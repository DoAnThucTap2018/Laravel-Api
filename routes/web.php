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

Route::get('/', function () {
    return view('index');
});
Route::group([
    'prefix' => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['admin'],
    'namespace' => 'Admin'
], function() {
    // your CRUD resources and other admin routes here

    CRUD::resource('setting', 'SettingCrudController');
    CRUD::resource('user', 'UserCrudController');
    CRUD::resource('product', 'ProductCrudController');
    CRUD::resource('order', 'OrderCrudController');
    //route show order

    Route::get('showorder/{id}/edit','ShowOrderController@showOder')->name('showorder');
    Route::post('editorder/{id}/edit','ShowOrderController@editOrder')->name('update');
    Route::get('dashboard','DashboardController@Dashboard');
});
Route::any('{path?}', function() {     return view("index"); })->where("path", ".+");