<?php

namespace App;

use Ajency\Connections\OdooConnect;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['odoo_model', 'odoo_id'];
    protected $casts    = [
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

    public function sync()
    {

    }

    public function saveCouponData()
    {
        if (!$this->has_coupon) {
            return;
        }

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
                $expn->value  = $discount['qty_step'];
                $this->expressions()->save($expn);
                break;
        }

    }

    public function saveActionData($discount)
    {
        $this->action()->delete();
        $action         = new Action;
        $action->entity = 'cart_price';
        $action->type   = $discount['apply1'];
        $action->value  = ['value' => $discount['discount_amt']];
        $this->action()->save($action);
    }

    public function saveOfferData($discount){
        $this->title      = $discount['name'];
        $this->start      = $discount['from_date1'];
        $this->expire     = $discount['to_date1'];
        $this->odoo_model = config('odoo.model.discount.name');
        $this->odoo_id    = $offerID;
        $this->priority   = $discount['priority1'];
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
}
