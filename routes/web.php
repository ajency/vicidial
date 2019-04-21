<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::post('/service_comm/listen', '\Ajency\ServiceComm\ServiceCommController@serviceCommListen');

$config = config('ajfileupload');

$app_version = 'v' . config('app.api_version');

$group_app_version = 'v1';
Route::group([
    'prefix' => '/rest/' . $group_app_version,
], function () use ($group_app_version) {
    Route::group([
        'prefix' => '/anonymous',
    ], function () use ($group_app_version) {
        Route::group([
            'prefix' => '/cart',
        ], function () use ($group_app_version) {
            Route::get('/count', $group_app_version . '\CartController@guestGetCount');
            Route::post('/insert', $group_app_version . '\CartController@guestAddItem');
            Route::post('/update', $group_app_version . '\CartController@guestModifyItem');
            Route::get('/get', $group_app_version . '\CartController@guestCartFetch');
            Route::get('/delete', $group_app_version . '\CartController@guestCartDelete');
            Route::get('/check-status', $group_app_version . '\CartController@checkStatus');
            Route::get('/apply-coupon', $group_app_version . '\CartController@guestCartCoupon');
        });
        Route::get('/states/all', $group_app_version . '\AddressController@fetchStates');
    });
    Route::group([
        'prefix' => '/authenticate',
    ], function () use ($group_app_version) {
        Route::get('/login', $group_app_version . '\UserController@verifyOTP');
        Route::get('/skip', $group_app_version . '\UserController@skipOTP');
        Route::get('/generate_otp', $group_app_version . '\UserController@sendSMS');
    });
    
});

$group_app_version = 'v2';
Route::group([
    'prefix' => '/rest/' . $group_app_version,
], function () use ($group_app_version) {
    Route::group([
        'prefix' => '/anonymous',
    ], function () use ($group_app_version) {
        Route::group([
            'prefix' => '/cart',
        ], function () use ($group_app_version) {
            Route::get('/count', $group_app_version . '\CartController@guestGetCount');
            Route::post('/insert', $group_app_version . '\CartController@guestAddItem');
            Route::post('/update', $group_app_version . '\CartController@guestModifyItem');
            Route::get('/get', $group_app_version . '\CartController@guestCartFetch');
            Route::get('/delete', $group_app_version . '\CartController@guestCartDelete');
            Route::get('/apply-coupon', $group_app_version . '\CartController@guestCartCoupon');
            Route::get('/check-status', $group_app_version . '\CartController@checkStatus');
        });
    });
    Route::group([
        'prefix' => '/authenticate',
    ], function () use ($group_app_version) {
        Route::get('/login', $group_app_version . '\UserController@verifyOTP');
        Route::get('/skip', $group_app_version . '\UserController@skipOTP');
        Route::get('/generate_otp', $group_app_version . '\UserController@sendSMS');
        Route::get('/resend_otp', $group_app_version . '\UserController@reSendSMS');
    });
});


Route::get('/', $app_version . '\HomeController@newhome')->name('home');
// Route::get('/newhome', $app_version . '\HomeController@newhome')->name('home');
Route::get('/drafthome', $app_version . '\HomeController@newdraft')->name('drafthome');
Route::get('/getWarehouseLevelInventory', $app_version . "\ProductController@allInventory");
Route::get('/contact-us', $app_version . '\StaticController@contact');
Route::get('/contact', $app_version . '\StaticController@contactnew');
Route::get('/faq', $app_version . '\StaticController@faq');
Route::get('/about-us', $app_version . '\StaticController@about');
Route::get('/terms-and-conditions', $app_version . '\StaticController@tc');
Route::get('/privacy-policy', $app_version . '\StaticController@privacy');
Route::get('/ideas', $app_version . '\PostController@blog');
Route::get('/ideas/{title}', $app_version . '\PostController@post');
Route::get('/ideas/category/{category}', $app_version . '\PostController@category');
Route::get('/stores', $app_version . '\StaticController@stores');
Route::get('/stores/surat', $app_version . '\StaticController@singlestore');
Route::get('/stores/hyderabad', $app_version . '\StaticController@singlestore');
Route::get('/stores/coimbatore', $app_version . '\StaticController@singlestore');
Route::get('/stores/jaipur', $app_version . '\StaticController@singlestore');
Route::get('/activities/{storename}', $app_version . '\StaticController@activities');
Route::get('/shop', $app_version . '\ListingController@shop')->name('shoplisting');
Route::get('/products/xml', $app_version . '\StaticController@productXML');
Route::get('/test/productlist', $app_version . '\ProductListTestController@index')->name('productListTest');
Route::get('/variant-diff-file', $app_version . '\StaticController@getVariantDiffFile');
Route::get('/user/order/{orderid}/payment/{type}', $app_version . '\PaymentController@payment')->name('payment');
Route::get('/user/order/{orderid}/payment/{type}/status', $app_version . '\PaymentController@status')->name('paymentStatus');
Route::get('/my/order/details', $app_version . '\OrderController@getOrderDetails')->name('orderDetails');
Route::get('/shop/{gendername}', $app_version . '\StaticController@gender');
Route::get('/draft/{gendername}', $app_version . '\StaticController@draft');
Route::get('/{product_slug}/buy', $app_version . '\ProductController@singleProduct')->name('product');
Route::get('/' . $config['base_root_path'] . $config['model']["App\ProductColor"]['base_path'] . '/{photo_id}/{preset}/{depth}/{image}', $app_version . '\ProductController@getImage');
Route::get('/sitemap.xml', $app_version.'\StaticController@sitemapXML');
Route::get('/products_list.xml', $app_version.'\StaticController@productlistXML');

Route::get('/' . config('fileupload_static_element')['base_root_path'] . config('fileupload_static_element')['model']["App\StaticElement"]['base_path'] . '/{photo_id}/{preset}/{depth}/{image}', $app_version . '\StaticElementController@getImage');
Route::get('/' . config('fileupload_static_element')['base_root_path'] . config('fileupload_static_element')['model']["App\StaticElement"]['base_path'] . '/{photo_id}/{preset}/{image}', $app_version . '\StaticElementController@getOriginalImage');
// Route::get('/{gendername}', $app_version.'\StaticController@gender');
Route::get('/{cat1}/{cat2?}/{cat3?}/{cat4?}/{cat5?}', $app_version . '\ListingController@index')->name('listing');
