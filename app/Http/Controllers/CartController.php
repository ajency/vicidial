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
        $id = $request->session()->get('active_cart_id', false);
        // \Log::info('cart = '.$id);
        if ($id) {
            $cart = Cart::find($id);
            return response()->json(['cart_count' => $cart->item_count()]);
        } else {
            return abort('404', "Cart not found for this session");
        }
    }

    public function guestAddItem(Request $request)
    {
        // \Log::info('enters guest_get_count function');
        $params  = $request->all();
        $id      = $request->session()->get('active_cart_id', false);
        $cart    = ($id) ? Cart::find($id) : new Cart;
        $variant = Variant::where('odoo_id', $params['variant_id'])->first();
        $item    = $variant->getItemAttributes();
        if ($item) {
            $cart->insert_item(["id" => $params['variant_id'], "quantity" => $params['variant_quantity']]);
            // \Log::info($cart->cart_data);
            $cart->save();
            $message = "Item added successfully";
            $request->session()->put('active_cart_id', $cart->id);
        }
        return response()->json(['cart_count' => $cart->item_count(), "message" => $message, "item" => $item]);
    }

    public function guestCartFetch(Request $request)
    {
        $id          = $request->session()->get('active_cart_id', false);
        $cart        = ($id) ? Cart::find($id) : new Cart;
        $items       = [];
        $total_price = 0;
        foreach ($cart->cart_data as $cart_item) {
            $variant = Variant::where('odoo_id', $cart_item['id'])->first();
            $items[] = $variant->getItemAttributes();
            $total_price += $variant->getSalePrice();
        }

        $cart    = Cart::find($id);
        $summary = ["total" => $total_price, "discount" => 0, "tax" => "", "coupon" => ""];
        $code    = ["code" => "NEWUSER", "applied" => true];
        return response()->json(['items' => $items, "summary" => $summary, "code" => $code]);
    }

    public function test(Request $request)
    {
        // \Log::info('enters guest_get_count function');
        $params  = $request->all();
        $variant = Varient::where('odoo_id', 100)->first();
        return response()->json([
            "variant"       => $variant->getVariantData(),
            "related_items" => $variant->getRelatedItems(),
        ]);

    }
}
