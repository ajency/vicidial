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
                $record=StaticElement::select()->where('sequence',$seq_no)->where('published',true)->orderBy('sequence','desc')->get()->first();        
            }
        }
        
        else
        {
            $record=StaticElement::select()->where('published', true)->get()->first();
        }
        
        $images = $record->getImagesAll(array_keys(config('fileupload_static_element.banner_presets')),$record);
       
        //get the presets and pass in get all images 


        if(!is_null($record))
        {
            //$resu=$record->fetchImages("banner");
            //return($resu);
            $response=[
                "id"=>$record['id'],
                "sequence"=>$record['sequence'],
                "element_data"=>$record['element_data'],
                "images"=>$images,
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
            $records=StaticElement::select()->where('draft',true)->orderBy('sequence','desc')->get();
        }
        else
        {
            $records=StaticElement::select()->where('published',true)->orderBy('sequence','desc')->get();
        }
    }
    
    $response=array();
   
   foreach($records as $record)
    {
        
        $id=$record->id;
       
        $type=$record->type;
        $sequence=$record->sequence;
        $element_data=$record->element_data;
        $images = $record->getImagesAll(array_keys(config('fileupload_static_element.banner_presets')),$record);
        if(!isset($response[$type])) 
        {
            $response[$type] = array();
        }
        $staticElements=array("id"=>$id,
        "sequence"=>$sequence,
        "element_data"=>$element_data,
        "images"=>$images);

        array_push($response[$type],$staticElements);
        
   }//foreach
   
    return ($response);
 }//fetch
 
//update given seq number
 public static function saveData($seq_no,$element_data,$image_upload)
 {      
        //getting upload and images values;
        $image_upload=(json_decode($image_upload));
        
        $upload=$image_upload->upload;
        $image_values=$image_upload->images;
        //return(gettype($image_values));      
        
        //getting images values in a array
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
            $success=$se->save;
            
            if($upload) 
            {
               $imagesaved=$se->saveUpdateImage($images);
            }//upload
            
        
        }//published==1
        else //published!=1
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

            // update with validations

            if($upload) 
            {
                $imagesaved=$se->saveUpdateImage($images);
                return $imagesaved;
            }//upload
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

        $image_saved=$se->saveNewImage($images);
       
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

//function to call saveImage
public function saveNewImage($images)
{

    foreach($images as $k=>$v)
    {
       $get_type=$v['type'];
       //return $get_type;
       $get_base64=$v['base64'];
       $imageSaved=$this->saveImage($get_base64,$get_type);
    } 

    return $imageSaved;
}

//update existing function to call saveImage 

//pending
public function saveUpdateImage($images)
{
    $types=['portrait','landscape'];

    foreach($types as $type)
    {
        foreach($images as $image)
        {
            if($type==$image['type'])
            {
                $imagesaved=$this->saveImage($image['base64'],$type);
                break;
            }
            else
            {
                
                $id=$this->getImages("portrait");
                
                $imageremapped=$this->remapImages($id,$type);
                dd($imageremapped);
            }
        }//foreach
    }//foreach
    
    
    
}//saveUpdateImage

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

////////
public function getImagesAll($presets,$record) {
    
    $files = $record->photos; 
    $allImages=[];
    
    foreach($files as $file) {
        //$file->file
        
        $imagedata = $this->returnPresetUrlss($presets,get_class($this),$this,$file->file);
      
        array_push($allImages, $imagedata);
    }
    return $allImages;
}

public function returnPresetUrlss($presets,$obj_class,$obj_instance,$file){
    $resp = [];
    $config        = config('fileupload_static_element');
    foreach($presets as $preset){     
       //$presets=original,landcspae,portrait
       //$config[banner_prese]=banner_presets from config
        foreach($config['banner_presets'] as $cpreset => $cdepths){
            // echo "cpreset=".$cpreset."<br/>";
            if(in_array($cpreset, $presets)){
                $cdepth_data = [];
                
                $path = explode('amazonaws.com/',$file->url);
                
                $type=explode("-",$path[1]); //getting the type from url
                

                foreach($cdepths as $cdepth => $csizes){
                   
                 $newfilepath = str_replace($config['model'][$obj_class]['base_path'].'/'.$obj_instance[$config['model'][$obj_class]['slug_column']].'/',$config['model'][$obj_class]['base_path'].'/'.$file->id.'/'.$cpreset.'/'.$cdepth.'/', $path[1]);
                 $cdepth_data[$cdepth] = url($newfilepath);
                }//if
                if($cpreset == "original"){
                    $newfilepath = str_replace($config['model'][$obj_class]['base_path'].'/'.$obj_instance[$config['model'][$obj_class]['slug_column']].'/',$config['model'][$obj_class]['base_path'].'/'.$file->id.'/'.$cpreset.'/', $path[1]);
                    $resp[$cpreset] = url($newfilepath);
                }
                else
                {
                    foreach($type as $t)
                    {
                        if($cpreset==$t)
                        {
                            $resp[$cpreset] = $cdepth_data;
                        }
                    }
                }
            }
        }
    }
    return $resp;
}



//$file->filw=$file
}//model
