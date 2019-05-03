<?php

namespace App\Jobs;

use App\SubOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SubOrderStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $subOrderId, $state, $is_shipped, $is_invoiced, $external_id, $lines_status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subOrderId, $state, $is_shipped, $is_invoiced, $external_id, $lines_status)
    {
        $this->subOrderId = $subOrderId;
        $this->state = $state;
        $this->is_shipped = $is_shipped;
        $this->is_invoiced = $is_invoiced;
        $this->external_id = $external_id;
        $this->lines_status = $lines_status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SubOrder::updateSubOrderStatus($this->subOrderId, $this->state, $this->is_shipped, $this->is_invoiced, $this->external_id, $this->lines_status);
    }
}
