<?php
use App\Facet;

function build_search_object($params) {
	$all_facets = [];
	$dataArr = [];
	$facet_display_data = config('product.facet_display_data');
	$dataArr["search_result"]=[];
	$dataArr["search_result"]["boolean_filter"]=[];
	// dd($params);
	foreach($params['categories'] as $param) {
		$slugs_arr = explode('--', $param);
		$all_facets = array_merge($slugs_arr, $all_facets);
	}
	if(isset($params["query"])){
		foreach($params["query"] as $queryk => $queryv){
			if($queryk == "pf"){
				$queryval = explode("|",$queryv);
				$primary_filters = array_filter($facet_display_data, function ($value) {
				    return ($value['filter_type'] == 'primary_filter');
				});
				$attr_param_arr = array_column($primary_filters,"attribute_param");
				foreach($queryval as $queryvalv){
					$querry_value_pairs = explode(":", $queryvalv);
					if (count($querry_value_pairs)>1 && in_array($querry_value_pairs[0], $attr_param_arr)) {

						$ar = array_filter($facet_display_data, function ($item) use ($querry_value_pairs) {
						        return $item['attribute_param'] === $querry_value_pairs[0];
						    }
						); 
						$ar_keys_ar = array_keys($ar);
		                $values = str_replace($querry_value_pairs[0].':', '', $queryvalv); 
		                $all_facets = array_merge($all_facets,(explode(",",$values)));
		            }

				}
			}
			if($queryk == "bf"){
				$queryval = explode("|",$queryv);
				$bool_filters = array_filter($facet_display_data, function ($value) {
				    return ($value['filter_type'] == 'boolean_filter');
				});

				$attr_param_arr = array_column($bool_filters,"attribute_param");
				foreach($queryval as $queryvalv){
					$querry_value_pairs = explode(":", $queryvalv);
					if (count($querry_value_pairs)>1 && in_array($querry_value_pairs[0], $attr_param_arr)) {

						$ar = array_filter($facet_display_data, function ($item) use ($querry_value_pairs) {
						        return $item['attribute_param'] === $querry_value_pairs[0];
						    }
						); 
						$ar_keys_ar = array_keys($ar);
		                $values = str_replace($querry_value_pairs[0].':', '', $queryvalv); 
		                $values_arr = explode(",",$values);
		                $bool_val=false;
		                if(is_string($values_arr[0]) && $values_arr[0] != "skip")
		                	$bool_val =($values_arr[0] == "true")?true:false;
		                else
		                	$bool_val =$values_arr[0];
		                $dataArr["search_result"]["boolean_filter"][$ar_keys_ar[0]]=$bool_val;
		            }

				}
				
			}
			if($queryk == "rf"){
				if (strpos($queryv, "price:") !== false) {
					$ar = array_filter($facet_display_data, function ($item) {
					        return $item['attribute_param'] === 'price';
					    }
					); 
					$ar_keys_ar = array_keys($ar);
	                $values = str_replace('price:', '', $queryv); 
	                $min_max_arr =explode("TO",$values);
	                $dataArr["search_result"]["range_filter"][$ar_keys_ar[0]]=["min"=>$min_max_arr[0],"max"=>$min_max_arr[1]];
	            }
			}
			if($queryk == "search_string"){
				$dataArr["search_result"][$queryk]=$queryv;
			}
		}
	}
	else{
		$dataArr["search_result"]["range_filter"]=[];
		$dataArr["search_result"]["boolean_filter"]=[];
	}

	if(isset($params["sort_on"]))
		$dataArr["sort_on"]=$params["sort_on"];

	
	// dd($all_facets);
	$facets_count = Facet::select('facet_value',DB::raw('count(id) as "count",facet_name'))->whereIn('slug', $all_facets)->groupBy('facet_value','facet_name')->get();
	// dd(array_column($facets_count, 'count', 'facet_value'));
	// $facets_count_link = array_column($facets_count, 'count', 'facet_value');
	$facets_count_link = [];
	
	
	$facet_display_data_keys = array_keys($facet_display_data);
	foreach($facets_count as $focuntv){
		$fval = array_search($focuntv->facet_name,$facet_display_data_keys);
		if(!isset($facets_count_link[$focuntv->facet_value]))
			$facets_count_link[$focuntv->facet_value] = [$facet_display_data_keys[$fval]];
		else
			array_push($facets_count_link[$focuntv->facet_value] , $facet_display_data_keys[$fval]);
	}
	
	// dd($facets_count_link);
	$facets = Facet::select('facet_name',DB::raw('group_concat(facet_value) as "values",group_concat(display_name) as "display_names", group_concat(slug) as "slugs",group_concat(concat(slug,"$$$",facet_value)) as "slugvalues"'))->whereIn('slug', $all_facets)->groupBy('facet_name')->get();
	$search_result = [];
	$slug_search_result = [];
	$slug_value_search_result = [];
	$slugs_result = [];
	foreach($facets as $facet){
		$fvalues = explode(",", $facet->values);
		foreach($fvalues as $fvaluesv){
			if(!in_array($facet->facet_name, $facets_count_link[$fvaluesv])){
				$ind = array_search($fvaluesv, $fvalues);
				unset($fvalues[$ind]);
			}
		}
		if(count($fvalues)>0)
			$search_result[$facet->facet_name] = $fvalues;
		$slugs_result[$facet->facet_name] = explode(",", $facet->slugs);
		$slug_values = explode(",", $facet->slugvalues);
		$disp_names = explode(",", $facet->display_names);
		foreach($slug_values as $key => $slugval){
			$slugval_arr = explode("$$$",$slugval);
			$slug_value_search_result[$slugval_arr[0]] = ["facet_name" => $facet->facet_name,"facet_value" => $slugval_arr[1], "display_name" => $disp_names[$key]];
			$slug_search_result[$slugval_arr[0]] = $facet->facet_name;
		}
	}

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
		$slug_filters = array_filter(config('product.facet_display_data'), function ($value) {
			return ($value['is_attribute_param'] == false);
		});
		$facets_data = Facet::select('facet_name',DB::raw('count(id) as "count"'))->whereIn('slug', $slugs_arr)->whereIn('facet_name', array_keys($slug_filters))->groupBy('facet_name')->get();
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
				$titile = $slug_name_value_arr[$cat1[0]]["display_name"]." at KSS";
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_age_group" || $slug_name_value_arr[$cat1[0]]["facet_name"] == "product_gender")
				$titile = $slug_name_value_arr[$cat1[0]]["display_name"]." fashion store";
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_subtype")
				$titile = $slug_name_value_arr[$cat1[0]]["display_name"]." at KSS";
			break;
		case 2:
			$cat1 = explode("--", $categories[0]);
			$cat2 = explode("--", $categories[1]);
			if(($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender") || ($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group"))
				$titile = $slug_name_value_arr[$cat1[0]]["display_name"]." for ".$slug_name_value_arr[$cat2[0]]["display_name"];
			if(($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender") || ($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group"))
				$titile = $slug_name_value_arr[$cat1[0]]["display_name"]."-".$slug_name_value_arr[$cat2[0]]["display_name"]." fashion store";
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_subtype")
				$titile = $slug_name_value_arr[$cat1[0]]["display_name"]." at KSS";
			break;		
		case 3:
			$cat1 = explode("--", $categories[0]);
			$cat2 = explode("--", $categories[1]);
			$cat3 = explode("--", $categories[2]);
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_gender")
				$titile = $slug_name_value_arr[$cat1[0]]["display_name"]." for ".$slug_name_value_arr[$cat2[0]]["display_name"]."-".$slug_name_value_arr[$cat3[0]]["display_name"];
			if(($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype") || ($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype"))
				$titile = $slug_name_value_arr[$cat3[0]]["display_name"]." for ".$slug_name_value_arr[$cat2[0]]["display_name"];
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype")
				$titile = $slug_name_value_arr[$cat3[0]]["display_name"]." for ".$slug_name_value_arr[$cat1[0]]["display_name"]."-".$slug_name_value_arr[$cat2[0]]["display_name"];
			break;		
		case 4:
			$cat1 = explode("--", $categories[0]);
			$cat2 = explode("--", $categories[1]);
			$cat3 = explode("--", $categories[2]);
			$cat4 = explode("--", $categories[3]);
			if($slug_name_value_arr[$cat1[0]]["facet_name"] == "product_category_type" && $slug_name_value_arr[$cat2[0]]["facet_name"] == "product_age_group" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_gender" && $slug_name_value_arr[$cat3[0]]["facet_name"] == "product_subtype")
				$titile = $slug_name_value_arr[$cat4[0]]["display_name"]." for ".$slug_name_value_arr[$cat2[0]]["display_name"]."-".$slug_name_value_arr[$cat3[0]]["display_name"];
			break;
		default:
			$titile = "Fashion at KSS";
	}

	return $titile;
}


