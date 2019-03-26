<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ajency\FileUpload\FileUpload;

class SizechartImage extends Model
{
    use FileUpload;

    public function getSizechartImageUrlByType($image_type){
    	$config        = config('ajfileupload');
    	$newFilePath = "";
    	$photo = $this->photos()->where('type',$image_type)->first();
    	// dd($this->photos);
    	// print_r($photo);
    	if($photo){
    		$path = explode('amazonaws.com/',$photo->file->url);
	        $newFilePath = $path[1];
	        if($config['use_cdn'] && $config['cdn_url'] ){
	            $tempUrl = parse_url($newFilePath);
	            $newFilePath =  $config['cdn_url'] . $tempUrl['path'];
	        }
    	}
        return $newFilePath;
    }
}
