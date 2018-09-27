@extends('layouts.default')

@section('sitetitle')
Single Product|Kidsuperstore
@stop

@section('content')
    
	<div class="container mt-0 mt-md-4">
		<div class="row">
			<div class="col-sm-12 col-lg-7">
				<div class="row center" >

					<div class="col-12 order-2 col-sm-12 col-md-12 order-sm-1 px-0 item">

						<img src="img/arrow.png" class="swipe-arrow  d-block d-md-none">
						<div class="loader"></div>
						<ul id="aniimated-thumbnials" class="d-flex d-sm-block list-unstyled m-0 m-md-2 prod-slides hidden">

							<li class="mx-2 mb-2" >
								<a href="img/3x/4front@3x.jpg" class="custom-selector">
									<img data-src="img/1x/4front@1x.jpg" class="lazyload"  data-srcset="img/1x/4front@1x.jpg 1x, img/2x/4front@2x.jpg 2x" >

								</a>
							</li>
							<li class="mx-2 mb-2" >
								<a href="img/3x/4focus@3x.jpg" class="custom-selector">
									<img data-src="img/1x/4focus@1x.jpg" class="lazyload"  data-srcset="img/1x/4focus@1x.jpg 1x, img/2x/4focus@2x.jpg 2x" >

								</a>
							</li>
							<li class="mx-2 mb-2">
								<a href="img/3x/4back@3x.jpg" class="custom-selector">
									<img data-src="img/1x/4back@1x.jpg" class="lazyload"  data-srcset="img/1x/4back@1x.jpg 1x, img/2x/4back@2x.jpg 2x" >

								</a>
							</li>
								<li class="mx-2 mb-2">
								<a href="img/3x/4back@3x.jpg" class=" custom-selector">
									<img data-src="img/1x/4back.jpg" class="lazyload"  data-srcset="img/1x/4back.jpg 1x, img/2x/4back@2x.jpg 2x" >

								</a>
							</li>

						</ul>

					</div>
				</div>
				<div class=" d-md-block mb-3">
					<div class="d-flex justify-content-between mt-3">
					<label class=""> <a  class="font-weight-bold kss-link" data-toggle="collapse" href="#color-options"  aria-expanded="false" aria-controls="color-options"><i class="fas fa-circle text-warning"></i> <i class="fas fa-circle text-info"></i> <i class="fas fa-circle text-success"></i> More color options</a></label>

				</div>
					<div class="collapse" id="color-options">
				  <div class="card card-body alert-light ">
				    <div class="radio-wrap w-image kss_variants ">
				    <input class="d-none radio-input" type="radio" name="kss-variants" id="green" checked="checked"/>
				    <label class="radio-label" for="green" style="background-image: url(img/thumbnail/6front@thumb.jpg)">
				      <div class="radio-option">green</div>
				    </label>
				    <input class="d-none radio-input" type="radio" name="kss-variants" id="yellow"/>
				    <label class="radio-label" for="yellow" style="background-image: url(img/thumbnail/1front@thumb.jpg)">
				      <div class="radio-option">yellow</div>
				    </label>
				    <input class="d-none radio-input" type="radio" name="kss-variants" id="blue"/>
				    <label class="radio-label" for="blue" style="background-image: url(img/thumbnail/3front@thumb.jpg)">
				      <div class="radio-option">blue</div>
				    </label>
				    <input class="d-none radio-input" type="radio" name="kss-variants" id="red"/>
				    <label class="radio-label" for="red" style="background-image: url(img/thumbnail/10front@thumb.jpg)">
				      <div class="radio-option">red</div>
				    </label>
				</div>
				  </div>
				</div>
			</div>
			</div>
			<div class="col-sm-12 col-lg-5">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb mb-1 bg-transparent p-0">
					    <li class="breadcrumb-item"><a href="#">Home</a></li>
					    <li class="breadcrumb-item"><a href="#">Boys</a></li>
					    <li class="breadcrumb-item active"><a href="#">Boys Shirts</a></li>
					</ol>
				</nav>
				<div class="d-flex">
					<div>
							<h1 class="kss-title mb-2 mb-sm-2 text-gray font-weight-bold">Cotton Rich Super Skinny Fit Jeans</h1>

				<h4 class="kss-price">₹869 <small class="kss-original-price text-muted">₹1309</small> <span class="kss-discount text-danger">20% OFF</span></h4>
				
					</div>


				</div>

				<hr>
				
				
				
				

				<div class="d-flex justify-content-between mt-4">
					<label class="">Select Size (Age Group)</label>
					<a href="#sizeModal" class="font-weight-bold kss-link" data-toggle="modal" data-target="#sizeModal">Size Chart</a>

					<div class="modal fade" id="sizeModal" tabindex="-1" role="dialog" aria-hidden="true">
					  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
					    <div class="modal-content">
					    	<div class="modal-header">
				    	        <h5 class="modal-title ml-auto">Size Chart</h5>
				    	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				    	          <span aria-hidden="true">&times;</span>
				    	        </button>
					    	</div>
					      	<div class="modal-body">
					      		<img src="img/size_chart.png" class="img-fluid">
					      	</div>
					    </div>
					  </div>
					</div>

				</div>
				<div class="radio-wrap d-flex kss_sizes wo-image mb-4">
				    <input class="d-none radio-input" type="radio" name="kss-sizes" id="18-24" checked="checked"/>
				    <label class="radio-label" for="18-24" title="18-24 months">
				      <div class="radio-option">18-24M</div>
				    </label>
				    <input class="d-none radio-input" type="radio" name="kss-sizes" id="1-2"/>
				    <label class="radio-label" for="1-2" title="1-2 years">
				      <div class="radio-option">1-2Y</div>
				    </label>
				    <input class="d-none radio-input" type="radio" name="kss-sizes" id="2-4" disabled="" />
				    <label class="radio-label" for="2-4" title="2-4 years">
				      <div class="radio-option">2-4Y</div>
				    </label>
				    <input class="d-none radio-input" type="radio" name="kss-sizes" id="4-8"/>
				    <label class="radio-label" for="4-8" title="4-8 years">
				      <div class="radio-option">4-8Y</div>
				    </label>
				     <input class="d-none radio-input" type="radio" name="kss-sizes" id="9-10"/>
				    <label class="radio-label" for="9-10" title="9-10 years">
				      <div class="radio-option">9-10Y</div>
				    </label>
				</div>

				<div class="row">
					
					<div class="col-sm-12 col-md-12 col-12 mobile-fixed pb-2 ">
						
						<div class="row">
							<div class="col-6 col-sm-6 col-md-6 col-xl-6 pr-1">
								<button class="btn btn-outline-secondary btn-lg btn-block">
									<div class="btn-label-initial"><i class="far fa-heart"></i> Save to Wishlist</div>
									<div class="btn-label-success"><i class="fas fa-arrow-right"></i> Go to Cart</div>
									<div class="btn-icon"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div>
								</button>
							</div>
							<div class="col-6 col-sm-6 col-md-6 col-xl-6 pl-1">
								<button class="btn btn-primary btn-lg btn-block cd-add-to-cart " data-price="869">
									<div class="btn-label-initial"><i class="fas fa-shopping-cart"></i> Add to Cart</div>
									<div class="btn-label-success"><i class="fas fa-arrow-right"></i> Go to Cart</div>
									<div class="btn-icon"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div>
								</button>
							</div>
						</div>
					</div>
				</div>

				<!-- <div class="alert alert-light my-4">
					<div class="d-flex justify-content-between">
						 <label class="text-body">
					 	<i class="fas fa-truck"></i> Check Delivery Options
					 	</label>
						<a class="font-weight-bold kss-link" data-toggle="collapse" href="#kss_pincode" role="button" aria-expanded="false" aria-controls="collapseExample">Add Pincode</a>
					</div>
					<div class="collapse mb-2 mt-4" id="kss_pincode">
					  	<form class="form-inline">
						   	<div class="form-group m-0 w-70">
                           		<input class="form-control form-control-lg" id="city" type="number">
                            	<label class="control-label">Check Pincode</label>
	                      	</div>
						  	<button type="submit" class="btn btn-primary mb-2 mt-2">Check</button>
						</form>
						<h6 class="text-dark mt-2 font-weight-bold">Delivery by 30 Aug, Thursday</h6>
						<br>
					</div>
				 	<p class="text-muted">Tax: Applicable tax on the basis of exact location & discount will be charged at the time of checkout</p>
				</div> -->

				<div class="accordion product-collapse" id="accordionExample">
				  <div class="">
				    <div class="collapse-head border-bottom mb-0" id="headingOne">
				        <button class="btn btn-link btn-block text-left py-3 px-0 br-0 " type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
					      	<label class="mb-0 text-body cursor-pointer">
					        	Details
					        </label>
				      	</button>
				    </div>

				    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
				    	<div class="card-body pb-2 px-0">
				       		<p>
				       			Blue and orange T-shirt, has a V-neck with a spread collar, short sleeves, DryCell technology for moisture management
				       		</p>
				       		<p>
								Bio-based Wicking finish
				       		</p>
				    	</div>
				    </div>
				  </div>
				  <!-- <div class="">
				    <div class="collapse-head border-bottom mb-0" id="headingTwo">
				        <button class="btn btn-link btn-block text-left py-3 px-0 br-0 collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
					    	<label class="mb-0 text-body cursor-pointer">
					        	Additional Info
					        </label>
				      	</button>
				    </div>
				    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
				      	<div class="card-body pb-2 px-0">
					     	<dl class="row">
							  <dt class="col-sm-2"><label class="text-muted f-w-4">Format</label></dt>
							  <dd class="col-sm-10">A description list is perfect for defining terms.</dd>

							  <dt class="col-sm-2"><label class="text-muted f-w-4">Collar</label></dt>
							  <dd class="col-sm-10">
							    <p>Vestibulum id ligula porta felis euismod semper eget lacinia odio sem nec elit.</p>
							  </dd>

							  <dt class="col-sm-2"><label class="text-muted f-w-4">Climate</label></dt>
							  <dd class="col-sm-10">Etiam porta sem malesuada magna mollis euismod.</dd>

							  <dt class="col-sm-2"><label class="text-muted f-w-4">Pattern</label></dt>
							  <dd class="col-sm-10">Etiam porta sem malesuada magna mollis euismod.</dd>

							  <dt class="col-sm-2"><label class="text-muted f-w-4">Sleeve</label></dt>
							  <dd class="col-sm-10">Etiam porta sem malesuada magna mollis euismod.</dd>

							  <dt class="col-sm-2"><label class="text-muted f-w-4">Gender</label></dt>
							  <dd class="col-sm-10">Etiam porta sem malesuada magna mollis euismod.</dd>

							   <dt class="col-sm-2"><label class="text-muted f-w-4">Material</label></dt>
							  <dd class="col-sm-10">Etiam porta sem malesuada magna mollis euismod.</dd>

							</dl>
				      	</div>
				    </div>
				  </div> -->
				  <!-- <div class="">
				    <div class="collapse-head border-bottom mb-0" id="headingThree">
				        <button class="btn btn-link btn-block text-left py-3 px-0 br-0 collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
				      		<label class="mb-0 text-body cursor-pointer">
				        		Reviews
				      		</label>
				    	</button>
				    </div>
				    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
				      <div class="card-body pb-2 px-0">
				        <blockquote class="blockquote mb-4">
						  <h6 class="mb-1"><strong>It fits perfect and he loved it.</strong></h6>
						  <footer class="blockquote-footer"><span class="badge badge-success"><i class="fas fa-star"></i> 4.5 </span> Seema Kothrud, Pune <cite title="Source Title">7 Jul, 2018</cite></footer>
						</blockquote>
						 <blockquote class="blockquote mb-4">
						  <h6 class="mb-1"><strong>I didn't realize you had clothes for 2T and they're super cute and affordable.</strong></h6>
						  <footer class="blockquote-footer"><span class="badge badge-success"><i class="fas fa-star"></i> 4.5 </span> Seema Kothrud, Pune <cite title="Source Title">7 Jul, 2018</cite></footer>
						</blockquote>

				      </div>
				    </div>
				  </div> -->
				</div>

			</div>
		</div>
	</div>

	
	<!-- <div id="similar" class="container">
		<hr class="mt-5">
		<h3 class="text-left my-4 font-weight-bold">Similar Products</h3>
	  <div id="card-list" class="row">
            <div class="col-lg-3 col-md-6 mb-4 col-6  ">
              <div class="card h-100 product-card">
              	<i class="fas fa-heart kss_heart"></i>
                <a href="/kss/product/" >
                  <div class="image oh loading loading-01">
                  <img data-src="img/normal/bluefront@1x.jpg" data-srcset="img/normal/bluefront@1x.jpg 1x, img/2x/bluefront@2x.jpg 2x" class="lazyload card-img-top" />
                 </div>
                </a>
                <div class="card-body">
                  <a href="/kss/product/" class="text-dark">
                    <h5 class="card-title">
                      Cotton Rich Super Skinny Fit Jeans
                    </h5>
                  </a>
                  <div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small><span class="kss-discount text-danger">20% OFF</span></div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 col-6  ">
           	  <div class="card h-100 product-card">
           	 		<i class="fas fa-heart kss_heart"></i>
                <a href="/kss/product/">
                   <div class="image oh loading loading-02">
                  <img data-src="img/normal/orangefront@1x.jpg" data-srcset="img/normal/orangefront@1x.jpg 1x, img/2x/orangefront@2x.jpg 2x" class="lazyload card-img-top" />
                </div>
                </a>
                <div class="card-body">
                  <a href="/kss/product/" class="text-dark">
                    <h5 class="card-title">
                      Cotton Rich Super Skinny Fit Jeans
                    </h5>
                  </a>
                  <div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small><span class="kss-discount text-danger">20% OFF</span></div>
                </div>
              </div>
            </div>

            <div class="col-lg-3 col-md-6 mb-4 col-6   ">
              <div class="card h-100 product-card">
              	<i class="fas fa-heart kss_heart"></i>
                <a href="/kss/product/">
                   <div class="image oh loading loading-03">
                        <img data-src="img/normal/red1front@1x.jpg" data-srcset="img/normal/red1front@1x.jpg 1x, img/2x/red1front@2x.jpg 2x" class="lazyload card-img-top" />
                    </div>
                </a>
                <div class="card-body">
                  <a href="/kss/product/" class="text-dark">
                    <h5 class="card-title">
                      Cotton Rich Super Skinny Fit Jeans
                    </h5>
                  </a>
                  <div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small><span class="kss-discount text-danger">20% OFF</span></div>
                </div>
              </div>
            </div>
                <div class="col-lg-3 col-md-6 mb-4 col-6 ">
              <div class="card h-100 product-card">
                <i class="fas fa-heart kss_heart"></i>
                <a href="/kss/product/">
                   <div class="image oh loading loading-04">
                   <img data-src="img/normal/redbluefront@1x.jpg"  data-srcset="img/normal/redbluefront@1x.jpg 1x, img/2x/redbluefront@2x.jpg 2x" class="lazyload card-img-top" />
                 </div>
                </a>
                <div class="card-body">
                  <a href="/kss/product/" class="text-dark">
                    <h5 class="card-title">
                      Cotton Rich Super Skinny Fit Jeans
                    </h5>
             	    </a>
                  <div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small><span class="kss-discount text-danger">20% OFF</span></div>
                </div>
              </div>
            </div>
        </div>
	</div> -->
