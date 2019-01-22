<?php

namespace App;

use Ajency\FileUpload\FileUpload;
use Ajency\FileUpload\models\FileUpload_Mapping;
use Ajency\FileUpload\models\FileUpload_Photos;
use Ajency\FileUpload\models\FileUpload_Varients;
use Illuminate\Database\Eloquent\Model;

class StaticElement extends Model
{
    use FileUpload;

    protected $casts = [
        'element_data' => 'array',
        'published'    => 'boolean',
        'draft'        => 'boolean',
    ];

    //fetch with seq number
    public static function fetchSeq($seq_no, $published = false)
    {
        $getRecord = null;

        if (!$published) {

            $getRecord = StaticElement::where('sequence', $seq_no)->where('draft', true)->orderBy('sequence', 'desc')->get()->first();
        }

        if (!is_null($getRecord)) {
            $record = $getRecord;
        } else {
            $record = StaticElement::where('sequence', $seq_no)->where('published', true)->orderBy('sequence', 'desc')->get()->first();
        }

        if (is_null($record)) {
            return [];
        }

        $images = $record->getStaticImagesAll(array_keys(config('fileupload_static_element.' . $record->type . '_presets')), $record);

        //get the presets and pass in get all images

        $response = [
            "sequence"     => $record['sequence'],
            "element_data" => $record['element_data'],
            "images"       => $images,
            "image_config" => config('fileupload_static_element.' . $record['type'] . '_upload'),
        ];

        return ($response);
    } //fetchSeq

    //fetch all
    public static function fetch($data = [], $published = false)
    {
        if (!$published) {
            $mode = 'draft';
        } else {
            $mode = 'published';
        }

        if (isset($data['type'])) {
            $records = StaticElement::where('type', $data['type'])->where($mode, true)->orderBy('sequence', 'asc')->get();
        } else {
            $records = StaticElement::where($mode, true)->orderBy('sequence', 'asc')->get();
        }

        $response = array();

        foreach ($records as $record) {

            $type   = $record->type;
            $images = $record->getStaticImagesAll(array_keys(config('fileupload_static_element.' . $record->type . '_presets')), $record);

            if (!isset($response[$type])) {
                $response[$type] = array();
            }

            array_push($response[$type], array(
                "sequence"     => $record->sequence,
                "element_data" => $record->element_data,
                "images"       => $images,
            ));

        } //foreach

        return ($response);
    } //fetch

    //update given seq number
    public static function saveData($seq_no, $element_data, $image_upload)
    {
        $record = StaticElement::where('sequence', '=', $seq_no)->orderBy('id', 'desc')->get()->first();

        if ($record == null) {
            abort(404);
        }

        StaticElement::where('sequence', $seq_no)->where('draft', true)->update(['published' => null, 'draft' => null]);

        $se               = new StaticElement();
        $se->sequence     = $record['sequence'];
        $se->element_data = $element_data;
        $se->type         = $record['type'];
        $se->save();

        if ($image_upload['upload']) {
            $se->saveUpdateImage($image_upload['images'], $record);
        } //upload

        return (["message" => "Home page element saved successfully", "success" => true]);

    } //update given seq number

    //save new data
    public static function saveNewData($element_data, $type, $image_upload)
    {
        $record = StaticElement::select()->where('type', '=', $type)->where(function ($q) {
            $q->where('published', true)
                ->orWhere('draft', true);
        })->orderBy('sequence', 'desc')->get()->first();

        if ($record == null) {
            $sequence = 1;
        } else {
            $sequence = $record['sequence'] + 1;
        }

        $se               = new StaticElement();
        $se->sequence     = $sequence;
        $se->element_data = $element_data;
        $se->type         = $type;
        $se->save();

        $se->saveNewImage($image_upload);

        return (["message" => "Home page element saved successfully", "success" => true]);
    } //saveNewData

    //function to call saveImage
    public function saveNewImage($images)
    {
        $types = array_keys(config('fileupload_static_element.' . $this->type . '_upload'));

        foreach ($types as $type) {
            $this->saveImage($images[$type], $type);
        }
    }

