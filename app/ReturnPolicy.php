<?php

namespace App;

use App\Facet;
use Carbon\Carbon;
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

    public function expressions()
    {
        return $this->morphMany('App\Expression', 'parent');
    }

    public static function getReturnPolicyForFacet($category_type, $sub_type)
    {
        $facets = Facet::whereHas('returnPolicies', function ($query) use ($category_type, $sub_type) {
            $query->where('facet_value', $category_type)->orWhere('facet_value', $sub_type);
        })->get();
        $facet_cattype = $facets->where('facet_name', 'product_category_type')->first();
        $facet_subtype = $facets->where('facet_name', 'product_subtype')->first();
        if ($facet_cattype) {
            $return_policy = $facet_cattype->returnPolicies()->first();
        } elseif ($facet_subtype) {
            $return_policy = $facet_subtype->returnPolicies()->first();
        } else {
            $default_return_policy = config('orders.default_return_policy');
            $return_policy         = ReturnPolicy::where('title', $default_return_policy)->first();
        }
        $return_policy_days = $return_policy->expressions->first()->value[0];
        return ['id' => $return_policy->id, 'title' => $return_policy->title, 'display_name' => $return_policy->display_name, 'days' => $return_policy_days];
    }

    public static function fetchReturnPolicy($orderLine)
    {
        $now = Carbon::now()->setTimezone('Asia/Kolkata');
        if (!$orderLine['return_policy']) {
            return ['name' => null, 'return_allowed' => false, 'date' => null];
        } else {
            $returnPolicy = $orderLine['return_policy'];
            
            if ($orderLine['shipment_status'] != 'delivered' || !$orderLine['shipment_delivery_date'] || $orderLine['is_returned'] || !$orderLine['return_expiry_date']) {
                return ['name' => $returnPolicy['display_name'], 'return_allowed' => false, 'date' => null];
            }
            $return_expiry_date = new Carbon($orderLine['return_expiry_date']);
            $return_allowed = ($now->greaterThan($return_expiry_date)) ? false : true;
            return ['name' => $returnPolicy['display_name'], 'return_allowed' => $return_allowed, 'date' => $orderLine['return_expiry_date']];
        }
    }
}
