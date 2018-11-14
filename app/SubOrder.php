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

    public function warehouse()
    {
        return $this->belongsTo('App\Warehouse');
    }

    public function setItems($items)
    {
        $itemsData = [];
        // print_r($items);
        foreach ($items as $itemData) {
            $itemsData[] = [
                'id'       => $itemData['variant']->id,
                'quantity' => $itemData['quantity'],
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
        $items = $this->getItems();
        $total = 0;
        foreach ($items as $itemData) {
            $total += $itemData['item']->getSalePrice();
        }
        $this->odoo_data = [
            'total'        => $total,
            'shipping_fee' => 0,
        ];
    }

    public function checkInventory()
    {
        if ($this->odoo_id == null) {
            $items = $this->getItems();
            foreach ($items as $itemData) {
                if ($itemData['quantity'] > $itemData['item']->inventory[$this->warehouse_id]['quantity']) {
                    abort(410, 'Items no longer available in store');
                }
            }
        }
    }

    public function placeOrder()
    {
        if ($this->odoo_id == null) {
            $this->checkInventory();
            $order_lines = [];
            $itemsData   = [];
            $i           = 0;
            foreach ($this->item_data as $itemData) {
                $variant            = Variant::find($itemData['id']);
                $item               = $variant->getItemAttributes();
                $item['quantity']   = $itemData['quantity'];
                $item['variant_id'] = $itemData['id'];
                $itemsData[]        = $item;
                $order_line = self::createOrderLine($i, $variant, $itemData['quantity']);
                $lines[]    = $order_line;
                $i++;
            }
            $odoo_order  = self::createOrderParams($lines);
            $id = $this->createOdooOrder($odoo_order);
            $order = $this->getSaleOrder($id);
            
            $this->odoo_id   = $order["id"];
            $this->odoo_data = [
                'total'          => $order["amount_total"],
                'shipping_fee'   => $order["shipping_charge"],
            ];
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
        $sub_order = array('suborder_id' => $this->id, 'total' => $this->odoo_data['total'] + $this->odoo_data['shipping_fee'], 'number_of_items' => count($this->item_data), 'items' => $itemsData);
        $store_address = $this->warehouse->getAddress();
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

    public function createOrderLine($i, Variant $variant, int $quantity)
    {
        $order_line = [
            $i,
            "virtual_" . $variant->id,
            array_merge(config('orders.odoo_orderline_defaults'),
            [
                "product_id"         => $variant->odoo_id,
                "product_uom_qty"    => $quantity,
                "price_unit"         => $variant->getSalePrice(),
                "discount"           => $variant->getDiscount(),
                "name"               => $variant->getName(),
            ]),
        ];
        return $order_line;
    }

    public function createOrderParams(array $order_lines = [])
    {
        $date_order = new Carbon;
        $address = $this->order->address->odoo_id;
        $generated_name = $this->warehouse->name.$date_order->toDateTimeString().random_int(1000, 9999);
        $options    = array_merge(config('orders.odoo_order_defaults'),
        [
            'partner_id'               => $this->order->cart->user->odoo_id,
            'partner_invoice_id'       => $address,
            'partner_shipping_id'      => $address,
            'warehouse_id'             => $this->warehouse_id,
            'company_id'               => $this->warehouse->company_id,
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
        return $out[0];
    }

    public function getSaleOrder(int $id)
    {
        $model = "sale.order";
        $odoo  = new OdooConnect;
        $out   = $odoo->defaultExec($model, "read", [$id]);
        return $out[0];
    }
}