    //update existing function to call saveImage
    public function saveUpdateImage($images, $record)
    {
        $types = array_keys(config('fileupload_static_element.' . $this->type . '_upload'));

        foreach ($types as $type) {
            if (isset($images[$type])) {
                $this->saveImage($images[$type], $type);
            } else {

                $id = $record->getStaticImages($type);
                $this->remapStaticImages(array_keys($id)[0], $type);
            }
        } //foreach

    } //saveUpdateImage

    //uploadImage
    public function saveImage($image, $im_type)
    {
        $id   = $this->id;
        $type = $this->type;

        $decodedImage = base64_decode($image);
        $f            = finfo_open();
        $mime_type    = finfo_buffer($f, $decodedImage, FILEINFO_MIME_TYPE);
        $extension    = str_replace("image/", "", $mime_type);

        $image_name = $type . "-" . $im_type . "-" . $id;

        $subfilepath = '/static_element/' . $image_name . "." . $extension;
        $subpath     = 'static_element/' . $image_name . "." . $extension;

        \Storage::put($subfilepath, $decodedImage);
        $disk = \Storage::disk('local');

        $filepath = ($disk->getDriver()->getAdapter()->getPathPrefix()) . $subpath;

        unset($image);

        $imageId = $this->uploadImageStatic($filepath, $type, false, true, '', '', $image_name, $filepath, $extension, $image_name);

        //mapping images to model
        $this->mapImage($imageId, $im_type);
        return $image_name;
    } //saveImage

    public function uploadImageStatic($image, $type, $is_watermarked = true, $is_public = true, $alt = '', $caption = '', $name = "", $base64_file = "", $base64_file_ext = "", $imageName = "", $attributes = [])
    {
        $upload            = new FileUpload_Photos;
        $upload->name      = $name;
        $upload->slug      = str_slug($name);
        $upload->is_public = $is_public;
        $upload->alt_text  = $alt;
        $upload->caption   = $caption;
        if ($base64_file != "") {
            $upload->image_size       = json_encode(["original"]);
            $image_size               = getimagesize($base64_file);
            $upload->dimensions       = json_encode(["original_width" => $image_size[0], "original_height" => $image_size[1]]);
            $upload->photo_attributes = json_encode($attributes);
        }
        $upload->save();
        if ($this->uploadPhoto($upload, $image, $type, $this, get_class($this), $is_watermarked, $is_public, $base64_file, $base64_file_ext, $imageName)) {
            return $upload->id;
        } else {
            return false;
        }
    }

    public function remapStaticImages($image_id, $type)
    {
        $photo = FileUpload_Photos::find($image_id);

        $upload                   = new FileUpload_Photos;
        $upload->name             = $photo->name;
        $upload->slug             = $photo->slug;
        $upload->is_public        = $photo->is_public;
        $upload->alt_text         = $photo->alt_text;
        $upload->caption          = $photo->caption;
        $upload->image_size       = $photo->image_size;
        $upload->dimensions       = $photo->dimensions;
        $upload->photo_attributes = $photo->photo_attributes;
        $upload->url              = $photo->url;
        $upload->save();

        $this->mapImage($upload->id, $type);
    }

