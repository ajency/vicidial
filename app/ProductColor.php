<?php

namespace App;

use Ajency\FileUpload\FileUpload;
use Ajency\Connections\ElasticQuery;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\FetchProductImages;
use SoapBox\Formatter\Formatter;
use Illuminate\Support\Facades\Storage;
use Ajency\Connections\OdooConnect;
use Illuminate\Support\Facades\DB;
use App\Jobs\IndexProduct;
use Carbon\Carbon;

class ProductColor extends Model
{
    use FileUpload;

    public function getElasticData()
    {
        $q = new ElasticQuery();
        $q->setIndex(config("elastic.indexes.product"));
        return $q->get($this->elastic_id)['_source'];
    }

    public static function saveToElastic(string $id, array $data)
    {
        $q = new ElasticQuery();
        $q->setIndex(config("elastic.indexes.product"));
        $q->createIndexParams($id, $data);
        return $q->index();
    }

    private static function updateElasticResultData($elastic_data, $change, $is_variant, $variant_id)
    {
        if ($is_variant) {
            foreach ($elastic_data["variants"] as &$variant) {
                if ($variant["variant_id"] == $variant_id) {
                    foreach ($change as $key => $value) {
                        $variant[$key] = $value;
                    }
                    break;
                }
            }
        } else {
            foreach ($change as $key => $value) {
                $elastic_data['search_result_data'][$key] = $value;
            }
        }
        return $elastic_data;
    }

    public static function updateElasticSearchData($elastic_data, $change, $is_variant, $variant_id)
    {
        foreach ($elastic_data['search_data'] as &$variant) {
            $flag = false;
            if ($is_variant) {
                foreach ($variant["number_facet"] as $facet) {
                    if ($facet["facet_name"] == "variant_id" and $facet["facet_value"] == $variant_id) {
                        $flag = true;
                        break;
                    }
                }
            } else {
                $flag = true;
            }
            if ($flag) {
                foreach ($change as $facet_type => $attributes) {
                    foreach ($variant[$facet_type] as $facet_key => $facet) {
                        if (isset($attributes[$facet["facet_name"]])) {
                            $variant[$facet_type][$facet_key]["facet_value"] = $attributes[$facet["facet_name"]];
                        }
                    }
                }
            }
        }
        return $elastic_data;
    }

    public static function updateElasticData(array $elastic_data, array $change, $is_variant = true, $variant_id = null)
    {
        if (isset($change['result'])) {
            $elastic_data = self::updateElasticResultData($elastic_data, $change['result'], $is_variant, $variant_id);
        }
        if (isset($change['search'])) {
            $elastic_data = self::updateElasticSearchData($elastic_data, $change['search'], $is_variant, $variant_id);
        }
        \Log::debug($elastic_data);
        $result = self::saveToElastic($elastic_data['id'], $elastic_data);
        return $result;
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

            $images     = $productColor->getAllImages(["main"]);
            $main_image = (isset($images[0]['main']['1x'])) ? $images[0]['main']['1x'] : false;

            $params = [
                'id'                => $productColorData['search_result_data']['product_id'] . "-" . $productColorData['search_result_data']['product_color_id'],
                'title'             => ucwords(strtolower($productColorData['search_result_data']['product_title'])),
                'color'             => $productColorData['search_result_data']['product_color_name'],
                'gender'            => ($productColorData['search_result_data']['product_gender'] == 'Boys') ? 'male' : (($productColorData['search_result_data']['product_gender'] == 'Girls') ? 'female' : 'unisex'),
                'identifier_exists' => 'no',
                'condition'         => 'new',
                'link'              => url('/') . "/" . $productColorData['search_result_data']['product_slug'] . "/buy",
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

            if ($productColorData['search_result_data']['product_image_available'] != false && $main_image != false) {
                $params['image_link'] = $main_image;
            } else {
                continue; // Skip if image not available
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
            $discounts = $odoo->defaultExec("product.template", 'search_read', [[['type', '=', 'discount'], ['discount_rule', '=', 'catalog'], ['from_date', '<', $current_date], ['to_date', '>', $current_date]]], ['fields' => config('odoo.model_fields.discounts'), 'order' => 'id', 'offset' => $offset]);

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

        $productIds = DB::select(DB::raw('SELECT DISTINCT product_id FROM product_colors where product_colors.id in (SELECT product_color_id from variants where variants.odoo_id in (' . implode(',', $variant_ids) . '))'));

        foreach ($productIds as $productId) {
            IndexProduct::dispatch($productId->product_id)->onQueue('process_product');
        }
    }
}
