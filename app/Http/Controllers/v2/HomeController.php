<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HomeController extends Controller
{
    public function options($all, Request $request, Response $response)
    {
        if(in_array($request->headers->get('Origin'),['https://www.kidsuperstore.in','http://www.kidsuperstore.in']))){
            
            $headers = [
                'Access-Control-Allow-Origin'      => config('app.angular_url'),
                'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers'     => 'Content-Type, Access-Control-Allow-Origin, Authorization',
                'Access-Control-Allow-Credentials' => 'true',
            ];
        }else{
            $headers = [
                'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers'     => 'Content-Type, Access-Control-Allow-Origin, Authorization',
            ];
        }

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
        return view('welcome');
    }

    public function newdraft(Request $request)
    {
        return view('home_new');
    }
}
