<?php
namespace App;

use Ajency\Connections\ElasticQuery;
use Ajency\Connections\OdooConnect;
use App\Defaults;
use App\Facet;
use App\Jobs\CreateProductJobs;
use App\Jobs\CreateRefreshCacheJobs;
use App\Jobs\CreateUpdateProductJobs;
use App\Jobs\FetchProductImages;
use App\Jobs\RefreshFacetCache;
use App\Jobs\RefreshProductCache;
use App\Jobs\UpdateSearchText;
use App\Jobs\UpdateVariantInventory;
use App\ProductColor;
use App\Variant;
use Illuminate\Support\Facades\DB;

class Product
{
    protected $data;

    public static function getProductIDs($filters, $offset, $limit = false)
    {
        $odooFilter = OdooConnect::odooFilter($filters);
        $odoo       = new OdooConnect;
        $attributes = ['order' => 'id', 'offset' => $offset];
        if ($limit) {
            $attributes['limit'] = $limit;
        }

        $products = $odoo->defaultExec('product.template', 'search', $odooFilter, $attributes);
        return $products;
    }

    public static function updateSync()
    {
        $offset = 0;
        do {
            $products = self::getProductIDs(['write' => Defaults::getLastProductSync()], $offset);
            CreateProductJobs::dispatch($products)->onQueue('create_jobs');
            $offset = $offset + $products->count();
        } while ($products->count() == config('odoo.limit'));
        Defaults::setLastProductSync();
    }

    public static function updateVariantSync()
    {
        $variant_ids = collect();

        $limit = 100000;

        $odoo              = new OdooConnect;
        $last_variant_date = $odoo->defaultExec('product.product', 'search_read', [[['id', '>', '0']]], ['order' => 'write_date DESC', 'limit' => 1, 'fields' => ['write_date']])->first()['write_date'];

        //Active Variants
        $offset = 0;
        do {
            $variants    = self::getProductIDsFromVariants(['write' => Defaults::getLastVariantSync()], $offset, $limit);
            $variant_ids = $variant_ids->merge($variants);
            $offset      = $offset + $variants->count();
        } while ($variants->count() == $limit);

        //InActive Variants
        /*$offset      = 0;
        do {
        $variants    = self::getProductIDsFromVariants(['write' => Defaults::getLastVariantSync(), 'term' => [['active', false]]], $offset);
        $variant_ids = $variant_ids->merge($variants);
        $offset      = $offset + $variants->count();
        } while ($variants->count() == config('odoo.limit'));*/

        if ($variant_ids->count() > 0) {
            $productIds = collect(DB::select(DB::raw('SELECT DISTINCT id FROM product_colors where product_colors.id in (SELECT product_color_id from variants where variants.odoo_id in (' . implode(',', $variant_ids->toArray()) . '))')));

            $chunks = $productIds->chunk(30);

            foreach ($chunks as $chunk) {
                CreateUpdateProductJobs::dispatch($chunk->toArray())->onQueue('create_jobs');
            }
        }
        Defaults::setLastVariantSync($last_variant_date);
    }

    public static function getProductIDsFromVariants($filters, $offset, $limit = false)
    {
        $odooFilter = OdooConnect::odooFilter($filters);
        $odoo       = new OdooConnect;
        $attributes = ['order' => 'id', 'offset' => $offset];
        if ($limit) {
            $attributes['limit'] = $limit;
        }

        $variants = $odoo->defaultExec('product.product', 'search', $odooFilter, $attributes);
        return $variants;
    }

    public static function startSync()
    {
        $first_id = ProductColor::max('product_id');
        $first_id = ($first_id == null) ? 0 : $first_id;
        $offset   = 0;
        do {
            $products = self::getProductIDs(['id' => $first_id], $offset);
            CreateProductJobs::dispatch($products)->onQueue('create_jobs');
            $offset = $offset + $products->count();
        } while ($products->count() == config('odoo.limit'));
    }

