<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\BusStop;

class UserController extends Controller
{
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

  public function displayLogin(){
    return view('dashboard_login');
  }

  public function authenticateUser(Request $request){
    $userModel = new User();
    $user = $userModel->where('email', '=', $request->input('input_email'))
                      ->where('password', '=', $request->input('input_password'))
                      ->get()->toArray();

    if(sizeof($user>0) && $user!=null){
      echo sizeof($user);
      return redirect()->route('home');
    } else{
      return redirect()->action('UserController@displayLogin');
    }
  }

  public function displayHome(Request $request){
    $halte_id = $request->session()->get('halte_id');
    $baseUrl = 'http://localhost/passenger_information_system/public/api/';

    //get nearest arrival estimation
    $nearestBusUrl = $baseUrl.'nearest_bus/'.$halte_id;
    $response = \Httpful\Request::get($nearestBusUrl)->send();
    $nearestBus = json_decode($response->raw_body, true);
    $nearestBus = $nearestBus['data'];

    //get next three bus stop
    $nextBusStopUrl = $baseUrl.'get_estimation/'.$halte_id;
    $response = \Httpful\Request::get($nextBusStopUrl)->send();
    $nextBusStop = json_decode($response->raw_body, true);
    $nextBusStop = $nextBusStop['data'];

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
    //echo json_encode($viewData);

    return view('dashboard_home')->with('viewData', $viewData);
  }

  public function displayListBusStop(){
    $baseUrl = 'http://localhost/passenger_information_system/public/api/';
    $allBusStopUrl = $baseUrl.'all_bus_stop';
    $response = \Httpful\Request::get($allBusStopUrl)->send();
    $allBusStop = json_decode($response->raw_body, true);
    $allBusStop = $allBusStop['data'];

    $viewData = array();
    $viewData['bus_stop'] = $allBusStop;

    return view('list_bus_stop')->with('viewData', $viewData);
  }

  public function viewBusStop(Request $request, $halte_id){
    $request->session()->put('halte_id', $halte_id);

    return redirect()->action('UserController@displayHome');
  }

  //todo add edit bus stop view and logic
  public function editBusStop(){

  }

  public function deleteBusStop($halte_id){
    $busStopModel = new BusStop();
    $busStopModel->where('halte_id', '=', $halte_id)->delete();

    return redirect()->action('UserController@displayListBusStop');
  }
}
