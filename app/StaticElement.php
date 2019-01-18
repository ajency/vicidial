<?php
//banner config for landscape and portrait 
/*
Landscape
2000 * 700 - large
1200 * 420 - medium
700 * 245 - small
20px - load image

Portrait
1200 * 933 - large
700 * 544 - medium
400 * 311 - small 
*/

namespace App;

use Illuminate\Database\Eloquent\Model;
use Ajency\FileUpload\FileUpload;
use Ajency\FileUpload\models\FileUpload_Photos;
use Ajency\FileUpload\models\FileUpload_Files;
use Ajency\FileUpload\models\FileUpload_Mapping;
use Ajency\FileUpload\models\FileUpload_Varients;



class StaticElement extends Model
{
    use FileUpload;

    protected $casts = [
        'element_data' => 'array',
        'published' => 'boolean',
        'draft'  => 'boolean',
    ];

    //fetch with seq number
    public static function fetchSeq($seq_no, bool $published = false)
    {
        if(!$published)
        {
            $getRecord=StaticElement::select()->where('sequence',$seq_no)->where('draft',true)->orderBy('sequence','desc')->get()->first();

            if(!is_null($getRecord))
            {
                $record=$getRecord;
            }
            else
            {
                $record=StaticElement::select()->where('sequence',$seq_no)->where('published',true)->orderBy('sequence','desc')->first();        
            }
        }
        
        else
        {
            $record=StaticElement::select()->where('published', true)->get()->first();
        }
        
        $se=new StaticElement();
        

        if(!is_null($record))
        {
            $resu=$record->fetchImages("banner");
            return($resu);
            $response=[
                "id"=>$record['id'],
                "sequence"=>$record['sequence'],
                "element_data"=>$record['element_data'],
                ];
        }
        else
        {
            $response=[];
        }
       
        return($response);
 }//fetchSeq


 //fetch all
 public static function fetch($data=[], $published = false)
 {
     //return [$published];
     
     if($data)
     {
         if(!$published)
         {
             $records=StaticElement::select()->where('type',$data['type'])->where('draft',true)->orderBy('sequence','desc')->get();
         }
         else
         {
             $records=StaticElement::select()->where('type',$data['type'])->where('published',true)->orderBy('sequence','desc')->get();
         }
    }

    else
    {
        if(!$published)
        {
            $records=StaticElement::select()->where('draft',true)->orderBy('sequence','desc')->get()->first();
        }
        else
        {
            $records=StaticElement::select()->where('published',true)->orderBy('sequence','desc')->get()->first();
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
        "element_data"=>$element_data);
        array_push($response[$type],$staticElements);
        
   }//foreach
   
    return ($response);
 }//fetch
 
//update given seq number
 public static function saveData($seq_no,$element_data,$image_upload)
 {
        $image_upload=(json_decode($image_upload));
        
        $upload=$image_upload->upload;
        $image_values=$image_upload->images;
        //return(gettype($image_values));      
        
       $images=array();
        foreach($image_values as $v)
        {
           $staticElements=["type"=>$v->type, "base64"=>$v->base64];
           array_push($images,$staticElements);
        }
        
        $record=StaticElement::select()->where('sequence', '=', $seq_no)->orderBy('created_at', 'desc')->get()->first();
        
        if($record==null)
        {
            abort(404);
        }
        if($record['published']==1)
        {
            $se=new StaticElement();
            $se->sequence=$seq_no;
            $se->element_data=$element_data;
            $se->type=$record['type'];
            $se->published=null;
            $success=$se->save();
///////////////////////////////////////////////////////////////
            if($upload)
            {
                foreach($images as $k=>$v)
                {
                    $get_type=$v['type'];
                    $get_base64=$v['base64'];

                    
                    $image_up=$se->saveImage($get_base64,$get_type);
                }
              //  return($image_up);
            }
            
///////////////////////////////////////////////////////////////           
        }
        else
        {
            //get latest seq
            $get_seq=Staticelement::select()->where('sequence',$seq_no)->orderBy('created_at', 'desc')->get()->first();
            $id=$get_seq['id'];
           
            $result=Staticelement::where('id', $id)->update(['published' => null,'draft'=>null]);
            
            $se=new StaticElement();
            $se->sequence=$seq_no;
            $se->element_data=$element_data;
            $se->published=null;
            $se->type=$record['type'];

            $success=$se->save();



///////////////////////////////////////////////////////////


            $data=array();
            $data['landscape']=false;
            $data['portrait']=false;
            $types=array();

            foreach($images as $k=>$v)
            {
                array_push($types,$v['type']);
            }

            $val=array();
            if($upload)
            {
                foreach($images as $k=>$v)
                {       
                        $val[$v['type']]=$v['base64'];
                       

                }

                foreach($val as $k=>$v)
                {
                    if($k=="portrait")
                    {
                        $data['portrait']=true;
                        $data['base64P']=$v;
                    }
                    if($k=="landscape")
                    {
                       $data['landscape']=true;
                       $data['base64L']=$v;
                    }
                }

                $data['base64P']="
                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";
                foreach($data as $k=>$v)
                {
                    if($data['portrait'] && $data['landscape'] )
                    {
                        $image_up=$se->saveImage($data['base64P'],'portrait');
                        $image_up=$se->saveImage($data['base64L'],'landscape');
                        
                    }
                    else if($data['portrait'])
                    {

                        $image_up=$se->saveImage($data['base64P'],'portrait');
                        $id=$se->id;

                        

                        $portrait=FileUpload_Mapping::select()->where('object_id',$id)->where()->get();
                        return($portrait);
                    }
                    else 
                    {
                        $image_up=$se->saveImage($data['base64L'],'landscape');
                        return($image_up);
                    }
                }//foreach
            
        }//upload    
///////////////////////////////////////////////////////////////
        } //else
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
        
  }//update given seq number 

