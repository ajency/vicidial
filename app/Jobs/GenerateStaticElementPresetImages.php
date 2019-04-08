<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\StaticElement;
use Ajency\FileUpload\models\FileUpload_Photos;

class GenerateStaticElementPresetImages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $static_element_id,$file_id,$filename;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($static_element_id,$file_id,$filename)
    {
        $this->static_element_id = $static_element_id;
        $this->file_id = $file_id;
        $this->filename = $filename;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $config  = config('fileupload_static_element');
        $static_element = StaticElement::find($this->static_element_id);
        $file_obj = FileUpload_Photos::find($this->file_id);
        if($file_obj!=null && $static_element!=null){
            if (substr($file_obj->url, -4) == '.gif') {
                $config[$staticElement->type.'_presets']['original'] = ["1x"=>""];
            }
            foreach($config[$static_element->type."_presets"] as $preset => $deptharr){
                foreach($deptharr as $depth => $dim){
                    $static_element->getStaticImage($this->file_id, $preset, $depth, $this->filename);
                }    
                
            }
        } 

    }
}
