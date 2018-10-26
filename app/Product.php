<?php
namespace App;

use App\Elastic\ElasticQuery;
use App\Elastic\OdooConnect;
use App\Facet;
use App\Jobs\CreateProductJobs;
use App\Jobs\FetchProductImages;
use App\ProductColor;
use App\Variant;

class Product
{
    protected $data;

    public static function getLastSyncedProduct()
    {
        // $query      = new ElasticQuery;
        // $lastSynced = intval($query->appendMust(ElasticQuery::createMatch('type', 'product'))
        //         ->setAggregation(ElasticQuery::createAggMax('max_id', 'id'))
        //         ->search()['aggregations']['max_id']['value']);
        // return $lastSynced;
        return 0;
    }

    public static function odooFilter($filters)
    {
        if (isset($filters['id'])) {
            return [[['id', '>', $filters['id']]]];
        } elseif (isset($filters['created'])) {
            return [[['create_date', '>', $filters['created']]]];
        } elseif (isset($filters['updated'])) {
            return [[['__last_update', '>', $filters['updated']]]];
        } elseif (isset($filters['write'])) {
            return [[['write_date', '>', $filters['write']]]];
        }
    }

    public static function getProductIDs($filters, $offset, $limit = false)
    {
        $odooFilter = self::odooFilter($filters);
        $odoo       = new OdooConnect;
        $attributes = ['order' => 'id', 'offset' => $offset];
        if ($limit) {
            $attributes['limit'] = $limit;
        }

        $products = $odoo->defaultExec('product.template', 'search', $odooFilter, $attributes);
        return $products;
    }

    public static function startSync()
    {
        $first_id = self::getLastSyncedProduct();
        $offset   = 0;
        do {
            $products = self::getProductIDs(['id' => $first_id], $offset);
            CreateProductJobs::dispatch($products)->onQueue('create_jobs');
            $offset = $offset + $products->count();
        } while ($products->count() == config('odoo.limit'));
    }

    public static function indexProduct($product_id)
    {
        $odoo        = new OdooConnect;
        $productData = $odoo->defaultExec('product.template', 'read', [[$product_id]], ['fields' => config('product.template_fields')])->first();
        $products    = self::indexVariants($productData['product_variant_ids'], sanitiseProductData($productData));
        self::bulkIndexProducts($products);
    }

    public static function indexVariants($variant_ids, $productData)
    {
        $products         = collect();
        $odoo             = new OdooConnect;
        $variants         = collect();
        $variantsData     = $odoo->defaultExec("product.product", 'read', [$variant_ids], ['fields' => config('product.variant_fields')]);
        $variantInventory = self::getVariantInventory($variant_ids);
        foreach ($variantsData as $variantData) {
            $attributeValues = $odoo->defaultExec('product.attribute.value', 'read', [$variantData['attribute_value_ids']], ['fields' => config('product.attribute_fields')]);
            $sanitisedData   = sanitiseVariantData($variantData, $attributeValues, $variantInventory[$variantData['id']]);
            self::storeVariantData($sanitisedData, $productData, $variantInventory[$variantData['id']]);
            $variants->push($sanitisedData);
        }
        $colorvariants = $variants->groupBy('product_color_id');
        foreach ($colorvariants as $colorVariantData) {
            $products->push(buildProductIndexFromOdooData($productData, $colorVariantData));

        }
        return $products;
    }

