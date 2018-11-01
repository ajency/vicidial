@extends('layouts.default')

@section('content')

	<div class="container mt-3">
		<div class="row">
			<div class="col-12">
				<div class="d-none d-md-block mb-4">
					   <nav aria-label="breadcrumb">
	                    <ol class="breadcrumb mb-1 bg-transparent p-0">
	                        <li class="breadcrumb-item"><a href="#">Home</a></li>
	                        <li class="breadcrumb-item"><a href="/kss/account/orders/">Accounts</a></li>
	                        <li class="breadcrumb-item active"><a href="#">Order Details</a></li>
	                    </ol>
	                  </nav>
                 </div>
                 <div >
                  <div class="d-flex align-items-top top-navbar">
	<!-- 	            <div class="pr-3">
		            	<a href="/kss/account/orders/">
		              <h4 id="back-to-orders" class="m-0 font-weight-bold kss_highlight">
		                <img class="btn-back kss_highlight" src="https://jeromie.github.io/kss/img/left-arrow.png" style="width:20px;"/>
		              </h4>
		          </a>
		            </div> -->
		            <div class="">
		              <h4 class="font-weight-bold m-0">Order Details</h4>
		            </div>
		             <div class="ml-auto d-none d-md-block">
		              <button type="button" class="btn btn-outline-dark"><i class="fas fa-print"></i> Print Invoice</button>
		            </div>
		          </div>
		       
		      </div>
              
			</div>
		</div>
		<div class="row mt-md-2 mt-0">

			<div class="col-12 col-xl-8 col-lg-8">
				<div class="alert alert-warning">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					    <span aria-hidden="true">&times;</span>
					</button>
					<h4 class="font-weight-bold text-success mb-3"><i class="fas fa-check-circle"></i> Order Confirmed</h4>
					<h4 class="font-weight-bold"> Thank you for shopping at kidssuperstore.com</h4>
					<p>Your order has been placed and is being processed, When the item are shipped you will receive an email with the details </p>
		
					Easily track all Kidsuperstore Orders!
				</div>
				<hr>
				<div class="row justify-content-end">
					<div class="col">
						Order No.
					  	<h6 class="font-weight-bold mt-1 ">#1234-1234-3434</h6>
					</div>
					<div class="col">
						Total amount:
					  	<h6 class="font-weight-bold mt-1 "><span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 2,519 for 3 items </h6>
					</div>
					<div class="col-xl-2 col-sm-3  mt-3 mt-md-0">
						Placed on:
					  	<h6 class="font-weight-bold mt-1 "><i class="far fa-calendar-alt"></i> 20 Aug 2018 </h6>
					</div>

				</div>
				
					<hr class="mb-5">
					<div class="d-flex bd-highlight">
					  <div class="pb-2 pr-2">
					  	<label class="d-block m-0">Shipment 1 of 1 Item</label>

					  	<i class="fas fa-clipboard-check mr-1 text-muted"></i> <span class="text-success font-weight-bold">Order Processed</span>
					  </div>
					  <div class="pb-2 ml-auto">
					  	Total:
					  	<h6 class="mt-1"><span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 869 for 1 item</h6>
					  </div>
					</div>
				  <div id="kss_shipment" class="card shadow-sm mt-2 mb-5">
				  <div class="card-body">
				    <div class="primary-info d-lg-flex d-xl-flex">
					
					<div class="kss_product_list flex-grow-1 pr-0 pr-md-4">
						<a href="/kss/product/" class="text-black">
							<div class="product-img">
										<div class="img" style="background-image: url(https://jeromie.github.io/kss/img/4front.jpg);"></div>
									</div>
									<div class="product-detail">
										<div class="product-name text-truncate">
											Cotton Rich Super Skinny Fit Jeans
										</div>
										<div class="product-size text-muted mb-1">
											<span>Size: 2-4 years</span> <span>|</span> <span>Qty: 1</span>
										</div>
										<div class="product-price">
											<div class="retail-price">
												<span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> <span class="price">869</span>
											</div>
										</div>
									
									</div>
									</a>
<!-- 								<div class="status-progress-wrap">
										  <div  class="status-progress-bar-wrap">
										    <div style="width:10%;" class="status-progress-bar">
										    </div>
										  </div>  
										  <div class="status-wrap active">
										    Ordered		
										  </div>
										  <div class="status-wrap text-light">
										    Packed
										  </div>
										  <div class="status-wrap text-light">
										    Shipped
										  </div>
										  <div class="status-wrap text-light">
										    Delivered
										  </div>
									</div> -->
									<h6 class="mt-2">Your Order has been placed. We will update the tracking details for this item once it is shipped</h6>
										<h6 class="mt-3">Delivery Estimate: <strong class="font-weight-bold text-info">Arriving 30 Aug - 3 Sept </strong></h6>
					</div>
					<div class="ml-auto mt-4 mt-md-0 col-12 col-xl-3 col-lg-3  p-0">
						<button type="button" class="btn btn-outline-dark btn-block">Cancel Item</button>
					</div>

					</div>

				  </div>
				</div>

				<div class="d-flex bd-highlight">
					  <div class="pb-2 pr-2">
					  	<label class="d-block m-0">Shipment 2 of 2 Items</label>

					  	<i class="fas fa-clock mr-1 text-muted"></i><span class="text-success font-weight-bold">Order Processing</span>
						<span class="font-weight-bold">(Today)</span>
					  </div>
					  <div class="pb-2 ml-auto">
					  	Total:
					  	<h6 class="mt-1"><span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 869 for 2 items</h6>
					  </div>
					</div>
					  <div id="kss_shipment" class="card shadow-sm mt-2 mb-5">
				  <div class="card-body">
				    <div class="primary-info d-lg-flex  d-xl-flex">
					
					<div class="kss_product_list flex-grow-1 pr-0 pr-md-4">
						<a href="/kss/product/" class="text-black">
							<div class="product-img">
										<div class="img" style="background-image: url(https://jeromie.github.io/kss/img/4front.jpg);"></div>
									</div>
									<div class="product-detail">
										<div class="product-name text-truncate">
											Cotton Rich Super Skinny Fit Jeans
										</div>
										<div class="product-size text-muted mb-1">
											<span>Size: 2-4 years</span> <span>|</span> <span>Qty: 1</span>
										</div>
										<div class="product-price">
											<div class="retail-price">
												<span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> <span class="price">869</span>
											</div>
										</div>
									
									</div>
								</a>
								<hr class="mt-4 mb-4">
								<a href="/kss/product/" class="text-black">
									<div class="product-img">
										<div class="img" style="background-image: url(https://jeromie.github.io/kss/img/4front.jpg);"></div>
									</div>
									<div class="product-detail">
										<div class="product-name text-truncate">
											Cotton Rich Super Skinny Fit Jeans
										</div>
										<div class="product-size text-muted mb-1">
											<span>Size: 2-4 years</span> <span>|</span> <span>Qty: 1</span>
										</div>
										<div class="product-price">
											<div class="retail-price">
												<span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> <span class="price">869</span>
											</div>
										</div>
									
									</div>
									</a>
