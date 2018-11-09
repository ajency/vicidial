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
        $params  = $request->all();
        $user_id = User::getUserByToken($request->header('Authorization'))->id;

        $address = Address::find($params["address_id"]);
        $cart    = Cart::find($cart_id);

        if ($address == null || $address->user_id != $user_id || $cart == null || $cart->user_id != $user_id) {
            abort(403);
        }

        $cart->checkCartAvailability();

        $order = $this->newOrder($cart, $address);

        $this->setUserCart($user_id);

        return response()->json(["items" => getCartData($cart, false), "summary" => $order->aggregateSubOrderData(), "order_id" => $order->id, "address" => $address->address, "message" => 'Order Placed successfully']);

    }

    public function newOrder($cart, $address)
    {
        if ($cart->type == 'order') {
            abort(400, 'invalid cart');
        }

        $order             = new Order;
        $order->cart_id    = $cart->id;
        $order->address_id = $address->id;
        $expires_at        = Carbon::now()->addMinutes(config('orders.expiry'));
        $order->expires_at = $expires_at->timestamp;
        $order->save();
        $order->setSubOrders();
        $order->placeSubOrdersOdoo();
        $cart->type = 'order';
        $cart->save();

        return $order;
    }

    public function setUserCart($user_id)
    {
        $user = User::find($user_id);

        $cart          = new Cart;
        $cart->user_id = $user->id;
        $cart->save();

        $user->cart_id = $cart->id;
        $user->save();
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
