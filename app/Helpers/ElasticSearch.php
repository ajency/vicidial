<?php
use Elasticsearch\ClientBuilder;

function getInventorySum(array $var){
        $total = 0;
        foreach ($var["inventory"] as $inventory) {
            $total +=$inventory["store_qty"];
        }
        return $total;
}

function getUnSelectedVariants(int $product_id=1636, int $selected_color_id=231){
        $client = ClientBuilder::create()->build();
        // $this->client->search()
        $params = [
            'index' => 'products',
            'type' => '_doc',
            'id' => $product_id,
        ];
        $product = $client->get($params);
        $params = [
            "index" => "products",
            "body" => [
                "query" => [
                    "bool" => [
                        "must" => [
                            [
                                "term" => [
                                    "parent_id" => $product_id,
                                ]
                            ],
                            [
                                "term" => [
                                    "type" => "variant",
                                ]
                            ],
                            
                        ],
                        "must_not" => [
                            [
                                "term" => [
                                    "var_color_id" => $selected_color_id,
                                ]
                            ],
                        ]
                    ]
                ]
            ],
            "size" => 100
        ];
        // echo "<pre>";
        // print_r($params);
        $response = $client->search($params);
        // print_r($response);
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


function fetchProduct(int $product_id, int $selected_color_id){
    $client = ClientBuilder::create()->build();

    $params = [
        'index' => 'products',
        'type' => '_doc',
        'id' => $product_id,
    ];
    $product = $client->get($params);
    $params = [
        "index" => "products",
        "body" => [
            "query" => [
                "bool" => [
                    "must" => [
                        [
                            "term" => [
                                "parent_id" => $product_id,
                            ]
                        ],
                        [
                            "term" => [
                                "type" => "variant",
                            ]
                        ],
                        [
                            "term" => [
                                "var_color_id" => $selected_color_id,
                            ]
                        ],
                    ]
                ]
            ]
        ]
    ];
    $response = $client->search($params);
    $id = $response["hits"]["hits"][0]["_source"]["id"];
    $sale_price = $response["hits"]["hits"][0]["_source"]["sale_price"];
    foreach ($response["hits"]["hits"] as $key => $value) {
      if($sale_price < $value["_source"]["sale_price"]){
      	$id = $value["_source"]["id"];
      	$sale_price = $value["_source"]["sale_price"];
      }
    }
    foreach ($response["hits"]["hits"] as $key => $value) {
        // $variants[$value["_id"]] = $value["_source"];
        $var = $value["_source"];
        
        
        $variant = [
            "id" => $var["id"],
            "list_price" => $var["lst_price"],
            "sale_price" => $var["sale_price"],
            "is_default" => ($id == $var["id"]),
            "size" => [
                "id" => $var["var_size_id"],
                "name" => $var["var_size_value"],
            ],
            "inventory_available" => (getInventorySum($var) > 0) ? true :false,
            "inventory" => $var["inventory"],

        ];
        $variants[] = $variant;
    }
    Log::debug(json_encode($variants, true));
    $product = $product["_source"];
    $json = [
        "parent_id" => $product["id"],
        "title" => $product["att_magento_display_name"],
        "slug_name" => $product["slug_name"],
        "slug_style" => $product["slug_style"],
        "category" => [
            "id" => $product["categ_id"],
            "gender" => $product["gender"],
            "type" => $product["category_type"],
            "age_group" => $product["age_group"],
            "sub_type" => $product["subtype"],
        ],
        "description" => "Incomplete",
        "additional_info" => [
            "age_group" => $product["age_group"],
            "gender" => $product["gender"],
            "material" => "incomplete",
            "sleeves" => "incomplete",
        ],
        "selected_color_id" => $selected_color_id,
        "variant_group" => [
             $selected_color_id => [
                "name" => $var["var_color_value"],
                "html" => $var["var_color_html"],
                "slug_color" => $var["slug_color"],
                "images" => json_decode('[{"is_primary":true,"res":{"desktop":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"},"mobile":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"}}},{"is_primary":false,"res":{"desktop":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"},"mobile":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"}}}]', true),
                "variants" => $variants,

             ]

        ],
    ];
    // foreach ($this->getUnSelectedVariants($product_id, $selected_color_id)) as $key => $value) {
    //     $json["variant_group"][]
    // }
    $json["variant_group"] = $json["variant_group"]+ getUnSelectedVariants($product_id, $selected_color_id);
    Log::debug(json_encode($json, true));
    return json_encode($json, true);
    
}

function singleproduct(string $product_slug, string $style_slug, string $color_slug) {
    // $client = ClientBuilder::create()->build();
    // $params = [
    //     'index' => 'products',
    //     "body" => [
    //         "query" =>[
    //             "bool" => [
    //                 "must" => [
    //                     [
    //                         "term" => [
    //                             "slug_name" => $product_slug,
    //                         ]
    //                     ],
    //                     [
    //                         "term" => [
    //                             "slug_style" => $style_slug,
    //                         ]
    //                     ],
    //                 ],
                    
    //             ]
    //         ]
    //     ]
    // ];
    // $product = $client->search($params);
    // $product = $product['hits']['hits'][0]['_source'];

    // $params = [
    //     "index" => "products",
    //     "body" => [
    //         "query" => [
    //             "bool" => [
    //                 "must" => [
    //                     [
    //                         "term" => [
    //                             "parent_id" => $product["id"],
    //                         ]
    //                     ],
    //                     [
    //                         "term" => [
    //                             "slug_color" => $color_slug,
    //                         ]
    //                     ],
    //                 ]
    //             ]
    //         ]
    //     ]
    // ];
    // $variant = $client->search($params);
    // $variant = $variant['hits']['hits'][0]['_source'];

    // return fetchProduct($product["id"], $variant["var_color_id"]);
    return '{"parent_id":234,"title":"BM Face Casual Graphic Boys Tshirt","slug_name":"bm-face-casual","slug_style":"bm-face","category":{"id":56,"type":"Clothing","gender":"Boys","age_group":"Toddler","sub_type":"Tshirt"},"description":"Casual fancy tshirt for toddlers","additional_info":{"gender":"Boys","material":"Cotton","sleeves":"Half Sleeves"},"selected_color_id":30,"variant_group":{"23":{"name":"Blue","html":"#0000FF","slug_color":"blue","images":[{"is_primary":true,"res":{"desktop":{"small_thumb":"/img/thumbnail/3front@thumb.jpg"},"mobile":{"small_thumb":"/img/thumbnail/3front@thumb.jpg"}}}],"variants":[{"id":4735,"inventory_available":true},{"id":4736,"inventory_available":true},{"id":4737,"inventory_available":false}]},"30":{"name":"Green","html":"#008000","slug_color":"green","images":[{"is_primary":true,"res":{"desktop":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"},"mobile":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"}}},{"is_primary":false,"res":{"desktop":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"},"mobile":{"small_thumb":"/img/thumbnail/6front@thumb.jpg","list_thumb":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/460a3bcbdb4cc235aac43a6f81f8f135/2/0/2018-09-01101712177353.png","main":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/c687aa7517cf01e65c009f6943c2b1e9/2/0/2018-09-01101712177353.png","zoom":"https://media-cdn.kidsuperstore.in/media/catalog/product/cache/926507dc7f93631a094422215b778fe0/2/0/2018-09-01101712177353.png"}}}],"variants":[{"id":4535,"list_price":1309,"sale_price":890,"is_default":true,"size":{"id":25,"name":"2-4Y"},"inventory_available":true,"inventory":[{"store":{"id":345,"name":"Surat Store","address":{"id":34,"location":"Surat road"}},"count":0},{"store":{"id":345,"name":"Coimbatore Store","address":{"id":39,"location":"C road"}},"count":2}]},{"id":4536,"list_price":1409,"sale_price":895,"is_default":false,"size":{"id":26,"name":"4-6Y"},"inventory_available":true,"inventory":[{"store":{"id":345,"name":"Surat Store","address":{"id":34,"location":"Surat road"}},"count":2},{"store":{"id":345,"name":"Coimbatore Store","address":{"id":39,"location":"C road"}},"count":3}]},{"id":4537,"list_price":1509,"sale_price":900,"is_default":false,"size":{"id":23,"name":"6-8Y"},"inventory_available":false,"inventory":[{"store":{"id":345,"name":"Surat Store","address":{"id":34,"location":"Surat road"}},"count":0}]}]}}}';
}

