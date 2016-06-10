<?php
Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

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
Route::get('daftar_bus', 'BusController@displayForm');
Route::post('daftar_bus', 'UserController@addNewBus');
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
Route::get('route_planner', 'UserController@viewRoutePlanner');
Route::post('route_planner', 'UserController@processRoutePlanner');
Route::get('list_bus/operation', 'UserController@viewAllBus');
Route::get('delete_bus/{plat_nomor}', 'UserController@deleteBusOperation');
Route::get('add_maintenance/{plat_nomor}', 'UserController@add_bus_maintenance_web');
Route::get('list_bus/maintenance', 'UserController@viewAllBusMaintenance');
Route::get('release_maintenance/{plat_nomor}', 'UserController@releaseBusMaintenaceWeb');
Route::get('full_map', 'UserController@viewPopUpLocation');
Route::get('detail_maintenance', 'UserController@detailMaintenanceView');
Route::post('detail_maintenance', 'UserController@updateMaintenanceView');
Route::get('feedback/bus', 'UserController@viewListBusFeedback');
Route::get('feedback/bus_stop', 'UserController@viewLisBusStopFeedback');
Route::get('feedback/bus_stop/{halte_id}', 'UserController@viewDetailBusStopFeedback');
Route::get('detail_bus', function(){
  return view('home_bus_detail');
});

//subdomain api
Route::get('api', function(){
  return view('welcome');
});

Route::get('api/post_location', 'StoreLocationController@accessDenied');
//    Route::get('report_location', ['middleware' => 'oauth', function() {
//        // return the protected resource
//        return redirect()->action('StoreLocationController@reportLocation');
//    }]);
Route::get('api/report_location', 'StoreLocationController@reportLocation'); //DEPRECATED

Route::post('api/bus_stop', 'BusStopController@addBusStop');

Route::get('api/bus_stop/all', 'BusStopController@getAllBusStop');

Route::get('api/bus_stop/{halte_id}', 'BusStopController@detailBusStop');

Route::delete('api/bus_stop/{halte_id}', 'BusStopController@deleteBusStop');

Route::get('api/bus_stop/{halte_id}/nearest_bus', 'BusStopController@getNearestArrivalEstimation');

Route::get('api/bus_stop/{halte_id}/bus_history', 'BusStopController@getDepartureHistory');

Route::get('api/bus_stop/{halte_id}/next_stop', 'BusStopController@nextBusStop');

Route::get('api/bus_stop/{halte_id}/route', 'BusStopController@getRoutePassingBusStop');

Route::get('api/bus_stop/{halte_id}/estimation', 'BusStopController@getArrivalEstimation');

Route::get('api/news/recent', 'NewsController@getNewsFeed');

Route::post('api/news', 'NewsController@addNewsFeed');

Route::put('api/news', 'NewsController@updateNewsFeed');

Route::delete('api/news/{news_id}', 'NewsController@deleteNewsFeed');

Route::get('api/news/{news_id}', 'NewsController@getCertainNewsFeed');

Route::post('api/bus/operation', 'StoreLocationController@postLocation');

Route::post('api/bus/operation/add', 'BusController@addBus');

Route::get('api/bus/operation/all', 'BusController@listAllBusOperation');

Route::get('api/bus/operation/{plat_nomor}', 'BusController@getBusOperation');

Route::delete('api/bus/operation/{plat_nomor}', 'BusController@deleteBusOperation');

Route::post('api/bus/operation/get_token', 'StoreLocationController@getTokenBus');

Route::get('api/bus/operation/bus_stop/remaining/{plat_nomor}', 'BusController@remainingBusStop');

Route::get('api/bus/route/{rute_id}', 'BusController@getBusInRoute');

Route::get('api/bus/trace/{plat_nomor}', 'BusController@getBusTrace');

Route::get('api/bus/speed_violation/{plat_nomor}', 'StoreLocationController@listBusViolation');

Route::get('api/bus/maintenance/{plat_nomor}', 'BusController@getBusMaintenance');

Route::put('api/bus/maintenance/{plat_nomor}', 'BusController@updateMaintenanceBusDiagnosis');

Route::post('api/bus/maintenance/{plat_nomor}', 'BusController@addBusMaintenance');

Route::post('api/bus/maintenance/release/{plat_nomor}', 'BusController@releaseBusMaintenance');

Route::get('api/estimation/all', 'BusStopController@allArrivalEstimation');

Route::get('api/estimation/{arrival_code}', 'BusStopController@getArrivalEstimationByCode');

Route::post('api/feedback', 'UserController@inputUserFeedback');

Route::get('api/feedback/bus_stop/all', 'BusStopController@allBusStopSatisfaction');

Route::get('api/feedback/bus_stop/{halte_id}', 'BusStopController@detailBusStopSatisfaction');

Route::get('api/feedback/bus/all', 'BusController@allBusSatisfaction');

Route::get('api/feedback/bus/{plat_nomor}', 'BusController@detailBusSatisfaction');

Route::get('api/route_planner/{halte_id_origin}/{halte_id_dest}', 'UserController@searchRoutePlanner');

Route::post('api/user', 'UserController@addUser');

Route::put('api/user', 'UserController@updateUser');

//oauth server
Route::post('oauth/access_token', function() {
  return Response::json(Authorizer::issueAccessToken());
});