<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\ListingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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

    public function filtersWithCount(Request $request)
    {
        $params      = $request->all();
        $listingPage = new ListingPage($params);
        $apiResponse = $listingPage->generateSinglePageData(['filters_with_count', 'filters_without_count', 'search_string', 'sort_on']);
        return response()->json($apiResponse);
    }

    public function filtersWithoutCount(Request $request)
    {
        $apiResponse = Cache::rememberForever('list-filters', function () {
            $listingPage = new ListingPage([]);
            $apiResponse = $listingPage->generateSinglePageData(['filters_with_count', 'filters_without_count', 'search_string', 'sort_on']);
            return $apiResponse;
        });
        return response()->json($apiResponse);
    }
}
