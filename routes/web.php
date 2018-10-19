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

Route::get('/rest/anonymous/cart/count', 'CartController@guestGetCount');
Route::post('/rest/anonymous/cart/insert', 'CartController@guestAddItem');
Route::get('/rest/anonymous/cart/get', 'CartController@guestCartFetch');

Route::middleware(['create-seo:home'])->group(function () {
    Route::get('/', 'HomeController@index')->name('home');
});

Route::middleware(['create-seo:product'])->group(function () {
    Route::get('/{product_slug}/{style_slug}/{color_slug}/buy', 'ProductController@index')->name('product');
});

Route::middleware(['create-seo:listing'])->group(function () {
    Route::get('/{category_type}/{gender}/{age_group}/{category_subtype}', 'ListingController@index')->name('listing');
});