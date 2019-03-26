<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\StaticElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Facet;
use App\SizechartImage;

class StaticElementController extends Controller
{
    public function callFetchSeq($seq_no, Request $request)
    {
        $request->validate(['type' => 'required', 'page_slug' => 'required']);
        $params = $request->all();

        $fetchedData = StaticElement::fetchSeq($seq_no, $params['page_slug'], $params['type']);
        return (json_encode($fetchedData));
    }

    public function callFetch(Request $request)
    {
        $request->validate(['type' => 'sometimes', 'page_slug' => 'required', 'published' => 'sometimes']);
        $params = $request->all();

        $data = array();
        if (isset($params['type'])) {
            $data['type'] = $params['type'];
        }

        if (isset($params['published'])) {
            if ($params['published'] && !isset($params['type'])) {
                $key = 'static_element_'.$params['page_slug'].'_published';
                $fetchedData = Cache::rememberForever($key, function () use ($params,$data) {
                    return StaticElement::fetch($params['page_slug'], $data, $params['published']);
                });
            } else {
                $fetchedData = StaticElement::fetch($params['page_slug'], $data, $params['published']);
            }

        } else {
            $fetchedData = StaticElement::fetch($params['page_slug'], $data);
        }
        return (json_encode($fetchedData));
    }

    //save update
    public function callSave($seq_no, Request $request)
    {
        $request->validate(['element_data' => 'required', 'page_slug' => 'required', 'type' => 'required', 'image_upload' => 'required']);
        $params = $request->all();

        $dataSaved = StaticElement::saveData($seq_no, $params['page_slug'], $params['element_data'], $params['type'], $params['image_upload']);
        return (json_encode($dataSaved));
    } //callSave

    //save new
    public function callSaveNew(Request $request)
    {
        $request->validate(['element_data' => 'required', 'page_slug' => 'required', 'type' => 'required', 'images' => 'present']);
        $images = $request->images;

        $params = $request->all();

        $dataInserted = StaticElement::saveNewData($params['page_slug'], $params['element_data'], $params['type'], $params['images']);
        return (json_encode($dataInserted));
    } //callSaveNew

    public function getImage($photo_id, $preset, $depth, $filename)
    {
        $imageurl = $this->fetchImage($photo_id, $preset, $depth, $filename);
        return \Redirect::to(url($imageurl), 301);
    }

    public function getOriginalImage($photo_id, $preset, $filename)
    {
        $imageurl = $this->fetchImage($photo_id, $preset, '1x', $filename);
        return \Redirect::to(url($imageurl), 301);
    }

    public function fetchImage($photo_id, $preset, $depth, $filename)
    {
        $path          = public_path() . 'img/' . $filename;
        $staticElement = StaticElement::join('fileupload_mapping', function ($join) {
            $join->on('static_elements.id', '=', 'fileupload_mapping.object_id');
            $join->where('fileupload_mapping.object_type', '=', "App\StaticElement");
        })->where('fileupload_mapping.file_id', $photo_id)->select('static_elements.*')->first();
        if ($staticElement == null) {
            abort(404);
        }

        $imageurl = "";
        $file     = $staticElement->getSingleStaticImage($photo_id, $preset, $depth);
        if ($file) {
            $imageurl = $file;
        } else {
            $imageurl = $staticElement->resizeStaticImages($photo_id, $preset, $depth, $filename);
        }
        if (config('ajfileupload.use_cdn') && config('ajfileupload.cdn_url')) {
            $tempUrl  = parse_url($imageurl);
            $imageurl = config('ajfileupload.cdn_url') . $tempUrl['path'];
        }
        return $imageurl;
    }

    public function callPublish(Request $request)
    {
        $publish = StaticElement::publish();
        return (json_encode($publish));
    }

    public function getMenu(Request $request)
    {
        return response()->json(json_decode(file_get_contents(config_path() . "/static_responses/menu.json"), true));

    }

    public function getFacets($type,Request $request){
        $data = [];
        $facets = Facet::where([["facet_name",$type]])->select('slug','display_name','facet_value')->get()->toArray();
        return response()->json(["success"=>true,"data"=>["facet_name"=>$type,"facet_values"=>$facets]],200);
    }

