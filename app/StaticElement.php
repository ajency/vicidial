<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaticElement extends Model
{
    public static function fetch(array $data = [], bool $draft = true)
    {
       if($draft==true)
        {
            $select = ['id','type','element_data','element_data_draft', 'sequence','sequence_data_draft','published'];
        }
        else
        {
            $select=['id','type','element_data','element_data_draft', 'sequence','sequence_data_draft','published'];
        }

        if(!empty($data))
        {
            $where=array();

            if(isset($data['id']))
            {
                $where[] = ['id', '=', $data['id']];
                
            }
            if(isset($data['type']))
            {
                $where[] = ['type', '=', $data['type']];
            }
          $staticElement=self::select($select)->where($where)->orderBy('sequence', 'ASC')->get();  
        }
        else
        {
            $staticElement=self::select($select)->orderBy('sequence', 'ASC')->get();
        }
       
       
        $response=array();
        //if id is set
        if(isset($data['id']))
        {
           $staticElementnew = $staticElement->first();
           if($staticElementnew==null)
           {
               abort(404);
           }
           $response=[
                "id"=>$staticElement[0]['id'],
                "sequence"=>$staticElement[0]['sequence'],
                "element_data"=>$staticElement[0]['element_data']
            ];
            
        }
       else
       {
           foreach($staticElement as $k=>$v)
            {
                $id=$v['id'];
                $type=$v['type'];
                $sequence=$v['sequence'];
                $element_data=$v['element_data'];

                if(!isset($response[$type])) 
                {
                    $response[$type] = array();
                }
                $staticElements=array("id"=>$id,
                "sequence"=>$sequence,
                "element_data"=>$element_data);
                array_push($response[$type],$staticElements);
                
            }//foreach
        }//else
        
        return(json_encode($response));
 }//fetch

}//model
