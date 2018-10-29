<?php

use App\Facet;
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

function makeQueryfromParams($params)
{
    $queryParams    = [];
    $elasticMapping = [
        'product_category_type' => 'search_data.string_facet.product_category_type',
        'product_gender'        => 'search_data.string_facet.product_gender',
        'product_age_group'     => 'search_data.string_facet.product_age_group',
        'product_subtype'       => 'search_data.string_facet.product_subtype',
    ];
    foreach ($elasticMapping as $param => $map) {
        if (array_has($params, $param)) {
            $categ = $params[$param];
            if (gettype($categ) != 'array') {
                $categ = [$categ];
            }

            if (array_search('all', $categ) === false) {
                array_set($queryParams, $map, $categ);
            }
        }
    }
    return $queryParams;
}

function fetchUserFromToken($token)
{
    $token = explode('Bearer ', $token)[1];
    $user  = User::where('api_token', $token)->first();
    return $user->id;
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

function sanitiseVariantData($odooData, $attributeData, $inventoryData)
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
        $variantData['product_color_id']   = 0;
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
    $indexData['search_result_data'] = [
        'product_id'            => $productData['product_id'],
        "product_title"         => $productData['product_att_magento_display_name'],
        "product_slug"          => $productData['product_slug'],
        "product_style"         => $productData['product_style_no'],
        "product_description"   => $productData['product_article_desc'],
        "product_att_sleeves"   => $productData['product_att_sleeves'],
        "product_att_material"  => $productData['product_att_material'],
        "product_category_type" => $productData['product_category_type'],
        "product_gender"        => $productData['product_gender'],
        "product_age_group"     => $productData['product_age_group'],
        "product_subtype"       => $productData['product_subtype'],
        "product_color_id"      => $variantData->first()['product_color_id'],
        "product_color_slug"    => str_slug($variantData->first()['product_color_name']),
        "product_color_name"    => $variantData->first()['product_color_name'],
        "product_color_html"    => $variantData->first()['product_color_html'],
        "product_images"        => [],
    ];
    $indexData["variants"] = [];
    foreach ($variantData as $variant) {
        $indexData['variants'][] = [
            "variant_id"           => $variant['variant_id'],
            "variant_list_price"   => $variant['variant_lst_price'],
            "variant_sale_price"   => $variant['variant_sale_price'],
            "variant_size_id"      => $variant['variant_size_id'],
            "variant_size_name"    => $variant['variant_size_name'],
            "variant_availability" => $variant['variant_availability'],
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
            $temp = [
                "warehouse" => $invtry["warehouse_id"][1],
                "quantity"  => intval($invtry["quantity"]),
            ];
            $inventory[$invtry["product_id"][0]]["inventory"][] = $temp;
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

function generateVariantImageName($product_name, $color_name, $colors,$index)
{
    $colors_count = (count($colors)>0)?array_count_values($colors):0;
    \Log::debug("colors count===");
    \Log::debug($colors_count);
    $append = "";
    if ($colors_count["$color_name"] > 1) {
        $append = ($index+1);
    }

    $image_name   = $product_name . "-" . $color_name . $append;
    $image_name = str_slug(implode(' ',[$product_name,$color_name,$append]));
    return $image_name;

}

function sanitiseFilterdata($result, $params = [])
{
    $filterResponse = [];
    foreach ($result["aggregations"]["agg_string_facet"]["facet_name"]["buckets"] as $facet_name) {
        $filterResponse[$facet_name["key"]] = [];
        foreach ($facet_name["facet_value"]["buckets"] as $value) {
            $filterResponse[$facet_name["key"]][$value["key"]] = $value["count"]["doc_count"];
        }
    }
    $response = [];
    foreach ($filterResponse as $facetName => $facetValues) {
        $filter           = [];
        $facets           = Facet::where('facet_name', $facetName)->get();
        $filter['header'] = [
            'facet_name'   => $facetName,
            'display_name' => config('product.facet_display_data.' . $facetName . '.name'),
        ];
        $filter['items'] = [];
        foreach ($facets as $facet) {
            $filter['items'][] = [
                'facet_value'  => $facet->facet_value,
                'display_name' => $facet->display_name,
                'slug'         => $facet->slug,
                'is_selected'  => (array_search($facet->facet_value, array_collapse($params)) === false) ? false : true,
                'sequence'     => $facet->sequence,
                'count'        => (isset($facetValues[$facet->facet_value])) ? $facetValues[$facet->facet_value] : 0,
            ];
        }
        $attributes = ['is_singleton', 'is_collapsed', 'template', 'order'];
        foreach ($attributes as $attribute) {
            $filter[$attribute] = config('product.facet_display_data.' . $facetName . '.' . $attribute);
        }
        $response[] = $filter;
    }
    $response["items"] = formatItems($result);
    return $response;
}

function formatItems($result){
    $items = [];
    foreach ($result['hits']['hits'] as  $doc) {
        $productColor      = ProductColor::where([["elastic_id", $doc["_id"]]])->first();
        $product = $doc["_source"];
        $data = $product["search_result_data"];

        $item = [
            "title" => $data["product_title"],
            "slug_name" => $data["product_slug"],
            "description" => $data["product_description"],
            "images" => $productColor->getDefaultImage(["list-view"]),
            "variants" => [],
            "product_id" => $data["product_id"],
            "color_id" => $data['product_color_id'],
            "color_name" => $data['product_color_name'],
            "color_html" => $data['product_color_html'],
        ];

        // find default product by max sale price
        $id         = $product["variants"][0]["variant_id"];
        $sale_price = $product["variants"][0]["variant_sale_price"];
        foreach ($product["variants"] as $variant) {
            if ($sale_price < $variant["variant_sale_price"]) {
                $id         = $variant["variant_id"];
                $sale_price = $variant["variant_sale_price"];
            }
        }
        foreach ($product["variants"] as $variant) {
            $item["variants"][] = [
                "list_price" => $variant["variant_list_price"],
                "sale_price" => $variant["variant_sale_price"],
                "is_default" => ($id == $variant["variant_id"]),
                "size" => [
                    "size_id" => $variant["variant_size_id"],
                    "size_name" => $variant["variant_size_name"],
                ],
                "inventory_available" => $variant["variant_availability"],
            ];
        }
        $items[] = $item;
    }
    return $items;
}