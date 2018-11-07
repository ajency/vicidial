<!-- Order info -->
@foreach ($sub_orders as $sub_order)
<!-- Order shipped details -->
<div class="d-flex bd-highlight">
	<div class="pb-2 pr-2">
		<label class="d-block m-0">Shipment {{$sub_order['number_of_items']}} of {{$sub_order['number_of_items']}} {{$sub_order['number_of_items'] == 1 ? "Item" : "Items"}}</label>
		<i class="fas fa-clipboard-check mr-1 text-muted"></i> <span class="text-success font-weight-bold">Order Processed</span>
	</div>
	<div class="pb-2 ml-auto">
		Total:
		<h6 class="mt-1"><span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span> {{$sub_order['total']}} for {{$sub_order['number_of_items']}} {{$sub_order['number_of_items'] == 1 ? "Item" : "Items"}}</h6>
	</div>
</div>

<!-- Actual order info -->
<div id="kss_shipment" class="card shadow-sm mt-2 mb-5">
	<div class="card-body">
		<div class="primary-info d-lg-flex d-xl-flex">
			<div class="kss_product_list flex-grow-1 pr-0 pr-md-4">
				@foreach( $sub_order['items'] as $item)
				<a href="/kss/product/" class="text-black">
					<div class="product-img">
						<div class="img" style="background-image: url(https://jeromie.github.io/kss/img/4front.jpg);"></div>
					</div>
					<div class="product-detail">
						<div class="product-name text-truncate">
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
								  	<span class="kss-discount text-danger">{{ round((($item['price_mrp']- $item['price_final']) / ($item['price_mrp'])) * 100)}} % OFF</span>
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