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
Route::group(['prefix'=>'auth'],function (){
    Route::post('postlogin',"Api\AuthenticationApiController@postLogin");
    Route::post('postregister',"Api\AuthenticationApiController@postRegister");
    Route::post('sendresetemail',"Api\AuthenticationApiController@sendResetEmail");
    Route::get('/getdetailuser/{id}',"Api\AuthenticationApiController@getDetailUser");
    Route::put('/putdetailuser/{id}',"Api\AuthenticationApiController@putDetailUser");
});
Route::group(['prefix'=>'address'],function (){
    Route::get('/getaddress/{id}',"Api\AddressApiController@getAddress");
    Route::put('/putaddress/{id}',"Api\AddressApiController@putAddress");
});
Route::group(['prefix' => 'products'], function() {
    Route::get('getlistproduct', "Api\ProductApiController@getListProduct");
    Route::get('/getorderproduct/{id}', "Api\ProductApiController@getOrderProduct");
    Route::get('/getdetailproduct/{id}', "Api\ProductApiController@getDetailProduct");
});
Route::group(['prefix' => 'payments'], function() {
    Route::post('postpaymentproduct', "Api\PaymentApiController@postPaymentProduct");
});
