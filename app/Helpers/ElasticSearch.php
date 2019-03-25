<?php
use Ajency\Connections\ElasticQuery;
use App\ProductColor;

function getInventorySum(array $var)
{
    $total = 0;
    foreach ($var["inventory"] as $inventory) {
        $total += $inventory["store_qty"];
    }
    return $total;
}

function getUnSelectedVariants(int $product_id, int $selected_color_id)
{

    $q = new ElasticQuery();
    $q->setIndex(config("elastic.indexes.product"));

    $color_id_name    = $q::createTerm('search_data.number_facet.facet_name', "product_color_id");
    $color_id_value   = $q::createTerm('search_data.number_facet.facet_value', $selected_color_id);
    $product_id_name  = $q::createTerm('search_data.number_facet.facet_name', "product_id");
    $product_id_value = $q::createTerm('search_data.number_facet.facet_value', $product_id);

    $filterColor   = $q::addToBoolQuery('filter', [$color_id_name, $color_id_value]);
    $filterProduct = $q::addToBoolQuery('filter', [$product_id_name, $product_id_value]);
    $nested1       = $q::createNested('search_data.number_facet', $filterColor);
    $must_not      = $q->addToBoolQuery('must_not', [$nested1]);

    $nested1 = $q::createNested('search_data.number_facet', $filterProduct);
    $must    = $q->addToBoolQuery('must', [$nested1], $must_not);

    $nested2 = $q::createNested('search_data', $must);

    $q->setQuery($nested2)
        ->setSource(['search_result_data', 'variants']);
    $response = $q->search();

    $color_groups = [

    ];
    $facets             = array();
    $unique_facet_names = ['product_color_html'];
    foreach ($response["hits"]["hits"] as $key => $value) {
        $var = $value["_source"]["search_result_data"];
        foreach ($var as $facet_name => $facet_value) {
            if (in_array($facet_name, $unique_facet_names)) {
                array_push($facets, ['facet_name' => $facet_name, 'facet_value' => $facet_value]);
            }
        }
    }

    $facet_value_pairs = getFacetDetails($facets);

    foreach ($response["hits"]["hits"] as $key => $value) {
        $var = $value["_source"]["search_result_data"];
        foreach ($value["_source"]["variants"] as $variant) {
            $variant = [
                "id"                  => $variant["variant_id"],

                "inventory_available" => $variant["variant_availability"],

            ];
            $color_groups[$var["product_color_id"]]["variants"][] = $variant;
        }

        $color_groups[$var["product_color_id"]]["name"]      = $facet_value_pairs['product_color_html'][$var['product_color_html']]['display_name'];
        $color_groups[$var["product_color_id"]]["html"]      = $var["product_color_html"];
        $color_groups[$var["product_color_id"]]["slug_name"] = $var["product_slug"];
        $productColor                                        = ProductColor::where([["product_id", $product_id], ["color_id", $var["product_color_id"]]])->first();
        $thumbs                                              = $productColor->getDefaultImage(["variant-thumb"]);
        $color_groups[$var["product_color_id"]]["images"]    = (isset($thumbs["variant-thumb"])) ? $thumbs["variant-thumb"] : [];
        $variants[]                                          = $variant;

    }
    return $color_groups;
}

function sortSizes($variant_a, $variant_b)
{
    return ($variant_a['sequence'] > $variant_b['sequence']) ? 1 : 0;
}

