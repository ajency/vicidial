<?php

return [
    'disk_name'           => 's3',
    'base_root_path'      => env('PHOTO_PRESET','').'',
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
            "1x" => "326X543",
            "2x" => "652X1086",
            "3x" => "978X1629"
        ],
        "zoom" => [
            "1x" => "1956X3258"
        ],
        "thumb" => [
            "1x" => "96X76",
        ],
        "variant-thumb" => [
            "1x" => "50X84",
            "2x" => "100X168",
            "3x" => "150X252"
        ],
        "list-view" => [
            "1x" => "270X450",
            "2x" => "540X900",
            "3x" => "810X1350",
            "load" => "10X10"
        ],
    ],
];
