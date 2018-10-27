<?php

return [
    'template_fields' => [
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
        // "parent_flag",
        // "sale_price",
        // "qty_available",
        // "article_code",
        // "product_variant_count",
        // "lst_price",
        // "list_price",
        // "discount_amt",
        // "color",
        // "product_own", #private/non private
    ],
    'variant_fields'  => [
        'id',
        'product_tmpl_id',
        'barcode',
        'active',
        'attribute_value_ids',
        "product_own", #private label
        "style_no",
        "lst_price", #MRP
        "sale_price", #Cost without tax
        "standard_price",
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
    'attribute_fields' => [
        'id',
        'name',
        'html_color',
        'attribute_id',
    ],
    'facets'          => [
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
            ],
        ],
        "boolean_facet" => [
            'product' => [
                'product_active',
            ],
            'variant' => ['variant_product_own', 'variant_active','variant_availability'],
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
            ],
            'variant' => ['variant_style_no'],
        ],
    ],
    "inventory_fields" => ["warehouse_id", "product_id", "quantity"],
    "inventory_max"    => 10,
    'facet_display_data' => [
        'product_category_type' => [
            'name' => 'Category',
            'is_singleton' => false,
            'is_collapsed' => true,
            'template' => 'cateory',
            'order' => 0,
        ],
        'product_gender' => [
            'name' => 'Gender',
            'is_singleton' => false,
            'is_collapsed' => true,
            'template' => 'gender',
            'order' => 1,
        ],
        'product_age_group' => [
            'name' => 'Age Group',
            'is_singleton' => false,
            'is_collapsed' => true,
            'template' => 'age',
            'order' => 2,
        ],
        'product_subtype' => [
            'name' => 'Sub Type',
            'is_singleton' => false,
            'is_collapsed' => true,
            'template' => 'subtype',
            'order' => 3,
        ],
    ],
];