function fetchProduct($product)
{

    $product            = $product["_source"];
    $variants           = [];
    $unique_facet_names = ['product_category_type', 'product_gender', 'product_age_group', 'product_subtype', 'product_color_html', 'variant_size_name', 'product_brand'];
    $facets             = array();
    foreach ($product['search_result_data'] as $facet_name => $facet_value) {
        if (in_array($facet_name, $unique_facet_names)) {
            array_push($facets, ['facet_name' => $facet_name, 'facet_value' => $facet_value]);
        }
    }
    foreach ($product['variants'] as $key => $variants) {
        foreach ($variants as $variant_name => $variant_value) {
            if (in_array($variant_name, $unique_facet_names)) {
                array_push($facets, ['facet_name' => $variant_name, 'facet_value' => $variant_value]);
            }
        }
    }
    foreach ($product['search_result_data']["product_metatag"] as $facet_value) {
        array_push($facets, ['facet_name' => 'product_metatag', 'facet_value' => $facet_value]);
    }
    $variants = [];

    $facet_value_pairs = getFacetDetails($facets);
    $id                = defaultVariant($product['variants']);
    $size_facet_values = $facet_value_pairs['variant_size_name'];
    foreach ($product["variants"] as $key => $variant) {
        if (isset($size_facet_values[$variant["variant_size_name"]])) {
            $product["variants"][$key]["display_name"] = $size_facet_values[$variant["variant_size_name"]]["display_name"];
            $product["variants"][$key]["slug"]         = $size_facet_values[$variant["variant_size_name"]]["slug"];
            $product["variants"][$key]["sequence"]     = $size_facet_values[$variant["variant_size_name"]]["sequence"];
        } else {
            $product["variants"][$key]["display_name"] = $variant["variant_size_name"];
            $product["variants"][$key]["slug"]         = str_slug($variant["variant_size_name"]);
            $product["variants"][$key]["sequence"]     = 10000;
        }
    }
    usort($product["variants"], "sortSizes");
    foreach ($product["variants"] as $key => $variant) {
        $variants[] = [
            "id"                  => $variant["variant_id"],
            "list_price"          => $variant["variant_list_price"],
            "sale_price"          => $variant["variant_sale_price"],
            "discount_per"        => calculateDiscount($variant["variant_list_price"], $variant["variant_sale_price"]),
            "is_default"          => ($id == $variant["variant_id"]),
            "size"                => [
                "id"           => $variant["variant_size_id"],
                "name"         => $variant["variant_size_name"],
                "display_name" => $variant["display_name"],
                "slug"         => $variant["slug"],
                "sequence"     => $variant["sequence"],
            ],
            "inventory_available" => $variant["variant_availability"],

        ];
    }

    $data                       = $product["search_result_data"];
    $product_brand_display_name = $facet_value_pairs['product_brand'][$data['product_brand']]['display_name'];
    $selected_color_id          = $data["product_color_id"];
    $productColor               = ProductColor::where([["product_id", $data["product_id"]], ["color_id", $selected_color_id]])->first();
    $allImages                  = $productColor->getAllImages(["main", "thumb", "zoom"]);
    $thumbImages                = $productColor->getDefaultImage(["variant-thumb"]);

    $product_metatags = array();
    foreach ($facet_value_pairs['product_metatag'] as $product_metatag) {
        array_push($product_metatags, ["name" => $product_metatag['display_name'], "href" => createUrl('list', ['shop'], ["pf" => ['tag' => [$product_metatag['slug']]]])]);
    }
    $json = [
        "parent_id"         => $data["product_id"],
        "title"             => $data["product_title"],
        "slug_name"         => $data["product_slug"],
        "category"          => [
            "product_gender"        => $data["product_gender"],
            "product_category_type" => $data["product_category_type"],
            "product_age_group"     => $data["product_age_group"],
            "product_subtype"       => $data["product_subtype"],
        ],
        "description"       => $data["product_description"],
        "metatags"          => $product_metatags,
        "additional_info"   => [
            "product_age_group" => $facet_value_pairs['product_age_group'][$data['product_age_group']]['display_name'],
            "product_gender"    => $facet_value_pairs['product_gender'][$data['product_gender']]['display_name'],
            "material"          => $data["product_att_material"],
            "sleeves"           => $data["product_att_sleeves"],
            "occasion"          => $data["product_att_occasion"],
            "wash"              => $data["product_att_wash"],
            "fabric_type"       => $data["product_att_fabric_type"],
            "product_type"      => $data["product_att_product_type"],
            "other_attribute"   => $data["product_att_other_attribute"],
            "brand"             => $product_brand_display_name,
        ],
        "ecom_sales"        => $data["product_att_ecom_sales"],
        "brand"             => ["name" => $product_brand_display_name, "href" => $facet_value_pairs['product_brand'][$data['product_brand']]['slug']],
        "selected_color_id" => $selected_color_id,
        "images"            => $allImages,
        "variant_group"     => [
            $selected_color_id => [
                "name"      => $facet_value_pairs['product_color_html'][$data['product_color_html']]['display_name'], //$data["product_color_name"],
                "html"      => $data["product_color_html"],
                "slug_name" => $facet_value_pairs['product_color_html'][$data['product_color_html']]['slug'],
                "images"    => (isset($thumbImages["variant-thumb"])) ? $thumbImages["variant-thumb"] : [],
                "variants"  => $variants,
            ],

        ],
    ];
    $json["variant_group"]     = $json["variant_group"] + getUnSelectedVariants($data["product_id"], $selected_color_id);
    $json["facet_value_pairs"] = $facet_value_pairs;

    ksort($json["variant_group"]);
    return json_encode($json, true);

}

function singleproduct(string $product_slug)
{

    $q = new ElasticQuery();
    $q->setIndex(config("elastic.indexes.product"));

    $facetName  = $q::createTerm('search_data.string_facet.facet_name', "product_slug");
    $facetValue = $q::createTerm('search_data.string_facet.facet_value', $product_slug);
    $filter     = $q::addFilterToQuery([$facetName, $facetValue]);
    $nested1    = $q::createNested('search_data.string_facet', $filter);
    $nested2    = $q::createNested('search_data', $nested1);
    $q->setQuery($nested2)
        ->setSource(['search_result_data', 'variants']);

    $products = $q->search();
    try {
        $product = $products["hits"]["hits"][0];
    } catch (Exception $e) {
        abort(404);
    }

    return fetchProduct($product);

}

function singleProductAPI(string $product_color)
{
    $q = new ElasticQuery();
    $q->setIndex(config("elastic.indexes.product"));

    try {
        $product = $q->get($product_color, ['search_result_data', 'variants']);
    } catch (Exception $e) {
        abort(404);
    }

    return fetchProduct($product);
}