<div class="seperator">
</div><div id="cd-shadow-layer"></div>

<div id="cd-cart">
	<div class="d-flex ">
		<div class="pr-3 align-items-center">
			<h3 class="modal-title font-weight-bold" >
            	<img class="btn-pay btn-back kss_highlight" src="img/left-arrow.png" style="width:20px;"/>
          	</h3>
		</div>
	  	<div class="align-items-center">
			<h3 class="modal-title font-weight-bold mt-1 mb-0">
				Cart <span class="text-muted "><strong>&#183;</strong></span>
				<small class="count text-muted ">2 items</small>
			</h3>
	  	</div>
	  	<div class="ml-auto align-self-center">
	 	 	<button class="btn btn-outline-secondary mt-1" >
                <i class="far fa-heart"></i> Wishlist
            </button>
	  	</div>
	</div>

	<hr class="mb-0">
	
	<ul class="cd-cart-items">
		<li>
			<div class="primary-info d-flex">
				<div class="product-img">
					<a href="/kss/product/">
						<div class="img" style="background-image: url(img/4front.jpg);"></div>
					</a>
				</div>
				<div class="product-detail">
					<a href="/kss/product/" class="kss-link kss_highlight">
						<label class="m-0">
						Cotton Rich Super Skinny Fit Jeans
					</label>
					</a>
					<div class="product-size text-muted ">
						<div class="d-flex flex-row">
						  <div class="size-qty align-self-center">
						  	<label class="m-0">Size:</label>
						  </div>
						  <div class="pl-2 pr-4 align-self-center">
						  	<select class="size form-control form-control-sm br-0  border-dark custom"  >
									<option>18-24M</option>
									<option selected="">1-2Y</option>
									<option>2-4Y</option>
									<option>4-8Y</option>
									<option>9-10Y</option>
								</select>
						  </div>
						  <div class="qty align-self-center">
						  	<label class="m-0">Qty:</label>
						  </div>
						  <div class="pl-2">
							<select class="size form-control form-control-sm br-0  border-dark custom"  >
									<option>1</option>
									<option>2</option>
									<option>3</option>
									<option>4</option>
								</select>
						  </div>
						</div>
					</div>
						<div class="product-price">
					<div class="kss-price kss-price--smaller">₹869 <small class="kss-original-price text-muted">₹1309</small> <span class="kss-discount text-danger">20% OFF</span></div>
				</div>
				</div>

				<div class="product-delete ml-2" title="Remove">
					<a href="#0" class="cd-item-remove delete d-block text-center">
						<i class="far fa-trash-alt"></i>
					</a>
				</div>
			</div>
		</li>

		<li class="out-of-stock">
			<div class="primary-info d-flex">
				<div class="product-img">
					<a href="/kss/product/" >
					<div class="img kss_disable" style="background-image: url(img/4front.jpg);"></div>
				</a>
				</div>
				<div class="product-detail">
					<a href="/kss/product/" class="kss-link kss_highlight">
						<label class="m-0">
							Cotton Rich Super Skinny Fit Jeans
						</label>
					</a>
					<div class="product-size text-muted ">
						<div class="product-quantity d-flex align-items-center">

							<div class="d-flex flex-row">
								<div class="size-qty align-self-center">
								  	<label class="m-0">Size:</label>
								</div>
								<div class="pl-2 pr-4 align-self-center">
								  	<select class="size form-control form-control-sm br-0  border-dark custom"  >
										<option>18-24M</option>
										<option>1-2Y</option>
										<option selected="" disabled="">2-4Y</option>
										<option>4-8Y</option>
										<option>9-10Y</option>
									</select>
								</div>
								<div class="qty align-self-center">
								  	<label class="m-0">Qty:</label>
								</div>
							  	<div class="pl-2">
									<select class="size form-control form-control-sm br-0  border-dark custom"  >
										<option>1</option>
										<option>2</option>
										<option>3</option>
										<option>4</option>
									</select>
							  	</div>
							</div>

						</div>
						<div class="product-price">
							<div class="kss-price kss-price--smaller text-danger-dark">Out of Stock</div>
						</div>
					</div>
				</div>
				<div class="product-delete ml-2" title="Remove">
					<a href="#0" class="cd-item-remove delete d-block text-center">
						<i class="far fa-trash-alt"></i>
					</a>
				</div>
			</div>
		</li>
	</ul>

	
	<div class="alert alert-light p-3 m-3 ">
		<div id="kss_coupon" class="d-flex">
			<div>
				<h5 class="f-w-4 text-muted m-0"><i class="fas fa-ticket-alt"></i>  Apply Code</h5>
			</div>
			<div class="ml-auto">
				<h5 class="m-0"><i class="fas fa-angle-right"></i></h5>
			</div>
		</div>
	</div>
	<hr>
	<div class="cart-summary mt-4">
		<h4 class="mb-1 font-weight-bold">Price Summary</h4>
		<p class="sub-text mb-3">Includes GST and all government taxes</p>

		<div class="d-flex justify-content-between py-1">
			<div><label class="text-muted f-w-4 m-0">Cart Total</label></div>
			<div> ₹1309 </div>
		</div>
		<div class="d-flex justify-content-between py-1">
			<div><label class="text-muted f-w-4 m-0">Cart Discount</label></div>
			<div class="text-success">- ₹440</div>
		</div>
		<div class="d-flex justify-content-between py-1">
			<div><label class="text-muted f-w-4 m-0">Estimated Tax</label></div>
			<div>₹180</div>
		</div>
		<div class="d-flex justify-content-between py-1">
			<div><label class="text-muted f-w-4 m-0">Coupon Discount</label></div>
			<div class="text-success">- ₹20</div>
		</div>
	</div>
	<hr class="dashed">
	<div class="cd-cart-total">
		<h5 class="font-weight-bold">Order Total <span>₹1029</span></h5>
		<p class="sub-text mb-3">Shipping charges will be added at checkout</p>
	</div>

	<div class="seperator mb-5"></div>

	<div id="kss_cart" class="p-3 ">
		<a  id="checkout" class="btn btn-primary btn-lg btn-block " data-toggle="modal" data-target="#signin">Checkout</a>
	</div><div class="slide-out" id="cd-coupon">
		<div class="d-flex pt-2 ">
				<div class="pr-3 align-items-center">
						<h3 class="modal-title font-weight-bold">
							<img class="btn-back kss_highlight cd-coupon-apply" src="img/left-arrow.png" style="width:20px;"/>
						</h3>
				</div>
				<div class="align-items-center">
						<h3 class="modal-title font-weight-bold mt-1 mb-0">
								Apply Coupon
						</h3>
				</div>
		</div>
		<hr class="mb-0">
				<div class="">
						<h4 class="mb-1 mt-4 font-weight-bold">
								Have a coupon code?
						</h4>
						<div class="form-group">
								<input class="form-control form-control-lg" id="frm-coupon" type="text">
										<label class="control-label">
												Enter coupon code
										</label>
								</input>
						</div>
						<div>
								<button class="btn btn-primary btn-lg btn-block cd-coupon-apply " data-price="869">
										<div class="btn-label-initial">
												Apply
										</div>
								</button>
						</div>
				</div>
		</hr>
