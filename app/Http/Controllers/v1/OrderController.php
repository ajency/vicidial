<?php

namespace App\Http\Controllers\v1;

use App\Address;
use App\Cart;
use App\Comment;
use App\Defaults;
use App\Http\Controllers\Controller;
use App\Jobs\OrderLineStatus;
use App\Jobs\SubOrderStatus;
use App\Order;
use App\ReturnPolicy;
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

        $user    = User::getUserByToken($request->header('Authorization'));
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
        $order->save();

        $cart->type = 'order';
        $cart->save();

        $response = ["items" => getCartData($cart, false), "summary" => $order->subOrderData(), "order_id" => $order->id, "address" => $order->address_data, "pincode_serviceability" => $pincode_data, "message" => 'Order Placed successfully'];

        $user_info = $user->userInfo();
        if ($user_info != null) {
            $response['user_info'] = $user_info;
        }

        return response()->json($response);
    }

    public function continueOrder($id, Request $request)
    {
        $params = $request->all();

        $user = User::getUserByToken($request->header('Authorization'));
        $cart = Cart::find($id);
        validateCart($user, $cart, 'order');

        $order = $cart->order;

        checkOrderInventory($order);

        if (isset($params['address_id'])) {
            $address = Address::find($params["address_id"]);
            validateAddress($user, $address);
            $pincode_data        = $address->checkPincodeServiceable();
            $order->address_id   = $address->id;
            $order->address_data = $address->shippingAddress();
            $order->save();
        } else {
            $address      = $order->address;
            $pincode_data = $address->checkPincodeServiceable();
        }

        $response = ["items" => getCartData($cart, false), "summary" => $order->subOrderData(), "order_id" => $order->id, "address" => $order->address_data, "pincode_serviceability" => $pincode_data, "message" => 'Order Placed successfully'];

        $user_info = $user->userInfo();
        if ($user_info != null) {
            $response['user_info'] = $user_info;
        }

        return response()->json($response);
    }

    public function checkSubOrderInventory($id, Request $request)
    {
        $user  = User::getUserByToken($request->header('Authorization'));
        $order = Order::find($id);
        $cart  = $order->cart;
        validateCart($user, $cart, 'order');

        checkOrderInventory($order);

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
            $user = User::getUserByToken('Bearer ' . $_COOKIE['token']);
            validateOrder($user, $order);
        }

        $params = $order->getOrderDetailsItemWise();

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

    public static function updateSubOrderStatus($params)
    {
        SubOrderStatus::dispatch($params["subOrderId"], $params["state"], $params["is_shipped"], $params["is_invoiced"], $params["external_id"])->onQueue('odoo_order');
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
        $user          = User::getUserByToken($request->header('Authorization'));
        $user_id       = (isset($search_object["user_id"])) ? $search_object["user_id"] : $user->id;
        if ($user_id != $user->id) {
            if ($user->hasPermissionTo('see other user orders', 'web') == false) {
                return response()->json(["message" => 'Access denied', 'success' => false, 'data' => $order_details]);
            }

        }
        //$order_status = (isset($search_object["status"]))?$search_object["status"]:'payment-successful';
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

        // dd($orders);

        foreach ($orders as $order) {
            array_push($order_details, $order->getOrderDetailsItemWise());
        }
        // dd($order_details);

        return response()->json(["message" => 'Order items received successfully', 'success' => true, 'data' => $order_details]);
    }

    public function singleOrder($txnid, Request $request)
    {
        $user  = User::getUserByToken($request->header('Authorization'));
        $order = Order::where('txnid', $txnid)->first();
        validateOrder($user, $order);
        return response()->json(["message" => 'Order items received successfully', 'success' => true, 'data' => $order->getOrderDetailsItemWise()]);
    }

    public function cancelOrder($id, Request $request)
    {
        $user  = User::getUserByToken($request->header('Authorization'));
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
        $user      = User::getUserByToken($request->header('Authorization'));
        $sub_order = SubOrder::find($id);
        validateSubOrder($user, $sub_order);

        $request->validate(['reason' => 'required|exists:defaults,id', 'comments' => 'present', 'variant_id' => 'required|exists:variants,odoo_id', 'quantity' => 'required|integer|min:1']);
        $params = $request->all();

        $order_lines = $sub_order->orderLines->where('variant_id', $params['variant_id'])->where('shipment_status', 'delivered')->where('is_returned', false);

        if ($order_lines->count() < $params['quantity'] && !ReturnPolicy::fetchReturnPolicy($order_lines->first())['return_allowed']) {
            abort(403, 'Return not allowed');
        }

        foreach ($order_lines->take($params['quantity']) as $order_line) {

            $comment              = new Comment;
            $comment->reason_id   = $params['reason'];
            $comment->reason_type = 'return';
            $comment->comments    = $params['comments'];
            $comment->model_id    = $order_line->id;
            $comment->model_type  = get_class($order_line);
            $comment->save();

            $order_line->is_returned = true;
            $order_line->save();
        }

        $data = [
            'name'     => $user->name,
            'mobile'   => $user->phone,
            'txnno'    => $sub_order->order->txnid,
            'item'     => $order_lines->first()->title,
            'product_slug'     => $order_lines->first()->product_slug,
            'size'     => $order_lines->first()->size,
            'quantity' => $params['quantity'],
            'reason'   => Defaults::getReason($params['reason']),
            'comments' => $params['comments'],
        ];

        sendEmail('return-email', [
            'from'          => ["name" => [$user->name], "id" => [$user->email_id]],
            'subject'       => 'Request for Return - ' . $sub_order->order->txnid,
            'template_data' => [
                'data' => $data,
            ],
            'priority'      => 'default',
        ]);

        return response()->json(["message" => 'Return request placed successfully', 'success' => true]);
    }

}
