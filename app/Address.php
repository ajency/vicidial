<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
	protected $casts = [
        'address' => 'array',
        'default' => 'boolean',
        'active' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function shippingAddress()
    {
        $address_data = $this->address;
        $address_data["id"] = $this->id;
        $address_data["type"] = $this->type;
        $address_data["default"] = $this->default;

        return $address_data;
    }
}
