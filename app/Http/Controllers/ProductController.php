<?php

namespace App\Http\Controllers;

use App\ProductColor;
use App\Product;
use App\Facet;
use App\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index($product_slug, Request $request)
    {
        $json = json_decode(singleproduct($product_slug));
        $params =  (array) $json;

        $query  = $request->all();

        $params['show_button'] = false;

        foreach ($params['variant_group']->{$params['selected_color_id']}->variants as $size_set) {
            if (isset($query['size']) and $query['size'] == $size_set->size->slug && $size_set->inventory_available) {
                $params['size'] = $query['size'];
            }
            $params['show_button'] = ($params['show_button'] or $size_set->inventory_available);
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

        $similar_cat_params=[];
        $facets = Facet::select('slug')->whereIn('facet_value', array_values((array)$params["category"]))->get()->toArray();
        $similar_cat_params['categories'] = array_column($facets, 'slug');
        $search_object_arr = build_search_object($similar_cat_params);

        $search_results = [];

        $search_object = $search_object_arr["search_result"];

        $search_results["slug_search_result"] = $search_object_arr["slug_search_result"];
        $search_results["slug_value_search_result"] = $search_object_arr["slug_value_search_result"];
        $search_results["slugs_result"] = $search_object_arr["slugs_result"];
        $search_results["title"] = $search_object_arr["title"];
        $similar_products_display_limit = config('product.similar_products_display_limit');
        $parameters = Product::productListPage(["search_object" => $search_object,"display_limit"=> ($similar_products_display_limit+1),"page" =>1],$search_results["slug_value_search_result"],$search_results["slug_search_result"],$search_results["slugs_result"],$search_results["title"]);

        // dd($parameters);
        $similar_data_params= json_decode(json_encode($parameters,JSON_FORCE_OBJECT));
        $similar_products = [];
        foreach($similar_data_params->items as $similar_item){
            if($similar_item->product_id != $params["parent_id"] && count($similar_products)<$similar_products_display_limit)
                array_push($similar_products, $similar_item);
        }

        return view('singleproduct')->with('params', $params)->with('similar_data_params', $similar_products);
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


    public function productMissingImages(){
        $variants = Variant::leftJoin('fileupload_mapping', function ($join) {
           $join->on('variants.product_color_id', '=', 'fileupload_mapping.object_id');
           $join->where('fileupload_mapping.object_type', '=', "App\ProductColor");
        })->where('fileupload_mapping.id', null)->get();

        $odoo_ids=[];
        foreach ($variants as $variant) {
          if($variant->getAvailability()) {
           array_push($odoo_ids,$variant->odoo_id);
          }
        }
        return response()->json($odoo_ids,200);
    }

    public function allInventory(){
        Variant::getWarehouseInventory();
    }
}
