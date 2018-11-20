<?php

use App\Defaults;
use App\Location;
use App\User;
use Carbon\Carbon;
function valInteger($object, $values)
{
    if (empty($object) || empty($values)) {
        return false;
    }

    foreach ($values as $value) {
        if (!isset($object[$value]) || !(ctype_digit($object[$value]) || is_integer($object[$value]))) {
            return false;
        }

    }
    return true;
}

function checkUserCart($token, $cart)
{
    $token = explode('Bearer ', $token)[1];
    $user  = User::where('api_token', $token)->first();
    if ($user->id != $cart->user_id) {
        abort(403);
    }

}

function makeQueryfromParams($searchObject)
{
    $queryParams    = [];
    $elasticMapping = [
        'product_category_type' => 'search_data.string_facet.product_category_type',
        'product_gender'        => 'search_data.string_facet.product_gender',
        'product_age_group'     => 'search_data.string_facet.product_age_group',
        'product_subtype'       => 'search_data.string_facet.product_subtype',
        'product_color_html'    => 'search_data.string_facet.product_color_html',
        'variant_sale_price'    => 'search_data.number_facet.variant_sale_price',
    ];

    foreach ($searchObject as $filterType => $params) {
        switch ($filterType) {
            case 'primary_filter':
                foreach ($elasticMapping as $param => $map) {
                    if (array_has($params, $param)) {
                        $categ = $params[$param];
                        if (gettype($categ) != 'array') {
                            $categ = [$categ];
                        }
                        if (array_search('all', $categ) === false) {
                            array_set($queryParams, $map, ["type" => "enum", "value" => $categ]);
                        }
                    }
                }
                break;
            case 'range_filter':
                foreach ($elasticMapping as $param => $map) {
                    if (array_has($params, $param)) {
                        array_set($queryParams, $map, ["type" => "range", "value" => $params[$param]]);
                    }
                }
                break;
        }
    }

    return $queryParams;
}

function sanitiseProductData($odooData)
{
    $create_date   = new Carbon($odooData['create_date']);
    $__last_update = new Carbon($odooData['__last_update']);
    $write_date    = new Carbon($odooData['write_date']);
    $i             = 0;
    $index         = [
        "product_id"                       => $odooData["id"],
        "type"                             => "product",
        "product_name"                     => $odooData["name"],
        "product_article_desc"             => $odooData["article_desc"],
        "product_barcode"                  => $odooData["barcode"], //???
        "product_style_no"                 => $odooData["style_no"],
        "product_create_date"              => $create_date->timestamp,
        "product_last_update"              => $__last_update->timestamp,
        "product_prod_type"                => $odooData["prod_type"], //???
        "product_hs_code"                  => $odooData["hs_code"],
        "product_variant_ids"              => $odooData["product_variant_ids"],
        "product_att_magento_display_name" => $odooData["att_magento_display_name"],
        "product_write_date"               => $write_date->timestamp, //???
        "product_display_name"             => $odooData["display_name"],
        "product_categories"               => $odooData["categ_id"][1],
        "product_active"                   => $odooData["active"],
        "product_att_fashionability"       => $odooData["att_fashionability"],
        "product_att_sleeves"              => $odooData["att_sleeves"],
        "product_description_sale"         => $odooData["description_sale"],
        "product_att_material"             => $odooData["att_material"],
        "product_att_occasion"             => $odooData["att_occasion"],
        "product_att_wash"                 => $odooData["att_wash1"],
        "product_att_fabric_type"          => $odooData["att_fabric_type"],
        "product_att_product_type"         => $odooData["att_product_type"],
        "product_att_other_attribute"      => $odooData["att_val_add1"],
        "product_vendor"                   => ($odooData["vendor_id"]) ? $odooData["vendor_id"][1] : null,
    ];
    $product_categories = explode('/', $index['product_categories']);
    $categories         = ['product_category_type', 'product_gender', 'product_age_group', 'product_subtype'];
    foreach ($categories as $category) {
        $index[$category] = (isset($product_categories[$i])) ? trim($product_categories[$i]) : 'Others';
        $i++;
    }
    if($index['product_gender'] == 'Others') $index['product_gender'] = 'Unisex';
    return $index;
}

