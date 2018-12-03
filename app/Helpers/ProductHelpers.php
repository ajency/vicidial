<?php
use App\Facet;
use App\ProductColor;
use App\Variant;
use App\Elastic\ElasticQuery;
//Calculate Discount from price
function calculate_discount($list_price, $sale_price){
    if($list_price == 0 or $sale_price == 0)
        return 0;
	$discount_amt = $list_price - $sale_price;
	return $discount_per = round($discount_amt/$list_price * 100);
}

//Get price, discount, attributes for size
function get_price_set($size_set, $size = null){
	$list_price = $size_set->list_price;
	$sale_price = $size_set->sale_price;

	$disabled = "";
	$checked = "";
	if(!$size_set->inventory_available) {
		$disabled = "disabled";
	}
	elseif ($size != null && $size == $size_set->size->name) {
		$checked="checked";
    }
	return ['id' => $size_set->id ,'list_price'=> $list_price, 'sale_price'=> $sale_price, 'discount_per'=> calculate_discount($list_price, $sale_price), 'disabled'=> $disabled, 'checked'=> $checked];
}

//Set price to be displayed
function set_default_price($variants, $size = null){
	foreach ($variants as $size_set) {
	    if($size != null) {
		    if($size == $size_set->size->name && $size_set->inventory_available) {
	        	return get_price_set($size_set, $size);
	        }
        }
        else {
        	if($size_set->is_default) {
	     		return get_price_set($size_set);
	     	}
        }
    }
}

//URL Generation
function create_url($slugs){
	$url = '';
	foreach ($slugs as $slug) {
		$url .= '/'.$slug;
	}
	return $url;
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
        // find default product by max sale price
        $id         = $product["variants"][0]["variant_id"];
        $sale_price = $product["variants"][0]["variant_sale_price"];
        foreach ($product["variants"] as $variant) {
            if ($sale_price < $variant["variant_sale_price"]) {
                $id         = $variant["variant_id"];
                $sale_price = $variant["variant_sale_price"];
            }
        }
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
                "discount_per" => calculate_discount($variant["variant_list_price"],$variant["variant_sale_price"])
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
    return $response;
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
    $priceFilter = [
        "max" => (isset($result["aggregations"]["agg_price"]["facet_name"]["buckets"][0])) ? $result["aggregations"]["agg_price"]["facet_name"]["buckets"][0]['facet_value_max']['value'] : null,
        "min" => (isset($result["aggregations"]["agg_price"]["facet_name"]["buckets"][0])) ? $result["aggregations"]["agg_price"]["facet_name"]["buckets"][0]['facet_value_min']['value'] : null,
    ];
    $priceFilter["min"] = (int) floor($priceFilter["min"] / 100) * 100;
    $priceFilter["max"] = (int) ceil($priceFilter["max"] / 100) * 100;
    $attributes         = ['is_singleton', 'is_collapsed', 'template', 'order', 'display_count', 'disabled_at_zero_count', 'is_attribute_param', 'filter_type','sort_on','sort_order','custom_attributes'];
    $response           = [];


    $facetNames =  ["product_category_type", "product_gender", "product_subtype", "product_age_group", "product_color_html"];
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
    $filter           = [];
    $filter['header'] = [
        'facet_name'   => 'variant_availability',
        'display_name' => config('product.facet_display_data.variant_availability.name'),
    ];
    foreach ($attributes as $attribute) {
        $filter[$attribute] = config('product.facet_display_data.variant_availability.' . $attribute);
    }
    $filter['items'] = [
        [
            "display_name" => config('product.facet_display_data.variant_availability.item_display_name'),
            "facet_value"  => false,
            "is_selected" => (isset($params['search_object']['boolean_filter']['variant_availability']) and $params['search_object']['boolean_filter']['variant_availability']),
            "count" => 20,
        ],
    ];
    $filter['attribute_slug'] = config('product.facet_display_data.variant_availability.attribute_slug');
    $response[] = $filter;

    return $response;
}


function getProductThumbImages($variantId){
    $variant = Variant::find($variantId);
    $default_imgs = $variant->productColor->getDefaultImage(["variant-thumb"]);
    if(isset($default_imgs["variant-thumb"]))
        return $default_imgs["variant-thumb"];
    else
        return $default_imgs;
}

function setElasticFacetFilters($q, $params)
{
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
                    }
                } else if ($values['type'] == 'range') {
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
    if (isset($params['search_object']['search_string'])) {
        $must[] = textSearch($q, $params['search_object']['search_string']);
    }
    $must = $q::addToBoolQuery('must', $must);
    $nested3 =[];
    // $must = hideZeroColorIDProducts($q, $must);
    // $must = hideZeroSizeIDProducts($q, $must);
    // $nested3[] = filterActiveProducts($q, $must);
    if (showProductsWithImages($params)) {
        $nested3[] = hideProductWithoutImages($q, $must);
    }
    if (showProductsWithInventory($params)) {
        $nested3[] = hideUnavailableProducts($q, $must);
    }

    $must = $q::addToBoolQuery('filter', $nested3, $must);
    return $must;
}

function showProductsWithImages($params){
    if(isset($params['search_object']['boolean_filter']['product_image_available']) && !$params['search_object']['boolean_filter']['product_image_available']){
        return false;
    }
    return true;
}

function showProductsWithInventory($params){
    if(isset($params['search_object']['boolean_filter']['variant_availability']) && $params['search_object']['boolean_filter']['variant_availability']){
        return true;
    }
    return false;
}

function textSearch(ElasticQuery $q, string $text)
{
    $match    = $q::createMatch("search_data.full_text", $text);
    $nested  = $q::createNested("search_data", $match);
    return $nested;
}

function priceFilter($q, $must, $min, $max)
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
 * Query to hide Products which are not available
 *
 * @return array
 */
function hideUnavailableProducts($q, $must)
{
    $nested     = [];
    $facetName  = $q::createTerm("search_data.boolean_facet.facet_name", "variant_availability");
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


/**
 * Query to hide Products not having images
 *
 * @return array
 */
function hideProductWithoutImages($q, $must)
{
    $nested     = [];
    $facetName  = $q::createTerm("search_data.boolean_facet.facet_name", "product_image_available");
    $facetValue = $q::createTerm("search_data.boolean_facet.facet_value", true);
    $filter     = $q::addToBoolQuery('filter', [$facetName, $facetValue]);
    $nested[]   = $q::createNested('search_data.boolean_facet', $filter);
    $nested2    = $q::createNested("search_data", $nested);
    return $nested2;
}