</div><div class="modal fade" id="signin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content ">
      <div class="modal-body">

        <div class="state-1">
          <div class="d-flex align-items-center">
            <div class="pr-3">
              <h3  class="m-0 font-weight-bold kss_highlight" data-dismiss="modal" aria-label="Close">
                <img class="btn-back kss_highlight" src="img/left-arrow.png" style="width:20px;"/>
              </h3>
            </div>
            <div class="">
              <h3 class="modal-title font-weight-bold mt-1" id="exampleModalLabel"> Mobile Number</h3>
            </div>
          </div>

          <p class="sub-text w-75 mt-3">Your Shipping and payment details will be associated with this number</p>
          <form>
            <div class="form-group mb-0">
              <input type="number" class="form-control form-control-number form-control-lg" id="frm-mobile"  placeholder=" ">
              <label class="control-label">Enter Mobile Number</label>
            </div>
          </form>
          <div class="mt-3">
            <button type="button" class="btn btn-primary btn-block btn-lg btn-signin">Send OTP <i class="fas fa-angle-right mt-2 position-absolute r-0"></i></button>
          </div>
        </div>

        <div class="state-2 d-none">
          <div class="d-flex align-items-center">
            <div class="pr-3">
              <h3 class="modal-title font-weight-bold" id="exampleModalLabel">
                <img class="btn-back kss_highlight" src="img/left-arrow.png" style="width:20px;"/>
              </h3>
            </div>
            <div class="">
             <h3 class="modal-title font-weight-bold mt-1" id="exampleModalLabel">Verify Mobile</h3>
            </div>
          </div>

          <form class="mt-3">
            <div class="form-group text-center mb-0">
              <p >Enter the OTP sent to your number</p><h4 class="font-weight-bold m-0">+91 840791773 <i class="fas fa-pencil-alt number-edit"></i></h4>
              <input type="number" class="form-control form-control-number form-control-lg text-center mb-2" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="">
              <small> Resend OTP in 18 sec</small>
            </div>
          </form>
          <div class="mt-3">
            <button id="shipping-details" type="button" class="btn btn-primary  btn-block btn-lg btn-verify" data-toggle="modal" data-target="#checkout-flow">Verify <i class="fas fa-angle-right position-absolute r-0 mt-2"></i></button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div><div class="kss_shipping slide-out">
	<div class="scroll-container">
		<nav class="navbar navbar-dark bg-dark pt-3 pb-3 ">
			<div class="d-flex align-items-center w-100">
				<div class="">
					<a href="/kss/product/">
						 <img src="img/logo-kss.png" xpreview="img/logo-kss.png" class=" img-fluid m-0" width="180px">
				 </a>
				</div>
				<div class="ml-auto align-self-center">
					<h3 class="m-0 text-white kss_highlight btn-pay"><span aria-hidden="true">&times;</span></h3>
				</div>
			</div>
			
		</nav>
		<div class="py-3 px-3 padding-size">
			<div class="row no-gutter">
				<div class="col-8">
					<h3 class="modal-title font-weight-bold" id="exampleModalLabel">Ship To</h3>
				</div>
				<div class="col-4 text-right">
					<h6 class="text-muted mt-2">STEP: 1 / 3</h6>
				</div>
			</div>
			<hr>

			<div class="shipping-content">
				<div class="row">
					<div class="col-md-12">
						
						<div class="form-group ">
							<input class="form-control form-control-lg" id="names" type="text">
							<label class="control-label">Name*</label>
						</div>
					</div>
					<div class="col-md-12">
						<div class="form-group has-error ">
							<input class="form-control form-control-lg" id="mobile" type="text" for="inputError">
							 <label class="control-label" for="inputError">Mobile No*</label>
							 <small id="passwordHelpBlock" class="form-text text-danger">
							Please enter mobile number
							</small>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<input class="form-control form-control-lg" id="email-address" type="text">
							<label class="control-label">Email Address*</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group ">
							<textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
							<label class="control-label">Address*</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group ">
							<input class="form-control form-control-lg" id="pincode" type="text">
							<label class="control-label">Pincode*</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input class="form-control form-control-lg" id="locality" type="text">
							<label class="control-label">Locality/Town*</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="form-group ">
							<input class="form-control form-control-lg" id="citys" type="text">
							<label class="control-label">City District*</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-group">
							<input class="form-control form-control-lg" id="state" type="text">
							<label class="control-label">State*</label>
						</div>
					</div>
				</div>
				<div class="row mt-4">
					<div class="col-md-12">
						<div class="custom-control custom-checkbox">
							<input type="checkbox" class="custom-control-input" id="customCheck1">
							<label class="custom-control-label" for="customCheck1">Make this my default address</label>
						</div>
					</div>
				</div>
			</div>

			<div class="shipping-content-info">
				<div class="radio-wrap d-flex kss_sizes wo-image mb-4">
					<input class="d-none radio-input" type="radio" name="kss-sizes" id="address-1" checked="checked"/>
					<label class="radio-label w-100 border-bottom text-left" for="address-1" title="Pari Shah">
						<div class="radio-option">
						 <div class="radio-selection "> <i class="fas fa-check-circle"></i></div>
								<h3 class="kss-title font-weight-bold w-75">Pari Shah <i class="fas fa-pencil-alt number-edit"></i></h3>
								<p class="w-75">
									Maharaja Sayaji Gaikwad Udyog Bhawan Survey Number 152-152, Pune, Maharashtra 411007
								</p>
								<p class="w-75">
									Mobile: <b class="font-weight-bold">+91 9898388993</b>
								</p>
						</div>
					</label>

					<input class="d-none radio-input" type="radio" name="kss-sizes" id="address-2"/>
					<label class="radio-label w-100 text-left border-bottom" for="address-2" title="Amit Shah">
						<div class="radio-option">
							 <div class="radio-selection "> <i class="fas fa-check-circle"></i></div>
									<h3 class="kss-title font-weight-bold w-75">Amit Shah <i class="fas fa-pencil-alt number-edit"></i></h3>
								<p class="w-75">
									Maharaja Sayaji Gaikwad Udyog Bhawan Survey Number 152-152, Pune, Maharashtra 411007
								</p>
								<p class="w-75">
									Mobile: <b class="font-weight-bold">+91 8407917773</b>
								</p>
						</div>
					</label>
				</div>
				<button type="button" id="add-address" class="btn btn-outline-secondary btn-lg btn-block">Add A New Address</button>
			</div>

			<div class="seperator mt-2 mb-2"></div>

			<div class="fixed-bottom d-none pl-3 pr-3">
				<div class="row no-gutters px-2 py-2 shipping-state-1">
					<div class="col-6 text-center">
						<button type="button" class="shipping-details-save btn btn-lg btn-block btn-link text-dark mt-1 mb-1 ml-auto mr-auto ">Cancel</button>
					</div>
					<div class="col-6 text-center">
						<button type="button" class="shipping-details-save btn btn-lg btn-block btn-primary mt-1 mb-1 ml-auto mr-auto ">Save</button>
					</div>
				</div>
				 <div class="row no-gutters px-2 py-2 shipping-state-2">
					<div class="col-12 text-center">
						<button id="shipping-summary" type="button" class=" btn btn-lg btn-block btn-primary mt-1 mb-1">Proceed</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div><div class="kss_shipping_summary slide-out">
	<div class="scroll-container">
		<nav class="navbar navbar-dark bg-dark pt-3 pb-3 ">
			<div class="d-flex align-items-center w-100">
				<div class="">
					<a href="/kss/product/">
						 <img src="img/logo-kss.png" xpreview="img/logo-kss.png" class=" img-fluid m-0" width="180px">
				 </a>
				</div>
				<div class="ml-auto align-self-center">
					<h3 class="m-0 text-white kss_highlight btn-pay"><span aria-hidden="true">&times;</span></h3>
				</div>
			</div>
		</nav>

		<div class="mb-5 py-3 px-3 padding-size">
			<div class="row no-gutter">
				<div class="col-8">
					<h3 class="modal-title font-weight-bold" id="exampleModalLabel">Shipping Summary</h3>
				</div>
				<div class="col-4 text-right">
					<h6 class="text-muted mt-2">STEP: 2 / 3</h6>
				</div>
			</div>
			<hr>
			
			<ul class="cd-cart-items list-unstyled mt-3">
			  <li class="p-0 pb-2">
			    <div class="primary-info d-flex">
			      <div class="product-img">
			        <div class="img" style="background-image: url(img/thumbnail/6front@thumb.jpg);"></div>
			      </div>
			      <div class="product-detail">
			        <label class="m-0 mt-2">
			          Cotton Rich Super Skinny Fit Jeans
			        </label>
			        <div class="product-size text-muted ">
			         <p class="sub-text mt-3">Estimated Delivery <b class="text-dark">23 Aug 2018</b></p>
			        </div>
			      </div>
			    </div>
			  </li>
			 	<li class="p-0 pb-2 pt-2">
			    <div class="primary-info d-flex">
			      <div class="product-img">
			        <div class="img" style="background-image: url(img/thumbnail/6front@thumb.jpg);"></div>
			      </div>
			      <div class="product-detail">
			        <label class="m-0 mt-2">
			          Cotton Rich Super Skinny Fit Jeans
			        </label>
			        <div class="product-size text-muted ">
			         <p class="sub-text mt-3">Estimated Delivery <b class="text-dark">23 Aug 2018</b></p>
			        </div>
			      </div>
			    </div>
			  </li>
			</ul>

			<div class="cart-summary mt-4">
			  <h4 class="mb-1 font-weight-bold">Price Summary</h4>
			  <p class="sub-text mb-3">Includes GST and all government taxes</p>

			  <div class="d-flex justify-content-between py-1">
			    <div>
			    	<label class="text-muted f-w-4 m-0">
			    		Cart Total
			    	</label>
			    </div>
			    <div> ₹1309 </div>
			  </div>
			  <div class="" id="cart-details">
			    <div class="d-flex justify-content-between py-1">
			      <div><label class="text-muted f-w-4 m-0">Cart Discount</label></div>
			      <div class="text-success">- ₹440</div>
			    </div>
			    <div class="d-flex justify-content-between py-1">
			      <div><label class="text-muted f-w-4 m-0">Estimated Tax</label></div>
			      <div>₹180</div>
			    </div>
			    <div class="d-flex justify-content-between py-1">
			      <div><label class="text-muted f-w-4 m-0">Coupon Discount</label></div>
			      <div class="text-success">- ₹20</div>
			    </div>
			  </div>
			  <div class="d-flex justify-content-between py-1">
			    <div>
			    	<label class="text-muted f-w-4 m-0">
			    		Order Total
			    	</label>
			    </div>
			    <div> ₹1029 </div>
			  </div>
			  <div class="d-flex justify-content-between py-1">
			    <div><label class="text-muted f-w-4 m-0">Shipping Fee</label></div>
			    <div class="">₹100</div>
			  </div>
			</div>
			<hr class="dashed">
			<div class="cd-cart-total">
			  <h5 class="font-weight-bold">Total <span>₹1129</span></h5>
			</div>
		</div>

		<div class="fixed-bottom d-none pl-3 pr-3">
		  <div class="row no-gutters px-2 py-2">
	      <div class="col-12 text-center">
	          <button id="payment-details" type="button" class=" btn btn-lg btn-block btn-primary mt-1 mb-1">Pay <span><strong>&#183;</strong></span> ₹1129</button>
	      </div>
		  </div>
		</div>

	</div>
