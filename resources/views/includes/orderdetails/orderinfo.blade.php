<div class="row justify-content-end">
	<div class="col">
		Order No.
	  	<h6 class="font-weight-bold mt-1 ">{{$order_info['txn_no']}}</h6>
	</div>
	<div class="col">
		Total amount:
	  	<h6 class="font-weight-bold mt-1 "><span class="rs-symbol"><i class="fas fa-rupee-sign sm-font"></i></span>{{$order_info['total_amount']}} for {{$order_info['no_of_items']}} {{$order_info['no_of_items'] == 1 ? "item" : "items"}} </h6>
	</div>
	<div class="col-xl-2 col-sm-3  mt-3 mt-md-0">
		Placed on:
	  	<h6 class="font-weight-bold mt-1 "><i class="far fa-calendar-alt"></i> {{$order_info['order_date']}} </h6>
	</div>
</div>