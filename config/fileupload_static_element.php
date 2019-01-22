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
        "original"   => [],
        "landscape" => [
            "1x"=>"700*245",
            "2x"=>"1200*420",
            "3x"=>"2000*700",
            "load"=>"20px"
        ],
        "portrait" => [
            "1x"=>"1200*933",
            "2x"=>"700*544" ,
            "3x"=>"1200*933" 
        ],
    ],
    'banner_upload'=> [
        "landscape" => [
            "size" => 250,
            "height" => 933,
            "width" => 1200
        ],
        "portrait" => [
            "size" => 250,
            "height" => 700,
            "width" => 2000
        ],
    ],
];
