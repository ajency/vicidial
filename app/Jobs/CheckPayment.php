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

class CheckPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $txnid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($txnid)
    {
        $this->txnid = $txnid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $order = Order::where('txnid', $this->txnid)->first();
        $post_params = [
            'merchantKey'            => config('payu.accounts.payumoney.key'),
            'merchantTransactionIds' => $order->txnid,
        ];
        $api_url  = config('payu.paymentResponseApiUrl') . '?' . http_build_query($post_params);
        $client   = new Client();
        $response = $client->request('POST', $api_url, [
            'headers' => [
                'Authorization' => config('payu.accounts.payumoney.auth'),
            ],
        ]);
        $response_params = json_decode($response->getBody(), true);
        $payu_payment = PayuPayment::firstOrNew(['txnid' => $order->txnid]);
        
        if (isset($response_params['result'][0]['postBackParam'])) {
            $post_back_params           = $response_params['result'][0]['postBackParam'];
            if(is_null($payu_payment->id)){
                $payu_payment->account        = config('payu.default');
                $payu_payment->payable_id     = $order->id;
                $payu_payment->payable_type   = get_class($order);
                $payu_payment->mode           = isset($post_back_params['mode']) ? $post_back_params['mode'] : null;
                $payu_payment->firstname      = $post_back_params['firstname'];
                $payu_payment->email          = $post_back_params['email'];
                $payu_payment->phone          = $post_back_params['phone'];
                $payu_payment->amount         = $post_back_params['amount'];
                $payu_payment->data           = json_encode($post_back_params);
                $payu_payment->status         = $post_back_params['status'];
                $payu_payment->unmappedstatus = 'pending';
                $payu_payment->bankcode       = isset($post_back_params['bankcode']) ? $post_back_params['bankcode'] : null;
            }
            if(is_null($payu_payment->id) || ($payu_payment->status == 'failed' && $post_back_params['status'] == 'success')){
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
                    if ($order->status == 'payment-in-progress') {
                        \Log::notice('payumoney-checkpayment-new: '.json_encode($response_params));
                    }
                    else{
                        \Log::notice('payumoney-checkpayment-update: '.json_encode($response_params));
                    }
                    if($post_back_params['status'] == 'success'){
                        if ($order->status == 'payment-failed') {
                            $order->updateInventory('ReserveInventory');
                        }
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
                    }
                    else{
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
                $order->viewed = false;
                $order->save();
            }
        }
    }
}
