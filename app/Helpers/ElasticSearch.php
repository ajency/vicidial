<?php
use Elasticsearch\ClientBuilder;
use App\Elastic\ElasticQuery;
use App\Product;

function getInventorySum(array $var){
        $total = 0;
        foreach ($var["inventory"] as $inventory) {
            $total +=$inventory["store_qty"];
        }
        return $total;
}

function getUnSelectedVariants(int $product_id=1636, int $selected_color_id=231){
        $client = ClientBuilder::create()->build();

        $elastic = new ElasticQuery;
        $elastic->setIndex("products");
        $parent_id = ElasticQuery::createTerm('parent_id', $product_id);
        $type = ElasticQuery::createTerm('type', "variant");
        $var_color_id = ElasticQuery::createTerm('var_color_id', $selected_color_id);

        $elastic->appendMust($parent_id)
        ->appendMust($type)
        ->appendMustNot($var_color_id)
        ->setSize(100);
        Log::debug(json_encode($elastic->getParams()["body"], true));
        $response = $elastic->search();
        
        $color_groups = [

        ];
        
        foreach ($response["hits"]["hits"] as $key => $value) {
            // $variants[$value["_id"]] = $value["_source"];
            $var = $value["_source"];
            
            
            $variant = [
                "id" => $var["id"],
                "inventory_available" => (getInventorySum($var) > 0) ? true :false,

            ];
            $color_groups[$var["var_color_id"]]["variants"][] = $variant;
            $color_groups[$var["var_color_id"]]["name"] = $var["var_color_value"];
            $color_groups[$var["var_color_id"]]["html"] = $var["var_color_html"];
            $color_groups[$var["var_color_id"]]["slug_color"] = $var["slug_color"];
            $color_groups[$var["var_color_id"]]["images"] = json_decode('[{"is_primary":true,"res":{"desktop":{"small_thumb":"/img/thumbnail/3front@thumb.jpg"},"mobile":{"small_thumb":"/img/thumbnail/3front@thumb.jpg"}}}]', true);
            $variants[] = $variant;

        }
        // print_r($color_groups);die();
        // $color_groups = [
        //     "name" => "Blue",
        //     "html" => "#0000FF",
        //     "images" => json_decode('[{"is_primary":true,"res":{"desktop":{"small_thumb":"/img/thumbnail/3front@thumb.jpg"},"mobile":{"small_thumb":"/img/thumbnail/3front@thumb.jpg"}}}]', true),
        //     "variants" => $variants,

        // ];
        return $color_groups;
    }


function fetchProduct($product){
    
    $product = $product["_source"];
    $variants = [];
    $id = $product["variants"][0]["variant_id"];
    $sale_price = $product["variants"][0]["variant_sale_price"];
    foreach ($product["variants"] as $key => $variant) {
        if($sale_price < $variant["variant_sale_price"]){
            $id = $variant["variant_id"];
            $sale_price = $variant["variant_sale_price"];
          }
      }
    foreach ($product["variants"] as $key => $variant) {
        $variants [] = [
            "id" => $variant["variant_id"],
            "list_price" => $variant["variant_list_price"],
            "sale_price" => $variant["variant_sale_price"],
            "is_default" => ($id == $variant["variant_id"]),
            "size" => [
                "id" => $variant["variant_size_id"],
                "name" => $variant["variant_size_name"],
            ],
            "inventory_available" => Product::getVariantAvailability($product, $variant["variant_id"]),
            "inventory" => [],

        ];
    }
    
    $data = $product["search_result_data"];
    $selected_color_id = $data["product_color_id"];
    $json = [
        "parent_id" => $data["product_id"],
        "title" => $data["product_title"],
        "slug_name" => $data["product_slug"],
        // "slug_style" => $data["product_style"],
        "category" => [
            // "id" => $product["categ_id"],
            "gender" =>  $data["product_gender"],
            "type" => $data["product_category_type"],
            "age_group" => $data["product_age_group"],
            "sub_type" => $data["product_subtype"],
        ],
        "description" => $data["product_description"],
        "additional_info" => [
            "age_group" => $data["product_age_group"],
            "gender" => $data["product_gender"],
            "material" => $data["product_att_material"],
            "sleeves" => $data["product_att_sleeves"],
        ],
        "selected_color_id" => $selected_color_id,
        "variant_group" => [
             $selected_color_id => [
                "name" => $data["product_color_name"],
                "html" => $data["product_color_html"],
                "slug_color" =>  $data["product_color_slug"],
                "images" => json_decode('[{"is_primary":true,"res":{"desktop":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"},"mobile":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"}}},{"is_primary":false,"res":{"desktop":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"},"mobile":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"}}}]', true),
                "variants" => $variants,
             ]

        ],
    ];

    // $json["variant_group"] = $json["variant_group"]+ getUnSelectedVariants(intval($product["id"],$selected_color_id);
    // Log::debug(json_encode($json, true));
    return json_encode($json, true);
    
}

