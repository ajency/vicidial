<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Elastic\OdooConnect;

class Promotion extends Model
{
    protected $fillable = ['odoo_id'];

    public static function getAllDiscountsFromOdoo()
    {
    	$offset	= 0;
        do {
            $odoo 		= new OdooConnect;
	        $discounts 	= $odoo->defaultExec("product.template", 'search_read', [[['type' ,'=', 'discount'], ['discount_rule' ,'=', 'cart']]], ['fields' => config('odoo.model_fields.discounts'), 'order' => 'id', 'offset' => $offset]);

            foreach ($discounts as $discount) {
                $promotion 					= self::firstOrNew(['odoo_id' => $discount['id']]);
				$promotion->title 			= $discount['name'];
				$promotion->value 			= $discount['discount_amt'];
				$promotion->discount_type 	= $discount['apply1'];
				$promotion->step_quantity	= $discount['qty_step'];
				$promotion->start 			= $discount['from_date1'];
				$promotion->expire 			= $discount['to_date1'];
				$promotion->priority 		= $discount['priority1'];
				$promotion->save();
            }

            $offset 	= $offset + $discounts->count();
        } while ($discounts->count() == config('odoo.limit'));
    }
}
