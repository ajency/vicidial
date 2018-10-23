<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;
use App\Product;
use App\Variant;

class FetchProductImages implements ShouldQueue
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
        $prod_images=Product::fetchProductImages($this->productId);
        foreach($prod_images as $prodImage){
            $image = $prodImage['image'];
            $imageName = str_random(10).'.'.'png';
            $filepath = storage_path(). '/variants/' . $imageName;
            $actualImage = base64_decode($image);
            // \File::put($filepath, $actualImage);
            (new Variant)->uploadImage($actualImage,false);
        }
        

        // Log::debug($prod_images);
        // print_r($prod_images);
    }
}
