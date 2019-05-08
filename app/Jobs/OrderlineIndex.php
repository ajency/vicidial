<?php

namespace App\Jobs;

use App\OrderLine;
use Ajency\Connections\ElasticQuery;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderlineIndex implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $indexData = [];
        $orderline = OrderLine::find($this->id);
        $indexData['orderline_id'] = $orderline->id;
        $indexData['orderline_title'] = $orderline->title;
        $indexData['orderline_name'] = $orderline->name;
        $indexData['orderline_variant_id'] = $orderline->variant_id;
        $indexData['orderline_images'] = $orderline->images;
        $indexData['orderline_size'] = $orderline->size;
        $indexData['orderline_price_mrp'] = (float) $orderline->price_mrp;
        $indexData['orderline_price_final'] = (float) $orderline->price_final;
        $indexData['orderline_price_discounted'] = (float) $orderline->price_discounted;
        $indexData['orderline_discount_per'] = (float) $orderline->discount_per;
        $indexData['orderline_product_id'] = $orderline->product_id;
        $indexData['orderline_product_color_id'] = $orderline->product_color_id;
        $indexData['orderline_product_slug'] = $orderline->product_slug;
        $indexData['orderline_state'] = $orderline->state;
        $indexData['orderline_shipment_status'] = $orderline->shipment_status;
        $indexData['orderline_shipment_delivery_date'] = $orderline->shipment_delivery_date;
        $indexData['orderline_return_expiry_date'] = $orderline->return_expiry_date;
        $indexData['orderline_return_policy'] = $orderline->return_policy;
        $indexData['orderline_product_type'] = $orderline->product_type;
        $indexData['orderline_product_subtype'] = $orderline->product_subtype;
        $indexData['orderline_is_returned'] = $orderline->is_returned;
        $indexData['orderline_created_at'] = $orderline->created_at->timestamp;
        $indexData['orderline_updated_at'] = $orderline->updated_at->timestamp;

        $indexData['order_address_id'] = $orderline->address_id;
        $indexData['order_type'] = $orderline->ordersNew->first()->type;
        $indexData['order_transaction_mode'] = $orderline->ordersNew->first()->transaction_mode;
        $indexData['order_address_data'] = $orderline->ordersNew->first()->address_data;
        $indexData['order_aggregate_data'] = $orderline->ordersNew->first()->aggregate_data;
        $indexData['order_status'] = $orderline->ordersNew->first()->status;
        $indexData['order_txnid'] = $orderline->ordersNew->first()->txnid;
        
        $indexData['suborder_is_shipped'] = $orderline->subOrdersNew->first()->is_shipped;
        $indexData['suborder_is_invoiced'] = $orderline->subOrdersNew->first()->is_invoiced;
        $indexData['location_id'] = $orderline->subOrdersNew->first()->location->warehouse_odoo_id;
        $indexData['location_name'] = $orderline->subOrdersNew->first()->location->warehouse_name;

        $q = new ElasticQuery;
        $q->setIndex('web_orders');
        $q->createIndexParams($orderline->id.'N', $indexData);
        $result = $q->index();

        if(!isset($result['result']) && !($result['result'] == 'created' || $result['result'] == 'updated')  ){
            throw new Exception(json_encode($result));
            
        }
    }
}
