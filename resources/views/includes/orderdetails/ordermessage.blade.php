<!--Order success failure messages -->

<div class="alert {{$status == 'success' ? 'alert-warning' : 'alert-danger'}}  mb-4 mt-2">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	</button>
	@if($status == 'success')
	<div>
	<h4 class="font-weight-bold text-success mb-3"><i class="fas fa-check-circle"></i> Order Confirmed</h4>
	<h4 class="font-weight-bold"> Thank you for shopping at kidsuperstore.in</h4>
	<p>Your order has been placed and is being processed, When the item are shipped you will receive an email with the details </p>
	Easily track all Kidsuperstore Orders!
	</div>
	@endif
	@if($status == 'failure')
	<div>
	<h4 class="font-weight-bold">Payment Failed</h4>
	<p>We could not process your payment. This could be due to the following reasons :</p>
	1. The CVV or Expiry Date might be wrong
	2. Your banck network might be down
	3. You have cancelled the transaction
	</div>
	@endif
</div>