<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\BusStop;
use Illuminate\Support\Facades\App;

class UserController extends Controller
{
  /**
   * add new user, all param must be filled, except profile image that can be added later
   * @param Request $request
   */
  public function addUser(Request $request){
    $userModel = new User();
    $userModel->name = $request->input('username');
    $userModel->email = $request->input('email');
    $userModel->password = $request->input('password');
    $userModel->created_at = Carbon::now();
    $userModel->updated_at = Carbon::now();

    try{
      $userModel->profile_img = $request->input('profile_img');
    }catch (\Exception $e){
      $userModel->profile_img = 'https://qph.is.quoracdn.net/main-qimg-3b0b70b336bbae35853994ce0aa25013?convert_to_webp=true';
    }

    try{
      $userModel->alamat = $request->input('alamat');
    }catch (\Exception $e){
    //nothing to do if there is no address set
    }
    $userModel->save();
  }

  /**
   * update certain user information profile based on username
   * @param Request $request
   */
  public function updateUser(Request $request){
    try{
      $userModel = new User();
      $userModel->where('username', '=', $request->username)
                ->update([
                  'email' => $request->email
                ]);
    }catch (\Exception $e){
    //nothing to do
    }

    try{
      $userModel = new User();
      $userModel->where('username', '=', $request->username)
                ->where('password', '=', $request->old_password)
                ->first();

      if(sizeof($userModel>0)){
        $userModel = new User();
        $userModel->where('username', '=', $request->username)
                  ->update([
                      'password' => $request->new_password
                  ]);
      }
    }catch (\Exception $e){
      //nothing to do
    }

    try{
      $userModel = new User();
      $userModel->where('username', '=', $request->username)
                ->update([
                  'profile_img' => $request->profile_img
                ]);
    }catch (\Exception $e){
      //nothing to do
    }

    try{
      $userModel = new User();
      $userModel->where('username', '=', $request->username)
          ->update([
              'alamat' => $request->alamat
          ]);
    }catch (\Exception $e){
      //nothing to do
    }
  }

  /**
   * just display login view
   * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
   */
  public function displayLogin(){
    return view('dashboard_login');
  }

  /**
   * handle login authentication form
   * @param Request $request
   * @return \Illuminate\Http\RedirectResponse
   */
  public function authenticateUser(Request $request){
    $userModel = new User();
    $user = $userModel->where('email', '=', $request->input('input_email'))
                      ->where('password', '=', $request->input('input_password'))
                      ->get()->toArray();

    if(sizeof($user>0) && $user!=null){
      echo sizeof($user);
      return redirect()->action('UserController@displayAllBus');
    } else{
      return redirect()->action('UserController@displayLogin');
    }
  }

  /**
   * handle detail bus stop view
   * @param Request $request
   * @return $this
   */
  public function displayHome(Request $request){
    $halte_id = $request->session()->get('halte_id');
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = 'http://localhost/passenger_information_system/public/api/';
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = 'http://93.188.164.230/passenger_information_system/public/api/';
    }


    //get nearest arrival estimation
    $nearestBusUrl = $baseUrl.'nearest_bus/'.$halte_id;
    $response = \Httpful\Request::get($nearestBusUrl)->send();
    $nearestBus = json_decode($response->raw_body, true);
    $nearestBus = $nearestBus['data'];

    //get next three arrival schedule
    $nextBusStopUrl = $baseUrl.'get_estimation/'.$halte_id;
    $response = \Httpful\Request::get($nextBusStopUrl)->send();
    $nextBusStop = json_decode($response->raw_body, true);
    $nextBusStop = $nextBusStop['data'];

    //get next three bus stop in nearest arrival schedule
    $nextRouteUrl = $baseUrl.'next_stop/'.$halte_id;
    $response = \Httpful\Request::get($nextRouteUrl)->send();
    $nextRoute = json_decode($response->raw_body, true);
    $nextRoute = $nextRoute['data'];

    //get recent news
    $recentNewsUrl = $baseUrl.'recent_news';
    $response = \Httpful\Request::get($recentNewsUrl)->send();
    $recentNews = json_decode($response->raw_body, true);
    $recentNews = $recentNews['data'];

    //get detail bus stop
    $detailBusStopUrl = $baseUrl.'bus_stop/'.$halte_id;
    $response = \Httpful\Request::get($detailBusStopUrl)->send();
    $detailBusStop = json_decode($response->raw_body, true);
    $detailBusStop = $detailBusStop['data'];

