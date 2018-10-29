<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubOrder extends Model
{
	public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
