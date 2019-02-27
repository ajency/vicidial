<?php

namespace App\Jobs;

use App\ProductColor;
use App\Variant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateVariantInventory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    protected $variant_ids;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($variant_ids, $active = true)
    {

        $this->variant_ids = $variant_ids;

    }

    /**
     * Execute the job.
     *
     * @return void
     */
    function handle()
    {
        foreach ($this->variant_ids as $variant_id) {
            $var = Variant::find($variant_id);
            ProductColor::updateElasticData([$var->getParentElasticData()['id'] => [
                'elastic_data' => $var->getParentElasticData(),
                'change'       => function (&$product, &$variants) use ($var) {
                    $variant                         = $variants[$var->odoo_id];
                    $variant['variant_availability'] = $var->getAvailability();
                    $variants[$var->odoo_id]         = $variant;
                },
            ]]);

        }
    }
}
