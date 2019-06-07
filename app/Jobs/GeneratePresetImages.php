<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\ProductColor;

class GeneratePresetImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 3;
    protected $productColorId;
    protected $product_color_details;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productColorId,$product_color_details)
    {
        $this->productColorId = $productColorId;
        $this->product_color_details = $product_color_details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $productColor = ProductColor::find($this->productColorId);
        $config        = config('ajfileupload');
        if(isset($this->product_color_details[$productColor->id])){
            foreach($config["presets"] as $preset => $deptharr){
                if($preset != "original"){
                    foreach($deptharr as $depth => $dim){
                        foreach($this->product_color_details[$productColor->id] as $product_color_detail){
                            $productColor->getImage($product_color_detail["photo_id"], $preset, $depth, $product_color_detail["filename"]);
                        }
                    }
                }    
            }
            
        }

    }
}
