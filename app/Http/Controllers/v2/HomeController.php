<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\StaticElement;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $static_elements = StaticElement::fetch('home', [], $published = true);
        setSEO('home');
        return view('home')->with('static_elements', $static_elements);
    }

    public function drafthome(Request $request)
    {
        $static_elements = StaticElement::fetch('home', []);
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
        return view('home_new');
    }
}