    public function saveSizeChartImages(Request $request)
    {
        $request->validate(['product_gender' => 'required', 'product_subtype' => 'required', 'product_brand' => 'required', 'images' => 'present']);
        $images = $request->images;

        $params = $request->all();
        $data = []; 
        $config        = config('ajfileupload');
        $sizechartImage = SizechartImage::where([["product_gender",$params["product_gender"]["facet_value"]],["product_subtype",$params["product_subtype"]["facet_value"]],["product_brand",$params["product_brand"]["facet_value"]]])->first();
        // dd($sizechartImage);
        $sizechartImageExist = false;
        if(is_null($sizechartImage)){
            $sizechartImage = new SizechartImage;
            $sizechartImage->product_gender = $params["product_gender"]["facet_value"];
            $sizechartImage->product_subtype = $params["product_subtype"]["facet_value"];
            $sizechartImage->product_brand = $params["product_brand"]["facet_value"];
            $sizechartImage->save();
        }
        else
            $sizechartImageExist = true;
        
        $imagesArr = [];

        foreach($images as $image_type =>$image){
            if($sizechartImageExist){
                $sizechartImageObj = SizechartImage::join('fileupload_mapping', function ($join) {
                    $join->on('sizechart_images.id', '=', 'fileupload_mapping.object_id');
                    $join->where('fileupload_mapping.object_type', '=', "App\SizechartImage");
                })->where([['fileupload_mapping.type',$image_type],["sizechart_images.id",$sizechartImage->id]])->whereNull('fileupload_mapping.deleted_at')->select('sizechart_images.id','fileupload_mapping.file_id')->first();
                    
                if($sizechartImageObj){
                    $sizechartImageObj->unmapImage($sizechartImageObj->file_id);
                }
            }
            
            // dd($sizechartImageObj);
            $f            = finfo_open();
            $actualImage   = base64_decode($image);
            $mime_type    = finfo_buffer($f, $actualImage, FILEINFO_MIME_TYPE);
            $extension    = str_replace("image/", "", $mime_type);
            $imageName = $image_type . "-" . $sizechartImage->id;
            $imageFullName = $imageName . "." . $extension;
            $subfilepath   = '/sizechartImages/' . $imageFullName;
            // dd($subfilepath);
            $subpath       = 'sizechartImages/' . $imageFullName;
            
            \Storage::put($subfilepath, $actualImage);
            $disk       = \Storage::disk('local');
            $filepath   = ($disk->getDriver()->getAdapter()->getPathPrefix()) . $subpath;
            $attributes = ["product_gender"=>$params["product_gender"],"product_subtype"=>$params["product_subtype"],"product_brand"=>$params["product_brand"]];
            $image_id = $sizechartImage->uploadImage($filepath, false, true, true, '', '', "", $filepath, $extension, $imageName, $attributes);
            $sizechartImage->mapImage($image_id, $image_type);
            $photo = $sizechartImage->photos()->where('type',$image_type)->first();
            $path = explode('amazonaws.com/',$photo->file->url);
            $newFilePath = $path[1];
            if($config['use_cdn'] && $config['cdn_url'] ){
                $tempUrl = parse_url($newFilePath);
                $newFilePath =  $config['cdn_url'] . $tempUrl['path'];
            }
            $imagesArr[$image_type] = $newFilePath;
            \Storage::disk('local')->delete($subfilepath);
        }

        $data["success"] = true;
        $data["message"] = "Images saved successfully!!";
        $data["data"] = [];
        $data["data"]["product_gender"] = $params["product_gender"];
        $data["data"]["product_subtype"] = $params["product_subtype"];
        $data["data"]["product_brand"] = $params["product_brand"];
        $data["data"]["images"] = $imagesArr;

        // $dataInserted = StaticElement::saveNewData($params['page_slug'], $params['element_data'], $params['type'], $params['images']);
        return response()->json($data,200);
    } 

    public function getSizeCharts(Request $request){
        $types = ["desktop","mobile"];
        $request->validate(['product_gender' => 'required', 'product_subtype' => 'required', 'product_brand' => 'required']);
        $params = $request->all();
        $config        = config('ajfileupload');
        $sizechartImages = SizechartImage::join('fileupload_mapping', function ($join) {
                    $join->on('sizechart_images.id', '=', 'fileupload_mapping.object_id');
                    $join->where('fileupload_mapping.object_type', '=', "App\SizechartImage");
                })->where([["sizechart_images.product_gender",$params["product_gender"]],["sizechart_images.product_subtype",$params["product_subtype"]],["sizechart_images.product_brand",$params["product_brand"]]])->whereNull('fileupload_mapping.deleted_at')->select('sizechart_images.id','fileupload_mapping.file_id','fileupload_mapping.id as mapping_id','fileupload_mapping.type')->get();
        // dd($sizechartImages);
        foreach($sizechartImages as $sizechartImage){
            // dd($sizechartImage->photos()->find($sizechartImage->mapping_id)->file);
            $photo = $sizechartImage->photos()->find($sizechartImage->mapping_id)->file;
            $path = explode('amazonaws.com/',$photo->url);
            $newFilePath = $path[1];
            if($config['use_cdn'] && $config['cdn_url'] ){
                $tempUrl = parse_url($newFilePath);
                $newFilePath =  $config['cdn_url'] . $tempUrl['path'];
            }
            $imagesArr[$sizechartImage->type] = $newFilePath;
        }

        if(count($imagesArr) != count($types)){
            foreach($types as $type){
                $imagesArr[$type]=(isset($imagesArr[$type]))?$imagesArr[$type]:"";
            }
        }
        

        $data["success"] = true;
        $data["data"] = [];
        $data["data"]["product_gender"] = ["facet_value" => $params["product_gender"]];
        $data["data"]["product_subtype"] = ["facet_value" => $params["product_subtype"]];
        $data["data"]["product_brand"] = ["facet_value" => $params["product_brand"]];
        $data["data"]["images"] = $imagesArr;
        return response()->json($data,200);
        // dd($params);
    }

}
