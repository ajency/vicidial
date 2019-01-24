<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
	protected $fillable = ['odoo_id'];
    public function offer(){
    	return $this->belongsTo('App\Offer');
    }
}
