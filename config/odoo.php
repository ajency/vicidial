<?php
$connections = array();
$conn_cnt    = env('ODOO_CONN_CNT', '0');
for ($conn = 1; $conn <= intval($conn_cnt); $conn++) {
    $connections[] = array("username" => env('ODOO_USER' . $conn, ''), "password" => env('ODOO_PASS' . $conn, ''));
}

return [
    'url'               => env('ODOO_URL', ''),
    'db'                => env('ODOO_DB', ''),
    'limit'             => intval(env('ODOO_LIMIT', '')),
    'connections'       => $connections,

    'model_fields'      => [
        'location'   => [
            'name',//
            'company_id',//
            "usage", //
            "warehouse_id",// 
            "location_id",// 
            "display_name", //
            "city", 
            "state_name", 
            "street", 
            "street2", 
            "zip",
            "store_code",
        ],
        'warehouse' => [
            'name',
            'code',
            'company_id',
            'carpet_area',
            'retail_area',
            'latitude',
            'longitude',

        ],
        'states'     => [],
    ],

    'inventory_limit'   => intval(env('ODOO_INVENTORY_LIMIT', 20)),
];