</div><div class="kss_payment slide-out">
  <div class="scroll-container">
<nav class="navbar navbar-dark bg-dark pt-3 pb-3 position-sticky">
   <div class="d-flex align-items-center w-100">
        <div class="">
          <a href="/kss/product/">
         <img src="img/logo-kss.png" xpreview="img/logo-kss.png" class=" img-fluid m-0" width="180px">
       </a>
        </div>
        <div class="ml-auto align-self-center">
          <h3 class="m-0 text-white kss_highlight btn-pay"><span aria-hidden="true">&times;</span></h3>
        </div>
      </div>
</nav>
<div class="py-3 px-3">
    <div class="row no-gutter">
            <div class="col-8">
              <h3 class="modal-title font-weight-bold" id="exampleModalLabel">Payment</h3>
            </div>
            <div class="col-4 text-right">
                  <h6 class="text-muted mt-2">STEP: 3 / 3</h6>
            </div>
        </div>
        <hr>
         <div class="row no-gutter">
            <div class="col-8">
             <h4 class="font-weight-bold text-success">You Pay ₹1129</h4>
            </div>
            <div class="col-4 text-right">


            </div>
        </div>

        <div class="list-group mb-4 mt-4">
          <a href="#" class="list-group-item list-group-item-action">
                <div class="mt-1">

                  <label class="w-100 d-block">Pay Online
                     <img src="img/payu.png" xpreview="img/payu.png" class=" ml-2" width="40px" height="20px">

                     <i class="fas fa-angle-right float-right mt-2"></i>
                  </label>
                </div>
          </a>
          <a href="#" class="list-group-item list-group-item-action">
              <div class="mt-1">
              <label class="w-100 d-block">Cash on Delivery  <i class="fas fa-angle-right float-right mt-2"></i></label>
            </div>
          </a>
