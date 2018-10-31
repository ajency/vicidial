<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
    	setSEO('home');
        return view('home');
    }

    public function api(Request $request)
    {
        return $request->user();
    }
}
