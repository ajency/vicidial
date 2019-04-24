<?php

namespace App\Jobs;

use App\Order;
use App\ReturnPolicy;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveReturnPolicies implements ShouldQueue
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
        foreach ($order->orderLines as $orderLine) {
            $orderLine->return_policy_id = ReturnPolicy::getReturnPolicyForFacet($orderLine->product_type, $orderLine->product_subtype);
            $orderLine->save();
        }
    }
}
