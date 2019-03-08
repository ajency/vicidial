<?php

namespace App;

use Ajency\FileUpload\FileUpload;
use Ajency\FileUpload\models\FileUpload_Mapping;
use Ajency\FileUpload\models\FileUpload_Photos;
use Ajency\FileUpload\models\FileUpload_Varients;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class StaticElement extends Model
{
    use FileUpload;

    protected $casts = [
        'element_data' => 'array',
        'published'    => 'boolean',
        'draft'        => 'boolean',
        'remove'       => 'boolean',
    ];

    //fetch with seq number
    public static function fetchSeq($seq_no, $page_slug, $type, $published = false)
    {
        if (!$published) {
            $record = StaticElement::where('sequence', $seq_no)->where('type', $type)->where('draft', true)->where('page_slug', $page_slug)->orderBy('sequence', 'desc')->get()->first();
        } else {
            $record = StaticElement::where('sequence', $seq_no)->where('type', $type)->where('published', true)->where('page_slug', $page_slug)->orderBy('sequence', 'desc')->get()->first();
        }

        if (is_null($record)) {
            return [];
        }

        $images = $record->getStaticImagesAll(array_keys(config('fileupload_static_element.' . $record->type . '_presets')), $record);

        //get the presets and pass in get all images

        $response = [
            "sequence"     => $record['sequence'],
            "element_data" => $record['element_data'],
            "type"         => $record['type'],
            "images"       => $images,
            "image_config" => config('fileupload_static_element.' . $record['type'] . '_upload'),
        ];

        return ($response);
    } //fetchSeq

    //fetch all
    public static function fetch($page_slug, $types = null, $published = false)
    {
        $records = [];
        $mode    = (!$published) ? 'draft' : 'published';

        if (!is_null($types) && gettype($types) != 'array') {
            $types = [$types];
        }
        if (is_null($types) || empty($types)) {
            $records = StaticElement::where($mode, true)->where('page_slug', $page_slug)->orderBy('sequence', 'asc')->get();
        } else {

            $records = StaticElement::where($mode, true)->where('page_slug', $page_slug)->where(function ($q) use ($types) {
                foreach ($types as $type) {
                    $q->where('type', 'like', $type . '%');
                }
            })->orderBy('sequence', 'asc')->get();

        }

        $allProducts  = ProductColor::select(['elastic_id'])->whereIn('elastic_id', $records->pluck('element_data')->pluck('products')->flatten()->unique()->values())->pluck('elastic_id');
        $productsData = [];
        if ($allProducts->count() > 0) {
            $productsData = Product::getProductDataFromIds($allProducts->toArray());
        }

        $response = array();

        foreach ($records as $record) {

            $type = explode('_', $record->type);

            $images = $record->getStaticImagesAll(array_keys(config('fileupload_static_element.' . $record->type . '_presets')), $record);

            if (!isset($response[$type[0]])) {
                $response[$type[0]] = array();
            }

            $productDetails = [];
            if (isset($record->element_data['products'])) {
                $products = $record->element_data['products'];

                foreach ($products as $product) {
                    if (isset($productsData[$product])) {
                        $productObj = $productsData[$product];
                        array_push($productDetails, array("product_found" => true, "product_id" => $product, "images" => $productObj['images'], "product-slug" => $productObj['url'], "title" => $productObj['title'], "list_price" => $productObj['list_price'], "sale_price" => $productObj['sale_price'], "discount_per" => $productObj['discount_per']));
                    } else {
                        array_push($productDetails, array("product_found" => false, "product_id" => $product));
                    }
                }
            } //if

            array_push($response[$type[0]], array(
                "sequence"     => $record->sequence,
                "element_data" => $record->element_data,
                "type"         => $record->type,
                "images"       => $images,
                "products"     => $productDetails,
            ));

        } //foreach

        return ($response);
    } //fetch

    //update given seq number
    public static function saveData($seq_no, $page_slug, $element_data, $type, $image_upload)
    {
        $record = StaticElement::where('sequence', '=', $seq_no)->where('type', $type)->where('page_slug', $page_slug)->orderBy('id', 'desc')->get()->first();

        if ($record == null) {
            abort(404);
        }

        StaticElement::where('sequence', $seq_no)->where('type', $type)->where('draft', true)->where('page_slug', $page_slug)->update(['draft' => null]);

        $se               = new StaticElement();
        $se->sequence     = $record['sequence'];
        $se->element_data = $element_data;
        $se->page_slug    = $page_slug;
        $se->type         = $record['type'];
        $se->save();

        if ($image_upload['upload']) {
            $se->saveUpdateImage($image_upload['images'], $record);
        } else {
            $se->saveUpdateImage([], $record);
        } //upload

        return (["message" => "Home page element saved successfully", "success" => true]);

    } //update given seq number

    //save new data
    public static function saveNewData($page_slug, $element_data, $type, $image_upload)
    {
        $select_type = explode('_', $type);
        $record      = StaticElement::select()->where('type', 'like', $select_type[0] . '%')->where('page_slug', $page_slug)->where(function ($q) {
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
        $se->page_slug    = $page_slug; //
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
            $upload->image_size = json_encode(["original"]);
            $image_size         = getimagesize($base64_file);
            $upload->dimensions = json_encode(["original_width" => $image_size[0], "original_height" => $image_size[1]]);
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
            $allImages = array_merge($allImages, $imagedata);
        }
        return $allImages;
    }

    public function returnStaticPresetUrl($presets, $obj_class, $obj_instance, $file, $im_type)
    {
        $resp   = [];
        $config = config('fileupload_static_element');

        if (substr($file->url, -4) == '.gif') {
            $config[$im_type . '_presets']['original'] = [];
        }

        foreach ($config[$im_type . '_presets'] as $cpreset => $cdepths) {
            if (in_array($cpreset, $presets) || $cpreset == "original") {
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
        return $resp;
    }

    public function getSingleStaticImage($file_id, $presets, $depth)
    {
        $file   = FileUpload_Photos::find($file_id);
        $config = config('fileupload_static_element');
        if ($file == null) {
            return false;
        }

        if (config('fileupload_static_element')['disk_name'] == "s3") {
            $map_image_size = json_decode($file->image_size, true);
            if ($map_image_size == null) {
                return false;
            }

            $image_size = $presets . "$$" . $depth;
            if (in_array($image_size, $map_image_size)) {
                $obj_instance = $this;
                $obj_class    = get_class($this);
                if ($presets == "original") {
                    $newfilepath = str_replace($config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/', $config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/' . $presets . '/', $file->url);
                } else {
                    $newfilepath = str_replace($config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/', $config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/' . $presets . '/' . $depth . '/', $file->url);
                }
                return $newfilepath;
            } else {
                return false;
            }

        }
    }

    public function resizeStaticImages($file_id, $presets, $depth, $filename)
    {
        $file = FileUpload_Photos::find($file_id);
        return $this->generateResizedStaticImages($this->id, $presets, $depth, get_class($this), $this, $filename, $file);
    }

    public function generateResizedStaticImages($object_id, $presets, $depth, $obj_class, $obj_instance, $filename, $file)
    {
        $config  = config('fileupload_static_element');
        $disk    = \Storage::disk($config['disk_name']);
        $path    = explode('amazonaws.com/', $file->url);
        $command = $disk->getDriver()->getAdapter()->getClient()->getCommand('GetObject', [
            'Bucket' => \Config::get('filesystems.disks.s3.bucket'),
            'Key'    => $path[1],
        ]);
        $filepath = $disk->getDriver()->getAdapter()->getClient()->createPresignedRequest($command, '+10 minutes')->getUri();

        $extarr = explode(".", $filepath);
        $ext    = (count($extarr) > 1) ? $extarr[1] : "jpg";

        $image_size = $presets . "$$" . $depth;
        if ($file->image_size != null) {
            $image_size_arr = json_decode($file->image_size, true);
            if (is_array($image_size_arr)) {
                array_push($image_size_arr, $image_size);
            }

        } else {
            $image_size_arr = [$image_size];
        }
        $file->image_size = json_encode($image_size_arr);
        if ($presets == "original") {
            $nfilepath          = explode("?", $filepath)[0];
            $newfilepath        = $config['base_root_path'] . $config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/' . $presets . '/' . $filename;
            $newfilepathfullurl = str_replace($config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/', $config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/' . $presets . '/', $file->url);
            if ($disk->put($newfilepath, file_get_contents($filepath), 'public')) {
                $file->save();
                return $newfilepathfullurl;
            } else {
                return false;
            }
        } else {
            $config_dimensions = $config[$obj_instance->type . '_presets'][$presets][$depth];
            $dimensions_arr    = explode("X", $config_dimensions);
            $width             = $dimensions_arr[0];
            $height            = $dimensions_arr[1];
            $new_img           = \Image::make(file_get_contents($filepath));
            $new_img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $new_img = $new_img->stream();

            $fp = $config['base_root_path'] . $config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/' . $presets . '/' . $depth . '/' . $filename;
            if ($disk->put($fp, $new_img->__toString(), 'public')) {
                $file->save();
                $newfilepathfullurl = str_replace($config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/', $config['model'][$obj_class]['base_path'] . '/' . $obj_instance[$config['model'][$obj_class]['slug_column']] . '/' . $presets . '/' . $depth . '/', $file->url);
                return $newfilepathfullurl;
            } else {
                return false;
            }

        }

    }

    public static function publish()
    {
        $getpublish = StaticElement::select()->where('draft', true)->get();

        $getpublish->pluck('page_slug')->unique()->each(function($slug){
            Cache::forget('static_element_'.$slug.'_published');
        });

        foreach ($getpublish as $pub) {
            if ($pub->published == null) {
                StaticElement::where('sequence', $pub->sequence)->where('type', $pub->type)->where('published', true)->where('page_slug', $pub->page_slug)->update(['published' => null]);

                $pub->published = true;
                $pub->save();
            }
        }

        return (["message" => "Elements published successfully", "success" => true]);
    }

}
