<?php

namespace App\Http\Controllers\v1;

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

    public function index($product_slug, Request $request)
    {
        
        $json   = json_decode(singleproduct($product_slug));
        $params = (array) $json;
        $posts  = array();
        $query  = $request->all();

        $params['show_button'] = false;

        $available_sizes   = array();
        $unavailable_sizes = array();

        foreach ($params['variant_group']->{$params['selected_color_id']}->variants as $size_set) {
            if (isset($query['size']) and $query['size'] == $size_set->size->slug && $size_set->inventory_available) {
                $params['size'] = $query['size'];
            }
            $params['show_button'] = ($params['show_button'] or $size_set->inventory_available);

            if ($size_set->inventory_available) {
                $available_sizes[] = $size_set;
            } else {
                $unavailable_sizes[] = $size_set;
            }
        }

        $params['variant_group']->{$params['selected_color_id']}->variants = array_merge($available_sizes, $unavailable_sizes);

        if ($params['ecom_sales'] == false) {
            $params['show_button'] = false;
        }

        $facet_names_for_url = array();
        $categories          = array_keys(get_object_vars($params['category']));
        foreach ($params['facet_value_pairs'] as $facet_name => $all_facets) {
            foreach ($all_facets as $facet) {
                array_push($posts, collect($facet)['display_name']);
                $facet_names_for_url[$facet_name] = ["display_name" => collect($facet)['display_name'], "slug" => collect($facet)['slug']];
            }
        }

        $related_search = array();
        if (isset($params['size'])) {
            $price = setDefaultPrice(collect($params['variant_group'])[$params['selected_color_id']]->variants, $params['size']);
        } else {
            $price = setDefaultPrice(collect($params['variant_group'])[$params['selected_color_id']]->variants);
        }
        array_push($related_search, ["name" => 'More in ' . $facet_names_for_url['product_subtype']['display_name'], "href" => createUrl('list', [$facet_names_for_url['product_subtype']['slug']])]);
        array_push($related_search, ["name" => 'More in ' . $facet_names_for_url['product_color_html']['display_name'] . ' ' . $facet_names_for_url['product_subtype']['display_name'], "href" => createUrl('list', [$facet_names_for_url['product_subtype']['slug']], ["pf" => ['color' => [$facet_names_for_url['product_color_html']['slug']]]])]);
        array_push($related_search, ["name" => 'More in ' . $facet_names_for_url['product_subtype']['display_name'] . ' from ' . $facet_names_for_url['product_brand']['display_name'], "href" => createUrl('list', [$facet_names_for_url['product_subtype']['slug'], $facet_names_for_url['product_brand']['slug']])]);
        array_push($related_search, ["name" => 'More in ' . $facet_names_for_url['product_subtype']['display_name'] . ' below ' . $price['sale_price'], "href" => createUrl('list', [$facet_names_for_url['product_subtype']['slug']], ["rf" => ['price' => ['0TO' . $price['sale_price']]]])]);

        $params['related_search'] = $related_search;

        $params['breadcrumb']         = array();
        $params['breadcrumb']['list'] = array();
        $url                          = array();
        $breadcrumb                   = config('product.breadcrumb_order');
        foreach ($breadcrumb as $category) {
            $facet                          = collect($json->facet_value_pairs->{$category})->first();
            $url[]                          = $facet->slug;
            $params['breadcrumb']['list'][] = ['name' => $facet->display_name, 'href' => createUrl('list', $url)];
        }
        $params['posts']                 = $posts;
        $params['breadcrumb']['current'] = '';
        setSEO('product', $params);


        $facets = Facet::select('slug')->whereIn('facet_value', array_values((array)$params["category"]))->get()->toArray();
        $similar_cat_params               = [];
        $similar_cat_params['categories'] = array_column($facets, 'slug');
        $search_object_arr                = build_search_object($similar_cat_params);

        $search_results = [];

        $search_object = $search_object_arr["search_result"];

        $search_results["slug_search_result"]       = $search_object_arr["slug_search_result"];
        $search_results["slug_value_search_result"] = $search_object_arr["slug_value_search_result"];
        $search_results["slugs_result"]             = $search_object_arr["slugs_result"];
        $search_results["title"]                    = $search_object_arr["title"];
        $similar_products_display_limit             = config('product.similar_products_display_limit');
        $parameters                                 = Product::productListPage(["search_object" => $search_object, "display_limit" => ($similar_products_display_limit + 1), "page" => 1], $search_results["slug_value_search_result"], $search_results["slug_search_result"], $search_results["slugs_result"], $search_results["title"]);

        // dd($parameters);
        $similar_data_params = json_decode(json_encode($parameters, JSON_FORCE_OBJECT));
        $similar_products    = [];
        foreach ($similar_data_params->items as $similar_item) {
            if ($similar_item->product_id != $params["parent_id"] && count($similar_products) < $similar_products_display_limit) {
                array_push($similar_products, $similar_item);
            }

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

    public function SingleProductApi(Request $request){
        $request->validate(['slug' => 'required']);
        $slug = $request->slug;
        $apiResponse = Cache::remember('single-product-'.$slug,60*12, function()use($slug){
            $singleProduct = new SingleProduct($slug);
            $apiResponse = $singleProduct->generateSinglePageData(['attributes','facets','variants','images','is_sellable','color_variants','breadcrumbs','related_products','meta','blogs']);
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
        $availability = Sync::call('inventory', 'getVariantAvailability', ['variants' => $variants->pluck('id')]);
        $colorVariants = [];
        foreach ($variants->where('product_color_id',$productColors->where('color_id',$colorId)->first()->id)->pluck('id','odoo_id') as $odooId => $variantID) {
            $colorVariants[$odooId] = $availability[$variantID];
        }
        $otherColors = [];
        foreach ($productColors as $color) {
            $otherColors[$color['id']] = [
                'color_id' => $color['color_id'],
                'availability' => false
            ];
            foreach ($variants->where('product_color_id',$color['id'])->pluck('id') as $variantID) {
                if($availability[$variantID]) {
                    $otherColors[$color['id']]['availability'] = true;
                    break;
                }
            }
        }
        $result = ['variants'=>$colorVariants,'other_colors' => $otherColors];
        return response()->json($result);
    }
}
//product
//"/value1/value2/shop/buy?color:color1,color2|tag:tag1,tag2&range:range1,range2&boolean:boolean1,boolean2"
//list
//"/?color:color1,color2|tag:tag1,tag2&range:range1,range2&boolean:boolean1,boolean2"
