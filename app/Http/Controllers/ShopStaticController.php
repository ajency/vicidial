<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopStaticController extends Controller
{
    public function index($static_page, Request $request)
    {
    	$params = array();
    	$params['page'] = $static_page;
    	$params['query'] = $request->all();
        return view('shop')->with('params',$params);
    }
}
