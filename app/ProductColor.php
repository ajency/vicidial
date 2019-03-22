<?php

namespace App;

use Ajency\Connections\ElasticQuery;
use Ajency\Connections\OdooConnect;
use Ajency\FileUpload\FileUpload;
use App\EntityData;
use App\Jobs\IndexProduct;
use App\Jobs\UpdateElasticData;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SoapBox\Formatter\Formatter;

class ProductColor extends Model
{
    use FileUpload;

    public function getElasticData()
    {
        $q = new ElasticQuery();
        $q->setIndex(config("elastic.indexes.product"));
        return $q->get($this->elastic_id)['_source'];
    }

    public function variants(){
        return $this->hasMany('App\Variant');
    }

    public static function saveToElastic(string $id, array $data)
    {
        $q = new ElasticQuery();
        $q->setIndex(config("elastic.indexes.product"));
        $q->createIndexParams($id, $data);
        return $q->index();
    }

    public static function deconstructElasticData($elastic_data)
    {
        $products     = collect($elastic_data['search_data']);
        $variants     = collect();
        $product_data = collect(['product_metatag' => []]);
        $products->each(function ($productData) use ($variants, $product_data) {
            $variant_data = ['variant_product_own' => true, 'variant_barcode' => 0];

            $attTypes = ['string_facet', 'number_facet', 'boolean_facet', 'attributes'];

            foreach ($attTypes as $attType) {
                foreach ($productData[$attType] as $facetData) {
                    $key   = ($attType == 'attributes') ? 'attribute_name' : 'facet_name';
                    $value = ($attType == 'attributes') ? 'attribute_value' : 'facet_value';
                    if (isProductAttribute($facetData[$key])) {
                        if ($facetData[$key] == 'product_gender' && isset($product_data[$facetData[$key]]) && $product_data[$facetData[$key]] == 'Unisex') {
                            continue;
                        }

                        if ($facetData[$key] == 'product_metatag') {
                            $arr                            = $product_data[$facetData[$key]];
                            $arr[]                          = $facetData[$value];
                            $product_data[$facetData[$key]] = $arr;
                        } else {
                            $product_data[$facetData[$key]] = $facetData[$value];
                        }

                    } else {
                        $variant_data[$facetData[$key]] = $facetData[$value];
                    }
                }
            }
            $variants[$variant_data['variant_id']] = $variant_data;

        });
        $extraAtt = ['product_vendor', 'product_att_ecom_sales', 'product_image_available'];
        foreach ($extraAtt as $att) {
            $product_data[$att] = (isset($elastic_data['search_result_data'][$att])) ? $elastic_data['search_result_data'][$att] : false;
        }
        $product_data['product_metatag'] = array_unique($product_data['product_metatag']);
        return ['product' => $product_data, 'variant' => $variants];
    }

    public static function updateStaticData($unstructured)
    {
        //add static data to product
        $productStaticData = EntityData::getOdooProductAttributes($unstructured['product']['product_id']);
        foreach (config('product.static_fields.product') as $attribute => $defaultAttValue) {
            $unstructured['product'][$attribute] = (isset($productStaticData[$attribute])) ? $productStaticData[$attribute] : $defaultAttValue;
        }

        //add static data to variant
        foreach ($unstructured['variant'] as $variant_id => $variantData) {
            $variantStaticData = EntityData::getOdooVariantAttributes($variant_id);
            foreach (config('product.static_fields.variant') as $attribute => $defaultAttValue) {
                $variantData[$attribute] = (isset($variantStaticData[$attribute])) ? $variantStaticData[$attribute] : $defaultAttValue;
            }
            $unstructured['variant'][$variant_id] = $variantData;
        }

        return $unstructured;
    }

    public static function updateElasticData($products)
    {
        $elasticProducts = collect();
        foreach ($products as $elastic_id => $productData) {
            $elastic_data = ($productData['elastic_data'] == null) ? (new ElasticQuery())->setIndex(config("elastic.indexes.product"))->get($elastic_id)['_source'] : $productData['elastic_data'];
            $change       = $productData['change'];

            $unstructured_data = self::deconstructElasticData($elastic_data);
            $unstructured_data = self::updateStaticData($unstructured_data);
            $productData       = $unstructured_data['product'];
            $variantsData      = $unstructured_data['variant'];
            $changed_data      = $change($productData, $variantsData);
            $structured_data   = buildProductIndexFromOdooData($productData, $variantsData);
            $elasticProducts->push($structured_data);
        }
        Product::bulkIndexProducts($elasticProducts);
    }

