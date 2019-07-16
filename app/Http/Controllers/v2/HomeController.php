<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function options($all, Request $request)
    {
        if (Str::is('*chrome-extension*', $request->headers->get('Origin'))) {
            $headers = [
                'Access-Control-Allow-Origin'  => '*',
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers' => 'Content-Type, Access-Control-Allow-Origin, Authorization, X-Chrome-Extension',
            ];
            return response('', 200)->withHeaders($headers);
        }
        if (in_array($request->headers->get('Origin'), config('app.cors'))) {
            $headers = [
                'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers' => 'Content-Type, Access-Control-Allow-Origin, Authorization',
            ];
        } else {
            $headers = [
                'Access-Control-Allow-Origin'      => config('app.angular_url'),
                'Access-Control-Allow-Methods'     => 'POST, GET, OPTIONS, PUT, DELETE',
                'Access-Control-Allow-Headers'     => 'Content-Type, Access-Control-Allow-Origin, Authorization',
                'Access-Control-Allow-Credentials' => 'true',
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
