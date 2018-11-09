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
    public function userCreateOrder($cart_id, Request $request)
    {
        $request->validate(['address_id' => 'required|exists:addresses,id']);
        $params = $request->all();

        $user    = User::getUserByToken($request->header('Authorization'));
        $address = Address::find($params["address_id"]);
        $cart    = Cart::find($cart_id);

        validateCart($user, $cart, 'cart');
        validateAddress($user, $address);
        $cart->checkCartAvailability();

        $order = Order::create([
            'cart_id'    => $cart->id,
            'address_id' => $address->id,
            'expires_at' => Carbon::now()->addMinutes(config('orders.expiry'))->timestamp,
        ]);
        $order->setSubOrders();
        $cart->type = 'order';
        $cart->save();

        $order->placeSubOrdersOdoo();

        return response()->json(["items" => getCartData($cart, false), "summary" => $order->aggregateSubOrderData(), "order_id" => $order->id, "address" => $address->address, "message" => 'Order Placed successfully']);
    }

    public function continueOrder($cart_id)
    {
        $user = User::getUserByToken($request->header('Authorization'));
        $cart    = Cart::find($cart_id);
        validateCart($user,$cart, 'order');
        $order = $cart->order;

        $order->placeSubOrdersOdoo();

        return response()->json(["items" => getCartData($cart, false), "summary" => $order->aggregateSubOrderData(), "order_id" => $order->id, "address" => $address->address, "message" => 'Order Placed successfully']);
    }

    public function getOrderDetails(Request $request)
    {
        $query = $request->all();

        if (!isset($query['orderid'])) {
            return view('error404');
        }

        $order = Order::find($query['orderid']);
        if ($order == null) {
            return view('error404');
        }

        $sub_orders = array();
        foreach ($order->subOrders as $subOrder) {
            $sub_orders[] = $subOrder->getSubOrder();
        }

        $payment = $order->payments->first();

        $params = [
            "order_info"       => $order->getOrderInfo(),
            "sub_orders"       => $sub_orders,
            "payment_info"     => [
                //"payment_mode" => $payment->bankcode,
                "payment_mode" => json_decode($payment->data)->bankcode,
                "card_num"     => $payment->cardnum,
            ],
            "shipping_address" => $order->address->shippingAddress(),
            "order_summary"    => $order->aggregateSubOrderData(),
        ];

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
