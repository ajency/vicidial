<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CancelOdooOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 5;
    protected $subOrder, $cancelSubOrderId;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subOrder, $cancelSubOrderId)
    {
        $this->subOrder = $subOrder;
        $this->cancelSubOrderId = $cancelSubOrderId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->subOrder->cancelOrder($this->cancelSubOrderId);
    }
}