function sanitiseVariantData($odooData, $attributeData, $inventoryData)
{
    $variantData = [
        'variant_id'             => $odooData['id'],
        'variant_type'           => 'variant',
        'variant_barcode'        => $odooData['barcode'],
        'variant_standard_price' => floatval($odooData['standard_price']),
        'variant_lst_price'      => $odooData['lst_price'],
        'variant_sale_price'     => $odooData['sale_price'],
        'variant_product_own'    => ($odooData['product_own']) ? 'private' : 'not private',
        'variant_style_no'       => $odooData['style_no'],
        'variant_active'         => $odooData['active'],
        'variant_availability'   => $inventoryData['availability'],
    ];
    $variantData['variant_discount']         = $odooData['lst_price'] - $odooData['sale_price'];
    $variantData['variant_discount_percent'] = ($odooData['lst_price'] > 0) ? $variantData['variant_discount'] / $odooData['lst_price'] * 100 : 0;
    $color                                   = $attributeData->firstWhere('attribute_id.1', 'COLOR');
    $size                                    = $attributeData->firstWhere('attribute_id.1', 'SIZE');
    if ($color) {
        $variantData['product_color_id']   = $color['id'];
        $variantData['product_color_name'] = $color['name'];
        $variantData['product_color_html'] = $color['html_color'];

    } else {
        $variantData['product_color_id']   = 0;
        $variantData['product_color_name'] = "Not Applicable";
        $variantData['product_color_html'] = "#4166F5";
    }
    if ($size) {
        $variantData['variant_size_id']   = $size['id'];
        $variantData['variant_size_name'] = $size['name'];
    } else {
        $variantData['variant_size_id']   = 0;
        $variantData['variant_size_name'] = "Miscellaneous";
    }

    return $variantData;
}

function generateFullTextForIndexing($productData, $variant)
{
    $textComponents = [
        $productData['product_name'],
        $productData['product_article_desc'],
        $productData['product_barcode'],
        $productData['product_style_no'],
        $productData['product_att_fashionability'],
        $productData['product_att_sleeves'],
        $productData['product_att_material'],
        $productData['product_category_type'],
        $productData['product_gender'],
        $productData['product_age_group'],
        $productData['product_subtype'],
        $variant['variant_barcode'],
        $variant['variant_style_no'],
        $variant['product_color_name'],
        $variant['product_color_html'],
        $variant['variant_size_name'],
    ];
    return implode(' ', $textComponents);
}