function getFacetValueSlugPairs(){
	$facets = Facet::select('facet_name',DB::raw('group_concat(facet_value) as "facet_values",group_concat(slug) as "slugs"'))->groupBy('facet_name')->get();
    $search_result_assoc = [];
    foreach($facets as $facet){
        $facet_values = explode(",", $facet->facet_values);
        $facet_slugs = explode(",", $facet->slugs);
        $facet_value_slug_pairs = [];
        foreach($facet_values as $facet_valuesk => $facet_valuesv){
            $facet_value_slug_pairs[$facet_valuesv]=$facet_slugs[$facet_valuesk];
        }
        $search_result_assoc[$facet->facet_name] = $facet_value_slug_pairs;
    }
    // dd($search_result_assoc);
    return $search_result_assoc;
}


function getFacetValueSize(){
	$facets = Facet::select(['facet_value', 'display_name', 'slug', 'sequence'])->where('facet_name','variant_size_name')->get();
    $search_result_assoc = [];
    $facet_value_slug_pairs = [];
    foreach($facets as $facet){
        $facet_value_slug_pairs[$facet['facet_value']] = array('display_name' => $facet['display_name'], 'slug' => $facet['slug'], 'sequence' => $facet['sequence']);
    }
    
    return $facet_value_slug_pairs;
}
