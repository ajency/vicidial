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


Route::get('/rest/anonymous/cart/count','CartController@guest_get_count');
Route::get('/rest/anonymous/cart/insert','CartController@guest_add_item');
Route::get('/rest/anonymous/cart/get','CartController@guest_cart_fetch');
// Route::get('/rest/anonymous/cart/get','')
