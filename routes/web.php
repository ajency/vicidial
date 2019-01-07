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

$group_app_version = 1; 
Route::group([
  'prefix'     => '/rest/v'.$group_app_version,
], function () use ($group_app_version) {
	Route::group([
	  'prefix'     => '/anonymous',
	], function () use ($group_app_version) {
		Route::group([
		  'prefix'     => '/cart',
		], function () use ($group_app_version) {
			Route::get('/count', 'v'.$group_app_version.'\CartController@guestGetCount');
			Route::post('/insert', 'v'.$group_app_version.'\CartController@guestAddItem');
			Route::get('/get', 'v'.$group_app_version.'\CartController@guestCartFetch');
			Route::get('/delete', 'v'.$group_app_version.'\CartController@guestCartDelete');
			Route::get('/check-status', 'v'.$group_app_version.'\CartController@checkStatus');
			Route::get('/changePromotion', 'v'.$group_app_version.'\CartController@guestCartPromotion');
		});
		Route::get('/states/all', 'v'.$group_app_version.'\AddressController@fetchStates');
	});
	Route::group([
	  'prefix'     => '/authenticate',
	], function () use ($group_app_version) {
		Route::get('/login', 'v'.$group_app_version.'\UserController@verifyOTP');
		Route::get('/generate_otp', 'v'.$group_app_version.'\UserController@sendSMS');
	});
});

Route::get('/', $app_version.'\HomeController@index')->name('home');
Route::get('/getWarehouseLevelInventory', $app_version."\ProductController@allInventory");
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
Route::get('/test/productlist', $app_version.'\ProductListTestController@index')->name('productListTest');
Route::get('/shop', $app_version.'\ListingController@shop')->name('shoplisting');
Route::get('/variant-diff-file',$app_version.'\StaticController@getVariantDiffFile');
Route::get('/user/order/{orderid}/payment/payu', $app_version.'\PaymentController@payment')->name('payment');
Route::get('/user/order/{orderid}/payment/payu/status', $app_version.'\PaymentController@status')->name('paymentStatus');
Route::get('/my/order/details', $app_version.'\OrderController@getOrderDetails')->name('orderDetails');
Route::get('/shop/{static_page}', $app_version.'\StaticController@index')->name('shopstatic');
Route::get('/{product_slug}/buy', $app_version.'\ProductController@index')->name('product');
Route::get('/'.$config['base_root_path']. $config['model']["App\ProductColor"]['base_path'].'/{photo_id}/{preset}/{depth}/{image}', $app_version.'\ProductController@getImage');
Route::get('/{cat1}/{cat2?}/{cat3?}/{cat4?}', $app_version.'\ListingController@index')->name('listing');

