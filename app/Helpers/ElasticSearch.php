<?php
use App\Elastic\ElasticQuery;
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

    foreach ($response["hits"]["hits"] as $key => $value) {
        // $variants[$value["_id"]] = $value["_source"];
        $var = $value["_source"]["search_result_data"];

        foreach ($value["_source"]["variants"] as $variant) {

            $variant = [
                "id"                  => $variant["variant_id"],

                "inventory_available" => $variant["variant_availability"],

            ];
            $color_groups[$var["product_color_id"]]["variants"][] = $variant;
        }

        $color_groups[$var["product_color_id"]]["name"]      = $var["product_color_name"];
        $color_groups[$var["product_color_id"]]["html"]      = $var["product_color_html"];
        $color_groups[$var["product_color_id"]]["slug_name"] = $var["product_slug"];
        $productColor                                        = ProductColor::where([["product_id", $product_id], ["color_id", $var["product_color_id"]]])->first();
        $thumbs                                              = $productColor->getDefaultImage(["variant-thumb"]);
        $color_groups[$var["product_color_id"]]["images"]    = (isset($thumbs["variant-thumb"])) ? $thumbs["variant-thumb"] : [];
        $variants[]                                          = $variant;

    }

    return $color_groups;
}

function fetchProduct($product)
{

    $product    = $product["_source"];
    $variants   = [];
    $id         = $product["variants"][0]["variant_id"];
    $sale_price = $product["variants"][0]["variant_sale_price"];
    foreach ($product["variants"] as $key => $variant) {
        if ($sale_price < $variant["variant_sale_price"]) {
            $id         = $variant["variant_id"];
            $sale_price = $variant["variant_sale_price"];
        }
    }
    foreach ($product["variants"] as $key => $variant) {
        $variants[] = [
            "id"                  => $variant["variant_id"],
            "list_price"          => $variant["variant_list_price"],
            "sale_price"          => $variant["variant_sale_price"],
            "is_default"          => ($id == $variant["variant_id"]),
            "size"                => [
                "id"   => $variant["variant_size_id"],
                "name" => $variant["variant_size_name"],
            ],
            "inventory_available" => $variant["variant_availability"],

        ];
    }

    $data              = $product["search_result_data"];
    $selected_color_id = $data["product_color_id"];
    $productColor      = ProductColor::where([["product_id", $data["product_id"]], ["color_id", $selected_color_id]])->first();
    $allImages         = $productColor->getAllImages(["main", "thumb", "zoom"]);
    $thumbImages       = $productColor->getDefaultImage(["variant-thumb"]);
    $json              = [
        "parent_id"         => $data["product_id"],
        "title"             => $data["product_title"],
        "slug_name"         => $data["product_slug"],
        "category"          => [
            "gender"    => $data["product_gender"],
            "type"      => $data["product_category_type"],
            "age_group" => $data["product_age_group"],
            "sub_type"  => $data["product_subtype"],
        ],
        "description"       => $data["product_description"],
        "additional_info"   => [
            "age_group"       => $data["product_age_group"],
            "gender"          => $data["product_gender"],
            "material"        => $data["product_att_material"],
            "sleeves"         => $data["product_att_sleeves"],
            "occasion"        => $data["product_att_occasion"],
            "wash"            => $data["product_att_wash"],
            "fabric_type"     => $data["product_att_fabric_type"],
            "product_type"    => $data["product_att_product_type"],
            "other_attribute" => $data["product_att_other_attribute"],
        ],
        "selected_color_id" => $selected_color_id,
        "images"            => $allImages,
        "variant_group"     => [
            $selected_color_id => [
                "name"      => $data["product_color_name"],
                "html"      => $data["product_color_html"],
                "slug_name" => $data["product_slug"],
                "images"    => (isset($thumbImages["variant-thumb"])) ? $thumbImages["variant-thumb"] : [],
                "variants"  => $variants,
            ],

        ],
    ];

    $json["variant_group"] = $json["variant_group"] + getUnSelectedVariants($data["product_id"], $selected_color_id);
    // Log::debug(json_encode($json, true));
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
    $product  = $products["hits"]["hits"][0];
    return fetchProduct($product);

}

