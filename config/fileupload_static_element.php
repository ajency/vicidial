<?php

return [
    'disk_name'           => 's3',
    'base_root_path'      => env('STATICELEMENTS_PRESET').'',
    'default_base_path'   => 'static_elements',
    'valid_image_formats' => ['jpg', 'png'],
    'valid_file_formats'  => ['doc', 'docx', 'pdf'],
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

    
    
    
];
