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
Route::get('api', function(){
  return view('welcome');
});

//device pov
Route::post('api/post_location', 'StoreLocationController@postLocation');
Route::get('api/post_location', 'StoreLocationController@accessDenied');
//    Route::get('report_location', ['middleware' => 'oauth', function() {
//        // return the protected resource
//        return redirect()->action('StoreLocationController@reportLocation');
//    }]);
Route::get('api/report_location', 'StoreLocationController@reportLocation');

Route::get('api/get_token', 'StoreLocationController@getTokenBus');

//bus stop pov
Route::get('api/get_estimation/{halte_id}', 'BusStopController@getArrivalEstimation');

Route::get('api/nearest_bus/{halte_id}', 'BusStopController@getNearestArrivalEstimation');

Route::get('api/bus_stop/{halte_id}', 'BusStopController@detailBusStop');

//user pov
Route::post('api/add_user', 'UserController@addUser');

Route::post('api/update_user', 'UserController@updateUser');

//oauth server
Route::post('oauth/access_token', function() {
  return Response::json(Authorizer::issueAccessToken());
});