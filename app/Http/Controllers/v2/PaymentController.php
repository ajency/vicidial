<?php

namespace App\Http\Controllers\v2;

use App\CashOnDelivery;
use App\Http\Controllers\Controller;
use App\Order;
use App\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tzsk\Payu\Facade\Payment;

class PaymentController extends Controller
{
    public function payment($orderid, $type)
    {
        $order = Order::find($orderid);
        $cart  = $order->cart;
        $user  = $cart->user;

        $order->checkInventoryForSuborders();
        $couponAvailability = $order->cart->checkCouponAvailability();
        if (!empty($couponAvailability['messages'])) {
            abort(400, array_values($couponAvailability['messages'])[0]);
        }

        switch ($type) {
            case 'payu':
                $attributes = [
                    'txnid'       => $order->txnid, # Transaction ID.
                    'amount'      => $order->subOrderData()['you_pay'], # Amount to be charged.
                    'productinfo' => $order->id,
                    'firstname'   => $user->name, # Payee Name.
                    'email'       => $user->email_id, # Payee Email Address.
                    'phone'       => $user->phone, # Payee Phone Number.
                ];

                $order->status = 'payment-in-progress';
                //status update
                $expires_at        = Carbon::now()->addMinutes(config('orders.payu_expiry'));
                $order->expires_at = $expires_at->timestamp;
                $order->save();
                $order->updateOrderlineIndex(['status']);

                return Payment::with($order)->make($attributes, function ($then) use ($orderid) {
                    $then->redirectTo('/user/order/' . $orderid . '/payment/payu/status');
                });
                break;

            case 'cod':
                //return redirect('/user/order/' . $orderid . '/payment/cod/status');
                return $this->status($orderid, $type);
                break;

            default:
                abort(400, 'Payment Type Not Available');
                break;
        }
    }

    public function status($orderid, $type)
    {
        $order = Order::find($orderid);

        try {
            switch ($type) {
                case 'payu':
                    $payment = Payment::capture();
                    if ($order->status != 'payment-in-progress') {
                        abort(400);
                    }

                    if ($payment->isCaptured()) {
                        $order->status           = 'payment-successful';
                        $order->transaction_mode = 'Prepaid';
                        $order->save();
                        $order->placeOrderOnOdoo();
                        request()->session()->flash('payment', "success");
                        $cart       = $order->cart;
                        $cart->type = 'order-complete';
                        $cart->save();
                        $new_cart   = $order->cart->user->newCart(false, $cart);
                        $user_token = getTokenID($_COOKIE['token']);
                        DB::table('oauth_access_tokens')->where('id', $user_token)->update(['cart_id' => $new_cart->id]);
                        $order->sendSuccessEmail();
                        $order->sendSuccessSMS();
                        $order->sendVendorSMS();
                    } else {
                        $order->status = 'payment-failed';
                        $order->save();
                        request()->session()->flash('payment', "failure");
                    }
                    break;

                case 'cod':
                    $order->status           = 'cash-on-delivery';
                    $order->transaction_mode = 'COD';
                    $order->save();
                    $order->placeOrderOnOdoo();
                    request()->session()->flash('payment', "cod");
                    $cart       = $order->cart;
                    $cart->type = 'order-complete';
                    $cart->save();
                    $new_cart   = $order->cart->user->newCart(false, $cart);
                    $user_token = getTokenID($_COOKIE['token']);
                    DB::table('oauth_access_tokens')->where('id', $user_token)->update(['cart_id' => $new_cart->id]);
                    $order->sendSuccessEmail();
                    $order->sendSuccessSMS();
                    $order->sendVendorSMS();
                    break;

                default:
                    abort(400, 'Payment Type Not Available');
                    break;
            }
            $order->updateOrderlineIndex(['status', 'transaction_mode']);
        } catch (\Exception $e) {
            \Log::notice('Order Success Method Failed');
            \Log::notice('Order id : ' . $orderid);
            sendEmail('failed-job', [
                'from'          => config('communication.failed-job.from'),
                'subject'       => 'Order Success Method Failed : ' . $type . ' [' . config('app.env') . ']',
                'template_data' => [
                    'queue'     => 'Order Success Method',
                    'job'       => 'Order Success Method',
                    'exception' => $e->getMessage(),
                    'body'      => 'Order id : ' . $orderid,
                    'trace'     => $e->getTraceAsString(),
                ],
                'priority'      => 'default',
            ]);
        }

        return redirect()->route('orderDetails', ['orderid' => $order->txnid]);
    }

