<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Elastic\OdooConnect;

class Facet extends Model
{
	protected $casts = [
        'display' => 'boolean',
    ];
	
	public static function updateAttribute($attribute)
    {
        $offset	= 0;
        $facets = ['COLOR' => 'product_color_html', 'SIZE' => 'variant_size_name'];
        if(!isset($facets[$attribute])) $facets[$attribute] = 'variant_'.strtolower($attribute).'_name';
        do {
            $odoo           = new OdooConnect;
	        $attributesData = $odoo->defaultExec("product.attribute.value", 'search_read', [[["id", ">", 0 ]]], ['order' => 'id', 'offset' => $offset]);

            foreach ($attributesData as $attributeData) {
                if($attributeData['attribute_id'][1] == $attribute) {
                    try {
                        $facetObj               = new Facet;
                        $facetObj->facet_name   = $facets[$attribute];
                        $facetObj->facet_value  = ($facets[$attribute] == 'product_color_html') ? $attributeData['html_color'] : $attributeData['name'];
                        $facetObj->display_name = $attributeData['name'];
                        $facetObj->slug         = ($facets[$attribute] == 'product_color_html') ? str_slug($attributeData['html_color']) : str_slug($attributeData['name']);
                        $facetObj->sequence     = 10000;
                        $facetObj->display      = (count($attributeData['product_ids'])>0) ? true : false;
                        $facetObj->save();
                    } catch (\Exception $e) {
                        \Log::warning($e->getMessage());
                    }
                }
            }

            $offset 		= $offset + $attributesData->count();
        } while ($attributesData->count() == config('odoo.limit'));
    }
}
