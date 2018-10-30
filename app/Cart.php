<?php

namespace App;

use App\Variant;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    const ITEM_FIELDS = ['id', 'quantity'];

    protected $casts = [
        'cart_data' => 'array',
    ];

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
            $cart_data[$item["id"]] = ["id" => $item["id"], "quantity" => intval($item["quantity"])];
            $this->cart_data        = $cart_data;
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

    public function getSummary()
    {
        $total_price = 0;
        $discount    = 0;
        foreach ($this->cart_data as $cart_item) {
            $variant = Variant::where('odoo_id', $cart_item['id'])->first();
            $total_price += $variant->getSalePrice() * $cart_item["quantity"];
            $discount += $variant->getDiscount() * $cart_item["quantity"];
        }
        return ["total" => $total_price, "discount" => $discount, "tax" => "", "coupon" => "", "order_total" => $total_price - $discount];
    }

    public function removeItem($variant_id)
    {
        $cart_data = $this->cart_data;
        unset($cart_data[$variant_id]);
        $this->cart_data = $cart_data;
        return $this;
    }
}
