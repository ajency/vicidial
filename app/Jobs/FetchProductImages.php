<?php

namespace App\Jobs;

use App\Product;
use App\ProductColor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\GeneratePresetImages;

class FetchProductImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    protected $subject, $payload;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($subject, $payload)
    {
        $this->subject = $subject;
        $this->payload = $payload;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $productColorId = $this->payload['product_color_id'];
        $prod_images = $this->payload['prod_images'];
        \Log::debug("debugging for processing images from google drive");
        \Log::debug("count of images from google driv for product color id");
        \Log::debug($productColorId);
        \Log::debug("=");
        \Log::debug(count($prod_images));

        $productColor = ProductColor::find($productColorId);
        $productColor->unmapAllImages();

        if($prod_images->count() == 0) {
            ProductColor::where('id', $productColorId)->update(['no_image'=>true]);
            return;
        }else{
            ProductColor::where('id', $productColorId)->update(['no_image'=>false]);
        }

        $extension   = "jpg";

        $prod_images_arr   = json_decode($prod_images, true);
        $colors            = array_column($prod_images_arr, "color_name");
        $default_color_ids = [];
        $db_image_ids=[];
        $product_color_details = [];
        foreach ($prod_images as $pIndex => $prodImage) {
            $pc            = ProductColor::find($productColorId);
            $image         = $prodImage['image'];
            $product_name  = ($prodImage["magento_name"] == "") ? $prodImage["magento_name"] : $prodImage["name"];
            $color_name = isset($prodImage["color_name"])?$prodImage["color_name"]:"";
            $imageName     = generateVariantImageName($product_name, $color_name, $colors,$pIndex);
            $imageFullName = $imageName . "." . $extension;
            $subfilepath   = '/variants/' . $imageFullName;
            $subpath       = 'variants/' . $imageFullName;
            $actualImage   = file_get_contents($image);
            \Storage::put($subfilepath, $actualImage);
            $disk       = \Storage::disk('local');
            $filepath   = ($disk->getDriver()->getAdapter()->getPathPrefix()) . $subpath;
            $attributes = $prodImage;
            unset($attributes['image']);
            \Log::debug("upload image");
            \Log::debug($prodImage);
            $image_id = $pc->uploadImage($filepath, false, true, true, '', '', "", $filepath, $extension, $imageName, $attributes);
            $type     = "";
            if (!in_array($pc->color_id, $default_color_ids)) {
                $type = "default";
                array_push($default_color_ids, $pc->color_id);
            }
            array_push($db_image_ids, $image_id);
            $pc->mapImage($image_id, $type);
            // \Storage::disk('local')->delete($subfilepath);
            if(!isset($product_color_details[$pc->id]))
                $product_color_details[$pc->id] = [];
            array_push($product_color_details[$pc->id] , ["photo_id"=>$image_id,"filename"=>$imageFullName]);

        }
        Product::updateImageFacets($productColorId);
        GeneratePresetImages::dispatch($productColorId,$product_color_details)->onQueue('process_product_image_presets');
        \Log::debug("count of images after processing to DB for product id");
        \Log::debug($productColorId);
        \Log::debug("=");
        \Log::debug($db_image_ids);
        
    }
}
