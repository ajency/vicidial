<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Jobs\CreateOrderlineIndexJobs;

class OrderLine extends Model
{
    protected $casts = [
        'images'        => 'array',
        'return_policy' => 'array',
        'is_returned'   => 'boolean',
    ];

    protected $fillable = [
        'title',
        'name',
        'variant_id',
        'images',
        'size',
        'price_mrp',
        'price_final',
        'price_discounted',
        'discount_per',
        'product_id',
        'product_color_id',
        'product_slug',
        'product_type',
        'product_subtype',
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

    public static function indexAllOrderLines($min = false, $max = false){
        $orderlines = self::select('id');
        if($min){
            $orderlines->where('id','>', $min);
        }
        if($max){
            $orderlines->where('id','<', $max);
        }
        $orderlines->pluck('id')->chunk(30)->each(function ($chunkedOrderLines) {
            CreateOrderlineIndexJobs::dispatch($chunkedOrderLines)->onQueue('order_index');
        });
    }

}
