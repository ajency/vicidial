<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\ProductColor;
use App\Product;
use App\Facet;
use App\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{

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
