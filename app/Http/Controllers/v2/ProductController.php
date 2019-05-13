<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use App\Product;
use App\ProductColor;
use App\Variant;
use Illuminate\Http\Request;
use App\SingleProduct;
use Ajency\ServiceComm\Comm\Sync;
use DB;
use Illuminate\Support\Facades\Cache;

class ProductController extends Controller
{
    public function singleProduct($product_slug, Request $request)
    {
        return view('home_new');
    }

    public function getImage($photo_id, $preset, $depth, $filename)
    {
        $path         = public_path() . 'img/' . $filename;
        $productColor = ProductColor::join('fileupload_mapping', function ($join) {
            $join->on('product_colors.id', '=', 'fileupload_mapping.object_id');
            $join->where('fileupload_mapping.object_type', '=', "App\ProductColor");
        })->where('fileupload_mapping.file_id', $photo_id)->select('product_colors.*')->first();
        // $productColor = ProductColor::where('elastic_id', $elastic_id)->first();
        if ($productColor == null) {
            abort(404);
        }

        $imageurl = "";
        $file     = $productColor->getSingleImage($photo_id, $preset, $depth);
        if ($file) {
            $imageurl = $file;
        } else {
            $imageurl = $productColor->resizeImages($photo_id, $preset, $depth, $filename);
        }
        if (config('ajfileupload.use_cdn') && config('ajfileupload.cdn_url')) {
            $tempUrl  = parse_url($imageurl);
            $imageurl = config('ajfileupload.cdn_url') . $tempUrl['path'];
        }
        return \Redirect::to(url($imageurl), 301);

    }

    public function productMissingImages()
    {
        $variants = Variant::leftJoin('fileupload_mapping', function ($join) {
            $join->on('variants.product_color_id', '=', 'fileupload_mapping.object_id');
            $join->where('fileupload_mapping.object_type', '=', "App\ProductColor");
        })->where('fileupload_mapping.id', null)->get();

        $odoo_ids = [];
        foreach ($variants as $variant) {
            if ($variant->getAvailability()) {
                array_push($odoo_ids, $variant->odoo_id);
            }
        }
        return response()->json($odoo_ids, 200);
    }

    public function allInventory()
    {
        Variant::getWarehouseInventory();
    }

    public function SingleProductApi(Request $request)
    {
        $request->validate(['slug' => 'required']);
        $slug        = $request->slug;
        $apiResponse = Cache::rememberForever('single-product-' . $slug, function () use ($slug) {
            $singleProduct = new SingleProduct($slug);
            $apiResponse   = $singleProduct->generateSinglePageData(['attributes', 'facets', 'variants', 'images', 'is_sellable', 'color_variants', 'breadcrumbs', 'related_products', 'meta', 'size_chart', 'blogs']);
            return $apiResponse;
        });
        return response()->json($apiResponse);
    }

    public function SingleProductInventory(Request $request){
        $request->validate(['product_id' => 'required|numeric', 'color_id' => 'required|numeric']);
        $productId = $request->product_id;
        $colorId = $request->color_id;
        $productColors = ProductColor::where('product_id',$productId)->get();
        $variants = DB::table('variants')->select(['id','odoo_id','product_color_id'])->whereIn('product_color_id',$productColors->pluck('id'))->get()->map(function ($x) {return (array) $x;});
        $variantQuantity = Sync::call('inventory', 'getVariantQuantity', ['variants' => $variants->pluck('id')]);
        $colorVariants = [];
        foreach ($variants->where('product_color_id',$productColors->where('color_id',$colorId)->first()->id)->pluck('id','odoo_id') as $odooId => $variantID) {
            $colorVariants[$odooId] = ($variantQuantity[$variantID] > 0) ? $variantQuantity[$variantID] : 0;
        }
        $otherColors = [];
        foreach ($productColors as $color) {
            $otherColors[$color['id']] = [
                'color_id' => $color['color_id'],
                'availability' => false
            ];
            foreach ($variants->where('product_color_id',$color['id'])->pluck('id') as $variantID) {
                if($variantQuantity[$variantID] > 0) {
                    $otherColors[$color['id']]['availability'] = true;
                    break;
                }
            }
        }
        $result = ['variants'=>$colorVariants,'other_colors' => $otherColors];
        return response()->json($result);
    }
}
