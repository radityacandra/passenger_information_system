<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Helpers\InverseResponse;

use App\User;
use App\BusStop;
use App\UserFeedback;
use App\BusRoute;
use App\ArrivalEstimation;

class UserController extends Controller
{
  /**
   * add new user, all param must be filled, except profile image that can be added later
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
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

    $response = array();
    try{
      $userModel->save();
      $response['code'] = 200;
      $response['data']['msg'] = 'successfully add new user';
    }catch (\Exception $e){
      $response['code'] = 400;
      $response['data']['msg'] = 'failed to add new user, please check the parameter';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * update certain user information profile based on username
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
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

    $response = array();
    $response['code'] = 200;
    $response['data']['msg'] = 'successfully update user';

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * save user feedback about bus_stop/bus_operation to database
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function inputUserFeedback(Request $request){
    $userFeedbackModel = new UserFeedback();

    $userId = $request->input('user_id');
    $userSatisfaction = $request->input('satisfaction');
    $userComplaint = $request->input('complaint');

    $userFeedbackModel->created_at = \Carbon\Carbon::now();
    $userFeedbackModel->updated_at = \Carbon\Carbon::now();
    $userFeedbackModel->user_id = $userId;
    $userFeedbackModel->satisfaction = $userSatisfaction;
    $userFeedbackModel->complaint = $userComplaint;

    if($request->exists('halte_id')){
      $directedToBusStop = $request->input('halte_id');
      $userFeedbackModel->directed_to_bus_stop = $directedToBusStop;
    }
    if($request->exists('plat_nomor')){
      $directedToBus = $request->input('plat_nomor');
      $userFeedbackModel->directed_to_bus = $directedToBus;
    }

    $response = array();
    if($userFeedbackModel->save()){
      $response['code'] = 200;
      $response['data']['msg'] = "feedback has successfully saved";
    } else {
      $response['code'] = 400;
      $response['data']['msg'] = "please provide correct parameter and try again";
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
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
      $baseUrl = 'http://167.114.207.130/passenger_information_system/public/api/';
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
      $baseUrl = 'http://167.114.207.130/passenger_information_system/public/api/';
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
  public function displayAllBus(Request $request){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = 'http://localhost/passenger_information_system/public/api/';
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = 'http://167.114.207.130/passenger_information_system/public/api/';
    }

    if($request->exists('display')){
      $plat_nomor = $request->input('plat_nomor');
      $rute_id = $request->input('rute_id');

      if($request->input('display')=='current_position'){
        //api/bus/operation/{plat_nomor}
        $allBusUrl = $baseUrl.'bus/operation/'.$plat_nomor;
        $response = \Httpful\Request::get($allBusUrl)->send();
        $allBus = json_decode($response->raw_body, true);
        $allBus = $allBus['data'];

        $viewData = array();
        $viewData['all_bus'][0] = $allBus;

        return view('home_big_map')->with('viewData', $viewData);
      } elseif($request->input('display')=='trace_position'){
        //api/bus/trace/{plat_nomor}
        $allBusUrl = $baseUrl.'bus/trace/'.$plat_nomor;
        $response = \Httpful\Request::get($allBusUrl)->send();
        $allBus = json_decode($response->raw_body, true);
        $allBus = $allBus['data'];

        for($i=0; $i<sizeof($allBus); $i++){
          $allBus[$i]['last_latitude'] = $allBus[$i]['latitude'];
          unset($allBus[$i]['latitude']);
          $allBus[$i]['last_longitude'] = $allBus[$i]['longitude'];
          unset($allBus[$i]['longitude']);
        }

        $viewData = array();
        $viewData['all_bus'] = $allBus;

        return view('home_big_map')->with('viewData', $viewData);
      } elseif($request->input('display')=='speed_violence'){
        //api/bus/speed_violation/{plat_nomor}
        $allBusUrl = $baseUrl.'bus/operation/'.$plat_nomor;
        $response = \Httpful\Request::get($allBusUrl)->send();
        $allBus = json_decode($response->raw_body, true);
        $allBus = $allBus['data'];

        $speedViolationUrl = $baseUrl.'bus/speed_violation/'.$plat_nomor;
        $response = \Httpful\Request::get($speedViolationUrl)->send();
        $speedViolation = json_decode($response->raw_body, true);
        $speedViolation = $speedViolation['data'];

        $viewData = array();
        if($plat_nomor!='all'){
          $viewData['all_bus'][0] = $allBus;
        } else {
          $viewData['all_bus'] = $allBus;
        }
        $viewData['speed_violation'] = $speedViolation;

        return view('home_map_speed_violence')->with('viewData', $viewData);
      } elseif($request->input('display')=='route_based'){
        //api/bus/route/{rute_id}
        $allBusUrl = $baseUrl.'bus/route/'.$rute_id;
        $response = \Httpful\Request::get($allBusUrl)->send();
        $allBus = json_decode($response->raw_body, true);
        $allBus = $allBus['data'];

        $viewData = array();
        $viewData['all_bus'] = $allBus;
        $viewData['list_route'] = $allBus;

        return view('home_map_speed_violence')->with('viewData', $viewData);
      }
    } else {
      $allBusUrl = $baseUrl.'bus/operation/all';
      $response = \Httpful\Request::get($allBusUrl)->send();
      $allBus = json_decode($response->raw_body, true);
      $allBus = $allBus['data'];

      $viewData = array();
      $viewData['all_bus'] = $allBus;

      return view('home_big_map')->with('viewData', $viewData);
    }
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
      $baseUrl = 'http://167.114.207.130/passenger_information_system/public/api/';
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
      $baseUrl = 'http://167.114.207.130/passenger_information_system/public/api/';
    }

    $arrivalCode = $request->session()->get('arrival_code');
    $arrivalEstimationUrl = $baseUrl.'estimation/'.$arrivalCode;
    $response = \Httpful\Request::get($arrivalEstimationUrl)->send();
    $arrivalEstimation = json_decode($response->raw_body, true);
    $arrivalEstimation = $arrivalEstimation['data'];

    return view('home_arrival_estimation')->with('arrivalEstimation', $arrivalEstimation);
  }

  public function viewRoutePlanner(){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = 'http://localhost/passenger_information_system/public/api/';
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = 'http://167.114.207.130/passenger_information_system/public/api/';
    }

    $allBusStopUrl = $baseUrl.'all_bus_stop';
    $response = \Httpful\Request::get($allBusStopUrl)->send();
    $allBusStop = json_decode($response->raw_body, true);
    $allBusStop = $allBusStop['data'];

    $containerName = array();
    for($i=0; $i<sizeof($allBusStop); $i++){
      $containerName[$i] = $allBusStop[$i]['nama_halte'];
    }

    $viewData = array();
    $viewData['all_bus']=$containerName;
    return view('route_planner')->with('viewData', $viewData);
  }

  public function processRoutePlanner(Request $request){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = 'http://localhost/passenger_information_system/public/api/';
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = 'http://167.114.207.130/passenger_information_system/public/api/';
    }

    $allBusStopUrl = $baseUrl.'all_bus_stop';
    $response = \Httpful\Request::get($allBusStopUrl)->send();
    $allBusStop = json_decode($response->raw_body, true);
    $allBusStop = $allBusStop['data'];

    $containerName = array();
    for($i=0; $i<sizeof($allBusStop); $i++){
      $containerName[$i] = $allBusStop[$i]['nama_halte'];
    }

    $origin = $request->input('origin');
    $destination = $request->input('destination');

    $halteIdOrigin = 0;
    $halteIdDestination = 0;

    foreach($allBusStop as $busStop){
      if($origin == $busStop['nama_halte']){
        $halteIdOrigin = $busStop['halte_id'];
      }

      if($destination == $busStop['nama_halte']){
        $halteIdDestination = $busStop['halte_id'];
      }

      if($halteIdOrigin!=0 && $halteIdDestination!=0){
        break;
      }
    }

    $routePlannerUrl = $baseUrl.'route_planner/'.$halteIdOrigin.'/'.$halteIdDestination;
    $response = \Httpful\Request::get($routePlannerUrl)->send();
    $routePlanner = json_decode($response->raw_body, true);
    $routePlanner = $routePlanner['data'];

    $timeSeconds = $routePlanner['total_time'];
    $hours = floor($timeSeconds / 3600);
    $minutes = floor(($timeSeconds / 60) % 60);
    $seconds = $timeSeconds % 60;

    $viewData = array();
    $viewData['total_time'] = $hours.' jam '.$minutes.' menit '.$seconds.' detik.';
    $viewData['route'] = $routePlanner['travel_info'];
    $viewData['all_bus']=$containerName;

    return view('route_planner')->with('viewData', $viewData);
  }

  public function viewAllBus(){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = 'http://localhost/passenger_information_system/public/api/';
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = 'http://167.114.207.130/passenger_information_system/public/api/';
    }

    $allBusUrl = $baseUrl.'bus/operation/all';
    $response = \Httpful\Request::get($allBusUrl)->send();
    $allBus = json_decode($response->raw_body, true);
    $allBus = $allBus['data'];

    $viewData = array();
    $viewData['all_bus'] = $allBus;

    return view('list_bus_operation')->with('viewData', $viewData);
  }

  /**
   * route planner controller. consist of 2 input, origin bus stop and destination bus stop
   * total time obtained from previous request arrival estimation to google maps api
   *
   * @param $halte_id_origin
   * @param $halte_id_dest
   * @return \Illuminate\Http\JsonResponse
   */
  public function searchRoutePlanner($halte_id_origin, $halte_id_dest){
    $baseTreeLevel = 0;
    $this->baseSearchRouteRecursion($halte_id_origin, $halte_id_dest, $baseTreeLevel);
    $containerRoute = array();

    $totalTime = 0;
    $arrivalEstimationModel = new ArrivalEstimation();
    $routePlanner = InverseResponse::inverseResponse($this->response);
    $anomaly = json_decode(json_encode($routePlanner[0]), true);
    if($routePlanner!=null){
      if($routePlanner[0]['halte_id'] == $halte_id_origin){
        for($i=0; $i<sizeof($routePlanner); $i++){
          if($i<(sizeof($routePlanner)-1)){
            $arrivalEstimation = $arrivalEstimationModel->where('halte_id_tujuan', '=', $routePlanner[$i]['halte_id'])
                ->where('rute_id', '=', $routePlanner[$i+1]['rute_id'])
                ->where('waktu_kedatangan', '>', $totalTime)
                ->orderBy('waktu_kedatangan', 'asc')
                ->get()
                ->toArray();

            $containerRoute[$i]['origin'] = $routePlanner[$i]['halte_id'];
            if($i==0){
              $containerRoute[$i]['detail_origin'] = $anomaly['detail_halte'];
            } else {
              $containerRoute[$i]['detail_origin'] = $routePlanner[$i]['detail_halte'];
            }
            $containerRoute[$i]['destination'] = $routePlanner[$i+1]['halte_id'];
            $containerRoute[$i]['detail_destination'] = $routePlanner[$i+1]['detail_halte'];
            $containerRoute[$i]['rute_id'] = $routePlanner[$i+1]['rute_id'];

            if($arrivalEstimation!=null){
              $waitingTime = $arrivalEstimation[0]['waktu_kedatangan'];
              $totalTime = $totalTime + $waitingTime;
              $containerRoute[$i]['plat_nomor'] = $arrivalEstimation[0]['plat_nomor'];
              $containerRoute[$i]['waiting_time'] = $waitingTime;

              $travelEstimation = $arrivalEstimationModel->where('halte_id_tujuan', '=', $routePlanner[$i+1]['halte_id'])
                  ->where('rute_id', '=', $routePlanner[$i+1]['rute_id'])
                  ->where('plat_nomor', '=', $arrivalEstimation[0]['plat_nomor'])
                  ->first();

              if($travelEstimation!=null){
                $travelTime = $travelEstimation['waktu_kedatangan'] - $waitingTime;
                $totalTime = $totalTime + $travelTime;
                $containerRoute[$i]['travel_time'] = $travelTime;
              }
            }
          }
        }
      }
    }

    $containerResponse = array();
    $containerResponse['travel_info'] = $containerRoute;
    $containerResponse['total_time'] = $totalTime;

    $response = array();
    $response['code'] = 200;
    $response['data'] = $containerResponse;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  public $counterRecursion = 0;
  public $response = array();

  /**
   * base recursion function, this will be self called if recursion condition happen
   * 
   * @param $halte_id_origin
   * @param $halte_id_dest
   * @param $treeLevel
   * @return null
   */
  public function baseSearchRouteRecursion($halte_id_origin, $halte_id_dest, $treeLevel){
    $busRouteModel = new BusRoute();
    $listBusRoute = $busRouteModel->where('halte_id', '=', $halte_id_dest)
                                  ->with('detailHalte')
                                  ->get()
                                  ->toArray();

    //echo '<br><br>'.json_encode($listBusRoute).'<br>';
    foreach($listBusRoute as $busRoute){
      $this->response[$treeLevel] = $busRoute;
      try{
        $directOrigin = $busRouteModel->where('rute_id', '=', $busRoute['rute_id'])
                                      ->where('halte_id', '=', $halte_id_origin)
                                      ->with('detailHalte')
                                      ->firstOrFail();
        //echo 'success';
        $this->response[$treeLevel+1] = $directOrigin;
        return null;
      } catch (\Exception $e){
        $this->counterRecursion++;
        /*echo 'recursing ke '.$this->counterRecursion. '<br>';
        echo 'urutan: '.($busRoute['urutan']-1). '<br>';
        echo 'halte id '. $busRoute['halte_id']. '<br>';
        echo 'rute_id '. $busRoute['rute_id']. '<br>';*/
        if(($busRoute['urutan']-1)==0){

        }else {
          $prevBusStop = $busRouteModel->where('urutan', '=', $busRoute['urutan']-1)
                                      ->where('rute_id', '=', $busRoute['rute_id'])
                                      ->first();
          $this->baseSearchRouteRecursion($halte_id_origin, $prevBusStop['halte_id'], $treeLevel+1);
        }
      }
    }
  }
}
