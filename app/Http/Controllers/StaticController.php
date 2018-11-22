<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaticController extends Controller
{
	public function __construct()
    {
        $this->params['breadcrumb'] = array();
        $this->params['breadcrumb']['list']    = array();
        setSEO();
    }

    public function index($static_page, Request $request)
    {
    	$params = array();
    	$params['page'] = $static_page;
    	$params['query'] = $request->all();
        return view('shop')->with('params',$params);
    }

	public function contact(Request $request)
    {
    	$this->params['breadcrumb']['current'] = 'Contact Us';
        return view('contact-us')->with('params', $this->params);
    }

    public function contactnew(Request $request)
    {
    	$this->params['breadcrumb']['current'] = 'Contact Us';
        return view('contact')->with('params', $this->params);
    }

    public function faq(Request $request)
    {
    	$this->params['breadcrumb']['current'] = 'Faq';
        return view('faq')->with('params', $this->params);
    }

    public function about(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'About Us';
        return view('about-us')->with('params', $this->params);
    }

    public function tc(Request $request)
    {
    	$this->params['breadcrumb']['current'] = 'Terms and Conditions';
        return view('terms-and-conditions')->with('params', $this->params);
    }

    public function privacy(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'Privacy Policy';
        return view('privacy-policy')->with('params', $this->params);
    }

    public function stores(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'Stores';
        return view('stores')->with('params', $this->params);
    }

    public function singlestore(Request $request)
    {
        $this->params['breadcrumb']['current'] = 'Store';
        return view('store-single')->with('params', $this->params);
    }

}
