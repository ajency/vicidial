<?php

return [
	'disk_name' => 's3',
	'base_root_path' => '',
	'default_base_path' => 'other_files',
	'valid_image_formats' => ['jpg', 'png', ],
	'valid_file_formats' => ['doc', 'docx', 'pdf'],
	'model' => [
		'App\ProductColor' => [
			'base_path' => 'products',
			'slug_column' => 'elastic_id',
		],
	],
];