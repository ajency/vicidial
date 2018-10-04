<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Elasticsearch\ClientBuilder;
use Log;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        
        $json = json_decode(singleproduct());
        //$json = json_decode($this->fetchProduct(1636, 231));
        //echo "<pre>";
        //print_r($json);
        $params =  (array) $json;

        //print_r($params);
        //return view('singleproduct');
        return view('singleproduct')->with('params',$params);
    }
}
