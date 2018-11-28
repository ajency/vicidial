<?php

namespace App;

use App\Variant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    const ITEM_FIELDS = ['id', 'quantity'];
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
            $variant = Variant::find($cart_item['id']);
            $total_price += $variant->getSalePrice() * $cart_item["quantity"];
            $discount += $variant->getDiscount() * $cart_item["quantity"];
        }
        return ["total" => $total_price, "discount" => $discount, "tax" => "", "coupon" => "", "order_total" => $total_price];
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

    public function abortNotCart($type)
    {
        if($this->type==null && $type=='cart') return;
        
        if ($this->type != $type) {
            abort(403);
        }
    }
}
