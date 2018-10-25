<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProductColor;

class ProductController extends Controller
{

    public function index($product_slug, Request $request)
    {
        $query = $request->all();
        $params = $request->get('params');
        if(isset($query['size'])) {
        	foreach ($params['variant_group']->{$params['selected_color_id']}->variants as $size_set) {
			    if($query['size'] == $size_set->size->name && $size_set->inventory_available) {
		        	$params['size'] = $query['size'];
		        }
		    }
        }

        $params['breadcrumb'] = array();
        $params['breadcrumb']['list'] = array();
        $params['breadcrumb']['list'][] = ['name'=>$params['category']->type,'href'=>'#'];
        $params['breadcrumb']['list'][] = ['name'=>$params['category']->age_group,'href'=>'#'];
        $params['breadcrumb']['list'][] = ['name'=>$params['category']->gender,'href'=>'#'];
        $params['breadcrumb']['list'][] = ['name'=>$params['category']->sub_type,'href'=>'#'];

        $params['breadcrumb']['current'] = '';
        
        return view('singleproduct')->with('params',$params);
    }

    public function get_image($elastic_id,$preset,$depth,$filename){
        $path = public_path().'img/'.$filename;
        $productColor = ProductColor::where('elastic_id',$elastic_id)->first();
        $imageurl = "";
        $file = $productColor->getSingleImage($preset,$depth);
        // echo $file."<br/>";
        if($file){
            // echo "enters1";
            $imageurl = $file;
        }
        else{
            // echo "enters2";
            $imageurl = $productColor->resizeImages($preset,$depth,$filename);
        }
        // dd($imageurl);
        return \Redirect::to(url($imageurl),308);
    
    }
}
