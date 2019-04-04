<?php

return [
    'disk_name'           => 's3',
    'base_root_path'      => env('PHOTO_PRESET').'',
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
            "load"=>"20X7"
        ],
        "portrait" => [
            "1x"=>"400X311",
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
    'theme_presets'=> [
        "landscape" => [
            "1x"=>"700X245",
            "2x"=>"1200X420",
            "3x"=>"2000X700",
            "load"=>"20X7"
        ],
        "portrait" => [
            "1x"=>"400X311",
            "2x"=>"700X544",
            "3x"=>"1200X933" 
        ],
    ],
    'theme_upload'=> [
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
    'landing_presets'=> [
        "landscape" => [
            "1x"=>"512X233",
            "2x"=>"1024X466",
            "3x"=>"1536X699",
            "load"=>"20X9"
        ],
        "portrait" => [
            "1x"=>"400X311",
            "2x"=>"700X544",
            "3x"=>"1200X933" 
        ],
    ],
    'landing_upload'=> [
        "landscape" => [
            "size" => 250000,
            "height" => 699,
            "width" => 1536
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
    'trending_presets'=> [],
    'trending_upload'=> [],

    'stories_presets'=> [
        "default" => [
            "1x"=>"360X360",
            "2x"=>"720X720",
            "3x"=>"1080X1080",
            "load"=>"10X13" 
        ],
    ],
    'stories_upload'=> [
        "default" => [
            "size" => 110000,
            "size_gif" => 500000,
            "height" => 1080,
            "width" => 1080
        ],
    ],

    'categories_presets'=> [
        "default" => [
            "1x"=>"300X300",
            "2x"=>"600X600",
            "3x"=>"900X900",
            "load"=>"10X13" 
        ],
    ],
    'categories_upload'=> [
        "default" => [
            "size" => 135000,
            "size_gif" => 500000,
            "height" => 900,
            "width" => 900
        ],
    ],

    'brand_presets'=> [
        "default" => [
            "1x"=>"170X170",
            "2x"=>"340X340",
            "3x"=>"510X510",
            "load"=>"10X13" 
        ],
    ],
    'brand_upload'=> [
        "default" => [
            "size" => 40000,
            "size_gif" => 500000,
            "height" => 510,
            "width" => 510
        ],
    ],

    'offer_presets'=> [
        "default" => [
            "1x"=>"350X350",
            "2x"=>"700X700",
            "3x"=>"1050X1050",
            "load"=>"10X13" 
        ],
    ],
    'offer_upload'=> [
        "default" => [
            "size" => 130000,
            "size_gif" => 500000,
            "height" => 1050,
            "width" => 1050
        ],
    ],


    'week_theme_presets'=> [
        "landscape" => [
            "1x"=>"600X300",
            "2x"=>"1200X600",
            "3x"=>"1800X900",
            "load"=>"20X7"
        ],
        "portrait" => [
            "1x"=>"400X311",
            "2x"=>"700X544",
            "3x"=>"1200X933" 
        ],
    ],
    'week_theme_upload'=> [
        "landscape" => [
            "size" => 140000,
            "height" => 900,
            "width" => 1800
        ],
        "portrait" => [
            "size" => 120000,
            "height" => 933,
            "width" => 1200
        ],
    ],

    'month_theme_presets'=> [
        "landscape" => [
            "1x"=>"600X300",
            "2x"=>"1200X600",
            "3x"=>"1800X900",
            "load"=>"20X7"
        ],
        "portrait" => [
            "1x"=>"400X311",
            "2x"=>"700X544",
            "3x"=>"1200X933" 
        ],
    ],
    'month_theme_upload'=> [
        "landscape" => [
            "size" => 140000,
            "height" => 900,
            "width" => 1800
        ],
        "portrait" => [
            "size" => 120000,
            "height" => 933,
            "width" => 1200
        ],
    ],

    'gender_tab_presets'=> [
        "default" => [
            "1x"=>"125X75",
            "2x"=>"250X150"
        ]
    ],
    'gender_tab_upload'=> [
        "default" => [
            "size" => 40000,
            "size_gif" => 500000,
            "height" => 150,
            "width" => 250
        ]
    ],

    'newoffer_presets'=> [],
    'newoffer_upload'=> [],

    'newbanner_presets'=> [
        "landscape" => [
            "1x"=>"700X245",
            "2x"=>"1200X420",
            "3x"=>"2000X700",
            "load"=>"20X7"
        ],
        "portrait" => [
            "1x"=>"400X329",
            "2x"=>"600X493",
            "3x"=>"1200X985" 
        ],
    ],
    'newbanner_upload'=> [
        "landscape" => [
            "size" => 250000,
            "height" => 700,
            "width" => 2000
        ],
        "portrait" => [
            "size" => 250000,
            "height" => 985,
            "width" => 1200
        ],
    ],

    'brandbanner_presets'=> [
        "landscape" => [
            "1x"=>"590X321",
            "2x"=>"992X540",
            "3x"=>"1000X539",
            "load"=>"20X11"
        ],
        "portrait" => [
            "1x"=>"400X216",
            "2x"=>"600X324",
            "3x"=>"1200X648" 
        ],
    ],
    'brandbanner_upload'=> [
        "landscape" => [
            "size" => 250000,
            "height" => 539,
            "width" => 1000
        ],
        "portrait" => [
            "size" => 250000,
            "height" => 648,
            "width" => 1200
        ],
    ]
];
