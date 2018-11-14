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
	$dataArr = [];
	$dataArr["search_result"]=[];
	foreach($params['categories'] as $param) {
		$slugs_arr = explode('--', $param);
		$all_facets = array_merge($slugs_arr, $all_facets);
	}
	if(isset($params["query"])){
		foreach($params["query"] as $queryk => $queryv){
			if($queryk == "pf"){
				if (strpos($queryv, "color:") !== false) {
	                $values = str_replace('color:', '', $queryv); 
	                $all_facets = array_merge($all_facets,(explode(",",$values)));
	            }
			}
			if($queryk == "rf"){
				if (strpos($queryv, "price:") !== false) {
	                $values = str_replace('price:', '', $queryv); 
	                $min_max_arr =explode("TO",$values);
	                $dataArr["search_result"]["range_filter"]=["min"=>$min_max_arr[0],"max"=>$min_max_arr[1]];
	            }
			}
		}
	}
	else{
		$dataArr["search_result"]["range_filter"]=[];
	}
	
	// dd($all_facets);
	$facets_count = Facet::select('facet_value',DB::raw('count(id) as "count",group_concat(facet_name) as "names"'))->whereIn('slug', $all_facets)->groupBy('facet_value')->get();
	// dd(array_column($facets_count, 'count', 'facet_value'));
	// $facets_count_link = array_column($facets_count, 'count', 'facet_value');
	$facets_count_link = [];
	$facet_display_data = config('product.facet_display_data');
	$facet_display_data_keys = array_keys($facet_display_data);
	foreach($facets_count as $focuntv){
		$focuntv_names = explode(",",$focuntv->names);
		$f_arr = [];
		foreach($focuntv_names as $fcname){
			$fval = array_search($fcname,$facet_display_data_keys);
			array_push($f_arr, $fval);
		}

		$facets_count_link[$focuntv->facet_value] = $facet_display_data_keys[$f_arr[0]];
	}
	
	// dd($facets_count_link);
	$facets = Facet::select('facet_name',DB::raw('group_concat(facet_value) as "values",group_concat(slug) as "slugs",group_concat(concat(slug,"$$$",facet_value)) as "slugvalues"'))->whereIn('slug', $all_facets)->groupBy('facet_name')->get();
	$search_result = [];
	$slug_search_result = [];
	$slug_value_search_result = [];
	$slugs_result = [];
	foreach($facets as $facet){
		$fvalues = explode(",", $facet->values);
		foreach($fvalues as $fvaluesv){
			if($facets_count_link[$fvaluesv] != $facet->facet_name ){
				$ind = array_search($fvaluesv, $fvalues);
				unset($fvalues[$ind]);
			}
		}
		if(count($fvalues)>0)
			$search_result[$facet->facet_name] = $fvalues;
		$slugs_result[$facet->facet_name] = explode(",", $facet->slugs);
		$slug_values = explode(",", $facet->slugvalues);
		foreach($slug_values as $slugval){
			$slugval_arr = explode("$$$",$slugval);
			$slug_value_search_result[$slugval_arr[0]] = ["facet_name" => $facet->facet_name,"facet_value" => $slugval_arr[1]];
			$slug_search_result[$slugval_arr[0]] = $facet->facet_name;
		}
	}
	// $facets_arr   = json_decode($facets, true);
	// $search_result = array_column($facets_arr, 'values',"facet_name");
	
	
	$dataArr["slug_search_result"] =$slug_search_result;
	$dataArr["slug_value_search_result"] =$slug_value_search_result;
	$dataArr["search_result"]["primary_filter"]=$search_result;
	$dataArr["slugs_result"] =$slugs_result;
	$dataArr["title"] = generateProductListTitle($params['categories'],$slug_value_search_result);
	return $dataArr;
}

