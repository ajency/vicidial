<?php
namespace App;

use App\Defaults;
use Ajency\Connections\ElasticQuery;
use Ajency\Connections\OdooConnect;
use App\Facet;
use App\Jobs\CreateProductJobs;
use App\Jobs\FetchProductImages;
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
        $inactiveVariants = $odoo->defaultExec("product.product", 'search', [[['product_tmpl_id', '=', $productData['product_id']], ['active', '=', false]]], [])->toArray();
        $variantsData     = $odoo->defaultExec("product.product", 'read', [array_merge($variant_ids, $inactiveVariants)], ['fields' => config('product.variant_fields')]);
        foreach ($variantsData as $variantData) {
            $attributeValues = $odoo->defaultExec('product.attribute.value', 'read', [$variantData['attribute_value_ids']], ['fields' => config('product.attribute_fields')]);
            $sanitisedData   = sanitiseVariantData($variantData, $attributeValues);
            self::storeVariantData($sanitisedData, $productData);
            $variants->push($sanitisedData);
        }
        $colorvariants = $variants->groupBy('product_color_id');
        foreach ($colorvariants as $colorVariantData) {
            $products->push(buildProductIndexFromOdooData($productData, $colorVariantData));

        }
        //create update job for active and inactive variants
        UpdateVariantInventory::dispatch(array_merge($variant_ids, $inactiveVariants))->onQueue('update_inventory');
        return $products;
    }

    public static function storeVariantData($variant, $product)
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
            $object                   = Variant::firstOrNew(['odoo_id' => $variant['variant_id']]);
            $object->odoo_id          = $variant['variant_id'];
            $object->inventory        = [];
            $object->product_color_id = $elastic->id;
            $object->active           = $variant['variant_active'];
            $object->deleted          = false;
            $object->save();
        } catch (\Exception $e) {
            \Log::warning($e->getMessage());
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
            $query->addToBulkIndexing($item['id'], $item);
        });
        $responses = $query->bulk();
        foreach ($responses['items'] as $response) {
            switch ($response['index']['result']) {
                case 'created':
                    \Log::info("Product {$response['index']['_id']} created");
                    break;
                case 'updated':
                    \Log::info("Product {$response['index']['_id']} updated");
                    break;
                default:
                    \Log::notice("Product {$response['index']['_id']} status {$response}");
                    throw new \Exception($response, 1);
                    
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

    /**
     * Function to generate Elastic Query for Aggregations required on LHS of ListView page
     *
     * @return ElasticQuery
     */
    public static function buildBaseQuery($variant_availability = "skip")
    {

        $q = new ElasticQuery;

        $max_count = Facet::groupBy('facet_name')->select('facet_name', DB::raw('count(*) as total'))->pluck('total')->max();

        $required          = ["product_category_type", "product_gender", "product_subtype", "product_age_group", "product_color_html", "product_metatag"];
        $aggs_facet_name   = $q::createAggTerms("facet_name", "search_data.string_facet.facet_name", ["include" => $required]);
        $aggs_facet_value  = $q::createAggTerms("facet_value", "search_data.string_facet.facet_value", ["size" => $max_count]);
        $aggs_facet_value  = $q::addToAggregation($aggs_facet_value, $q::createAggReverseNested('count'));
        $aggs_facet_name   = $q::addToAggregation($aggs_facet_name, $aggs_facet_value);
        $aggs_string_facet = $q::createAggNested("agg_string_facet", "search_data.string_facet");
        $aggs_string_facet = $q::addToAggregation($aggs_string_facet, $aggs_facet_name);

        $aggFacetNameP = $q::createAggTerms("facet_name", "search_data.number_facet.facet_name", ["include" => ['variant_sale_price']]);
        $aggMax        = $q::createAggMax('facet_value_max', 'search_data.number_facet.facet_value');
        $aggMin        = $q::createAggMin('facet_value_min', 'search_data.number_facet.facet_value');
        $minMax        = $q::addToAggregation($aggFacetNameP, array_merge($aggMax, $aggMin));
        $aggsPrice     = $q::createAggNested("agg_price", "search_data.number_facet");
        $priceQ        = $q::addToAggregation($aggsPrice, $minMax);

        $required    = ["variant_size_name"];
        $facet_names = [];

        foreach ($required as $facet_name) {
            $reverse          = $q::createAggReverseNested('count');
            $size             = $q::createAggTerms($facet_name, "variants." . $facet_name, ["size" => $max_count]);
            $aggs_facet_value = $q::addToAggregation($size, $reverse);
            $facet_names      = $facet_names + $aggs_facet_value;
        }

        if ($variant_availability === "skip") {
            $filterAgg = $q::createAggFilter("available", ["match_all" => new \stdClass()]);
        } else {
            $filterAgg = $q::createAggFilter("available", ["term" => ["variants.variant_availability" => $variant_availability]]);
        }

        // $filterAgg  = $q::createAggFilter("available", ['bool' =>['must_not' =>[["term" => [ "variants.variant_availability"=> true ]]]]]);
        $facet_name = $q::addToAggregation($filterAgg, $facet_names);
        $nestedAgg  = $q::createAggNested("variant_aggregation", "variants");
        $aggs       = $q::addToAggregation($nestedAgg, $facet_name);

        $q->setIndex(config('elastic.indexes.product'))
            ->initAggregation()->setAggregation(array_merge($priceQ, $aggs_string_facet, $aggs))
            ->setSize(0);

        return $q;
    }

    /**
     * Function to return the Data for LHS of Product List View
     *
     * @return array
     */
    public static function getProductCategoriesWithFilter($params)
    {
        $params['search_object'] = setDefaultFilters($params);
        $available               = "skip";
        if (isset($params['search_object']['boolean_filter']['variant_availability'])) {
            $available = $params['search_object']['boolean_filter']['variant_availability'];
        }

        $q    = self::buildBaseQuery($available);
        $must = setElasticFacetFilters($q, $params);
        $q->setQuery($must);
        // dd($q->getJSON());
        $response = $q->search();
        return sanitiseFilterdata($response, $params);
    }

    public static function getProductCategories()
    {
        $q = self::buildBaseQuery();
        return sanitiseFilterdata($q->search());
    }

    /**
     * Function to return the Data for RHS of Product List View
     *
     * @return array
     */
    public static function getItemsWithFilters($params)
    {
        $params['search_object'] = setDefaultFilters($params);
        $size                    = $params["display_limit"];
        $offset                  = ($params["page"] - 1) * $size;
        $index                   = config('elastic.indexes.product');
        $q                       = new ElasticQuery;
        $q->setIndex($index);
        $must = setElasticFacetFilters($q, $params);
        $q->setQuery($must)
            ->setSource(["search_result_data", "variants"])
            ->setSize($size)->setFrom($offset);
        if (isset($params['sort_on']) and $params['sort_on'] != "") {
            $sort = config('product.sort.' . $params['sort_on']);
            $q->setSort([$sort['field'] => ['order' => $sort['order']]]);
        }
        return formatItems($q->search(), $params);
    }

    public static function productListPage($params, $slug_value_search_result, $slug_search_result, $slugs_result, $title = "")
    {
        $output                         = [];
        $filter_params                  = [];
        $filter_params["search_object"] = [];
        $facet_display_data             = config('product.facet_display_data');
        // dd($facet_display_data);
        // dd($params);
        if (count($params["search_object"]["boolean_filter"]) == 0) {
            unset($params["search_object"]["boolean_filter"]);
        }

        foreach ($params["search_object"]["primary_filter"] as $paramk => $paramv) {
            if ($facet_display_data[$paramk]["is_essential"] == false) {
                $fields = $paramv;
                array_push($fields, "all");
                $filter_params["search_object"]["primary_filter"][$paramk] = $fields;
            } else {
                $filter_params["search_object"]["primary_filter"][$paramk] = $paramv;
            }

        }
        if (isset($params["search_object"]["range_filter"])) {
            $filter_params["search_object"]["range_filter"] = $params["search_object"]["range_filter"];
        }

        if (isset($params["search_object"]["boolean_filter"])) {
            $filter_params["search_object"]["boolean_filter"] = $params["search_object"]["boolean_filter"];
        }
        if (isset($params["search_object"]["search_string"])) {
            $filter_params["search_object"]["search_string"] = $params["search_object"]["search_string"];
        }

        $filter_params["display_limit"] = $params["display_limit"];
        $filter_params["page"]          = $params["page"];
        if (isset($params["sort_on"])) {
            $filter_params["sort_on"] = $params["sort_on"];
        }

        // dd($filter_params,$params);

        // $params = $filter_params =  ['search_object' =>['primary_filter' => [ 'product_gender' => ['Boys','all']]], 'display_limit' => 20, 'page' => 1] ;
        // $params = $filter_params ;
        if ((!isset($params["exclude_in_response"])) || (isset($params["exclude_in_response"]) && !in_array("filters", $params["exclude_in_response"]))) {
            $output["filters"] = self::getProductCategoriesWithFilter($filter_params);
        }

        // dd($output["filters"]);
        if ((!isset($params["exclude_in_response"])) || (isset($params["exclude_in_response"]) && !in_array("items", $params["exclude_in_response"]))) {
            $results = self::getItemsWithFilters($params);
        }

        $facet_names         = array_keys($facet_display_data);
        $bread               = [];
        $bread['breadcrumb'] = array("list" => [], "current" => "");
        // $bread['breadcrumb']['list']   = array();
        $gen_url = "";
        foreach ($facet_names as $fkey => $facet_name) {
            $slugval = array_search($facet_name, $slug_search_result);

            $part_url = "";
            $cat_name = "";
            if (isset($slug_value_search_result[$slugval]["facet_value"])) {
                foreach ($slugs_result[$facet_name] as $slugk => $slugv) {
                    if ($slugk == 0) {
                        $part_url .= $slugv;
                        $cat_name = $slug_value_search_result[$slugv]["facet_value"];
                    } else {
                        $part_url .= "--" . $slugv;
                        $cat_name .= "-" . $slug_value_search_result[$slugv]["facet_value"];
                    }
                }
                $gen_url .= "/" . $part_url;

                if ($fkey == (count($slug_search_result) - 1)) {
                    $bread['breadcrumb']['current'] = $cat_name;
                } else {
                    $bread['breadcrumb']['list'][] = ['name' => $cat_name, 'href' => url($gen_url)];
                }

            }

        }

        if ((!isset($params["exclude_in_response"])) || (isset($params["exclude_in_response"]) && !in_array("items", $params["exclude_in_response"]))) {
            if ((!isset($params["exclude_in_response"])) || (isset($params["exclude_in_response"]) && !in_array("search_string", $params["exclude_in_response"]))) {
                $output["search_string"] = $results['search_string'];
            }

            if ((!isset($params["exclude_in_response"])) || (isset($params["exclude_in_response"]) && !in_array("page", $params["exclude_in_response"]))) {
                $output["page"] = $results["page"];
            }

            $output["items"] = $results["items"];
            if ((!isset($params["exclude_in_response"])) || (isset($params["exclude_in_response"]) && !in_array("results_found", $params["exclude_in_response"]))) {
                $output["results_found"] = $results["results_found"];
            }

            if ((!isset($params["exclude_in_response"])) || (isset($params["exclude_in_response"]) && !in_array("headers", $params["exclude_in_response"]))) {
                $output["headers"] = ["page_title" => $title, "product_count" => $results["page"]["total_item_count"]];
            }

        }
        $output["sort_on"] = config("product.sort_on");
        if (isset($params['sort_on'])) {
            foreach ($output["sort_on"] as &$value) {
                $value['is_selected'] = ($value['value'] == $params['sort_on']);
            }
        }
        if ((!isset($params["exclude_in_response"])) || (isset($params["exclude_in_response"]) && !in_array("breadcrumbs", $params["exclude_in_response"]))) {
            $output["breadcrumbs"] = $bread['breadcrumb'];
        }

        if ((!isset($params["exclude_in_response"])) || (isset($params["exclude_in_response"]) && !in_array("search", $params["exclude_in_response"]))) {
            $output["search"] = ["params" => ["genders" => ["men"], "l1_categories" => ["clothing"]], "pattern" => [["key" => "genders", "slugs" => ["men"]], ["key" => "l1_categories", "slugs" => ["clothing"]]], "is_valid" => true, "domain" => "https=>//newsite.stage.kidsuperstore.in", "type" => "product-list", "query" => ["page" => ["2"], "page_size" => ["20"]]];
        }

        // dd($output);
        return $output;
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
                        'change'       => function(&$product,&$variants){
                            $product['product_image_available'] = true;
                        },
                    ]
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

    public static function getBrandsForProducts(){
        $odoo = new OdooConnect;
        $allBrands = $odoo->defaultExec('product.template','search_read',[[['brand_ids','!=', false]]],['fields'=>['brand_ids'],'limit'=>500, 'offset' => 0]);
        $brandIds = $allBrands->pluck('brand_ids')->flatten()->unique()->values();
        $brands = $odoo->defaultExec('custom.brand','read',[$brandIds->toArray()],['fields'=>['display_name']])->pluck('display_name','id');
        $products = $allBrands->pluck('id');
        $productColors = ProductColor::select(['product_id','elastic_id'])->whereIn('product_id',$products)->pluck('product_id','elastic_id');
        $productBrands = $productColors->map(function($productID)use($brands,$allBrands){
            $brand = $brands[$allBrands->where('id',$productID)->first()['brand_ids'][0]];
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
                'change' => function (&$product, &$variants) use ($brand) {
                    $product['product_brand'] = $brand; 
                }
            ];
            
        });
        if ($productBrands->count() != 0) {
            ProductColor::updateElasticData($productBrands);
        }
        return ;
    }
