<?php

return [
    'template_fields'         => [
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
        // "product_own", #private/non private
        "vendor_id", #Vendor
        "brand_ids", #Brand
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
    'variant_fields'          => [
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
    'move_fields'             => [
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
    'update_inventory'        => env('UPDATE_INVENTORY', false),
    'attribute_fields'        => [
        'id',
        'name',
        'html_color',
        'attribute_id',
    ],
    'facets'                  => [
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
            ],
            'variant' => [
                'product_color_name',
                'product_color_html',
                'variant_size_name',
                'variant_product_own',
            ],
        ],
        "boolean_facet" => [
            'product' => [
                'product_active',
            ],
            'variant' => ['variant_active', 'variant_availability'],
        ],
        "number_facet"  => [
            'product' => ['product_id'],
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
    "inventory_fields"        => ["warehouse_id", "product_id", "quantity", 'location_id'],
    "inventory_max"           => 10,
    'facet_display_data'      => [
        'product_category_type' => [
            'name'                   => 'Category',
            'is_singleton'           => false,
            'is_collapsed'           => false,
            'template'               => 'category',
            'order'                  => 0,
            'display_count'          => true,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => false,
            "attribute_param"        => null,
            'filter_type'            => 'primary_filter',
            "is_essential"          => true
        ],
        'product_gender'        => [
            'name'                   => 'Gender',
            'is_singleton'           => false,
            'is_collapsed'           => false,
            'template'               => 'gender',
            'order'                  => 1,
            'display_count'          => true,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => false,
            "attribute_param"        => null,
            'filter_type'            => 'primary_filter',
            "is_essential"          => true
        ],
        'product_age_group'     => [
            'name'                   => 'Age Group',
            'is_singleton'           => false,
            'is_collapsed'           => true,
            'template'               => 'age',
            'order'                  => 2,
            'display_count'          => true,
            'disabled_at_zero_count' => true,
            "is_attribute_param"     => false,
            "attribute_param"        => null,
            'filter_type'            => 'primary_filter',
            "is_essential"          => false
        ],
        'product_subtype'       => [
            'name'                   => 'Sub Type',
            'is_singleton'           => false,
            'is_collapsed'           => true,
            'template'               => 'subtype',
            'order'                  => 3,
            'display_count'          => true,
            'disabled_at_zero_count' => true,
            "is_attribute_param"     => false,
            "attribute_param"        => null,
            'filter_type'            => 'primary_filter',
            "is_essential"          => false
        ],
        'product_color_html'    => [
            'name'                   => 'Colour',
            'is_singleton'           => false,
            'is_collapsed'           => true,
            'template'               => 'color',
            'order'                  => 5,
            'display_count'          => true,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => true,
            "attribute_param"        => null,
            'filter_type'            => 'primary_filter',
            "is_essential"          => false
        ],
        'variant_sale_price'    => [
            'name'                   => 'Price Range',
            'is_singleton'           => true,
            'is_collapsed'           => true,
            'template'               => 'price',
            'order'                  => 4,
            'display_count'          => false,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => true,
            "attribute_param"        => "price",
            'filter_type'            => 'range_filter',
            "is_essential"          => false
        ],
        'variant_availability'  => [
            'name'                   => 'Availability',
            'display_name'           => 'Exclude Out Of Stock',
            'is_singleton'           => true,
            'is_collapsed'           => true,
            'template'               => 'availability',
            'order'                  => 6,
            'display_count'          => true,
            'disabled_at_zero_count' => false,
            "is_attribute_param"     => true,
            'attribute_slug'         => 'variant_availability'
            "attribute_param"        => "availability",
            'filter_type'            => 'boolean_filter',
        ],
    ],
    'breadcrumb_order'        => [
        'product_category_type',
        'product_age_group',
        'product_gender',
        'product_subtype',
    ], //Used for breadcrumbs on single product page
    "list_page_display_limit" => 30,

];
