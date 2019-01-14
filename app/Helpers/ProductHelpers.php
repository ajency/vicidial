<?php
use App\Facet;
use App\ProductColor;
use App\Variant;
use Ajency\Connections\ElasticQuery;
//Calculate Discount from price
function calculateDiscount($list_price, $sale_price)
{
    if ($list_price == 0 or $sale_price == 0) {
        return 0;
    }

    $discount_amt        = $list_price - $sale_price;
    return $discount_per = round($discount_amt / $list_price * 100);
}

//Get price, discount, attributes for size
function getPriceSet($size_set, $size = null)
{
    $list_price   = $size_set->list_price;
    $sale_price   = $size_set->sale_price;
    $discount_per = $size_set->discount_per;

    $disabled = "";
    $checked  = "";
    if (!$size_set->inventory_available) {
        $disabled = "disabled";
    } elseif ($size != null && $size == $size_set->size->slug) {
        $checked = "checked";
    }
    return ['list_price' => $list_price, 'sale_price' => $sale_price, 'discount_per' => $discount_per, 'disabled' => $disabled, 'checked' => $checked];
}

//Set price to be displayed
function setDefaultPrice($variants, $size = null)
{
    foreach ($variants as $size_set) {
        if ($size != null) {
            if ($size == $size_set->size->slug && $size_set->inventory_available) {
                return getPriceSet($size_set, $size);
            }
        } else {
            if ($size_set->is_default) {
                return getPriceSet($size_set);
            }
        }
    }
}

//URL Generation
function createUrl($slugs)
{
    $url = '';
    foreach ($slugs as $slug) {
        $url .= '/' . $slug;
    }
    return $url;
}

function defaultVariant($variants){
    $variants = collect($variants);
    $variants->transform(function ($item, $key) {
            $item['variant_discount'] = $item['variant_list_price'] - $item['variant_sale_price'];
            return $item;
        });
    $max_discount = $variants->pluck('variant_discount')->max();
    $variants = $variants->where('variant_discount', $max_discount);
    $min_sale_price = $variants->pluck('variant_sale_price')->min();
    $variants = $variants = $variants->where('variant_sale_price', $min_sale_price);

    return $variants->first()['variant_id'];

}
function formatItems($result, $params){
    $items = [];
    $response = ["results_found" => ($result["hits"]["total"] > 0)];
    foreach ($result['hits']['hits'] as  $doc) {
        $productColor      = ProductColor::where("elastic_id", $doc["_id"])->first();
        $product = $doc["_source"];
        $data = $product["search_result_data"];
        $listImages       = $productColor->getDefaultImage(["list-view"]);
        $item = [
            "title" => $data["product_title"],
            "slug_name" => $data["product_slug"],
            "description" => $data["product_description"],
            "images" => (isset($listImages["list-view"])) ? $listImages["list-view"] : [],
            "variants" => [],
            "product_id" => $data["product_id"],
            "color_id" => $data['product_color_id'],
            "color_name" => $data['product_color_name'],
            "color_html" => $data['product_color_html'],
        ];

        //find product_availability
        $item['product_availability'] = false;
        foreach ($product["variants"] as $variant) {
            if($variant['variant_availability']){
                $item['product_availability']  = true;
                break;
            }
        }
        // display price
        $variants           = collect($product['variants']);
        $prices             = $variants->pluck('variant_sale_price')->unique();
        $item['sale_price'] = ["min" => $prices->min(), "max" => $prices->max()];
        $list_price         = $variants->pluck('variant_list_price');
        $item['mrp']        = ["min" => $list_price->min(), "max" => $list_price->max()];
        $variants->transform(function ($item, $key) {
            $item['variant_discount'] = $item['variant_list_price'] - $item['variant_sale_price'];
            return $item;
        });
        $discounts             = $variants->pluck('variant_discount');
        $item['discount']      = ["min" => $discounts->min(), "max" => $discounts->max()];
        $item['display_price'] = $item['sale_price'];

        $item['default_mrp']        = $item['mrp']['min'];
        $item['default_sale_price'] = $item['sale_price']['min'];
        $item['default_default']    = $item['discount']['max'];
        
        $id = defaultVariant($product['variants']);
        foreach ($product["variants"] as $variant) {
            $item["variants"][] = [
                "list_price" => $variant["variant_list_price"],
                "sale_price" => $variant["variant_sale_price"],
                "is_default" => ($id == $variant["variant_id"]),
                "size" => [
                    "size_id" => $variant["variant_size_id"],
                    "size_name" => $variant["variant_size_name"],
                ],
                "inventory_available" => $variant["variant_availability"],
                "variant_id" => $variant["variant_id"],
                "discount_per" => calculateDiscount($variant["variant_list_price"],$variant["variant_sale_price"])
            ];
        }
        $items[] = $item;
    }

    $response["items"] = $items;
    $size = $params["display_limit"];
    $offset = ($params["page"] - 1) * $size;
    $total_items = $result["hits"]["total"];
    $total_pages = intval(ceil($total_items / $size));
    $response["page"] = [
        "current" => $params["page"],
        "total" => $total_pages ,
        "has_previous" => ($params["page"]> 1),
        "has_next" => ($params["page"] < $total_pages),
        "total_item_count" => $total_items,
    ];

    if(isset($params['search_object']) && isset($params['search_object']['search_string']))
        $response['search_string'] = $params['search_object']['search_string'];
    else
        $response['search_string'] = null;
    return $response;
}