    public static function storeVariantData($variant, $product, $inventory)
    {

        try {
            $elastic             = new ProductColor;
            $elastic->elastic_id = $product['product_id'] . '.' . $variant['product_color_id'];
            $elastic->product_id = $product['product_id'];
            $elastic->color_id   = $variant['product_color_id'];
            $elastic->save();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage());
            $elastic = ProductColor::where('elastic_id', $product['product_id'] . '.' . $variant['product_color_id'])->first();
        }
        try {
            $object                   = new Variant;
            $object->odoo_id          = $variant['variant_id'];
            $object->inventory        = $inventory['inventory'];
            $object->product_color_id = $elastic->id;
            $object->save();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage());
        }
        $facets = ['product_category_type', 'product_gender', 'product_age_group', 'product_subtype'];
        foreach ($facets as $facet) {
            try {
                $facetObj               = new Facet;
                $facetObj->facet_name   = $facet;
                $facetObj->facet_value  = $product[$facet];
                $facetObj->display_name = $product[$facet];
                $facetObj->slug         = str_slug($product[$facet]);
                $facetObj->sequence     = 10000;
                $facetObj->save();
            } catch (\Exception $e) {
                \Log::warning($e->getMessage());
            }
        }

    }

    public static function bulkIndexProducts($products)
    {
        $query = new ElasticQuery;
        $query->setIndex(config('elastic.indexes.product'));
        $query->initializeBulkIndexing();
        $products->each(function ($item, $key) use ($query) {
            $query->addToBulkIndexing($item['id'], $item, ['op_type' => "create"]);
        });
        $responses = $query->bulk();
        $updated   = 0;
        foreach ($responses['items'] as $response) {
            switch ($response['create']['status']) {
                case 201:
                    $updated++;
                    \Log::info("Product {$response['create']['_id']} indexed");
                    break;

                default:
                    \Log::notice("Product {$response['create']['_id']} status {$response['create']['status']}");
                    break;
            }
        }
    }

    public static function fetchProductImages(int $product_id)
    {
        $odoo           = new OdooConnect;
        $product        = $odoo->defaultExec('product.template', 'read', [$product_id], ["fields" => ["images", "att_magento_display_name"]]);
        $magento_name   = $product[0]["att_magento_display_name"];
        $product_images = $odoo->defaultExec("product.image", "read", [$product[0]["images"]], [
            "fields" => ["image", "color_variant", "name"],
        ]);
        $images = collect();
        foreach ($product_images as $image) {
            $temp = [
                "image"        => $image["image"],
                "color_id"     => $image["color_variant"][0],
                "color_name"   => $image["color_variant"][1],
                "name"         => $image["name"],
                "magento_name" => $magento_name,
            ];
            $images->push($temp);
        }
        return $images;
    }

    public static function getVariantInventory(array $variant_ids)
    {
        $odoo          = new OdooConnect;
        $filters       = [["product_id", "in", $variant_ids]];
        $inventoryData = $odoo->multiExec('stock.quant', 'search_read', [$filters], ["fields" => config("product.inventory_fields"), "limit" => config("product.inventory_max")]);
        $inventory     = sanitiseInventoryData($inventoryData);
        return inventoryFormatData($variant_ids, $inventory);
    }

    public static function getAttributeValue($product, string $field)
    {
        $attributes = $product["search_data"][0]["attributes"];
        foreach ($attributes as $key => $attribute) {
            if ($attribute["attribute_name"] == $field) {
                return $attribute["attribute_value"];
            }

        }
    }

    public static function getAttributeSlug($product, string $field)
    {
        $attributes = $product["search_data"][0]["attributes"];
        foreach ($attributes as $key => $attribute) {
            if ($attribute["attribute_name"] == $field) {
                return $attribute["attribute_slug"];
            }

        }
    }

    public static function getStringFacetValue($product, string $field)
    {
        $facets = $product["search_data"][0]["string_facet"];
        foreach ($facets as $key => $facet) {
            if ($facet["facet_name"] == $field) {
                return $facet["facet_value"];
            }

        }
    }

    public static function getStringFacetSlug($product, string $field)
    {
        $facets = $product["search_data"][0]["string_facet"];
        foreach ($facets as $key => $facet) {
            if ($facet["facet_name"] == $field) {
                return $facet["facet_value"];
            }

        }
    }

    public static function getNumberFacetValue($product, string $field)
    {
        $facets = $product["search_data"][0]["number_facet"];
        foreach ($facets as $key => $facet) {
            if ($facet["facet_name"] == $field) {
                return $facet["facet_value"];
            }

        }
    }

    public static function getVariantSequence($product, $variant_id)
    {
        $data = $product["variants"];
        foreach ($data as $key => $value) {
            if ($value["variant_id"] == $variant_id) {
                return $key;
            }
        }
    }

    public static function getVariantAvailability($product, int $variant_id)
    {
        $order = self::getVariantSequence($product, $variant_id);
        $data  = $product["search_data"][$order]["boolean_facet"];
        foreach ($data as $key => $value) {
            if ($value["facet_name"] == "variant_availability") {
                return $value["facet_value"];
            }
        }
        return false;
    }

    public static function getNoImageProducts()
    {
        $products = ProductColor::leftJoin('fileupload_mapping', function ($join) {
            $join->on('product_colors.id', '=', 'fileupload_mapping.object_id');
            $join->where('fileupload_mapping.object_type', '=', "App\ProductColor");
        })->where('fileupload_mapping.id', null)->select('product_colors.product_id')->distinct()->get();
        foreach ($products as $product) {
            FetchProductImages::dispatch($product->product_id)->onQueue('process_product_images');
        }
    }

    public static function getImg(){
        $prod_images = '[{"image":false,"id":3,"color_variant":false,"name":false},{"image":false,"id":4,"color_variant":false,"name":false},{"image":false,"id":5,"color_variant":false,"name":"Short-1018"}]';
        $prod_images_arr   = json_decode($prod_images);
        foreach($prod_images_arr as $pIndex => $pval){
            echo "ind===".$pIndex."<br/>";
        }
    }

}