    public static function productXMLData()
    {
        $productColors = self::get();
        $xmlData       = array('title' => 'Online Shopping For Kids Wear And Fashion In India - Kidsuperstore.in', 'description' => 'Kidsuperstore.in: Online Shopping Site For Kids Wear And Fashion In India. Buy Shoes, Clothing, Dresses And Accessories For Boys, Girls, Toddlers, Juniors And Infants. Shipping | Cash On Delivery | 30 Days Return.', 'link' => url('/'));
        $excludeArray  = ["title", "description", "link"];
        foreach ($productColors as $productColor) {
            try {
                $productColorData = $productColor->getElasticData();
            } catch (\Exception $e) {
                continue;
            }

            if ($productColorData['search_result_data']['product_att_ecom_sales'] == false) {
                continue; // Skip if ecom sales is off
            }

            $images     = $productColor->getAllImages(["main"]);
            $main_image = (isset($images[0]['main']['1x'])) ? $images[0]['main']['1x'] : false;

            if ($productColorData['search_result_data']['product_image_available'] == false || $main_image == false) {
                continue; // Skip if image not available
            }

            $params = [
                'id'                => $productColorData['search_result_data']['product_id'] . "-" . $productColorData['search_result_data']['product_color_id'],
                'title'             => ucwords(strtolower($productColorData['search_result_data']['product_title'])),
                'color'             => $productColorData['search_result_data']['product_color_name'],
                'gender'            => ($productColorData['search_result_data']['product_gender'] == 'Boys') ? 'male' : (($productColorData['search_result_data']['product_gender'] == 'Girls') ? 'female' : 'unisex'),
                'identifier_exists' => 'no',
                'condition'         => 'new',
                'link'              => url('/') . "/" . $productColorData['search_result_data']['product_slug'] . "/buy",
                'image_link'        => $main_image,
                'product_type'      => $productColorData['search_result_data']['product_category_type'] . ' > ' . $productColorData['search_result_data']['product_subtype'],
            ];

            if ($productColorData['search_result_data']['product_age_group'] != 'Others' && $productColorData['search_result_data']['product_age_group'] != 'All') {
                $params['age_group'] = ($productColorData['search_result_data']['product_age_group'] == 'Infant') ? 'infant' : (($productColorData['search_result_data']['product_age_group'] == 'Toddler') ? 'toddler' : 'kids');
            }

            if ($productColorData['search_result_data']['product_description'] != false) {
                $params['description'] = ucwords(strtolower($productColorData['search_result_data']['product_description']));
            } else {
                $params['description'] = ucwords(strtolower($productColorData['search_result_data']['product_title']));
            }

            if (strlen($params['description']) < 145) {
                $params['description'] .= ' - Kidsuperstore.in Brings You The Latest Clothing And Accessories For Kids. We Ensure That All Of Our Products Are Genuine And Of The Highest Quality.';
            }

            if ($productColorData['search_result_data']['product_att_material'] != false) {
                $params['material'] = $productColorData['search_result_data']['product_att_material'];
            }

            if ($productColorData['search_result_data']['product_category_type'] == 'Apparels' || $productColorData['search_result_data']['product_category_type'] == 'Accessories') {
                $params['google_product_category'] = 166;
            } else if ($productColorData['search_result_data']['product_category_type'] == 'Shoes') {
                $params['google_product_category'] = 187;
            } else if ($productColorData['search_result_data']['product_category_type'] == 'Toys') {
                $params['google_product_category'] = 1239;
            }

            $params['sale_price']   = $productColorData["variants"][0]["variant_sale_price"];
            $params['price']        = $productColorData["variants"][0]["variant_list_price"];
            $params['availability'] = "out of stock";
            $params['size']         = "";
            $sizes                  = array();

            foreach ($productColorData["variants"] as $key => $variant) {
                if ($params['sale_price'] > $variant["variant_sale_price"]) {
                    $params['sale_price'] = $variant["variant_sale_price"];
                    $params['price']      = $variant["variant_list_price"];
                }
                if ($params['availability'] == "in stock" || $variant['variant_availability'] == true) {
                    $params['availability'] = "in stock";
                }
                array_push($sizes, $variant["variant_size_name"]);
            }

            $params['size'] = implode('/', $sizes);

            array_push($xmlData, $params);
        }

        $formatter = Formatter::make($xmlData, Formatter::ARR);
        $xml       = $formatter->toXml('rss version="2.0" xmlns:g="http://base.google.com/ns/1.0"', 'http://base.google.com/ns/1.0', $excludeArray);

        Storage::disk('s3')->put(config('ajfileupload.doc_base_root_path') . '/products.xml', $xml);
    }

