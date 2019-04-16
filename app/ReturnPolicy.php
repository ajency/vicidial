<?php

namespace App;

use App\Facet;
use App\Variant;
use Illuminate\Database\Eloquent\Model;

class ReturnPolicy extends Model
{
    protected $casts = [
        'id'           => 'integer',
        'title'        => 'string',
        'display_name' => 'string',
    ];
    public function facet()
    {
        return $this->belongsToMany('App\Facet');
    }

    public static function getReturnPolicy($variant_odoo_id)
    {
        $variant = Variant::where('odoo_id', $variant_odoo_id)->first();

        $cat_type = $variant->getCategoryType();
        $sub_type = $variant->getSubType();

        $facets = Facet::whereHas('return_policies', function ($query) use ($cat_type, $sub_type) {
            $query->where('facet_value', $cat_type)->orWhere('facet_value', $sub_type);
        })->get();

        $facet_cattype = $facets->where('facet_name', 'product_category_type')->first();
        // dd($facet_cattype);
        $facet_subtype = $facets->where('facet_name', 'product_subtype')->first();

        if ($facet_cattype) {
            $facet = $facet_cattype->return_policies()->first();
            

            $returnPolicy = array('id' => $facet->id, 'title' => $facet->title, 'display_name' => $facet->display_name);
            //return $returnPolicy;
            //return json_encode($returnPolicy);
            return response()->json($returnPolicy);

        } elseif ($facet_subtype) {
            $facet = $facet_subtype->return_policies()->first();
            $returnPolicy = array('id' => $facet->id, 'title' => $facet->title, 'display_name' => $facet->display_name);
            
        } else {
            $returnPolicy = 'Other';
        }

        //return json_encode($returnPolicy);
        return response()->json($returnPolicy);

    }

}
