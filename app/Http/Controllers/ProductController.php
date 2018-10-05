<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index($product_slug, $style_slug, $color_slug, Request $request)
    {
        $params = $request->get('params');
        return view('singleproduct')->with('params',$params);
    }
}
