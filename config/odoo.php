<?php
$connections = array();
$conn_cnt    = env('ODOO_CONN_CNT', '0');
for ($conn = 1; $conn <= intval($conn_cnt); $conn++) {
    $connections[] = array("username" => env('ODOO_USER' . $conn, ''), "password" => env('ODOO_PASS' . $conn, ''));
}

return [
    'url'           => env('ODOO_URL', ''),
    'db'            => env('ODOO_DB', ''),
    'limit'         => intval(env('ODOO_LIMIT', '')),
    'connections'   => $connections,
    'update_inventory' => env('INV_UPDATE_COUNT',20),
    'update_products' => env('PROD_UPDATE_COUNT',20),
    'dropshipping_warehouse_id' => env('DROPSHIPPING_WAREHOUSE',1),
    'dropshipping_warehouse_name' => 'Omni Edge Retail Private Limited',

    'model_fields'  => [
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
        'warehouse'  => [
            'name',
            'code',
            'company_id',
            'carpet_area',
            'retail_area',
            'latitude',
            'longitude',
            'store_manager_phone',

        ],
        'states'     => [],
        'attributes'  => [
            'attribute_id',
            'html_color',
            'name',
            'product_ids',
            'id',
        ],
        'discounts'  => [
            'discount_rule',
            'id',
            'name',
            'discount_amt',
            'apply1',
            'qty_step',
            'from_date1',
            'to_date1',
            'priority1',
            'condition_id',
        ],
        'discount_products'  => [
            'product_ids',
        ],
    ],

    'model'       => [
        'discount' => [
            'name'   => 'product.template',
            'fields' => [
                'id',
                'name',
                'type', //discount
                'discount_rule', //[cart price, product price]
                'from_date1',
                'to_date1',
                'priority1',
                'coupon_typ', //specific/no coupon
                'uses_customer', //uses per customer
                'auto_gen',
                'uses_coup', //uses per coupon
                'apply1', //action - apply (discount type)
                'discount_amt',
                'max_qty',
                'qty_step',
                'apply_ship',
                'is_discard_rule', //discard other discounts
                'free_ship',
                'coupon_qty',
                'code_len',
                'code_format',
                'code_prefix',
                'code_suffix',
                'dash_x',
                'coupon_count',
                'condition_id',
                'description_sale',
            ],
        ],
        'coupon'   => [
            'name'   => 'sale.order.coupon',
            'fields' => [
                'create_uid',
                'code',
                'global_code',
                'total_coupon_count',
                'uses_customer',
                '__last_update',
                'expiration_date',
                'global_discount_coupon',
                'program_id', //product.template relation
                'write_uid',
                'state',
                'consumed_coupon_count',
                'uses_coup',
                'write_date',
                'create_date',
                'partner_ids',
                'partner_id',
                'id',
                'display_name',
            ],
        ],
    ],
];