/**
 * Function to sort Items in LHS response
 * 
 */
function sortLHSItems($items, $facet_name){
    $items = collect($items);
    $sort_on = config('product.facet_display_data.'.$facet_name.".sort_on");
    $sort_order = config('product.facet_display_data.'.$facet_name.".sort_order");
    
    if($sort_order === 'asc'){
        $items = $items->sortBy($sort_on);  
    }elseif ($sort_order === "desc") {
        $items = $items->sortByDesc($sort_on);  

    }
    return $items->values()->all();
}

function sanitiseFilterdata($result, $params = [])
{
    $filterResponse = [];
    foreach ($result["aggregations"]["agg_string_facet"]["facet_name"]["buckets"] as $facet_name) {
        $filterResponse[$facet_name["key"]] = [];
        foreach ($facet_name["facet_value"]["buckets"] as $value) {
            $filterResponse[$facet_name["key"]][$value["key"]] = $value["count"]["doc_count"];
        }
    }

    $variant_facets = ['variant_size_name'];
    foreach ($variant_facets as $facet_name) {
        foreach ($result["aggregations"]['variant_aggregation']['available'][$facet_name]['buckets'] as $data) {
            $filterResponse[$facet_name][$data["key"]] = $data['count']["doc_count"];
        }
    }

    $priceFilter = [
        "max" => (isset($result["aggregations"]["agg_price"]["facet_name"]["buckets"][0])) ? $result["aggregations"]["agg_price"]["facet_name"]["buckets"][0]['facet_value_max']['value'] : null,
        "min" => (isset($result["aggregations"]["agg_price"]["facet_name"]["buckets"][0])) ? $result["aggregations"]["agg_price"]["facet_name"]["buckets"][0]['facet_value_min']['value'] : null,
    ];
    $priceFilter["min"] = (int) floor($priceFilter["min"] / 100) * 100;
    $priceFilter["max"] = (int) ceil($priceFilter["max"] / 100) * 100;
    $attributes         = ['is_singleton', 'is_collapsed', 'template', 'order', 'display_count', 'disabled_at_zero_count', 'is_attribute_param', 'filter_type','sort_on','sort_order','custom_attributes'];
    $response           = [];


    $facetNames =  ["product_category_type", "product_gender", "product_subtype", "product_age_group", "product_color_html", "product_metatag", "variant_size_name"];
    // dd($facetNames);
    foreach ($facetNames as $f) {
        $filter           = [];
        $facetName = $f;
        $facetValues = isset($filterResponse[$facetName])? $filterResponse[$facetName]:null;
        $facets           = Facet::where('facet_name', $facetName)->where("display",true)->get();
        $filter['header'] = [
            'facet_name'   => $facetName,
            'display_name' => config('product.facet_display_data.' . $facetName . '.name'),
        ];
        $filter['items'] = [];

        $is_collapsed    = 0;
        foreach ($facets as $facet) {
            if (isset($params["search_object"]['primary_filter'][$facet->facet_name])) {
                $is_selected = (array_search($facet->facet_value, $params["search_object"]['primary_filter'][$facet->facet_name]) === false) ? false : true;
            } else {
                $is_selected = false;
            }

            $filter['items'][] = [
                'facet_value'  => $facet->facet_value,
                "false_facet_value" =>  config('product.facet_display_data.'.$facet->facetName.'.false_facet_value'),
                'display_name' => $facet->display_name,
                'slug'         => $facet->slug,
                'is_selected'  => $is_selected,
                'sequence'     => $facet->sequence,
                'count'        => (isset($facetValues[$facet->facet_value])) ? $facetValues[$facet->facet_value] : 0,
            ];
            $is_collapsed += $is_selected;
        }
        foreach ($attributes as $attribute) {
            $filter[$attribute] = config('product.facet_display_data.' . $facetName . '.' . $attribute);
        }
        //change made by Tanvi to is_collapsed value
        $filter["is_collapsed"] = (!boolval($is_collapsed) == true)?(config('product.facet_display_data.' . $facetName . '.is_collapsed')):!boolval($is_collapsed);
        $response[] = $filter;
        
    }

    //le price filter
    $filter           = [];
    $filter['header'] = [
        'facet_name'   => 'variant_sale_price',
        'display_name' => config('product.facet_display_data.variant_sale_price.name'),
    ];
    foreach ($attributes as $attribute) {
        $filter[$attribute] = config('product.facet_display_data.variant_sale_price.' . $attribute);
    }
    $filter["items"]                   = [];
    $filter["is_collapsed"]            = false;
    $filter["bucket_range"]            = [];
    // $filter["bucket_range"]["start"]   = $priceFilter['min'];
    // $filter["bucket_range"]["end"]     = $priceFilter['max'];
    
    /** change made by Tanvi to bucket range as a workaround to handle price filters **/
    $filter["bucket_range"]["start"]   = config('product.price_filter_bucket_range.min');
    $filter["bucket_range"]["end"]     = config('product.price_filter_bucket_range.max');
    /** change made by Tanvi to bucket range as a workaround to handle price filters **/
    $filter["selected_range"]          = [];
    $filter["selected_range"]["start"] = (isset($params["search_object"]['range_filter']['variant_sale_price'])) ? $params["search_object"]['range_filter']['variant_sale_price']['min'] : $filter["bucket_range"]["start"];
    // $filter["selected_range"]["start"] = ($filter["selected_range"]["start"] < $filter["bucket_range"]["start"])? $filter["bucket_range"]["start"] : $filter["selected_range"]["start"];
    $filter["selected_range"]["end"]   = (isset($params["search_object"]['range_filter']['variant_sale_price'])) ? $params["search_object"]['range_filter']['variant_sale_price']['max'] : $filter["bucket_range"]["end"];
    // $filter["selected_range"]["end"] = ($filter["selected_range"]["end"] > $filter["bucket_range"]["end"])? $filter["bucket_range"]["end"] : $filter["selected_range"]["end"];
    $response[] = $filter;

    //le availability filter
    
    $response[] = boolFilterResponse("variant_availability", $attributes, $params);

    foreach ($response as &$filter) {
        $filter['items'] = sortLHSItems($filter['items'],  $filter['header']['facet_name']);
    }

    // image availability filter

        // image availability filter
    $response[] = boolFilterResponse("product_image_available", $attributes, $params);
    // ecomm filter
    $response[] = boolFilterResponse("product_att_ecom_sales", $attributes, $params);
    
    return $response;
}


