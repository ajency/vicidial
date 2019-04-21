<?php
use App\Facet;

function generateProductListTitle($params,$facets){
	$title = "Fashion at KSS";
	return $title;
	if (!isset($params['primary_filter'])) {
		return $title;
	}
	$facets["product_category_type"]->keyBy('facet_value')['Test']->display_name;

	switch(count($params['primary_filter'])) {
		case 1:
			if(isset($params['primary_filter']['product_category_type']))
				$title = $facets["product_category_type"]->keyBy('facet_value')[$params['primary_filter']['product_category_type'][0]]->display_name." at KSS";
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_age_group" || $slug_name_value_arr[$cat1[0]]["facet_name"] == "product_gender" || $slug_name_value_arr[$cat1[0]]["facet_name"] == "product_brand")
				$title = $slug_name_value_arr[$cat1[0]]["display_name"]." fashion store";
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_subtype")
				$title = $slug_name_value_arr[$cat1[0]]["display_name"]." at KSS";
			break;
		case 2:
			$cat1 = explode("--", $categories[0]);
			$cat2 = explode("--", $categories[1]);
			if(($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender") || ($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group"))
				$title = $slug_name_value_arr[$cat1[0]]["display_name"]." for ".$slug_name_value_arr[$cat2[0]]["display_name"];
			if(($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender") || ($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group"))
				$title = $slug_name_value_arr[$cat1[0]]["display_name"]."-".$slug_name_value_arr[$cat2[0]]["display_name"]." fashion store";
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_subtype")
				$title = $slug_name_value_arr[$cat1[0]]["display_name"]." at KSS";
			break;
		case 3:
			$cat1 = explode("--", $categories[0]);
			$cat2 = explode("--", $categories[1]);
			$cat3 = explode("--", $categories[2]);
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_gender")
				$title = $slug_name_value_arr[$cat1[0]]["display_name"]." for ".$slug_name_value_arr[$cat2[0]]["display_name"]."-".$slug_name_value_arr[$cat3[0]]["display_name"];
			if(($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype") || ($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype"))
				$title = $slug_name_value_arr[$cat3[0]]["display_name"]." for ".$slug_name_value_arr[$cat2[0]]["display_name"];
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype")
				$title = $slug_name_value_arr[$cat3[0]]["display_name"]." for ".$slug_name_value_arr[$cat1[0]]["display_name"]."-".$slug_name_value_arr[$cat2[0]]["display_name"];
			break;
		case 4:
			$cat1 = explode("--", $categories[0]);
			$cat2 = explode("--", $categories[1]);
			$cat3 = explode("--", $categories[2]);
			$cat4 = explode("--", $categories[3]);
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype")
				$title = $slug_name_value_arr[$cat4[0]]["display_name"]." for ".$slug_name_value_arr[$cat2[0]]["display_name"]."-".$slug_name_value_arr[$cat3[0]]["display_name"];
			break;
		case 5:
			$cat1 = explode("--", $categories[0]);
			$cat2 = explode("--", $categories[1]);
			$cat3 = explode("--", $categories[2]);
			$cat4 = explode("--", $categories[3]);
			$cat5 = explode("--", $categories[4]);
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype")
				$title = $slug_name_value_arr[$cat4[0]]["display_name"]." for ".$slug_name_value_arr[$cat2[0]]["display_name"]."-".$slug_name_value_arr[$cat3[0]]["display_name"];
			break;
		default:
			$title = "Fashion at KSS";
	}

	return $title;
}

function getFacetDetails($facets)
{
    $facets = Facet::orWhere(function ($q) use ($facets) {
        foreach ($facets as $facet) {
            $q->orWhere([['facet_name', $facet['facet_name']], ['facet_value', $facet['facet_value']]]);
        }
    })->get()->groupBy('facet_name')->toArray();

    $search_result_assoc    = [];
    $facet_value_slug_pairs = [];

    foreach ($facets as $key => $facet) {
        foreach ($facet as $single_facet) {
            $facet_value_slug_pairs[$single_facet['facet_name']][$single_facet['facet_value']] = array('display_name' => $single_facet['display_name'], 'slug' => $single_facet['slug'], 'sequence' => $single_facet['sequence']);
        }
    }
    return $facet_value_slug_pairs;
}