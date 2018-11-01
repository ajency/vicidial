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
        $inventory      = Product::getVariantInventory([$this->variant_id]);
        $var            = Variant::where(["odoo_id" => $this->variant_id])->first();
        $var->inventory = $inventory[$this->variant_id]["inventory"];
        $availability   = $var->getAvailability();
        $var->save();
        $elastic_id   = $var->productColor->elastic_id;
        $productColor = $var->getVariantData();
        foreach ($productColor["variants"] as &$variant) {
            if ($variant["variant_id"] == $this->variant_id) {
                $variant["variant_availability"] = $availability;
                break;
            }
        }

        foreach ($productColor["search_data"] as &$variant) {
            $flag = false;
            foreach ($variant["number_facet"] as $facet) {
                if ($facet["facet_name"] == "variant_id" and $facet["facet_value"] == $this->variant_id) {
                    $flag = true;
                    break;
                }
            }
            if ($flag) {

                foreach ($variant["boolean_facet"] as &$facet) {
                    if ($facet["facet_name"] == "variant_availability") {
                        $facet["facet_value"] = $availability;
                        break;
                    }
                }
                break;
            }
        }
        $result = ProductColor::saveToElastic($elastic_id, $productColor);
        \Log::info($result);
    }
}
