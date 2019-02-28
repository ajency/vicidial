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
    protected $subOrderId, $state, $is_invoiced, $external_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subOrderId, $state, $is_invoiced, $external_id)
    {
        $this->subOrderId = $subOrderId;
        $this->state = $state;
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
        SubOrder::updateSubOrderStatus($this->subOrderId, $this->state, $this->is_invoiced, $this->external_id);
    }
}