<?php

namespace App;

use App\Cart;
use App\SubOrder;
use Illuminate\Database\Eloquent\Model;
use Tzsk\Payu\Fragment\Payable;

class Order extends Model
{
    use Payable;
    
    public function subOrders()
    {
        return $this->hasMany('App\SubOrder');
    }

    public function cart()
    {
        return $this->belongsTo('App\Cart');
    }

    public function setSubOrders()
    {
        $cart       = Cart::find($this->cart_id);
        $warehouses = getWarehousesForCart($cart);
        $suborders  = generateSubordersData($cart->getItems(), collect($warehouses));
        // print_r($suborders);
        foreach ($suborders as $warehouseID => $items) {
            $subOrder               = new SubOrder;
            $subOrder->order_id     = $this->id;
            $subOrder->warehouse_id = $warehouseID;
            $subOrder->setItems($items);
            $subOrder->save();
            $subOrder->placeOrderOnOdoo();
        }
    }

    public function aggregateSubOrderData()
    {
        $total = [
            'untaxed_amount' => 0,
            'tax'            => 0,
            'total'          => 0,
            'shipping_fee'   => 0,
        ];
        $subOrders = $this->subOrders;

        foreach ($subOrders as $subOrder) {
            foreach ($total as $key => $value) {
                $total[$key] += $subOrder->odoo_data[$key];
            }
        }

        $total['final_price'] = $total['total'] + $total['shipping_fee'];

        return $total;
    }
}
