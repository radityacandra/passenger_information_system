<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\ArrivalEstimation;
use App\BusStopHistory;
use App\BusStop;

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

  public function detailBusStop($halte_id){
    $busStopModel = new BusStop();
    $busStop = $busStopModel->where('halte_id', '=', $halte_id)
                            ->first();

    $response = array();
    $response['code'] = 200;
    $response['data'] = $busStop;
    echo json_encode($response);
  }
}
