<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ajency\FileUpload\FileUpload;

class SizechartImage extends Model
{
    use FileUpload;

    protected $fillable = ['product_gender','product_subtype','product_brand'];
    protected $casts = ['aws_links'=>'array'];

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

    public function getAwsLinks(){
        $links = [];
        
        if(isset($this->aws_links['desktop'])){
            if(config('ajfileupload.use_cdn') && config('ajfileupload.cdn_url')){
                $links['desktop'] = config('ajfileupload.cdn_url') .'/'. $this->aws_links['desktop'];
            }else{
                $links['desktop'] = \Storage::disk(config('ajfileupload.disk_name'))->url($this->aws_links['desktop']);
            }
        }else{
            $links['desktop'] = null;
        }
        if(isset($this->aws_links['mobile'])){
            if(config('ajfileupload.use_cdn') && config('ajfileupload.cdn_url')){
                $links['mobile'] = config('ajfileupload.cdn_url') .'/'. $this->aws_links['mobile'];
            }else{
                $links['mobile'] = \Storage::disk(config('ajfileupload.disk_name'))->url($this->aws_links['mobile']);
            }
        }else{
            $links['mobile'] = null;
        }
        return $links;
        
    }
}
