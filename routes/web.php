<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


// 登录页面

    Route::get('admin/login','UserController@login');
    // 验证码
    Route::get('admin/yzm','UserController@yzm');
    // 登录的处理操作
    Route::post('admin/check','UserController@check');

    // 文件上传路由
    Route::any("/admin/upload","UploadController@uploadImage");

    Route::group(['namespace'=>'','prefix'=>'','middleware'=>'adminLogin'],function(){
        //商品管理路由
        Route::resource('products','ProductController');
        //优惠券管理路由
        Route::resource('coupons','CouponController');


    });
