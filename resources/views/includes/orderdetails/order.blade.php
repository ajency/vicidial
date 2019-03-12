<!-- Order info -->
@foreach ($items as $item)
<!-- Order shipped details -->
<div class="d-flex bd-highlight">
	<div class="pb-2 pr-2">
		<label class="d-block m-0">Item {{$loop->iteration}} of {{count($items)}}</label>
		@if(! empty($item['store_address']))
			<span>Sold by: {{$item['store_address']['store_name']}}</span>
		@endif
		<!-- <i class="fas fa-clipboard-check mr-1 text-muted"></i> <span class="text-success font-weight-bold">Order Processed</span> -->
	</div>
	<div class="pb-2 ml-auto col-5 text-right pl-0">
			<div *ngIf="showStatus" class="mt-4">
				@if($item['state'] == 'draft' && !$item['shipment_status'])
				<span class="order-label order-label--processing" data-toggle="tooltip" data-placement="top" title="Your order has been placed and we are verifying item availability in the inventory">Processing</span>
				@endif

				@if($item['state'] == 'cancel' ||  $item['shipment_status'] == 'cancelled')
				<span class="order-label order-label--cancelled" data-toggle="tooltip" data-placement="top" title="The item has been cancelled">Cancelled</span>
				@endif

				@if($item['state'] == 'processing-cancel')
				<span class="order-label order-label--processcancel" data-toggle="tooltip" data-placement="top" title="The item is being processed for cancellation">Processing Cancel</span>
				@endif

				@if($item['state'] == 'sale' && !$item['shipment_status'])
				<span class="order-label order-label--confirmed" data-toggle="tooltip" data-placement="top" title="Stock for the items has been verified and your items will be shipped out soon.">Confirmed</span>
				@endif

				@if($item['shipment_status'] == 'shipped')
				<span class="order-label order-label--shipped" data-toggle="tooltip" data-placement="top" title="Your item has been shipped and should reach you soon">Shipped</span>
				@endif

				@if($item['shipment_status']=='out for delivery')
				<span class="order-label order-label--outdelivery" data-toggle="tooltip" data-placement="top" title="Your item is out for delivery">Out for Delivery</span>
				@endif

				@if($item['shipment_status']=='delivered')
				<span class="order-label order-label--delivered" data-toggle="tooltip" data-placement="top" title="The item has been delivered">Delivered</span>
				@endif
			</div>
	</div>
</div>

<!-- Actual order info -->
<div id="kss_shipment" class="card shadow-sm mt-2 mb-5">
	<div class="card-body">
		<div class="primary-info d-lg-flex d-xl-flex">
			<div class="kss_product_list flex-grow-1 pr-0 pr-md-4">
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
				
			</div>

			<!-- <div class="ml-auto mt-4 mt-md-0 col-12 col-xl-3 col-lg-3  p-0">
				<button type="button" class="btn btn-outline-dark btn-block">Cancel Item</button>
			</div> -->
		</div>
	</div>
</div>
@endforeach