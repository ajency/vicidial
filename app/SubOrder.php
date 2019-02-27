<?php

namespace App;

use Ajency\ServiceComm\Comm\Sync;
use App\Variant;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class SubOrder extends Model
{
    protected $casts = [
        'item_data'   => 'array',
        'odoo_data'   => 'array',
        'is_invoiced' => 'boolean',
    ];

    public $orderLineIds = [];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function location()
    {
        return $this->belongsTo('App\Location', 'location_id', 'odoo_id');
    }

    public function orderLines()
    {
        return $this->morphToMany('App\OrderLine', 'line_mapping');
    }

    public function setItems($items)
    {
        $itemsData = [];
        foreach ($items as $itemData) {
            $variant     = Variant::find($itemData['variant']->id);
            $itemsData[] = [
                'id'               => $itemData['variant']->id,
                'quantity'         => $itemData['quantity'],
                'price_mrp'        => $variant->getLstPrice(),
                'price_final'      => $variant->getSalePrice(),
                'discount'         => $variant->getDiscount(),
                'price_discounted' => $itemData['price_final'],
            ];

            $item = $variant->getItemAttributes();

            for ($qty = 1; $qty <= $itemData['quantity']; $qty++) {
                $orderLine = OrderLine::create(array_merge($item, [
                    'variant_id'       => $variant->odoo_id,
                    'price_discounted' => $itemData['price_final'],
                    'name'             => $variant->getName(),
                    'product_id'       => $variant->getParentId(),
                    'product_color_id' => $variant->getVarColorId(),
                    'product_slug'     => $variant->getProductSlug(),
                ]));
                array_push($this->orderLineIds, $orderLine->id);
            }
        }
        $this->item_data = $itemsData;
    }

    public function setOrderLines()
    {
        foreach ($this->item_data as $itemData) {
            $variant = Variant::find($itemData['id']);

            $item = $variant->getItemAttributes();

            for ($qty = 1; $qty <= $itemData['quantity']; $qty++) {
                $orderLine = OrderLine::create(array_merge($item, [
                    'variant_id'       => $variant->odoo_id,
                    'price_discounted' => $itemData['price_discounted'],
                    'name'             => $variant->getName(),
                    'product_id'       => $variant->getParentId(),
                    'product_color_id' => $variant->getVarColorId(),
                    'product_slug'     => $variant->getProductSlug(),
                ]));
                array_push($this->orderLineIds, $orderLine->id);
            }
        }
    }

    public function getItems()
    {
        $itemsData = [];
        foreach ($this->item_data as $itemData) {
            $itemsData[] = [
                'item'     => Variant::find($itemData['id']),
                'quantity' => $itemData['quantity'],
            ];
        }
        return $itemsData;
    }

    public function aggregateData()
    {
        $items            = $this->item_data;
        $mrp_total        = 0;
        $sale_price_total = 0;
        $you_pay          = 0;
        $cart_discount    = 0;
        $shipping_fee     = 0;
        foreach ($items as $itemData) {
            $mrp_total += $itemData['quantity'] * $itemData['price_mrp'];
            $sale_price_total += $itemData['quantity'] * $itemData['price_final'];
            $you_pay += $itemData['quantity'] * $itemData['price_discounted'];
            $cart_discount += $itemData['quantity'] * ($itemData['price_final'] - $itemData['price_discounted']);
        }
        $this->odoo_data = [
            'mrp_total'        => $mrp_total,
            'sale_price_total' => $sale_price_total,
            'you_pay'          => $you_pay + $shipping_fee,
            'cart_discount'    => $cart_discount,
            'shipping_fee'     => $shipping_fee,
        ];
    }

    public function checkInventory($abort = true)
    {
        if ($this->odoo_id == null) {
            $items = $this->getItems();
            foreach ($items as $itemData) {
                if (!isset($itemData['item']->inventory[$this->location_id]) || ($itemData['quantity'] > $itemData['item']->inventory[$this->location_id]['quantity'])) {
                    $this->order->cart->type = 'failure';
                    $this->order->cart->save();
                    if ($abort) {
                        abort(410, 'Items no longer available in store');
                    } else {
                        return 'failure';
                    }
                }
            }
        }
    }

    public function placeOrder($placeorder)
    {
        $sub_order_data = [
            'user_external_id'      => $this->order->cart->user->odoo_id,
            'address_external_id'   => $this->order->address->odoo_id,
            'location_external_id'  => $this->location->id,
            'warehouse_external_id' => $this->location->warehouse->odoo_id,
            'company_external_id'   => $this->location->company_odoo_id,
            'sub_order_id'          => $this->id,
            'location_txn_id'       => $this->location->location_name . '/' . $this->order->txnid,
            'item_data'             => $this->orderLines->toArray(),
            'payment_data'          => $this->odoo_data,
            'type'                  => $this->type,
            'order_date'            => Carbon::now()->toDateTimeString(),
            'transaction_mode'      => $this->order->transaction_mode,
        ];

        if ($this->odoo_id) {
            $sub_order_data['external_id'] = $this->odoo_id;
        }

        Sync::call('backoffice', 'createOPRJob', ['sub_order_data' => $sub_order_data, 'placeorder' => $placeorder]);
    }

    public function getSubOrder()
    {
        $itemsData = [];
        foreach ($this->item_data as $itemData) {
            $variant                  = Variant::find($itemData['id']);
            $item                     = $variant->getItemAttributes();
            $item['quantity']         = $itemData['quantity'];
            $item['variant_id']       = $itemData['id'];
            $item['product_id']       = $variant->getParentId();
            $item['product_color_id'] = $variant->getVarColorId();
            $item['product_slug']     = $variant->getProductSlug();
            $itemsData[]              = $item;
        }
        $sub_order     = array('suborder_id' => $this->id, 'total' => $this->odoo_data['you_pay'], 'number_of_items' => count($this->item_data), 'items' => $itemsData);
        $store_address = $this->location->getAddress();
        if ($store_address != null) {
            $sub_order['store_address'] = $store_address;
        }

        return $sub_order;
    }

    public static function rectifyOldSubOrders($subOrders)
    {
        foreach ($subOrders as $subOrder) {
            $items     = $subOrder->getItems(true);
            $itemsData = [];
            foreach ($items as $itemData) {
                $itemsData[] = [
                    'id'               => $itemData['item']->id,
                    'quantity'         => $itemData['quantity'],
                    'price_mrp'        => $itemData['item']->getLstPrice(),
                    'price_final'      => $itemData['item']->getSalePrice(),
                    'discount'         => $itemData['item']->getDiscount(),
                    'price_discounted' => $itemData['price_final'],
                ];
            }
            $subOrder->item_data = $itemsData;
            $subOrder->aggregateData();
            $subOrder->save();
        }
    }

    public static function updateSubOrderStatus($subOrderId, $state, $is_invoiced, $external_id)
    {
        $subOrder              = self::find($subOrderId);
        $subOrder->odoo_id     = $external_id;
        $subOrder->is_invoiced = $is_invoiced;
        $subOrder->odoo_status = $state;
        $subOrder->save();
        foreach ($subOrder->orderLines as $orderLine) {
            $orderLine->state = $state;
            $orderLine->save();
        }
    }
}
