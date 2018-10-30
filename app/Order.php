<?php

namespace App;

use App\Cart;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function subOrders()
    {
        return $this->hasMany('App\SubOrder');
    }

    public function seperateSubOrders()
    {
        $cart       = Cart::find($this->cart_id);
        $warehouses = getWarehousesForCart($cart);
        $suborders  = generateSuborder($cart->getItems(), collect($warehouses));
    }
}
