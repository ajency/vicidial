<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Ajency\Connections\ElasticQuery;
use Illuminate\Http\Request;

class ProductListTestController extends Controller
{
    public function index(Request $request)
    {
        // return view('singleproduct')->with('params',$params);
        $index = config('elastic.indexes.product');
        $q     = new ElasticQuery;
        $q->setIndex($index)
            ->setQuery(
                ["match_all" => [
                    "boost" => 1.0,
                ]]
            )
            ->setSource(["search_result_data.product_slug"])
            ->setSize(10000);

        $response = $q->search();
        $links    = [];
        foreach ($response["hits"]["hits"] as $item) {
            $links[] = url('/') . "/" . $item["_source"]["search_result_data"]["product_slug"] . "/buy";
        }
        return view('testproductlist')->with('links', $links);
    }
}
