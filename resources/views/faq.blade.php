@extends('layouts.default')

@section('headjs')

@stop

@section('content')

<!-- Banner -->
<div class="kss_banner_sm justify-content-center d-flex p-3 p-md-5 text-white bg-dark">
   <div class="align-self-center text-center">
      <h1 class="display-4 bold mt-4 mb-1 banner-title">FAQ</h1>
   </div>
</div>
<div class="container mt-3">
   <!-- Breadcrumbs -->
   <div class="row">
      <div class="col-12">
         <div class="mb-4">
            @include('includes.breadcrumbs', ['breadcrumbs' => $params['breadcrumb']])
         </div>
      </div>
   </div>
   <div class="row justify-content-center">
      <div class="col-sm-10">
         <div class="accordion product-collapse" id="accordionExample">

            <div class="">
               <div class="collapse-head border-bottom mb-0" id="headingOne">
                  <button class="btn btn-link btn-block text-left py-3 px-0 br-0 " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                     <h4 class="mb-0 text-body cursor-pointer font-weight-bold fz-sm white-space-normal">How do I place an order?</h4>
                  </button>
               </div>
               <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                  <div class="card-body pb-2 px-0">
                     <h5 class="mb-3 fz-sm">Please follow the following steps below to place your order</h5>
                     <ol>
                        <li class="h5 text-muted fz-sm line-height-5">
                           Explore your favourite online Shopping destination and select the product of your choice.
                           <img src="/img/faq/1.jpg" class="img-fluid my-3 shadow" title="Select product" alt="Select product">
                        </li>
                        <li class="h5 text-muted fz-sm line-height-5">
                           Select the desired, size and click on Add to bag. This will automatically open the bag.
                           <img src="/img/faq/2.jpg" class="img-fluid my-3 shadow" title="Add to Bag" alt="Add to Bag">
                        </li>
                        <li class="h5 text-muted fz-sm line-height-5">
                           Click on proceed to checkout.
                           <img src="/img/faq/3.jpg" class="img-fluid my-3 shadow" title="proceed to checkout" alt="proceed to checkout">
                        </li>
                        <li class="h5 text-muted fz-sm line-height-5">
                           Login to your account by entering your mobile number.
                           <img src="/img/faq/4.jpg" class="img-fluid my-3 shadow" title="Enter mobile" alt="Enter mobile">
                        </li>
                        <li class="h5 text-muted fz-sm line-height-5">
                           Enter the OTP received for your mobile number.
                        </li>
                        <li class="h5 text-muted fz-sm line-height-5">
                           Select the shipping address you want to ship your products to. Incase you are a first time user you will be prompted to add a new shipping address.
                           <img src="/img/faq/5.jpg" class="img-fluid my-3 shadow" title="Select Shipping" alt="Select Shipping">
                        </li>
                        <li class="h5 text-muted fz-sm line-height-5">
                           View your final order summary. Here you can edit your address. You will not be able to edit your bag details here. Hit Pay via PayU to continue paying via payment gateway.
                        </li>
                        <li class="h5 text-muted fz-sm line-height-5">
                           In PayU payment gateway, enter your email id first
                        </li>
                        <li class="h5 text-muted fz-sm line-height-5">
                           Then you can proceed to enter your card details to complete the payment. Please note PayU does not support RuPay cards. It supports MasterCard and Visa.
                        </li>
                     </ol>
                  </div>
               </div>
            </div>

            <div class="">
               <div class="collapse-head border-bottom mb-0" id="headingTwo">
                  <button class="btn btn-link btn-block text-left py-3 px-0 br-0 collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                  <h4 class="mb-0 text-body cursor-pointer font-weight-bold fz-sm white-space-normal">
                  How do I cancel an order?
                  </h4>
                  </button>
               </div>
               <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                  <div class="card-body pb-2 px-0">
                     <p class="h5 text-muted fz-sm line-height-5">
                        Please click here to cancel your order. <br>
                        Or you can also cancel your order by accessing the “My Orders” section under “My Account” of site and then select the item or order you want to cancel.
                     </p>
                  </div>
               </div>
            </div>

            <div class="">
               <div class="collapse-head border-bottom mb-0" id="headingThree">
                  <button class="btn btn-link btn-block text-left py-3 px-0 br-0 collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                     <h4 class="mb-0 text-body cursor-pointer font-weight-bold fz-sm white-space-normal">
                        How do I get a refund?
                     </h4>
                  </button>
               </div>
               <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                  <div class="card-body pb-2 px-0">
                     <p class="h5 text-muted fz-sm line-height-5">
                        After you have cancelled or returned your order your amount will be refunded to you within 7 working days or as may be specified per the terms and conditions. 
                     </p>
                  </div>
               </div>
            </div>

            <div class="">
               <div class="collapse-head border-bottom mb-0" id="headingFour">
                  <button class="btn btn-link btn-block text-left py-3 px-0 br-0 collapsed" type="button" data-toggle="collapse" data-target="#collapsefour" aria-expanded="false" aria-controls="collapsefour">
                     <h4 class="mb-0 text-body cursor-pointer font-weight-bold fz-sm white-space-normal">
                        How do I track my order?
                     </h4>
                  </button>
               </div>
               <div id="collapsefour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionExample">
                  <div class="card-body pb-2 px-0">
                     <p class="h5 text-muted fz-sm line-height-5">
                        Go to “My Orders” section in “My Account” of site and then select the item or order you want to track.
                     </p>
                  </div>
               </div>
            </div>
    
            <div class="">
               <div class="collapse-head border-bottom mb-0" id="headingFive">
                  <button class="btn btn-link btn-block text-left py-3 px-0 br-0 collapsed" type="button" data-toggle="collapse" data-target="#collapseFive" aria-expanded="true" aria-controls="collapseFive">
                     <h4 class="mb-0 text-body cursor-pointer font-weight-bold fz-sm white-space-normal">
                        What is your shipping and return policy?
                     </h4>
                  </button>
               </div>
               <div id="collapseFive" class="collapse " aria-labelledby="headingFive" data-parent="#accordionExample">
                  <div class="card-body pb-2 px-0">
                     <p class="h5 text-muted fz-sm line-height-5">
                        You can view our shipping and return policy here.
                     </p>
                  </div>
               </div>
            </div>

            <div class="">
               <div class="collapse-head border-bottom mb-0" id="headingSix">
                  <button class="btn btn-link btn-block text-left py-3 px-0 br-0 collapsed" type="button" data-toggle="collapse" data-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                     <h4 class="mb-0 text-body cursor-pointer font-weight-bold fz-sm white-space-normal">
                        What is your Privacy policy?
                     </h4>
                  </button>
               </div>
               <div id="collapseSix" class="collapse" aria-labelledby="headingSix" data-parent="#accordionExample">
                  <div class="card-body pb-2 px-0">
                     <p class="h5 text-muted fz-sm line-height-5">
                        You can view our privacy policy here.
                     </p>
                  </div>
               </div>
            </div>

            <div class="">
               <div class="collapse-head border-bottom mb-0" id="headingSeven">
                  <button class="btn btn-link btn-block text-left py-3 px-0 br-0 collapsed" type="button" data-toggle="collapse" data-target="#collapseSeven" aria-expanded="false" aria-controls="collapseSeven">
                     <h4 class="mb-0 text-body cursor-pointer font-weight-bold fz-sm white-space-normal">
                        How do I contact you?
                     </h4>
                  </button>
               </div>
               <div id="collapseSeven" class="collapse" aria-labelledby="headingSeven" data-parent="#accordionExample">
                  <div class="card-body pb-2 px-0">
                     <p class="h5 text-muted fz-sm line-height-5">
                        You can write to us at <a href="mailto:care@kidsuperstore.in">care@kidsuperstore.in</a> <br>
                        You can also contact us by submitting your query on the contact form <a href="/contact">here</a>.
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

@stop