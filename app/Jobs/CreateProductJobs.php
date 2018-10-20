<?php

namespace App\Jobs;

use App\Jobs\IndexProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateProductJobs implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $productIds;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($products)
    {
        $this->productIds = $products;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->productIds as $productID) {
            IndexProduct::dispatch($productID)->onQueue('process_product');
        }
    }
}
