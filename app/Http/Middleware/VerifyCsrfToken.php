<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
	private $openRoutes = [
        'service_comm/listen',
        'rest/v2/anonymous/cart/insert',
        'rest/v2/anonymous/cart/update',
        'user/order/payu-payment/status',
        'payu/notify/payment/success',
        'payu/notify/payment/failed',
    ];
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'service_comm/listen',
        'rest/v2/anonymous/cart/insert',
        'rest/v2/anonymous/cart/update',
        'user/order/payu-payment/status',
        'payu/notify/payment/success',
        'payu/notify/payment/failed',
    ];
}
