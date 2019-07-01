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
    protected $response, $status;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($response, $status)
    {
        $this->response = $response;
        $this->status   = $status;
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
        if ($order && $order->payment_in_progress) {
            $request_params['bankcode'] = '';
            try {
                $payu_payment = PayuPayment::create([
                    'account'        => config('payu.default'),
                    'payable_id'     => $order->id,
                    'payable_type'   => get_class($order),
                    'txnid'          => $order->txnid,
                    'mode'           => $request_params['paymentMode'],
                    'firstname'      => $request_params['customerName'],
                    'email'          => $request_params['customerEmail'],
                    'phone'          => $request_params['customerPhone'],
                    'amount'         => $request_params['amount'],
                    'data'           => json_encode($request_params),
                    'status'         => $request_params['status'],
                    'mode'           => $request_params['paymentMode'],
                    'unmappedstatus' => 'pending',
                    'bankcode'       => $request_params['bankcode'],
                ]);
            } catch (\Exception $e) {
                \Log::notice('payu_payment update failed for order ID:' . $order->id . ' with error: ' . $e->getMessage());
                $payu_payment = PayuPayment::where('txnid', $request_params['merchantTransactionId'])->first();
            }
            if (config('app.env') == 'production') {
                $post_params = [
                    'merchantKey'            => config('payu.accounts.payumoney.key'),
                    'merchantTransactionIds' => $request_params['merchantTransactionId'],
                ];
                $api_url  = config('payu.paymentResponseApiUrl') . '?' . http_build_query($post_params);
                $client   = new Client();
                $response = $client->request('POST', $api_url, [
                    'headers' => [
                        'Authorization' => config('payu.accounts.payumoney.auth'),
                    ],
                ]);

                $response_params = json_decode($response->getBody(), true);
                if (isset($response_params['result'][0]['postBackParam'])) {
                    $post_back_params           = $response_params['result'][0]['postBackParam'];
                    $payu_payment->data         = json_encode($post_back_params);
                    $payu_payment->bank_ref_num = $post_back_params['bank_ref_num'];
                    $payu_payment->bankcode     = $post_back_params['bankcode'];
                    $payu_payment->cardnum      = $post_back_params['cardnum'];
                    $payu_payment->name_on_card = $post_back_params['name_on_card'];
                    $payu_payment->card_type    = $post_back_params['card_type'];
                    $payu_payment->mihpayid     = $post_back_params['mihpayid'];
                    if (!is_null($post_back_params['unmappedstatus'])) {
                        $payu_payment->unmappedstatus = $post_back_params['unmappedstatus'];
                    }
                    if (!is_null($post_back_params['net_amount_debit'])) {
                        $payu_payment->net_amount_debit = $post_back_params['net_amount_debit'];
                    }
                    $payu_payment->save();
                }
            }

            try {
                if ($this->status == 'success') {
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
                    $order->updateInventory('UnreserveInventory');
                }

            } catch (\Exception $e) {
                \Log::notice('Order Success Payu Method Failed with error: ' . $e->getMessage());
                \Log::notice('Order id : ' . $order->id);
                sendEmail('failed-job', [
                    'from'          => config('communication.failed-job.from'),
                    'subject'       => 'Order Success Method Failed : PAYU [' . config('app.env') . ']',
                    'template_data' => [
                        'queue'     => 'Order Success Method',
                        'job'       => 'Order Success Method',
                        'exception' => $e->getMessage(),
                        'body'      => 'Order id : ' . $order->id,
                        'trace'     => $e->getTraceAsString(),
                    ],
                    'priority'      => 'default',
                ]);
            }
            $order->updateOrderlineIndex(['status', 'transaction_mode']);
            $order->payment_in_progress = false;
            $order->save();
        }
    }
}
