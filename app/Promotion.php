<?php

namespace App;

use Ajency\Connections\OdooConnect;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['odoo_id'];

    protected $dates = [
        'created_at',
        'updated_at',
        'start',
        'expire',
    ];

    public function getStartAttribute($value)
    {
        return (new Carbon($value))->setTimezone('Asia/Kolkata');
    }

    public function getExpireAttribute($value)
    {
        return (new Carbon($value))->setTimezone('Asia/Kolkata');
    }

    public static function getAllDiscountsFromOdoo()
    {
        $offset = 0;
        do {
            $odoo      = new OdooConnect;
            $discounts = $odoo->defaultExec("product.template", 'search_read', [[['type', '=', 'discount'], ['discount_rule', '=', 'cart']]], ['fields' => config('odoo.model_fields.discounts'), 'order' => 'id', 'offset' => $offset]);

            foreach ($discounts as $discount) {
                $promotion                = self::firstOrNew(['odoo_id' => $discount['id']]);
                $promotion->title         = $discount['name'];
                $promotion->value         = $discount['discount_amt'];
                $promotion->discount_type = $discount['apply1'];
                $promotion->step_quantity = $discount['qty_step'];
                $promotion->start         = $discount['from_date1'];
                $promotion->expire        = $discount['to_date1'];
                $promotion->priority      = $discount['priority1'];
                $promotion->save();
            }

            $offset = $offset + $discounts->count();
        } while ($discounts->count() == config('odoo.limit'));
    }

    public static function getAllPromotions($cart, $source = 'web')
    {
        $promotions = self::where('active', true)->where('start', '<=', Carbon::now())->where('expire', '>', Carbon::now())->get();
        $response   = [];
        foreach ($promotions as $promo) {
            $promo_res = [
                'promotion_id'   => $promo->id,
                'display_title'  => $promo->title,
                'description'    => $promo->description,
                'min_cart_value' => $promo->step_quantity,
                'discount_value' => $promo->value,
                'discount_type'  => $promo->discount_type,
                'valid_from'     => $promo->start->toDateTimeString(),
                'valid_till'     => $promo->expire->toDateTimeString(),
            ];
            $response[$promo->id] = $promo_res;
        }
        return $response;
    }
}
