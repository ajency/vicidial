<?php

namespace App;

use App\Coupon;
use App\Offer;
use App\Variant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    const ITEM_FIELDS   = ['id', 'quantity'];
    protected $fillable = ['user_id', 'active', 'type'];

    protected $casts = [
        'cart_data' => 'array',
    ];

    public function order()
    {
        return $this->hasOne('App\Order');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function __construct()
    {
        if ($this->cart_data == null) {
            $this->cart_data = array();
        }

        parent::__construct();
    }

    public function insertItem($item)
    {
        // \Log::info($item);
        if (valInteger($item, self::ITEM_FIELDS)) {
            $item                   = array_only($item, self::ITEM_FIELDS);
            $cart_data              = $this->cart_data;
            $cart_data[$item["id"]] = ["id" => $item["id"], "quantity" => intval($item["quantity"]), 'timestamp' => Carbon::now()->timestamp];
            $this->cart_data        = $cart_data;

        } else {
            return false;
        }
        return $this;
    }

    public function itemExists($item)
    {
        if (isset($this->cart_data[$item["id"]])) {
            return true;
        }
        return false;
    }

    public function itemCount()
    {
        $total = 0;
        foreach ($this->cart_data as $key => $item) {
            $total += $item["quantity"];
        }
        return $total;
    }

    public function getCartSalePriceTotal()
    {
        $total_price = 0;
        foreach ($this->cart_data as $cart_item) {
            $variant = Variant::find($cart_item['id']);
            $total_price += $variant->getSalePrice() * $cart_item["quantity"];
        }
        return $total_price;
    }

    public function getCartMrpPriceTotal()
    {
        $total_price = 0;
        foreach ($this->cart_data as $cart_item) {
            $variant = Variant::find($cart_item['id']);
            $total_price += $variant->getLstPrice() * $cart_item["quantity"];
        }
        return $total_price;
    }

    public function getSummary()
    {
        $cartData = Offer::processData($this->flatData());
        return [
            "mrp_total"        => $cartData['mrp_total'],
            "sale_price_total" => $cartData['sale_total'],
            "cart_discount"    => $cartData['discount'],
            "you_pay"          => $cartData['final_total'],
        ];
    }

    public function removeItem($variant_id)
    {
        $cart_data = $this->cart_data;
        unset($cart_data[$variant_id]);
        $this->cart_data = $cart_data;

        return $this;
    }

    public function getItem(int $variant_id, $fetch_related = true, $current_quantity = false)
    {
        $variant = Variant::find($variant_id);
        if ($variant == null) {
            abort(404);
        }

        $item                 = $variant->getItem($fetch_related, $current_quantity);
        $item["quantity"]     = intval($this->cart_data[$item["id"]]["quantity"]);
        $item["timestamp"]    = intval($this->cart_data[$item["id"]]["timestamp"]);
        $item["availability"] = ($variant->getQuantity() >= $item["quantity"]);

        return $item;
    }

    public function getItems($offerData = false)
    {
        $items = [];
        if ($offerData) {
            $cartData = Offer::processData($this->flatData());
            foreach ($cartData['items'] as $id => $cart_item) {
                $cartData['items'][$id]['item'] = Variant::find($id);
            }
            return array_values($cartData['items']);
        } else {
            foreach ($this->cart_data as $cart_item) {
                $items[] = [
                    'item'     => Variant::find($cart_item['id']),
                    'quantity' => $cart_item["quantity"],
                ];
            }
            return $items;
        }
    }

    public function checkCartAvailability()
    {
        foreach ($this->cart_data as $cart_item) {
            $item = $this->getItem($cart_item['id']);
            if (!$item["availability"]) {
                abort(404, "One or more items are Out of Stock");
            }

        }
    }

    public function abortNotCart($type, $skip_session = false)
    {
        if ($this->type == null && $type == 'cart') {
            return;
        }

        if ($this->type != $type) {
            if (!$skip_session) {
                request()->session()->forget('active_cart_id');
            }
            abort(403);
        }
    }

    public function anonymousCartCheckUser()
    {
        if ($this->user_id != null) {
            request()->session()->forget('active_cart_id');
            abort(403);
        }
    }

    public function checkCouponAvailability(){
        $cartData           = $this->flatData();
        $cartData           = Offer::processData($cartData);
        if($cartData['coupon'] != $this->coupon){
            $this->coupon = $cartData['coupon'];
            $this->save();
        }
        return [
            'messages'=> $cartData['messages'], 
            'coupon_applied'=> (isset($cartData['offersApplied'][0]))? $cartData['offersApplied'][0]->getCouponDetails():null,
        ];
    }

    public function applyCoupon($couponCode = null)
    {
        $cartData           = $this->flatData();
        $cartData['coupon'] = $couponCode;
        $cartData           = Offer::processData($cartData);
        if (empty($cartData['messages'])) {
            $this->coupon = $cartData['coupon'];
            $this->save();
            return [
                'coupon_applied' => (isset($cartData['offersApplied'][0]))? $cartData['offersApplied'][0]->getCouponDetails():null,
                'summary'        => [
                    'mrp_total'        => $cartData['mrp_total'],
                    'you_pay'          => $cartData['final_total'],
                    'cart_discount'    => $cartData['discount'],
                    'sale_price_total' => $cartData['sale_total'],
                ],
            ];
        } else {
            throw new \Exception(json_encode(array_values($cartData['messages'])));

        }
    }

    public function getDiscountedPrice($variant)
    {
        $spt                    = $this->getCartSalePriceTotal();
        $discount_ratio         = $this->getCartDiscount($spt) / floatval($spt);
        $variant_discount_price = $variant->getSalePrice() * (1 - $discount_ratio);
        return $variant_discount_price;
    }

    public function flatData()
    {
        $items    = $this->getItems();
        $cartData = ["items" => [], "coupon" => $this->coupon];
        foreach ($items as $item) {
            $singleItem                           = [];
            $singleItem['odoo_id']                = $item['item']->odoo_id;
            $singleItem['quantity']               = $item['quantity'];
            $singleItem['price_mrp']              = $item['item']->getLstPrice();
            $singleItem['price_sale']             = $item['item']->getSalePrice();
            $singleItem['brand']                  = $item['item']->getBrand();
            $singleItem['gender']                 = $item['item']->getGender();
            $singleItem['subtype']                = $item['item']->getSubtype();
            $cartData['items'][$item['item']->id] = $singleItem;
        }
        return $cartData;
    }
}
