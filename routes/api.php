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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('test',function(){
//     return 'hello world';
// });
// Route::middleware('auth.api')->get('test','Api\RegisterController@test');
// Route::post('app/init');
// Route::get('test','Api\RegisteredController@test');
//
//发送验证码
Route::post('register/sendMobile','Api\RegisterController@sendMobile');

//发送验证码
Route::post('register/sendEmail','Api\RegisterController@sendEmail');

//验证
Route::post('register/validation','Api\RegisterController@validation');


Route::post('login/login','Api\LoginController@login');

Route::post('test',function(){
    return 'ok';
});
