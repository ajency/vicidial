<?php

namespace App;

use App\Variant;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Elastic\OdooConnect;

class SubOrder extends Model
{
    protected $casts = [
        'item_data' => 'array',
        'odoo_data' => 'array',
    ];

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function location()
    {
        return $this->belongsTo('App\Location', 'location_id', 'odoo_id');
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
                'price_discounted' => $this->order->cart->getDiscountedPrice($variant),
            ];
        }
        $this->item_data = $itemsData;
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
                if ($itemData['quantity'] > $itemData['item']->inventory[$this->location_id]['quantity']) {
                    $this->order->cart->type = 'failure';
                    $this->order->cart->save();
                    if($abort) {
                        abort(410, 'Items no longer available in store');
                    }
                    else {
                        return 'failure';
                    }
                }
            }
        }
    }

    public function placeOrder()
    {
        if ($this->odoo_id == null) {
            $order_lines = [];
            $itemsData   = [];
            foreach ($this->item_data as $itemData) {
                $variant            = Variant::find($itemData['id']);
                $item               = $variant->getItemAttributes();
                $item['quantity']   = $itemData['quantity'];
                $item['variant_id'] = $itemData['id'];
                $itemsData[]        = $item;
                $order_line = self::createOrderLine($variant, $itemData);
                $lines[]    = $order_line;
            }
            $odoo_order  = self::createOrderParams($lines);
            $id = $this->createOdooOrder($odoo_order);
            //$order = $this->getSaleOrder($id);
            
            $this->odoo_id   = $id;
            $this->odoo_status = 'draft';
            $this->save();
        }
    }

    public function getSubOrder()
    {
        $itemsData = [];
        foreach ($this->item_data as $itemData) {
            $variant                = Variant::find($itemData['id']);
            $item                   = $variant->getItemAttributes();
            $item['quantity']       = $itemData['quantity'];
            $item['variant_id']     = $itemData['id'];
            $item['product_slug']   = $variant->getProductSlug();
            $itemsData[]            = $item;
        }
        $sub_order = array('suborder_id' => $this->id, 'total' => $this->odoo_data['you_pay'], 'number_of_items' => count($this->item_data), 'items' => $itemsData);
        $store_address = $this->location->getAddress();
        if($store_address!=null) {
            $sub_order['store_address'] = $store_address;
        }

        return $sub_order;
    }

    // public function abondonOrder()
    // {
    //     $items = $this->item_data;
    //     foreach ($items as $item) {
    //         $variant = Variant::find($item['id']);
    //         $variant->inventory[$this->warehouse_id]['quantity'] += $item['quantity'];
    //         $variant->save();
    //     }
    //     $this->item_data = [];
    //     $this->save();
    // }

    // public function save(array $options = [])
    // {
    //     if ($this->id == null) {
    //         $items = $this->item_data;
    //         foreach ($items as $item) {
    //             $variant = Variant::find($item['id']);
    //             $variant->inventory[$this->warehouse_id]['quantity'] -= $item['quantity'];
    //             $variant->save();
    //         }
    //     }
    //     parent::save($options);
    // }

    public function createOrderLine(Variant $variant, array $itemData)
    {
        $order_line = [
            0,
            0,
            array_merge(config('orders.odoo_orderline_defaults'),
            [
                "product_id"         => $variant->odoo_id,
                "product_uom_qty"    => $itemData['quantity'],
                "price_unit"         => $itemData['price_discounted'],
                "discount"           => 0,
                "name"               => $variant->getName(),
            ]),
        ];
        return $order_line;
    }

    public function createOrderParams(array $order_lines = [])
    {
        $date_order = new Carbon;
        $address = $this->order->address->odoo_id;
        $generated_name = $this->location->location_name.'/'.$this->order->txnid;
        $options    = array_merge(config('orders.odoo_order_defaults'),
        [
            'partner_id'               => $this->order->cart->user->odoo_id,
            'partner_invoice_id'       => $address,
            'partner_shipping_id'      => $address,
            'warehouse_id'             => $this->location->warehouse->odoo_id,
            'company_id'               => $this->location->company_odoo_id,
            'date_order'               => $date_order->toDateTimeString(),
            'origin'                   => $generated_name,
            "name"                     => $generated_name,
            "order_line"               => $order_lines,
        ]);
        return $options;
    }

    public function createOdooOrder(array $params)
    {
        $model = "sale.order";
        $odoo  = new OdooConnect;
        $out   = $odoo->defaultExec($model, 'create', [$params], null);
        try{
            return $out[0];
        }
        catch(\Exception $e){
            throw new \Exception($out);
        }
    }

    /*public function getSaleOrder(int $id)
    {
        $model = "sale.order";
        $odoo  = new OdooConnect;
        $out   = $odoo->defaultExec($model, "read", [$id]);
        return $out[0];
    }*/

    public static function rectifyOldSubOrders($subOrders)
    {
        foreach ($subOrders as $subOrder) {
            $items     = $subOrder->getItems();
            $itemsData = [];
            foreach ($items as $itemData) {
                $itemsData[] = [
                    'id'               => $itemData['item']->id,
                    'quantity'         => $itemData['quantity'],
                    'price_mrp'        => $itemData['item']->getLstPrice(),
                    'price_final'      => $itemData['item']->getSalePrice(),
                    'discount'         => $itemData['item']->getDiscount(),
                    'price_discounted' => $subOrder->order->cart->getDiscountedPrice($itemData['item']),
                ];
            }
            $subOrder->item_data = $itemsData;
            $subOrder->aggregateData();
            $subOrder->save();
        }
    }
}