    public function uploadPhoto($upload, $image, $type, $obj_instance, $obj_class, $watermark, $public, $base64_file, $base64_file_ext, $imageName)
    {
        $config        = config('fileupload_static_element');
        $imageFileName = time();

        $disk = \Storage::disk($config['disk_name']);
        $ext  = ($base64_file_ext == "") ? $image->getClientOriginalExtension() : $base64_file_ext;
        if ($base64_file != "") {
            $image = $base64_file;
        }

        if (isset($config['model'][$obj_class])) {
            if ($imageName == "") {
                $filepath = $config['base_root_path'] . $config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/images/' . $imageFileName . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '-';
            } else {
                $filepath = $config['base_root_path'] . $config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/';
            }

        } else {
            if ($imageName == "") {
                $filepath = $config['default_base_path'] . 'images/' . $imageFileName . '/image-';
            } else {
                $filepath = $config['default_base_path'];
            }

        }
        if ($imageName == "") {
            $fp = $filepath . 'original.' . $ext;
        } else {
            $fp = $filepath . $imageName . "." . $ext;
        }

        if ($disk->put($fp, file_get_contents($image), 'private')) {
            $upload->url = $disk->url($fp);
            $upload->save();
        } else {
            return false;
        }

        if (isset($config['model'][$obj_class]) && $base64_file == "") {
            $img = Image::make($image->getRealPath());
            foreach ($config['model'][$obj_class]['sizes'][$type] as $size_name) {
                if (isset($config['sizes'][$size_name])) {
                    $new_img = Image::make($image->getRealPath());
                    $new_img->resize($config['sizes'][$size_name]['width'], $config['sizes'][$size_name]['height'], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    if ($watermark and isset($config['sizes'][$size_name]['watermark'])) {
                        $path = $config['sizes'][$size_name]['watermark']['image_path'];
                        $pos  = $config['sizes'][$size_name]['watermark']['position'];
                        $new_img->insert($config['sizes'][$size_name]['watermark']['image_path'],
                            $config['sizes'][$size_name]['watermark']['position'],
                            $config['sizes'][$size_name]['watermark']['x'],
                            $config['sizes'][$size_name]['watermark']['y']
                        );
                    }
                    $new_img = $new_img->stream();
                    $fp      = $filepath . $size_name . '.' . $ext;
                    if ($public) {
                        if ($disk->put($fp, $new_img->__toString(), 'public')) {
                            $this->save();
                        } else {
                            return false;
                        }
                    } else {
                        if ($disk->put($fp, $new_img->__toString(), 'private')) {
                            $this->save();
                        } else {
                            return false;
                        }
                    }
                    $entry           = new FileUpload_Varients;
                    $entry->photo_id = $this->id;
                    $entry->size     = $size_name;
                    $entry->url      = $disk->url($fp);
                    $entry->save();
                }
            }
        }
        return true;
    }

    public function fetchImages($type)
    {
        $result = $this->getStaticImages($type);
        return $result;
    }

    public function getStaticImages($type)
    {
        $uploads = array();
        $images  = $this->media()->where('file_type', FileUpload_Photos::class)->where('type', $type)->pluck('id')->toArray();
        $images  = FileUpload_Mapping::whereIn('id', $images)->get();
        foreach ($images as $image) {
            $uploads[$image->file_id] = array('id' => $image->file_id);
            $details                  = FileUpload_photos::where('id', $image->file_id)->first();
            if (!empty($details)) {
                $uploads[$image->file_id]['name']    = $details->name;
                $uploads[$image->file_id]['caption'] = $details->caption;
                $uploads[$image->file_id]['alt']     = $details->alt_text;
                $varients                            = FileUpload_Varients::where('photo_id', $image->file_id)->get();
                foreach ($varients as $varient) {
                    $uploads[$image->file_id][$varient->size] = $varient->url;
                }
            }
        }
        return $uploads;
    }

    public function getStaticImagesAll($presets, $record)
    {

        $files     = $record->photos;
        $allImages = [];

        foreach ($files as $file) {
            $imagedata = $this->returnStaticPresetUrl($presets, get_class($this), $this, $file->file, $record->type);
            array_push($allImages, $imagedata);
        }
        return $allImages;
    }

    public function returnStaticPresetUrl($presets, $obj_class, $obj_instance, $file, $im_type)
    {
        $resp   = [];
        $config = config('fileupload_static_element');
        foreach ($presets as $preset) {
            foreach ($config[$im_type . '_presets'] as $cpreset => $cdepths) {
                if (in_array($cpreset, $presets)) {
                    $cdepth_data = [];

                    $path = explode('amazonaws.com/', $file->url);

                    $type = explode("-", $path[1]); //getting the type from url

                    foreach ($cdepths as $cdepth => $csizes) {

                        $newfilepath          = str_replace($config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/', $config['model'][$obj_class]['base_path'] . '/' . $file->id . '/' . $cpreset . '/' . $cdepth . '/', $path[1]);
                        $cdepth_data[$cdepth] = url($newfilepath);
                    }

                    if ($cpreset == "original") {
                        $newfilepath    = str_replace($config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/', $config['model'][$obj_class]['base_path'] . '/' . $file->id . '/' . $cpreset . '/', $path[1]);
                        $resp[$cpreset] = url($newfilepath);
                    } else {
                        foreach ($type as $t) {
                            if ($cpreset == $t) {
                                $resp[$cpreset] = $cdepth_data;
                            }
                        }
                    }
                }
            }
        }
        return $resp;
    }
}
