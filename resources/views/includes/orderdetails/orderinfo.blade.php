<div class="row justify-content-end">
	<div class="col-6 col-md-3">
		Order No.
	  	<h6 class="font-weight-bold mt-1 ">{{$order_info['txn_no']}}</h6>
	</div>
	<div class="col-6 col-md-3">
		Total amount:
	  	<h6 class="font-weight-bold mt-1 "><span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span>{{$order_info['total_amount']}}</h6>
	</div>
	<div class="col-6 col-md-3">
		Placed on:
	  	<h6 class="font-weight-bold mt-1 "><i class="far fa-calendar-alt"></i> {{$order_info['order_date']}} </h6>
	</div>
	<div class="col-6 col-md-3">
		Mode of payment
		@if($order_info['order_status'] =='payment-successful')
	  	<h6 class="font-weight-bold mt-1 ">Card Payment <!-- - <span class="text-success payment-status">PAID</span> --></h6>
	  	@endif
	  	@if($order_info['order_status'] =='payment-failed' || $order_info['order_status'] =='payment-in-progress')
	  	<h6 class="font-weight-bold mt-1 ">Card Payment - 
	  		@if($order_info['order_status'] =='payment-in-progress')
		  		<span  class="text-warning payment-status">PENDING</span> 
	  		@endif
	  		@if($order_info['order_status'] =='payment-failed')
		  		<span class="text-danger payment-status">FAILED</span> 
	  		@endif
	  	</h6>
	  	@endif
	</div>
</div>