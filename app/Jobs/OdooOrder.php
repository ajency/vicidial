<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OdooOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 5;
    protected $subOrder, $placeorder;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subOrder, $placeorder)
    {
        $this->subOrder = $subOrder;
        $this->placeorder = $placeorder;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->subOrder->placeOrder($this->placeorder);
    }
}
