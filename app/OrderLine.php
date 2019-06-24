<?php

namespace App;

use App\Jobs\CreateOrderlineIndexJobs;
use App\Jobs\OrderlineIndex;
use App\Jobs\UpdateOrderLineIndex;
use Illuminate\Database\Eloquent\Model;

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

    public function comments()
    {
        return $this->morphMany('App\Comment', 'model');
    }

    public static function indexAllOrderLines($min = false, $max = false)
    {
        $orderlines = self::select('id');
        if ($min) {
            $orderlines->where('id', '>', $min);
        }
        if ($max) {
            $orderlines->where('id', '<', $max);
        }
        $orderlines->pluck('id')->chunk(30)->each(function ($chunkedOrderLines) {
            CreateOrderlineIndexJobs::dispatch($chunkedOrderLines)->onQueue('order_index');
        });
    }

    public function index()
    {
        OrderlineIndex::dispatch($this->id)->onQueue('order_index');
    }

    public function updateIndex($changes)
    {
        UpdateOrderLineIndex::dispatch($this->id, $changes)->onQueue('order_index');
    }

    public static function updateMultipleIndex($params)
    {
        foreach ($params['orderLines'] as $key => $changes) {
            $ol = self::find($key);
            $ol->updateIndex($changes);
        }
    }

    public function flatData()
    {
        $indexData                               = [];
        $orderline                               = $this;
        $indexData['orderline_id']               = $orderline->id;
        $indexData['orderline_title']            = $orderline->title;
        $indexData['orderline_name']             = $orderline->name;
        $indexData['orderline_variant_id']       = $orderline->variant_id;
        $indexData['orderline_images']           = $orderline->images;
        $indexData['orderline_size']             = $orderline->size;
        $indexData['orderline_price_mrp']        = (float) $orderline->price_mrp;
        $indexData['orderline_price_final']      = (float) $orderline->price_final;
        $indexData['orderline_price_discounted'] = (float) $orderline->price_discounted;
        $indexData['orderline_discount_per']     = (float) $orderline->discount_per;
        $indexData['orderline_product_id']       = $orderline->product_id;
        $indexData['orderline_product_color_id'] = $orderline->product_color_id;
        $indexData['orderline_product_slug']     = $orderline->product_slug;
        $indexData['orderline_state']            = $orderline->state;
        $indexData['orderline_shipment_status']  = $orderline->shipment_status;
        if ($orderline->shipment_delivery_date) {
            $indexData['orderline_shipment_delivery_date'] = (new Carbon($orderline->shipment_delivery_date))->timestamp;
        }

        if ($orderline->return_expiry_date) {
            $indexData['orderline_return_expiry_date'] = (new Carbon($orderline->return_expiry_date))->timestamp;
        }
        $indexData['orderline_return_policy']   = $orderline->return_policy;
        $indexData['orderline_product_type']    = $orderline->product_type;
        $indexData['orderline_product_subtype'] = $orderline->product_subtype;
        $indexData['orderline_is_returned']     = $orderline->is_returned;
        $indexData['orderline_created_at']      = $orderline->created_at->timestamp;
        $indexData['orderline_updated_at']      = $orderline->updated_at->timestamp;
        $indexData['order_id']                  = $orderline->ordersNew->first()->id;
        $indexData['order_address_id']          = $orderline->ordersNew->first()->address_id;
        $indexData['order_transaction_mode']    = $orderline->ordersNew->first()->transaction_mode;
        $indexData['order_address_data']        = $orderline->ordersNew->first()->address_data;
        $indexData['order_aggregate_data']      = $orderline->ordersNew->first()->aggregate_data;
        $indexData['order_status']              = $orderline->ordersNew->first()->status;
        $indexData['order_txnid']               = $orderline->ordersNew->first()->txnid;

        if ($orderline->ordersReturned->first() !== null) {
            $indexData['return_order_id']                     = $orderline->ordersReturned->first()->id;
            $indexData['return_order_txnid']                  = $orderline->ordersReturned->first()->txnid;
            $indexData['return_order_reason_id']              = $orderline->ordersReturned->comments->first()->reason_id;
            $indexData['return_order_reason_additional_text'] = $orderline->ordersReturned->comments->first()->comments;
            $indexData['return_suborder_id']                  = $orderline->subOrdersReturned->first()->id;
        }

        if ($orderline->ordersCancelled->first() !== null) {
            $indexData['cancel_order_id']                     = $orderline->ordersCancelled->first()->id;
            $indexData['cancel_order_txnid']                  = $orderline->ordersCancelled->first()->txnid;
            $indexData['cancel_order_reason_id']              = $orderline->ordersCancelled->first()->comments->first()->reason_id;
            $indexData['cancel_order_reason_additional_text'] = $orderline->ordersCancelled->first()->comments->first()->comments;
            $indexData['cancel_suborder_id']                  = $orderline->subOrdersCancelled->first()->id;
        }

        $indexData['suborder_id']          = $orderline->subOrdersNew->first()->id;
        $indexData['suborder_status']      = $orderline->subOrdersNew->first()->odoo_status;
        $indexData['suborder_is_shipped']  = $orderline->subOrdersNew->first()->is_shipped;
        $indexData['suborder_is_invoiced'] = $orderline->subOrdersNew->first()->is_invoiced;
        $indexData['suborder_odoo_data']   = $orderline->subOrdersNew->first()->odoo_data;

        $indexData['location_id']    = $orderline->subOrdersNew->first()->location->warehouse_odoo_id;
        $indexData['location_name']  = $orderline->subOrdersNew->first()->location->warehouse_name;
        $indexData['location_db_id'] = $orderline->subOrdersNew->first()->location->id;

        $indexData['user_id']    = $orderline->ordersNew->first()->cart->user->id;
        $indexData['user_email'] = $orderline->ordersNew->first()->cart->user->email_id;
        $indexData['user_phone'] = $orderline->ordersNew->first()->cart->user->phone;
        $indexData['user_name']  = $orderline->ordersNew->first()->cart->user->name;

        return $indexData;
    }

    public static function indexWaybillToOrderLines($min = false, $max = false)
    {
        $orderlines = self::select('id');
        if ($min) {
            $orderlines->where('id', '>', $min);
        }
        if ($max) {
            $orderlines->where('id', '<', $max);
        }
        $orderlines->pluck('id')->chunk(30)->each(function ($chunkedOrderLines) {
            WayBillOrderlineIndex::dispatch($chunkedOrderLines)->onQueue('order_index');
        });
    }

}
