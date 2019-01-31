<?php

namespace App;

use Ajency\Connections\OdooConnect;
use App\Offer;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    protected $casts = [
        'has_expression' => 'boolean',

    ];

    protected $fillable = ['odoo_id'];

    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }

    public function validate($userID = null)
    {
        if ($this->left_uses <= 0) {
            return false;
        }

        if ($this->has_expression) {

        }

        return true;
    }

    public static function updateCouponLeft()
    {
        $couponsIds = Offer::where('active', true)->where('has_coupon', true)->where('start', '<=', Carbon::now())->where('expire', '>', Carbon::now())->with(['coupons'])->get()->pluck('coupons')->flatten()->pluck('odoo_id');
        $odoo       = new OdooConnect;
        $odoo->defaultExec('sale.order.coupon','read',[$couponsIds->toArray()],['fields'=>['consumed_coupon_count']])
            ->each(function($item){
                self::where('odoo_id',$item['id'])->update(['left_uses' => $item['consumed_coupon_count']]);
            });
    }
}
