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
$config = config('ajfileupload');

Route::get('/rest/anonymous/cart/count', 'CartController@guestGetCount');
Route::post('/rest/anonymous/cart/insert', 'CartController@guestAddItem');
Route::get('/rest/anonymous/cart/get', 'CartController@guestCartFetch');
Route::get('/rest/anonymous/cart/delete', 'CartController@guestCartDelete');
Route::get('/contact-us', 'StaticController@contact');
Route::get('/contact', 'StaticController@contactnew');
Route::get('/faq', 'StaticController@faq');

Route::get('/rest/v1/authenticate/login', 'ApiLoginController@verifyOTP');
Route::get('/rest/v1/authenticate/generate_otp', 'SMSController@sendSMS');

Route::get('/test/productlist', 'ProductListTestController@index')->name('productListTest');

Route::get('/shop', 'ListingController@shop')->name('shoplisting');

Route::get('/', 'HomeController@index')->name('home');

# PayU
Route::get('/user/order/{orderid}/payment/payu', 'PaymentController@payment')->name('payment');
Route::get('/user/order/{orderid}/payment/payu/status', 'PaymentController@status')->name('paymentStatus');

Route::get('/my/order/details', 'OrderController@getOrderDetails')->name('orderDetails');

Route::get('/shop/{static_page}', 'StaticController@index')->name('shopstatic');

Route::get('/{product_slug}/buy', 'ProductController@index')->name('product');

Route::get('/'.$config['base_root_path']. $config['model']["App\ProductColor"]['base_path'].'/{photo_id}/{preset}/{depth}/{image}', 'ProductController@getImage');

Route::get('/{cat1}/{cat2?}/{cat3?}/{cat4?}', 'ListingController@index')->name('listing');
