<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\ProductColor;

class CorrectProductInventory implements ShouldQueue
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
        $productColor = ProductColor::find($this->productId);
        $var = $productColor->variants;

        $changes = [
            $productColor->elastic_id => [
                'elastic_data' => $var->first()->getParentElasticData(),
                'change' => function (&$product, &$variants) use ($var) {
                    foreach ($variants as $variant_id => $variant) {
                        $variant['variant_availability'] = $var->where('odoo_id',$variant['variant_id'])->first()->getAvailability();
                        $variants[$variant_id] = $variant;
                    }
                },
            ]
        ];
        ProductColor::updateElasticData($changes);

    }
}
