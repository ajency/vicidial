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

Route::middleware(['create-seo:home'])->group(function () {
    Route::get('/', function () {
        return view('home');
    });
});

Route::middleware(['create-seo:product'])->group(function () {
    Route::get('/{product_slug}/{style_slug}/{color_slug}/buy', 'ProductController@index')->name('product');
});

Route::get('/rest/anonymous/cart/count', 'CartController@guestGetCount');
Route::get('/rest/anonymous/cart/insert', 'CartController@guestAddItem');
Route::get('/rest/anonymous/cart/get', 'CartController@guestCartFetch');

// Route::get('/rest/anonymous/cart/get','')
