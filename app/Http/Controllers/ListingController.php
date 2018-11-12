<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Facet;
use DB;
class ListingController extends Controller
{
    public function search_object($params = null,$search_obj = null)
    {
        // print_r($params);
        if($search_obj == null){
            $valid = validate_category_urls($params);
            if($valid == false){
                return $valid;
            }
        }
        
        $search_object_arr = build_search_object($params);
        // $search_object = ($search_obj == null)?(build_search_object($params)):$search_obj;
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
        // $search_object=["product_age_group" =>["Others"]];
               // dd($search_object);
        $params = Product::productListPage(["search_object" => $search_object,"display_limit"=> 20,"page" =>1],$search_results["slug_value_search_result"],$search_results["slug_search_result"],$search_results["slugs_result"],$search_results["title"]);

        // dd($params);
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

    	$params = $this->search_object($parameters);
        if($params == false) return view('error404');
        if(empty((array)$params->filters)) return view('noproducts');
        
        $params->search_result_assoc = getFacetValueSlugPairs();
        // dd($search_result_assoc);
        return view('productlisting')->with('params',$params);
    }

    public function shop(Request $request)
    {
        $parameters = array();
        $parameters['categories'] = array();
        $parameters['query'] = $request->all();

        $params = $this->search_object($parameters);
        $params->search_result_assoc = getFacetValueSlugPairs();

        return view('productlisting')->with('params',$params);
    }

    public function productList(Request $request)
    {
        $data = $request->json()->all();
        // dd($data);
        $parameters = array();
        $params = explode("/",$data["listurl"]);
        $parameters['categories'] = array();
         // dd($params);
         foreach($params as $param){
            if($param != "")
                array_push($parameters['categories'], $param);
         }
        
       // dd($parameters);
        
        $response = $this->search_object($parameters,$data["search_object"]);
        // dd($response);
        return response()->json($response,200);
    }


}