function buildProductIndexFromOdooData($productData, $variantData)
{
    $productData['product_slug'] = str_slug(implode(' ', [
        $productData['product_att_magento_display_name'],
        $productData['product_id'],
        $variantData->first()['product_color_name'],
    ]));

    $indexData = [
        'type'        => "product",
        'id'          => $productData['product_id'] . '.' . $variantData->first()['product_color_id'],
        'search_data' => [],
    ];
    $product_title = ($productData['product_att_magento_display_name'] && $productData['product_att_magento_display_name']!='') ? $productData['product_att_magento_display_name'] : $productData['product_name'];
    $indexData['search_result_data'] = [
        'product_id'                        => $productData['product_id'],
        "product_title"                     => $product_title,
        "product_att_magento_display_name"  => $productData['product_att_magento_display_name'],
        "product_name"                      => $productData['product_name'],
        "product_slug"                      => $productData['product_slug'],
        "product_style"                     => $productData['product_style_no'],
        "product_description"               => $productData['product_description_sale'],
        "product_att_sleeves"               => $productData['product_att_sleeves'],
        "product_att_fashionability"        => $productData['product_att_fashionability'],
        "product_att_material"              => $productData['product_att_material'],
        "product_att_occasion"              => $productData['product_att_occasion'],
        "product_att_wash"                  => $productData['product_att_wash'],
        "product_att_fabric_type"           => $productData['product_att_fabric_type'],
        "product_att_product_type"          => $productData['product_att_product_type'],
        "product_att_other_attribute"       => $productData['product_att_other_attribute'],
        "product_category_type"             => $productData['product_category_type'],
        "product_gender"                    => $productData['product_gender'],
        "product_age_group"                 => $productData['product_age_group'],
        "product_subtype"                   => $productData['product_subtype'],
        "product_vendor"                    => $productData['product_vendor'],
        "product_color_id"                  => $variantData->first()['product_color_id'],
        "product_color_slug"                => str_slug($variantData->first()['product_color_name']),
        "product_color_name"                => $variantData->first()['product_color_name'],
        "product_color_html"                => $variantData->first()['product_color_html'],
        "product_images"                    => [],
    ];
    $indexData["variants"] = [];
    foreach ($variantData as $variant) {
        $indexData['variants'][] = [
            "variant_id"             => $variant['variant_id'],
            "variant_list_price"     => $variant['variant_lst_price'],
            "variant_sale_price"     => $variant['variant_sale_price'],
            "variant_standard_price" => $variant['variant_standard_price'],
            "variant_size_id"        => $variant['variant_size_id'],
            "variant_size_name"      => $variant['variant_size_name'],
            "variant_availability"   => $variant['variant_availability'],
            "variant_product_own"    => $variant['variant_product_own'],
        ];
        $search_data = [
            'full_text'         => generateFullTextForIndexing($productData, $variant),
            'full_text_boosted' => generateFullTextForIndexing($productData, $variant),
            'string_facet'      => [],
            'number_facet'      => [],
            'boolean_facet'     => [],
            'attributes'        => [],
        ];
        $facets = ['string_facet', 'number_facet', 'boolean_facet'];
        foreach ($facets as $facet) {
            foreach (config('product.facets.' . $facet . '.product') as $value) {
                if($value == 'product_gender' && $productData[$value] == 'Unisex'){
                    $search_data[$facet][] =['facet_name' => $value, 'facet_value'=> 'Girls', 'facet_slug'=>'girls'];
                    $search_data[$facet][] =['facet_name' => $value, 'facet_value'=> 'Boys', 'facet_slug'=>'boys'];
                    $search_data[$facet][] =['facet_name' => $value, 'facet_value'=> 'Unisex', 'facet_slug'=>'unisex'];
                    continue;
                }
                $facetObj = [
                    'facet_name'  => $value,
                    'facet_value' => $productData[$value],
                ];
                if ($facet == 'string_facet') {
                    $facetObj['facet_slug'] = str_slug($productData[$value]);
                }
                $search_data[$facet][] = $facetObj;
            }
            foreach (config('product.facets.' . $facet . '.variant') as $value) {
                $facetObj = [
                    'facet_name'  => $value,
                    'facet_value' => $variant[$value],
                ];
                if ($facet == 'string_facet') {
                    $facetObj['facet_slug'] = str_slug($variant[$value]);
                }

                $search_data[$facet][] = $facetObj;
            }
        }
        foreach (config('product.facets.attributes.product') as $value) {
            $search_data['attributes'][] = [
                'attribute_name'  => $value,
                'attribute_value' => $productData[$value],
                'attribute_slug'  => str_slug($productData[$value]),
            ];
        }
        foreach (config('product.facets.attributes.variant') as $value) {
            $search_data['attributes'][] = [
                'attribute_name'  => $value,
                'attribute_value' => $variant[$value],
            ];
        }
        $indexData['search_data'][] = $search_data;
    }
    $categories            = collect(explode('/', $productData['product_categories']));
    $indexData['category'] = [
        'direct_parents' => [$categories->last()],
        'all_parents'    => $categories->toArray(),
        'paths'          => [str_slug($productData['product_name']) . '/' . $productData['product_style_no'] . "/" . str_slug($variant['product_color_name']) . '/buy'],
    ];
    $indexData['number_sort'] = [
        "variant_discount"         => $variant['variant_discount'],
        "variant_discount_percent" => $variant['variant_discount_percent'],
        "variant_lst_price"        => $variant['variant_lst_price'],
        "variant_sale_price"       => $variant['variant_sale_price'],
    ];
    $indexData['string_sort'] = [
        "product_name" => $productData['product_name'],
    ];

    return $indexData;
}

function sanitiseInventoryData($inventoryData)
{
    $inventory = [];
    foreach ($inventoryData as $connectionData) {
        foreach ($connectionData as $invtry) {
            $location = Location::where('odoo_id', $invtry["location_id"][0])->first();
            if ($location == null || $location->use_in_inventory == false) {
                continue;
            }
            $temp = [
                "location_id"   => $invtry["location_id"][0],
                "location_name" => $invtry["location_id"][1],
                "quantity"      => intval($invtry["quantity"]),
            ];
            $inventory[$invtry["product_id"][0]][$temp["location_id"]] = $temp;

        }
    }
    return $inventory;
}

function inventoryFormatData(array $variant_ids, array $inventory)
{

    $final = [];
    foreach ($variant_ids as $variant_id) {
        $ret = [
            "availability" => false,
            "inventory"    => isset($inventory[$variant_id]) ? $inventory[$variant_id] : [],
        ];
        if (isset($inventory[$variant_id])) {
            foreach ($inventory[$variant_id] as $invntry) {
                if ($invntry > 0) {
                    $ret["availability"] = true;
                    break;
                }
            }
        }
        $final[$variant_id] = $ret;
    }

    return $final;
}

