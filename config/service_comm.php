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
];