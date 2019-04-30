<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\StaticElement;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $static_elements=StaticElement::fetch('home',[], $published=true);
        setSEO('home');
        return view('home')->with('static_elements', $static_elements);
    }
    
    public function drafthome(Request $request)
    {
        $static_elements=StaticElement::fetch('home',[]);
    	setSEO('home');
        return view('home')->with('static_elements', $static_elements);
    }

    public function api(Request $request)
    {
        return $request->user();
    }

    public function newhome(Request $request)
    {
        return view('home_new');
    }

    public function newdraft(Request $request)
    {
        return view('draft_new');
    }
    
    public function singleProduct($product_slug, Request $request)
    {
        return view('home_new');
    }
    
    public function shop(Request $request)
    {
        return view('home_new');
    }
}
