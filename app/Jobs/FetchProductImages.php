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
    public $tries = 3;
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
        $prod_images = Product::fetchProductImages($this->productId);
        \Log::debug("debugging for processing images from odoo");
        \Log::debug("count of images from odoo for product id");
        \Log::debug($this->productId);
        \Log::debug("=");
        \Log::debug(count($prod_images));

        if($prod_images->count() == 0) {
            ProductColor::where('product_id', $this->productId)->update(['no_image'=>true]);
            return;
        }else{
            ProductColor::where('product_id', $this->productId)->update(['no_image'=>false]);
        }

        $extension   = "jpg";

        $productColors = ProductColor::where('product_id', $this->productId)->get();
        foreach ($productColors as $pcs) {
            $pcs->unmapAllImages();
        }
        $prod_images_arr   = json_decode($prod_images, true);
        $colors            = array_column($prod_images_arr, "color_name");
        $default_color_ids = [];
        $db_image_ids=[];
        foreach ($prod_images as $pIndex => $prodImage) {
            $pc            = ProductColor::where([['product_id', $this->productId], ['color_id', $prodImage["color_id"]]])->first();
            $image         = $prodImage['image'];
            $product_name  = ($prodImage["magento_name"] == "") ? $prodImage["magento_name"] : $prodImage["name"];
            $color_name = isset($prodImage["color_name"])?$prodImage["color_name"]:"";
            $imageName     = generateVariantImageName($product_name, $color_name, $colors,$pIndex);
            $imageFullName = $imageName . "." . $extension;
            $subfilepath   = '/variants/' . $imageFullName;
            $subpath       = 'variants/' . $imageFullName;
            $actualImage   = base64_decode($image);
            \Storage::put($subfilepath, $actualImage);
            $disk       = \Storage::disk('local');
            $filepath   = ($disk->getDriver()->getAdapter()->getPathPrefix()) . $subpath;
            $attributes = $prodImage;
            unset($attributes['image']);
            \Log::debug("upload image");
            \Log::debug($prodImage);
            $image_id = $pc->uploadImage($filepath, false, true, true, '', '', "", $filepath, $extension, $imageName, $attributes);
            $type     = "";
            if (!in_array($prodImage["color_id"], $default_color_ids)) {
                $type = "default";
                array_push($default_color_ids, $prodImage["color_id"]);
            }
            array_push($db_image_ids, $image_id);
            $pc->mapImage($image_id, $type);
            // \Storage::disk('local')->delete($subfilepath);
        }
        Product::updateImageFacets($this->productId);
        \Log::debug("count of images after processing to DB for product id");
        \Log::debug($this->productId);
        \Log::debug("=");
        \Log::debug($db_image_ids);
        
    }
}
