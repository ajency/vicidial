<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Expression extends Model
{
  protected $casts = [
      'value' => 'array',
  ];
  public function parent()
  {
      return $this->morphTo();
  }

  public function validate(&$data)
  {
     switch($this->entity){
         case 'cart_price':
             switch ($this->filter) {
                 case 'greater_than':
                     return ($data['final_total'] >= $this->value[0]);
                     break;
                 default:
                     return false;
                     break;
             }
             break;

         case 'days':
             switch ($this->filter) {
                 case 'less_than':
                     if ($this->value[0] == 0) {
                         return false;
                         break;
                     }
                     return ($data['days'] <= $this->value[0]);
                     break;                   
                 default:
                     return false;
                     break;
             }
             break;

         case 'specific_products':
           switch ($this->filter) {
               case 'greater_than':
                       $total_amount = 0;
                       $boolIsValid = false;
                       switch ($this->value['activity']) {
                           case 'include':
                                if(empty($data['items'])) {
                                    return false;
                                    break;
                                }
                                foreach ($data['items'] as $key => $orderItem) {
                                    $isCouponApplicable = true;
                                    // Check for each item in the cart if condition satisfies
                                    if ( !empty($orderItem['category_type']) && ($orderItem['category_type'] != $this->value['facet']['category_type']) ) {
                                        $isCouponApplicable &= false;
                                    }
                                    if ( !empty($orderItem['sub_type']) && ($orderItem['sub_type'] != $this->value['facet']['sub_type']) ) {
                                        $isCouponApplicable  &= false;
                                    }
                                    if ( !empty($orderItem['gender']) && ($orderItem['gender'] != $this->value['facet']['gender']) ) {
                                        $isCouponApplicable  &= false;
                                    }
                                    if ( !empty($orderItem['age_group']) && ($orderItem['age_group'] != $this->value['facet']['age_group']) ) {
                                        $isCouponApplicable  &= false;
                                    }
                                    // Exclude listed variant ID from category
                                    if(!empty($this->value['variant']) && in_array($orderItem['odoo_id'], $this->value['variant']) ){
                                        $isCouponApplicable &= false;
                                    }
                                    $boolIsValid |= $isCouponApplicable;
                                    $data['items'][$key]['is_coupon_applicable'] = $isCouponApplicable;

                                    $total_amount += ( $isCouponApplicable )? $orderItem['price_sale'] * $orderItem['quantity'] : 0;
                                }
                                $boolIsValid = ($total_amount < $this->value ['value'])? false :
                                    $boolIsValid;
                                $data['coupon_products_total']   = $total_amount;
                                $data['coupon_specific_products'] = $boolIsValid;
                               return $boolIsValid;
                               break;
                           
                           default:
                                return false;
                                break;
                            }
                   return $boolIsValid;
                   break;     
               default:
                   return false;
                   break;
           }
           break;
        
         default:
             return false;
             break;
     }
  }
}
