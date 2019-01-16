<?php

namespace App;

use App\Promotion;
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

    public function promotion()
    {
        return $this->hasOne('App\Promotion', 'id', 'promotion_id');
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
            $this->applyPromotion($this->getBestPromotion());
            // \Log::info($this->cart_data);
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

    public function getCartDiscount($spt)
    {
        if ($this->promotion != null) {
            if ($this->promotion->discount_type == "cart_fixed") {
                $discount = $this->promotion->value;
            } elseif ($this->promotion->discount_type == "by_percent") {
                $discount = round($spt * $this->promotion->value / 100.0,2);
            }
        } else {
            $discount = 0;
        }

        return $discount;
    }

    public function getSummary()
    {
        $spt      = $this->getCartSalePriceTotal();
        $discount = $this->getCartDiscount($spt);
        return [
            "mrp_total"        => $this->getCartMrpPriceTotal(),
            "sale_price_total" => $spt,
            "cart_discount"    => $discount,
            "you_pay"          => $spt - $discount,
        ];
    }

    public function removeItem($variant_id)
    {
        $cart_data = $this->cart_data;
        unset($cart_data[$variant_id]);
        $this->cart_data = $cart_data;
        $this->applyPromotion($this->getBestPromotion());
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

    public function getItems()
    {
        $items = [];
        foreach ($this->cart_data as $cart_item) {
            $items[] = [
                'item'     => Variant::find($cart_item['id']),
                'quantity' => $cart_item["quantity"],
            ];
        }
        return $items;
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

    public function getBestPromotion()
    {
        $salePrice       = $this->getCartSalePriceTotal();
        $promotions      = Promotion::where('active', true)->where('step_quantity', '<=', $salePrice)->where('start', '<=', Carbon::now())->where('expire', '>', Carbon::now())->get();
        $apply_promotion = null;
        $discSalePrice   = $salePrice;
        foreach ($promotions as $promotion) {
            if ($promotion->discount_type == "cart_fixed") {
                $discountedSalePrice = $salePrice - $promotion->value;
            } elseif ($promotion->discount_type == "by_percent") {
                $discountedSalePrice = $salePrice - ($salePrice * $promotion->value / 100.0);
            }
            if ($discountedSalePrice < $discSalePrice) {
                $discSalePrice   = $discountedSalePrice;
                $apply_promotion = $promotion->id;
            }
        }
        return $apply_promotion;
    }

    public function applyPromotion($promotion_id)
    {
        $promotion = Promotion::find($promotion_id);
        if ($this->isPromotionApplicable($promotion)) {
            $this->promotion_id = $promotion_id;
            $this->save();
        }
    }

    public function isPromotionApplicable($promotion)
    {
        if ($promotion == null) {
            return true;
        }
        if ($promotion->active == false || $promotion->step_quantity > $this->getCartSalePriceTotal() || $promotion->start > Carbon::now() || $promotion->expire < Carbon::now()) {
            return false;
        }
        return true;
    }

    public function getDiscountedPrice($variant)
    {
        $spt                    = $this->getCartSalePriceTotal();
        $discount_ratio         = $this->getCartDiscount($spt) / floatval($spt);
        $variant_discount_price = $variant->getSalePrice() * (1 - $discount_ratio);
        return $variant_discount_price;
    }
}
