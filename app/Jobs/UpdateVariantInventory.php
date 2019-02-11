<?php

namespace App\Jobs;

use App\Product;
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
    protected $variant_ids, $active;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($variant_ids, $active = true)
    {

        $this->variant_ids = $variant_ids;
        $this->active      = $active;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $inventory = Product::getVariantInventory($this->variant_ids);
        // $changes   = [];
        foreach ($this->variant_ids as $variant_id) {
            $var            = Variant::where(["odoo_id" => $variant_id])->firstOrFail();
            $var->inventory = $inventory[$variant_id]["inventory"];
            $var->save();
            if ($this->active) {
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
}
