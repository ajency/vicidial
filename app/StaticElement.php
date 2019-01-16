<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StaticElement extends Model
{
    public static function fetchSeq($seq_no, bool $draft = true)
    {
        if($draft==true)
        {
            $getRecord=StaticElement::select()->where('sequence',$seq_no)->where('draft',1)->orderBy('sequence','desc')->get()->first();

            if(!is_null($getRecord))
            {
                $record=$getRecord;
            }
            else
            {
                $record=StaticElement::select()->where('sequence',$seq_no)->where('published',1)->orderBy('sequence','desc')->first();        
            }
        }
        
        else
        {
            $record=StaticElement::select()->where('published', 1)->get()->first();
        }
        
        if(!is_null($record))
        {
            $response=[
                "id"=>$record['id'],
                "sequence"=>$record['sequence'],
                "element_data"=>json_decode($record['element_data']),
                ];
        }
        else
        {
            $response=[];
        }
       
        return($response);
 }//fetchSeq


 //fetch type
 public static function fetch($type, bool $draft = true)
 {
     if(isset($type))
     {
         $where=['type','=',$type];
          
         if($draft==true)
         {
             $records=StaticElement::select()->where($where)->where('draft',1)->orderBy('sequence','desc')->get();
         }
         else
         {
             $records=StaticElement::select()->where($where)->where('published',1)->orderBy('sequence','desc')->get();
         }
    }
    else
    {
        if($draft==true)
        {
            $records=StaticElement::select()->where('draft',1)->orderBy('sequence','desc')->get();
        }
        else
        {
            $records=StaticElement::select()->where('published',1)->orderBy('sequence','desc')->get();
        }
    }

    
    
    foreach($records as $k=>$v)
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
        "element_data"=>json_decode($element_data));
        array_push($response[$type],$staticElements);
        
    }//foreach


    return($response);
 }//fetch
 
//update
 public static function saveData($seq_no,$element_data)
 {
        $record=StaticElement::select()->where('sequence', '=', $seq_no)->orderBy('created_at', 'desc')->get()->first();
        
        if($record==null)
        {
            abort(404);
        }
        if($record['published']==1)
        {
            $se=new StaticElement();
            $se->sequence=$seq_no;
            $se->element_data=json_encode($element_data);
            $se->type=$record['type'];
            $se->published=null;
            $success=$se->save();
                    
        }
        else
        {
            //get latest seq
            $get_seq=Staticelement::select()->where('sequence',$seq_no)->orderBy('created_at', 'desc')->get()->first();
            $id=$get_seq['id'];
           
            $result=Staticelement::where('id', $id)->update(['published' => null,'draft'=>null]);
            
            $se=new StaticElement();
            $se->sequence=$seq_no;
            $se->element_data=json_encode($element_data);
            $se->published=null;
            $se->type=$record['type'];

            $success=$se->save();
        } 
        if($success)
        {
           $response=[
                "message"=>"Home page element saved successfully",
                "success"=>true
                ];
        }
        else
        {
            $response=[
                "message"=>"Home page element not saved successfully",
            ];
        }
        
        return ($response);
        
  }//save

  //new data
  public static function saveNewData($element_data,$type)
  {
        $record=StaticElement::select()->where('type','=',$type)->where(function($q) 
                                            {
                                                $q->where('published', 1)
                                                ->orWhere('draft', 1);
                                            })->orderBy('sequence', 'desc')->get()->first();

        if($record==null)
        {
            $sequence=1;
        }
        else
        {
            $sequence=$record['sequence']+1;
        }
        
        $se=new StaticElement();
        $se->sequence=$sequence;
        $se->element_data=json_encode($element_data);
        $se->published=null;
        $se->type=$record['type'];
        $success=$se->save();

        if($success)
        {
            $response=[
              "message"=>"Home page element saved successfully",
              "success"=>true
          ];
        }
        else
        {
            $response=[
                "message"=>"Home page element not saved successfully",
            ];
        }

      return ($response);
  }//saveNewData


}//model
