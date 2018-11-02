<?php

namespace App\Http\Controllers;

use App\ProductColor;
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
        $params['breadcrumb']['list'][] = ['name' => $params['category']->type, 'href' => '#'];
        $params['breadcrumb']['list'][] = ['name' => $params['category']->age_group, 'href' => '#'];
        $params['breadcrumb']['list'][] = ['name' => $params['category']->gender, 'href' => '#'];
        $params['breadcrumb']['list'][] = ['name' => $params['category']->sub_type, 'href' => '#'];

        $params['breadcrumb']['current'] = '';

        setSEO('product', $params);

        return view('singleproduct')->with('params', $params);
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
