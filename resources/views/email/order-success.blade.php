@extends('layouts.email')
@section('content')
<pre>
@php 
	$orderDetails = $order->getOrderDetails();
	print_r($orderDetails);
@endphp
</pre>>
@endsection