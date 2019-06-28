<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function options($all, Request $request)
    {
        $headers = [
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Content-Type, X-Auth-Token, Origin',
            'Access-Control-Allow-Origin'  => '*',
        ];

        return response('', 200)->withHeaders($headers);
    }

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
