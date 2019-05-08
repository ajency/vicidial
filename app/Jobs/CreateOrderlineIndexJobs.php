<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateOrderlineIndexJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $ids; 
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($orderlines)
    {
        $this->ids = $orderlines;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->ids->each(function ($id) {
            OrderlineIndex::dispatch($id)->onQueue('order_index');
        });
    }
}
