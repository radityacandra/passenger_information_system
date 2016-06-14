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

  /**
   * read incoming request and add new bus stop to database
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function addBusStop(Request $request){
    $busStopModel = new BusStop();
    $response = array();

    try{
      $busStopModel->nama_halte = $request->input('nama_halte');
      $busStopModel->lokasi_halte = $request->input('alamat_halte');
      $busStopModel->latitude = $request->input('latitude');
      $busStopModel->longitude = $request->input('longitude');
      $busStopModel->save();

      $response['code'] = 200;
      $response['data']['msg'] = 'bus stop has successfully added to database';
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'failed to save bus stop. Make sure you attach correct parameters';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  public function updateBusStop($halteId, Request $request){
    $busStopModel = new BusStop();
    $response = array();

    try{
      $response['code'] = 400;
      $response['data']['msg'] = 'noting updated, please check if your request is correct';

      if($request->exists('nama_halte')){
        $busStopModel->where('halte_id', '=', $halteId)
            ->update([
              'nama_halte' => $request->input('nama_halte')
            ]);

        $response['code'] = 200;
        $response['data']['msg'] = 'Nama halte has been updated';
      }

      if($request->exists('alamat_halte')){
        $busStopModel->where('halte_id', '=', $halteId)
                    ->update([
                      'lokasi_halte'  => $request->input('alamat_halte')
                    ]);

        $response['code'] = 200;
        $response['data']['msg'] = 'Lokasi halte has been updated';
      }

      if($request->exists('latitude')){
        $busStopModel->where('halte_id', '=', $halteId)
                     ->update([
                       'latitude' => $request->input('latitude')
                     ]);

        $response['code'] = 200;
        $response['data']['msg'] = 'latitude halte has been updated';
      }

      if($request->exists('longitude')){
        $busStopModel->where('halte_id', '=', $halteId)
                     ->update([
                       'longitude'  => $request->input('longitude')
                     ]);

        $response['code'] = 200;
        $response['data']['msg'] = 'longitude halte has been updated';
      }
    }catch (\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'internal error, please try again later or contact administrator';
    }

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

    $detailRating = array();
    $detailRating[0]['rating'] = 1;
    $detailRating[0]['input'] = 0;
    $detailRating[1]['rating'] = 2;
    $detailRating[1]['input'] = 0;
    $detailRating[2]['rating'] = 3;
    $detailRating[2]['input'] = 0;
    $detailRating[3]['rating'] = 4;
    $detailRating[3]['input'] = 0;
    $detailRating[4]['rating'] = 5;
    $detailRating[4]['input'] = 0;

    foreach($listUserFeedback as $userFeedback){
      $groupUserFeedback['halte_id'] = $userFeedback['directed_to_bus_stop'];
      $groupUserFeedback['input']++;
      $groupUserFeedback['rating'] = ($groupUserFeedback['rating'] + $userFeedback['satisfaction'])
          /$groupUserFeedback['input'];
      $groupUserFeedback['feedback'][$counter] = $userFeedback['complaint'];

      if($userFeedback['satisfaction'] == 1){
        $detailRating[0]['input']++;
      } elseif($userFeedback['satisfaction'] == 2){
        $detailRating[1]['input']++;
      } elseif($userFeedback['satisfaction'] == 3){
        $detailRating[2]['input']++;
      } elseif($userFeedback['satisfaction'] == 4){
        $detailRating[3]['input']++;
      } elseif($userFeedback['satisfaction'] == 5){
        $detailRating[4]['input']++;
      }

      $counter++;
    }

    $groupUserFeedback['detail_rating'] = $detailRating;

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

  /**
   * delete certain bus stop from database
   *
   * @param $halte_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function deleteBusStop($halte_id){
    $busStopModel = new BusStop();
    $response = array();

    try{
      $busStopModel->where('halte_id', '=', $halte_id)
          ->delete();

      $response['code'] = 200;
      $response['data']['msg'] = 'bus stop has been successfully deleted from database';
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'failed to delete bus stop. Make sure halte id is correct.';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }
}
