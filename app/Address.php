<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $casts = [
        'address' => 'array', 
        'default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
