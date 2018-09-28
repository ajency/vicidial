<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function index(Request $request)
    {
        $json = json_decode(singleproduct());
        //echo "<pre>";
        //print_r($json);
        $params =  (array) $json;

        //print_r($params);
        //return view('singleproduct');
        return view('singleproduct')->with('params',$params);
    }
}
