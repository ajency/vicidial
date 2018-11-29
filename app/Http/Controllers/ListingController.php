<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Facet;
use DB;
class ListingController extends Controller
{
    public function search_object($params,$page_params,$search_obj = null)
    {
        // print_r($params);
        if($search_obj == null){
            $valid = validate_category_urls($params);
            if($valid == false){
                return $valid;
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
        // dd($params_arr);
        $params = Product::productListPage($params_arr,$search_results["slug_value_search_result"],$search_results["slug_search_result"],$search_results["slugs_result"],$search_results["title"]);


        return json_decode(json_encode($params,JSON_FORCE_OBJECT));
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
        // dd($page_params);
    	$params = $this->search_object($parameters,$page_params);
        if($params == false) return view('error404');
        if(empty((array)$params->filters)) return view('noproducts');

        $params->search_result_assoc = getFacetValueSlugPairs();
        
        $params->show_search = (isset($parameters['query']['show_search']) && $parameters['query']['show_search'] == "true" )?true:false;
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

        $params = $this->search_object($parameters,$page_params);
        $params->search_result_assoc = getFacetValueSlugPairs();
        $params->show_search = (isset($parameters['query']['show_search']) && $parameters['query']['show_search'] == "true")?true:false;
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
        foreach($parsed_arr as $pvals){
            if (strpos($pvals, "pf=color:") !== false) {
                $values = str_replace('pf=color:', '', $pvals);
                $parameters['categories'] = array_merge($parameters['categories'],(explode(",",$values)));
            }
        }

        foreach($params as $param){
            if($param != ""){
                if (strpos($param, "pf=color:") !== false)
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else if (strpos($param, "rf=price:") !== false)
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else if (strpos($param, "bf=variant_availability:") !== false)
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else if (strpos($param, "sort_on=") !== false)
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else if (strpos($param, "search_string=") !== false) 
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else if (strpos($param, "show_search=") !== false) 
                    $p_val = preg_replace("/(\?.*)/", "", $param);
                else
                    $p_val = $param;
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
        $response = $this->search_object($parameters,$page_params,$data["search_object"]);
        return response()->json($response,200);
    }


}
