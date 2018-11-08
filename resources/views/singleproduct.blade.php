@extends('layouts.default')

@section('headjs')
	@include('includes.abovethefold.singleproductcss')
@stop

@section('content')

	<div class="container mt-0 mt-md-4">
		<div class="row">
			<div class="col-sm-12 col-lg-7">
				<!-- Product Images -->
				@include('includes.singleproduct.productimages', ['params' => $params])

				@php $selected_color_id = $params['selected_color_id']; @endphp

				<!-- Product Color-selection Section -->
				@include('includes.singleproduct.productcolorselection', ['params' => $params, 'selected_color_id' => $selected_color_id])
			</div>
			<div class="col-sm-12 col-lg-5">
				<!-- Breadcrumbs -->
				@include('includes.breadcrumbs', ['breadcrumbs' => $params['breadcrumb']])

				<!-- Product Title & Prices Section -->
				@include('includes.singleproduct.producttitle', ['params' => $params, 'selected_color_id' => $selected_color_id])

				<hr>





				<div class="d-flex justify-content-between mt-4">
					<label class="">Select Size (Age Group)</label>
					<!-- Product Size Chart -->
					<!-- <a href="#sizeModal" class="font-weight-bold kss-link" data-toggle="modal" data-target="#sizeModal">Size Chart</a>

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
					</div> -->

				</div>
				<!-- Product Size Selection -->
				@include('includes.singleproduct.productsizes', ['params' => $params, 'selected_color_id' => $selected_color_id])

				<div class="row">

					<div class="col-sm-12 col-md-12 col-12 mobile-fixed pb-2 add-bag-btn">

						<!-- <div class="row"> -->
							<!-- <div class="col-6 col-sm-6 col-md-6 col-xl-6 pr-1">
								<button class="btn btn-outline-secondary btn-lg btn-block">
									<div class="btn-label-initial"><i class="far fa-heart"></i> Save to Wishlist</div>
									<div class="btn-label-success"><i class="fas fa-arrow-right"></i> Go to Cart</div>
									<div class="btn-icon"><i class="fas fa-circle-notch fa-spin fa-lg"></i></div>
								</button>
							</div> -->
							<!-- <div class="col-6 col-sm-6 col-md-6 col-xl-6 pl-1"> -->
								<button id="cd-add-to-cart" class="btn btn-primary btn-lg btn-block cd-add-to-cart" disabled>
									<div class="btn-label-initial d-flex align-items-center justify-content-center">Select Size</div>
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

				<!-- Details / Additional info / Reviews -->
				@include('includes.singleproduct.productdetails', ['params' => $params])

			</div>
		</div>
	</div>

	<!-- Similar Products -->
	@include('includes.similar-products')


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
	<script type="text/javascript" src="{{CDN::mix('/js/singleproduct.js') }}"></script>

@stop