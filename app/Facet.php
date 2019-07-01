<?php

namespace App;

use Ajency\Connections\OdooConnect;
use Illuminate\Database\Eloquent\Model;

class Facet extends Model
{
    protected $fillable = ['display_name', 'sequence', 'display'];

    protected $casts = [
        'display' => 'boolean',
    ];

    public function returnPolicies()
    {
        return $this->belongsToMany('App\ReturnPolicy');
    }

    public static function updateAttribute($attribute)
    {
        $offset = 0;
        $facets = ['COLOR' => 'product_color_html', 'SIZE' => 'variant_size_name'];
        if (!isset($facets[$attribute])) {
            $facets[$attribute] = 'variant_' . strtolower($attribute) . '_name';
        }

        $max_facet_id = self::select(['odoo_id'])->where('facet_name', $facets[$attribute])->max('odoo_id');
        if ($max_facet_id == null) {
            $max_facet_id = 0;
        }

        $odoo = new OdooConnect;
        do {
            $attributesData = $odoo->defaultExec("product.attribute.value", 'search_read', [[["id", ">", $max_facet_id]]], ['fields' => config('odoo.model_fields.attributes'), 'order' => 'id', 'offset' => $offset]);

            foreach ($attributesData as $attributeData) {
                if ($attributeData['attribute_id'][1] == $attribute) {
                    $facet_value = ($facets[$attribute] == 'product_color_html') ? $attributeData['html_color'] : $attributeData['name'];
                    try {
                        $facetObj               = new Facet;
                        $facetObj->facet_name   = $facets[$attribute];
                        $facetObj->facet_value  = $facet_value;
                        $facetObj->display_name = $attributeData['name'];
                        $facetObj->slug         = ($facets[$attribute] == 'product_color_html') ? str_slug($attributeData['html_color']) : str_slug($attributeData['name']);
                        $facetObj->sequence     = 10000;
                        $facetObj->display      = (count($attributeData['product_ids']) > 0) ? true : false;
                        $facetObj->odoo_id      = $attributeData['id'];
                        $facetObj->save();
                    } catch (\Exception $e) {
                        \Log::warning($e->getMessage());
                        $facetObj_existing = self::where('facet_name', $facets[$attribute])->where('facet_value', $facet_value)->update(['odoo_id' => $attributeData['id']]);
                    }
                }
            }

            $offset = $offset + $attributesData->count();
        } while ($attributesData->count() == config('odoo.limit'));
    }

    public static function fetchFacetList($params)
    {
        $editable_facets  = config('product.facets.editable');
        $facet_categories = collect(config('product.facet_display_data'))->filter(function ($facet, $key) use ($editable_facets) {
            return in_array($key, $editable_facets);
        })->mapWithKeys(function ($facet, $key) use ($params) {
            return [$key => $facet['name']];
        });
        $facets = collect($editable_facets);
        if ($params['category'] != 'all') {
            $facets = $facets->filter(function ($facet) use ($params) {
                return ($params['category'] == $facet);
            });
        }
        $facet_list_obj = self::select('id', 'facet_value', 'display_name', 'sequence', 'display')->whereIn('facet_name', $facets);
        $total_count = $facet_list_obj->count();
        if (isset($params['offset']) && isset($params['limit'])) {
            $facet_list_obj->offset($params['offset'])->limit($params['limit']);
        }
        $facet_list = $facet_list_obj->get();     
        return ['list' => $facet_list, 'total_count' => $total_count, 'categories' => $facet_categories];
    }

    public static function updateFacets($params)
    {
        collect($params['facets'])->each(function ($facet) {
            self::find($facet['id'])->update([$facet['name'] => $facet['value']]);
        });
    }
}