function boolFilterResponse($facet_name, $attributes, $params){
    $filter           = [];
    $filter['header'] = [
        'facet_name'   => $facet_name,
        'display_name' => config('product.facet_display_data.'.$facet_name.'.name'),
    ];
    foreach ($attributes as $attribute) {
        $filter[$attribute] = config('product.facet_display_data.'.$facet_name.'.'.$attribute);
    }
    $config = config('product.facet_display_data.'.$facet_name);
    $filter['items'] = [
        [
            "display_name" => $config['item_display_name'],
            "facet_value"  => $config['facet_value'],
            "is_selected"  => selectBool($params, $facet_name, $config['facet_value']),
            "count" => 20,
            "false_facet_value" => $config['false_facet_value'],
            "slug" => str_slug($config['facet_value']),
        ],
    ];
    $filter['attribute_slug'] = config('product.facet_display_data.'.$facet_name.'attribute_slug');
    return $filter;
}


function selectBool($params, $name, $value){
    if (isset($params['search_object']['boolean_filter'][$name])) {
        if ($params['search_object']['boolean_filter'][$name] === $value) {
            return true;
        } else {
            return false;
        }
    }
    return true;
}


function getProductThumbImages($variantId){
    $variant = Variant::find($variantId);
    $default_imgs = $variant->productColor->getDefaultImage(["variant-thumb"]);
    if(isset($default_imgs["variant-thumb"]))
        return $default_imgs["variant-thumb"];
    else
        return $default_imgs;
}

