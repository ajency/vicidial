<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Facet;
use DB;
class ListingController extends Controller
{
    public function search_object($params,$page_params,$search_obj = null)
    {
        if($search_obj == null){
            $valid = validate_category_urls($params);
            if($valid == false){
                abort(404);
            }
        }

        $search_object_arr = build_search_object($params);
        $search_results = [];
        if($search_obj == null){
            $search_object = $search_object_arr["search_result"];
        }
        else{
            $search_object = $search_obj;
        }
        $search_results["slug_search_result"] = $search_object_arr["slug_search_result"];
        $search_results["slug_value_search_result"] = $search_object_arr["slug_value_search_result"];
        $search_results["slugs_result"] = $search_object_arr["slugs_result"];
        $search_results["title"] = $search_object_arr["title"];
        if(!isset($page_params["display_limit"]))
            $page_params["display_limit"] = config('product.list_page_display_limit');

        $params_arr = ["search_object" => $search_object,"display_limit"=> $page_params["display_limit"],"page" =>$page_params["page"]];
        if(isset($page_params["sort_on"]))
            $params_arr["sort_on"]=$page_params["sort_on"];
        if(isset($page_params["exclude_in_response"]))
            $params_arr["exclude_in_response"] = $page_params["exclude_in_response"];

        $params = Product::productListPage($params_arr,$search_results["slug_value_search_result"],$search_results["slug_search_result"],$search_results["slugs_result"],$search_results["title"]);

        return ["result"=>json_decode(json_encode($params,JSON_FORCE_OBJECT)),"slug_value_search_result"=>$search_results["slug_value_search_result"]];
    }

    public function index($cat1, $cat2 = null, $cat3 = null, $cat4 = null, Request $request)
    {
    	$parameters = array();
    	$parameters['categories'] = array();
        array_push($parameters['categories'], $cat1);
        if($cat2 != null ) array_push($parameters['categories'], $cat2);
        if($cat3 != null ) array_push($parameters['categories'], $cat3);
        if($cat4 != null ) array_push($parameters['categories'], $cat4);
    	$parameters['query'] = $request->all();
        $page_params = [];
        $page_params["page"] = (isset($parameters['query']['page']))?$parameters['query']['page']:1;
        if(isset($parameters['query']['sort_on']))
            $page_params["sort_on"] = $parameters['query']['sort_on'];
        if(isset($parameters['query']['exclude_in_response']))
            $page_params["exclude_in_response"]=$parameters['query']['exclude_in_response'];

        $search_data = $this->search_object($parameters,$page_params);
    	$params = $search_data["result"];
        $params->slug_value_search_result = $search_data["slug_value_search_result"];

        if(empty((array)$params->filters)) return view('noproducts');

        $params->search_result_assoc = getFacetValueSlugPairs();
        
        if(isset($parameters['query']['show_search']))
            $params->show_search = (isset($parameters['query']['show_search']) && $parameters['query']['show_search'] == "true" )?true:false;
        else
            $params->show_search = config('product.show_list_search');
        $params->page_val = $page_params["page"];
        $params->pagination = config('product.pagination');
        return view('productlisting')->with('params',$params);
    }

    public function shop(Request $request)
    {
        $parameters = array();
        $parameters['categories'] = array();
        $parameters['query'] = $request->all();
        $page_params = [];
        $page_params["page"] = (isset($parameters['query']['page']))?$parameters['query']['page']:1;
        if(isset($parameters['query']['sort_on']))
            $page_params["sort_on"] = $parameters['query']['sort_on'];
        if(isset($parameters['query']['exclude_in_response']))
            $page_params["exclude_in_response"]=$parameters['query']['exclude_in_response'];

        $search_data = $this->search_object($parameters,$page_params);
        $params = $search_data["result"];
        $params->slug_value_search_result = $search_data["slug_value_search_result"];
        $params->search_result_assoc = getFacetValueSlugPairs();

        if(isset($parameters['query']['show_search']))
            $params->show_search = (isset($parameters['query']['show_search']) && $parameters['query']['show_search'] == "true" )?true:false;
        else
            $params->show_search = config('product.show_list_search');
        $params->page_val = $page_params["page"];
        $params->pagination = config('product.pagination');
        // dd($page_params["page"]);
        return view('productlisting')->with('params',$params);
    }

    public function productList(Request $request)
    {
        $data = $request->json()->all();
        $parameters = array();
        $params = explode("/",$data["listurl"]);
        $parameters['categories'] = array();
        $parseurl=parse_url($data["listurl"], PHP_URL_QUERY);
        $parsed_arr = explode("&", $parseurl);
        $page_params = [];
        $primary_filters = array_filter(config('product.facet_display_data'), function ($value) {
            return ($value['filter_type'] == 'primary_filter');
        });

        $primary_attr_param_arr = array_column($primary_filters,"attribute_param");
        foreach($parsed_arr as $pvals){
            $pfilter = explode("=",$pvals);
            if($pfilter[0] == "pf"){
                $queryval = explode("|",$pfilter[1]);
                foreach($queryval as $queryvalv){
                    $querry_value_pairs = explode(":", $queryvalv);
                    if (count($querry_value_pairs)>1 && in_array($querry_value_pairs[0], $primary_attr_param_arr)) {

                        $ar = array_filter(config('product.facet_display_data'), function ($item) use ($querry_value_pairs) {
                                return $item['attribute_param'] === $querry_value_pairs[0];
                            }
                        ); 
                        $ar_keys_ar = array_keys($ar);
                        $values = str_replace($querry_value_pairs[0].':', '', $queryvalv); 
                        $parameters['categories'] = array_merge($parameters['categories'],(explode(",",$values)));
                    }

                }
                
            }
        }

        $bool_filters = array_filter(config('product.facet_display_data'), function ($value) {
            return ($value['filter_type'] == 'boolean_filter');
        });

        $attr_param_arr = array_column($bool_filters,"attribute_param");
        
        
        foreach($params as $param){      
            if($param != ""){
                if (strpos($param, "rf=price:") !== false)
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else if (strpos($param, "bf=") !== false) 
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else if (strpos($param, "pf=") !== false) 
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else if (strpos($param, "sort_on=") !== false)
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else if (strpos($param, "search_string=") !== false) 
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else if (strpos($param, "show_search=") !== false) 
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else{
                    $case_done = false;
                    foreach($attr_param_arr as $attr_param){
                        if (strpos($param, $attr_param.":") !== false) {
                            $p_val = preg_replace("/(\?.*)/", "", $param);
                            $case_done = true;
                        }
                    }
                    foreach($primary_attr_param_arr as $primary_attr_param){
                        if (strpos($param, $primary_attr_param.":") !== false) {
                            $p_val = preg_replace("/(\?.*)/", "", $param);
                            $case_done = true;
                        }
                    }
                    if(!$case_done)
                        $p_val = $param;
                }
                if (strpos($param, "search_string=") === false) 
                    array_push($parameters['categories'], $p_val);
            }
         }

        if(isset($data["display_limit"]))
            $page_params["display_limit"] = $data["display_limit"];
        if(isset($data["sort_on"]))
            $page_params["sort_on"] = $data["sort_on"];
        if(isset($data['exclude_in_response']))
            $page_params["exclude_in_response"]=$data['exclude_in_response'];
        $page_params["page"] = $data["page"];
        $search_data = $this->search_object($parameters,$page_params,$data["search_object"]);
        $response = $search_data["result"];

        return response()->json($response,200);
    }


}
