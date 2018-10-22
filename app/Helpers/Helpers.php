<?php

use Carbon\Carbon;

function val_integer($object,$values){
	if (empty($object)|| empty($values)) return false;
	foreach ($values as $value) {
		if(!isset($object[$value]) || !(ctype_digit($object[$value]) || is_integer($object[$value]) )) return false;
	}
	return true;
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
    ];
    $product_categories = explode('/', $index['product_categories']);
    $categories         = ['product_category_type', 'product_gender', 'product_age_group', 'product_subtype'];
    foreach ($categories as $category) {
        $index[$category] = (isset($product_categories[$i])) ? trim($product_categories[$i]) : 'Others';
        $i++;
    }
    return $index;
}

function sanitiseVariantData($odooData, $attributeData,$inventoryData)
{
    $variantData = [
        'variant_id'             => $odooData['id'],
        'variant_type'           => 'variant',
        'variant_barcode'        => $odooData['barcode'],
        'variant_standard_price' => floatval($odooData['standard_price']),
        'variant_lst_price'      => $odooData['lst_price'],
        'variant_sale_price'     => $odooData['sale_price'],
        'variant_product_own'    => $odooData['product_own'],
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

    }
    if ($size) {
        $variantData['variant_size_id']   = $size['id'];
        $variantData['variant_size_name'] = $size['name'];
    }
    if (!isset($variantData['product_color_id'])) {
        $variantData['product_color_id'] = 0;
        $variantData['product_color_name'] = "";
        $variantData['product_color_html'] = "";
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

    $indexData = [
        'type'        => "product",
        'id'          => floatval($productData['product_id'] . '.' . $variantData->first()['product_color_id']),
        'search_data' => [],
    ];
    $indexData['search_result_data'] = [
        'product_id'          => $productData['product_id'],
        "product_title"       => $productData['product_att_magento_display_name'],
        "product_slug"        => str_slug($productData['product_att_magento_display_name']),
        "product_style"       => $productData['product_style_no'],
        "product_description" => $productData['product_article_desc'],
        "product_color_id"    => $variantData->first()['product_color_id'],
        "product_color_slug"  => str_slug($variantData->first()['product_color_name']),
        "product_color_name"  => $variantData->first()['product_color_name'],
        "product_color_html"  => $variantData->first()['product_color_html'],
        "product_images"      => [],
        'variants'            => [],
    ];
    foreach ($variantData as $variant) {
        $indexData['search_result_data']['variants'][] = [
            "variant_id"         => $variant['variant_id'],
            "variant_list_price" => $variant['variant_lst_price'],
            "variant_sale_price" => $variant['variant_sale_price'],
            "variant_size_id"    => $variant['variant_size_id'],
            "variant_size_name"  => $variant['variant_size_name'],
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
                $search_data[$facet][] = [
                    'facet_name'  => $value,
                    'facet_value' => $productData[$value],
                ];
            }
            foreach (config('product.facets.' . $facet . '.variant') as $value) {
                $search_data[$facet][] = [
                    'facet_name'  => $value,
                    'facet_value' => $variant[$value],
                ];
            }
        }
        foreach (config('product.facets.attributes.product') as $value) {
            $search_data['attributes'][] = [
                'attribute_name'  => $value,
                'attribute_value' => $productData[$value],
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
