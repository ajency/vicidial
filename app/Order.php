<?php

namespace App;

use Ajency\Connections\OdooConnect;
use App\Cart;
use App\Jobs\OdooOrder;
use App\Jobs\OdooOrderLine;
use App\SubOrder;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Tzsk\Payu\Fragment\Payable;

class Order extends Model
{
    use Payable;

    protected $casts = [
        'address_data'   => 'array',
        'aggregate_data' => 'array',
    ];

    protected $fillable = ['cart_id', 'address_id', 'address_data', 'expires_at', 'type'];

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

    public function orderLines()
    {
        return $this->morphToMany('App\OrderLine', 'line_mapping');
    }

    public function setSubOrders()
    {
        $cart = Cart::find($this->cart_id);
        // $locations = Location::where('use_in_inventory',true)->pluck('odoo_id');
        $address   = $this->address;
        $locations = Location::getLocationScores($address->latitude, $address->longitude);
        $suborders = generateSubordersData($cart->getItems(true), $locations);
        // print_r($suborders);
        foreach ($suborders as $locationID => $items) {
            $subOrder              = new SubOrder;
            $subOrder->order_id    = $this->id;
            $subOrder->location_id = $locationID;
            $subOrder->type        = 'New Transaction';
            $subOrder->setItems($items);
            $subOrder->aggregateData();
            $subOrder->save();

            $orderLineIds = $subOrder->orderLineIds;
            $subOrder->refresh();
            foreach ($orderLineIds as $orderLineId) {
                $subOrder->orderLines()->attach($orderLineId, ['type' => $subOrder->type]);
                $this->orderLines()->attach($orderLineId, ['type' => $this->type]);
            }
        }
    }

    public function checkInventoryForSuborders()
    {
        foreach ($this->subOrders as $subOrder) {
            $subOrder->checkInventory();
        }
    }

    public function placeOrderOnOdoo()
    {
        //create a job to place order on odoo for all suborders.
        foreach ($this->subOrders as $subOrder) {
            $subOrder->odoo_status = 'processing';
            $subOrder->save();
            $subOrder->orderLines->update(['status' => 'processing']);
            OdooOrder::dispatch($subOrder, true)->onQueue('odoo_order');
        }
        if ($this->cart->coupon != null) {
            $odoo              = new OdooConnect;
            $currentCouponLeft = $odoo->defaultExec('sale.order.coupon', 'search_read', [[['global_code', '=', $this->cart->coupon]]], ['fields' => ['consumed_coupon_count']])->first();
            $odoo->defaultExec('sale.order.coupon', 'write', [[$currentCouponLeft['id']], ['consumed_coupon_count' => $currentCouponLeft['consumed_coupon_count'] - 1]], null);
            Coupon::where('odoo_id', $currentCouponLeft['id'])->update(['left_uses' => $currentCouponLeft['consumed_coupon_count'] - 1]);
        }

    }

    public function subOrderData()
    {
        return $this->aggregate_data;
    }

    public function aggregateSubOrderData()
    {
        $total = [
            'shipping_fee' => 0,
        ];
        $subOrders = $this->subOrders;

        foreach ($subOrders as $subOrder) {
            foreach ($total as $key => $value) {
                $total[$key] += $subOrder->odoo_data[$key];
            }
        }

        $summary = $this->cart->getSummary();

        $total['mrp_total']        = $summary['mrp_total'];
        $total['sale_price_total'] = $summary['sale_price_total'];
        $total['you_pay']          = $summary['you_pay'];
        $total['cart_discount']    = $summary['cart_discount'];

        $this->aggregate_data = $total;
    }

    public function getOrderInfo()
    {
        $dateInd = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at, 'UTC');
        $dateInd->setTimezone('Asia/Kolkata');

        $order_info = array('order_id' => $this->id, 'txn_no' => $this->txnid, 'total_amount' => $this->subOrderData()['you_pay'], 'order_date' => $dateInd->format('j M Y'), 'no_of_items' => count($this->cart->getItems()));

        if ($this->cart->user->verified == null) {
            $order_info['token'] = $this->token;
        }

        return $order_info;
    }

    public function getOrderDetails()
    {
        $sub_orders = array();
        foreach ($this->subOrders as $subOrder) {
            $sub_orders[] = $subOrder->getSubOrder();
        }

        $params = [
            "order_info"       => $this->getOrderInfo(),
            "sub_orders"       => $sub_orders,
            "shipping_address" => $this->address_data,
            "order_summary"    => $this->subOrderData(),
        ];

        $payment = $this->payments->first();
        if ($payment != null) {
            $params['payment_info'] = [
                //"payment_mode" => $payment->bankcode,
                "payment_mode" => json_decode($payment->data)->bankcode,
                "card_num"     => $payment->cardnum,
            ];
        }

        return $params;
    }

    public function sendSuccessEmail()
    {
        sendEmail('order-success', [
            'to'            => $this->cart->user->email_id,
            'from'          => config('communication.order-success.from'),
            'subject'       => 'Thank you for your order at Kidsuperstore.in',
            'template_data' => [
                'order' => $this,
            ],
            'priority'      => 'default',
        ]);
    }

    public function sendSuccessSMS()
    {
        sendSMS('order-success', [
            'to'      => $this->cart->user->phone,
            'message' => "Your order with order id {$this->txnid} for Rs. {$this->subOrderData()['you_pay']} has been placed successfully on KidSuperStore.in. Check your order at " . url('/#/account/my-orders/') . "/{$this->txnid}",
        ]);
    }

    //sms to the stores
    public function sendVendorSMS()
    {
        $numbers = array();
        foreach ($this->subOrders as $subOrder) {
            if ($subOrder->location->warehouse->phone_number) {
                array_push($numbers, $subOrder->location->warehouse->phone_number);
            }
        }
        sendSMS('order-vendor', [
            'to'      => $numbers,
            'message' => "You have received an Order from " . $this->cart->user->name,
        ]);
    }

    public static function rectifyOldOrders()
    {
        $orders = self::where('aggregate_data', null)->get();
        foreach ($orders as $order) {
            SubOrder::rectifyOldSubOrders($order->subOrders);
            $order->aggregateSubOrderData();
            if ($order->address_data == null && $order->address != null) {
                $order->address_data = $order->address->shippingAddress();
            }
            $order->save();
        }
    }

    public static function addOrderlinesforOldOrders($start, $end)
    {
        $orders = self::where('id', '>=', $start)->where('id', '<=', $end)->get();
        foreach ($orders as $order) {
            OdooOrderLine::dispatch($order)->onQueue('odoo_order_line');
        }
    }

    public function addOrderlines()
    {
        foreach ($this->subOrders as $subOrder) {
            $subOrder->setOrderLines();
            $orderLineIds = $subOrder->orderLineIds;
            foreach ($orderLineIds as $orderLineId) {
                $subOrder->orderLines()->attach($orderLineId, ['type' => $subOrder->type]);
                $this->orderLines()->attach($orderLineId, ['type' => $this->type]);
            }
            $subOrder->refresh();
            if ($this->status == 'payment-successful') {
                $subOrder->odoo_status = 'processing';
                $subOrder->save();
                $subOrder->orderLines->update(['status' => 'processing']);
                OdooOrder::dispatch($subOrder, false)->onQueue('odoo_order');
            }
        }
    }
}
