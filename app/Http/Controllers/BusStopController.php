<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ArrivalEstimation;
use App\BusStopHistory;
use App\BusStop;
use App\InfoLive;
use App\BusRoute;
use App\UserFeedback;

use App\Helpers\SplitParagraph;

class BusStopController extends Controller
{

  public $listArrivalEstimation;

  /**
   * get arrival estimation for certain halte_id
   *
   * @param $halte_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function getArrivalEstimation($halte_id){
    $arrivalEstimationModel = new ArrivalEstimation();
    $arrivalEstimation = $arrivalEstimationModel->where('halte_id_tujuan', '=', $halte_id)
                                                ->orderBy('waktu_kedatangan', 'asc')
                                                ->take(10)
                                                ->get()
                                                ->toArray();

    $this->listArrivalEstimation = $arrivalEstimation;

    $response = array();
    $response['code'] = 200;
    $response['data'] = $this->listArrivalEstimation;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  public $nearestArrivalEtimation = array();

  /**
   * get nearest bus heading to certain bus stop
   *
   * @param $halte_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function getNearestArrivalEstimation($halte_id){
    $arrivalEstimationModel = new ArrivalEstimation();
    $arrivalEstimation = $arrivalEstimationModel->where('halte_id_tujuan', $halte_id)
                                                ->orderBy('waktu_kedatangan', 'asc')
                                                ->take(1)
                                                ->get()
                                                ->toArray();

    $this->nearestArrivalEtimation = $arrivalEstimation[0];

    $response = array();
    $response['code'] = 200;
    $response['data'] = $this->nearestArrivalEtimation;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get 10 most recent departure from certain bus stop
   *
   * @param $halte_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function getDepartureHistory($halte_id){
    $busStopHistoryModel = new BusStopHistory();
    $busStopHistory = $busStopHistoryModel->where('halte_id', '=', $halte_id)
                                          ->orderBy('arrival_history', 'desc')
                                          ->take(10)
                                          ->get()
                                          ->toArray();

    $response = array();
    $response['code'] = 200;
    $response['data'] = $busStopHistory;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get bus stop detail
   *
   * @param $halte_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function detailBusStop($halte_id){
    $busStopModel = new BusStop();
    $busStop = $busStopModel->where('halte_id', '=', $halte_id)
                            ->first();

    $response = array();
    $response['code'] = 200;
    $response['data'] = $busStop;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get three most recent news update
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function getNewsFeed(){
    $infoModel = new InfoLive();
    $listInfo = $infoModel->orderBy('news_id', 'desc')
                          ->take(3)
                          ->get()
                          ->toArray();

    for($i = 0; $i<sizeof($listInfo); $i++){
      $listInfo[$i]['content'] = SplitParagraph::splitParagraph($listInfo[$i]['content']);
    }

    $response = array();
    $response['code'] = 200;
    $response['data'] = $listInfo;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get list all bus stop
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function getAllBusStop(){
    $busStopModel = new BusStop();
    $listBusStop = $busStopModel->get()
                                ->toArray();

    $response = array();
    $response['code'] = 200;
    $response['data'] = $listBusStop;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get next three bus stop in nearest arrival schedule
   *
   * @param $halte_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function nextBusStop($halte_id){
    $arrivalEstimationModel = new ArrivalEstimation();
    $arrivalEstimation = $arrivalEstimationModel->where('halte_id_tujuan', $halte_id)
        ->orderBy('waktu_kedatangan', 'asc')
        ->take(1)
        ->get()
        ->toArray();

    $rute_id = $arrivalEstimation[0]['rute_id'];

    $busRouteModel = new BusRoute();
    $busRouteOrder = $busRouteModel->where('rute_id', '=', $rute_id)
                                    ->where('halte_id', '=', $halte_id)
                                    ->first();

    $nextOrder = array();
    for($i = 0; $i < 3; $i++){
      $nextOrder[$i] = $busRouteOrder['urutan'] + $i + 1;
    }

    $busRouteModel = new BusRoute();
    $nextOrder = $busRouteModel->where('rute_id', '=', $rute_id)
                                ->whereIn('urutan', $nextOrder)
                                ->with('detailHalte')
                                ->get()
                                ->toArray();

    $response = array();
    $response['code'] = 200;
    $response['data'] = $nextOrder;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get all arrival estimation, for admin
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function allArrivalEstimation(){
    $arrivalEstimationModel = new ArrivalEstimation();
    $arrivalEstimation = $arrivalEstimationModel->with('thisHalte')
                                                ->with('toHalte')
                                                ->get()
                                                ->toArray();

    $response = array();
    $response['code'] = 200;
    $response['data'] = $arrivalEstimation;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get certain arrival code by arrival code
   *
   * @param $arrival_code
   * @return \Illuminate\Http\JsonResponse
   */
  public function getArrivalEstimationByCode($arrival_code){
    $arrivalEstimationModel = new ArrivalEstimation();
    $arrivalEstimation = $arrivalEstimationModel->where('arrival_code', '=', $arrival_code)
                                                ->with('thisHalte')
                                                ->with('toHalte')
                                                ->first();

    $response = array();
    $response['code'] = 200;
    $response['data'] = $arrivalEstimation;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get all bus stop satisfaction for command center
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function allBusStopSatisfaction(){
    $userFeedbackModel = new UserFeedback();

    $listUserFeedback = $userFeedbackModel->select('satisfaction', 'directed_to_bus_stop')
                                          ->whereNotNull('directed_to_bus_stop')
                                          ->where('directed_to_bus_stop', '!=', 0)
                                          ->get()
                                          ->toArray();

    $groupUserFeedback = array();
    $counter = 0;
    foreach($listUserFeedback as $userFeedback){
      if($counter == 0){
        //initialization
        $groupUserFeedback[$counter]['halte_id'] = $userFeedback['directed_to_bus_stop'];
        $groupUserFeedback[$counter]['rating'] = $userFeedback['satisfaction'];
        $groupUserFeedback[$counter]['input'] = 1;
        $counter++;
      } else {
        //this is the story begin...
        for($counterGroup = 0; $counterGroup<sizeof($groupUserFeedback); $counterGroup++){
          if($userFeedback['directed_to_bus_stop'] == $groupUserFeedback[$counterGroup]['halte_id']){
            $groupUserFeedback[$counterGroup]['input']++;
            $groupUserFeedback[$counterGroup]['rating'] =
                ($groupUserFeedback[$counterGroup]['rating'] + $userFeedback['satisfaction'])
                /$groupUserFeedback[$counterGroup]['input'];
          } else {
            $groupUserFeedback[$counter]['halte_id'] = $userFeedback['directed_to_bus_stop'];
            $groupUserFeedback[$counter]['rating'] = $userFeedback['satisfaction'];
            $groupUserFeedback[$counter]['input'] = 1;
            $counter++;
          }
        }
      }
    }

    $response = array();
    $response['code'] = 200;
    $response['data'] = $groupUserFeedback;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get detail feedback (praise/complaint) to certain bus stop
   *
   * @param $halte_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function detailBusStopSatisfaction($halte_id){
    $userFeedbackModel = new UserFeedback();
    $listUserFeedback = $userFeedbackModel->where('directed_to_bus_stop', '=', $halte_id)
                                          ->get()
                                          ->toArray();

    $groupUserFeedback = array();
    $groupUserFeedback['rating'] = 0;
    $groupUserFeedback['input'] = 0;
    $counter = 0;
    foreach($listUserFeedback as $userFeedback){
      $groupUserFeedback['halte_id'] = $userFeedback['directed_to_bus_stop'];
      $groupUserFeedback['input']++;
      $groupUserFeedback['rating'] = ($groupUserFeedback['rating'] + $userFeedback['satisfaction'])
          /$groupUserFeedback['input'];
      $groupUserFeedback['feedback'][$counter] = $userFeedback['complaint'];
      $counter++;
    }

    $response = array();
    $response['code'] = 200;
    $response['data'] = $groupUserFeedback;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get all route that passing certain bus stop
   *
   * @param $halte_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function getRoutePassingBusStop($halte_id){
    $busRouteModel = new BusRoute();
    $busRoute = $busRouteModel->select('rute_id')
                              ->where('halte_id', '=', $halte_id)
                              ->groupBy('rute_id')
                              ->get()
                              ->toArray();

    $response = array();

    if($busRoute!=null){
      $response['code'] = 200;
      $response['data'] = $busRoute;
    } else {
      $response['code'] = 404;
      $response['data']['msg'] = 'bus stop is not registered in system, make sure you make correct request.';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }
}
