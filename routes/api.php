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

for ($group_app_version=1; $group_app_version <= config('app.api_latest'); $group_app_version++) { 
	Route::group([
	  'prefix'     => '/rest/v'.$group_app_version,
	], function () use ($group_app_version) {
		Route::group([
		  'middleware' => ['auth:api'],
		  'prefix'     => '/user',
		], function () use ($group_app_version) {
			Route::group([
			  'prefix'     => '/cart',
			], function () use ($group_app_version) {
				Route::post('/{id}/insert', 'v'.$group_app_version.'\CartController@userAddItem');
				Route::get('/{id}/get', 'v'.$group_app_version.'\CartController@userCartFetch');
				Route::get('/{id}/delete', 'v'.$group_app_version.'\CartController@userCartDelete');
				Route::get('/{id}/change-promotion', 'v'.$group_app_version.'\CartController@userCartPromotion');
				Route::post('/{id}/create-order', 'v'.$group_app_version.'\OrderController@userCreateOrder');
				Route::post('/{id}/continue-order', 'v'.$group_app_version.'\OrderController@continueOrder');
				Route::get('/mine', 'v'.$group_app_version.'\CartController@getCartID');
				Route::get('/start-fresh', 'v'.$group_app_version.'\CartController@startFresh');
			});
			Route::group([
			  'prefix'     => '/address',
			], function () use ($group_app_version) {
				Route::post('/new', 'v'.$group_app_version.'\AddressController@userAddAddress');
				Route::post('/edit', 'v'.$group_app_version.'\AddressController@userEditAddress');
				Route::get('/all', 'v'.$group_app_version.'\AddressController@userFetchAddresses');
				Route::get('/delete', 'v'.$group_app_version.'\AddressController@userDeleteAddress');
			});
			Route::get('/get-user-info', 'v'.$group_app_version.'\UserController@fetchUserInfo');
			Route::post('/save-user-details', 'v'.$group_app_version.'\UserController@saveUserDetails');
			Route::get('/order/{id}/check-inventory', 'v'.$group_app_version.'\OrderController@checkSubOrderInventory');
			Route::post('/orders', 'v'.$group_app_version.'\OrderController@listOrders');
		});
		Route::post('/product-list', 'v'.$group_app_version.'\ListingController@productList');
		Route::get('/product-with-missing-images', 'v'.$group_app_version.'\ProductController@productMissingImages');
	});
}

Route::middleware('auth:api')->get('/user', config('app.version').'\HomeController@api');