  //save new data
  public static function saveNewData($element_data,$type,$image_upload)
  { 
    $image_upload=(json_decode($image_upload,true));
    
    $images=array();
    foreach($image_upload as $k=>$v)
    {
       $staticElements=["type"=>$k, "base64"=>$v];
       array_push($images,$staticElements);
    } 

    $record=StaticElement::select()->where('type','=',$type)->where(function($q) 
                                            {
                                                $q->where('published', true)
                                                ->orWhere('draft', true);
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
        $se->element_data=$element_data;
        $se->published=null;
        $se->type=$type;
        $success=$se->save();


        foreach($images as $k=>$v)
        {
           $get_type=$v['type'];
           $get_base64=$v['base64'];
           $imageSaaved=$se->saveImage($get_base64,$get_type);
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
  }//saveNewData

  //uploadImage
  public function saveImage($image,$im_type)
  {
      $id=$this->id;
      $type=$this->type;
      $extension   = "jpg";
     

      $image_name=$type."-".$im_type."-".$id;  
      
      $decodedImage= base64_decode($image);
      $subfilepath   = '/variants/' . "" . $image_name ."." . $extension;
      $subpath       = '/variants/' . "" . $image_name . "." . $extension;


      \Storage::put($subfilepath, $decodedImage);
      $disk       = \Storage::disk('local');
      
      $filepath   = ($disk->getDriver()->getAdapter()->getPathPrefix()) . $subpath;
   
      unset($image); 


     
     
      
  
//$image,$type,$is_watermarked=true,$is_public=true,$alt='',$caption='',$name="",$base64_file="",$base64_file_ext="",$imageName="",$attributes=[]
      $imageId = $this->uploadImage($filepath,$type, false, true, '', '', $image_name, $filepath, $extension, $image_name, );

      //mapping images to model
      $this->mapImage($imageId, $im_type);
     return $image_name;
  }//saveImage 

  public function fetchImages($type)
  {
        $result=$this->getImages($type);
        return $result;
  }


}//model
