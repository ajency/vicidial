<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\ListingPage;
use Illuminate\Http\Request;

class ListingController extends Controller
{

    public function index($cat1, $cat2 = null, $cat3 = null, $cat4 = null, $cat5 = null, Request $request)
    {
        return view('home_new');
    }

    public function shop(Request $request)
    {
        return view('home_new');
    }

    public function productList(Request $request)
    {
        $params      = $request->all();
        $listingPage = new ListingPage($params);
        $apiResponse = $listingPage->generateSinglePageData(['items', 'page', 'headers', 'results_found']);
        return response()->json($apiResponse);
    }

}
