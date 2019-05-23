<?php

return [
	'auth_token' => env("SERVICE_COMM_AUTH",""),
	'url' => [
		'inventory' => env('INVENTORY_SERVICE_URL',''),
		'backoffice' => env("BACKOFFICE_URL","")
	],
	'mapping' => [
		'updateSubOrderStatus' => [
			'model' => 'App\Http\Controllers\v2\OrderController',
			'function' => 'updateSubOrderStatus',
		],
		'updateOrderLineStatus' => [
			'model' => 'App\Http\Controllers\v2\OrderController',
			'function' => 'updateOrderLineStatus',
		],
		'inventoryElasticUpdate' => [
			'model' => 'App\Variant',
			'function' => 'updateInventory',
		],
		'addVendorLocation' => [
			'model' => 'App\Location',
			'function' => 'addVendorLocation',
		],
		'updateOrderLineIndex' => [
			'model' => "App\OrderLine",
			'function' => 'updateMultipleIndex'
		],
	],
	'async_provider' => 'sns',
	'sns' => [
		'client' => [
			'id' => env('AWS_ID'),
			'credentials' => [
				'key' => env('AWS_KEY'),
				'secret' => env('AWS_SECRET')
			],
			'region'=> env('AWS_REGION'),
			'version' => 'latest'
		],
		'prefix' => str_slug(env('APP_ENV')),
		'topics' => ['OrderCreated']
	],
];