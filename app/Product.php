<?php
namespace App;

use App\Elastic\ElasticQuery;
use App\Elastic\OdooConnect;
use App\Facet;
use App\Jobs\CreateProductJobs;
use App\Jobs\FetchProductImages;
use App\Jobs\UpdateVariantInventory;
use App\ProductColor;
use App\Variant;
use App\Warehouse;

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

    public static function startSync()
    {
        $first_id = ProductColor::max('product_id');
        $first_id = ($first_id == null)? 0: $first_id;
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
        foreach ($inventory['inventory'] as $inventoryData) {
            try{
                $loc = new Location;
                $loc->odoo_id = $inventoryData['location_id'];
                $loc->name = $inventoryData['location_name'];
                $loc->warehouse_odoo_id = $inventoryData['warehouse_id'];
                $loc->save();
            }catch (\Exception $e) {
                \Log::warning($e->getMessage());
            }
        }
        $facets = ['product_category_type', 'product_gender', 'product_age_group', 'product_subtype'];
        foreach ($facets as $facet) {
            try {
                $facetObj               = new Facet;
                $facetObj->facet_name   = $facet;
                $facetObj->facet_value  = $product[$facet];
                $facetObj->display_name = ($facet == 'product_color_html')? $product['product_color_name']:$product[$facet];
                $facetObj->slug         = str_slug($product[$facet]);
                $facetObj->sequence     = 10000;
                $facetObj->save();
            } catch (\Exception $e) {
                \Log::warning($e->getMessage());
            }
        }
        $facets = ['product_color_html'];
        foreach ($facets as $facet) {
            try {
                $facetObj               = new Facet;
                $facetObj->facet_name   = $facet;
                $facetObj->facet_value  = $variant[$facet];
                $facetObj->display_name = ($facet == 'product_color_html')? $variant['product_color_name']:$variant[$facet];
                $facetObj->slug         = str_slug($variant[$facet]);
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
    public static function buildBaseQuery()
    {

        $q                 = new ElasticQuery;

        $required          = ["product_category_type", "product_gender", "product_subtype", "product_age_group", "product_color_html"];
        $aggs_facet_name   = $q::createAggTerms("facet_name", "search_data.string_facet.facet_name", ["include" => $required]);
        $aggs_facet_value  = $q::createAggTerms("facet_value", "search_data.string_facet.facet_value");
        $aggs_facet_value  = $q::addToAggregation($aggs_facet_value, $q::createAggReverseNested('count'));
        $aggs_facet_name   = $q::addToAggregation($aggs_facet_name, $aggs_facet_value);
        $aggs_string_facet = $q::createAggNested("agg_string_facet", "search_data.string_facet");
        $aggs_string_facet = $q::addToAggregation($aggs_string_facet, $aggs_facet_name);
        
        $aggFacetNameP     = $q::createAggTerms("facet_name", "search_data.number_facet.facet_name", ["include" => ['variant_sale_price']]);
        $aggMax            = $q::createAggMax('facet_value_max', 'search_data.number_facet.facet_value');
        $aggMin            = $q::createAggMin('facet_value_min', 'search_data.number_facet.facet_value');
        $minMax            = $q::addToAggregation($aggFacetNameP, array_merge($aggMax, $aggMin));
        $aggsPrice         = $q::createAggNested("agg_price", "search_data.number_facet");
        $priceQ            = $q::addToAggregation($aggsPrice, $minMax);
        
        $q->setIndex(config('elastic.indexes.product'))
            ->initAggregation()->setAggregation(array_merge($priceQ, $aggs_string_facet))
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

        $q = self::buildBaseQuery();

        $filters = makeQueryfromParams($params["search_object"]);

        $must = [];
        foreach ($filters as $path => $data) {
            foreach ($data as $facet => $data2) {
                foreach ($data2 as $field => $values) {
                    $should = [];
                    $nested = [];
                    if ($values['type'] == 'enum') {
                        foreach ($values['value'] as $value) {
                            $facetName  = $q::createTerm($path . "." . $facet . '.facet_name', $field);
                            $facetValue = $q::createTerm($path . "." . $facet . '.facet_value', $value);
                            $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
                            $nested[]   = $q::createNested($path . '.' . $facet, $filter);
                            $should     = $q::addToBoolQuery('should', $nested, $should);
                        }} else if ($values['type'] == 'range') {
                        $facetValue = $q::createRange($path . "." . $facet . '.facet_value', ['lte' => $values['value']['max'], 'gte' => $values['value']['min']]);
                        $facetName  = $q::createTerm($path . "." . $facet . '.facet_name', $field);
                        $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
                        $nested[]   = $q::createNested($path . '.' . $facet, $filter);
                        $should     = $q::addToBoolQuery('should', $nested, $should);
                    }
                    $nested2 = $q::createNested($path, $should);
                    $must[]  = $nested2;
                }
            }
        }

        $must = $q::addToBoolQuery('must', $must);


        $must = self::hideZeroColorIDProducts($q, $must);
        $must = self::hideUnavailableProducts($q, $must);
        

        $q->setQuery($must);
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
    public static function getItemsWithFilters($params){
        $size = $params["display_limit"];
        $offset = ($params["page"] - 1) * $size;

        $index = config('elastic.indexes.product');
        $q     = new ElasticQuery;
        $q->setIndex($index);
        $filters = makeQueryfromParams($params["search_object"]);
        $must    = [];
        foreach ($filters as $path => $data) {
            foreach ($data as $facet => $data2) {
                foreach ($data2 as $field => $values) {
                    $should = [];
                    $nested = [];
                    if ($values['type'] == 'enum') {
                        foreach ($values['value'] as $value) {
                            $facetName  = $q::createTerm($path . "." . $facet . '.facet_name', $field);
                            $facetValue = $q::createTerm($path . "." . $facet . '.facet_value', $value);
                            $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
                            $nested[]   = $q::createNested($path . '.' . $facet, $filter);
                            $should     = $q::addToBoolQuery('should', $nested, $should);
                        }} else if ($values['type'] == 'range') {
                        $facetValue = $q::createRange($path . "." . $facet . '.facet_value', ['lte' => $values['value']['max'], 'gte' => $values['value']['min']]);
                        $facetName  = $q::createTerm($path . "." . $facet . '.facet_name', $field);
                        $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
                        $nested[]   = $q::createNested($path . '.' . $facet, $filter);
                        $should     = $q::addToBoolQuery('should', $nested, $should);
                    }
                    $nested2 = $q::createNested($path, $should);
                    $must[]  = $nested2;

                }
            }
        }
        $must = $q::addToBoolQuery('must', $must);


        $must = self::hideZeroColorIDProducts($q, $must);
        $must = self::hideUnavailableProducts($q, $must);
        $q->setQuery($must)
        ->setSource(["search_result_data", "variants"])
        ->setSize($size)->setFrom($offset);
        return formatItems($q->search(), $params);
    }

    /**
     * Query to hide Products which are not available
     * 
     * @return array
     */
    public static function hideUnavailableProducts($q, $must){
        $nested = [];
        $facetName  = $q::createTerm( "search_data.boolean_facet.facet_name", "variant_availability");
        $facetValue = $q::createTerm("search_data.boolean_facet.facet_value", true);
        $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
        $nested[]   = $q::createNested('search_data.boolean_facet', $filter);
        $nested2 = $q::createNested("search_data", $nested);
        $must = $q::addToBoolQuery('filter',$nested2, $must);
        return $must;
    }

    /**
     * Query to hide Products with Color ID equalling 0
     * 
     * @return void
     */
    public static function hideZeroColorIDProducts($q, $must){
        $nested = [];
        $facetName  = $q::createTerm( "search_data.number_facet.facet_name", "product_color_id");
        $facetValue = $q::createTerm("search_data.number_facet.facet_value", 0);
        $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
        $nested[]   = $q::createNested('search_data.number_facet', $filter);
        $nested2 = $q::createNested("search_data", $nested);
        $must = $q::addToBoolQuery('must_not',$nested2, $must);
        return $must;

    }

    public static function priceFilter($q, $must, $min, $max)
    {
        $nested     = [];
        $facetName  = $q::createTerm("search_data.number_facet.facet_name", "variant_sale_price");
        $facetValue = $q::createRange("search_data.number_facet.facet_value", ['lte' => $max, 'gte' => $min]);
        $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
        $nested[]   = $q::createNested('search_data.number_facet', $filter);
        $nested2    = $q::createNested('search_data', $nested);
        $must       = $q::addToBoolQuery('filter', $nested2, $must);
        return $must;

    }

    public static function productListPage($params, $slug_value_search_result, $slug_search_result, $slugs_result, $title = "")
    {
        $output                         = [];
        $filter_params                  = [];
        $filter_params["search_object"] = [];
        $facet_display_data             = config('product.facet_display_data');
        // dd($params);
        foreach ($params["search_object"]["primary_filter"] as $paramk => $paramv) {
            if ($facet_display_data[$paramk]["is_essential"] == false) {
                $fields = $paramv;
                array_push($fields, "all");
                $filter_params["search_object"]["primary_filter"][$paramk] = $fields;
            } else {
                $filter_params["search_object"]["primary_filter"][$paramk] = $paramv;
            }

        }
        if( isset($params["search_object"]["range_filter"]))
            $filter_params["search_object"]["range_filter"] = $params["search_object"]["range_filter"];
        $filter_params["display_limit"] = $params["display_limit"];
        $filter_params["page"] = $params["page"];
        // print_r($filter_params);
        // dd($filter_params,$params);

        // $params = $filter_params =  ['search_object' =>['primary_filter' => [ 'product_gender' => ['Boys','all']]], 'display_limit' => 20, 'page' => 1] ;
        // $params = $filter_params ;
        $output["filters"]   = self::getProductCategoriesWithFilter($filter_params);
        // dd($output["filters"]);
        $results             = self::getItemsWithFilters($params);
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
        $output["page"]          = $results["page"];
        $output["items"]         = $results["items"];
        $output["results_found"] = $results["results_found"];
        $output["headers"]       = ["page_title" => $title, "product_count" => $results["page"]["total_item_count"]];
        $output["sort_on"]       = [["name" => "Latest Products", "value" => "latest", "is_selected" => false], ["name" => "Popularity", "value" => "popular", "is_selected" => true], ["name" => "Price Low to High", "value" => "price_asc", "is_selected" => false], ["name" => "Price High to Low", "value" => "price_dsc", "is_selected" => false], ["name" => "Discount Low to High", "value" => "discount_asc", "is_selected" => false], ["name" => "Discount High to Low", "value" => "discount_dsc", "is_selected" => false]];
        $output["breadcrumbs"]   = $bread['breadcrumb'];
        $output["search"]        = ["params" => ["genders" => ["men"], "l1_categories" => ["clothing"]], "pattern" => [["key" => "genders", "slugs" => ["men"]], ["key" => "l1_categories", "slugs" => ["clothing"]]], "is_valid" => true, "domain" => "https=>//newsite.stage.kidsuperstore.in", "type" => "product-list", "query" => ["page" => ["2"], "page_size" => ["20"]]];
        // dd($output);
        return $output;
    }

}
