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
function createUrl($type, $slugs = ['shop'], $all_filters = null)
{
    $url = '';
    foreach ($slugs as $value) {
        $url .= '/' .$value;
    }
    if ($type == 'product') {
        $url .= '/buy';
    }
    if (!is_null($all_filters)) {
        $url .= '?';
        $filters_with_bar = array();
        foreach ($all_filters as $filter_type => $filter_values) {
            $filters_with_comma = array();
            foreach($filter_values as $filter_name => $filter_value) {
                $filters = array();
                foreach ($filter_value as $single_filter) {
                    if(gettype($single_filter) == "boolean") {
                        array_push($filters, json_encode($single_filter));
                    }
                    else {
                        array_push ($filters, $single_filter);
                    }
                }
                array_push($filters_with_comma, $filter_name . ':' . implode(',', $filters));
            }
            array_push ($filters_with_bar, $filter_type . '=' . implode('|', $filters_with_comma));
        }
        $url .= implode('&', $filters_with_bar);
    }
    return $url;
}

function defaultVariant($variants,$isResponseId = true){
    $variants = collect($variants);
    $variants->transform(function ($item, $key) {
            $item['variant_discount'] = $item['variant_list_price'] - $item['variant_sale_price'];
            return $item;
        });
    $max_discount = $variants->pluck('variant_discount')->max();
    $variants = $variants->where('variant_discount', $max_discount);
    $min_sale_price = $variants->pluck('variant_sale_price')->min();
    $variants = $variants = $variants->where('variant_sale_price', $min_sale_price);
    if($isResponseId){
        return $variants->first()['variant_id'];
    }else{
        return $variants->first();
    }

}

function setListingFilters($params)
{
    $filter_params                  = [];
    $filter_params["search_object"] = [];
    $facet_display_data             = config('product.facet_display_data');
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

    return $filter_params;
}

function formatItems($result, $params){
    $items = [];
    $response = ["results_found" => ($result["hits"]["total"] > 0)];
    foreach ($result['hits']['hits'] as  $doc) {
        $items[] = $doc["_source"]["search_result_data"]["product_slug"];
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
        "display_limit" => $params["display_limit"]
    ];

    return $response;
}

function sanitiseFilterdata($result)
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

    /*$priceFilter = [
        "max" => (isset($result["aggregations"]["agg_price"]["facet_name"]["buckets"][0])) ? $result["aggregations"]["agg_price"]["facet_name"]["buckets"][0]['facet_value_max']['value'] : null,
        "min" => (isset($result["aggregations"]["agg_price"]["facet_name"]["buckets"][0])) ? $result["aggregations"]["agg_price"]["facet_name"]["buckets"][0]['facet_value_min']['value'] : null,
    ];
    $priceFilter["min"] = (int) floor($priceFilter["min"] / 100) * 100;
    $priceFilter["max"] = (int) ceil($priceFilter["max"] / 100) * 100;*/

    return $filterResponse;
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
    foreach ($params['search_object'] as $filter_type => $facet) {
        if(is_array($facet)){
            foreach ($facet as $facet_name => $values) {
                if ($filter_type == "range_filter")
                {
                    if(!isset($values['max']))
                        $values['max'] = null;
                    if(!isset($values['min']))
                        $values['min'] = null;
                }
                $search_object[$filter_type][$facet_name] = $values;     
            }
        }
        else{
            $search_object[$filter_type] = $facet;
        }
    }
    return $search_object;
}

function setElasticFacetFilters($q, $params, $isResponseNested = true)
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
    if($isResponseNested){
        $bool = $q::addToBoolQuery('must', $must);
        $bool = $q::addToBoolQuery('must_not', $must_not, $bool);
        $bool = $q::createNested($path, $bool);
        return $bool;    
    }else{
        return [$must,$must_not];
    }
    
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

function fetchLandingProductDetails($products)
{
    $productsData = [];
    foreach ($products as $productSource) {
        $product       = $productSource["_source"];
        $id            = defaultVariant($product['variants']);
        $productObj    = ProductColor::where('elastic_id', $productSource["_id"])->first();
        $productImages = $productObj->getDefaultImage(["list-view"]);
        foreach ($product['variants'] as $variant) {
            if ($variant['variant_id'] == $id) {
                $productsData[$productSource["_id"]] = ['title' => $product["search_result_data"]["product_title"], 'url' => url('/' . $product["search_result_data"]["product_slug"] . "/buy"), 'list_price' => $variant["variant_list_price"], 'sale_price' => $variant["variant_sale_price"], 'discount_per' => calculateDiscount($variant["variant_list_price"], $variant["variant_sale_price"]), 'images' => (isset($productImages['list-view'])) ? $productImages['list-view'] : []];
                break;
            }
        }
    }
    return $productsData;
}
