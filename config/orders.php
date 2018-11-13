<?php
return [
    "expiry"        => env('ORDER_EXPIRY', 15),
    "payu_expiry"   => env('PAYU_ORDER_EXPIRY', 15),
    "odoo_order_defaults" => [
        'update_bool'              => false,
        'company_id_fran'          => 1,
        'franchisee_store'         => false,
        'vendor_bill'              => false,
        'validity_date'            => false,
        'use_internal'             => false,
        'ship_to_partner'          => false,
        'pricelist_id'             => 1,
        'magento_status'           => false,
        'payment_method_id'        => 35,
        'payment_term_id'          => false,
        'carrier_id'               => 2,
        'delivery_price'           => 0,
        'delivery_rating_success'  => false,
        'delivery_message'         => false,
        'pickup_date_time'         => false,
        'pack_count'               => 0,
        'shipping_charge'          => 0,
        'note'                     => 'Payment Information:- PayU Money',
        'incoterm'                 => false,
        'picking_policy'           => 'direct',
        'shipment_status'          => false,
        'user_id'                  => false,
        'team_id'                  => false,
        'cart_recovery_email_sent' => false,
        'client_order_ref'         => false,
        'analytic_account_id'      => false,
        'fiscal_position_id'       => false,
        'ecommerce_channel'        => 'magento',
    ],
    "odoo_orderline_defaults" => [
        "barcode"            => false,
        "layout_category_id" => false,
        "product_uom"        => 1,
        "route_id"           => false,
        "product_packaging"  => false,
        "tax_id"             => [],
        "customer_lead"      => 0,
        "analytic_tag_ids"   => [],
        "invoice_lines"      => [],
    ],
];