</div>
 <div class="cart-summary mt-5">
    <h4 class="mb-1 font-weight-bold">Price Summary</h4>
    <p class="sub-text mb-3">Includes GST and all government taxes</p>

    <div class="collapse" id="cart-details2">
      <div class="d-flex justify-content-between py-1">
        <div>
          <label class="text-muted f-w-4 m-0">
            Cart Total
          </label>
        </div>
        <div> ₹1309 </div>
      </div>
      <div class="d-flex justify-content-between py-1">
        <div><label class="text-muted f-w-4 m-0">Cart Discount</label></div>
        <div class="text-success">- ₹440</div>
      </div>
      <div class="d-flex justify-content-between py-1">
        <div><label class="text-muted f-w-4 m-0">Estimated Tax</label></div>
        <div>₹180</div>
      </div>
      <div class="d-flex justify-content-between py-1">
        <div><label class="text-muted f-w-4 m-0">Coupon Discount</label></div>
        <div class="text-success">- ₹20</div>
      </div>
    </div>
    <div class="d-flex justify-content-between py-1">
      <div>
        <label class="text-muted f-w-4 m-0">
          Order Total <a data-toggle="collapse" href="#cart-details2" role="button" aria-expanded="false" aria-controls="cart-details2" class="ml-2 font-weight-bold kss-link"><i class="fas fa-info-circle"></i>
          View Details</a>
        </label>
      </div>
      <div> ₹1029 </div>
    </div>
    <div class="d-flex justify-content-between py-1">
      <div><label class="text-muted f-w-4 m-0">Shipping Fee</label></div>
      <div class="">₹100</div>
    </div>
  </div>
  <hr class="dashed">
  <div class="cd-cart-total">
    <h5 class="font-weight-bold">Total <span>₹1129</span></h5>
  </div> 
   </div>
   </div>
