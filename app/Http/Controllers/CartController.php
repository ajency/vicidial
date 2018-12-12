<?php

namespace App\Http\Controllers;

use App\Cart;
use App\User;
use App\Variant;
use App\Promotion;
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
        return response()->json(['cart_count' => $cart->itemCount(), "message" => $message, "item" => $item,'promo_applied' => $cart->promotion_id, "summary" => $summary]);
    }

    public function guestAddItem(Request $request)
    {
        $request->validate(['variant_id' => 'required|exists:variants,odoo_id', 'variant_quantity' => 'required']);
        $params = $request->all();
        $id     = $request->session()->get('active_cart_id', false);
        $cart   = ($id) ? Cart::find($id) : new Cart;
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
        return response()->json(['cart_count' => $cart->itemCount(), "message" => $message, "item" => $item, 'promo_applied' => $cart->promotion_id, "summary" => $summary]);
    }

    public function userCartFetch($id, Request $request)
    {
        $cart = Cart::find($id);
        if ($cart == null) {
            abort(400, "Invalid Cart");
        }
        checkUserCart($request->header('Authorization'), $cart);
        if($cart->type == 'order-complete') abort(400);
        if($cart->type == 'order') {
            $cart->type = (checkOrderInventory($cart->order, false) == 'failure') ? 'failure' : 'order';
        }

        $items = getCartData($cart, true, isNotProd());

        $code    = ["code" => "NEWUSER", "applied" => true];
        if(!$cart->isPromotionApplicable($cart->promotion) && $cart->type == 'cart'){
            $cart->applyPromotion($cart->getBestPromotion());
            $cart->refresh();
        }
        $summary = $cart->getSummary();
        $promotions = Promotion::getAllPromotions($cart,'web');
        return response()->json(['cart_count' => $cart->itemCount(), 'cart_type' => $cart->type, 'items' => $items,'promo_applied' => $cart->promotion_id, "promotions" => $promotions, "summary" => $summary, "code" => $code]);
    }

    public function guestCartFetch(Request $request)
    {
        $id   = $request->session()->get('active_cart_id', false);
        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Cart not found for this session");
        }
        if($cart->type == 'order-complete') abort(400);
        $items = getCartData($cart, true, isNotProd());

        $code    = ["code" => "NEWUSER", "applied" => true];
        if(!$cart->isPromotionApplicable($cart->promotion) && $cart->type == 'cart'){
            $cart->applyPromotion($cart->getBestPromotion());
            $cart->refresh();
        }
        $summary = $cart->getSummary();
        $promotions = Promotion::getAllPromotions($cart,'web');
        return response()->json(['cart_count' => $cart->itemCount(), 'cart_type' => $cart->type, 'items' => $items,'promo_applied' => $cart->promotion_id, "summary" => $summary, "promotions" => $promotions, "code" => $code]);
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
        $cart->abortNotCart('cart');
        $cart->removeItem($params["variant_id"]);
        $cart->save();
        $cart->refresh();
        $message = "Item deleted successfully";
        $summary = $cart->getSummary();
        $promotions = Promotion::getAllPromotions($cart,'web');
        return response()->json(['cart_count' => $cart->itemCount(), 'message' => $message,'promo_applied' => $cart->promotion_id, "summary" => $summary, "promotions" => $promotions]);
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
        $message = "Item deleted successfully";
        $summary = $cart->getSummary();
        $promotions = Promotion::getAllPromotions($cart,'web');
        return response()->json(['cart_count' => $cart->itemCount(), 'message' => $message,'promo_applied' => $cart->promotion_id, "summary" => $summary, "promotions" => $promotions]);
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
        $cart->abortNotCart('cart');

        foreach ($cart->cart_data as $variant_id => $variant_details) {
            $variant = Variant::find($variant_id);
            if ($variant->getQuantity() < $variant_details['quantity']) {
                abort(404, "Quantity not available");
            }
        }

        if(!$cart->isPromotionApplicable($cart->promotion)) {
            abort(404, "Promotion not applicable");
        }

        return response()->json(["message" => 'Items are available in store', 'success'=> true]);
    }

    public function userCartPromotion($id, Request $request){
        $request->validate(['promotion_id' => 'required|exists:promotions,id']);
        $params = $request->all();

        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Requested Cart ID not found");
        }
        $cart->abortNotCart('cart');
        $user    = User::getUserByToken($request->header('Authorization'));
        validateCart($user, $cart, 'cart');
        if($cart->isPromotionApplicable($params['promotion_id'])){
            $cart->applyPromotion($params['promotion_id']);
            $cart->refresh();
            return response()->json(["cart_count"=>$cart->itemCount(), "summary" => $cart->getSummary(), "message" => "promotion applied successfully", "promo_applied" => $promotion_id]);
        }else{
            abort(400, "Promo cannot be applied");
        }
    }

    public function guestCartPromotion(Request $request)
    {
        $request->validate(['promotion_id' => 'required|exists:promotions,id']);
        $id     = $request->session()->get('active_cart_id', false);
        $params = $request->all();

        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Cart not found for this session");
        }
        $cart->abortNotCart('cart');
        if($cart->isPromotionApplicable($params['promotion_id'])){
            $cart->applyPromotion($params['promotion_id']);
            $cart->refresh();
            return response()->json(["cart_count"=>$cart->itemCount(), "summary" => $cart->getSummary(), "message" => "promotion applied successfully", "promo_applied" => $promotion_id]);
        }else{
            abort(400, "Promo cannot be applied");
        }
    }
}
