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
    if(empty($data['items'])) {
      return false;
    }
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
          $value         = $this->value['value'];
          $variantIds    = $this->value['variant'];
          $gender        = $this->value['facet']['gender'];
          $subType       = $this->value['facet']['sub_type'];
          $ageGroup      = $this->value['facet']['age_group'];
          $categoryType  = $this->value['facet']['category_type'];

           switch ($this->filter) {
               case 'greater_than':
                   $total_amount = 0;
                   $boolIsValid = false;
                   switch ($this->value['activity']) {
                       case 'include':
                            foreach ($data['items'] as $key => $orderItem) {
                                $isCouponApplicable = true;
                                // Check for each item in the cart if condition satisfies
                                if ( $categoryType && !empty($orderItem['category_type']) && ($orderItem['category_type'] != $categoryType) ) {
                                    $isCouponApplicable = false;
                                }
                                if ( $subType && !empty($orderItem['sub_type']) && ($orderItem['sub_type'] != $subType) ) {
                                    $isCouponApplicable = false;
                                }
                                if ( $gender && !empty($orderItem['gender']) && ($orderItem['gender'] != $gender) ) {
                                    $isCouponApplicable = false;
                                }
                                if ( $ageGroup && !empty($orderItem['age_group']) && ($orderItem['age_group'] != $ageGroup) ) {
                                    $isCouponApplicable  = false;
                                }
                                // Except listed variant ID from category
                                if( is_array($variantIds) && in_array($orderItem['odoo_id'], $variantIds) ){
                                    $isCouponApplicable = false;
                                }
                                $boolIsValid |= $isCouponApplicable;
                                $data['items'][$key]['is_coupon_applicable'] = $isCouponApplicable;

                                $total_amount += ( $isCouponApplicable )? $orderItem['price_sale'] * $orderItem['quantity'] : 0;
                            }
                            $boolIsValid = ($total_amount < $value)? false : $boolIsValid;
                            $data['is_specific_products_coupon']  = $boolIsValid;
                            $data['coupon_products_total_amount'] = $total_amount;
                           return $boolIsValid;
                           break;
                       
                       case 'exclude':
                            foreach ($data['items'] as $key => $orderItem) {
                                $isCouponApplicable = true;
                                // Check for each item in the cart if condition satisfies
                                if ( $categoryType && !empty($orderItem['category_type']) && ($orderItem['category_type'] == $categoryType) ) {
                                    $isCouponApplicable = false;
                                }
                                if ( $subType && !empty($orderItem['sub_type']) && ($orderItem['sub_type'] == $subType) ) {
                                    $isCouponApplicable = false;
                                }
                                if ( $gender && !empty($orderItem['gender']) && ($orderItem['gender'] == $gender) ) {
                                    $isCouponApplicable = false;
                                }
                                if ( $ageGroup && !empty($orderItem['age_group']) && ($orderItem['age_group'] == $ageGroup) ) {
                                    $isCouponApplicable  = false;
                                }
                                // Except listed variant ID
                                if( is_array($variantIds) && in_array($orderItem['odoo_id'], $variantIds) ){
                                    $isCouponApplicable = true;
                                }
                                $boolIsValid |= $isCouponApplicable;
                                $data['items'][$key]['is_coupon_applicable'] = $isCouponApplicable;

                                $total_amount += ( $isCouponApplicable )? $orderItem['price_sale'] * $orderItem['quantity'] : 0;
                            }
                            $boolIsValid = ($total_amount < $value)? false : $boolIsValid;
                            $data['is_specific_products_coupon']  = $boolIsValid;
                            $data['coupon_products_total_amount'] = $total_amount;
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
