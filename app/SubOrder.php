<?php

namespace App;

use App\Variant;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Elastic\OdooConnect;
use App\Warehouse;

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

    public function placeOrderOnOdoo()
    {
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

    public static function createOrderLine($i, Variant $variant, int $quantity)
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

    public static function createOrderParams(array $order_lines = [])
    {
        $company_id = 1;
        $date_order = new Carbon;
        $options    = array_merge(config('orders.odoo_orderline_defaults'),
        [
            'partner_id'               => $this->order->cart->user->odoo_id,
            'partner_invoice_id'       => $this->order->address->odoo_id,
            'partner_shipping_id'      => $this->order->address->odoo_id,
            'warehouse_id'             => $this->warehouse_id,
            'company_id'               => Warehouse::find($this->warehouse_id)->company_id,
            'date_order'               => $date_order->toDateTimeString(),
            'origin'                   => "test000000245",
            "name"                     => "test000000245",
            "order_line"               => $order_lines,
        ]);
        return $options;
    }

    public function createOdooOrder(array $params)
    {
        $model = "sale.order";
        $odoo  = new OdooConnect;
        $out   = $odoo->defaultExec($model, 'write', [$params], null);
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
