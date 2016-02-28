<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
//main website
Route::get('/', function () {
    return view('welcome');
});
Route::get('daftar_bus', 'BusController@displayForm');
Route::post('daftar_bus', 'BusController@addBus');
Route::get('home', function(){
   return view('dashboard_home');
});
Route::get('detail_bus', function(){
   return view('home_bus_detail');
});

//subdomain api
Route::group(['domain' => 'api.localhost'], function(){
    Route::get('/', function(){
         return view('welcome');
    });

    Route::post('post_location', 'StoreLocationController@postLocation');
    Route::get('post_location', 'StoreLocationController@accessDenied');
    Route::get('report_location', 'StoreLocationController@reportLocation');

    Route::get('get_token', 'StoreLocationController@getTokenBus');
});