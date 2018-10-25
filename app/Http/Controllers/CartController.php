<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Variant;
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
            return response()->json(['cart_count' => $cart->itemCount()]);
        } else {
            return abort('404', "Cart not found for this session");
        }
    }

    public function userAddItem($id, Request $request)
    {
        $params  = $request->all();
        $cart    = ($id) ? Cart::find($id) : new Cart;
        $variant = Variant::where('odoo_id', $params['variant_id'])->first();
        $item    = $variant->getItem();
        if ($item) {
            $qty = $params['variant_quantity'];
            if ($cart->itemExists($item)) {
                $qty += $cart->cart_data[$item["id"]]["quantity"];
            }
            $cart->insertItem(["id" => $params['variant_id'], "quantity" => $qty]);
            $cart->save();
            $message          = "Item added successfully";
            $item["quantity"] = intval($cart->cart_data[$item["id"]]["quantity"]);
        }
        $summary = $cart->getSummary();
        return response()->json(['cart_count' => $cart->itemCount(), "message" => $message, "item" => $item, "summary" => $summary]);
    }

    public function guestAddItem(Request $request)
    {
        $params  = $request->all();
        $id      = $request->session()->get('active_cart_id', false);
        $cart    = ($id) ? Cart::find($id) : new Cart;
        $variant = Variant::where('odoo_id', $params['variant_id'])->first();
        $item    = $variant->getItem();
        if ($item) {
            $qty = $params['variant_quantity'];
            if ($cart->itemExists($item)) {
                $qty += $cart->cart_data[$item["id"]]["quantity"];
            }
            $cart->insertItem(["id" => $params['variant_id'], "quantity" => $qty]);
            $cart->save();
            $message = "Item added successfully";
            $request->session()->put('active_cart_id', $cart->id);
            $item["quantity"] = intval($cart->cart_data[$item["id"]]["quantity"]);
        }
        $summary = $cart->getSummary();
        return response()->json(['cart_count' => $cart->itemCount(), "message" => $message, "item" => $item, "summary" => $summary]);
    }

    public function userCartFetch($id, Request $request)
    {
        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Cart not found for this session");
        }

        $items = [];
        foreach ($cart->cart_data as $cart_item) {
            $variant          = Variant::where('odoo_id', $cart_item['id'])->first();
            $item             = $variant->getItem();
            $item["quantity"] = intval($cart->cart_data[$item["id"]]["quantity"]);
            $items[]          = $item;
        }
        $summary = $cart->getSummary();
        $code    = ["code" => "NEWUSER", "applied" => true];
        return response()->json(['cart_count' => $cart->itemCount(), 'items' => $items, "summary" => $summary, "code" => $code]);
    }

    public function guestCartFetch(Request $request)
    {
        $id   = $request->session()->get('active_cart_id', false);
        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Cart not found for this session");
        }

        $items = [];
        foreach ($cart->cart_data as $cart_item) {
            $variant          = Variant::where('odoo_id', $cart_item['id'])->first();
            $item             = $variant->getItem();
            $item["quantity"] = intval($cart->cart_data[$item["id"]]["quantity"]);
            $items[]          = $item;
        }
        $summary = $cart->getSummary();
        $code    = ["code" => "NEWUSER", "applied" => true];
        return response()->json(['cart_count' => $cart->itemCount(), 'items' => $items, "summary" => $summary, "code" => $code]);
    }

    public function guestCartDelete(Request $request)
    {
        $id     = $request->session()->get('active_cart_id', false);
        $params = $request->all();

        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Cart not found for this session");
        }
        $cart->removeItem($params["variant_id"]);
        $cart->save();
        $message = "Item deleted successfully";
        $summary = $cart->getSummary();
        return response()->json(['cart_count' => $cart->itemCount(), 'message' => $message, "summary" => $summary]);
    }

    public function userCartDelete($id, Request $request)
    {
        $params = $request->all();

        $cart = Cart::find($id);
        if ($cart == null) {
            abort(404, "Cart not found for this session");
        }
        $cart->removeItem($params["variant_id"]);
        $cart->save();
        $message = "Item deleted successfully";
        $summary = $cart->getSummary();
        return response()->json(['cart_count' => $cart->itemCount(), 'message' => $message, "summary" => $summary]);
    }
}
