<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
	const ITEM_FIELDS = ['id','quantity'];

    protected $casts = [
        'cart_data' => 'array',
    ];

    function __construct(){
    	if($this->cart_data == null) $this->cart_data = array();
    	parent::__construct();
    }

    public function insert_item($item){
    	// \Log::info($item);
    	if(val_integer($item,self::ITEM_FIELDS)){
    		$item = array_only($item,self::ITEM_FIELDS);
    		$this->cart_data = array_merge([$item], $this->cart_data);  
    		// \Log::info($this->cart_data);
    	}else{
    		return false;
    	}
    	return $this;
    }

    public function item_count(){
    	return ($this->cart_data == null)? 0:count($this->cart_data);
    }

    // public function remove_item($id){
    // 	if(is_integer($id)){
    // 		$found = false;
    // 		$this->cart_data = array_except($this->cart_data, function($item) use ($found){
    // 			if ($id == $item["id"]){
    // 				$found = true;
    // 				return true;
    // 			}
    // 			return false;
    // 		});
    // 		return ($found)? $this:false;
    // 	}else{
    // 		return false;
    // 	}
    // }
}
