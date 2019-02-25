<?php

namespace App\Jobs;

use App\SubOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OrderLineStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $subOrderId, $state, $shipment_status, $is_invoiced, $external_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subOrderId, $state, $shipment_status, $is_invoiced, $external_id)
    {
        $this->subOrderId = $subOrderId;
        $this->state = $state;
        $this->shipment_status = $shipment_status;
        $this->is_invoiced = $is_invoiced;
        $this->external_id = $external_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SubOrder::updateOrderLineStatus($this->subOrderId, $this->state, $this->shipment_status, $this->is_invoiced, $this->external_id);
    }
}