function validate_category_urls($params){
	$all_facets = [];
	$all_unique_cat_facets = [];
	$facet_display_data = config('product.facet_display_data');
	foreach($params['categories'] as $param) {
		$slugs_arr = explode('--', $param);
		$facets_data = Facet::select('facet_name',DB::raw('count(id) as "count"'))->whereIn('slug', $slugs_arr)->groupBy('facet_name')->get();
		// print_r($facets_data);
		$max_count=0;
		foreach ($facets_data as $key => $facetcont) {
			if($key == 0)
				$max_count =  $facetcont->count;
			if($facetcont->count > $max_count){
				$max_count = $facetcont->count;
			}
			if($facet_display_data[$facetcont->facet_name]["is_singleton"] == true && count($slugs_arr)>1)
				return false;
		}
		if($max_count != count($slugs_arr))
			return false;
		$all_facets = array_merge($slugs_arr, $all_facets);
		array_push($all_unique_cat_facets,$slugs_arr[0]);

	}
	$facets_count = Facet::select('slug',DB::raw('count(id) as "count"'))->whereIn('slug', $all_facets)->groupBy('slug')->get();
	// print_r($facets_count);
	// echo "facets_count===".count($facets_count);
	// echo "all_facets===".count($all_facets);

	if(count($facets_count) != count($all_facets)){
		return false;
	}

	$facets_data = Facet::select('slug',DB::raw('group_concat(facet_name) as "facet_names"'))->whereIn('slug', $all_unique_cat_facets)->groupBy('slug')->get();
	$all_facets_arr=[];
	foreach($facets_data as $key => $facet){
		if($key == 0)
			$all_facets_arr = array_merge($all_facets_arr,explode(',',$facet->facet_names));
		else{
			$fn_arr = explode(',',$facet->facet_names);
			$common_arr = array_intersect($all_facets_arr, $fn_arr);
			// print_r($common_arr);
			if(count($common_arr)>0){
				return false;
			}
			$all_facets_arr = array_merge($all_facets_arr,$fn_arr);
		}
	}

	return true;
}



function generateProductListTitle($categories,$slug_name_value_arr){
	$titile = "Fashion at KSS";

	switch(count($categories)){
		case 1:
			$cat1 = explode("--", $categories[0]);
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type")
				$titile = $slug_name_value_arr[$cat1[0]]["facet_value"]." at KSS";
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_age_group" || $slug_name_value_arr[$cat1[0]]["facet_name"] == "product_gender")
				$titile = $slug_name_value_arr[$cat1[0]]["facet_value"]." fashion store";
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_subtype")
				$titile = $slug_name_value_arr[$cat1[0]]["facet_value"]." at KSS";
			break;
		case 2:
			$cat1 = explode("--", $categories[0]);
			$cat2 = explode("--", $categories[1]);
			if(($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender") || ($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group"))
				$titile = $slug_name_value_arr[$cat1[0]]["facet_value"]." for ".$slug_name_value_arr[$cat2[0]]["facet_value"];
			if(($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender") || ($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group"))
				$titile = $slug_name_value_arr[$cat1[0]]["facet_value"]."-".$slug_name_value_arr[$cat2[0]]["facet_value"]." fashion store";
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_subtype")
				$titile = $slug_name_value_arr[$cat1[0]]["facet_value"]." at KSS";
			break;		
		case 3:
			$cat1 = explode("--", $categories[0]);
			$cat2 = explode("--", $categories[1]);
			$cat3 = explode("--", $categories[2]);
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_gender")
				$titile = $slug_name_value_arr[$cat1[0]]["facet_value"]." for ".$slug_name_value_arr[$cat2[0]]["facet_value"]."-".$slug_name_value_arr[$cat3[0]]["facet_value"];
			if(($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype") || ($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype"))
				$titile = $slug_name_value_arr[$cat3[0]]["facet_value"]." for ".$slug_name_value_arr[$cat2[0]]["facet_value"];
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype")
				$titile = $slug_name_value_arr[$cat3[0]]["facet_value"]." for ".$slug_name_value_arr[$cat1[0]]["facet_value"]."-".$slug_name_value_arr[$cat2[0]]["facet_value"];
			break;		
		case 4:
			$cat1 = explode("--", $categories[0]);
			$cat2 = explode("--", $categories[1]);
			$cat3 = explode("--", $categories[2]);
			$cat4 = explode("--", $categories[3]);
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype")
				$titile = $slug_name_value_arr[$cat4[0]]["facet_value"]." for ".$slug_name_value_arr[$cat2[0]]["facet_value"]."-".$slug_name_value_arr[$cat3[0]]["facet_value"];
			break;
		default:
			$titile = "Fashion at KSS";
	}

	return $titile;
}


function getFacetValueSlugPairs(){
	$facets = Facet::select('facet_name',DB::raw('group_concat(concat(facet_value,"$$$",slug)) as "values"'))->groupBy('facet_name')->get();
    $search_result_assoc = [];
    foreach($facets as $facet){
        $comb = explode(",", $facet->values);
        $facet_values = [];
        $facet_value_slug_pairs = [];
        foreach($comb as $combv){
            $cmbvalue = explode("$$$", $combv);
            array_push($facet_values, $cmbvalue[0]);
            $facet_value_slug_pairs[$cmbvalue[0]]=$cmbvalue[1];
        }
        $search_result_assoc[$facet->facet_name] = $facet_value_slug_pairs;
    }
    return $search_result_assoc;
}
