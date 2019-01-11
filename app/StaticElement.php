<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaticElement extends Model
{
    public static function fetch(array $data = [], bool $draft = true)
    {
       /*ifdata!empty
        $where = array();
        if isset $id
        $where['id'] = $id 
        
        

Facet::select('facet_value',DB::raw('count(id) as "count",facet_name'))->whereIn('slug', $all_facets)->groupBy('facet_value','facet_name')->get();
        
        
        */

        if($draft==true)
        {
            //select element_data_draft as elememt data and secquence_data_draft as sequence
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
                //$where['id']=$id;
                $where[] = ['id', '=', $data['id']];
            }
            if(isset($data['type']))
            {
                $where[] = ['type', '=', $data['type']];
            }
           //select(DB::raw('count(*) as user_count, status'))
            $staticElement=self::select($select)->where($where)->orderBy('sequence', 'ASC')->get();  
        }
        else
        {
            $staticElement=self::select($select)->orderBy('sequence', 'ASC')->get();
        }
       
       
        dd($staticElement);


        if(isset($data['id']))
        {
           $staticElementnew = $staticElement->first();
           $response=[
                "id"=>$staticElement[0]['id'],
                "sequence"=>$staticElement[0]['sequence'],
                "element_data"=>$staticElement[0]['element_data']
            ];
 

        return(json_encode($response));
        }
       
        

        foreach($staticElement as $k=>$v)
        {
               //dd($v['id']);
        
                $id=$v['id'];
                $type=$v['type'];
                $sequence=$v['sequence'];
                $element_data=$v['element_data'];

                $response=array(
                    "type"=>$type,
                   
                    array("id"=>$id,
                    "sequence"=>$sequence,
                    "element_data"=>$element_data),
                );
         }//foreach
            
        // dd($response);

            
       return(json_encode($response));
        
       
        


        
    }//fetch

}//model
