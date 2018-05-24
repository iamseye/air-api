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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout');
Route::post('register', 'Auth\RegisterController@register');
Route::post('send-verification-email', 'VerifyController@sendVerificationEmail');
Route::post('send-mobile-verification-code', 'VerifyController@sendMobileVerificationCode');
Route::post('verify-mobile', 'VerifyController@verifyMobile');


Route::post('password/email', 'Auth\ForgotPasswordController@sendResetPasswordEmail');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::post('placeorder', 'PaymentControllunauthenticateder@placeOrder');

Route::group(['middleware' => 'auth:api'], function () {
    Route::put('user/{id}', 'UserController@update')->name('user.update');
    Route::post('upload-verify-photo/{id}', 'UserController@uploadVerifyPhoto')->name('user.uploadVerifyPhoto');
    Route::post('rent-order', 'RentOrderController@store')->name('rentOrder.store');
});

//
//Route::group(['middleware' => 'auth:api'], function() {
//    Route::get('articles', 'ArticleController@index');
//    Route::get('articles/{article}', 'ArticleController@show');
//    Route::post('articles', 'ArticleController@store');
//    Route::put('articles/{article}', 'ArticleController@update');
//    Route::delete('articles/{article}', 'ArticleController@delete');
//});


//Auth::guard('api')->user(); // instance of the logged user
//Auth::guard('api')->check(); // if a user is authenticated
//Auth::guard('api')->id(); // the id of the authenticated user
