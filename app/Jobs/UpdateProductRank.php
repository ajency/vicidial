<?php

namespace App\Jobs;

use App\ProductColor;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateProductRank implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $productId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->productId = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach (ProductColor::where('product_id', $this->productId) as $productColor) {
            ProductColor::updateElasticData([$productColor->elastic_id => [
                'elastic_data' => null,
                'change'       => function (&$product, &$variants) {},
            ]]);
        }
    }
}