    public static function startInactiveSync()
    {
        $odooFilter      = OdooConnect::odooFilter(['write' => Defaults::getLastInactiveProductSync()]);
        $odooFilter[0][] = ['active', '=', false];
        $offset          = 0;
        $attributes      = ['order' => 'id', 'offset' => $offset];
        $odoo            = new OdooConnect;
        do {
            $productIds = $odoo->defaultExec('product.template', 'search', $odooFilter, $attributes);
            CreateProductJobs::dispatch($productIds)->onQueue('create_jobs');
            $offset = $offset + $productIds->count();
        } while ($productIds->count() == config('odoo.limit'));
        $variantsData = $odoo->defaultExec("product.product", 'search_read', $odooFilter, ['fields' => ["product_tmpl_id"], 'limit' => 100]);
        $productIDs   = collect();
        $variantsData->each(function ($item, $key) use ($productIDs) {
            $productIDs->push($item["product_tmpl_id"][0]);
        });
        CreateProductJobs::dispatch($productIDs->unique())->onQueue('create_jobs');
        Defaults::setLastInactiveProductSync();
    }

    public static function indexProduct($product_id)
    {
        $odoo        = new OdooConnect;
        $productData = $odoo->defaultExec('product.template', 'read', [[$product_id]], ['fields' => config('product.template_fields')])->first();
        $products    = self::indexVariants($productData['product_variant_ids'], sanitiseProductData($productData));
        self::bulkIndexProducts($products);
        //create photo job for $product_id
        FetchProductImages::dispatch($product_id)->onQueue('process_product_images');
    }

    public static function indexVariants($variant_ids, $productData)
    {
        $products         = collect();
        $odoo             = new OdooConnect;
        $variants         = collect();
        $updateVariants   = [];
        $inactiveVariants = $odoo->defaultExec("product.product", 'search', [[['product_tmpl_id', '=', $productData['product_id']], ['active', '=', false]]], [])->toArray();
        $variantsData     = $odoo->defaultExec("product.product", 'read', [array_merge($variant_ids, $inactiveVariants)], ['fields' => config('product.variant_fields')]);
        foreach ($variantsData as $variantData) {
            $attributeValues = $odoo->defaultExec('product.attribute.value', 'read', [$variantData['attribute_value_ids']], ['fields' => config('product.attribute_fields')]);
            $sanitisedData   = sanitiseVariantData($variantData, $attributeValues);

            $updateVariants[] = self::storeVariantData($sanitisedData, $productData);

            $sanitisedData['variant_availability'] = Variant::select('inventory')->where('odoo_id', $sanitisedData['variant_id'])->first()->getAvailability();
            $variants->push($sanitisedData);
        }
        $colorvariants = $variants->groupBy('product_color_id');
        foreach ($colorvariants as $colorVariantData) {
            $products->push(buildProductIndexFromOdooData($productData, $colorVariantData));

        }
        // create update job for active and inactive variants
        if (!empty($updateVariants)) {
            UpdateVariantInventory::dispatch($updateVariants)->onQueue('update_inventory');
        }

        return $products;
    }