<!-- 									<div class="status-progress-wrap">
										  <div  class="status-progress-bar-wrap">
										    <div style="width:90%;" class="status-progress-bar">
										    </div>
										  </div>  
										  <div class="status-wrap active">
										    Ordered		
										  </div>
										  <div class="status-wrap active">
										    Packed
										  </div>
										  <div class="status-wrap active">
										    Shipped
										  </div>
										  <div class="status-wrap text-light">
										    Delivered
										  </div>
									</div> -->
									<h6 class="mt-2">Your Item is <strong>out for delivery</strong> and will arrive today (updated 10 mins ago)</h6>
										<h6 class="mt-3">Delivery Estimate: <strong class="font-weight-bold text-info">Arriving Today </strong></h6>
					</div>
					<div class="ml-auto mt-4 mt-md-0 col-12 col-xl-3 col-lg-3 p-0">
						<button type="button" class="btn btn-outline-dark btn-block">Cancel Item</button>
						<!-- <button type="button" class="btn btn-primary btn-block"><i class="fas fa-map-marker-alt"></i> Track Shipment</button> -->
					</div>

					</div>

				  </div>
				</div>
				<div class="d-flex  align-self-center mb-4">
				<label><i class="fas fa-question-circle fa-1x "></i> Need help with this order? <a href="#">Visit our help center</a></label>
				</div>
			</div>
			
			<div class="col-12 col-xl-4 col-lg-4">
                 <label class="">Payment Information</label>
                 <div class="card shadow-sm">
				  <div class="card-body text-muted d-flex">
				    Payment Mode:<i class="icon-master-card mr-1 ml-1"></i> <strong>ending in 1333</strong> 

				  </div>
				</div>

				 <label class="mt-4">Shipping Address</label>
                 <div class="card shadow-sm">
				  <div class="card-body">
				  
									<h3 class="kss-title font-weight-bold text-muted">Amit Shah</h3>
								<p class="text-muted">
									Maharaja Sayaji Gaikwad Udyog Bhawan Survey Number 152-152, Pune, Maharashtra 411007
								</p>
								<p class="text-muted">
									Mobile: <b class="font-weight-bold">+91 8407917773</b>
								</p>
						
				  </div>
				</div>
				<label class="mt-4">Order Summary</label>
                 <div class="card shadow-sm">
				  <div class="card-body">

      <div class="d-flex justify-content-between py-1">
        <div>
          <label class="text-muted f-w-4 m-0">
            Order Total
          </label>
        </div>
        <div> 
        	<span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 1309
        </div>
      </div>

      <div class="d-flex justify-content-between py-1">
        <div><label class="text-muted f-w-4 m-0">Shipping Fee</label></div>
        <div class="text-success">- <span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 100</div>
      </div>

<!--       <div class="d-flex justify-content-between py-1">
        <div><label class="text-muted f-w-4 m-0">Estimated Tax</label></div>
        <div><span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 180</div>
      </div>
      <div class="d-flex justify-content-between py-1">
        <div><label class="text-muted f-w-4 m-0">Coupon Discount</label></div>
        <div class="text-success">- <span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 20</div>
      </div> -->

<!--     <div class="d-flex justify-content-between py-1">
      <div>
        <label class="text-muted f-w-4 m-0">
          Order Total 
        </label>
      </div>
      <div> <span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 1029 </div>
    </div> -->
<!--     <div class="d-flex justify-content-between py-1">
      <div><label class="text-muted f-w-4 m-0">Shipping Fee</label></div>
      <div class=""><span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> 100</div>
    </div> -->
    <hr class="dashed">
    <div class="cd-cart-total pb-0">
    <h5 class="font-weight-bold">Total <span><i class="fas fa-rupee-sign"></i> 2,519</span></h5>
  </div>
  </div>
 
   </div>


	<div class="card shadow-sm mt-3">
	  <div class="card-body text-success d-flex">
	    <strong>Your Total Savings on this Order is <i class="fas fa-rupee-sign sm-font"></i></span> 452</strong>

	  </div>
	</div>


				  </div>
				</div>
	

			</div>



@stop