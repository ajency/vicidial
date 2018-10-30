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
        foreach ($this->itemData as $itemData) {
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
}
