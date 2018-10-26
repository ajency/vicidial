<?php

return [
    'disk_name'           => 's3',
    'base_root_path'      => '',
    'default_base_path'   => 'other_files',
    'valid_image_formats' => ['jpg', 'png'],
    'valid_file_formats'  => ['doc', 'docx', 'pdf'],
    'model'               => [
        'App\ProductColor' => [
            'base_path'   => 'products',
            'slug_column' => 'elastic_id',
        ],
    ],
    'presets'=> [
        "original"   => [],
        "main" => [
            "1x" => "326*543",
            "2x" => "652*1086",
            "3x" => "978*1629"
        ],
        "zoom" => [
            "1x" => "1956*3258"
        ],
        "thumb" => [
            "1x" => "96*76",
        ],
        "variant-thumb" => [
            "1x" => "50*84",
            "2x" => "100*68",
            "3x" => "150*252"
        ],
        "list-view" => [
            "1x" => "270*450",
            "2x" => "540*900",
            "3x" => "810*1350",
            "load" => "10*10"
        ],
    ],
];
