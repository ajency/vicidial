<?php
use Ripcord\Ripcord;
use Carbon\Carbon;

$common = Ripcord::client("https://indrajal.stage.kidsuperstore.in/xmlrpc/2/common");
$models = Ripcord::client("https://indrajal.stage.kidsuperstore.in/xmlrpc/2/object");

$user_id = $common->authenticate('kss-stage', 'admin_magento', 'LyraOmniRetail@987', []);


$date_order = new Carbon;

$params = [

    'partner_id'               => 1229,
    'partner_invoice_id'       => 1231,
    'partner_shipping_id'      => 1231,
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
    'note'                     => "Payment Information:- PayU Money",
    'warehouse_id'             => 2,
    'incoterm'                 => false,
    'picking_policy'           => 'direct',
    'shipment_status'          => false,
    'user_id'                  => false,
    'team_id'                  => false,
    'cart_recovery_email_sent' => false,
    'client_order_ref'         => false,
    'company_id'               => 1,
    'analytic_account_id'      => false,
    'date_order'               => $date_order->toDateTimeString(),
    'fiscal_position_id'       => false,
    'ecommerce_channel'        => 'magento',
    'origin'                   => "test000000245",
    "order_line"               => [[
									    0,
									    "virtual_1100",
									    [
									        "barcode"            => false,
									        "product_id"         => 5742, 
									        "layout_category_id" => false,
									        "product_uom_qty"    => 1,
									        "product_uom"        => 1,
									        "route_id"           => false,
									        "price_unit"         => 1299, 
									        "discount"           => 0,
									        "product_packaging"  => false,
									        "tax_id"             => [],
									        "customer_lead"      => 0,
									        "analytic_tag_ids"   => [],
									        "name"               => "Parallel_Demo1_White_12-18m_5742",
									        'invoice_lines'      => [],
									    ],
									]],
    "name"                     => "test000000245"

];


$data = collect($models->execute_kw(
		    'kss-stage',
		    $user_id,
		    'LyraOmniRetail@987',
		    "sale.order", 'create', [$params], null
		));



echo "<pre>";
print_r($data);