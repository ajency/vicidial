<?php

use Illuminate\Http\Request;

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

$app_version = 'v'.config('app.api_version');

$group_app_version = 'v1';
Route::group([
  'prefix'     => '/rest/'.$group_app_version,
], function () use ($group_app_version) {
	Route::group([
	  'middleware' => ['auth:api'],
	  'prefix'     => '/user',
	], function () use ($group_app_version) {
		Route::group([
		  'prefix'     => '/cart',
		], function () use ($group_app_version) {
			Route::post('/{id}/insert', $group_app_version.'\CartController@userAddItem');
			Route::get('/{id}/get', $group_app_version.'\CartController@userCartFetch');
			Route::get('/{id}/delete', $group_app_version.'\CartController@userCartDelete');
			Route::get('/{id}/change-promotion', $group_app_version.'\CartController@userCartPromotion');
			Route::post('/{id}/create-order', $group_app_version.'\OrderController@userCreateOrder');
			Route::post('/{id}/continue-order', $group_app_version.'\OrderController@continueOrder');
			Route::get('/mine', $group_app_version.'\CartController@getCartID');
			Route::get('/start-fresh', $group_app_version.'\CartController@startFresh');
		});
		Route::group([
		  'prefix'     => '/address',
		], function () use ($group_app_version) {
			Route::post('/new', $group_app_version.'\AddressController@userAddAddress');
			Route::post('/edit', $group_app_version.'\AddressController@userEditAddress');
			Route::get('/all', $group_app_version.'\AddressController@userFetchAddresses');
			Route::get('/delete', $group_app_version.'\AddressController@userDeleteAddress');
		});
		Route::middleware('check-user')->get('/get-user-info', $group_app_version.'\UserController@fetchUserInfo');
		Route::post('/save-user-details', $group_app_version.'\UserController@saveUserDetails');
		Route::get('/order/{id}/check-inventory', $group_app_version.'\OrderController@checkSubOrderInventory');
		Route::middleware('check-user')->post('/orders', $group_app_version.'\OrderController@listOrders');
	});
	Route::post('/product-list', $group_app_version.'\ListingController@productList');
	Route::get('/product-with-missing-images', $group_app_version.'\ProductController@productMissingImages');
	Route::post('/send-contact-details', $group_app_version.'\StaticController@saveContactDetails');
	
	Route::get('/district-state/{pincode}', $group_app_version.'\AddressController@fetchPincode');
});

$group_app_version = 'v2';
Route::group([
  'prefix'     => '/rest/'.$group_app_version,
], function () use ($group_app_version) {
	Route::group([
	  'middleware' => ['auth:api-passport'],
	], function () use ($group_app_version) {
		Route::group([
		  'prefix'     => '/user',
		], function () use ($group_app_version) {
			Route::group([
			  'prefix'     => '/cart',
			], function () use ($group_app_version) {
				Route::get('/{id}/count', $group_app_version.'\CartController@userGetCount');
				Route::post('/{id}/insert', $group_app_version.'\CartController@userAddItem');
				Route::post('/{id}/update', $group_app_version.'\CartController@userModifyItem');
				Route::get('/{id}/get', $group_app_version.'\CartController@userCartFetch');
				Route::get('/{id}/delete', $group_app_version.'\CartController@userCartDelete');
				Route::get('/{id}/change-promotion', $group_app_version.'\CartController@userCartPromotion');
				Route::get('/mine', $group_app_version.'\CartController@getCartID');
				Route::get('/start-fresh', $group_app_version.'\CartController@startFresh');
				Route::post('/{id}/create-order', $group_app_version.'\OrderController@userCreateOrder');
				Route::post('/{id}/continue-order', $group_app_version.'\OrderController@continueOrder');
			});
			Route::group([
			  'prefix'     => '/address',
			], function () use ($group_app_version) {
				Route::post('/new', $group_app_version.'\AddressController@userAddAddress');
				Route::post('/edit', $group_app_version.'\AddressController@userEditAddress');
				Route::get('/all', $group_app_version.'\AddressController@userFetchAddresses');
				Route::get('/delete', $group_app_version.'\AddressController@userDeleteAddress');
			});

			Route::middleware('check-user')->get('/get-user-info', $group_app_version.'\UserController@fetchUserInfo');
			Route::post('/save-user-details', $group_app_version.'\UserController@saveUserDetails');

			Route::get('/order/{id}/check-inventory', $group_app_version.'\OrderController@checkSubOrderInventory');
			Route::middleware('check-user')->post('/orders', $group_app_version.'\OrderController@listOrders');
		});

		Route::group([
		  'prefix'     => '/authenticate',
		], function () use ($group_app_version) {
			Route::get('/refresh_token', $group_app_version.'\UserController@refreshToken');
		});
	});

	Route::get('/product-details', $group_app_version.'\ProductController@singleProductAPI');
	Route::get('/states/all', $group_app_version.'\AddressController@fetchStates');
	Route::get('/district-state/{pincode}', $group_app_version.'\AddressController@fetchPincode');
});

//routes to staticElements
//Route::get('/rest/v2/get-page-element','v2\StaticElementController@callFetch');
Route::post('/rest/v2/save-page-element/new','v2\StaticElementController@callSaveNew'); //working

Route::get('/rest/v2/get-page-element/{seq_no}','v2\StaticElementController@callFetchSeq');
Route::get('/rest/v2/get-page-element','v2\StaticElementController@callFetch'); //not
Route::post('/rest/v2/save-page-element/{seq_no}','v2\StaticElementController@callSave'); //update

Route::middleware('auth:api')->get('/user', $app_version.'\HomeController@api');

