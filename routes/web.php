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

Route::get('/getWarehouseLevelInventory', "ProductController@allInventory");
Route::get('/rest/v1/anonymous/cart/count', 'CartController@guestGetCount');
Route::post('/rest/v1/anonymous/cart/insert', 'CartController@guestAddItem');
Route::get('/rest/v1/anonymous/cart/get', 'CartController@guestCartFetch');
Route::get('/rest/v1/anonymous/cart/delete', 'CartController@guestCartDelete');
Route::get('/rest/v1/anonymous/states/all', 'AddressController@fetchStates');
Route::get('/rest/v1/anonymous/cart/check-status', 'CartController@checkStatus');

Route::get('/contact-us', 'StaticController@contact');
Route::get('/contact', 'StaticController@contactnew');
Route::get('/faq', 'StaticController@faq');
Route::get('/about-us', 'StaticController@about');
Route::get('/terms-and-conditions', 'StaticController@tc');
Route::get('/privacy-policy', 'StaticController@privacy');
Route::get('/stores', 'StaticController@stores');
Route::get('/stores/surat', 'StaticController@singlestore');
Route::get('/stores/hyderabad', 'StaticController@singlestore');
Route::get('/stores/coimbatore', 'StaticController@singlestore');

Route::get('/rest/v1/authenticate/login', 'UserController@verifyOTP');
Route::get('/rest/v1/authenticate/generate_otp', 'UserController@sendSMS');

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