function setDefaultFilters(array $params){
    // load default parms

    $facet_display_data = config('product.facet_display_data');
    $search_object = [];
    foreach ($facet_display_data as $facet_name => $data) {
        if($data['implicit_filter']['skip']== false){
            $search_object[$data['filter_type']][$facet_name] = $data['implicit_filter']['default_value'];
        }
    }
    
    //add request params
    foreach ($params['search_object'] as $filter_type => $facet) {
        if(is_array($facet)){
            foreach ($facet as $facet_name => $values) {
                $search_object[$filter_type][$facet_name] = $values;
            }
        }
        else{
            $search_object[$filter_type] = $facet;
        }
    }

    return $search_object;
}

function setElasticFacetFilters($q, $params)
{
    $search_object = $params['search_object'];
    $filters = makeQueryfromParams($search_object);
    $must    = [];
    $must_not = [];
    $path = "search_data";
    $data = $filters[$path];
    foreach ($data as $facet => $data2) {
        foreach ($data2 as $field => $values) {
            $should = [];
            $nested = [];
            if ($values['type'] == 'enum') {
                foreach ($values['value'] as $value) {
                    $facetName  = $q::createTerm($path . "." . $facet . '.facet_name', $field);
                    $facetValue = $q::createTerm($path . "." . $facet . '.facet_value', $value);
                    if($facet === "boolean_facet" and $value === false){   
                        $facetValue = $q::createTerm($path . "." . $facet . '.facet_value', !$value);
                    }
                    $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
                    $nested[]   = $q::createNested($path . '.' . $facet, $filter);
                    $should     = $q::addToBoolQuery('should', $nested, $should);
                }
            } else if ($values['type'] == 'range') {
                $facetValue = $q::createRange($path . "." . $facet . '.facet_value', ['lte' => $values['value']['max'], 'gte' => $values['value']['min']]);
                $facetName  = $q::createTerm($path . "." . $facet . '.facet_name', $field);
                $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
                $nested[]   = $q::createNested($path . '.' . $facet, $filter);
                $should     = $q::addToBoolQuery('should', $nested, $should);
            }
            $nested2 = $q::createNested($path, $should);
            if($facet === "boolean_facet"  and $value === false){
                $must_not[] = $should;
            }
            else{
                $must[]  = $should;
            }
        }
    }

    if (isset($search_object['search_string'])) {
        $must[] = textSearch($q, $search_object['search_string']);
    }
    $bool = $q::addToBoolQuery('must', $must);
    $bool = $q::addToBoolQuery('must_not', $must_not, $bool);
    $bool = $q::createNested($path, $bool);
    return $bool;
}


function textSearch(ElasticQuery $q, string $text)
{
    $match = $q::createMatch("search_data.full_text", $text);
    return $match;
}

/**
 * Query to filter Products which have active variants
 *
 * @return array
 */
function filterActiveProducts($q, $must)
{
    $nested     = [];
    $facetName  = $q::createTerm("search_data.boolean_facet.facet_name", "product_att_ecom_sales");
    $facetValue = $q::createTerm("search_data.boolean_facet.facet_value", true);
    $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
    $nested[]   = $q::createNested('search_data.boolean_facet', $filter);
    $nested2    = $q::createNested("search_data", $nested);
    return $nested2;
}


/**
 * Query to hide Products with Color ID equalling 0
 *
 * @return elastic params
 */
function hideZeroColorIDProducts($q, $must)
{
    $nested     = [];
    $facetName  = $q::createTerm("search_data.number_facet.facet_name", "product_color_id");
    $facetValue = $q::createTerm("search_data.number_facet.facet_value", 0);
    $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
    $nested[]   = $q::createNested('search_data.number_facet', $filter);
    $nested2    = $q::createNested("search_data", $nested);
    $must       = $q::addToBoolQuery('must_not', $nested2, $must);
    return $must;

}

/**
 * Query to hide Products with Size ID equalling 0
 *
 * @return elastic params
 */
function hideZeroSizeIDProducts($q, $must)
{
    $nested     = [];
    $facetName  = $q::createTerm("search_data.number_facet.facet_name", "variant_size_id");
    $facetValue = $q::createTerm("search_data.number_facet.facet_value", 0);
    $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
    $nested[]   = $q::createNested('search_data.number_facet', $filter);
    $nested2    = $q::createNested("search_data", $nested);
    $must       = $q::addToBoolQuery('must_not', $nested2, $must);
    return $must;

}
