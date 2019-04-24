<?php

namespace App;

use Ajency\Connections\OdooConnect;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['odoo_model', 'odoo_id'];

    protected $casts = [
        'has_coupon' => 'boolean',
        'active'     => 'boolean',
        'global'     => 'boolean',
        'display'    => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'start',
        'expire',
    ];

    public function expressions()
    {
        return $this->morphMany('App\Expression', 'parent');
    }

    public function coupons()
    {
        return $this->hasMany('App\Coupon');
    }

    public function action()
    {
        return $this->hasOne('App\Action');
    }

    public function getStartAttribute($value)
    {
        return (new Carbon($value))->setTimezone('Asia/Kolkata');
    }

    public function getExpireAttribute($value)
    {
        return (new Carbon($value))->setTimezone('Asia/Kolkata');
    }

    public static function sync()
    {
        self::where('active',true)->update(['active' => false]);
        $odoo    = new OdooConnect;
        $coupons = $odoo->defaultExec(config('odoo.model.discount.name'), 'search', [[['coupon_typ', '=', 'SPECIFIC_COUPON'], ['type', '=', 'discount'], ['discount_rule', '=', 'cart']]], ['limit' => 1000]);
        $coupons->each(function ($couponID) {
            self::indexDiscount($couponID);
        });
    }

    public function saveCouponData()
    {
        if (!$this->has_coupon) {
            return;
        }
        $odoo             = new OdooConnect;
        $discount_coupons = $odoo->defaultExec(config('odoo.model.coupon.name'), 'search_read', [[['program_id', '=', $this->odoo_id]]], ['fields' => config('odoo.model.coupon.fields'), 'order' => 'id']);
        if ($discount_coupons->isEmpty()) {
            throw new \Exception("coupon discount ID {$this->odoo_id} has no coupons");
        } elseif ($discount_coupons->first()['global_discount_coupon']) {
            $odoo_coupon      = $discount_coupons->first();
            $this->global     = true;
            $this->display    = true;
            $this->total_uses = $odoo_coupon['total_coupon_count'];
            $this->save();

            $coupon                 = Coupon::firstOrNew(['odoo_id' => $odoo_coupon['id']]);
            $coupon->code           = $odoo_coupon['code'];
            $coupon->display_code   = $odoo_coupon['global_code'];
            $coupon->has_expression = false;
            $coupon->left_uses      = $odoo_coupon['consumed_coupon_count'];
            $this->coupons()->save($coupon);
        } else {
            $this->global  = false;
            $this->display = false;
            $this->save();
        }
    }

    public function saveExpressionData($discount)
    {
        $this->expressions()->delete();
        switch ($discount['discount_rule']) {
            case 'cart':
                $expn         = new Expression;
                $expn->entity = 'cart_price';
                $expn->filter = 'greater_than';
                $expn->value  = [$discount['qty_step']];
                $this->expressions()->save($expn);
                break;
        }

    }

    public function saveActionData($discount)
    {
        $this->action()->delete();
        $action         = new Action;
        $action->entity = 'cart_price';
        switch ($discount['apply1']) {
            case 'cart_fixed':
                $action->type = 'value';
                break;
            case 'by_percent':
                $action->type = 'percent';
                break;
            default:
                # code...
                break;
        }

        $action->value = ['value' => $discount['discount_amt']];
        $this->action()->save($action);
    }

    public function saveOfferData($discount)
    {
        $this->title       = $discount['name'];
        $this->start       = $discount['from_date1'];
        $this->expire      = $discount['to_date1'];
        $this->priority    = $discount['priority1'];
        $this->active      = true;
        $this->description = ($discount['description_sale'] == false) ? null : $discount['description_sale'];
        switch ($discount['coupon_typ']) {
            case 'NO_COUPON':
                $this->has_coupon = false;
                break;

            case 'SPECIFIC_COUPON':
                $this->has_coupon = true;
                break;
        }
        $this->save();
    }

    public static function indexDiscount($offerID)
    {
        $odoo     = new OdooConnect;
        $discount = $odoo->defaultExec(config('odoo.model.discount.name'), 'read', [[$offerID]], ['fields' => config('odoo.model.discount.fields')])->first();
        if ($discount == null) {
            throw new \Exception("ID {$offerID} does not exist in " . config('odoo.model.discount.name'));
        }
        $offer = self::firstOrNew(['odoo_model' => config('odoo.model.discount.name'), 'odoo_id' => $offerID]);
        $offer->saveOfferData($discount);
        $offer->saveCouponData();
        $offer->saveExpressionData($discount);
        $offer->saveActionData($discount);
    }

    public function getCouponDetails()
    {
        $coupon                  = [];
        $coupon['coupon_code']   = $this->coupons->first()->display_code;
        $coupon['display_title'] = $this->title;
        $coupon['description']   = $this->description;
        $expn                    = $this->expressions->first();
        $coupon['condition']     = [
            'entity' => $expn['entity'],
            'filter' => $expn['filter'],
            'value'  => $expn['value'],
        ];
        $coupon['action'] = [
            'type'  => $this->action->type,
            'value' => $this->action->value['value'],
        ];
        $coupon['valid_from'] = $this->start->toDateTimeString();
        $coupon['valid_till'] = $this->expire->toDateTimeString();
        return $coupon;
    }

    public static function getAllActiveCoupons()
    {
        $couponDiscounts = self::where('active', true)
            ->where('display', true)
            ->where('has_coupon', true)
            ->where('global', true)
            ->where('start', '<=', Carbon::now())
            ->where('expire', '>', Carbon::now())
            ->with(['expressions', 'action', 'coupons'])
            ->get();
        $coupons = [];
        foreach ($couponDiscounts as $discount) {
            if ($discount->coupons->sum('left_uses') > 0) {
                $coupons[] = $discount->getCouponDetails();
            }

        }
        return $coupons;
    }

    public function applyOffer($cartData)
    {
        $expressions      = $this->expressions;
        $isApplicable     = true;
        $couponApplicable = false;
        $hasShippingItems = false;

        //check if active
        if(!$this->active){
            $cartData['messages']['inactive_offer'] = "Offer is disabled";
            $cartData['coupon']                   = null;
            return $cartData;
        }

        //check if offer is valid under current timeframe
        $now = Carbon::now();
        if ($now < $this->start) {
            $cartData['messages']['offer_future'] = "Offer has expired";
            $cartData['coupon']                   = null;
            return $cartData;
        }
        if ($now > $this->expire) {
            $cartData['messages']['offer_expire'] = "Offer has expired";
            $cartData['coupon']                   = null;
            return $cartData;
        }
        //check if offer satisfies all condition

        foreach ($expressions as $expression) {
            if (!$expression->validate($cartData)) {
                $isApplicable = false;
            }
        }
        if (!$isApplicable) {
            $cartData['messages']['offer_not_applicable'] = "Offer {$this->title} not applicable on your cart";
            $cartData['coupon']                           = null;
            return $cartData;
        }

        //if cart has shipping items, then set coupon as invalid
        if(checkForOfferItems($cartData['items'])){
            $cartData['messages']['coupon_not_applicable_for_products_with_shipping_charges'] = "This coupon is not valid for school uniforms";
            $cartData['coupon']                                                               = null;
            return $cartData;   
        }

        //if offer has coupon, check if coupon usage is still valid
        $coupons = $this->coupons;
        foreach ($coupons as $coupon) {
            if ($coupon->validate()) {
                $couponApplicable = true;
            }
        }
        if (!$couponApplicable) {
            $cartData['messages']['coupon_not_applicable'] = "Coupon not valid or has exceeded its limit";
            $cartData['coupon']                            = null;
            return $cartData;
        }

        //perform the offer action
        $cartData = $this->action->apply($cartData);

        //Add offer applied
        $cartData['offersApplied'][] = $this;

        //translate to items
        return translateDiscountToItems($cartData);
    }

    public static function buildCartData($cartData)
    {
        $mrp_total  = 0;
        $sale_total = 0;

        foreach ($cartData['items'] as $id => $item) {
            $mrp_total += $item['price_mrp'] * $item['quantity'];
            $sale_total += $item['price_sale'] * $item['quantity'];
            $cartData['items'][$id]['price_final'] = $item['price_sale'];
        }
        $cartData['mrp_total']     = $mrp_total;
        $cartData['sale_total']    = $sale_total;
        $cartData['final_total']   = $sale_total;
        $cartData['discount']      = 0;
        $cartData['round_off']     = 0;
        $cartData['shipping']      = 0;
        $cartData['offersApplied'] = [];
        $cartData['messages']      = [];
        
        return $cartData;
    }

    public static function processData($cartData)
    {
        $cartData = self::buildCartData($cartData);
        if ($cartData['coupon'] != null && trim($cartData['coupon']) != '') {
            $coupon = Coupon::where('display_code', $cartData['coupon'])->first();
            if ($coupon != null) {
                $cartData = $coupon->offer->applyOffer($cartData);
            } else {
                $cartData['coupon']                     = null;
                $cartData['messages']['invalid_coupon'] = 'Your code did not match any coupons'; //shift this to config
            }
        } else {
            $cartData['coupon'] = null;
        }
        //check if cart has shipping items and add shipping charges to cart if any
        $cartData = self::addShippingCharges($cartData);
        return $cartData;
    }

    public static function addShippingCharges($cartData)
    {
        if(checkForShippingItems($cartData['items'])){  //check if cart has shipping items present
            $cartData['shipping']     = Defaults::getUniformShippingPrice();
        }
        return $cartData;
    }

}
