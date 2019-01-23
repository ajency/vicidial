<?php

return [
    'disk_name'           => 's3',
    'base_root_path'      => env('STATICELEMENTS_PRESET').'',
    'default_base_path'   => 'static_elements',
    'valid_image_formats' => ['jpg', 'jpeg', 'gif'],
    'model'               => [
      
        'App\StaticElement' => [
            'base_path'   => 'static_elements',
            'slug_column' => 'type',
        ],
    ],
    'banner_presets'=> [
        "landscape" => [
            "1x"=>"700X245",
            "2x"=>"1200X420",
            "3x"=>"2000X700",
            "load"=>"20X10"
        ],
        "portrait" => [
            "1x"=>"1200X933",
            "2x"=>"700X544" ,
            "3x"=>"1200X933" 
        ],
    ],
    'banner_upload'=> [
        "landscape" => [
            "size" => 250000,
            "height" => 700,
            "width" => 2000
        ],
        "portrait" => [
            "size" => 250000,
            "height" => 933,
            "width" => 1200
        ],
    ],
];