    public static function storeVariantData($variant, $product)
    {
        $exists      = true;
        $new_facet   = false;
        $new_product = true;
        try {
            $elastic             = new ProductColor;
            $elastic->elastic_id = $product['product_id'] . '.' . $variant['product_color_id'];
            $elastic->product_id = $product['product_id'];
            $elastic->color_id   = $variant['product_color_id'];
            $elastic->save();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage());
            $elastic     = ProductColor::where('elastic_id', $product['product_id'] . '.' . $variant['product_color_id'])->first();
            $new_product = false;
        }
        try {
            if ($new_product) {
                \Ajency\ServiceComm\Comm\Async::call('NewProductColor', [
                    'external_product_id' => $product['product_id'],
                    'product_color_id'    => $elastic->id,
                    'product_barcode'     => $product['product_barcode'],
                    'product_name'        => ($productData['product_att_magento_display_name'] && $productData['product_att_magento_display_name'] != '') ? $productData['product_att_magento_display_name'] : $productData['product_name'],
                    'product_color'       => $variant['product_color_name'] . str_slug($variant['product_color_html']),
                ], 'sns', false);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        try {
            $object          = Variant::firstOrNew(['odoo_id' => $variant['variant_id']]);
            $object->odoo_id = $variant['variant_id'];
            if (is_null($object->id)) {
                // $object->inventory = [];
                $exists = false;
            }
            $object->product_color_id = $elastic->id;
            $object->active           = $variant['variant_active'];
            $object->deleted          = false;
            $object->save();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage());
            $object = Variant::select('id')->where('odoo_id', $variant['variant_id'])->first();
        }
        try {
            if (!$exists) {

                \Ajency\ServiceComm\Comm\Sync::call('inventory', 'addVariant', [
                    'id'               => $object->id,
                    'product_color_id' => $object->product_color_id,
                    'odoo_id'          => $object->odoo_id,
                ]);
            }

            if ($product['product_is_dropshipping']) {
                \Ajency\ServiceComm\Comm\Sync::call('inventory', 'addDropshippingVariant', [
                    'id'               => $object->id,
                    'product_color_id' => $object->product_color_id,
                    'odoo_id'          => $object->odoo_id,
                ]);
            }
        } catch (\Exception $e) {
            \Log::error($e->getMessage());
        }
        $facets = ['product_category_type', 'product_gender', 'product_age_group', 'product_subtype', 'product_brand'];
        foreach ($facets as $facet) {
            if ($product[$facet]) {
                try {
                    $facetObj               = new Facet;
                    $facetObj->facet_name   = $facet;
                    $facetObj->facet_value  = $product[$facet];
                    $facetObj->display_name = $product[$facet];
                    $facetObj->slug         = str_slug($product[$facet]);
                    $facetObj->sequence     = 10000;
                    $facetObj->display      = false;
                    $facetObj->save();
                    $new_facet = true;
                } catch (\Exception $e) {
                    \Log::warning($e->getMessage());
                }
            }
        }
        $facets = ['product_color_html', 'variant_size_name'];
        foreach ($facets as $facet) {
            try {
                $facetObj               = new Facet;
                $facetObj->facet_name   = $facet;
                $facetObj->facet_value  = $variant[$facet];
                $facetObj->display_name = ($facet == 'product_color_html') ? $variant['product_color_name'] : $variant[$facet];
                $facetObj->slug         = str_slug($variant[$facet]);
                $facetObj->sequence     = 10000;
                $facetObj->display      = false;
                $facetObj->save();
                $new_facet = true;
            } catch (\Exception $e) {
                \Log::warning($e->getMessage());
            }
        }

        foreach ($product['product_metatag'] as $metatag) {
            try {
                $facetObj               = new Facet;
                $facetObj->facet_name   = "product_metatag";
                $facetObj->facet_value  = $metatag;
                $facetObj->display_name = $metatag;
                $facetObj->slug         = str_slug($metatag);
                $facetObj->sequence     = 10000;
                $facetObj->display      = false;
                $facetObj->save();
                $new_facet = true;
            } catch (\Exception $e) {
                \Log::warning($e->getMessage());
            }
        }

        if ($new_facet) {
            RefreshFacetCache::dispatch()->onQueue('create_cache_jobs');
        }

        return $object->id;

    }

