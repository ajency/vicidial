<!--Order success failure messages -->

<div class="alert {{$status == 'success' || $status == 'cod' ? 'alert-warning' : 'alert-danger'}}  mb-4 mt-2">
	
	@if($status == 'success' || $status == 'cod')
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	</button>
	<div>
		<h4 class="font-weight-bold text-success mb-3"><i class="fas fa-check-circle"></i> Order Confirmed</h4>
		<h4 class="font-weight-bold"> Thank you for shopping at kidsuperstore.in</h4>
		<p>Your order has been placed and is being processed, When the item are shipped you will receive an email with the details </p>
		Easily track all Kidsuperstore Orders!
	</div>
	@if($trackBackUrl != '')
	<iframe src="{{$trackBackUrl}}" height="1" width="1" frameborder="0"></iframe>
	@endif
	<iframe src="https://af0y.com/p.ashx?o=301&e=225&t={{$order_info['txn_no']}}&ect={{$order_info['total_amount']}}&p={{$order_info['total_amount']}}" height="1" width="1" frameborder="0"></iframe>

	<!-- Trade tracker iframe -->
	<iframe src="https://ts.tradetracker.net/?cid=30735&pid=47044&tgi=&tid={{$order_info['txn_no']}}&tam={{$order_info['total_amount']}}&descrMerchant={descrMerchant}&descrAffiliate={{$order_info['txn_no']}}&currency={currency}&data={{$order_info['txn_no']}}&vc={voucherCode}" height="1" width="1" frameborder="0"></iframe>
	@endif
	@if($status == 'failure')
	<button class="btn btn-primary retry-pay-btn">Retry Payment</button>
	<div>
		<h4 class="font-weight-bold failed-title"><i class="fas fa-times-circle"></i> Payment Failed</h4>
		<p class="mb-2 pt-3 pt-md-0">We could not process your payment. This could be due to the following reasons :</p>
		1. The CVV or Expiry Date might be wrong<br>
		2. Your bank network might be down<br>
		3. You have cancelled the transaction
	</div>
	@endif
</div>

@section('order-msg')
	<script type="text/javascript">
		var status = '<?php echo $status;?>';

		function getNewCartId(){
	        var url = "/api/rest/v2/user/cart/mine";
	        $.ajax({
	            url: url,
	            type: 'GET',
	            headers: {
	                        'Authorization': 'Bearer '+getCookie('token')
	                    },
	            data: {},
	            dataType: 'JSON',
	            success: function (data) {
	                    document.cookie = "cart_id=" + data.cart_id + ";path=/";
	                
	            },
	            error: function (request, status, error) {
	            	console.log("error");
	            }
	        });
	    }

		if(status == 'success' || status == 'cod'){
				getNewCartId();
				document.cookie = "cart_count=" + 0 + ";path=/";
				updateCartCountInUI();
				sessionStorage.removeItem('cart_data');
		}
		$(function(){
			$('.retry-pay-btn').click(function(){
				let url = window.location.href.split("#")[0] + '#/bag';
	       		window.location = url;	
			})
		})
		
	</script>
@stop