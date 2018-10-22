@extends('layouts.default')

@section('content')
    
	<div class="container mt-0 mt-md-4">
		<div class="row">
			<div class="col-sm-12 col-lg-7">
				<div class="row center" >

					<div class="col-12 order-2 col-sm-12 col-md-12 order-sm-1 px-0 item">

						<img src="/img/arrow.png" class="swipe-arrow  d-block d-md-none">
						<div class="loader"></div>
						<ul id="aniimated-thumbnials" class="d-flex d-sm-block list-unstyled m-0 m-md-2 prod-slides hidden">

							<li class="mx-2 mb-2" >
								<a href="/img/3x/4front@3x.jpg" class="custom-selector">
									<img data-src="/img/1x/4front@1x.jpg" class="lazyload"  data-srcset="/img/1x/4front@1x.jpg 1x, /img/2x/4front@2x.jpg 2x" >

								</a>
							</li>
							<li class="mx-2 mb-2" >
								<a href="/img/3x/4focus@3x.jpg" class="custom-selector">
									<img data-src="/img/1x/4focus@1x.jpg" class="lazyload"  data-srcset="/img/1x/4focus@1x.jpg 1x, /img/2x/4focus@2x.jpg 2x" >

								</a>
							</li>
							<li class="mx-2 mb-2">
								<a href="/img/3x/4back@3x.jpg" class="custom-selector">
									<img data-src="/img/1x/4back@1x.jpg" class="lazyload"  data-srcset="/img/1x/4back@1x.jpg 1x, /img/2x/4back@2x.jpg 2x" >

								</a>
							</li>
								<li class="mx-2 mb-2">
								<a href="/img/3x/4back@3x.jpg" class=" custom-selector">
									<img data-src="/img/1x/4back.jpg" class="lazyload"  data-srcset="/img/1x/4back.jpg 1x, /img/2x/4back@2x.jpg 2x" >

								</a>
							</li>

						</ul>

					</div>
				</div>
				@php $selected_color_id = $params['selected_color_id']; @endphp
				@include('includes.singleproduct.productcolorselection', ['params' => $params, 'selected_color_id' => $selected_color_id])
			</div>
			<div class="col-sm-12 col-lg-5">
				@include('includes.breadcrumbs', ['params' => $params])
				<div class="d-flex">
					<div>
							<h1 class="kss-title mb-2 mb-sm-2 text-gray font-weight-bold">{{$params['title']}}</h1>
							@php

							if(isset($params['size'])) {
							    $default_price = set_default_price($params['variant_group']->{$selected_color_id}->variants, $params['size']);
					        }
					        else {
					        	$default_price = set_default_price($params['variant_group']->{$selected_color_id}->variants);
					        }

						    if($default_price['list_price'] == $default_price['sale_price']) { @endphp
								<h4 id="kss-price" class="kss-price">₹{{$default_price['sale_price']}}</h4>
							@php } else { @endphp
								<h4 id="kss-price" class="kss-price">₹{{$default_price['sale_price']}} <small class="kss-original-price text-muted">₹{{$default_price['list_price']}}</small> <span class="kss-discount text-danger">{{$default_price['discount_per']}}% OFF</span></h4>
							@php } @endphp
				
					</div>


				</div>

				<hr>
				
				
				
				

				<div class="d-flex justify-content-between mt-4">
					<label class="">Select Size (Age Group)</label>
					<!-- <a href="#sizeModal" class="font-weight-bold kss-link" data-toggle="modal" data-target="#sizeModal">Size Chart</a> -->

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
					      		<img src="/img/size_chart.png" class="img-fluid">
					      	</div>
					    </div>
					  </div>
					</div>

				</div>
				<div class="radio-wrap d-flex kss_sizes wo-image mb-4">
				    @php
				    foreach ($params['variant_group']->{$selected_color_id}->variants as $size_set) {
				    	if(isset($params['size'])) {
						    $price_set = get_price_set($size_set, $params['size']);
				        }
				        else {
				        	$price_set = get_price_set($size_set);
				        }
				    	@endphp
				    	<input class="d-none radio-input" type="radio" name="kss-sizes" id="size-{{$size_set->size->id}}" {{$price_set['checked']}} data-variant_id="{{$size_set->id}}" {{$price_set['disabled']}} data-list_price="{{$price_set['list_price']}}" data-sale_price="{{$price_set['sale_price']}}" data-discount_per="{{$price_set['discount_per']}}" data-title="{{$size_set->size->name}}"/>
					    <label class="radio-label" for="size-{{$size_set->size->id}}" title="{{$size_set->size->name}}">
					      <div class="radio-option">{{$size_set->size->name}}</div>
					    </label>
				    	@php
				     } @endphp
				</div>

				<div class="row">
					
					<div class="col-sm-12 col-md-12 col-12 mobile-fixed pb-2 ">
						
						<!-- <div class="row"> -->
							<!-- <div class="col-6 col-sm-6 col-md-6 col-xl-6 pr-1">
								<button class="btn btn-outline-secondary btn-lg btn-block">
									<div class="btn-label-initial"><i class="far fa-heart"></i> Save to Wishlist</div>
									<div class="btn-label-success"><i class="fas fa-arrow-right"></i> Go to Cart</div>
									<div class="btn-icon"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div>
								</button>
							</div> -->
							<!-- <div class="col-6 col-sm-6 col-md-6 col-xl-6 pl-1"> -->
								<button id="cd-add-to-cart" class="btn btn-primary btn-lg btn-block cd-add-to-cart" @php if(!isset($params['size'])) { @endphp disabled @php } @endphp>
									<div class="btn-label-initial d-flex align-items-center justify-content-center"><i class="kss_icon bag-icon-fill icon-sm"></i> Add to Bag</div>
									<div class="btn-label-success"><i class="fas fa-arrow-right"></i> Go to Bag</div>
									<div class="btn-icon"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div>
								</button>
							<!-- </div> -->
						<!-- </div> -->
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
				       		<p>{{$params['description']}}</p>
				    	</div>
				    </div>
				  </div>
				  <div class="">
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

							  <dt class="col-sm-2"><label class="text-muted f-w-4">Gender</label></dt>
							  <dd class="col-sm-10">{{$params['additional_info']->gender}}</dd>

							  <dt class="col-sm-2"><label class="text-muted f-w-4">Sleeves</label></dt>
							  <dd class="col-sm-10">{{$params['additional_info']->sleeves}}</dd>

							  <dt class="col-sm-2"><label class="text-muted f-w-4">Material</label></dt>
							  <dd class="col-sm-10">{{$params['additional_info']->material}}</dd>

							</dl>
				      	</div>
				    </div>
				  </div>
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
                  <img data-src="/img/normal/bluefront@1x.jpg" data-srcset="/img/normal/bluefront@1x.jpg 1x, /img/2x/bluefront@2x.jpg 2x" class="lazyload card-img-top" />
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
                  <img data-src="/img/normal/orangefront@1x.jpg" data-srcset="/img/normal/orangefront@1x.jpg 1x, /img/2x/orangefront@2x.jpg 2x" class="lazyload card-img-top" />
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
                        <img data-src="/img/normal/red1front@1x.jpg" data-srcset="/img/normal/red1front@1x.jpg 1x, /img/2x/red1front@2x.jpg 2x" class="lazyload card-img-top" />
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
                   <img data-src="/img/normal/redbluefront@1x.jpg"  data-srcset="/img/normal/redbluefront@1x.jpg 1x, /img/2x/redbluefront@2x.jpg 2x" class="lazyload card-img-top" />
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

	<div class="alert kss-alert sticky-alert d-inline-flex align-items-baseline px-sm-4 py-sm-4 px-3 py-3 fade show" role="alert">
	  <i class="fas fa-check pr-sm-3 pr-2 icon"></i>
	  <div class="message"></div>
	  <button type="button" class="close" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>

@stop

@section('footjs')

	<script type="text/javascript">
	    window.variants = @php echo json_encode($params['variant_group']); @endphp
	</script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
	<script type="text/javascript" src="/js/singleproduct.js"></script>

@stop