function generateVariantImageName($product_name, $color_name, $colors, $index)
{
    $colors_count = (count($colors) > 0) ? array_count_values($colors) : 0;
    \Log::debug("colors count===");
    \Log::debug($colors_count);
    $append = "";
    if ($colors_count["$color_name"] > 1) {
        $append = ($index + 1);
    }

    $image_name = $product_name . "-" . $color_name . $append;
    $image_name = str_slug(implode(' ', [$product_name, $color_name, $append]));
    return $image_name;

}

function generateSubordersData($cartItems, $locations)
{
    $finalCart     = [];
    $locationsData = $locations->combine($locations->map(function ($item, $key) {
        return ['id' => $item, 'items' => collect(), 'remaining_items' => collect()];
    }));
    foreach ($cartItems as $cartItem) {
        $processedLocations = [];
        foreach ($cartItem['item']->inventory as $locationData) {
            if (array_search($locationData['location_id'], $locations->toArray()) === false) {
                continue;
            }
            $transferQty = ($cartItem['quantity'] < $locationData['quantity']) ? $cartItem['quantity'] : $locationData['quantity'];
            $locationsData[$locationData['location_id']]['items']->push([
                'variant'  => $cartItem['item'],
                'quantity' => $transferQty,
            ]);
            $processedLocations[] = $locationData['location_id'];
            if ($transferQty < $cartItem['quantity']) {
                $locationsData[$locationData['location_id']]['remaining_items']->push([
                    'item'     => $cartItem['item'],
                    'quantity' => $cartItem['quantity'] - $transferQty,
                ]);
            }
        }
        foreach ($locations as $warehouseID) {
            if (array_search($warehouseID, $processedLocations) === false) {
                $locationsData[$warehouseID]['remaining_items']->push($cartItem);
            }
        }
    }

    //start function which chooses the location
    $selectedLocation = $locationsData->sortByDesc(function ($product, $key) {
        return $product['items']->count();
    })->first();
    //end function that chooses the location

    $key = $selectedLocation['id'];
    if ($selectedLocation['remaining_items']->count() != 0) {
        $otherOrders       = generateSubordersData($selectedLocation['remaining_items'], $locations->diff([$key]));
        $otherOrders[$key] = $selectedLocation['items'];
        return $otherOrders;
    } else {
        return [$key => $selectedLocation['items']];
    }
}

function getCartData($cart, $fetch_related = true, $current_quantity = false)
{
    $items = [];
    foreach ($cart->cart_data as $cart_item) {
        $items[] = $cart->getItem($cart_item['id'], $fetch_related, $current_quantity);
    }
    return $items;
}

function validateOrder($user, $order)
{
    if ($order == null || $order->cart->user_id != $user->id) {
        abort(403);
    }
}

function validateCart($user, $cart, $type = null)
{
    if ($cart == null || $cart->user_id != $user->id) {
        abort(403);
    }
    if ($type != null && $cart->type != $type) {
        abort(403, 'invalid cart');
    }
}

function validateAddress($user, $address)
{
    if ($address == null || $address->user_id != $user->id) {
        abort(403);
    }
}

function sanitiseMoveData($moveData, $prefix = '')
{
    $date        = new Carbon($moveData["date"]);
    $create_date = new Carbon($moveData["create_date"]);
    $body        = [
        $prefix . "location_id"      => $moveData["location_id"][0],
        $prefix . "location"         => $moveData["location_id"][1],
        $prefix . "location_dest_id" => $moveData["location_dest_id"][0],
        $prefix . "location_dest"    => $moveData["location_dest_id"][1],
        $prefix . "state"            => $moveData["state"],
        $prefix . "product_id"       => $moveData["product_id"][0],
        $prefix . "product"          => $moveData["product_id"][1],
        $prefix . "product_uom_id"   => $moveData["product_uom_id"][0],
        $prefix . "product_uom"      => $moveData["product_uom_id"][1],
        $prefix . "date"             => $date->timestamp,
        $prefix . "create_date"      => $create_date->timestamp,
        $prefix . "picking_id"       => $moveData["picking_id"][0],
        $prefix . "picking"          => $moveData["picking_id"][1],
        $prefix . "move_id"          => $moveData["move_id"][0],
        $prefix . "move"             => $moveData["move_id"][1],
        $prefix . 'qty_done'         => $moveData['qty_done'],
        $prefix . 'reference'        => $moveData['reference'],
        $prefix . 'display_name'     => $moveData['display_name'],
        $prefix . 'id'               => $moveData['id'],
        $prefix . 'owner_id'         => $moveData['owner_id'],
        $prefix . 'consume_line_ids' => $moveData['consume_line_ids'],
        $prefix . 'ordered_qty'      => $moveData['ordered_qty'],
        $prefix . 'from_loc'         => $moveData['from_loc'],
        $prefix . 'to_loc'           => $moveData['to_loc'],
        $prefix . 'package_id'       => $moveData['package_id'],
        $prefix . 'is_locked'        => $moveData['is_locked'],
        $prefix . 'lot_name'         => $moveData['lot_name'],
    ];

    return $body;
}

