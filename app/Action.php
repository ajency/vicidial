<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
	protected $casts = [
		'value' => 'array',
	];
	
    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }
}
