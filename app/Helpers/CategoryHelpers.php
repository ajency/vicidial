<?php
use App\Category;
use App\Facet;

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
		return $category->elastic_name;
	}
	else {
		return false;
	}
}

//Generate search object from url params
function create_search_object($parameters){
	$search_object = new stdClass;
	foreach ($parameters['categories'] as $type => $slugs) {
		$search_object->{$type} = array();
		$slugs_arr = explode('--', $slugs);
		foreach ($slugs_arr as $slug) {
			$elastic_name = fetch_elastic_category($slug, $type);
			if($elastic_name == false){
				$search_object->error = true;
				$search_object->error_string = $type;
				return $search_object;
			}
			else {
				$search_object->{$type}[] = $elastic_name;
			}
		}

	}

	return $search_object;
}


function build_search_object($params) {
	$all_facets = [];
	foreach($params['categories'] as $param) {
		$slugs_arr = explode('--', $param);
		$all_facets = array_merge($slugs_arr, $all_facets);
	}

	$facets = Facet::select('facet_name',DB::raw('group_concat(facet_value) as "values"'))->whereIn('slug', $all_facets)->groupBy('facet_name')->get();
	$search_result = [];
	foreach($facets as $facet){
		$search_result[$facet->facet_name] = explode(",", $facet->values);
	}
	// $facets_arr   = json_decode($facets, true);
	// $search_result = array_column($facets_arr, 'values',"facet_name");
	return $search_result;
}

function validate_category_urls($params){
	$all_facets = [];
	foreach($params['categories'] as $param) {
		$slugs_arr = explode('--', $param);
		$facets_data = Facet::select('facet_name',DB::raw('count(id) as "count"'))->whereIn('slug', $slugs_arr)->groupBy('facet_name')->get();
		print_r($facets_data);
		$max_count=0;
		foreach ($facets_data as $key => $facetcont) {
			if($key == 0)
				$max_count =  $facetcont->count;
			if($facetcont->count > $max_count){
				$max_count = $facetcont->count;
			}
		}
		if($max_count != count($slugs_arr))
			return false;
		$all_facets = array_merge($slugs_arr, $all_facets);

	}
	$facets_count = Facet::select('slug',DB::raw('count(id) as "count"'))->whereIn('slug', $all_facets)->groupBy('slug')->get();
	// print_r($facets_count);
	// echo "facets_count===".count($facets_count);
	// echo "all_facets===".count($all_facets);

	if(count($facets_count) != count($all_facets)){
		return false;
	}
	return true;
}

