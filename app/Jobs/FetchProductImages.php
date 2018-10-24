<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Log;
use App\Product;
use App\ProductColor;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\File;

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
        // if($this->productId == 979){
        if($this->productId == 982)
        {
            
            $prod_images=Product::fetchProductImages($this->productId);
            $extension = "jpg";
            
            // $productColors = ProductColor::where('product_id',$this->productId)->get();
            // foreach($productColors as $pcs){
            //     $pcs->unmapAllImages();
            // }            
            $colors = array_column($prod_images, "color_name");
            $colors_count = array_count_values($colors);
            $default_color_ids = [];
            foreach($prod_images as $prodImage){
                $pc = ProductColor::where([['product_id',$this->productId],['color_id',$prodImage["color_id"]]])->first();
                $image = $prodImage['image'];
                \Log::debug("product reached===");
                \Log::debug($image);

                // $image = substr($image, strpos($image, ",")+1);

                $imageName = str_random(10).'.'.$extension;
                $filepath = storage_path(). '/variants/' . $imageName;
                $actualImage = base64_decode($image);
                \File::put($filepath, $actualImage);
                $image_id = $pc->uploadImage($filepath,false,true,true,'','',"",$filepath,$extension);
                $type = "";
                if(!in_array($prodImage["color_id"], $default_color_ids)){
                    $type = "default";
                    array_push($default_color_ids, $prodImage["color_id"]);
                }

                $pc->mapImage($image_id,$type); // map images
            }
        }
        
        // }
        
        

        // Log::debug($prod_images);
        // print_r($prod_images);
    }
}
