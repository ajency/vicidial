<?php

return [
	'auth_token' => env("SERVICE_COMM_AUTH",""),
	'url' => [
		'inventory' => env('INVENTORY_SERVICE_URL',''),
		'backoffice' => env("BACKOFFICE_URL","")
	],
	'mapping' => [
		'updateSubOrderStatus' => [
			'model' => 'App\Http\Controllers\v1\OrderController',
			'function' => 'updateSubOrderStatus',
		],
		'inventoryElasticUpdate' => [
			'model' => 'App\Variant',
			'function' => 'updateInventory',
		],
	],
];