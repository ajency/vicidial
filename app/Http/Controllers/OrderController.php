<?php

namespace App\Http\Controllers;

use App\Address;
use App\Cart;
use App\Order;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function userCreateOrder($id, Request $request)
    {
        $request->validate(['address_id' => 'required|exists:addresses,id']);
        $params = $request->all();

        $user    = User::getUserByToken($request->header('Authorization'));
        $address = Address::find($params["address_id"]);
        $cart    = Cart::find($id);

        validateCart($user, $cart, 'cart');
        validateAddress($user, $address);
        $cart->checkCartAvailability();

        $order = Order::create([
            'cart_id'    => $cart->id,
            'address_id' => $address->id,
            'expires_at' => Carbon::now()->addMinutes(config('orders.expiry'))->timestamp,
        ]);

        $dateInd = Carbon::now();
        $dateInd->setTimezone('Asia/Kolkata');

        $order->txnid = strtoupper($dateInd->format('Mjy')).str_pad($order->id, 8, '0', STR_PAD_LEFT);
        $order->save();

        $order->setSubOrders();
        $cart->type = 'order';
        $cart->save();

        $response = ["items" => getCartData($cart, false), "summary" => $order->aggregateSubOrderData(), "order_id" => $order->id, "address" => array_merge($address->address,["id"=>$address->id]), "message" => 'Order Placed successfully'];

        $user_info = $user->userInfo();
        if($user_info!=null) {
            $response['user_info'] = $user_info;
        }

        return response()->json($response);
    }

    public function continueOrder($id, Request $request)
    {
        $params = $request->all();

        $user = User::getUserByToken($request->header('Authorization'));
        $cart    = Cart::find($id);
        validateCart($user,$cart, 'order');

        $order = $cart->order;

        if(isset($params['address_id'])) {
            $address = Address::find($params["address_id"]);
            validateAddress($user, $address);
            $order->address_id = $address->id;
            $order->save();
        }
        else {
            $address = $order->address;
        }

        $response = ["items" => getCartData($cart, false), "summary" => $order->aggregateSubOrderData(), "order_id" => $order->id, "address" => array_merge($address->address,["id"=>$address->id]), "message" => 'Order Placed successfully'];

        $user_info = $user->userInfo();
        if($user_info!=null) {
            $response['user_info'] = $user_info;
        }

        return response()->json($response);
    }

    public function getOrderDetails(Request $request)
    {
        $query = $request->all();

        if (!isset($query['orderid'])) {
            abort(404);
        }

        $order = Order::find($query['orderid']);
        if(!isset($_COOKIE['token'])) {
            abort(401);
        }
        $user    = User::getUserByToken('Bearer '.$_COOKIE['token']);
        validateOrder($user, $order);

        $params = $order->getOrderDetails();

        $params['breadcrumb']            = array();
        $params['breadcrumb']['list']    = array();
        $params['breadcrumb']['list'][]  = ['name' => "Account", 'href' => '#'];
        $params['breadcrumb']['list'][]  = ['name' => "Order", 'href' => '#'];
        $params['breadcrumb']['current'] = 'Order Details';

        if (request()->session()->get('payment', false)) {
            $params['payment_status'] = request()->session()->get('payment');
        }

        return view('orderdetails')->with('params', $params);
    }

}

