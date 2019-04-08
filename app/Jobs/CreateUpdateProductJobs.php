<?php

namespace App\Jobs;

use App\Jobs\UpdateProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CreateUpdateProductJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $productIds;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productIds)
    {
        $this->productIds = $productIds;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->productIds as $productId) {
            UpdateProduct::dispatch($productId->id)->onQueue('process_product');
        }
    }
}
