<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tzsk\Payu\Facade\Payment;
use Carbon\Carbon;
use App\Order;

class PaymentController extends Controller
{
    public function payment($orderid)
    {
    	$order = Order::find($orderid);
    	$cart = $order->cart;
    	$user = $cart->user;

    	$order->checkInventoryForSuborders();

    	$attributes = [
		    'txnid' => $order->txnid, # Transaction ID.
		    'amount' => $order->aggregateSubOrderData()['final_price'], # Amount to be charged.
		    'productinfo' => $order->id,
		    'firstname' => $user->name, # Payee Name.
		    'email' => $user->email, # Payee Email Address.
		    'phone' => $user->phone, # Payee Phone Number.
		];

    	$order->status = 'payment-in-progress';
    	$expires_at = Carbon::now()->addMinutes(config('orders.payu_expiry'));
        $order->expires_at = $expires_at->timestamp;
    	$order->save();

		return Payment::with($order)->make($attributes, function ($then) use ($orderid) {
		    $then->redirectTo('/user/order/'.$orderid.'/payment/payu/status');
		});
    }

    public function status($orderid)
    {
    	$payment = Payment::capture();
		$order = Order::find($orderid);
		if ($order->status != 'payment-in-progress') abort(400);

		if($payment->isCaptured()) {
			$order->status = 'payment-successful';
			$order->save();
			$order->placeOrderOnOdoo();
			request()->session()->flash('payment', "success");
			$cart = $order->cart;
			$cart->type = 'order-complete';
			$cart->save();
			$order->cart->user->newCart();

			sendEmail('order-complete', [
				'to' => $order->cart->user->email,
				'subject' => 'Order placed successfully on Kid Super Store',
				'template_data' => [
					'order' => $order,
				],
				'priority' => 'default',
			]);

			sendSMS('order-complete', [
				'to' => $order->cart->user->phone,
				'message' => 'Your order with order id <insert id here> for Rs. <enter total here> has been placed successfully on Kid Super Store',
			]);
		}else{
			$order->status = 'payment-failed';
			$order->save();
			request()->session()->flash('payment', "failure");
		}

		return redirect()->route('orderDetails', ['orderid' => $orderid]);
    }
}
