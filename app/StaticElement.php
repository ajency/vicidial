<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaticElement extends Model
{
    public static function fetch(array $data = [], boolean $draft=true)
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
            $select = ['element_data_draft', 'sequence_data_draft'];
        }
        else
        {
            $select=['element_data','sequence_data'];
        }

        if(!empty($data))
        {
            $where=array();

            if(isset($data['id']))
            {
                //$where['id']=$id;
                $where[] = ['id', '=', $id];
            }
            if(isset($data['type']))
            {
                $where[] = ['type', '=', $type];
            }

            $result=self::select($select)->where($where)->orderBy('sequence', 'ASC')->get();  
        }
        else
        {
            $result=self::select($select)->orderBy('sequence', 'ASC')->get();
        }
        
        dd($result);


        if(isset($data['id']))
        {
           $staticElementnew = $staticElement->first();
           $response=[
                "id"=>$staticElementnew['id'],
                "sequence"=>$staticElementnew['sequence'],
                "element_data"=>$staticElementnew['element_data']
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
            
    

            
       return(json_encode($response));
        
       
        


        
    }//fetch

}//model
