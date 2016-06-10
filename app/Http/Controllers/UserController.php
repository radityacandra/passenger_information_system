<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Httpful\Mime;
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

  public $localUrl = 'http://127.0.0.1/pis/api/';
  public $remoteUrl = 'http://smartcity.wg.ugm.ac.id/webapp/passenger_information_system/public/api/';

  /**
   * handle detail bus stop view
   * @param Request $request
   * @return $this
   */
  public function displayHome(Request $request){
    $halte_id = $request->session()->get('halte_id');
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    //get nearest arrival estimation
    $nearestBusUrl = $baseUrl.'bus_stop/'.$halte_id.'/nearest_bus';
    $response = \Httpful\Request::get($nearestBusUrl)->send();
    $nearestBus = json_decode($response->raw_body, true);
    $nearestBus = $nearestBus['data'];

    //get next three arrival schedule
    $nextBusStopUrl = $baseUrl.'bus_stop/'.$halte_id.'/estimation';
    $response = \Httpful\Request::get($nextBusStopUrl)->send();
    $nextBusStop = json_decode($response->raw_body, true);
    $nextBusStop = $nextBusStop['data'];

    //get next three bus stop in nearest arrival schedule
    $nextRouteUrl = $baseUrl.'bus_stop/'.$halte_id.'/next_stop';
    $response = \Httpful\Request::get($nextRouteUrl)->send();
    $nextRoute = json_decode($response->raw_body, true);
    $nextRoute = $nextRoute['data'];

    //get recent news
    $recentNewsUrl = $baseUrl.'news/recent';
    $response = \Httpful\Request::get($recentNewsUrl)->send();
    $recentNews = json_decode($response->raw_body, true);
    $recentNews = $recentNews['data'];

    //get detail bus stop
    $detailBusStopUrl = $baseUrl.'bus_stop/'.$halte_id;
    $response = \Httpful\Request::get($detailBusStopUrl)->send();
    $detailBusStop = json_decode($response->raw_body, true);
    $detailBusStop = $detailBusStop['data'];

    //get departure history
    $departureHistoryUrl = $baseUrl.'bus_stop/'.$halte_id.'/bus_history';
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
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }
    $allBusStopUrl = $baseUrl.'bus_stop/all';
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
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $deleteBusUrl = $baseUrl.'bus_stop/'.$halte_id;
    $response = \Httpful\Request::delete($deleteBusUrl)->send();

    return redirect()->action('UserController@displayListBusStop');
  }

  /**
   * handle full page map view
   * @return $this view home_big_map
   */
  public function displayAllBus(Request $request){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
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
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
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
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $addBusStopUrl = $baseUrl.'bus_stop';
    $parameter = array(
        'nama_halte'  => $request->input('nama_halte'),
        'alamat_halte'=> $request->input('alamat_halte'),
        'latitude'    => $request->input('latitude'),
        'longitude'   => $request->input('longitude')
    );
    $response = \Httpful\Request::post($addBusStopUrl)
        ->sendsType(Mime::FORM)
        ->body(http_build_query($parameter))
        ->send();

    return redirect()->action('UserController@viewAllBus');
  }

  public function viewDetailArrival(Request $request, $arrival_code){
    $request->session()->put('arrival_code', $arrival_code);

    return redirect()->action('UserController@detailArrival');
  }

  public function detailArrival(Request $request){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
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
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $allBusStopUrl = $baseUrl.'bus_stop/all';
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
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $allBusStopUrl = $baseUrl.'bus_stop/all';
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
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $allBusUrl = $baseUrl.'bus/operation/all';
    $response = \Httpful\Request::get($allBusUrl)->send();
    $allBus = json_decode($response->raw_body, true);
    $allBus = $allBus['data'];

    $viewData = array();
    $viewData['all_bus'] = $allBus;

    return view('list_bus_operation')->with('viewData', $viewData);
  }

  public function deleteBusOperation($plat_nomor){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $deleteBusUrl = $baseUrl.'bus/operation/'.$plat_nomor;
    $response = \Httpful\Request::delete($deleteBusUrl)->send();

    return redirect()->action('UserController@viewAllBus');
  }

  public function add_bus_maintenance_web($plat_nomor){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $maintenanceBusUrl = $baseUrl.'bus/maintenance/'.$plat_nomor;
    $response = \Httpful\Request::post($maintenanceBusUrl)->send();

    return redirect()->action('UserController@viewAllBus');
  }

  public function addNewBus(Request $request){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $addBusUrl = $baseUrl.'bus/operation/add';
    $parameter = array(
        'plat_nomor' => $request->input('plat_nomor'),
        'device_id'  => $request->input('device_id'),
        'rute'       => $request->input('rute')
    );
    $response = \Httpful\Request::post($addBusUrl)
        ->sendsType(Mime::FORM)
        ->body(http_build_query($parameter))
        ->send();

    return redirect()->action('UserController@viewAllBus');
  }

  public function viewAllBusMaintenance(){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $allBusMaintenanceUrl = $baseUrl.'bus/maintenance/all';
    $response = \Httpful\Request::get($allBusMaintenanceUrl)->send();
    $allBusMaintenance = json_decode($response->raw_body, true);
    $allBusMaintenance = $allBusMaintenance['data'];

    $viewData = array();
    if(isset($allBusMaintenancep['msg'])){
      $viewData['err_msg'] = $allBusMaintenance['msg'];
    } else {
      $viewData['all_bus'] = $allBusMaintenance;
    }

    return view('list_bus_maintenance')->with('viewData', $viewData);
  }

  public function releaseBusMaintenaceWeb($plat_nomor){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $releaseBusUrl = $baseUrl.'bus/maintenance/release/'.$plat_nomor;
    $response = \Httpful\Request::post($releaseBusUrl)->send();

    return redirect()->action('UserController@viewAllBusMaintenance');
  }

  public function viewPopUpLocation(Request $request){
    $latitude = $request->input('lat');
    $longitude = $request->input('long');
    $platNomor = $request->input('busid');

    $viewData = array();
    $viewData['latitude'] = $latitude;
    $viewData['longitude'] = $longitude;
    $viewData['plat_nomor'] = $platNomor;

    return view('full_map')->with('viewData', $viewData);
  }

  public function detailMaintenanceView(Request $request){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $viewData = array();
    if($request->exists('busid')){
      $platNomor = $request->input('busid');
      $busMaintenanceUrl = $baseUrl.'bus/maintenance/'.$platNomor;
      $response = \Httpful\Request::get($busMaintenanceUrl)->send();
      $busMaintenance = json_decode($response->raw_body, true);
      $busMaintenance = $busMaintenance['data'];

      if(isset($busMaintenance['msg'])){
        $viewData['err_msg'] = $busMaintenance['msg'];
      } else {
        $viewData['data_bus'] = $busMaintenance;
      }
    }

    return view('maintenance_update_diagnosis')->with('viewData', $viewData);
  }

  public function updateMaintenanceView(Request $request){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $platNomor = $request->input('busid');
    $diagnosis = $request->input('diagnosis');

    $updateDiagnosisUrl = $baseUrl.'bus/maintenance/'.$platNomor;
    $data = array(
      'diagnosis' => $diagnosis
    );
    $response = \Httpful\Request::put($updateDiagnosisUrl)
                                ->sendsType(Mime::FORM)
                                ->body(http_build_query($data))
                                ->send();

    $allBusMaintenanceUrl = $baseUrl.'bus/maintenance/all';
    $response = \Httpful\Request::get($allBusMaintenanceUrl)->send();
    $allBusMaintenance = json_decode($response->raw_body, true);
    $allBusMaintenance = $allBusMaintenance['data'];

    $viewData = array();
    if(isset($allBusMaintenancep['msg'])){
      $viewData['err_msg'] = $allBusMaintenance['msg'];
    } else {
      $viewData['all_bus'] = $allBusMaintenance;
    }

    return view('list_bus_maintenance')->with('viewData', $viewData);
  }

  public function viewListBusFeedback(){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $getAllBusFeedbackUrl = $baseUrl.'feedback/bus/all';
    $response = \Httpful\Request::get($getAllBusFeedbackUrl)->send();
    $getAllBusFeedback = json_decode($response, true);
    $getAllBusFeedback = $getAllBusFeedback['data'];

    $viewData = array();
    $viewData['all_feedback'] = $getAllBusFeedback;

    return view('list_bus_feedback')->with('viewData', $viewData);
  }

  public function viewLisBusStopFeedback(){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $getAllBusStopUrl = $baseUrl.'feedback/bus_stop/all';
    $response = \Httpful\Request::get($getAllBusStopUrl)->send();
    $getAllBusStop = json_decode($response->raw_body, true);
    $getAllBusStop = $getAllBusStop['data'];

    $viewData = array();
    $viewData['all_bus_stop'] = $getAllBusStop;

    return view('list_bus_stop_feedback')->with('viewData', $viewData);
  }

  public function viewDetailBusStopFeedback($halte_id){
    if(getenv('APP_ENV') == 'local'){
      $baseUrl = $this->localUrl;
    }
    if(getenv('APP_ENV') == 'production'){
      $baseUrl = $this->remoteUrl;
    }

    $busStopFeedbackUrl = $baseUrl.'feedback/bus_stop/'.$halte_id;
    $response = \Httpful\Request::get($busStopFeedbackUrl)->send();
    $busStopFeedback = json_decode($response->raw_body, true);
    $busStopFeedback = $busStopFeedback['data'];

    $detailBusStopUrl = $baseUrl.'bus_stop/'.$halte_id;
    $response = \Httpful\Request::get($detailBusStopUrl)->send();
    $detailBusStop = json_decode($response->raw_body, true);
    $detailBusStop = $detailBusStop['data'];

    $viewData = array();
    $datasetRating = array();
    $counter = 0;
    foreach($busStopFeedback['detail_rating'] as $rating){
      $datasetRating[$counter] = $rating['input'];
      $counter++;
    }

    $viewData['dataset_rating'] = $datasetRating;
    $viewData['bus_stop_feedback'] = $busStopFeedback;
    $viewData['detail_bus_stop'] = $detailBusStop;

    return view('detail_bus_stop_feedback')->with('viewData', $viewData);
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
              //find out waiting time
              $waitingTime = $arrivalEstimation[0]['waktu_kedatangan'];
              $totalTime = $totalTime + $waitingTime;
              $containerRoute[$i]['plat_nomor'] = $arrivalEstimation[0]['plat_nomor'];
              $containerRoute[$i]['waiting_time'] = $waitingTime;

              //finding out travel time, make request to google distance matrix api
              //alternative 1: google distance matrix
              $param = array(
                  'units'       => 'metric',
                  'origins'     => $containerRoute[$i]['detail_origin']['latitude'].', '
                      .$containerRoute[$i]['detail_origin']['longitude'],
                  'destinations'=> $containerRoute[$i]['detail_destination']['latitude'].', '
                      .$containerRoute[$i]['detail_destination']['longitude'],
                  'key'         => 'AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU'
              );

              $url = 'https://maps.googleapis.com/maps/api/distancematrix/json?' . http_build_query($param);
              $response = \Httpful\Request::get($url)->send();
              $dataResponse = json_decode($response->raw_body, true);
              $travelTime = $dataResponse['rows'][0]['elements'][0]['duration']['value'];
              $containerRoute[$i]['travel_time'] = $travelTime;

              //alternative 2: google directions - recommended, but a lot cost
              $waypoints = '';
              $busRouteModel = new BusRoute();
              $busRoute = $busRouteModel->select('urutan')
                                        ->where('rute_id', '=', $containerRoute[$i]['rute_id'])
                                        ->where('halte_id', '=', $containerRoute[$i]['origin'])
                                        ->get()
                                        ->toArray();

              if($busRoute!=null){
                $busStopOriginOrder = $busRoute[0]['urutan'];
              }

              $busRoute = $busRouteModel->select('urutan')
                  ->where('rute_id', '=', $containerRoute[$i]['rute_id'])
                  ->where('halte_id', '=', $containerRoute[$i]['destination'])
                  ->get()
                  ->toArray();

              if($busRoute!=null){
                $busStopDestinationOrder = $busRoute[0]['urutan'];
              }

              if($busStopDestinationOrder>$busStopOriginOrder){
                //search bus stop between origin and destination directly
                $listBusRoute = $busRouteModel->whereBetween('urutan', [$busStopOriginOrder+1,
                    $busStopDestinationOrder-1])
                                          ->where('rute_id', '=', $containerRoute[$i]['rute_id'])
                                          ->with('detailHalte')
                                          ->get()
                                          ->toArray();
                $counterWaypoint = 0;
                foreach($listBusRoute as $busRoute){
                  if($counterWaypoint<22){
                    if($counterWaypoint==0){
                      $waypoints = 'via:'.$busRoute['detail_halte']['latitude'].', '
                          .$busRoute['detail_halte']['longitude'];
                    } else{
                      $waypoints = $waypoints.'|via:'.$busRoute['detail_halte']['latitude'].', '
                          .$busRoute['detail_halte']['longitude'];
                    }
                    $counterWaypoint++;
                  }
                }
              } else {
                //search bus stop between origin to max order, AND min order to destination
                $busRoute = $busRouteModel->select('urutan')
                                          ->where('rute_id', '=', $containerRoute[$i]['rute_id'])
                                          ->orderBy('urutan', 'desc')
                                          ->take(1)
                                          ->get()
                                          ->toArray();
                $busStopMaxOrder = $busRoute[0]['urutan'];

                $listBusRoute = $busRouteModel->where('rute_id', '=', $containerRoute[$i]['rute_id'])
                                          ->whereBetween('urutan', [$busStopOriginOrder+1, $busStopMaxOrder])
                                          ->with('detailHalte')
                                          ->get()
                                          ->toArray();

                //todo: waypoint loop
                $counterWaypoint = 0;
                foreach($listBusRoute as $busRoute){
                  if($counterWaypoint<15){
                    if($counterWaypoint==0){
                      $waypoints = 'via:'.$busRoute['detail_halte']['latitude'].', '
                          .$busRoute['detail_halte']['longitude'];
                    } else{
                      $waypoints = $waypoints.'|via:'.$busRoute['detail_halte']['latitude'].', '
                          .$busRoute['detail_halte']['longitude'];
                    }
                  }
                  $counterWaypoint++;
                }

                if($busStopDestinationOrder!=1){
                  $listBusRoute = $busRouteModel->where('rute_id', '=', $containerRoute[$i]['rute_id'])
                                            ->whereBetween('urutan', [1, $busStopDestinationOrder-1])
                                            ->with('detailHalte')
                                            ->get()
                                            ->toArray();

                  foreach($listBusRoute as $busRoute){
                    if($waypoints<22){
                      $waypoints = $waypoints.'|via:'.$busRoute['detail_halte']['latitude'].', '
                          .$busRoute['detail_halte']['longitude'];
                    }
                    $counterWaypoint++;
                  }
                }
              }

              $param = array(
                  'units'       => 'metric',
                  'origin'      => $containerRoute[$i]['detail_origin']['latitude'].', '
                      .$containerRoute[$i]['detail_origin']['longitude'],
                  'destination' => $containerRoute[$i]['detail_destination']['latitude'].', '
                      .$containerRoute[$i]['detail_destination']['longitude'],
                  'waypoints'   => $waypoints,
                  'key'         => 'AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU'
              );
              $url = $url = 'https://maps.googleapis.com/maps/api/directions/json?' . http_build_query($param);
              $response = \Httpful\Request::get($url)->send();
              $dataResponse = json_decode($response->raw_body, true);
              $travelTime = $dataResponse['routes'][0]['legs'][0]['duration']['value'];
              $containerRoute[$i]['travel_time'] = $travelTime;
              $totalTime = $totalTime + $travelTime;
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