    //get departure history
    $departureHistoryUrl = $baseUrl.'bus_history/'.$halte_id;
    $response = \Httpful\Request::get($departureHistoryUrl)->send();
    $departureHistory = json_decode($response->raw_body, true);
    $departureHistory = $departureHistory['data'];

    $viewData = array();
    $viewData['nearest_bus'] = $nearestBus;
    $viewData['next_bus_stop'] = $nextBusStop;
    $viewData['recent_news'] = $recentNews;
    $viewData['detail_bus_stop'] = $detailBusStop;
    $viewData['departure_history'] = $departureHistory;
    $viewData['next_route'] = $nextRoute;

    return view('dashboard_home')->with('viewData', $viewData);
  }

  /**
   * handle list_halte view
   * @return $this view list_bus_stop
   */
  public function displayListBusStop(){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = 'http://localhost/passenger_information_system/public/api/';
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = 'http://93.188.164.230/passenger_information_system/public/api/';
    }
    $allBusStopUrl = $baseUrl.'all_bus_stop';
    $response = \Httpful\Request::get($allBusStopUrl)->send();
    $allBusStop = json_decode($response->raw_body, true);
    $allBusStop = $allBusStop['data'];

    $viewData = array();
    $viewData['bus_stop'] = $allBusStop;

    return view('list_bus_stop')->with('viewData', $viewData);
  }

  /**
   * we must set halte_id session before passing to detail bus stop page
   * @param Request $request
   * @param $halte_id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function viewBusStop(Request $request, $halte_id){
    $request->session()->put('halte_id', $halte_id);

    return redirect()->action('UserController@displayHome');
  }

  //todo add edit bus stop view and logic
  public function editBusStop(){

  }

  /**
   * handle bus stop deletion button action
   * @param $halte_id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function deleteBusStop($halte_id){
    $busStopModel = new BusStop();
    $busStopModel->where('halte_id', '=', $halte_id)->delete();

    return redirect()->action('UserController@displayListBusStop');
  }

  /**
   * handle full page map view
   * @return $this view home_big_map
   */
  public function displayAllBus(){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = 'http://localhost/passenger_information_system/public/api/';
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = 'http://93.188.164.230/passenger_information_system/public/api/';
    }
    $allBusUrl = $baseUrl.'all_bus';
    $response = \Httpful\Request::get($allBusUrl)->send();
    $allBus = json_decode($response->raw_body, true);
    $allBus = $allBus['data'];

    $viewData = array();
    $viewData['all_bus'] = $allBus;

    return view('home_big_map')->with('viewData', $viewData);
  }

  /**
   * handle all arrival estimation view
   * @return $this view list_arrival_estimation
   */
  public function displayAllArrival(){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = 'http://localhost/passenger_information_system/public/api/';
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = 'http://93.188.164.230/passenger_information_system/public/api/';
    }
    $allArrivalEstimationUrl =  $baseUrl.'estimation/all';
    $response = \Httpful\Request::get($allArrivalEstimationUrl)->send();
    $allArrivalEstimation = json_decode($response->raw_body, true);
    $allArrivalEstimation = $allArrivalEstimation['data'];

    $viewData = array();
    $viewData['arrival_estimation'] = $allArrivalEstimation;

    return view('list_arrival_estimation')->with('viewData', $viewData);
  }

  public function displayFormBusStop(){
    return view('sign_up_bus_stop');
  }

  public function addBusStop(Request $request){
    $busStopModel = new BusStop();
    $busStopModel->nama_halte = $request->input('nama_halte');
    $busStopModel->lokasi_halte = $request->input('alamat_halte');
    $busStopModel->latitude = $request->input('latitude');
    $busStopModel->longitude = $request->input('longitude');
    $busStopModel->save();
  }

  public function viewDetailArrival(Request $request, $arrival_code){
    $request->session()->put('arrival_code', $arrival_code);

    return redirect()->action('UserController@detailArrival');
  }

  public function detailArrival(Request $request){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = 'http://localhost/passenger_information_system/public/api/';
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = 'http://93.188.164.230/passenger_information_system/public/api/';
    }

    $arrivalCode = $request->session()->get('arrival_code');
    $arrivalEstimationUrl = $baseUrl.'estimation/'.$arrivalCode;
    $response = \Httpful\Request::get($arrivalEstimationUrl)->send();
    $arrivalEstimation = json_decode($response->raw_body, true);
    $arrivalEstimation = $arrivalEstimation['data'];

    return view('home_arrival_estimation')->with('arrivalEstimation', $arrivalEstimation);
  }
}
