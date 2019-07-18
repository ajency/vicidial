<?php

namespace App\Http\Controllers\v2;

use App\Address;
use App\Cart;
use App\Comment;
use App\Defaults;
use App\Http\Controllers\Controller;
use App\Jobs\OrderCreatedNotification;
use App\Jobs\OrderLineStatus;
use App\Jobs\SubOrderStatus;
use App\Order;
use App\SubOrder;
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
        $pincode_data = $address->checkPincodeServiceable();

        $order = Order::create([
            'cart_id'      => $cart->id,
            'address_id'   => $address->id,
            'address_data' => $address->shippingAddress(),
            'expires_at'   => Carbon::now()->addMinutes(config('orders.expiry'))->timestamp,
            'type'         => 'New Transaction',
        ]);

        saveTxnid($order);
        saveOrderToken($order);

        $order->setSubOrders();
        $order->aggregateSubOrderData();
        $storeData         = $order->getStoreData();
        $order->store_ids  = $storeData['store_ids'];
        $order->store_data = $storeData['store_data'];
        $order->verified   = $params["token_verified"];
        $order->save();
        OrderCreatedNotification::dispatch($order->id)->onQueue('order_index');

        if (!$address->verified && $params["token_verified"]) {
            $address->verified = $params["token_verified"];
            $address->save();
        }

        $cart->type = 'order';
        $cart->save();

        $response = ["items" => getCartData($cart, false), "summary" => $order->subOrderData(), "order_id" => $order->id, "address" => $order->address_data, "pincode_serviceability" => $pincode_data, "message" => 'Order Placed successfully'];

        $user_info = $user->userInfo();
        if ($user_info != null && $params["token_verified"]) {
            $response['user_info'] = $user_info;
        }
        $response['user_info_editable'] = false;
        if ($params["token_verified"] || $user_info == null) {
            $response['user_info_editable'] = true;
        }

        return response()->json($response);
    }

    public function continueOrder($id, Request $request)
    {
        $params = $request->all();
        $user   = $request->user();
        $cart   = Cart::find($id);
        validateCart($user, $cart, 'order');
        $order = $cart->order;
        checkOrderInventory($order);
        if ($order->status != 'draft') {
            $order = $order->newOrder($cart, $params['token_id']);
            $cart  = $order->cart;
        }
        if (isset($params['address_id'])) {
            $address = Address::find($params["address_id"]);
            validateAddress($user, $address);
            $pincode_data        = $address->checkPincodeServiceable();
            $order->address_id   = $address->id;
            $order->address_data = $address->shippingAddress();
            $order->verified     = $params["token_verified"];
            $order->save();
        } else {
            $address      = $order->address;
            $pincode_data = $address->checkPincodeServiceable();
        }

        if (!$address->verified && $params["token_verified"]) {
            $address->verified = $params["token_verified"];
            $address->save();
        }

        $response = ["items" => getCartData($cart, false), "summary" => $order->subOrderData(), "order_id" => $order->id, "address" => $order->address_data, "pincode_serviceability" => $pincode_data, "message" => 'Order Placed successfully'];

        $user_info = $user->userInfo();
        if ($user_info != null && $params["token_verified"]) {
            $response['user_info'] = $user_info;
        }
        $response['user_info_editable'] = false;
        if ($params["token_verified"] || $user_info == null) {
            $response['user_info_editable'] = true;
        }

        return response()->json($response);
    }

    public function checkSubOrderInventory($id, Request $request)
    {
        $user  = $request->user();
        $order = Order::find($id);
        $order->validate($user);
        $cart = $order->cart;
        return response()->json(["message" => 'Items are available in store', 'success' => true]);
    }

    public function getOrderDetails(Request $request)
    {
        $query = $request->all();

        if (isset($query['ordertoken'])) {
            $order = Order::where('token', $query['ordertoken'])->first();
            if ($order == null) {
                abort(403);
            }
        } else {
            if (!isset($query['orderid'])) {
                abort(404);
            }

            $order = Order::where('txnid', $query['orderid'])->first();
            if (!isset($_COOKIE['token'])) {
                abort(401);
            }
            $user = User::getUserByPassportToken($_COOKIE['token']);
            if ($user == null) {
                $user = User::getUserByToken('Bearer ' . $_COOKIE['token']);
            }
            validateOrder($user, $order);
        }

        $params = $order->getOrderDetailsItemWise(true);

        $params['breadcrumb']            = array();
        $params['breadcrumb']['list']    = array();
        $params['breadcrumb']['list'][]  = ['name' => "Account", 'href' => '#'];
        $params['breadcrumb']['list'][]  = ['name' => "Order", 'href' => '#'];
        $params['breadcrumb']['current'] = 'Order Details';

        if (request()->session()->get('payment', false)) {
            $params['payment_status'] = request()->session()->get('payment');
        }

        $params['trackBackUrl'] = $order->getTrackbackUrlCashBackWorld();

        return view('orderdetails')->with('params', $params);
    }

    public function newOrderDetails($trxn_id, Request $request)
    {
        return view('home_new');
    }

    public static function updateSubOrderStatus($params)
    {
        SubOrderStatus::dispatch($params["subOrderId"], $params["state"], $params["is_shipped"], $params["is_invoiced"], $params["external_id"], $params["lines_status"])->onQueue('odoo_order');
    }

    public static function updateOrderLineStatus($params)
    {
        OrderLineStatus::dispatch($params["lineIds"], $params["status"], $params["status_datetime"])->onQueue('odoo_order');
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
        //$order_status = (isset($search_object["status"])) ? $search_object["status"] : 'payment-successful';
        $orderObj = Order::join('carts', 'carts.id', '=', 'orders.cart_id')->where('carts.user_id', $user_id)->where(function ($q) {
            $q->where('orders.status', 'payment-successful')
                ->orWhere('orders.status', 'cash-on-delivery');
        })->orderBy("orders." . $sort_on, $sort_by)->select("orders.*");

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
            array_push($order_details, $order->getOrderDetailsItemWise(true));
        }

        return response()->json(["message" => 'Order items received successfully', 'success' => true, 'data' => $order_details]);
    }

    public function singleOrder($txnid, Request $request)
    {
        $user  = $request->user();
        $order = Order::where('txnid', $txnid)->first();
        validateOrder($user, $order);
        return response()->json(["message" => 'Order items received successfully', 'success' => true, 'data' => $order->getOrderDetailsItemWise(true)]);
    }

    public function cancelOrder($id, Request $request)
    {
        $user  = $request->user();
        $order = Order::find($id);
        validateOrder($user, $order);

        if (!$order->cancelAllowed()) {
            abort(403, 'Cancel not allowed');
        }

        $request->validate(['reason' => 'required|exists:defaults,id', 'comments' => 'present']);
        $params = $request->all();

        $orderId = $order->cancelOrderOnOdoo();

        $comment              = new Comment;
        $comment->reason_id   = $params['reason'];
        $comment->reason_type = 'cancel';
        $comment->comments    = $params['comments'];
        $comment->model_id    = $orderId;
        $comment->model_type  = get_class($order);
        $comment->save();

        return response()->json(["message" => 'Order cancelled successfully', 'success' => true]);
    }

    public function getAllReasons(Request $request)
    {
        return Defaults::getReasons();
    }

    public function returnOrder($id, Request $request)
    {
        $user      = $request->user();
        $sub_order = SubOrder::find($id);
        validateSubOrder($user, $sub_order);

        $request->validate(['reason' => 'required|exists:defaults,id', 'comments' => 'present', 'variant_id' => 'required|exists:variants,odoo_id', 'quantity' => 'required|integer|min:1']);
        $params = $request->all();

        $sub_order->order->placeReturnRequest($params, $sub_order);

        return response()->json(["message" => 'Return request placed successfully', 'success' => true]);
    }

    public function finalPageDetails($txnid, Request $request)
    {
        $user   = $request->user();
        $params = $request->all();
        $order  = Order::where('txnid', $txnid)->first();
        validateOrder($user, $order);
        setActiveCart($params['token_id'], $params['active_cart']);
        if ($order->payment_in_progress) {
            return response()->json(['order-pending' => true]);
        }
        switch ($order->status) {
            case 'cash-on-delivery':
                $status = 'cod';
                break;
            case 'payment-successful':
                $status = 'success';
                break;
            case 'payment-failed':
                $status = 'failure';
                break;
            default:
                $status = '';
                break;
        }
        $status        = ($order->viewed) ? '' : $status;
        $order->viewed = true;
        $order->save();

        return response()->json([
            'data'          => $order->getOrderDetailsItemWise(true),
            'order-pending' => false,
            'status'        => $status,
            'trackback_url' => $order->getTrackbackUrlCashBackWorld(),
        ]);
    }
}
