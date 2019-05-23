<?php

namespace App;

use Ajency\ServiceComm\Comm\Sync;
use App\Cart;
use App\Jobs\CancelOdooOrder;
use App\Jobs\OdooOrder;
use App\Jobs\OdooOrderLine;
use App\Jobs\OrderLineDeliveryDate;
use App\Jobs\ReturnOdooOrder;
use App\Jobs\SaveReturnPolicies;
use App\ReturnPolicy;
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
        'store_ids'      => 'array',
        'store_data'     => 'array',
        'verified'       => 'boolean',
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

    public function comments()
    {
        return $this->morphMany('App\Comment', 'model');
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
                // OrderlineIndex::dispatch($orderLineId)->onQueue('order_index');
            }
        }
        SaveReturnPolicies::dispatch($this->id)->onQueue('orderline_return_policy');
    }

    public function updateOrderlineIndex($fields){
        foreach ($this->orderlines as $orderline) {
            $changes = [];
            foreach ($fields as $field) {
                $changes['order_'.$field] = $this->$field;
            }
            $orderline->updateIndex($changes);
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
        $inventoryData = [];
        foreach ($this->subOrders as $subOrder) {
            $subOrder->odoo_status = 'draft';
            $subOrder->save();
            $variantQuantity = [];
            foreach ($subOrder->orderLines as $orderLine) {
                $orderLine->state = 'draft';
                $orderLine->save();
                try {
                    $orderLine->update(['orderline_state' => 'draft']);
                } catch (\Exception $e) {
                    \Log::error($e->message);
                }
                if (!isset($variantQuantity[$orderLine->variant_id])) {
                    $variantQuantity[$orderLine->variant_id] = 0;
                }
                $variantQuantity[$orderLine->variant_id] += 1;
            }
            $inventoryData[$subOrder->location_id] = $variantQuantity;
            OdooOrder::dispatch($subOrder, true)->onQueue('odoo_order');
        }
        Sync::call('inventory', 'reserveInventory', ['inventoryData' => $inventoryData]);
        /*if ($this->cart->coupon != null) {
    $odoo              = new OdooConnect;
    $currentCouponLeft = $odoo->defaultExec('sale.order.coupon', 'search_read', [[['global_code', '=', $this->cart->coupon]]], ['fields' => ['consumed_coupon_count']])->first();
    $odoo->defaultExec('sale.order.coupon', 'write', [[$currentCouponLeft['id']], ['consumed_coupon_count' => $currentCouponLeft['consumed_coupon_count'] - 1]], null);
    Coupon::where('odoo_id', $currentCouponLeft['id'])->update(['left_uses' => $currentCouponLeft['consumed_coupon_count'] - 1]);
    }*/
    }

    public function cancelOrderOnOdoo()
    {
        $order = self::create([
            'cart_id'      => $this->cart_id,
            'address_id'   => $this->address_id,
            'address_data' => $this->address_data,
            'expires_at'   => Carbon::now()->addMinutes(config('orders.expiry'))->timestamp,
            'type'         => 'Cancelled Transaction',
        ]);

        //create a job to place order on odoo for all suborders.
        foreach ($this->subOrders as $subOrder) {
            $cancelSubOrder              = new SubOrder;
            $cancelSubOrder->order_id    = $order->id;
            $cancelSubOrder->location_id = $subOrder->location_id;
            $cancelSubOrder->type        = 'Cancelled Transaction';
            $cancelSubOrder->item_data   = $subOrder->item_data;
            $cancelSubOrder->odoo_status = 'cancel';
            $cancelSubOrder->save();
            $cancelSubOrder->refresh();

            foreach ($subOrder->orderLines as $orderLine) {
                $cancelSubOrder->orderLines()->attach($orderLine->id, ['type' => $cancelSubOrder->type]);
                $order->orderLines()->attach($orderLine->id, ['type' => $order->type]);
                $orderLine->state = 'processing-cancel';
                $orderLine->save();
                $orderLine->index();
            }
            CancelOdooOrder::dispatch($cancelSubOrder, $subOrder->id)->onQueue('odoo_order');
        }

        return $order->id;
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
        $total['you_pay']          = $summary['you_pay'] + $total['shipping_fee'];
        $total['cart_discount']    = $summary['cart_discount'];

        $this->aggregate_data = $total;
    }

    public function getOrderInfo($verification = false)
    {
        $dateInd = Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at, 'UTC');
        $dateInd->setTimezone('Asia/Kolkata');

        $order_info = array('order_id' => $this->id, 'txn_no' => $this->txnid, 'order_status' => $this->status, 'amount_due' => $this->amountDue(), 'cancel_allowed' => $this->cancelAllowed(), 'total_amount' => $this->subOrderData()['you_pay'], 'order_date' => $dateInd->format('j M Y'), 'no_of_items' => $this->orderLines->groupBy('variant_id')->count());

        if ($this->cart->user->verified == null) {
            $order_info['token'] = $this->token;
        }

        if ($verification) {
            $order_info['verified'] = $this->verified;
        }

        return $order_info;
    }

    public function cancelAllowed()
    {
        foreach ($this->subOrders as $subOrder) {
            if ($subOrder->is_shipped || $subOrder->is_invoiced) {
                return false;
            }
        }

        foreach ($this->orderLines as $orderLine) {
            if (($orderLine->state != 'draft' && $orderLine->state != 'sale') || $orderLine->shipment_status != null) {
                return false;
            }
        }

        return true;
    }

    public function amountDue()
    {
        $amountDue = 0;
        if ($this->status == 'cash-on-delivery') {
            foreach ($this->subOrders as $subOrder) {
                if ($subOrder->orderLines->first()->shipment_status != 'delivered' && $subOrder->orderLines->first()->state != 'cancel') {
                    $amountDue += $subOrder->odoo_data['you_pay'];
                }
            }
        }

        return $amountDue;
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

    public function getOrderDetailsItemWise($verification = false)
    {
        $items = array();
        foreach ($this->subOrders as $subOrder) {
            $items = array_merge($items, $subOrder->getSubOrderItemWise());
        }

        $params = [
            "order_info"       => $this->getOrderInfo($verification),
            "items"            => $items,
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
        $link = ($this->cart->user->verified != null) ? url('/#/account/my-orders/') . '/' . $this->txnid : url('/my/order/details') . '?ordertoken=' . $this->token;
        sendSMS('order-success', [
            'to'      => $this->cart->user->phone,
            'message' => "Your order with order id {$this->txnid} for Rs. {$this->subOrderData()['you_pay']} has been placed successfully on KidSuperStore.in. Check your order at " . $link,
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
        if ($this->status == 'payment-successful') {
            $this->transaction_mode = 'Prepaid';
            $this->save();
        }
        foreach ($this->subOrders as $subOrder) {
            $subOrder->setOrderLines();
            $orderLineIds = $subOrder->orderLineIds;
            foreach ($orderLineIds as $orderLineId) {
                $subOrder->orderLines()->attach($orderLineId, ['type' => $subOrder->type]);
                $this->orderLines()->attach($orderLineId, ['type' => $this->type]);
            }
            $subOrder->refresh();
            if ($this->status == 'payment-successful') {
                $subOrder->odoo_status = 'draft';
                $subOrder->save();
                foreach ($subOrder->orderLines as $orderLine) {
                    $orderLine->state = 'draft';
                    $orderLine->save();
                }
                OdooOrder::dispatch($subOrder, false)->onQueue('odoo_order');
            }
        }
    }

    public static function addStoreToOrders($start, $end)
    {
        $orders = self::where('id', '>=', $start)->where('id', '<=', $end)->get();
        foreach ($orders as $order) {
            $storeData         = $order->getStoreData();
            $order->store_ids  = $storeData['store_ids'];
            $order->store_data = $storeData['store_data'];
            $order->save();
        }
    }

    public function getStoreData()
    {
        $store_ids  = [];
        $store_data = [];
        foreach ($this->subOrders as $subOrder) {
            array_push($store_ids, $subOrder->location->warehouse_odoo_id);
            array_push($store_data, ['id' => $subOrder->location->warehouse_odoo_id, 'name' => $subOrder->location->warehouse_name]);
        }
        return ['store_ids' => $store_ids, 'store_data' => $store_data];
    }

    public static function saveDeliveryDate($order_from_id, $order_to_id)
    {
        $orders = self::select('id')->where('id', '>=', $order_from_id)->where('id', '<=', $order_to_id)->get()->pluck('id');
        foreach ($orders as $order_id) {
            OrderLineDeliveryDate::dispatch($order_id)->onQueue('orderline_return_policy');
        }
    }

    public function placeReturnRequest($params, $sub_order)
    {
        $order_lines      = $this->orderLines->where('variant_id', $params['variant_id'])->where('shipment_status', 'delivered')->where('is_returned', false);
        $order_line_first = $order_lines->first();
        if ($order_lines->count() < $params['quantity'] || !ReturnPolicy::fetchReturnPolicy($order_line_first)['return_allowed']) {
            abort(403, 'Return not allowed');
        }

        $order = self::create([
            'cart_id'      => $this->cart_id,
            'address_id'   => $this->address_id,
            'address_data' => $this->address_data,
            'expires_at'   => Carbon::now()->addMinutes(config('orders.expiry'))->timestamp,
            'type'         => 'Return Transaction',
        ]);
        $order->new_transaction_id = $this->id;
        $order->save();

        $returnSubOrder                     = new SubOrder;
        $returnSubOrder->order_id           = $order->id;
        $returnSubOrder->location_id        = $sub_order->location_id;
        $returnSubOrder->type               = 'Return Transaction';
        $returnSubOrder->item_data          = [];
        $returnSubOrder->odoo_data          = ['you_pay' => $params['quantity'] * $order_line_first['price_discounted']];
        $returnSubOrder->odoo_status        = 'return';
        $returnSubOrder->new_transaction_id = $sub_order->id;
        $returnSubOrder->save();
        $returnSubOrder->refresh();

        foreach ($order_lines->take($params['quantity']) as $order_line) {
            $returnSubOrder->orderLines()->attach($order_line->id, ['type' => $returnSubOrder->type]);
            $order->orderLines()->attach($order_line->id, ['type' => $order->type]);
            $comment              = new Comment;
            $comment->reason_id   = $params['reason'];
            $comment->reason_type = 'return';
            $comment->comments    = $params['comments'];
            $comment->model_id    = $order_line->id;
            $comment->model_type  = get_class($order_line);
            $comment->save();
            $order_line->is_returned = true;
            $order_line->save();
            $order_line->index();
        }

        ReturnOdooOrder::dispatch($returnSubOrder)->onQueue('odoo_order');
    }

    public function getTrackbackUrlCashBackWorld()
    {
        // Your organization ID; provided by Cashback World.
        $organization = config("orders.cash_back_world.organization_id");
        // Event ID; provided by Cashback World.
        $event = config("orders.cash_back_world.event_id");
        // Secret Code; provided by Cashback World.
        $secretcode = config("orders.cash_back_world.secret_code");
        /* The orderValue is the basis for the commission paid to Cashback World. */
        $orderValue = $this->aggregate_data['you_pay'];
        // Currency of the sale.
        $currency = config("orders.cash_back_world.currency");
        $orderNumber = $this->txnid;
        // Event type: i.e. true = Sale; & false = Lead
        $isSale = true;
        // OPTIONAL: You may transmit a list of items ordered in the reportInfo parameter.
        $reportInfo = "";
        $reportInfo = urlencode($reportInfo);

        $tduid = "";
        if (!empty($_COOKIE[config("orders.cash_back_world.cookie_name")])) {
            $tduid = $_COOKIE[config("orders.cash_back_world.cookie_name")];
        } else {
            return false;
        }

        if ($isSale) {
            $domain = "tbs.tradedoubler.com";
            $checkNumberName = "orderNumber";
        } else {
            $domain = "tbl.tradedoubler.com";
            $checkNumberName = "leadNumber";
            $orderValue = "1";
        }

        $checksum = "v04" . md5($secretcode . $orderNumber . $orderValue);

        $trackBackUrl = "https://" . $domain . "/report"
        . "?organization=" . $organization
        . "&event=" . $event
        . "&" . $checkNumberName . "=" . $orderNumber
        . "&checksum=" . $checksum
        . "&tduid=" . $tduid
        . "&type=iframe"
        . "&reportInfo=" . $reportInfo;
        if ($isSale)
        {
        $trackBackUrl .= "&orderValue=" . $orderValue . "&currency=" . $currency;
        }
        return $trackBackUrl;
    }
}
