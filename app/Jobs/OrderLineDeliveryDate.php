<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Order;
use App\ReturnPolicy;
use App\Variant;
use Ajency\ServiceComm\Comm\Sync;

class OrderLineDeliveryDate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $order_id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($order_id)
    {
        $this->order_id = $order_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = Order::find($this->order_id);
        foreach ($order->subOrders as $subOrder) {
            if($subOrder->orderLines->first()->shipment_status == 'delivered'){
                $shipped_date = Sync::call('backoffice', 'fetchOrderDeliveryDate', ['sub_order_id' => $subOrder->id]);
            }
            foreach ($subOrder->orderLines as $orderLine) {
                $variant = Variant::where('odoo_id', $orderLine->variant_id)->first();
                $category_type = $variant->getCategoryType();
                $sub_type = $variant->getSubType();
                $return_policy = ReturnPolicy::getReturnPolicyForFacet($category_type, $sub_type);
                $orderLine->shipment_delivery_date = $shipped_date;
                $orderLine->return_policy = $return_policy;
                $orderLine->save();
            }
        }
    }
}
