<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index($product_slug, $style_slug, $color_slug, Request $request)
    {
        
        $json = json_decode(singleproduct($product_slug, $style_slug, $color_slug));
        $params =  (array) $json;

        //print_r($params);
        //return view('singleproduct');
        return view('singleproduct')->with('params',$params);
    }
}
