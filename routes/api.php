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

Route::middleware('auth:api')->get('/user', 'HomeController@api');

Route::middleware('auth:api')->post('/rest/v1/user/cart/{id}/insert', 'CartController@userAddItem');
Route::middleware('auth:api')->get('/rest/v1/user/cart/{id}/get', 'CartController@userCartFetch');
Route::middleware('auth:api')->get('/rest/v1/user/cart/{id}/delete', 'CartController@userCartDelete');
Route::middleware('auth:api')->get('/rest/v1/user/cart/{id}/change-promotion', 'CartController@userCartPromotion');

Route::middleware('auth:api')->post('/rest/v1/user/address/new', 'AddressController@userAddAddress');
Route::middleware('auth:api')->post('/rest/v1/user/address/edit', 'AddressController@userEditAddress');
Route::middleware('auth:api')->get('/rest/v1/user/address/all', 'AddressController@userFetchAddresses');

Route::middleware('auth:api')->get('/rest/v1/user/address/delete', 'AddressController@userDeleteAddress');

Route::middleware('auth:api')->get('/rest/v1/user/get-user-info', 'UserController@fetchUserDetails');

Route::post('/rest/v1/product-list', 'ListingController@productList');

Route::middleware('auth:api')->post('/rest/v1/user/cart/{id}/create-order', 'OrderController@userCreateOrder');
Route::middleware('auth:api')->post('/rest/v1/user/cart/{id}/continue-order', 'OrderController@continueOrder');
Route::middleware('auth:api')->get('/rest/v1/user/cart/mine', 'CartController@getCartID');
Route::middleware('auth:api')->get('/rest/v1/user/cart/start-fresh', 'CartController@startFresh');

Route::middleware('auth:api')->post('/rest/v1/user/save-user-details', 'UserController@saveUserDetails');

Route::middleware('auth:api')->get('/rest/v1/user/order/{id}/check-inventory', 'OrderController@checkSubOrderInventory');

Route::get('/rest/v1/product-with-missing-images', 'ProductController@productMissingImages');

Route::middleware('auth:api')->post('/rest/v1/user/orders', 'OrderController@listOrders');