function singleproduct(string $product_slug) {
    $json = '{"query":{"nested":{"path":"search_data","query":{"bool":{"must":[{"nested":{"path":"search_data.string_facet","query":{"bool":{"filter":[{"term":{"search_data.string_facet.facet_name":"product_slug"}},{"term":{"search_data.string_facet.facet_value":"'.$product_slug.'"}}]}}}}]}}}}}
';
    // print_r($json);die();
    $body = json_decode($json, true);
    // echo "<pre>";
    // print_r($body);die();
    $client = ClientBuilder::create()->build();
        $products = $client->search(["index" => "new_products", "body"=>$body]);
        $product = $products["hits"]["hits"][0];
    return fetchProduct($product);
    // return '{"parent_id":234,"title":"BM Face Casual Graphic Boys Tshirt","slug_name":"bm-face-casual","slug_style":"bm-face","category":{"id":56,"type":"Clothing","gender":"Boys","age_group":"Toddler","sub_type":"Tshirt"},"description":"Casual fancy tshirt for toddlers","additional_info":{"gender":"Boys","material":"Cotton","sleeves":"Half Sleeves"},"selected_color_id":30,"variant_group":{"23":{"name":"Blue","html":"#0000FF","slug_color":"blue","images":[{"is_primary":true,"res":{"desktop":{"small_thumb":"/img/thumbnail/3front@thumb.jpg"},"mobile":{"small_thumb":"/img/thumbnail/3front@thumb.jpg"}}}],"variants":[{"id":4735,"inventory_available":true},{"id":4736,"inventory_available":true},{"id":4737,"inventory_available":false}]},"30":{"name":"Green","html":"#008000","slug_color":"green","images":[{"is_primary":true,"res":{"desktop":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"},"mobile":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"}}},{"is_primary":false,"res":{"desktop":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"},"mobile":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"}}}],"variants":[{"id":4535,"list_price":1309,"sale_price":890,"is_default":true,"size":{"id":25,"name":"2-4Y"},"inventory_available":true,"inventory":[{"store":{"id":345,"name":"Surat Store","address":{"id":34,"location":"Surat road"}},"count":0},{"store":{"id":345,"name":"Coimbatore Store","address":{"id":39,"location":"C road"}},"count":2}]},{"id":4536,"list_price":1409,"sale_price":895,"is_default":false,"size":{"id":26,"name":"4-6Y"},"inventory_available":true,"inventory":[{"store":{"id":345,"name":"Surat Store","address":{"id":34,"location":"Surat road"}},"count":2},{"store":{"id":345,"name":"Coimbatore Store","address":{"id":39,"location":"C road"}},"count":3}]},{"id":4537,"list_price":1509,"sale_price":900,"is_default":false,"size":{"id":23,"name":"6-8Y"},"inventory_available":false,"inventory":[{"store":{"id":345,"name":"Surat Store","address":{"id":34,"location":"Surat road"}},"count":0}]}]}}}';
}

