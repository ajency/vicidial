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
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $payments = PayuPayment::where([
            ['created_at', '>' , Carbon::now()->subMinutes(50)->toDateTimeString()],
            ['created_at', '<' , Carbon::now()->subMinutes(45)->toDateTimeString()],
            ['status', 'failed'],
        ])->get();
        foreach ($payments as $payu_payment) {
            $order = Order::where('txnid', $payments->txnid)->first();
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
            if (isset($response_params['result'][0]['postBackParam']) && ($payu_payment->status == 'failed' && $post_back_params['status'] == 'success')) {
                $post_back_params           = $response_params['result'][0]['postBackParam'];
                $payu_payment->status       = $post_back_params['status'];
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
                try {
                    $order->updateInventory('ReserveInventory');
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
}
