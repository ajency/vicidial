<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index($category_type, $gender, $age_group, $category_subtype, Request $request)
    {
    	$parameters = array();
    	$parameters['categories'] = array();
    	$parameters['categories']['category_type'] = $category_type;
    	$parameters['categories']['gender'] = $gender;
    	$parameters['categories']['age_group'] = $age_group;
    	$parameters['categories']['subtype'] = $category_subtype;

    	$parameters['query'] = $request->all();

    	$search_object = create_search_object($parameters);
    	if(isset($search_object->error) && $search_object->error == true) {
    		return view('error404');
    	}

        $json = json_decode(listingproducts($search_object));
        $params =  (array) $json;

        return view('productlisting')->with('params',$params);
    }
}
