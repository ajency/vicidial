<?php

namespace App\Http\Controllers;

use App\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function guest_get_count(Request $request){
    	$id = $request->session()->get('cart_id',false);
    	if($id){
    		$cart = Cart::find($id);
			return response()->json(['cart_count' => $cart->item_count()]);	
    	}else return abort('404', "Cart not found for this session");
    }

    public function guest_add_item(Request $request){
    	$id = $request->session()->get('cart_id',false);
    	$cart = ($id)? Cart::find($id) : new Cart;
    	$item = true; //Get elastic data here
    	if($item){
    		$cart->insert_item(["id"=>$request->variant_id, "quantity" =>$request->variant_quantity]);
	    	$cart->save();
    	}
    	return response()->json(['cart_count' => $cart->item_count(), "message" => $message, "item" => $item]);
    	
    }
}
