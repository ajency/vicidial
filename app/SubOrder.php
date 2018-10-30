<?php

namespace App;

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

    public function setItems($items){
    	$itemsData = [];
    	foreach ($items as $itemData) {
    		$itemsData[] = [
    			'id' => $itemData['item']->id,
    			'quantity' => $itemData['quantity'],
    		];
    	}
    	$this->item_data = $itemsData;
    }

	public function placeOrderOnOdoo(){
		$this->odoo_id = 0;
		$this->odoo_data = [
			'untaxed_amount' => 1.5,
			'tax' => 1,
			'round_off' => 0.5,
			'total' => 2
		];
		$this->odoo_status = 'draft';
		$this->save();
	}
}
