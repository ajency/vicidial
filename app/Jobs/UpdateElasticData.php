<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\ProductColor;

class UpdateElasticData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $changes;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($changes)
    {
        $this->changes = $changes;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $products = $this->changes->combine($this->changes->map(function()  {return ['elastic_data' => null, 'change' => function (&$product, &$variants) {
                        if (!isset($product['product_vendor_id']) || !$product['product_vendor_id']) {
                            $product['product_vendor_id'] = 0;
                        }
                        if (!isset($product['product_is_dropshipping']) || !$product['product_is_dropshipping']) {
                            $product['product_is_dropshipping'] = false;
                        }
                    }];}));
        ProductColor::updateElasticData($products);
    }
}
