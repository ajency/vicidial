<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\StaticElement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Facet;
use App\SizechartImage;
use DB;
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

    public function getFacets(Request $request){
        $params = $request->all();
        // dd($params["type"]);
        $types = explode(",", $params["type"]);
        $data = [];
        $facets = Facet::whereIn("facet_name",$types)->select('facet_name',DB::raw('group_concat(facet_value) as "values",group_concat(display_name) as "display_names", group_concat(slug) as "slugs"'))->groupBy('facet_name')->get();
        // dd($facets->toArray());
        $facets_data=[];
        foreach ($facets as $facet) {
            
            $facet_values = explode(",",$facet->values);
            $display_names = explode(",",$facet->display_names);
            $slugs = explode(",",$facet->slugs);
            $facet_values_data = [];
            foreach($facet_values as $facet_key => $facet_value){
                array_push($facet_values_data,["facet_value"=>$facet_value,"slug"=>$slugs[$facet_key],"display_name"=>$display_names[$facet_key]]);
            }
            array_push($facets_data, ["facet_name"=>$facet->facet_name,"facet_values"=>$facet_values_data]);
        }
        return response()->json(["success"=>true,"data"=>$facets_data,"message"=>"facets fetched successfully!!"],200);
    }

    public function saveSizeChartImages(Request $request){
        $request->validate(['product_gender' => 'required', 'product_subtype' => 'required', 'product_brand' => 'required', 'images' => 'present']);
        $params = $request->all();
        $sizechartImage = SizechartImage::firstOrNew([
            "product_gender"=>$params["product_gender"]["facet_value"],
            "product_subtype"=>$params["product_subtype"]["facet_value"],
            "product_brand"=>$params["product_brand"]["facet_value"],
        ]);
        if(is_null($sizechartImage->id)) {
            $sizechartImage->save();
            $sizechartImage->aws_links = [];
            $sizechartImage->clearCache();
            $request->validate(['images.desktop' => 'required', 'images.mobile' => 'required']);
        }
        $sizechartImage->unmapAllImages();
        $imagetypes = $sizechartImage->aws_links;
        foreach ($request->images as $imageType => $image) {
            $image = base64_decode($image);
            $mime_type    = finfo_buffer(finfo_open(), $image, FILEINFO_MIME_TYPE);
            $imageName = $imageType.'.'.str_replace("image/", "", $mime_type);
            $imagePath = config('ajfileupload.base_root_path').'size-charts/'.$sizechartImage->id.'/'.$imageName;
            \Storage::disk(config('ajfileupload.disk_name'))->put($imagePath,$image,'public');
            $imagetypes[$imageType] = $imagePath;
        }
        $sizechartImage->aws_links = $imagetypes;
        $sizechartImage->save();
        $data = [];
        $data["success"] = true;
        $data["data"] = [];
        $data["data"]["product_gender"] = ["facet_value" => $params["product_gender"]];
        $data["data"]["product_subtype"] = ["facet_value" => $params["product_subtype"]];
        $data["data"]["product_brand"] = ["facet_value" => $params["product_brand"]];
        $data["data"]["images"] = $sizechartImage->aws_links;
        return response()->json($data,200);

    }

    public function getSizeCharts(Request $request){
        $request->validate(['product_gender' => 'required', 'product_subtype' => 'required', 'product_brand' => 'required']);
        $params=$request->all();
        $sizechartImage = SizechartImage::where("product_gender",$request->product_gender)->where("product_subtype",$request->product_subtype)->where("product_brand",$request->product_brand)->first();
        $data = [];
        $data["success"] = true;
        $data["data"] = [];
        $data["data"]["product_gender"] = ["facet_value" => $params["product_gender"]];
        $data["data"]["product_subtype"] = ["facet_value" => $params["product_subtype"]];
        $data["data"]["product_brand"] = ["facet_value" => $params["product_brand"]];
        $data["data"]["images"] = [
            'desktop' => null,
            'mobile' => null
        ];
        if(!is_null($sizechartImage)){
            $data["data"]["images"] = $sizechartImage->getAwsLinks();
        }
        return response()->json($data,200);
    }

}
