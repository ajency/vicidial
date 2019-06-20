<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

$app_version = 'v' . config('app.api_version');

$group_app_version = 'v1';
Route::group([
    'prefix' => '/rest/' . $group_app_version,
], function () use ($group_app_version) {
    Route::group([
        'middleware' => ['auth:api'],
        'prefix'     => '/user',
    ], function () use ($group_app_version) {
        Route::group([
            'prefix' => '/cart',
        ], function () use ($group_app_version) {
            Route::post('/{id}/insert', $group_app_version . '\CartController@userAddItem');
            Route::post('/{id}/update', $group_app_version . '\CartController@userModifyItem');
            Route::get('/{id}/get', $group_app_version . '\CartController@userCartFetch');
            Route::get('/{id}/delete', $group_app_version . '\CartController@userCartDelete');
            Route::get('/{id}/apply-coupon', $group_app_version . '\CartController@userCartCoupon');
            Route::post('/{id}/create-order', $group_app_version . '\OrderController@userCreateOrder');
            Route::post('/{id}/continue-order', $group_app_version . '\OrderController@continueOrder');
            Route::get('/mine', $group_app_version . '\CartController@getCartID');
            Route::get('/start-fresh', $group_app_version . '\CartController@startFresh');
        });
        Route::group([
            'prefix' => '/address',
        ], function () use ($group_app_version) {
            Route::post('/new', $group_app_version . '\AddressController@userAddAddress');
            Route::post('/edit', $group_app_version . '\AddressController@userEditAddress');
            Route::get('/all', $group_app_version . '\AddressController@userFetchAddresses');
            Route::get('/delete', $group_app_version . '\AddressController@userDeleteAddress');
        });
        Route::post('/save-user-details', $group_app_version . '\UserController@saveUserDetails');
        Route::get('/order/{id}/check-inventory', $group_app_version . '\OrderController@checkSubOrderInventory');
        Route::get('/order/{id}/send-otp', $group_app_version . '\PaymentController@sendCODVerifySMS');
        Route::get('/order/{id}/resend-otp', $group_app_version . '\PaymentController@reSendCODVerifySMS');
        Route::get('/order/{id}/verify-otp', $group_app_version . '\PaymentController@verifyOTP');
        Route::group([
            'middleware' => ['check-user:' . $group_app_version],
        ], function () use ($group_app_version) {
            Route::post('/orders', $group_app_version . '\OrderController@listOrders');
            Route::get('/order/{txnid}/details', $group_app_version . '\OrderController@singleOrder');
            Route::post('/order/{id}/cancel', $group_app_version . '\OrderController@cancelOrder');
            Route::post('/sub-order/{id}/return', $group_app_version . '\OrderController@returnOrder');
            Route::get('/get-user-info', $group_app_version . '\UserController@fetchUserInfo');
        });
    });
    Route::get('/single-product', $group_app_version . '\ProductController@SingleProductApi');
    Route::get('/single-product-inventory', $group_app_version . '\ProductController@SingleProductInventory');
    Route::get('/product-list', $group_app_version . '\ListingController@productList');
    Route::get('/get-filters', $group_app_version . '\ListingController@filtersWithoutCount');
    Route::get('/get-filters-count', $group_app_version . '\ListingController@filtersWithCount');
    Route::get('/product-with-missing-images', $group_app_version . '\ProductController@productMissingImages');
    Route::post('/send-contact-details', $group_app_version . '\StaticController@saveContactDetails');

    Route::get('/district-state/{pincode}', $group_app_version . '\AddressController@fetchPincode');
    Route::get('/get-all-reasons', $group_app_version . '\OrderController@getAllReasons');

    Route::group([
        'middleware' => ['auth:api', 'extension-api-permissions'],
    ], function () use ($group_app_version) {
        Route::post('/save-page-element/new', $group_app_version . '\StaticElementController@callSaveNew');
        Route::post('/save-page-element/{seq_no}', $group_app_version . '\StaticElementController@callSave');
        Route::get('/get-page-element/{seq_no}', $group_app_version . '\StaticElementController@callFetchSeq');
        Route::get('/facets', $group_app_version . '\StaticElementController@getFacets');
        Route::post('/save-sizechart-images', $group_app_version . '\StaticElementController@saveSizeChartImages');
        Route::get('/get-size-charts', $group_app_version . '\StaticElementController@getSizeCharts');
        Route::post('/save-rank-csv', $group_app_version . '\StaticController@saveRankCSV');
        Route::get('/download-rank-csv', $group_app_version . '\StaticController@downloadRankCSV');
    });
    Route::get('/get-page-elements', $group_app_version . '\StaticElementController@callFetch');
    Route::get('/get-menu', $group_app_version . '\StaticElementController@getMenu');
    Route::get('/test/get-page-element-dummy', $group_app_version . '\StaticElementController@callFetch');
    Route::get('/test/get-menu', $group_app_version . '\StaticElementController@getMenu');
    Route::group([
        'middleware' => ['auth:api', 'publish-static-element'],
    ], function () use ($group_app_version) {
        Route::get('/publish-page-element', $group_app_version . '\StaticElementController@callPublish');
    });
});

