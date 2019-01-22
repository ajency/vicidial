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
}