    public function sendCODVerifySMS($id, Request $request)
    {
        $user  = $request->user();
        $order = Order::find($id);
        validateOrder($user, $order);
        checkCODServiceable($order->address->checkPincodeServiceable()["cod"]);

        $data      = $request->all();
        $validator = $this->validateNumber($data);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first(), 'success' => false, 'verified' => false]);
        }
        if ($data["token_verified"] && $data['phone'] == $user->phone) {
            return response()->json(["message" => "User verified successfully", 'success' => true, 'verified' => true]);
        } else {
            $otp                        = generateOTP();
            $otp_expiry                 = Carbon::now()->addMinutes(config('otp.cod_expiry'));
            $cashOnDelivery             = CashOnDelivery::firstOrNew(['order_id' => $id, 'phone' => $data['phone']]);
            $cashOnDelivery->otp        = $otp;
            $cashOnDelivery->otp_expiry = $otp_expiry->toDateTimeString();
            $cashOnDelivery->save();

            sendSMS('send-otp', [
                'to'      => '91' . $data['phone'],
                'message' => $otp . ' is the code required to verify your payment of Rs.' . $order->subOrderData()['you_pay'] . ' on kidsuperstore.in. The code will expire in ' . config('otp.cod_expiry') . ' minutes.',
            ], true);
        }
        $response = ["message" => "OTP Sent successfully", 'success' => true, 'verified' => false];
        return response()->json(isNotProd() ? array_merge($response, ['OTP' => $otp]) : $response);
    }

    public function reSendCODVerifySMS($id, Request $request)
    {
        $user  = $request->user();
        $order = Order::find($id);
        validateOrder($user, $order);

        $data      = $request->all();
        $validator = $this->validateNumber($data);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first(), 'success' => false]);
        }

        $cashOnDelivery = CashOnDelivery::where(['order_id' => $id, 'phone' => $data['phone']])->get()->first();
        if ($cashOnDelivery == null) {
            return response()->json(["message" => 'OTP not sent to this number. Please check the number.', 'success' => false]);
        }

        $otp_expiry                 = Carbon::now()->addMinutes(config('otp.cod_expiry'));
        $cashOnDelivery->otp_expiry = $otp_expiry->toDateTimeString();
        $cashOnDelivery->save();

        sendSMS('send-otp', [
            'to'      => '91' . $data['phone'],
            'message' => $cashOnDelivery->otp . ' is the code required to verify your payment of Rs.' . $order->subOrderData()['you_pay'] . ' on kidsuperstore.in. The code will expire in ' . config('otp.cod_expiry') . ' minutes.',
        ], true);

        $response = ["message" => "OTP Sent successfully", 'success' => true];
        return response()->json(isNotProd() ? array_merge($response, ['OTP' => $cashOnDelivery->otp]) : $response);
    }

    public function verifyOTP($id, Request $request)
    {
        $order = Order::find($id);
        $order->checkInventoryForSuborders();

        $data      = $request->all();
        $validator = $this->validateOTP($data);
        if ($validator->fails()) {
            return response()->json(["message" => $validator->errors()->first(), 'success' => false]);
        }

        $cashOnDelivery = CashOnDelivery::where(['order_id' => $id, 'phone' => $data['phone']])->get()->first();
        if ($cashOnDelivery == null) {
            return response()->json(["message" => 'OTP not sent to this number. Please check the number.', 'success' => false]);
        }

        if ((new Carbon($cashOnDelivery->otp_expiry))->timestamp < Carbon::now()->timestamp) {
            return response()->json(["message" => 'The entered OTP is Expired. Please send OTP again.', 'success' => false]);
        }

        if ($cashOnDelivery->otp != $data['otp']) {
            return response()->json(["message" => 'The entered OTP is invalid. Please try again.', 'success' => false]);
        }

        return response()->json(["message" => "OTP match successful", 'success' => true]);
    }

    public function validateOTP($data)
    {
        return $validator = Validator::make($data, [
            'phone' => 'required|digits:10',
            'otp'   => 'required|digits:' . config('otp.length'),
        ]);
    }

    public function validateNumber($data)
    {
        return $validator = Validator::make($data, [
            'phone' => 'required|digits:10',
        ]);
    }

    public function notifyPayment($status, Request $request)
    {
        //\Log::info('payumoney_webhook_content: '.json_encode($request->getContent()));
        //\Log::info('payumoney_webhook_header: '.json_encode($request->header()));
        $request_params = $request->getContent();
        NotifyPayment::dispatch($request_params)->onQueue('notify_payment');
        return response()->json(['success' => true], 200);
    }

    public function orderPayment($id, $type)
    {
        $order = Order::find($id);
        $cart  = $order->cart;
        $user  = $cart->user;

        $order->checkInventoryForSuborders();
        $couponAvailability = $order->cart->checkCouponAvailability();
        if (!empty($couponAvailability['messages'])) {
            abort(400, array_values($couponAvailability['messages'])[0]);
        }
        try {
            switch ($type) {
                case 'payu':
                    $attributes = [
                        'txnid'       => $order->txnid, # Transaction ID.
                        'amount'      => $order->subOrderData()['you_pay'], # Amount to be charged.
                        'productinfo' => $order->id,
                        'firstname'   => $user->name, # Payee Name.
                        'email'       => $user->email_id, # Payee Email Address.
                        'phone'       => $user->phone, # Payee Phone Number.
                    ];

                    $order->status              = 'payment-in-progress';
                    $order->payment_in_progress = true;
                    $expires_at                 = Carbon::now()->addMinutes(config('orders.payu_expiry'));
                    $order->expires_at          = $expires_at->timestamp;
                    $order->save();
                    $order->updateOrderlineIndex(['status']);

                    return Payment::with($order)->make($attributes, function ($then) use ($order->id) {
                        //$then->redirectTo('/user/order/' . $orderid . '/payment/payu/status');
                    });
                    break;

                case 'cod':
                    $order->status           = 'cash-on-delivery';
                    $order->transaction_mode = 'COD';
                    $order->save();
                    $order->placeOrderOnOdoo();
                    request()->session()->flash('payment', "cod");
                    $cart       = $order->cart;
                    $cart->type = 'order-complete';
                    $cart->save();
                    $new_cart   = $order->cart->user->newCart(false, $cart);
                    $user_token = getTokenID($_COOKIE['token']);
                    DB::table('oauth_access_tokens')->where('id', $user_token)->update(['cart_id' => $new_cart->id]);
                    $order->sendSuccessEmail();
                    $order->sendSuccessSMS();
                    $order->sendVendorSMS();
                    break;
                default:
                    abort(400, 'Payment Type Not Available');
                    break;
            }
            $order->updateOrderlineIndex(['status', 'transaction_mode']);
        } catch (\Exception $e) {
            \Log::notice('Order Success Method Failed');
            \Log::notice('Order id : ' . $order->id);
            sendEmail('failed-job', [
                'from'          => config('communication.failed-job.from'),
                'subject'       => 'Order Success Method Failed : ' . $type . ' [' . config('app.env') . ']',
                'template_data' => [
                    'queue'     => $event->job->getQueue(),
                    'job'       => 'Order Success Method',
                    'exception' => $e->getMessage(),
                    'body'      => 'Order id : ' . $order->id,
                    'trace'     => $e->getTraceAsString(),
                ],
                'priority'      => 'default',
            ]);
        }
        return response()->json(['txnid' => $order->txnid]);
    }
}
