<?php

namespace App\Jobs;

use Ajency\ServiceComm\Comm\Sync;
use App\Order;
use App\ReturnPolicy;
use App\Variant;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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
        $order       = Order::find($this->order_id);
        $variant_ids = $order->orderLines->pluck('variant_id')->unique()->all();
        $variants    = Variant::whereIn('odoo_id', $variant_ids)->get();
        foreach ($variants as $variant) {
            $variants_data[$variant->odoo_id] = ['category_type' => $variant->getCategoryType(), 'sub_type' => $variant->getSubType()];
        }

        foreach ($order->subOrders as $subOrder) {
            $shipped_date = null;
            if ($subOrder->orderLines->first()->shipment_status == 'delivered') {
                $shipped_date = Sync::call('backoffice', 'fetchOrderDeliveryDate', ['sub_order_id' => $subOrder->id]);
            }

            foreach ($subOrder->orderLines as $orderLine) {
                $category_type      = $variants_data[$orderLine->variant_id]['category_type'];
                $sub_type           = $variants_data[$orderLine->variant_id]['sub_type'];
                $return_policy_data = ReturnPolicy::getReturnPolicyForFacet($category_type, $sub_type);

                $return_policy      = ReturnPolicy::find($return_policy_data['id']);
                $return_expiry_date = null;
                if($shipped_date && $return_policy){
                    $d         = explode("-", explode(" ", $shipped_date)[0]);
                    $orderDate = Carbon::createFromDate($d[0], $d[1], $d[2], "Asia/Kolkata");
                    $orderDate->startOfDay();
                    $return_expiry_date = ($return_policy->expressions->first()->value[0] == 0) ? null : $orderDate->endOfDay()->addDays($return_policy->expressions->first()->value[0] - 1)->toDateTimeString();
                }

                $orderLine->shipment_delivery_date = $shipped_date;
                $orderLine->return_expiry_date     = $return_expiry_date;
                $orderLine->return_policy          = $return_policy_data;
                $orderLine->save();
            }
        }
    }
}
