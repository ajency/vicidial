<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expression extends Model
{
	protected $casts = [
		'value' => 'array',
	];
    public function parent()
    {
        return $this->morphTo();
    }

    public function validate($cartData){
    	switch($this->filter){
    		case 'greater_than':
    			switch ('entity') {
    				case 'cart_price':
    					return ($cartData['final_total'] >= $this->value[0]);
    					break;
    				
    				default:
    					return false;
    					break;
    			}
    			break;
    		default:
    			return false;
    			break;
    	}
    }
}
