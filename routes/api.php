<?php

use Illuminate\Support\Facades\Route;

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

//login
Route::post('login', 'UserController@login');

//product
Route::prefix('product')->group(function () {
    Route::get('list', 'ProductController@list');
    Route::post('create', 'ProductController@create');
    Route::get('details', 'ProductController@details');
    Route::post('edit', 'ProductController@edit');
    Route::post('delete', 'ProductController@delete');
});

//coupon
Route::prefix('coupon')->group(function () {
    Route::get('list', 'CouponController@list');
    Route::get('productList', 'CouponController@productList');
    Route::post('create', 'CouponController@create');
    Route::get('details', 'CouponController@details');
    Route::post('edit', 'CouponController@edit');
    Route::post('delete', 'CouponController@delete');
});

//upload picture
Route::post('uploadImage', 'uploadController@uploadImage');
