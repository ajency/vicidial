<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EntityData extends Model
{
    protected $table = 'entity_data';

    protected $casts = [
        'active' => 'boolean',
    ];

    protected CONST ATTRIBUTE_CAST = [
    	'product_rank' => 'int',
    ];

    public static function attributeCastHelper($attribute, $value)
    {
        if (isset(self::ATTRIBUTE_CAST[$attribute])) {
            switch (self::ATTRIBUTE_CAST[$attribute]) {
                case 'int':
                    $value = (int) $value;
                    break;
            }
        }
        return $value;
    }

    public static function getOdooProductAttributes($productID, $all = false)
    {
        $query = self::where([
            'entity'        => 'product',
            'entity_origin' => 'odoo',
            'entity_id'     => $productID,
        ]);
        if (!$all) {
            $query->where('active', true);
        }
        $results = $query->get();
        return $results->mapWithKeys(function ($item) {
            return [$item['attribute'] => EntityData::attributeCastHelper($item['attribute'], $item['value'])];

        });
    }
    
    public static function getOdooVariantAttributes($variantID, $all = false)
    {
        $query = self::where([
            'entity'        => 'variant',
            'entity_origin' => 'odoo',
            'entity_id'     => $variantID,
        ]);
        if (!$all) {
            $query->where('active', true);
        }
        $results = $query->get();
        return $results->mapWithKeys(function ($item) {
            return [$item['attribute'] => EntityData::attributeCastHelper($item['attribute'], $item['value'])];

        });
    }

}