    public static function getProductsFromOdooDiscounts()
    {
        $variant_ids  = array();
        $offset       = 0;
        $odoo         = new OdooConnect;
        $current_date = Carbon::now()->toDateTimeString();
        do {
            $discounts = $odoo->defaultExec("product.template", 'search_read', [[['type', '=', 'discount'], ['discount_rule', '=', 'catalog'], ['write_date', '>', Defaults::getLastCatalogDiscountSync()], ['from_date', '<', $current_date], ['to_date', '>', $current_date]]], ['fields' => config('odoo.model_fields.discounts'), 'order' => 'id', 'offset' => $offset]);

            foreach ($discounts as $discount) {
                $offset_p = 0;
                do {
                    $products = $odoo->defaultExec('prod_discount', 'read', [$discount['condition_id']], ['fields' => config('odoo.model_fields.discount_products')]);

                    foreach ($products as $product_ids) {
                        $variant_ids = array_merge($variant_ids, $product_ids['product_ids']);
                    }

                    $offset_p = $offset_p + $products->count();
                } while ($products->count() == config('odoo.limit'));
            }

            $offset = $offset + $discounts->count();
        } while ($discounts->count() == config('odoo.limit'));

        Defaults::setLastCatalogDiscountSync();

        $productIds = DB::select(DB::raw('SELECT DISTINCT product_id FROM product_colors where product_colors.id in (SELECT product_color_id from variants where variants.odoo_id in (' . implode(',', $variant_ids) . '))'));

        foreach ($productIds as $productId) {
            IndexProduct::dispatch($productId->product_id)->onQueue('process_product');
        }
    }

    public static function updateAllProducts()
    {
        $ids    = ProductColor::select('product_id')->pluck('product_id')->unique();
        $chunks = $ids->chunk(30);

        foreach ($chunks as $chunk) {
            UpdateElasticData::dispatch($chunk)->onQueue('process_product');
        }
    }

    public static function generatePresetImages(){
        $productColors = ProductColor::join('fileupload_mapping', function ($join) {
            $join->on('product_colors.id', '=', 'fileupload_mapping.object_id');
            $join->where('fileupload_mapping.object_type', '=', "App\ProductColor");
        })->whereNull('fileupload_mapping.deleted_at')->select('product_colors.id','product_colors.elastic_id','fileupload_mapping.file_id')->get();
        $product_colors_arr = [];
        $config        = config('ajfileupload');
        foreach($productColors as $productColor){
            $all_photos = $productColor->photos()->get();

            if(!in_array($productColor->id, $product_colors_arr)){
                foreach($all_photos as $single_photo){
                    $map_image_size = json_decode($single_photo->file->image_size,true);
                    $filedata = explode("/", $single_photo->file->url);
                    $filename = $filedata[(count($filedata)-1)];
                    foreach($config["presets"] as $preset => $deptharr){
                        if($preset != "original"){
                            foreach($deptharr as $depth => $dim){
                                $image_size = ($preset == "original")?$preset:($preset."$$".$depth);
                                if(in_array($image_size,$map_image_size) == false){
                                    $imageurl = $productColor->resizeImages($single_photo->file->id,$preset, $depth, $filename);
                                }
                            }    
                        }
                        
                    }
                }
                array_push($product_colors_arr,$productColor->id);
            }
        }
    }

}
