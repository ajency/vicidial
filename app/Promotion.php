<?php

namespace App;

use App\Elastic\OdooConnect;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $fillable = ['odoo_id'];

    public static function getAllDiscountsFromOdoo()
    {
        $offset = 0;
        do {
            $odoo      = new OdooConnect;
            $discounts = $odoo->defaultExec("product.template", 'search_read', [[['type', '=', 'discount'], ['discount_rule', '=', 'cart']]], ['fields' => config('odoo.model_fields.discounts'), 'order' => 'id', 'offset' => $offset]);

            foreach ($discounts as $discount) {
                $from_date1 = Carbon::createFromFormat('Y-m-d H:i:s', $discount['from_date1'], 'UTC');
                $from_date1->setTimezone('Asia/Kolkata');
                $to_date1 = Carbon::createFromFormat('Y-m-d H:i:s', $discount['to_date1'], 'UTC');
                $to_date1->setTimezone('Asia/Kolkata');

                $promotion                = self::firstOrNew(['odoo_id' => $discount['id']]);
                $promotion->title         = $discount['name'];
                $promotion->value         = $discount['discount_amt'];
                $promotion->discount_type = $discount['apply1'];
                $promotion->step_quantity = $discount['qty_step'];
                $promotion->start         = $from_date1;
                $promotion->expire        = $to_date1;
                $promotion->priority      = $discount['priority1'];
                $promotion->save();
            }

            $offset = $offset + $discounts->count();
        } while ($discounts->count() == config('odoo.limit'));
    }

    public static function getAllPromotions($cart, $source = 'web')
    {
        $promotions = self::get();
        $response   = [];
        foreach ($promotions as $promo) {
            $promo_res = [
                'promotion_id'   => $promo->id,
                'display_title'  => $promo->title,
                'description'    => $promo->description,
                'min_cart_value' => $promo->step_quantity,
                'discount_value' => $promo->value,
                'discount_type'  => $promo->discount_type,
                'valid_from'     => $promo->start,
                'valid_till'     => $promo->expire,
            ];
            $response[$promo->id] = $promo_res;
        }
        return $response;
    }
}
