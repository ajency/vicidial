<?php

return [
    'dropshipping_route_id' => 39,
    'template_fields'                => [
        "name",
        "id",
        "article_desc",
        "barcode",
        "style_no",
        "create_date",
        "__last_update",
        "prod_type",
        "hs_code",
        "product_variant_ids",
        "att_magento_display_name",
        "write_date",
        "display_name",
        "categ_id",
        "active",
        "att_fashionability", #Fashionability
        "att_sleeves", #sleeves
        "description_sale", #description
        "att_material", # material
        "att_occasion",
        "att_wash1",
        "att_fabric_type",
        "att_product_type",
        "att_val_add1",
        "att_ecom_sales",
        "metatag_ids",
        "product_template_description_id",
        "fabric_description_id",
        // "product_own", #private/non private
        "vendor_id", #Vendor
        "brand_id", #Brand
        "route_ids",
        // "parent_flag",
        // "sale_price",
        // "qty_available",
        // "article_code",
        // "product_variant_count",
        // "lst_price",
        // "list_price",
        // "discount_amt",
        // "color",
    ],
    'variant_fields'                 => [
        'id',
        'product_tmpl_id',
        'barcode',
        'active',
        'attribute_value_ids',
        "product_own", #private label
        "style_no",
        "lst_price", #MRP
        "sale_price", #selling price
        "standard_price", // cost of the item
        "route_ids",
        // 'display_name',
        // 'name',
        // 'virtual_available',
        // 'active',
        // 'uom_id',
        // 'price',
        // 'default_code',
        // '__last_update',
        // "taxes_id", # Customer Tax
        // "supplier_taxes_id", # Vendor Tax

    ],
    'move_fields'                    => [
        "id",
        "location_dest_id",
        "location_id",
        "state",
        "product_id",
        "product_uom_id",
        "date",
        "create_date",
        "move_id",
        "picking_id",
        "qty_done",
        "reference",
        "display_name",
        "owner_id",
        "consume_line_ids",
        "ordered_qty",
        "from_loc",
        "to_loc",
        "package_id",
        "is_locked",
        "lot_name",
    ],
    'static_fields' => [
        'product' => [
            'product_rank' => 0,
        ],
        'variant' => [
            
        ],
    ],
    'update_inventory'               => env('UPDATE_INVENTORY', false),
    'attribute_fields'               => [
        'id',
        'name',
        'html_color',
        'attribute_id',
    ],
    'facets'                         => [
        "string_facet"  => [
            'product' => [
                'product_slug',
                'product_att_fashionability',
                'product_att_material',
                'product_category_type',
                'product_gender',
                'product_age_group',
                'product_subtype',
                'product_att_sleeves',
                'product_metatag',
                'product_brand',
                'product_vendor',
                'product_template_description',
                'product_fabric_description',
            ],
            'variant' => [
                'product_color_name',
                'product_color_html',
                'variant_size_name',
                'variant_product_own',
                'variant_barcode',
            ],
        ],
        "boolean_facet" => [
            'product' => [
                'product_active',
                'product_image_available',
                'product_att_ecom_sales',
                'product_is_dropshipping',
            ],
            'variant' => [
                'variant_active',
                'variant_availability',
            ],
        ],
        "number_facet"  => [
            'product' => ['product_id','product_rank','product_vendor_id','product_template_description_id','product_fabric_description_id'],
            'variant' => [
                'product_color_id',
                'variant_id',
                'variant_standard_price',
                'variant_lst_price',
                'variant_sale_price',
                'variant_discount_percent',
                'variant_discount',
                'variant_size_id',
            ],
        ],
        "attributes"    => [
            'product' => [
                'product_name',
                'product_article_desc',
                'product_barcode',
                'product_style_no',
                'product_prod_type',
                'product_att_magento_display_name',
                'product_description_sale',
                'product_display_name',
                'product_hs_code',
                'product_att_occasion',
                'product_att_wash',
                'product_att_fabric_type',
                'product_att_product_type',
                'product_att_other_attribute',
            ],
            'variant' => ['variant_style_no'],
        ],
    ],
    "inventory_fields"               => ["product_id", "quantity", 'location_id'],
    'facet_display_data'             => [
        'product_category_type'    => [
            'name'                   => 'Category',
            'is_singleton'           => false,
            'is_collapsed'           => false,
            'template'               => 'category',
            'order'                  => 0,
            'display_count'          => false,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => false,
            "attribute_param"        => "category",
            'filter_type'            => 'primary_filter',
            "is_essential"           => true,
            "sort_on"                => "sequence",
            "sort_order"             => "asc",
            "custom_attributes"      => [],
            "false_facet_value"      => null,
            "implicit_filter"        => [
                'skip'          => true,
                'default_value' => [],
            ],
        ],
        'product_gender'           => [
            'name'                   => 'Gender',
            'is_singleton'           => false,
            'is_collapsed'           => false,
            'template'               => 'gender',
            'order'                  => 1,
            'display_count'          => false,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => false,
            "attribute_param"        => "gender",
            'filter_type'            => 'primary_filter',
            "is_essential"           => true,
            "sort_on"                => "sequence",
            "sort_order"             => "asc",
            "custom_attributes"      => [],
            "false_facet_value"      => null,
            "implicit_filter"        => [
                'skip'          => true,
                'default_value' => [],
            ],
        ],
        'product_age_group'        => [
            'name'                   => 'Age Group',
            'is_singleton'           => false,
            'is_collapsed'           => false,
            'template'               => 'age',
            'order'                  => 2,
            'display_count'          => true,
            'disabled_at_zero_count' => true,
            "is_attribute_param"     => false,
            "attribute_param"        => "age",
            'filter_type'            => 'primary_filter',
            "is_essential"           => false,
            "sort_on"                => "sequence",
            "sort_order"             => "asc",
            "custom_attributes"      => [],
            "false_facet_value"      => null,
            "implicit_filter"        => [
                'skip'          => true,
                'default_value' => [],
            ],
        ],
        'product_subtype'          => [
            'name'                   => 'Sub Type',
            'is_singleton'           => false,
            'is_collapsed'           => false,
            'template'               => 'subtype',
            'order'                  => 3,
            'display_count'          => true,
            'disabled_at_zero_count' => true,
            "is_attribute_param"     => false,
            "attribute_param"        => "subtype",
            'filter_type'            => 'primary_filter',
            "is_essential"           => false,
            "sort_on"                => "sequence",
            "sort_order"             => "asc",
            "custom_attributes"      => [],
            "false_facet_value"      => null,
            "implicit_filter"        => [
                'skip'          => true,
                'default_value' => [],
            ],
        ],
        'product_brand'            => [
            'name'                   => 'Brand',
            'is_singleton'           => false,
            'is_collapsed'           => true,
            'template'               => 'brand',
            'order'                  => 4,
            'display_count'          => true,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => false,
            "attribute_param"        => "brand",
            'filter_type'            => 'primary_filter',
            "is_essential"           => false,
            "sort_on"                => "count",
            "sort_order"             => "desc",
            "custom_attributes"      => ["show_more_limit" => 10],
            "false_facet_value"      => null,
            "implicit_filter"        => [
                'skip'          => true,
                'default_value' => [],
            ],
        ],
        'product_color_html'       => [
            'name'                   => 'Colour',
            'is_singleton'           => false,
            'is_collapsed'           => true,
            'template'               => 'color',
            'order'                  => 6,
            'display_count'          => true,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => true,
            "attribute_param"        => "color",
            'filter_type'            => 'primary_filter',
            "is_essential"           => false,
            "sort_on"                => "count",
            "sort_order"             => "desc",
            "custom_attributes"      => ["show_more_limit" => 10],
            "false_facet_value"      => null,
            "implicit_filter"        => [
                'skip'          => true,
                'default_value' => [],
            ],
        ],
        'variant_sale_price'       => [
            'name'                   => 'Price Range',
            'is_singleton'           => true,
            'is_collapsed'           => true,
            'template'               => 'price',
            'order'                  => 5,
            'display_count'          => true,
            'disabled_at_zero_count' => true,
            "is_attribute_param"     => true,
            "attribute_param"        => "price",
            'filter_type'            => 'range_filter',
            "is_essential"           => false,
            "sort_on"                => "sequence",
            "sort_order"             => "asc",
            "custom_attributes"      => [],
            "false_facet_value"      => null,
            "implicit_filter"        => [
                'skip'          => true,
                'default_value' => [],
            ],
        ],
        'variant_availability'     => [
            'name'                   => 'Availability',
            'item_display_name'      => 'Include Out Of Stock',
            'is_singleton'           => true,
            'is_collapsed'           => true,
            'template'               => "availability",
            'order'                  => 7,
            'display_count'          => false,
            'disabled_at_zero_count' => true,
            "is_attribute_param"     => true,
            "attribute_param"        => "variant_availability",
            'filter_type'            => 'boolean_filter',
            "is_essential"           => false,
            "sort_on"                => "sequence",
            "sort_order"             => "asc",
            "custom_attributes"      => [],
            "false_facet_value"      => true,
            "facet_value"            => "skip",
            "implicit_filter"        => [
                'skip'          => false,
                'default_value' => true,
            ],
        ],
        'product_image_available'  => [
            'name'                   => 'Image',
            'item_display_name'      => 'Include no images',
            'is_singleton'           => true,
            'is_collapsed'           => true,
            'template'               => (isNotProd()) ? "image" : null,
            'order'                  => 7,
            'display_count'          => false,
            'disabled_at_zero_count' => true,
            "is_attribute_param"     => true,
            "attribute_param"        => "product_image_available",
            'filter_type'            => 'boolean_filter',
            "is_essential"           => false,
            "sort_on"                => "sequence",
            "sort_order"             => "asc",
            "custom_attributes"      => [],
            "false_facet_value"      => true,
            "facet_value"            => "skip",
            "implicit_filter"        => [
                'skip'          => false,
                'default_value' => true,
            ],
        ],
        'product_att_ecom_sales'   => [
            'name'                   => '',
            'item_display_name'      => '',
            'is_singleton'           => true,
            'is_collapsed'           => true,
            'template'               => null,
            'order'                  => 7,
            'display_count'          => false,
            'disabled_at_zero_count' => true,
            "is_attribute_param"     => true,
            "attribute_param"        => "product_att_ecom_sales",
            'filter_type'            => 'boolean_filter',
            "is_essential"           => false,
            "false_facet_value"      => true,
            "facet_value"            => "skip",
            "implicit_filter"        => [
                'skip'          => false,
                'default_value' => true,
            ],
        ],
        'variant_size_name'        => [
            'name'                   => 'Size',
            'is_singleton'           => false,
            'is_collapsed'           => true,
            'template'               => 'size',
            'order'                  => 6,
            'display_count'          => true,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => true,
            "attribute_param"        => "size",
            'filter_type'            => 'primary_filter',
            "is_essential"           => false,
            "sort_on"                => "count",
            "sort_order"             => "desc",
            "custom_attributes"      => ["show_more_limit" => 10],
            "false_facet_value"      => null,
            "implicit_filter"        => [
                'skip'          => true,
                'default_value' => [],
            ],
        ],
        'product_metatag'          => [
            'name'                   => 'Tags',
            'is_singleton'           => false,
            'is_collapsed'           => true,
            'template'               => 'tag',
            'order'                  => 6,
            'display_count'          => true,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => true,
            "attribute_param"        => "tag",
            'filter_type'            => 'primary_filter',
            "is_essential"           => false,
            "sort_on"                => "count",
            "sort_order"             => "desc",
            "custom_attributes"      => ["show_more_limit" => 10],
            "false_facet_value"      => null,
            "implicit_filter"        => [
                'skip'          => true,
                'default_value' => [],
            ],
        ],
        'variant_discount_percent' => [
            'name'                   => 'Discount',
            'is_singleton'           => true,
            'is_collapsed'           => false,
            'template'               => null, //'discount',
            'order'                  => 9,
            'display_count'          => false,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => true,
            "attribute_param"        => "discount",
            'filter_type'            => 'range_filter',
            "is_essential"           => false,
            "custom_attributes"      => [],
            "false_facet_value"      => null,
            "implicit_filter"        => [
                'skip'          => true,
                'default_value' => [],
            ],
        ],
    ],
    'discount_filter'                => [
        ["min" => 0, "max" => 30, "display_name" => "Upto 30%", "sequence" => 1],
        ["min" => 30, "max" => 60, "display_name" => "30% to 60%", "sequence" => 2],
        ["min" => 60, "max" => 100, "display_name" => "60% to 100%", "sequence" => 3],
    ],
    'breadcrumb_order'               => [
        'product_category_type',
        'product_age_group',
        'product_gender',
        'product_subtype',
    ], //Used for breadcrumbs on single product page
    "list_page_display_limit"        => 40,
    "similar_products_display_limit" => 5,
    "price_filter_bucket_range"      => ["min" => 0, "max" => 7000],
    "sort"                           => [
        'price_asc'     => ['field' => 'number_sort.variant_sale_price', "order" => 'asc'],
        'price_desc'    => ['field' => 'number_sort.variant_sale_price', "order" => 'desc'],
        'discount_asc'  => ['field' => 'number_sort.variant_discount_percent', "order" => 'asc'],
        'discount_desc' => ['field' => 'number_sort.variant_discount_percent', "order" => 'desc'],
        'rank_desc' => ['field' => 'number_sort.product_rank', "order" => 'desc'],
    ],
    "sort_on"                        => [
        ["name" => "Recommended", "value" => "", "is_selected" => true, "class" => "popularity"],
        ["name" => "Price Low to High", "value" => "price_asc", "is_selected" => false, "class" => "price-l"],
        ["name" => "Price High to Low", "value" => "price_desc", "is_selected" => false, "class" => "price-h"],
        //["name" => "Discount High to Low", "value" => "discount_desc", "is_selected" => false, "class" => "discount"],
        //["name" => "Discount Low to High", "value" => "discount_asc", "is_selected" => false, "class" => "discount"],
    ],
    "show_list_search"               => true,
    "pagination" => ["show_previous_after"=>5]
];
