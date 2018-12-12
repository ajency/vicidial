<!-- Order Details sidebar start -->
<div class="col-12 col-xl-4 col-lg-4">
   @if(!empty($payment_info) and $payment_info['payment_mode'] and $payment_info['card_num'])
      <label class="">Payment Information</label>

      <!-- Payment Info/Mode -->
      
      <div class="card shadow-sm">
            <div class="card-body text-muted d-flex">
               Payment Mode:<i class="mr-1 ml-1 {{ $payment_info['payment_mode'] == 'MAST' ? 'icon-master-card' : ( $payment_info['payment_mode'] == 'VISA' ? 'icon-visa' : ($payment_info['payment_mode'] == 'rupay' ? 'icon-rupay' : 'far fa-credit-card no-card ') ) }} "></i> <strong>ending in {{substr($payment_info['card_num'], -4)}}</strong>
            </div>
      </div>
   @endif

   <!-- Shipping Address -->
   <label class="mt-4">Shipping Address</label>
   <div class="card shadow-sm">
      <div class="card-body">
         <h3 class="kss-title font-weight-bold text-muted">{{$shipping_address['name']}}</h3>
         <p class="text-muted">
            {{$shipping_address['address']}}, {{$shipping_address['locality']}}, @if($shipping_address['landmark']!=""){{$shipping_address['landmark']}},@endif {{$shipping_address['city']}}, {{$shipping_address['state']}} {{$shipping_address['pincode']}}
         </p>
         <p class="text-muted">
            Mobile: <b class="font-weight-bold">+91 {{$shipping_address['phone']}}</b>
         </p>
      </div>
   </div>

   <!-- Order summary -->
   <label class="mt-4">Order Summary</label>
   <div class="card shadow-sm">
      <div class="card-body">
         <div class="d-flex justify-content-between py-1">
            <div>
               <label class="text-muted f-w-4 m-0">
               Total Item Price
               </label>
            </div>
            <div> 
               <span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> {{$order_summary['mrp_total']}}
            </div>
         </div>

         <div class="d-flex justify-content-between py-1">
            <div>
               <label class="text-muted f-w-4 m-0">Sub Total</label>
            </div>
            <div class="text-success">
               <span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> {{$order_summary['sale_price_total']}}
            </div>
         </div>

         <div class="d-flex justify-content-between py-1">
            <div>
               <label class="text-muted f-w-4 m-0">Coupon Discount</label>
            </div>
            <div class="text-success">
               - <span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> {{$order_summary['cart_discount']}}
            </div>
         </div>

         <div class="d-flex justify-content-between py-1">
            <div>
               <label class="text-muted f-w-4 m-0">Shipping</label>
            </div>
            <div class="text-success">
               - <span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> {{$order_summary['shipping_fee']}}
            </div>
         </div>

<!--          <div class="d-flex justify-content-between py-1">
            <div>
               <label class="text-muted f-w-4 m-0">Estimated Tax</label>
            </div>
            <div>
               <span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 180
            </div>
         </div>

         <div class="d-flex justify-content-between py-1">
            <div>
               <label class="text-muted f-w-4 m-0">Coupon Discount</label>
            </div>
            <div class="text-success">
               - <span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 20
            </div>
         </div> 

         <div class="d-flex justify-content-between py-1">
            <div>
               <label class="text-muted f-w-4 m-0">
                  Order Total 
               </label>
            </div>
            <div>
               <span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span>1029
            </div>
         </div>

         <div class="d-flex justify-content-between py-1">
            <div>
               <label class="text-muted f-w-4 m-0">Shipping Fee</label>
            </div>
            <div class="">
               <span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 100
            </div>
         </div> -->

         <hr class="dashed">
         <div class="cd-cart-total pb-0">
            <h5 class="font-weight-bold">
               Total <span><i class="fas fa-rupee-sign"></i> {{$order_summary['you_pay']}}</span>
            </h5>
         </div>
      </div>
   </div>

   <!-- Total savings -->
   @if($order_summary['mrp_total'] != $order_summary['you_pay'])
      <div class="card shadow-sm mt-3">
         <div class="card-body text-success d-flex">
            <strong>Your Total Savings on this Order is <i class="fas fa-rupee-sign sm-font pl-1"></i></span> {{$order_summary['mrp_total'] - $order_summary['you_pay']}}</strong>
         </div>
      </div>
   @endif
</div>