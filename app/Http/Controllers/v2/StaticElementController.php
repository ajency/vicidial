<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\StaticElement;

class StaticElementController extends Controller
{
    //Request $request
    public function callFetchSeq($seq_no)
    {
        
        $fetchedData=StaticElement::fetchSeq($seq_no);
        return(json_encode($fetchedData));
    }

    public function callFetch(Request $request)
    {
        $request->validate(['type' => 'sometimes']);
        $params=$request->all();

        $data=array();
        if(isset($params['type']))
        {
            $data['type']=$params['type'];
        }

        $fetchedData=StaticElement::fetch($data);
        return(json_encode($fetchedData));
    }

    //save update 
    public function callSave($seq_no,Request $request) 
    {
        $request->validate(['element_data' => 'required']);
        
        $params=$request->all();
        $element_data=$params['element_data'];
         
        $dataSaved=StaticElement::saveData($seq_no,$element_data);
        return(json_encode($dataSaved));
      
    }//callSave

    //save new
    public function callSaveNew(Request $request)
    {
        $request->validate(['element_data' => 'required']);
        $params=$request->all();
        $element_data=$params['element_data'];

        

        $dataInserted=StaticElement::saveNewData($element_data);
        return(json_encode($dataInserted));
    }//callSaveNew
}
