<?php

namespace App\Jobs;

use App\Order;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Tzsk\Payu\Model\PayuPayment;

class NotifyPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $response;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($response)
    {
        $this->response = $response;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $request_params = $this->response;
        $order          = Order::where('txnid', $request_params['merchantTransactionId'])->first();
        $payu_payment   = PayuPayment::create([
            'account'          => config('payu.default'),
            'payable_id'       => $order->id,
            'payable_type'     => get_class($order),
            'txnid'            => $order->txnid,
            'mihpayid'         => $request_params['paymentId'],
            'firstname'        => $request_params['customerName'],
            'email'            => $request_params['customerEmail'],
            'phone'            => $request_params['customerPhone'],
            'amount'           => $request_params['amount'],
            'net_amount_debit' => $request_params['amount'],
            'data'             => json_encode($request_params),
            'status'           => $request_params['status'],
            'mode'             => $request_params['paymentMode'],
            'unmappedstatus'   => 'pending',
        ]);

        $post_params = [
            'merchantKey'            => config('payu.payumoney.key'),
            'merchantTransactionIds' => $request_params['merchantTransactionId'],
        ];
        $api_url = config('payu.paymentResponseApiUrl') . '?' . http_build_query($post_params);
        $client  = new Client();
        try {
            $response = $client->request('POST', $api_url, [
                'headers' => [
                    'Authorization' => config('payu.payumoney.auth'),
                ],
            ]);
            $response_params = json_decode($response->getBody(), true);
            if (!isset($response_params['result'][0]['postBackParam'])) {
                throw new Exception('Get Payment Response API returned null');
            }
            $post_back_params = $response_params['result'][0]['postBackParam'];
        } catch (\Exception $e) {
            abort(400, $e->getMessage());
        }
        $payu_payment->data             = json_encode($response_params['result']);
        $payu_payment->bank_ref_num     = $post_back_params['bank_ref_num'];
        $payu_payment->bankcode         = $post_back_params['bankcode'];
        $payu_payment->cardnum          = $post_back_params['cardnum'];
        $payu_payment->name_on_card     = $post_back_params['name_on_card'];
        $payu_payment->card_type        = $post_back_params['card_type'];
        $payu_payment->mihpayid         = $post_back_params['mihpayid'];
        $payu_payment->unmappedstatus   = $post_back_params['unmappedstatus'];
        $payu_payment->net_amount_debit = $post_back_params['net_amount_debit'];
        $payu_payment->save();

        if ($payu_payment->unmappedstatus == 'captured') {
            $order->status           = 'payment-successful';
            $order->transaction_mode = 'Prepaid';
            $order->save();
            $order->placeOrderOnOdoo();

            $cart       = $order->cart;
            $cart->type = 'order-complete';
            $cart->save();

            $order->sendSuccessEmail();
            $order->sendSuccessSMS();
            $order->sendVendorSMS();
        } else {
            $order->status = 'payment-failed';
            $order->save();
            request()->session()->flash('payment', "failure");
        }
        $order->payment_in_progress = false;
        $order->save();
    }
}
