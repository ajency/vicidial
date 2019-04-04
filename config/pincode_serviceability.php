<?php
return [
	'default_shipment_service' => 'Delhivery',
    'services' => [
        'delhivery' => [
                'client' => 'OMNIEDGERETAIL SURFACE',
                'api_key' => env("DELHIVERY_API_KEY",""),
                'gateway_url' => env("DELHIVERY_GATEWAY_URL","")
            ],
    ]

];