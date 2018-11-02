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

        return response()->json(["items"=>getCartData($cart, false), "summary"=>$order->aggregateSubOrderData(), "order_id"=>$order->id, "address"=>$address->address, "message"=> 'Order Placed successfully']);

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
        $user = User::find($user_id);

        $cart = new Cart;
        $cart->user_id = $user->id;
        $cart->save();

        $user->cart_id = $cart->id;
        $user->save();
    }

    public function getOrderDetails()
    {

        $params = [
            "order_info"=>[
                "order_id"=>"123",
                "txn_no"=>"#544545",
                "total_amount"=>420,
                "order_date"=>"20 Aug 2018",
                "no_of_items"=>1
            ],
            "sub_orders"=>[
                [   
                    "suborder_id" => 123,
                    "total" => 1830,
                    "number_of_items" => 2,
                    "items"=> [
                        [
                            "title" => "Cotton Rich Super Skinny Fit Jeans",
                            "size" => "2-4 years",
                            "quantity" => 1,
                            "price" => 869,
                            "variant_id" => 123,
                            "images"=> ""
                        ],
                        [
                            "title" => "Peach Casual Printed Tshirt",
                            "size" => "8-9 years",
                            "quantity" => 2,
                            "price" => 869,
                            "variant_id" => 123,
                            "images"=> ""
                        ]
                    ]
                ],
                [   
                    "suborder_id" => 244,
                    "total" => 4545,
                    "number_of_items" => 1,
                    "items"=> [
                        [
                            "title" => "Cotton Rich Super Skinny Fit Jeans",
                            "size" => "2-4 years",
                            "quantity" => 1,
                            "price" => 869,
                            "variant_id" => 123,
                            "images"=> ""
                        ]
                    ]
                ]
            ],
            "payment_info"=>[
                "payment_mode" => "mastercard",
                "card_num" => "512345XXXXXX2346",
            ],

            "shipping_address" => [
                "name"=> "Shashank",
                "phone"=> "1112224445",
                "pincode"=> 214547,
                "state"=> "Goa",
                "address"=> "Line4,Line5,line6",
                "locality"=> "qwersd",
                "landmark"=> "asdf",
                "city"=> "Mapusa",
                "type"=> "Home"
             ],

             "order_summary" => [
                        "total" => 12345,
                        "shipping_fee" => 123,
                        "final_price" => 13456,
                        "savings" => 345
            ]
        ];

        $params['breadcrumb']           = array();
        $params['breadcrumb']['list']   = array();
        $params['breadcrumb']['list'][] = ['name' => "Account", 'href' => '#'];
        $params['breadcrumb']['list'][] = ['name' => "Order", 'href' => '#'];
        $params['breadcrumb']['current'] = 'Order Details';

        $params['payment_status'] = "success";

        return view('orderdetails')->with('params',$params);
    }
}
