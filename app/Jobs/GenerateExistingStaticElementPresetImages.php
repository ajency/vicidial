<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\StaticElement;

class GenerateExistingStaticElementPresetImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $staticElement;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($staticElement)
    {
        $this->staticElement = $staticElement;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $staticElement = $this->staticElement;
        $config  = config('fileupload_static_element');
        $all_photos = $staticElement->photos()->get();
        foreach($all_photos as $single_photo){
            $map_image_size = json_decode($single_photo->file->image_size,true);
            $filedata = explode("/", $single_photo->file->url);
            $filename = $filedata[(count($filedata)-1)];
            if (substr($single_photo->file->url, -4) == '.gif') {
                $config[$staticElement->type.'_presets']['original'] = ["1x"=>""];
            }
            foreach($config[$staticElement->type."_presets"] as $preset => $deptharr){
                foreach($deptharr as $depth => $dim){
                    $image_size = ($preset == "original")?$preset:($preset."$$".$depth);
                    if(in_array($image_size,$map_image_size) == false){
                        $imageurl = $staticElement->resizeStaticImages($single_photo->file->id,$preset, $depth, $filename);
                    }
                }    
                
            }
        }
    }
}