function listingproducts($search_object) {
    return '{"results_found":true,"sort_on":[{"name":"Latest Products","value":"latest","is_selected":false},{"name":"Popularity","value":"popular","is_selected":true},{"name":"Price Low to High","value":"price_asc","is_selected":false},{"name":"Price High to Low","value":"price_dsc","is_selected":false},{"name":"Discount Low to High","value":"discount_asc","is_selected":false},{"name":"Discount High to Low","value":"discount_dsc","is_selected":false}],"page":{"current":2,"total":885,"has_previous":true,"has_next":true,"total_item_count":17697},"filters":[],"search":{"params":{"genders":["men"],"l1_categories":["clothing"]},"pattern":[{"key":"genders","slugs":["men"]},{"key":"l1_categories","slugs":["clothing"]}],"is_valid":true,"domain":"https://newsite.stage.kidsuperstore.in","type":"product-list","query":{"page":["2"],"page_size":["20"]}},"items":[{"title":"BM Face Casual Graphic Boys Tshirt","slug_name":"boys-round-neck-tshirt-with-contrast-rib-and-chest-print","slug_style":"ts1903","description":"Casual fancy tshirt for toddlers","slug_color":"gold","images":{"desktop":{"one_x":"/img/normal/bluefront@1x.jpg","two_x":"/img/normal/bluefront@2x.jpg"},"mobile":{"one_x":"/img/normal/bluefront@1x.jpg","two_x":"/img/normal/bluefront@2x.jpg"}},"variants":[{"list_price":1309,"sale_price":890,"is_default":true,"size":{"size_id":25,"size_name":"2-4Y"},"inventory_available":true,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":0},{"store":{"address":{"location_id":39,"location_name":"C road"},"store_id":345,"store_name":"Coimbatore Store"},"inventory_count":2}],"variant_id":4535},{"list_price":1409,"sale_price":895,"is_default":false,"size":{"size_id":26,"size_name":"4-6Y"},"inventory_available":true,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":2},{"store":{"address":{"location_id":39,"location_name":"C road"},"store_id":345,"store_name":"Coimbatore Store"},"inventory_count":3}],"variant_id":4536},{"list_price":1509,"sale_price":900,"is_default":false,"size":{"size_id":23,"size_name":"6-8Y"},"inventory_available":false,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":0}],"variant_id":4537}],"product_id":234,"color_id":30,"color_name":"Gold","color_html":"#FFDF00"},{"title":"Yellow Casual Graphic Boys Tshirt","slug_name":"fixed-waist-with-adjustable-elastic-od-woven-short","slug_style":"upgt180901-ca-1026","description":"Casual fancy tshirt for toddlers","slug_color":"yellow","images":{"desktop":{"one_x":"/img/normal/orangefront@1x.jpg","two_x":"/img/normal/orangefront@2x.jpg"},"mobile":{"one_x":"/img/normal/orangefront@1x.jpg","two_x":"/img/normal/orangefront@2x.jpg"}},"variants":[{"list_price":1309,"sale_price":890,"is_default":true,"size":{"size_id":25,"size_name":"2-4Y"},"inventory_available":true,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":0},{"store":{"address":{"location_id":39,"location_name":"C road"},"store_id":345,"store_name":"Coimbatore Store"},"inventory_count":2}],"variant_id":5535},{"list_price":1409,"sale_price":895,"is_default":false,"size":{"size_id":26,"size_name":"4-6Y"},"inventory_available":false,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":0},{"store":{"address":{"location_id":39,"location_name":"C road"},"store_id":345,"store_name":"Coimbatore Store"},"inventory_count":0}],"variant_id":5536},{"list_price":1509,"sale_price":900,"is_default":false,"size":{"size_id":23,"size_name":"6-8Y"},"inventory_available":true,"inventory":[{"store":{"address":{"location_id":34,"location_name":"Surat road"},"store_id":345,"store_name":"Surat Store"},"inventory_count":1}],"variant_id":5537}],"product_id":233,"color_id":31,"color_name":"Yellow","color_html":"#FFFF00"}],"breadcrumbs":[{"name":"Home","action":{"type":"home","query":{}}},{"name":"Men","action":{"type":"product-list","query":{"genders":["men"]}}},{"name":"Clothing","action":{"type":"product-list","query":{"genders":["men"],"l1_categories":["clothing"]}}}],"headers":{"page_title":"Clothing","product_count":17697}}';
}

