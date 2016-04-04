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
  return redirect()->action('UserController@displayLogin');
});
Route::get('daftar_bus', 'BusController@displayForm');
Route::post('daftar_bus', 'BusController@addBus');
Route::get('login', 'UserController@displayLogin');
Route::post('login', 'UserController@authenticateUser');
Route::get('home', 'UserController@displayHome');
Route::get('home/{halte_id}', 'UserController@viewBusStop');
Route::get('list_halte', 'UserController@displayListBusStop');
Route::get('delete_halte/{halte_id}', 'UserController@deleteBusStop');
Route::get('map_bus', 'UserController@displayAllBus');
Route::get('arrival_schedule', 'UserController@displayAllArrival');
Route::get('detail_arrival', 'UserController@detailArrival');
Route::get('detail_arrival/{arrival_code}', 'UserController@viewDetailArrival');
Route::get('daftar_halte', 'UserController@displayFormBusStop');
Route::post('daftar_halte', 'UserController@addBusStop');
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

Route::post('api/get_token', 'StoreLocationController@getTokenBus');

//bus stop pov
Route::get('api/get_estimation/{halte_id}', 'BusStopController@getArrivalEstimation');

Route::get('api/nearest_bus/{halte_id}', 'BusStopController@getNearestArrivalEstimation');

Route::get('api/bus_stop/{halte_id}', 'BusStopController@detailBusStop');

Route::get('api/recent_news', 'BusStopController@getNewsFeed');

Route::get('api/bus_history/{halte_id}', 'BusStopController@getDepartureHistory');

Route::get('api/all_bus_stop', 'BusStopController@getAllBusStop');

Route::get('api/all_bus', 'BusController@listAllBusOperation');

Route::get('api/next_stop/{halte_id}', 'BusStopController@nextBusStop');

Route::get('api/estimation/all', 'BusStopController@allArrivalEstimation');

Route::get('api/estimation/{arrival_code}', 'BusStopController@getArrivalEstimationByCode');

//user pov
Route::post('api/add_user', 'UserController@addUser');

Route::post('api/update_user', 'UserController@updateUser');

//oauth server
Route::post('oauth/access_token', function() {
  return Response::json(Authorizer::issueAccessToken());
});