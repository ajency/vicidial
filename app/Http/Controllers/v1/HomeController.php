<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
    	setSEO('home');
        return view('home');
    }
    
    public function draftimage(Request $request)
    {
    	setSEO('home');
        return view('home');
    }

    public function api(Request $request)
    {
        return $request->user();
    }
}
