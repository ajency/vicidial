<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderLine extends Model
{
    protected $casts = [
        'images'   => 'array',
    ];

    protected $fillable = [
        'title',
        'variant_id',
        'images',
        'size',
        'price_mrp',
        'price_final',
        'discount_per',
        'product_id',
        'product_color_id',
        'product_slug',
    ];

    public function orders()
    {
        return $this->morphedByMany('App\Order', 'line_mapping');
    }

    public function ordersNew()
    {
        return $this->morphedByMany('App\Order', 'line_mapping')->wherePivot('type', 'New Transaction');
    }

    public function ordersCancelled()
    {
        return $this->morphedByMany('App\Order', 'line_mapping')->wherePivot('type', 'Cancelled Transaction');
    }

    public function ordersReturned()
    {
        return $this->morphedByMany('App\Order', 'line_mapping')->wherePivot('type', 'Returned Transaction');
    }

    public function subOrders()
    {
        return $this->morphedByMany('App\SubOrder', 'line_mapping');
    }

    public function subOrdersNew()
    {
        return $this->morphedByMany('App\SubOrder', 'line_mapping')->wherePivot('type', 'New Transaction');
    }

    public function subOrdersCancelled()
    {
        return $this->morphedByMany('App\SubOrder', 'line_mapping')->wherePivot('type', 'Cancelled Transaction');
    }

    public function subOrdersReturned()
    {
        return $this->morphedByMany('App\SubOrder', 'line_mapping')->wherePivot('type', 'Returned Transaction');
    }
}
