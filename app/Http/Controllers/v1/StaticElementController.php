<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\StaticElement;
use Illuminate\Http\Request;

class StaticElementController extends Controller
{
    public function callFetchSeq($seq_no)
    {

        $fetchedData = StaticElement::fetchSeq($seq_no);
        return (json_encode($fetchedData));
    }

    public function callFetch(Request $request)
    {
        $request->validate(['type' => 'sometimes', 'published' => 'sometimes']);
        $params = $request->all();
        global $fetchedData;

        $data = array();
        if (isset($params['type'])) {
            $data['type'] = $params['type'];
        }

        if (isset($params['published'])) {
            $published    = $params['published'];
            $boole        = (trim($published) == 'true') ? true : false;
            $fectchedData = StaticElement::fetch($data, $boole);
        } else {
            $fetchedData = StaticElement::fetch($data);
        }
        return (json_encode($fetchedData));
    }

    //save update
    public function callSave($seq_no, Request $request)
    {
        $request->validate(['element_data' => 'required', 'image_upload' => 'required']);
        $params = $request->all();

        $dataSaved = StaticElement::saveData($seq_no, $params['element_data'], $params['image_upload']);
        return (json_encode($dataSaved));
    } //callSave

    //save new
    public function callSaveNew(Request $request)
    {
        $request->validate(['element_data' => 'required', 'type' => 'required', 'images' => 'required']);
        $images = $request->images;

        $params = $request->all();

        $dataInserted = StaticElement::saveNewData($params['element_data'], $params['type'], $params['images']);
        return (json_encode($dataInserted));
    } //callSaveNew

    public function getImage($photo_id, $preset, $depth, $filename)
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
        return \Redirect::to(url($imageurl), 301);

    }
}
