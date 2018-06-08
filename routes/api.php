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
    Route::post('login',"Api\AuthenticationApiController@login");
    Route::post('logout',"Api\AuthenticationApiController@logout");
    Route::post('register',"Api\AuthenticationApiController@register");
    Route::post('forgotpasword',"Api\AuthenticationApiController@forgotPasword");
    Route::get('user/{id}',"Api\AuthenticationApiController@index");
    Route::put('user/{id}',"Api\AuthenticationApiController@update");
});
Route::group(['prefix'=>'address'],function (){
    Route::get('{id}',"Api\AddressApiController@index");
    Route::put('{id}',"Api\AddressApiController@update");
});
Route::group(['prefix' => 'product'], function() {
    Route::get('/listproduct/{id}', "Api\ProductApiController@listProduct");
    Route::get('/detailproduct/{id}', "Api\ProductApiController@detailProduct");
    Route::get('/orderproduct/{id}', "Api\ProductApiController@orderProduct");
    Route::get('menu', "Api\ProductApiController@menu");
    Route::get('index', "Api\ProductApiController@index");
});
Route::group(['prefix' => 'payment'], function() {
    Route::post('product', "Api\PaymentApiController@payProduct");
});
Route::group(['prefix'=>'data'],function (){
    Route::get('slide',"Api\SlideApiController@getSlide");
});
