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
    protected $variant_ids;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($variant_ids)
    {
        $this->variant_ids   = $variant_ids;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $inventory      = Product::getVariantInventory($this->variant_ids);
        foreach ($this->variant_ids as $variant_id) {
            $var            = Variant::where(["odoo_id" => $variant_id])->firstOrFail();
            $var->inventory = $inventory[$variant_id]["inventory"];
            $var->save();
            $result = ProductColor::updateElasticInventory($variant_id, $var->getParentElasticData(), $var->getAvailability());
            \Log::info($result);
        }
    }
}
