@extends('layouts.default')

@section('headjs')

@stop

@section('content')

	<div class="container mt-3 order-details">
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

				<div class="d-flex  align-self-center mb-4">
					<label>
						Need help with this order? <a href="#" class="kss-anchor">Visit our help center</a>
					</label>
				</div>

			</div>

			<!-- Order Info sidebar -->
			@include('includes.orderdetails.orderstats-sidebar', ['payment_info' => (!empty($params['payment_info']))? $params['payment_info'] : [], 'shipping_address' => $params['shipping_address'], 'order_summary' => $params['order_summary'] ])

		</div>

	</div>

	<!-- Similar Products -->
	{{-- @include('includes.similar-products') --}}

@stop
@section('footjs')
	@yield('order-msg')
	@if(! empty($params['payment_status']))
		@if($params['payment_status'] == 'success')
			<script type="text/javascript">
				var total = {{$params['order_info']['total_amount']}};
				@php $variant_ids = []; @endphp
				@foreach($params['sub_orders'] as $sub_order)
					@foreach($sub_order['items'] as $item)
						@php $variant_ids[] = $item['product_id'] . '-' . $item['product_color_id'] @endphp
					@endforeach
				@endforeach
				var content_ids = '{{implode(",",$variant_ids)}}';
				fbq('track', 'Purchase', {
				    value: total,
				    currency: 'INR',
				    content_ids: content_ids,
				    content_type: 'product_group',
				});
				// Google pixel tracking
				gtag('event', 'page_view', {
					'send_to': google_pixel_id,
					'ecomm_pagetype': 'purchase',
					'ecomm_prodid': content_ids,
					'ecomm_totalvalue': total,
					'user_id': getCookie('user_id')
				});
			</script>
		@endif	
	@endif
@stop