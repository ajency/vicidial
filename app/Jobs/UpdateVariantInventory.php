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
    protected $variant_id;
    protected $product_move;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product_move)
    {
        $this->product_move = $product_move;
        $this->variant_id   = $product_move["variant_id"];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $inventory      = Product::getVariantInventory([$this->variant_id]);
        $var            = Variant::where(["odoo_id" => $this->variant_id])->first();
        $var->inventory = $inventory[$this->variant_id]["inventory"];
        $var->save();
        $result = ProductColor::updateElasticInventory($this->variant_id, $var->getVariantData(), $var->getAvailability());
        \Log::info($result);
    }
}
