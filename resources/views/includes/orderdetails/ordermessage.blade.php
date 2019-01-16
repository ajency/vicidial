<!--Order success failure messages -->

<div class="alert {{$status == 'success' ? 'alert-warning' : 'alert-danger'}}  mb-4 mt-2">
	
	@if($status == 'success')
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	</button>
	<div>
		<h4 class="font-weight-bold text-success mb-3"><i class="fas fa-check-circle"></i> Order Confirmed</h4>
		<h4 class="font-weight-bold"> Thank you for shopping at kidsuperstore.in</h4>
		<p>Your order has been placed and is being processed, When the item are shipped you will receive an email with the details </p>
		Easily track all Kidsuperstore Orders!
	</div>
	@endif
	@if($status == 'failure')
	<a href="/#/bag" class="btn btn-primary close">Retry Payment</a>
	<div>
		<h4 class="font-weight-bold"><i class="fas fa-times-circle"></i> Payment Failed</h4>
		<p class="mb-2">We could not process your payment. This could be due to the following reasons :</p>
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
	        var url = "/api/rest/v1/user/cart/mine";
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

		if(status == 'success'){
				getNewCartId();
				document.cookie = "cart_count=" + 0 + ";path=/";
				updateCartCountInUI();
				sessionStorage.removeItem('cart_data');
		}
		
	</script>
@stop