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
            "2x"=>"700X544",
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
    'category_box_large_presets'=> [
        "default" => [
            "1x"=>"248X233",
            "2x"=>"370X349",
            "3x"=>"740X698",
            "load"=>"10X9" 
        ],
    ],
    'category_box_large_upload'=> [
        "default" => [
            "size" => 160000,
            "size_gif" => 500000,
            "height" => 698,
            "width" => 740
        ],
    ],
    'category_box_medium_presets'=> [
        "default" => [
            "1x"=>"246X232",
            "2x"=>"370X349",
            "3x"=>"740X698",
            "load"=>"10X9" 
        ],
    ],
    'category_box_medium_upload'=> [
        "default" => [
            "size" => 120000,
            "size_gif" => 500000,
            "height" => 698,
            "width" => 740
        ],
    ],
    'category_box_small_presets'=> [
        "default" => [
            "1x"=>"245X181",
            "2x"=>"370X273",
            "3x"=>"740X546",
            "load"=>"10X7" 
        ],
    ],
    'category_box_small_upload'=> [
        "default" => [
            "size" => 100000,
            "size_gif" => 500000,
            "height" => 546,
            "width" => 740
        ],
    ],
    'category_landscape_presets'=> [
        "default" => [
            "1x"=>"512X233",
            "2x"=>"768X349",
            "3x"=>"1535X698",
            "load"=>"10X5" 
        ],
    ],
    'category_landscape_upload'=> [
        "default" => [
            "size" => 180000,
            "size_gif" => 500000,
            "height" => 698,
            "width" => 1535
        ],
    ],
    'category_portrait_presets'=> [
        "default" => [
            "1x"=>"271X428",
            "2x"=>"409X646",
            "3x"=>"818X1293",
            "load"=>"10X16" 
        ],
    ],
    'category_portrait_upload'=> [
        "default" => [
            "size" => 160000,
            "size_gif" => 500000,
            "height" => 1293,
            "width" => 818
        ],
    ],
    'story_box_medium_presets'=> [
        "default" => [
            "1x"=>"248X273",
            "2x"=>"370X407",
            "3x"=>"740X814",
            "load"=>"10X11" 
        ],
    ],
    'story_box_medium_upload'=> [
        "default" => [
            "size" => 120000,
            "size_gif" => 500000,
            "height" => 814,
            "width" => 740
        ],
    ],
    'story_landscape_presets'=> [
        "default" => [
            "1x"=>"521X273",
            "2x"=>"778X408",
            "3x"=>"1553X814",
            "load"=>"10X5" 
        ],
    ],
    'story_landscape_upload'=> [
        "default" => [
            "size" => 180000,
            "size_gif" => 500000,
            "height" => 814,
            "width" => 1553
        ],
    ],
    'story_portrait_presets'=> [
        "default" => [
            "1x"=>"272X378",
            "2x"=>"409X568",
            "3x"=>"818X1136",
            "load"=>"10X13" 
        ],
    ],
    'story_portrait_upload'=> [
        "default" => [
            "size" => 200000,
            "size_gif" => 500000,
            "height" => 1136,
            "width" => 818
        ],
    ],
];