</div></div>
<div class="modal fade dark-modal" id="loginModal" tabindex="-1" role="dialog" >
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header border-0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body px-5 pt-0 pb-1">

        
        <div class="sign-in-box active">
          <h3 class="modal-title text-center text-white mb-4">Sign in to Kidsuperstore.in</h3>
          <form>
            <ul class="list-group">
              <li class="list-group-item p-0">
                <input type="email" class="form-control form-control-lg border-0" required placeholder="Your Email Address">
              </li>
              <li class="list-group-item p-0">
                <input type="password" class="form-control form-control-lg border-0" required placeholder="Enter Password">
              </li>
            </ul>
            <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">Sign In</button>
          </form>
        </div>

        
        <div class="sign-up-box d-none">
          <h3 class="modal-title text-center text-white mb-4">Signup with Kidsuperstore.in</h3>
          <form>
            <ul class="list-group">
              <li class="list-group-item p-0">
                <input type="email" class="form-control form-control-lg border-0" required placeholder="Your Email Address">
              </li>
              <li class="list-group-item p-0">
                <input type="password" class="form-control form-control-lg border-0" required placeholder="Choose Password">
              </li>
              <li class="list-group-item p-0">
                <input type="tel" class="form-control form-control-lg border-0" required placeholder="Mobile Number">
              </li>
            </ul>
            <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">Register</button>
          </form>
        </div>

        
        <div class="reset-box d-none">
          <h3 class="modal-title text-center text-white mb-4">Forgot Password?</h3>
          <div class="text-white text-center mb-3">We will send you a link to reset your password.</div>
          <form>
            <ul class="list-group">
              <li class="list-group-item p-0">
                <input type="email" class="form-control form-control-lg border-0" required placeholder="Your Email Address">
              </li>
            </ul>
            <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">Send Reset Link</button>
          </form>
        </div>
        <hr class="mt-4">
      </div>

      <div class="modal-footer d-block small border-0 px-5 pb-5 pt-1">
        <div class="sign-in-box">
          <div class="d-flex flex-wrap justify-content-center justify-content-sm-between align-items-center">
            <a href="#" class="view-reset">Reset password</a>
            <div class="text-white">New to Kidsuperstore.in? <a href="#" class="view-signup">Create Account</a></div>
          </div>
        </div>
        <div class="sign-up-box d-none">
          <div class="text-white text-center">Already have an account? <a href="#" class="view-signin">Login!</a></div>
        </div>
        <div class="reset-box d-none">
          <div class="text-white text-center"><a href="#" class="view-signin">Login!</a></div>
        </div>
      </div>

    </div>
  </div>
</div><div class="overlay-fix" style="display:none;">
                </div>
	<a href="#" class="go-top">
		<div class="top-icon">
		</div>
		Go Top
	</a>

@stop