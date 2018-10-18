<?php

//Function to insert category in DB
function insert_category($elastic_name, $type, $slug){
	$category = new Category;
    $category->elastic_name = $elastic_name;
    $category->type = $type;
    $category->slug = $slug;
    $category->save();
}

//Function to fetch Elastic category name from slug
function fetch_elastic_category($slug, $type){
	$category = Category::where('slug', '=', $slug)->where('type', '=', $type)->first();
	if($category) {
		$category->getElasticName();
	}
	else {
		return false;
	}
}

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