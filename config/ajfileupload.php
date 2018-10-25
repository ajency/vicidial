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
    'presets'             => [
        "original"   => [],
        "thumb"      => [
            "1x" => "100X100",
            "2x" => "200X200",
        ],
        "list-thumb" => [
            "1x" => "100X100",
            "2x" => "200X200",
        ],
        "main"       => [
            "1x" => "100X100",
            "2x" => "200X200",
        ],
        "zoom"       => [
            "1x" => "100X100",
            "2x" => "200X200",
        ],
    ],
];
