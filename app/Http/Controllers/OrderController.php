<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Cart;
use App\Address;
use App\Order;
use App\User;

class OrderController extends Controller
{
    public function userCreateOrder($cart_id, Request $request)
    {
        $params = $request->all();
        $user_id = User::getUserByToken($request->header('Authorization'))->id;

        $address = Address::find($params["address_id"]);
        $cart = Cart::find($cart_id);

        if($address==null || $address->user_id != $user_id || $cart==null || $cart->user_id != $user_id) abort(403);

        $cart->checkCartAvailability();

        $order = $this->newOrder($cart, $address);

        $this->setUserCart($user_id);

        return response()->json(["items"=>getCartData($cart, false), "summary"=>$order->aggregateSubOrderData(), "address"=>$address->address, "message"=> 'Order Placed successfully']);

    }

    public function newOrder($cart, $address)
    {
        if($cart->type == 'order') abort(400,'invalid cart');
        $order = new Order;
        $order->cart_id = $cart->id;
        $order->address_id = $address->id;
        $expires_at = Carbon::now()->addMinutes(config('orders.expiry'));
        $order->expires_at = $expires_at->timestamp;
        $order->save();
        $order->setSubOrders();
        $cart->type = 'order';
        $cart->save();

        return $order;
    }

    public function setUserCart($user_id)
    {
        $cart =  new Cart;
        $cart->save();

        $user = User::find($user_id);
        $user->cart_id = $cart->id;
        $user->save();
    }
}
