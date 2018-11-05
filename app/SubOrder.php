<?php

namespace App;

use App\Variant;
use Illuminate\Database\Eloquent\Model;

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

    public function placeOrderOnOdoo()
    {
        $this->odoo_id   = 0;
        $this->odoo_data = [
            'untaxed_amount' => 1.5,
            'tax'            => 1,
            'total'          => 2,
            'shipping_fee'   => 0,
        ];
        $this->odoo_status = 'draft';
        $this->save();
    }

    public function getSubOrder()
    {
        $itemsData = [];
        foreach ($this->item_data as $itemData) {
            $variant = Variant::find($itemData['id']);
            $item = $variant->getItemAttributes();
            $item['quantity'] = $itemData['quantity'];
            $item['variant_id'] = $itemData['id'];
            $itemsData[] = $item;
        }
        $sub_order = array('suborder_id' => $this->id, 'total' => $this->odoo_data['total']+$this->odoo_data['shipping_fee'], 'number_of_items' => count($this->item_data), 'items' => $itemsData);

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
}
