<?php

namespace App\Http\Controllers\v2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\StaticElement;

class StaticElementController extends Controller
{
    //Request $request
    public function callFetch(Request $request)
    {
        $request->validate(['id' => 'sometimes', 'type' => 'sometimes']);
        $params  = $request->all();  //type,id

        $data=array();
        if(isset($params['id']))
        {
            $data['id'] = $params['id'];
        }
        if(isset($params['type']))
        {
            $data['type'] = $params['type'];
        }
       
        $fetchedData = StaticElement::fetch($data);
        return($fetchedData);
    }
}
