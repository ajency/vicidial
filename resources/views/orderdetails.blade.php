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
					@include('includes.orderdetails.ordermessage', ['status' => $params['payment_status'], 'order_info' => $params['order_info'] ])
				@endif

				<hr class="mb-4">

				<!-- Order info -->
					@include('includes.orderdetails.orderinfo', ['order_info' => $params['order_info']])
				<hr class="mb-4">

				<!-- Product info -->
				@include('includes.orderdetails.order', ['items' => $params['items']])

				<div class="d-flex  align-self-center mb-4">
					<label>
						Need help with this order? <a href="#" class="kss-anchor">Visit our help center</a>
					</label>
				</div>

			</div>

			<!-- Order Info sidebar -->
			@include('includes.orderdetails.orderstats-sidebar', ['payment_info' => (!empty($params['payment_info']))? $params['payment_info'] : [], 'shipping_address' => $params['shipping_address'], 'order_summary' => $params['order_summary'], 'amount_due' => $params['order_info']['amount_due'], 'order_status' => $params['order_info']['order_status'] ])

		</div>

	</div>

	<!-- Similar Products -->
	{{-- @include('includes.similar-products') --}}

@stop
@section('footjs')
	@yield('order-msg')
	@if(! empty($params['payment_status']))
		@if($params['payment_status'] == 'success' || $params['payment_status'] == 'cod')
			<script type="text/javascript">
				@php $variant_ids = []; $variant_qty = []; $contents = ''; @endphp
				@foreach($params['items'] as $item)
					@php $variant_ids[] = $item['product_id'] . '-' . $item['product_color_id'];
						 $variant_qty[] = ["id" => $item['product_id'] . '-' . $item['product_color_id'], "quantity" => $item['quantity']];
					@endphp
				@endforeach
				@php $contents = json_encode($variant_qty); @endphp
				console.log("contents ==>",JSON.parse('{{$contents}}'));
				fbq('track', 'Purchase', {
				    value: {{$params['order_info']['total_amount']}},
				    currency: 'INR',
				    contents: JSON.parse('{{$contents}}'),
				    content_ids: '{{implode(",",$variant_ids)}}'
				});
				// Google pixel tracking
				gtag('event', 'page_view', {
					'send_to': "{{config('analytics.google_pixel_id')}}",
					'ecomm_pagetype': 'purchase',
					'ecomm_prodid': new Array({{implode(",",$variant_ids)}}),
					'ecomm_totalvalue': {{$params['order_info']['total_amount']}},
					'user_id': getCookie('user_id')
				});
				// Google Conversion tracking
				gtag('event', 'conversion', {
			      'send_to': "AW-{{config('analytics.conversion_id')}}/{{config('analytics.conversion_label')}}",
			      'value': {{$params['order_info']['total_amount']}},
			      'currency': 'INR',
			      'transaction_id': '{{$params['order_info']['txn_no']}}'
			  });

				// Analytics ecommerce purchase event
				gtag('event', 'purchase', {
					"send_to": "{{config('analytics.google_id')}}",
					"transaction_id": '{{$params['order_info']['txn_no']}}',
					"value": {{$params['order_info']['total_amount']}},
					"currency": "INR"
				});



			</script>
		@endif	
	@endif
@stop