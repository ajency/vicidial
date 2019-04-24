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
        $facets = Facet::whereHas('return_policies', function ($query) use ($category_type, $sub_type) {
            $query->where('facet_value', $category_type)->orWhere('facet_value', $sub_type);
        })->get();
        $facet_cattype = $facets->where('facet_name', 'product_category_type')->first();
        $facet_subtype = $facets->where('facet_name', 'product_subtype')->first();
        if ($facet_cattype) {
            $return_policy = $facet_cattype->return_policies()->first();
        } elseif ($facet_subtype) {
            $return_policy = $facet_subtype->return_policies()->first();
        } else {
            $default_return_policy = config('orders.default_return_policy');
            $return_policy         = ReturnPolicy::where('title', $default_return_policy)->first();
        }

        return $return_policy->id;
    }

    public static function fetchReturnPolicy($orderLine_id)
    {
        $now        = Carbon::now();
        $policyList = array();
        $orderLine  = OrderLine::find($orderLine_id);
        if ($orderLine->shipment_status != 'delivered' || !$orderLine->shipment_delivery_date || $orderLine->is_returned || !$orderLine->return_policy) {
            return ['name' => null, 'return_allowed' => false];
        } else {
            $returnPolicy   = $orderLine->return_policy;
            $orderDate      = new Carbon($orderLine->shipment_delivery_date);
            $data           = ['days' => $orderDate->diff($now)->days];
            $return_allowed = true;
            foreach ($returnPolicy->expressions as $expression) {
                if (!$expression->validate($data)) {
                    $return_allowed = false;
                    break;
                }
            }
        }
        return ['name' => $returnPolicy['display_name'], 'return_allowed' => $return_allowed];
    }
}
