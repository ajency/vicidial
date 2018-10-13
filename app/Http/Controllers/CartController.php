<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Varient;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function guest_get_count(Request $request){
    	// \Log::info('enters guest_get_count function');
    	$id = $request->session()->get('active_cart_id',false);
    	// \Log::info('cart = '.$id);
    	if($id){
    		$cart = Cart::find($id);
			return response()->json(['cart_count' => $cart->item_count()]);	
    	}else return abort('404', "Cart not found for this session");
    }

    public function guest_add_item(Request $request){
		// \Log::info('enters guest_get_count function');
		$params = $request->all();
    	$id = $request->session()->get('active_cart_id',false);
    	$cart = ($id)? Cart::find($id) : new Cart;
    	$item = true; //Get elastic data here
        $variant = new Varient($params['variant_id']);
        $item = $variant->getVariantData();
    	if($item){
    		$cart->insert_item(["id"=>$params['variant_id'], "quantity" =>$params['variant_quantity']]);
    		// \Log::info($cart->cart_data);
	    	$cart->save();
	    	$message="Item added successfully";
	    	$request->session()->put('active_cart_id',$cart->id);
    	}
    	return response()->json(['cart_count' => $cart->item_count(), "message" => $message, "item" => $item]);
    	
    }
}
