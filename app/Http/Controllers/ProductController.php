<?php

namespace App\Http\Controllers;

use App\ProductColor;
use App\Product;
use App\Facet;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index($product_slug, Request $request)
    {
        $json = json_decode(singleproduct($product_slug));
        $params =  (array) $json;

        $query  = $request->all();

        if (isset($query['size'])) {
            foreach ($params['variant_group']->{$params['selected_color_id']}->variants as $size_set) {
                if ($query['size'] == $size_set->size->name && $size_set->inventory_available) {
                    $params['size'] = $query['size'];
                }
            }
        }

        $params['breadcrumb']           = array();
        $params['breadcrumb']['list']   = array();
        $url = array();
        $breadcrumb = config('product.breadcrumb_order');
        foreach ($breadcrumb as $category) {
            $facet = Facet::where('facet_name', '=', $category)->where('facet_value', '=', $params['category']->{$category})->first();
            $url[] = $facet->slug;
            $params['breadcrumb']['list'][] = ['name' => $facet->display_name, 'href' => create_url($url)];
        }

        $params['breadcrumb']['current'] = '';

        setSEO('product', $params);

        $search_object = [
          "boolean_filter" => [],
          "primary_filter" => [
            "product_category_type" => ["Apparels"]
          ]
        ];
        // dd($params);
        $similar_cat_params=[];
        $similar_cat_params['categories'] = ["apparels"];
        $search_object_arr = build_search_object($similar_cat_params);
        // dd($search_object_arr);
        // $search_object = ($search_obj == null)?(build_search_object($params)):$search_obj;
        $search_results = [];

        $search_object = $search_object_arr["search_result"];

        $search_results["slug_search_result"] = $search_object_arr["slug_search_result"];
        $search_results["slug_value_search_result"] = $search_object_arr["slug_value_search_result"];
        $search_results["slugs_result"] = $search_object_arr["slugs_result"];
        $search_results["title"] = $search_object_arr["title"];
        $similar_products_display_limit = config('product.similar_products_display_limit');
        // echo "similar_products_display_limit==".$similar_products_display_limit;
        $parameters = Product::productListPage(["search_object" => $search_object,"display_limit"=> ($similar_products_display_limit+1),"page" =>1],$search_results["slug_value_search_result"],$search_results["slug_search_result"],$search_results["slugs_result"],$search_results["title"]);

        // dd($parameters);
        $similar_data_params= json_decode(json_encode($parameters,JSON_FORCE_OBJECT));

        return view('singleproduct')->with('params', $params)->with('similar_data_params', $similar_data_params);
    }

    public function getImage($photo_id, $preset, $depth, $filename)
    {
        $path         = public_path() . 'img/' . $filename;
        $productColor = ProductColor::join('fileupload_mapping', function ($join) {
            $join->on('product_colors.id', '=', 'fileupload_mapping.object_id');
            $join->where('fileupload_mapping.object_type', '=', "App\ProductColor");
        })->where('fileupload_mapping.file_id', $photo_id)->select('product_colors.*')->first();
        // $productColor = ProductColor::where('elastic_id', $elastic_id)->first();
        if($productColor == null) abort(404);
        $imageurl     = "";
        $file         = $productColor->getSingleImage($photo_id,$preset, $depth);
        if ($file) {
            $imageurl = $file;
        } else {
            $imageurl = $productColor->resizeImages($photo_id,$preset, $depth, $filename);
        }
        return \Redirect::to(url($imageurl), 301);

    }
}
