<?php

namespace App\Jobs;

use App\Product;
use App\Variant;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateVariantInventory implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $variant_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($variant_id)
    {
        $this->variant_id = $variant_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $inventory          = Product::getVariantInventory([$this->variant_id]);
        $variant            = Variant::where(["odoo_id" => $this->variant_id])->first();
        $variant->inventory = $inventory[$this->variant_id]["inventory"];
        $variant->save();
    }
}
