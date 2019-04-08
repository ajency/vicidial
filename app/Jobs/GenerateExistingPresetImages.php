<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\ProductColor;

class GenerateExistingPresetImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $productColor;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($productColor)
    {
        $this->productColor = $productColor;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $config        = config('ajfileupload');
        $productColor = $this->productColor;
        $all_photos = $productColor->photos()->get();
        foreach($all_photos as $single_photo){
            $map_image_size = json_decode($single_photo->file->image_size,true);
            $filedata = explode("/", $single_photo->file->url);
            $filename = $filedata[(count($filedata)-1)];
            foreach($config["presets"] as $preset => $deptharr){
                if($preset != "original"){
                    foreach($deptharr as $depth => $dim){
                        $image_size = ($preset == "original")?$preset:($preset."$$".$depth);
                        if(in_array($image_size,$map_image_size) == false){
                            $imageurl = $productColor->resizeImages($single_photo->file->id,$preset, $depth, $filename);
                        }
                    }    
                } 
            }
        }
    }
}