function generateOTP()
{
    $min   = str_pad(1, config('otp.length'), 0);
    $max   = str_pad(9, config('otp.length'), 9);
    $token = random_int($min, $max);
    return $token;
}

function createAccessToken($UserObject)
{
    $UserObject->createToken('KSS_USER')->accessToken;
}

function fetchAccessToken($UserObject)
{
    return $token = $UserObject->tokens->first();
}

/**
 * This function is used to send email for each event
 * This function will send an email to given recipients
 * @param data can contain the following extra parameters
 *   @param template_data
 *   @param to
 *   @param cc
 *   @param bcc
 *   @param from[id]
 *   @param from[name]
 *   @param subject
 *   @param delay  - @var integer
 *   @param priority - @var string -> ['low','default','high']
 *   @param attach - An Array of arrays each containing the following parameters:
 *           @param file - base64 encoded raw file
 *           @param as - filename to be given to the attachment
 *           @param mime - mime of the attachment
 */
function sendEmail($event, $data)
{
    $email = new \Ajency\Comm\Models\EmailRecipient();

    //From
    if (isset($data['from'])) {
        $fromId   = (isset($data['from']['id'])) ? $data['from']['id'] : config('communication.email.from.id');
        $fromName = (isset($data['from']['name'])) ? $data['from']['name'] : config('communication.email.from.name');
        $email->setFrom($fromId, $fromName);
    } else {
        $email->setFrom(config('communication.email.from.id'), config('communication.email.from.name'));
    }

    //TO
    $to = (isset($data['to'])) ? Defaults::getEmailExtras('to', $data['to']) : Defaults::getEmailExtras('to');
    $email->setTo($to);

    //CC
    $cc = (isset($data['cc'])) ? Defaults::getEmailExtras('cc', $data['cc']) : Defaults::getEmailExtras('cc');
    $email->setCc($cc);

    //BCC
    $bcc = (isset($data['bcc'])) ? Defaults::getEmailExtras('bcc', $data['bcc']) : Defaults::getEmailExtras('bcc');
    $email->setBcc($bcc);

    //Template Data
    $params = (isset($data['template_data'])) ? $data['template_data'] : [];
    $email->setParams($params);

    if (isset($data['attach'])) {
        $email->setAttachments($data['attach']);
    }

    $notify = new \Ajency\Comm\Communication\Notification();
    $notify->setEvent($event);
    $notify->setRecipientIds([$email]);
    //subject
    $notify->setProviderParams([
        'email' => ['subject' => (isset($data['subject'])) ? $data['subject'] : ""],
    ]);
    if (isset($data['delay'])) {
        $notify->setDelay($data['delay']);
    }

    if (isset($data['priority'])) {
        $notify->setPriority($data['priority']);
    }

    \AjComm::sendNotification($notify);

}

/**
 * This function is used to send sms for each event
 * This function will send an sms to given recipients
 * @param data can contain the following extra parameters
 *   @param to - array
 *   @param message - string
 *   @param delay  - @var integer
 * @param override
 */
function sendSMS($event, $data = [], $override = false)
{
    if (!isset($data['to']) || !isset($data['message'])) {
        return false;
    }

    if (!is_array($data['to'])) {
        $data['to'] = [$data['to']];
    }

    $sms = new \Ajency\Comm\Models\SmsRecipient();
    $sms->setTo($data['to']);
    $sms->setMessage($data['message']);
    if ($override) {
        $sms->setOverride(true);
    }

    $notify = new \Ajency\Comm\Communication\Notification();
    $notify->setEvent($event);
    $notify->setRecipientIds([$sms]);
    if (isset($data['delay'])) {
        $notify->setDelay($data['delay']);
    }

    if (isset($data['priority'])) {
        $notify->setPriority($data['priority']);
    }

    \AjComm::sendNotification($notify);

}
