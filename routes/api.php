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

Route::middleware('auth:api')->get('/user', config('app.version').'\HomeController@api');

Route::middleware('auth:api')->post('/rest/v1/user/cart/{id}/insert', 'v1\CartController@userAddItem');
Route::middleware('auth:api')->get('/rest/v1/user/cart/{id}/get', 'v1\CartController@userCartFetch');
Route::middleware('auth:api')->get('/rest/v1/user/cart/{id}/delete', 'v1\CartController@userCartDelete');
Route::middleware('auth:api')->get('/rest/v1/user/cart/{id}/change-promotion', 'v1\CartController@userCartPromotion');

Route::middleware('auth:api')->post('/rest/v1/user/address/new', 'v1\AddressController@userAddAddress');
Route::middleware('auth:api')->post('/rest/v1/user/address/edit', 'v1\AddressController@userEditAddress');
Route::middleware('auth:api')->get('/rest/v1/user/address/all', 'v1\AddressController@userFetchAddresses');

Route::middleware('auth:api')->get('/rest/v1/user/address/delete', 'v1\AddressController@userDeleteAddress');

Route::middleware('auth:api')->get('/rest/v1/user/get-user-info', 'v1\UserController@fetchUserInfo');

Route::post('/rest/v1/product-list', 'v1\ListingController@productList');

Route::middleware('auth:api')->post('/rest/v1/user/cart/{id}/create-order', 'v1\OrderController@userCreateOrder');
Route::middleware('auth:api')->post('/rest/v1/user/cart/{id}/continue-order', 'v1\OrderController@continueOrder');
Route::middleware('auth:api')->get('/rest/v1/user/cart/mine', 'v1\CartController@getCartID');
Route::middleware('auth:api')->get('/rest/v1/user/cart/start-fresh', 'v1\CartController@startFresh');

Route::middleware('auth:api')->post('/rest/v1/user/save-user-details', 'v1\UserController@saveUserDetails');

Route::middleware('auth:api')->get('/rest/v1/user/order/{id}/check-inventory', 'v1\OrderController@checkSubOrderInventory');

Route::get('/rest/v1/product-with-missing-images', 'v1\ProductController@productMissingImages');

Route::middleware('auth:api')->post('/rest/v1/user/orders', 'v1\OrderController@listOrders');

