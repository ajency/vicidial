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
                      $cartData['discount'] += round($cartData['final_total'] * $this->value['value'] / (float) 100,2);
                      $cartData['final_total'] = round($cartData['final_total'] - $cartData['final_total'] * $this->value['value'] / (float) 100, 2);
                      break;
                  default:
                      # code...
                      break;
              }
              break;

          case 'specific_products':
              switch ($this->type) {
                  case 'value':
                      $cartData['final_total'] -= $this->value['value'];
                      $cartData['discount'] += $this->value['value'];
                      break;
                  case 'percent':
                      $cartData['discount'] += round($cartData['coupon_products_total_amount'] * $this->value['value'] / (float) 100,2);
                      $cartData['final_total'] = round($cartData['final_total'] - $cartData['coupon_products_total_amount'] * $this->value['value'] / (float) 100, 2);
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
