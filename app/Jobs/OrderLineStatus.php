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
    protected $subOrderId, $status;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subOrderId, $status)
    {
        $this->subOrderId = $subOrderId;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        SubOrder::updateOrderLineStatus($this->subOrderId, $this->status);
    }
}
