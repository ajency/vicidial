<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CashOnDelivery extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_id',
        'phone',
    ];
}