$group_app_version = 'v2';
Route::group([
    'prefix' => '/rest/' . $group_app_version,
], function () use ($group_app_version) {
    Route::group([
        'middleware' => ['auth:api-passport', 'get-token-details'],
    ], function () use ($group_app_version) {
        Route::group([
            'prefix' => '/user',
        ], function () use ($group_app_version) {
            Route::group([
                'prefix' => '/authenticate',
            ], function () use ($group_app_version) {
                Route::get('/verify-token', $group_app_version . '\UserController@verifyToken');
                Route::get('/generate_otp', $group_app_version . '\UserController@sendSMS');
                Route::get('/resend_otp', $group_app_version . '\UserController@reSendSMS');
                Route::get('/refresh_token', $group_app_version . '\UserController@refreshToken');
            });
            Route::group([
                'prefix' => '/cart',
            ], function () use ($group_app_version) {
                Route::get('/{id}/count', $group_app_version . '\CartController@userGetCount');
                Route::post('/{id}/insert', $group_app_version . '\CartController@userAddItem');
                Route::post('/{id}/update', $group_app_version . '\CartController@userModifyItem');
                Route::get('/{id}/get', $group_app_version . '\CartController@userCartFetch');
                Route::get('/{id}/delete', $group_app_version . '\CartController@userCartDelete');
                Route::get('/{id}/apply-coupon', $group_app_version . '\CartController@userCartCoupon');
                Route::get('/mine', $group_app_version . '\CartController@getCartID');
                Route::get('/start-fresh', $group_app_version . '\CartController@startFresh');
                Route::post('/{id}/create-order', $group_app_version . '\OrderController@userCreateOrder');
                Route::post('/{id}/continue-order', $group_app_version . '\OrderController@continueOrder');
            });
            Route::group([
                'prefix' => '/address',
            ], function () use ($group_app_version) {
                Route::post('/new', $group_app_version . '\AddressController@userAddAddress');
                Route::post('/edit', $group_app_version . '\AddressController@userEditAddress');
                Route::get('/all', $group_app_version . '\AddressController@userFetchAddresses');
                Route::get('/delete', $group_app_version . '\AddressController@userDeleteAddress');
            });
            Route::post('/save-user-details', $group_app_version . '\UserController@saveUserDetails');

            Route::group([
                'prefix' => '/order',
            ], function () use ($group_app_version) {
                Route::get('/{id}/check-inventory', $group_app_version . '\OrderController@checkSubOrderInventory');
                Route::get('/{id}/send-otp', $group_app_version . '\PaymentController@sendCODVerifySMS');
                Route::get('/{id}/resend-otp', $group_app_version . '\PaymentController@reSendCODVerifySMS');
                Route::get('/{id}/verify-otp', $group_app_version . '\PaymentController@verifyOTP');
                Route::get('/{id}/payment/{type}', $group_app_version . '\PaymentController@orderPayment');                   
                Route::get('/order/details/{txnid}', $group_app_version . '\OrderController@finalPageDetails');
            });
            Route::group([
                'middleware' => ['check-user:' . $group_app_version],
            ], function () use ($group_app_version) {
                Route::post('/orders', $group_app_version . '\OrderController@listOrders');
                Route::get('/order/{txnid}/details', $group_app_version . '\OrderController@singleOrder');
                Route::post('/order/{id}/cancel', $group_app_version . '\OrderController@cancelOrder');       
                Route::post('/sub-order/{id}/return', $group_app_version . '\OrderController@returnOrder');
                Route::get('/get-user-info', $group_app_version . '\UserController@fetchUserInfo');
            });
        });
    });
    Route::get('/single-product', $group_app_version . '\ProductController@SingleProductApi');
    Route::get('/single-product-inventory', $group_app_version . '\ProductController@SingleProductInventory');
    Route::get('/product-list', $group_app_version . '\ListingController@productList');
    Route::get('/get-filters', $group_app_version . '\ListingController@filtersWithoutCount');
    Route::get('/get-filters-count', $group_app_version . '\ListingController@filtersWithCount');
    Route::get('/product-with-missing-images', $group_app_version . '\ProductController@productMissingImages');
    Route::post('/send-contact-details', $group_app_version . '\StaticController@saveContactDetails');
    Route::get('/states/all', $group_app_version . '\AddressController@fetchStates');
    Route::get('/district-state/{pincode}', $group_app_version . '\AddressController@fetchPincode');
    Route::get('/get-all-reasons', $group_app_version . '\OrderController@getAllReasons');

    Route::group([
        'middleware' => ['auth:api-passport', 'extension-api-permissions'],
    ], function () use ($group_app_version) {
        Route::post('/save-page-element/new', $group_app_version . '\StaticElementController@callSaveNew');
        Route::post('/save-page-element/{seq_no}', $group_app_version . '\StaticElementController@callSave');
        Route::get('/get-page-element/{seq_no}', $group_app_version . '\StaticElementController@callFetchSeq');
        Route::get('/facets', $group_app_version . '\StaticElementController@getFacets');
        Route::post('/save-sizechart-images', $group_app_version . '\StaticElementController@saveSizeChartImages');
        Route::get('/get-size-charts', $group_app_version . '\StaticElementController@getSizeCharts');
        Route::post('/save-rank-csv', $group_app_version . '\StaticController@saveRankCSV');
        Route::get('/download-rank-csv', $group_app_version . '\StaticController@downloadRankCSV');
    });
    Route::get('/get-page-elements', $group_app_version . '\StaticElementController@callFetch');
    Route::get('/get-menu', $group_app_version . '\StaticElementController@getMenu');
    Route::get('/get-menu-new', $group_app_version . '\StaticElementController@callFetch');
    Route::get('/test/get-page-element-dummy', $group_app_version . '\StaticElementController@callFetch');
    Route::get('/test/get-menu', $group_app_version . '\StaticElementController@getMenu');
    Route::group([
        'middleware' => ['auth:api-passport', 'publish-static-element'],
    ], function () use ($group_app_version) {
        Route::get('/publish-page-element', $group_app_version . '\StaticElementController@callPublish');
    });
});

Route::middleware('auth:api-passport')->get('/user', $app_version . '\HomeController@api');
