<?php

namespace App\Jobs;

use App\Product;
use App\ProductColor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

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

        if( $this->productId == 982){
        $prod_images = Product::fetchProductImages($this->productId);
        $extension   = "jpg";

        $productColors = ProductColor::where('product_id', $this->productId)->get();
        foreach ($productColors as $pcs) {
            $pcs->unmapAllImages();
        }
        $prod_images_arr   = json_decode($prod_images, true);
        $colors            = array_column($prod_images_arr, "color_name");
        $default_color_ids = [];
        foreach ($prod_images as $prodImage) {
            $pc            = ProductColor::where([['product_id', $this->productId], ['color_id', $prodImage["color_id"]]])->first();
            $image         = $prodImage['image'];
            $product_name  = ($prodImage["magento_name"] == "") ? $prodImage["magento_name"] : $prodImage["name"];
            $imageName     = generateVariantImageName($product_name, $prodImage["color_name"], $colors);
            $imageFullName = $imageName . "." . $extension;
            $subfilepath      = '/variants/' . $imageFullName;
            $subpath      = 'variants/' . $imageFullName; 
            $actualImage   = base64_decode($image);
            \Storage::put($subfilepath, $actualImage);
            $disk = \Storage::disk('local');  
            $filepath      = ($disk->getDriver()->getAdapter()->getPathPrefix()).$subpath;        
            $attributes = $prodImage;
            unset($attributes['image']);
            $image_id = $pc->uploadImage($filepath, false, true, true, '', '', "", $filepath, $extension, $imageName, $attributes);
            $type     = "";
            if (!in_array($prodImage["color_id"], $default_color_ids)) {
                $type = "default";
                array_push($default_color_ids, $prodImage["color_id"]);
            }

            $pc->mapImage($image_id, $type);
            \Storage::disk('local')->delete($subfilepath);
        }
    }

    }
}
