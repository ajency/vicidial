<?php
use App\Facet;
use App\ProductColor;
//Calculate Discount from price
function calculate_discount($list_price, $sale_price){
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

	return ['list_price'=> $list_price, 'sale_price'=> $sale_price, 'discount_per'=> calculate_discount($list_price, $sale_price), 'disabled'=> $disabled, 'checked'=> $checked];
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
        $productColor      = ProductColor::where([["elastic_id", $doc["_id"]]])->first();
        $product = $doc["_source"];
        $data = $product["search_result_data"];

        $item = [
            "title" => $data["product_title"],
            "slug_name" => $data["product_slug"],
            "description" => $data["product_description"],
            "images" => $productColor->getDefaultImage(["list-view"]),
            "variants" => [],
            "product_id" => $data["product_id"],
            "color_id" => $data['product_color_id'],
            "color_name" => $data['product_color_name'],
            "color_html" => $data['product_color_html'],
        ];

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
    $response = [];
    foreach ($filterResponse as $facetName => $facetValues) {
        $filter           = [];
        $facets           = Facet::where('facet_name', $facetName)->get();
        $filter['header'] = [
            'facet_name'   => $facetName,
            'display_name' => config('product.facet_display_data.' . $facetName . '.name'),
        ];
        $filter['items'] = [];
        foreach ($facets as $facet) {
            $filter['items'][] = [
                'facet_value'  => $facet->facet_value,
                'display_name' => $facet->display_name,
                'slug'         => $facet->slug,
                'is_selected'  => (array_search($facet->facet_value, array_collapse($params["search_object"])) === false) ? false : true,
                'sequence'     => $facet->sequence,
                'count'        => (isset($facetValues[$facet->facet_value])) ? $facetValues[$facet->facet_value] : 0,
            ];
        }
        $attributes = ['is_singleton', 'is_collapsed', 'template', 'order'];
        foreach ($attributes as $attribute) {
            $filter[$attribute] = config('product.facet_display_data.' . $facetName . '.' . $attribute);
        }
        $response[] = $filter;
    }
    return $response;
}