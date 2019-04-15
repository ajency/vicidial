<?php

namespace App;

use App\Facet;
use App\Variant;
use Illuminate\Database\Eloquent\Model;

class ReturnPolicy extends Model
{
    public function facet()
    {
        return $this->belongsToMany('App\Facet');
    }

    public static function getReturnPolicy($variant_odoo_id)
    {
        //$var = [];
        $variant = Variant::where('odoo_id', $variant_odoo_id)->first();

        $cat_type = $variant->getCategoryType();
        $sub_type = $variant->getSubType();

        $facet    = Facet::where('facet_value', $cat_type)->first();
        $facet_id = $facet->id;

        $f = Facet::find($facet_id);
        $v = $f->return_policies()->first();

        if ($v) {

            return $v->title;

        } 

        else {

            $facet    = Facet::where('facet_value', $sub_type)->first();
            $facet_id = $facet->id;

            $f = Facet::find($facet_id);
            $v = $f->return_policies()->first();

            if ($v) {

                return $v->title;
                
            } else {
                $v = 'Other';

                return $v;

            }
        }

        /* //$facet    = \DB::table('facets')->where('facet_value', $cat_type)->first();

    $return   = \DB::table('facet_returnpolicies')->where('facet_id', $facet_id)->first();
    if ($return) {
    //dd($return);
    $ret           = $return->returnpolicies_id;
    $return_type   = \DB::table('return_policies')->where('id', $ret)->first();
    $return_policy = $return_type->title;
    return $return_policy;
    } else {
    $facet    = \DB::table('facets')->where('facet_value', $sub_type)->first();
    $facet_id = $facet->id;
    $return   = \DB::table('facet_returnpolicies')->where('facet_id', $facet_id)->first();
    if ($return) {
    $ret           = $return->returnpolicies_id;
    $return_type   = \DB::table('return_policies')->where('id', $ret)->first();
    $return_policy = $return_type->title;
    return $return_policy;
    } else {
    $return_policy = 'Other';
    return $return_policy;
    }

    }*/

    }

}
