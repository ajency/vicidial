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
