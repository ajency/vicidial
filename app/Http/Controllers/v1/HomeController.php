<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\StaticElement;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $static_elements=StaticElement::fetch([], $published=true);
        setSEO('home');
        return view('home')->with('static_elements', $static_elements);
    }
    
    public function drafthome(Request $request)
    {
        $static_elements=StaticElement::fetch([]);
    	setSEO('home');
        return view('home')->with('static_elements', $static_elements);
    }

    public function api(Request $request)
    {
        return $request->user();
    }
}
