<?php

namespace App\Http\Controllers\v2;

use App\Address;
use App\Cart;
use App\Http\Controllers\Controller;
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

        $user    = $request->user();
        $address = Address::find($params["address_id"]);
        $cart    = Cart::find($id);

        validateCart($user, $cart, 'cart');
        validateAddress($user, $address);
        $cart->checkCartAvailability();

        if (!$cart->isPromotionApplicable($cart->promotion)) {
            abort(404, "Promotion not applicable");
        }

        $order = Order::create([
            'cart_id'      => $cart->id,
            'address_id'   => $address->id,
            'address_data' => $address->shippingAddress(),
            'expires_at'   => Carbon::now()->addMinutes(config('orders.expiry'))->timestamp,
        ]);

        saveTxnid($order);

        $order->setSubOrders();
        $order->aggregateSubOrderData();
        $order->save();

        $cart->type = 'order';
        $cart->save();

        $response = ["items" => getCartData($cart, false), "summary" => $order->subOrderData(), "order_id" => $order->id, "address" => $order->address_data, "message" => 'Order Placed successfully'];

        $user_info = $user->userInfo();
        if ($user_info != null) {
            $response['user_info'] = $user_info;
        }

        return response()->json($response);
    }

    public function continueOrder($id, Request $request)
    {
        $params = $request->all();

        $user = $request->user();
        $cart = Cart::find($id);
        validateCart($user, $cart, 'order');

        $order = $cart->order;

        checkOrderInventory($order);

        if (!$cart->isPromotionApplicable($cart->promotion)) {
            abort(404, "Promotion not applicable");
        }

        if (isset($params['address_id'])) {
            $address = Address::find($params["address_id"]);
            validateAddress($user, $address);
            $order->address_id   = $address->id;
            $order->address_data = $address->shippingAddress();
            $order->save();
        } else {
            $address = $order->address;
        }

        $response = ["items" => getCartData($cart, false), "summary" => $order->subOrderData(), "order_id" => $order->id, "address" => $order->address_data, "message" => 'Order Placed successfully'];

        $user_info = $user->userInfo();
        if ($user_info != null) {
            $response['user_info'] = $user_info;
        }

        return response()->json($response);
    }

    public function checkSubOrderInventory($id, Request $request)
    {
        $user  = $request->user();
        $order = Order::find($id);
        $cart  = $order->cart;
        validateCart($user, $cart, 'order');

        checkOrderInventory($order);

        if (!$cart->isPromotionApplicable($cart->promotion)) {
            abort(404, "Promotion not applicable");
        }

        return response()->json(["message" => 'Items are available in store', 'success' => true]);
    }

    public function getOrderDetails(Request $request)
    {
        $query = $request->all();

        if (!isset($query['orderid'])) {
            abort(404);
        }

        $order = Order::where('txnid', $query['orderid'])->first();
        if (!isset($_COOKIE['token'])) {
            abort(401);
        }
        $user = User::getUserByToken('Bearer ' . $_COOKIE['token']);
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

    public function listOrders(Request $request)
    {
        $data          = $request->all();
        $order_details = [];
        $search_object = (isset($data["search_object"])) ? $data["search_object"] : [];
        $sort_on       = (isset($data["sort_on"])) ? $data["sort_on"] : "created_at";
        $sort_by       = (isset($data["sort_by"])) ? $data["sort_by"] : "desc";
        $length        = (isset($data["display_limit"])) ? $data["display_limit"] : 0;
        $page          = (isset($data["page"])) ? $data["page"] : 1;
        $start         = ($page == 1) ? ($page - 1) : ((($page - 1) * $length));
        $user          = $request->user();
        $user_id       = (isset($search_object["user_id"])) ? $search_object["user_id"] : $user->id;
        if ($user_id != $user->id) {
            if ($user->hasPermissionTo('see other user orders', 'web') == false) {
                return response()->json(["message" => 'Access denied', 'success' => false, 'data' => $order_details]);
            }

        }
        $order_status = (isset($search_object["status"])) ? $search_object["status"] : 'payment-successful';
        $orderObj     = Order::join('carts', 'carts.id', '=', 'orders.cart_id')->where('carts.user_id', $user_id)->where('orders.status', $order_status)->orderBy("orders." . $sort_on, $sort_by)->select("orders.*");

        if (isset($search_object["order_date"]) && isset($search_object["order_date"]["start"]) && isset($search_object["order_date"]["end"])) {
            $from     = date($search_object["order_date"]["start"]);
            $to       = date($search_object["order_date"]["end"]);
            $orderObj = $orderObj->whereBetween('orders.created_at', [$from, $to]);
        }
        if ($length == 0) {
            $orders = $orderObj->get();
        } else {
            $orders = $orderObj->skip($start)->take($length)->get();
        }

        foreach ($orders as $order) {
            array_push($order_details, $order->getOrderDetails());
        }

        return response()->json(["message" => 'Order items received successfully', 'success' => true, 'data' => $order_details]);
    }

}