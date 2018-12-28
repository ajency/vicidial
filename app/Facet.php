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
        $offset	        = 0;
        $facets         = ['COLOR' => 'product_color_html', 'SIZE' => 'variant_size_name'];
        if(!isset($facets[$attribute])) $facets[$attribute] = 'variant_'.strtolower($attribute).'_name';
        $max_facet_id   = self::select(['odoo_id'])->where('facet_name', $facets[$attribute])->max('odoo_id');
        if($max_facet_id == null) $max_facet_id = 0;
        
        $odoo = new OdooConnect;
        do {
	        $attributesData = $odoo->defaultExec("product.attribute.value", 'search_read', [[["id", ">", $max_facet_id ]]], ['fields' => config('odoo.model_fields.attributes'), 'order' => 'id', 'offset' => $offset]);

            foreach ($attributesData as $attributeData) {
                if($attributeData['attribute_id'][1] == $attribute) {
                    $facet_value = ($facets[$attribute] == 'product_color_html') ? $attributeData['html_color'] : $attributeData['name'];
                    try {
                        $facetObj               = new Facet;
                        $facetObj->facet_name   = $facets[$attribute];
                        $facetObj->facet_value  = $facet_value;
                        $facetObj->display_name = $attributeData['name'];
                        $facetObj->slug         = ($facets[$attribute] == 'product_color_html') ? str_slug($attributeData['html_color']) : str_slug($attributeData['name']);
                        $facetObj->sequence     = 10000;
                        $facetObj->display      = (count($attributeData['product_ids'])>0) ? true : false;
                        $facetObj->odoo_id      = $attributeData['id'];
                        $facetObj->save();
                    } catch (\Exception $e) {
                        \Log::warning($e->getMessage());
                        $facetObj_existing          = self::where('facet_name', $facets[$attribute])->where('facet_value', $facet_value)->update(['odoo_id' => $attributeData['id']]);
                    }
                }
            }

            $offset 		= $offset + $attributesData->count();
        } while ($attributesData->count() == config('odoo.limit'));
    }
}
