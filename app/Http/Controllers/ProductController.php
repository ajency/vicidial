<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index($product_slug, $style_slug, $color_slug, Request $request)
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
}
