<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tzsk\Payu\Facade\Payment;
use Carbon\Carbon;

class PaymentController extends Controller
{
    public function payment($orderid)
    {
    	$order = Order::find($orderid);
    	$cart = $order->cart;
    	$user = $cart->user;

    	$order->status = 'payment-in-progress';
    	$expires_at = Carbon::now()->addMinutes(config('orders.payu_expiry'));
        $order->expires_at = $expires_at->timestamp;
    	$order->save();

    	$attributes = [
		    'txnid' => strtoupper(str_random(8)).str_pad($order->id, 6, '0', STR_PAD_LEFT);, # Transaction ID.
		    'amount' => $order->aggregateSubOrderData()['final_price'], # Amount to be charged.
		    'productinfo' => "Kids Products",
		    'firstname' => "", # Payee Name.
		    'email' => "", # Payee Email Address.
		    'phone' => $user->phone, # Payee Phone Number.
		];

		return Payment::make($attributes, function ($then) use ($orderid) {
		    $then->redirectTo('/user/order/'.$orderid.'/payment/payu/status');
		});
    }

    public function status($orderid)
    {
    	$payment = Payment::capture();

		$order = Order::find($orderid);

		if($payment->isCaptured() && $order->status == 'payment-in-progress') {
			$order->status = 'payment-successful';
			$order->save();
			$request->session()->flash('payment', true);
		}
		elseif($order->status == 'payment-in-progress') {
			$order->status = 'payment-failed';
			$order->save();
			$request->session()->flash('payment', false);
		}

		//return redirect('account/order-details');
    }
}