    public static function bulkIndexProducts($products)
    {
        $query = new ElasticQuery;
        $query->setIndex(config('elastic.indexes.product'));
        $query->initializeBulkIndexing();
        $products->each(function ($item, $key) use ($query) {
            $query->addToBulkIndexing($item['id'], $item);
            RefreshProductCache::dispatch($item['search_result_data']['product_slug'])->onQueue('refresh_cache');
        });
        $responses = $query->bulk();
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
        $inventoryData = $odoo->multiExec('stock.quant', 'search_read', [$filters], ["fields" => config("product.inventory_fields")]);
        $inventory     = sanitiseInventoryData($inventoryData);
        return inventoryFormatData($variant_ids, $inventory);
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
        })->where('fileupload_mapping.id', null)->select('product_colors.product_id')->where('product_colors.no_image', '!=', true)->distinct()->get();
        foreach ($products as $product) {
            FetchProductImages::dispatch($product->product_id)->onQueue('process_product_images');
        }
    }

    public static function updateImageFacets($product_id)
    {
        $products = ProductColor::where('product_id', $product_id)->get();
        foreach ($products as $product) {
            $images = $product->getAllImages(array_keys(config('ajfileupload.presets')));
            if (count($images) > 0) {
                $changeData = [
                    $product->elastic_id => [
                        'elastic_data' => $product->getElasticData(),
                        'change'       => function (&$product, &$variants) {
                            $product['product_image_available'] = true;
                        },
                    ],
                ];
                ProductColor::updateElasticData($changeData);
            }
        }
    }

    public static function updateAllSearchtext($indexname)
    {
        $products = ProductColor::select('elastic_id')->get()->pluck('elastic_id')->toArray();
        $job_sets = array_chunk($products, config('odoo.update_products'));
        foreach ($job_sets as $job_set) {
            UpdateSearchText::dispatch(['productIDs' => $job_set, 'indexName' => $indexname])->onQueue('search_text');
        }
    }

    public static function elasticSearchtext($elasticData)
    {
        $searchResult       = $elasticData['search_result_data'];
        $productId          = $searchResult['product_id'];
        $productdisplayName = $searchResult['product_att_magento_display_name'];
        foreach ($elasticData['search_data'] as &$variant) {
            $variant['full_text']         = implode(' ', [$variant['full_text'], $productId, $productdisplayName]);
            $variant['full_text_boosted'] = implode(' ', [$variant['full_text_boosted'], $productId, $productdisplayName]);
        }
        return $elasticData;
    }

    public static function getProductDataFromIds($ids)
    {
        $q = new ElasticQuery();
        $q->setIndex(config("elastic.indexes.product"));

        $products = $q->mget($ids, ['search_result_data', 'variants']);

        return fetchLandingProductDetails($products['docs']);
    }

    public static function getBrandsForProducts()
    {
        $odoo   = new OdooConnect;
        $offset = 0;
        do {
            $allBrands     = $odoo->defaultExec('product.template', 'search_read', [[['brand_id', '!=', false]]], ['fields' => ['brand_id'], 'limit' => config('odoo.limit'), 'order' => 'id', 'offset' => $offset]);
            $products      = $allBrands->pluck('id');
            $productColors = ProductColor::select(['product_id', 'elastic_id'])->whereIn('product_id', $products)->pluck('product_id', 'elastic_id');
            $productBrands = $productColors->map(function ($productID) use ($allBrands) {
                $brand = $allBrands->where('id', $productID)->first()['brand_id'][1];
                try {
                    $facetObj               = new Facet;
                    $facetObj->facet_name   = 'product_brand';
                    $facetObj->facet_value  = $brand;
                    $facetObj->display_name = $brand;
                    $facetObj->slug         = str_slug($brand);
                    $facetObj->sequence     = 10000;
                    $facetObj->display      = false;
                    $facetObj->save();
                } catch (\Exception $e) {
                    \Log::warning($e->getMessage());
                }
                return [
                    'elastic_data' => null,
                    'change'       => function (&$product, &$variants) use ($brand) {
                        $product['product_brand'] = $brand;
                    },
                ];
            });
            if ($productBrands->count() != 0) {
                ProductColor::updateElasticData($productBrands);
            }
            $offset = $offset + $allBrands->count();
        } while ($allBrands->count() == config('odoo.limit'));
        return;
    }

    public static function getVendorIds($products)
    {
        $odoo           = new OdooConnect;
        $allVendors     = $odoo->defaultExec('product.template', 'read', [$products], ['fields' => ['vendor_id', 'product_variant_ids', 'product_template_description_id', 'fabric_description_id']]);
        $allBarcodes    = $odoo->defaultExec('product.product', 'read', [$allVendors->pluck('product_variant_ids')->flatten()->toArray()], ['fields' => ['barcode', 'standard_price']]);
        $products       = $allVendors->pluck('id');
        $productColors  = ProductColor::select(['product_id', 'elastic_id'])->whereIn('product_id', $products)->pluck('product_id', 'elastic_id');
        $productVendors = $productColors->map(function ($productID) use ($allVendors, $allBarcodes) {
            $odooData    = $allVendors->where('id', $productID)->first();
            $barcodeData = $allBarcodes->whereIn('id', $odooData['product_variant_ids']);
            return [
                'elastic_data' => null,
                'change'       => function (&$product, &$variants) use ($odooData, $barcodeData) {
                    $product['product_vendor_id']               = $odooData['vendor_id'][0];
                    $product['product_vendor']                  = $odooData['vendor_id'][1];
                    $product["product_vendor_id"]               = ($odooData["vendor_id"]) ? $odooData["vendor_id"][0] : null;
                    $product["product_vendor"]                  = ($odooData["vendor_id"]) ? $odooData["vendor_id"][1] : null;
                    $product["product_template_description_id"] = ($odooData["product_template_description_id"]) ? $odooData["product_template_description_id"][0] : null;
                    $product["product_template_description"]    = ($odooData["product_template_description_id"]) ? $odooData["product_template_description_id"][1] : null;
                    $product["product_fabric_description_id"]   = ($odooData["fabric_description_id"]) ? $odooData["fabric_description_id"][0] : null;
                    $product["product_fabric_description"]      = ($odooData["fabric_description_id"]) ? $odooData["fabric_description_id"][1] : null;
                    foreach ($barcodeData as $variantData) {
                        $variant                           = $variants[$variantData['id']];
                        $variant['variant_barcode']        = $variantData['barcode'];
                        $variant['variant_standard_price'] = floatval($variantData['standard_price']);
                        $variants[$variantData['id']]      = $variant;
                    }
                },
            ];
        });
        ProductColor::updateElasticData($productVendors);
    }

    public static function updateProduct($product_id)
    {
        $productColor = ProductColor::find($product_id);

        $var = $productColor->variants()->select('odoo_id')->get()->pluck('odoo_id')->toArray();

        $odoo         = new OdooConnect;
        $variantsData = $odoo->defaultExec("product.product", 'read', [$var], ['fields' => ['lst_price', 'sale_price']])->keyBy('id');

        if (in_array(config('orders.shipping.variant.id'), $var)) {
            Defaults::setUniformShippingPrice($variantsData[config('orders.shipping.variant.id')]['sale_price']);
        }

        ProductColor::updateElasticData([$productColor->elastic_id => [
            'elastic_data' => null,
            'change'       => function (&$product, &$variants) use ($variantsData) {
                foreach ($variants as $variant_id => $variant) {
                    if (isset($variantsData[$variant_id])) {
                        $variant['variant_lst_price']        = $variantsData[$variant_id]['lst_price'];
                        $variant['variant_sale_price']       = $variantsData[$variant_id]['sale_price'];
                        $variant['variant_discount']         = $variant['variant_lst_price'] - $variant['variant_sale_price'];
                        $variant['variant_discount_percent'] = ($variant['variant_lst_price'] > 0) ? $variant['variant_discount'] / $variant['variant_lst_price'] * 100 : 0;
                    }
                    $variants[$variant_id] = $variant;
                }
            },
        ]]);

        return;
    }

    public static function refreshAllCache()
    {
        RefreshFacetCache::dispatch()->onQueue('create_cache_jobs');

        $index = config('elastic.indexes.product');
        $q     = new ElasticQuery;
        $q->setIndex($index)
            ->setQuery(
                ["match_all" => [
                    "boost" => 1.0,
                ]]
            )
            ->setSource(["search_result_data.product_slug"])
            ->setSize(10000);

        $response = $q->search();
        $chunks   = collect($response["hits"]["hits"])->chunk(30);

        foreach ($chunks as $chunk) {
            CreateRefreshCacheJobs::dispatch($chunk->toArray())->onQueue('create_cache_jobs');
        }
    }
}
