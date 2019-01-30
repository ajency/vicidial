<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Cart;
use App\User;
use App\Variant;
use App\Offer;
use App\Coupon;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function guestGetCount(Request $request)
    {
        // \Log::info('enters guest_get_count function');
        $id   = $request->session()->get('active_cart_id', false);
        $cart = Cart::find($id);
        if ($cart !== null) {
            // \Log::debug('cart = '.$cart);
            $cart->anonymousCartCheckUser();
            $cart->abortNotCart('cart');
            return response()->json(['cart_count' => $cart->itemCount()]);
        } else {
            return abort('404', "Cart not found for this session");
        }
    }

    public function startFresh(Request $request){
        $user = User::getUserByToken($request->header('Authorization'));
        $cart = $user->newCart(true);
        return response()->json(['cart_id' => $cart->id]);
    }

    public function userAddItem($id, Request $request)
    {
        $request->validate(['variant_id' => 'required|exists:variants,odoo_id', 'variant_quantity' => 'required']);
        $params = $request->all();
        $cart   = Cart::find($id);
        if ($cart == null) {
            abort(400, "Invalid Cart");
        }
        $user    = User::getUserByToken($request->header('Authorization'));
        validateCart($user, $cart, 'cart');
        $variant = Variant::where('odoo_id', $params['variant_id'])->first();
        $item    = $variant->getItem(true, isNotProd());
        if ($item) {
            $qty = $params['variant_quantity'];
            if ($cart->itemExists($item)) {
                $qty += $cart->cart_data[$item["id"]]["quantity"];
            }

            if ($variant->getQuantity() >= $qty) {
                $cart->insertItem(["id" => $variant->id, "quantity" => $qty]);
                $cart->save();
                $cart->refresh();
                $message = "Item added successfully";
            } else {
                abort(404, "Quantity not available");
            }
            $item["quantity"]  = intval($cart->cart_data[$item["id"]]["quantity"]);
            $item["timestamp"] = intval($cart->cart_data[$item["id"]]["timestamp"]);
        }
        $summary = $cart->getSummary();
        return response()->json(['cart_count' => $cart->itemCount(), "message" => $message, "item" => $item, "summary" => $summary]);
    }

    public function guestAddItem(Request $request)
    {
        $request->validate(['variant_id' => 'required|exists:variants,odoo_id', 'variant_quantity' => 'required']);
        $params = $request->all();
        $id     = $request->session()->get('active_cart_id', false);
        $cart   = ($id) ? Cart::find($id) : new Cart;
        $cart->anonymousCartCheckUser();
        $cart->abortNotCart('cart');
        $variant = Variant::where('odoo_id', $params['variant_id'])->first();
        $item    = $variant->getItem(true, isNotProd());
        if ($item) {
            $qty = $params['variant_quantity'];
            if ($cart->itemExists($item)) {
                $qty += $cart->cart_data[$item["id"]]["quantity"];
            }

            if ($variant->getQuantity() >= $qty) {
                $cart->insertItem(["id" => $variant->id, "quantity" => $qty]);
                $cart->save();
                $cart->refresh();
                $message = "Item added successfully";
            } else {
                abort(404, "Quantity not available");
            }
            $request->session()->put('active_cart_id', $cart->id);
            $item["quantity"]  = intval($cart->cart_data[$item["id"]]["quantity"]);
            $item["timestamp"] = intval($cart->cart_data[$item["id"]]["timestamp"]);
        }
        $summary = $cart->getSummary();
        return response()->json(['cart_count' => $cart->itemCount(), "message" => $message, "item" => $item,  "summary" => $summary]);
    }

    public function userCartFetch($id, Request $request)
    {
        $cart = Cart::find($id);
        if ($cart == null) {
            abort(400, "Invalid Cart");
        }
        checkUserCart(User::getUserByToken($request->header('Authorization')), $cart);
        if($cart->type == 'order-complete') abort(400);
        if($cart->type == 'order') {
            $cart->type = (checkOrderInventory($cart->order, false) == 'failure') ? 'failure' : 'order';
        }

        $items = getCartData($cart, true, isNotProd());
        $coupons = Offer::getAllActiveCoupons();

        if($cart->coupon != null){
            $appliedCoupon = Coupon::where('display_code', $cart->coupon)->first()->offer->getCouponDetails();
        }else{
            $appliedCoupon = null;
        }
        
        $summary = $cart->getSummary();
        return response()->json(['cart_count' => $cart->itemCount(), 'cart_type' => $cart->type, 'items' => $items, 'applied_coupon' => $appliedCoupon, "coupons" => $coupons, "summary" => $summary]);
    }

    public function guestCartFetch(Request $request)
    {
        $id   = $request->session()->get('active_cart_id', false);
        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Cart not found for this session");
        }
        $cart->anonymousCartCheckUser();
        $cart->abortNotCart('cart');
        $items = getCartData($cart, true, isNotProd());

        if($cart->coupon != null){
            $appliedCoupon = Coupon::where('display_code', $cart->coupon)->first()->offer->getCouponDetails();
        }else{
            $appliedCoupon = null;
        }
    
        $coupons = Offer::getAllActiveCoupons();


        $summary = $cart->getSummary();
        return response()->json(['cart_count' => $cart->itemCount(), 'cart_type' => $cart->type, 'items' => $items, "summary" => $summary,'applied_coupon' => $appliedCoupon, "coupons" => $coupons, ]);
    }

    public function guestCartDelete(Request $request)
    {
        $request->validate(['variant_id' => 'required|exists:variants,id']);
        $id     = $request->session()->get('active_cart_id', false);
        $params = $request->all();

        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Cart not found for this session");
        }
        $cart->anonymousCartCheckUser();
        $cart->abortNotCart('cart');
        $cart->removeItem($params["variant_id"]);
        $cart->save();
        $cart->refresh();
        $available = $cart->checkCouponAvailability();
        $available['messages']['item-delete'] = "Item deleted successfully";
        $summary = $cart->getSummary();
        $coupons = Offer::getAllActiveCoupons();
        return response()->json(array_merge(['cart_count' => $cart->itemCount(), "summary" => $summary, "coupons" => $coupons],$available));
    }

    public function userCartDelete($id, Request $request)
    {
        $request->validate(['variant_id' => 'required|exists:variants,id']);
        $params = $request->all();

        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Requested Cart ID not found");
        }
        $user    = User::getUserByToken($request->header('Authorization'));
        validateCart($user, $cart, 'cart');
        $cart->removeItem($params["variant_id"]);
        $cart->save();
        $cart->refresh();
        $available = $cart->checkCouponAvailability();
        $available['messages']['item-delete'] = "Item deleted successfully";
        $summary = $cart->getSummary();
        $coupons = Offer::getAllActiveCoupons();
        return response()->json(array_merge(['cart_count' => $cart->itemCount(), "summary" => $summary, "coupons" => $coupons],$available));
    }

    public function getCartID(Request $request)
    {
        $user = User::getUserByToken($request->header('Authorization'));
        $cart = Cart::find($user->cart_id);
        return response()->json(["cart_id" => $user->cart_id, "cart_type" => $cart->type]);
    }

    public function checkStatus(Request $request)
    {
        $id     = $request->session()->get('active_cart_id', false);
        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Cart not found for this session");
        }
        $cart->anonymousCartCheckUser();
        $cart->abortNotCart('cart');

        foreach ($cart->cart_data as $variant_id => $variant_details) {
            $variant = Variant::find($variant_id);
            if ($variant->getQuantity() < $variant_details['quantity']) {
                abort(404, "Quantity not available = $cart->chec");
            }
        }

        
        return response()->json(["message" => 'Items are available in store', 'success'=> true]);
    }

    public function userCartCoupon($id, Request $request){
        $request->validate(['coupon_code' => 'required']);
        $params = $request->all();

        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Requested Cart ID not found");
        }
        $cart->abortNotCart('cart');
        $user    = User::getUserByToken($request->header('Authorization'));
        validateCart($user, $cart, 'cart');
        try{
            $apply = $cart->applyCoupon($params['coupon_code']);
            $cart->refresh();
            if($cart->coupon != null){
                $apply['messages'] = ['Coupon Applied successfully']; //Take from config
            }else{
                $apply['messages'] = ['Coupon removed successfully'];
            }
            return response()->json($apply);
        }catch (\Exception $e){
            abort(400,json_decode($e->getMessage())[0]);
        }
        
    }

    public function guestCartCoupon(Request $request)
    {
        $request->validate(['coupon_code' => 'required']);
        $id     = $request->session()->get('active_cart_id', false);
        $params = $request->all();

        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Cart not found for this session");
        }
        $cart->anonymousCartCheckUser();
        $cart->abortNotCart('cart');
        try{
            $apply = $cart->applyCoupon($params['coupon_code']);
            $cart->refresh();
            if($cart->coupon != null){
                $apply['messages'] = ['Coupon Applied successfully']; //Take from config
            }else{
                $apply['messages'] = ['Coupon removed successfully'];
            }
            return response()->json($apply);
        }catch (\Exception $e){
            abort(400,$e->message);
        }
        
    }
}
