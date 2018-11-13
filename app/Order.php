<?php

namespace App;

use App\Cart;
use App\SubOrder;
use App\Jobs\OdooOrder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tzsk\Payu\Fragment\Payable;

class Order extends Model
{
    use Payable;

    protected $fillable = ['cart_id', 'address_id', 'expires_at'];

    public function subOrders()
    {
        return $this->hasMany('App\SubOrder');
    }

    public function cart()
    {
        return $this->belongsTo('App\Cart');
    }

    public function address()
    {
        return $this->belongsTo('App\Address');
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
            $subOrder->aggregateData();
            $subOrder->save();
        }
    }

    public function checkInventoryForSuborders()
    {
        foreach ($this->subOrders as $subOrder) {
            $subOrder->checkInventory();
        }
    }

    public function placeOrderOnOdoo(){
        //create a job to place order on odoo for all suborders.
        foreach ($this->subOrders as $subOrder) {
            OdooOrder::dispatch($subOrder)->onQueue('odoo_order');
        }
    }

    public function aggregateSubOrderData()
    {
        $total = [
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
        $total['savings']     = 70;

        return $total;
    }

    public function getOrderInfo()
    {
        $dateInd = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at, 'UTC');
        $dateInd->setTimezone('Asia/Kolkata');

        $order_info = array('order_id' => $this->id, 'txn_no' => $this->txnid, 'total_amount' => $this->aggregateSubOrderData()['final_price'], 'order_date' => $dateInd->format('j M Y'), 'no_of_items' => count($this->cart->getItems()));

        return $order_info;
    }
}
