<!-- Order info -->
@foreach ($sub_orders as $sub_order)
<!-- Order shipped details -->
<div class="d-flex bd-highlight">
	<div class="pb-2 pr-2">
		<label class="d-block m-0">Sub Order {{$loop->iteration}}</label>
		@if(! empty($sub_order['store_address']))
			<span>Sold by: {{$sub_order['store_address']['store_name']}}</span>
		@endif
		<!-- <i class="fas fa-clipboard-check mr-1 text-muted"></i> <span class="text-success font-weight-bold">Order Processed</span> -->
	</div>
	<div class="pb-2 ml-auto">
<!-- 		Total:
		<h6 class="mt-1"><span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> {{$sub_order['total']}} for {{$sub_order['number_of_items']}} {{$sub_order['number_of_items'] == 1 ? "Item" : "Items"}}</h6> -->
		<h6 class="mt-1 text-right">{{$sub_order['number_of_items']}} {{$sub_order['number_of_items'] == 1 ? "Item" : "Items"}}</h6>
		<div>
			@if($sub_order['state'] == 'draft')
				<span class="order-label order-label--processing" data-toggle="tooltip" data-placement="top" title="Your order has been placed and the seller is verifying item availability in the inventory.">Processing</span>
			@endif
			@if($sub_order['state'] == 'sale')
				<span class="order-label order-label--confirmed" data-toggle="tooltip" data-placement="top" title="Stock for the items has been verified by the seller. Your items will be shipped out soon.">Confirmed</span>
			@endif
		</div>
	</div>
</div>

<!-- Actual order info -->
<div id="kss_shipment" class="card shadow-sm mt-2 mb-5">
	<div class="card-body">
		<div class="primary-info d-lg-flex d-xl-flex">
			<div class="kss_product_list flex-grow-1 pr-0 pr-md-4">
				@foreach( $sub_order['items'] as $item)
				@php
				$image_1x = $image_2x = $image_3x = CDN::asset('/img/placeholder.svg');
		    	if(count((array)$item['images'])>0){
		    		$image_1x = $item['images']['1x'];
		    		$image_2x = $item['images']['2x'];
		    		$image_3x = $item['images']['3x'];
		    	}
		    	@endphp
				<a href="/{{$item['product_slug']}}/buy?size={{$item['size']}}" class="text-black">
					<div class="product-img @php if(count((array)$item['images'])==0) { @endphp variant-placeholder @php } @endphp">
						<!-- <div class="img" style="background-image: url(https://jeromie.github.io/kss/img/4front.jpg);"></div> -->
                        <img src="{{$image_1x}}" class="lazyload img-fit" data-srcset="{{$image_1x}} 50w, {{$image_2x}} 100w, {{$image_3x}} 150w" sizes="50px">
					</div>
					<div class="product-detail">
						<div class="product-name text-truncate text-capitalize">
							{{$item['title']}}
						</div>
						<div class="product-size text-muted mb-1">
							<span>Size: {{$item['size']}}</span> <span>|</span> <span>Qty: {{$item['quantity']}}</span>
						</div>
						<div class="product-price">
							<div class="kss-price kss-price--smaller">₹{{$item['price_final']}}
								@if($item['price_final'] != $item['price_mrp'])
									<small class="kss-original-price text-muted">₹{{$item['price_mrp']}}
								  	</small>
								  	<span class="kss-discount text-danger">{{ calculateDiscount( $item['price_mrp'],$item['price_final']) }} % OFF</span>
							  	@endif

							</div>
						</div>
			<!-- 			<div class="product-price">
							<div class="retail-price">
								<span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span>
								<span class="price">{{$item['price_final']}}</span> 
							</div>
						</div> -->
					</div>
				</a>
				@if(!$loop->last)
					<hr class="mt-4 mb-4">
				@endif
				@endforeach
				

				<!--<div class="status-progress-wrap">
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
<!-- 
				<h6 class="mt-2">
					Your Order has been placed. We will update the tracking details for this item once it is shipped
				</h6> -->

				<!-- <h6 class="mt-3">
					Delivery Estimate: <strong class="font-weight-bold text-info">Arriving 30 Aug - 3 Sept </strong>
				</h6> -->
			</div>

			<!-- <div class="ml-auto mt-4 mt-md-0 col-12 col-xl-3 col-lg-3  p-0">
				<button type="button" class="btn btn-outline-dark btn-block">Cancel Item</button>
			</div> -->
		</div>
	</div>
</div>
@endforeach