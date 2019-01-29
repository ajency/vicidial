<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $casts = [
        'value' => 'array',
    ];

    public function offer()
    {
        return $this->belongsTo('App\Offer');
    }

    public function apply($cartData)
    {
        switch ($this->entity) {
            case 'cart_price':
                switch ($this->type) {
                    case 'value':
                        $cartData['final_total'] -= $this->value['value'];
                        $cartData['discount'] += $this->value['value'];
                        break;
                    case 'percent':
                        $cartData['final_total'] = round($cartData['final_total'] - $cartData['final_total'] * $this->value['value'] / (float) 100);
                        $cartData['discount'] += round($cartData['final_total'] * $this->value['value'] / (float) 100);
                        break;
                    default:
                        # code...
                        break;
                }
                break;

            default:
                # code...
                break;
        }
        return $cartData;
    }
}
