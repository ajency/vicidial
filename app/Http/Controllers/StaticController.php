<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
    public function index($static_page, Request $request)
    {
    	$params = array();
    	$params['page'] = $static_page;
    	$params['query'] = $request->all();
        return view('shop')->with('params',$params);
    }

	public function contact(Request $request)
    {
    	setSEO();
        return view('contact-us');
    }

    public function contactnew(Request $request)
    {
    	setSEO();
        return view('contact');
    }

    public function faq(Request $request)
    {
    	setSEO();
        return view('faq');
    }

    public function about(Request $request)
    {
    	setSEO();
        return view('about-us');
    }

    public function tc(Request $request)
    {
    	setSEO();
        return view('terms-and-condition');
    }

}
