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

$app_version = config('app.version');

Route::get('/getWarehouseLevelInventory', $app_version."\ProductController@allInventory");
Route::get('/rest/v1/anonymous/cart/count', 'v1\CartController@guestGetCount');
Route::post('/rest/v1/anonymous/cart/insert', 'v1\CartController@guestAddItem');
Route::get('/rest/v1/anonymous/cart/get', 'v1\CartController@guestCartFetch');
Route::get('/rest/v1/anonymous/cart/delete', 'v1\CartController@guestCartDelete');
Route::get('/rest/v1/anonymous/states/all', 'v1\AddressController@fetchStates');
Route::get('/rest/v1/anonymous/cart/check-status', 'v1\CartController@checkStatus');
Route::get('/rest/v1/anonymous/cart/changePromotion', 'v1\CartController@guestCartPromotion');

Route::get('/contact-us', $app_version.'\StaticController@contact');
Route::get('/contact', $app_version.'\StaticController@contactnew');
Route::get('/faq', $app_version.'\StaticController@faq');
Route::get('/about-us', $app_version.'\StaticController@about');
Route::get('/terms-and-conditions', $app_version.'\StaticController@tc');
Route::get('/privacy-policy', $app_version.'\StaticController@privacy');
Route::get('/stores', $app_version.'\StaticController@stores');
Route::get('/stores/surat', $app_version.'\StaticController@singlestore');
Route::get('/stores/hyderabad', $app_version.'\StaticController@singlestore');
Route::get('/stores/coimbatore', $app_version.'\StaticController@singlestore');

Route::get('/products/xml', $app_version.'\StaticController@productXML');

Route::get('/rest/v1/authenticate/login', 'v1\UserController@verifyOTP');
Route::get('/rest/v1/authenticate/generate_otp', 'v1\UserController@sendSMS');

Route::get('/test/productlist', $app_version.'\ProductListTestController@index')->name('productListTest');

Route::get('/shop', $app_version.'\ListingController@shop')->name('shoplisting');

Route::get('/', $app_version.'\HomeController@index')->name('home');
Route::get('/variant-diff-file',$app_version.'\StaticController@getVariantDiffFile');

# PayU
Route::get('/user/order/{orderid}/payment/payu', $app_version.'\PaymentController@payment')->name('payment');
Route::get('/user/order/{orderid}/payment/payu/status', $app_version.'\PaymentController@status')->name('paymentStatus');

Route::get('/my/order/details', $app_version.'\OrderController@getOrderDetails')->name('orderDetails');

Route::get('/shop/{static_page}', $app_version.'\StaticController@index')->name('shopstatic');

Route::get('/{product_slug}/buy', $app_version.'\ProductController@index')->name('product');

Route::get('/'.$config['base_root_path']. $config['model']["App\ProductColor"]['base_path'].'/{photo_id}/{preset}/{depth}/{image}', $app_version.'\ProductController@getImage');

Route::get('/{cat1}/{cat2?}/{cat3?}/{cat4?}', $app_version.'\ListingController@index')->name('listing');

