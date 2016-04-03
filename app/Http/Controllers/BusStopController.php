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

use App\Helpers\SplitParagraph;

class BusStopController extends Controller
{

  public $listArrivalEstimation;
  /**
   * get arrival estimation for certain halte_id
   * @param $halte_id
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
    echo json_encode($response);
  }

  public $nearestArrivalEtimation = array();
  /**
   * get nearest bus heading to certain bus stop
   * @param $halte_id
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
    echo json_encode($response);
  }

  /**
   * get 10 most recent departure from certain bus stop
   * @param $halte_id
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
    echo json_encode($response);
  }

  /**
   * get bus stop detail
   * @param $halte_id
   */
  public function detailBusStop($halte_id){
    $busStopModel = new BusStop();
    $busStop = $busStopModel->where('halte_id', '=', $halte_id)
                            ->first();

    $response = array();
    $response['code'] = 200;
    $response['data'] = $busStop;
    echo json_encode($response);
  }

  /**
   * get three most recent news update
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
    echo json_encode($response);
  }

  /**
   * get list all bus stop
   */
  public function getAllBusStop(){
    $busStopModel = new BusStop();
    $listBusStop = $busStopModel->get()
                                ->toArray();

    $response = array();
    $response['code'] = 200;
    $response['data'] = $listBusStop;
    echo json_encode($response);
  }

  /**
   * get next three bus stop in nearest arrival schedule
   * @param $halte_id
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
    echo json_encode($response);
  }

  /**
   * get all arrival estimation, for admin
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
    echo json_encode($response);
  }
}
