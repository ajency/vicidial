<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ListingController extends Controller
{
    public function search_object_old($parameters)
    {
        $search_object = create_search_object($parameters);
        if(isset($search_object->error) && $search_object->error == true) {
            return false;
        }

        $json = json_decode(listingproducts($search_object));

        $params =  (array) $json;

        return $params;
    }    

    public function index1($category_type, $gender, $age_group, $category_subtype, Request $request)
    {
        $parameters = array();
        $parameters['categories'] = array();
        $parameters['categories']['category_type'] = $category_type;
        $parameters['categories']['gender'] = $gender;
        $parameters['categories']['age_group'] = $age_group;
        $parameters['categories']['subtype'] = $category_subtype;

        $parameters['query'] = $request->all();

        $params = $this->search_object($parameters);
        if($params == false) return view('error404');

        return view('productlisting')->with('params',$params);
    }

    public function search_object($params = null,$search_obj = null)
    {
        $search_object = ($search_obj == null)?(build_search_object($params)):$search_obj;
        $params = Product::productList(["search_object" => $search_object]);
        return json_Decode(json_encode($params,JSON_FORCE_OBJECT));
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

        return view('productlisting')->with('params',$params);
    }

    public function shop(Request $request)
    {
        $parameters = array();
        $parameters['categories'] = array();
        $parameters['query'] = $request->all();

        $params = $this->search_object($parameters);

        return view('productlisting')->with('params',$params);
    }

    public function productList(Request $request)
    {
        $data = $request->all();
        $response = $this->search_object(null,$data["search_object"]);

        return response()->json($response,200);
    }


}