function listingproducts($search_object)
{
    return '{"results_found":true,"sort_on":[{"name":"Latest Products","value":"latest","is_selected":false},{"name":"Popularity","value":"popular","is_selected":true},{"name":"Price Low to High","value":"price_asc","is_selected":false},{"name":"Price High to Low","value":"price_dsc","is_selected":false},{"name":"Discount Low to High","value":"discount_asc","is_selected":false},{"name":"Discount High to Low","value":"discount_dsc","is_selected":false}],"page":{"current":2,"total":885,"has_previous":true,"has_next":true,"total_item_count":17697},"filters":[],"search":{"params":{"genders":["men"],"l1_categories":["clothing"]},"pattern":[{"key":"genders","slugs":["men"]},{"key":"l1_categories","slugs":["clothing"]}],"is_valid":true,"domain":"https://newsite.stage.kidsuperstore.in","type":"product-list","query":{"page":["2"],"page_size":["20"]}},"items":[{"title":"BM Face Casual Graphic Boys Tshirt","slug_name":"boys-round-neck-tshirt-with-contrast-rib-and-chest-print","slug_style":"ts1903","description":"Casual fancy tshirt for toddlers","slug_color":"gold","images":{"desktop":{"one_x":"/img/normal/bluefront@1x.jpg","two_x":"/img/normal/bluefront@2x.jpg"},"mobile":{"one_x":"/img/normal/bluefront@1x.jpg","two_x":"/img/normal/bluefront@2x.jpg"}},"variants":[{"list_price":1309,"sale_price":890,"is_default":true,"size":{"size_id":25,"size_name":"2-4Y"},"inventory_available":true,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":0},{"store":{"address":{"location_id":39,"location_name":"C road"},"store_id":345,"store_name":"Coimbatore Store"},"inventory_count":2}],"variant_id":4535},{"list_price":1409,"sale_price":895,"is_default":false,"size":{"size_id":26,"size_name":"4-6Y"},"inventory_available":true,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":2},{"store":{"address":{"location_id":39,"location_name":"C road"},"store_id":345,"store_name":"Coimbatore Store"},"inventory_count":3}],"variant_id":4536},{"list_price":1509,"sale_price":900,"is_default":false,"size":{"size_id":23,"size_name":"6-8Y"},"inventory_available":false,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":0}],"variant_id":4537}],"product_id":234,"color_id":30,"color_name":"Gold","color_html":"#FFDF00"},{"title":"Yellow Casual Graphic Boys Tshirt","slug_name":"fixed-waist-with-adjustable-elastic-od-woven-short","slug_style":"upgt180901-ca-1026","description":"Casual fancy tshirt for toddlers","slug_color":"yellow","images":{"desktop":{"one_x":"/img/normal/orangefront@1x.jpg","two_x":"/img/normal/orangefront@2x.jpg"},"mobile":{"one_x":"/img/normal/orangefront@1x.jpg","two_x":"/img/normal/orangefront@2x.jpg"}},"variants":[{"list_price":1309,"sale_price":890,"is_default":true,"size":{"size_id":25,"size_name":"2-4Y"},"inventory_available":true,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":0},{"store":{"address":{"location_id":39,"location_name":"C road"},"store_id":345,"store_name":"Coimbatore Store"},"inventory_count":2}],"variant_id":5535},{"list_price":1409,"sale_price":895,"is_default":false,"size":{"size_id":26,"size_name":"4-6Y"},"inventory_available":false,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":0},{"store":{"address":{"location_id":39,"location_name":"C road"},"store_id":345,"store_name":"Coimbatore Store"},"inventory_count":0}],"variant_id":5536},{"list_price":1509,"sale_price":900,"is_default":false,"size":{"size_id":23,"size_name":"6-8Y"},"inventory_available":true,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":1}],"variant_id":5537}],"product_id":233,"color_id":31,"color_name":"Yellow","color_html":"#FFFF00"}],"breadcrumbs":[{"name":"Home","action":{"type":"home","query":{}}},{"name":"Men","action":{"type":"product-list","query":{"genders":["men"]}}},{"name":"Clothing","action":{"type":"product-list","query":{"genders":["men"],"l1_categories":["clothing"]}}}],"headers":{"page_title":"Clothing","product_count":17697}}';
}
