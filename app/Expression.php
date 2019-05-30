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
            if(empty($data['items'])) {
              return false;
            }
            $value         = $this->value['value'];
            $variantIds    = $this->value['variant'];
            $gender        = $this->value['facet']['gender'];
            $subType       = $this->value['facet']['sub_type'];
            $ageGroup      = $this->value['facet']['age_group'];
            $categoryType  = $this->value['facet']['category_type'];

             switch ($this->filter) {
                 case 'greater_than':
                     $total_amount = 0;
                     $isCouponCartApplicable = false;
                     switch ($this->value['activity']) {
                         case 'include':
                            foreach ($data['items'] as $key => $orderItem) {
                                // Check for each item in the cart if condition satisfies
                                if( ( !$categoryType || ($orderItem['category_type'] === $categoryType) ) && ( !$subType || ($orderItem['sub_type'] === $subType) ) && ( !$gender || ($orderItem['gender'] === $gender) ) && ( !$ageGroup || ($orderItem['age_group'] === $ageGroup) ) && ( !is_array($variantIds) || !in_array($orderItem['odoo_id'], $variantIds) ) ) {
                                    $isCouponCartApplicable = true;
                                    $data['items'][$key]['is_coupon_applicable'] = true;
                                    $total_amount += $orderItem['price_sale'] * $orderItem['quantity'];
                                    continue;
                                }
                                $data['items'][$key]['is_coupon_applicable'] = false;
                            }
                           break;
                       
                         case 'exclude':
                            foreach ($data['items'] as $key => $orderItem) {
                                // Check for each item in the cart if condition satisfies
                                if ( ( !$categoryType || ($orderItem['category_type'] !== $categoryType) ) || ( !$subType || ($orderItem['sub_type'] !== $subType) ) || ( !$gender || ($orderItem['gender'] !== $gender) ) || ( !$ageGroup || ($orderItem['age_group'] !== $ageGroup) ) || ( !is_array($variantIds) && in_array($orderItem['odoo_id'], $variantIds) ) ) {
                                    $isCouponCartApplicable = true;
                                    $data['items'][$key]['is_coupon_applicable'] = true;
                                    $total_amount += $orderItem['price_sale'] * $orderItem['quantity'];
                                    continue;
                                }
                                $data['items'][$key]['is_coupon_applicable'] = false;
                            }
                           break;

                         default:
                            return false;
                            break;
                        }
                      $isCouponCartApplicable = ($total_amount < $value)? false : $isCouponCartApplicable;
                      $data['is_specific_products_coupon']  = true;
                      $data['coupon_products_total_amount'] = $total_amount;
                     return $isCouponCartApplicable;
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
