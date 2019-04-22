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
        $returnPolicies = array();
        $facets         = Facet::whereHas('return_policies', function ($query) use ($category_type, $sub_type) {
            $query->where('facet_value', $category_type)->orWhere('facet_value', $sub_type);
        })->get();
        $facet_cattype = $facets->where('facet_name', 'product_category_type')->first();
        $facet_subtype = $facets->where('facet_name', 'product_subtype')->first();
        if ($facet_cattype) {
            $facet = $facet_cattype->return_policies()->first();
        } elseif ($facet_subtype) {
            $facet = $facet_subtype->return_policies()->first();
        } else {
            $default_title = collect(Defaults::where('type', 'return_policy')->where('label', 'default')->first()->meta_data)['title'];
            $facet         = ReturnPolicy::where('title', $default_title)->first();
        }
        $returnPolicies[] = ['id' => $facet->id, 'title' => $facet->title, 'display_name' => $facet->display_name];
        return $returnPolicies;
    }

    public static function fetchReturnPolicy($orderLine_id)
    {
        $now        = Carbon::now();
        $policyList = array();
        $orderLine = OrderLine::find($orderLine_id);
        if (!$orderLine->return_policy) {
            $policyList[] = [null => false];
        }
        else{
            $returnPolicyIds = collect($orderLine->return_policy)->pluck('id');
            $returnPolicies  = ReturnPolicy::whereIn('id', $returnPolicyIds)->get();
            foreach ($returnPolicies as $returnPolicy) {
                if ($orderLine->shipment_delivery_date) {
                    foreach ($returnPolicy->expressions as $expression) {
                        $orderDate    = new Carbon($orderLine->shipment_delivery_date);
                        $data['days'] = $orderDate->diff($now)->days;
                        if ($expression->validate($data)) {
                            $policyList[] = [$returnPolicy['display_name'] => true];
                        } else {
                            $policyList[] = [$returnPolicy['display_name'] => false];
                        }
                    }
                } else {
                    $policyList[] = [$returnPolicy['display_name'] => false];
                }
            }
        }
        return $policyList;
    }
}
