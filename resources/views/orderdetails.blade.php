@extends('layouts.default')

@section('content')

	<div class="container mt-3">
		<div class="row">
			<div class="col-12">
				<div class="d-none d-md-block mb-4">
					<!-- Breadcrumbs -->
					 @include('includes.breadcrumbs', ['breadcrumbs' => $params['breadcrumb']])
                 </div>
                 <div >
                  <div class="d-flex align-items-top top-navbar">
					<!--<div class="pr-3">
		            	<a href="/kss/account/orders/">
		              <h4 id="back-to-orders" class="m-0 font-weight-bold kss_highlight">
		                <img class="btn-back kss_highlight" src="https://jeromie.github.io/kss/img/left-arrow.png" style="width:20px;"/>
		              </h4>
		          </a>
		            </div> -->
		            <div class="">
		              <h4 class="font-weight-bold m-0">Order Details</h4>
		            </div>
		            <!--  <div class="ml-auto d-none d-md-block">
		              <button type="button" class="btn btn-outline-dark"><i class="fas fa-print"></i> Print Invoice</button>
		            </div> -->
		          </div>
		      </div>
              
			</div>
		</div>
		<div class="row mt-md-2 mt-0">

			<div class="col-12 col-xl-8 col-lg-8">
				<!-- Order Message -->
				@if(! empty($params['payment_status']))
					@include('includes.orderdetails.ordermessage', ['status' => $params['payment_status']])
				@endif
					
				<hr class="mb-4">

				<!-- Order info -->
					@include('includes.orderdetails.orderinfo', ['order_info' => $params['order_info']])
				<hr class="mb-4">

				<!-- Product info -->
				@include('includes.orderdetails.order', ['sub_orders' => $params['sub_orders']])

				<div class="d-flex  align-self-center">
					<label>
						<i class="fas fa-question-circle fa-1x "></i> Need help with this order? <a href="#">Visit our help center</a>
					</label>
				</div>

			</div>
			
			<!-- Order Info sidebar -->
			@include('includes.orderdetails.orderstats-sidebar', ['payment_info' => $params['payment_info'], 'shipping_address' => $params['shipping_address'], 'order_summary' => $params['order_summary'] ])

		</div>
	
	</div>

	<!-- Similar Products -->
	{{-- @include('includes.similar-products') --}}

@stop