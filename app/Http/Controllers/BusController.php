<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BusOperation;
use App\ArrivalEstimation;
use App\BusRoute;
use App\BusStopHistory;
use App\BusMaintenance;
use App\UserFeedback;
use App\StoreLocationModel;

class BusController extends Controller
{
  /**
   * add new bus to database
   *
   * @param Request $requests
   * @return \Illuminate\Http\JsonResponse
   */
  public function addBus(Request $requests){
    $response = array();
    try{
      $plat_nomor = $requests->input('plat_nomor');
      $rute = $requests->input('rute');
      //untuk store token bus
      $random_token = substr(md5(rand()), 0, 10);
      $deviceId = $requests->input('device_id');

      $bus = new BusOperation;
      $bus->plat_nomor = $plat_nomor;
      $bus->rute_id = $rute;
      $bus->token = $random_token;
      $bus->device_id = $deviceId;
      $bus->save();

      $response['code'] = 200;
      $response['data']['msg'] = 'bus has successfully added to database';
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'failed to save to database. Make sure you add correct parameters';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  public function displayForm(){
    return view('sign_up_bus');
  }

  public function listAllBusOperation(){
    $busOperationModel = new BusOperation();
    $listBusOperation = $busOperationModel->select('plat_nomor', 'rute_id', 'last_latitude', 'last_longitude',
        'avg_speed', 'driver_id', 'conductor_id', 'updated_at')
                                          ->get()
                                          ->toArray();

    $this->listDetailAllBus = $listBusOperation;

    return $this->statusDeviceBus();
  }

  public function getBusOperation($plat_nomor){
    $busOperationModel = new BusOperation();
    $response = array();
    try {
      $busOperation = $busOperationModel->select('plat_nomor', 'rute_id', 'last_latitude', 'last_longitude',
          'avg_speed', 'driver_id', 'conductor_id')
                                        ->where('plat_nomor', '=', $plat_nomor)
                                        ->firstOrFail();

      $response['code'] = 200;
      $response['data'] = $busOperation;
    } catch(\Exception $e){
      $response['code'] = 400;
      $response['data']['msg'] = 'bus in operation with plat nomor '.$plat_nomor.' not found. Please make sure it isnt under maintenance';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  public function getBusInRoute($rute_id){
    $busOperationModel = new BusOperation();
    $response = array();
    if($rute_id!='all'){
      $busOperation = $busOperationModel->select('plat_nomor', 'rute_id', 'last_latitude', 'last_longitude',
          'avg_speed', 'driver_id', 'conductor_id')
          ->where('rute_id', '=', $rute_id)
          ->get()
          ->toArray();
    } elseif($rute_id=='all'){
      $busOperation = $busOperationModel->select('plat_nomor', 'rute_id', 'last_latitude', 'last_longitude',
          'avg_speed', 'driver_id', 'conductor_id')
          ->get()
          ->toArray();
    }

    if($busOperation!=null){
      $response['code'] = 200;
      $response['data'] = $busOperation;
    } else {
      $response['code'] = 400;
      $response['data']['msg'] = 'no one bus operate in that route';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  public function displayListBusOperation(){

  }

  public $listDetailAllBus = array();

  /**
   * web service, executed every there is incoming request
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function statusDeviceBus(){
    $busOperationModel = new BusOperation();

    for($i=0; $i<sizeof($this->listDetailAllBus); $i++){
      $lastUpdate = $this->listDetailAllBus[$i]['updated_at'];
      $lastUpdate = new \DateTime($lastUpdate);

      $nowTime = date("Y-m-d h:i:s");
      $nowTime = new \DateTime($nowTime);
      $interval = $lastUpdate->diff($nowTime);
      $lastVisible = $interval->d . " days " . $interval->h . " hours " . $interval->i . " minutes " .
          $interval->s . "seconds ago";
      $totalInMinutes = $interval->y*12*30*24*60 + $interval->m*30*24*60 + $interval->d*24*60 + $interval->h*60 +
          $interval->i;

      $this->getNearestArrivalByBus($this->listDetailAllBus[$i]['plat_nomor'], $i);

      $this->listDetailAllBus[$i]['device_status'] = array();

      if ($totalInMinutes>=30){
        $busOperationModel->where('plat_nomor', '=', $this->listDetailAllBus[$i]['plat_nomor'])
            ->update([
                'device_status' => "trouble"
            ]);

        $this->listDetailAllBus[$i]['device_status']['status'] = "trouble";
      } else {
        $busOperationModel->where('plat_nomor', '=', $this->listDetailAllBus[$i]['plat_nomor'])
            ->update([
                'device_status' => "running"
            ]);

        $this->listDetailAllBus[$i]['device_status']['status'] = "running";
      }
      $this->listDetailAllBus[$i]['last_visible']['exact'] = $lastVisible;
      $this->listDetailAllBus[$i]['last_visible']['total'] = $totalInMinutes;
    }

    $response = array();
    $response['code'] = 200;
    $response['data'] = $this->listDetailAllBus;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  public function getNearestArrivalByBus($plat_nomor, $position){
    $arrivalEstimationModel = new ArrivalEstimation();
    $arrivalEstimation = $arrivalEstimationModel->where('plat_nomor', '=', $plat_nomor)
                                                ->orderBy('waktu_kedatangan', 'asc')
                                                ->with('thisHalte')
                                                ->with('toHalte')
                                                ->first();

    $this->listDetailAllBus[$position]['arrival'] = $arrivalEstimation;
  }

  /**
   * get remaining bus stop information based on route_id of the bus and visited bus stop
   *
   * @param $plat_nomor
   * @return \Illuminate\Http\JsonResponse
   */
  public function remainingBusStop($plat_nomor){
    $busOperationModel = new BusOperation();
    $busRouteModel = new BusRoute();
    $busStopHistoryModel = new BusStopHistory();
    $response = array();

    try{
      if($plat_nomor=='all'){
        $listBusOperation = $busOperationModel->get()
                                              ->toArray();
        $counter = 0;
        $dataContainer = array();
        foreach($listBusOperation as $busOperation){
          $busStopHistory = $busStopHistoryModel->where('plat_nomor', '=', $plat_nomor)
              ->get()
              ->toArray();

          $visitedBusStopArray = array();
          for($i=0; $i<sizeof($busStopHistory); $i++){
            $visitedBusStopArray[$i] = $busStopHistory[$i]['halte_id'];
          }

          $busRoute = $busRouteModel->where('rute_id', '=', $busOperation['rute_id'])
              ->whereNotIn('halte_id', $visitedBusStopArray)
              ->with('detailHalte')
              ->get()
              ->toArray();

          if($busRoute!=null){
            $dataContainer[$counter] = $busRoute;
          } else {
            $dataContainer[$counter]['msg'] = 'route is not registered in system';
          }

          $counter++;
        }

        $response['code'] = 200;
        $response['data'] = $dataContainer;
      } else {
        $busOperation = $busOperationModel->where('plat_nomor', '=', $plat_nomor)
                                          ->firstOrFail();

        $busStopHistory = $busStopHistoryModel->where('plat_nomor', '=', $plat_nomor)
                                              ->get()
                                              ->toArray();

        $visitedBusStopArray = array();
        for($i=0; $i<sizeof($busStopHistory); $i++){
          $visitedBusStopArray[$i] = $busStopHistory[$i]['halte_id'];
        }

        $busRoute = $busRouteModel->where('rute_id', '=', $busOperation['rute_id'])
                                  ->whereNotIn('halte_id', $visitedBusStopArray)
                                  ->with('detailHalte')
                                  ->get()
                                  ->toArray();

        $response['code'] = 200;
        if($busRoute!=null){
          $response['data'] = $busRoute;
        } else {
          $response['data']['msg'] = 'route is not registered in system';
        }
      }
    } catch(\Exception $e) {
      $response['code'] = 200;
      $response['data']['msg'] = 'bus is not registered in system';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * add bus maitenance record
   * bus maintenance most come from bus operation, so we can delete bus operatonal record for record migration
   *
   * @param $plat_nomor
   * @return \Illuminate\Http\JsonResponse
   */
  public function addBusMaintenance($plat_nomor){
    $busOperationModel = new BusOperation();
    $busMaintenanceModel = new BusMaintenance();

    $response = array();

    try {
      $busOperation = $busOperationModel->where('plat_nomor', '=', $plat_nomor)
          ->firstOrFail();
      $busOperationModel->where('plat_nomor', '=', $plat_nomor)
          ->delete();

      $busMaintenanceModel->plat_nomor = $plat_nomor;
      $busMaintenanceModel->created_at = \Carbon\Carbon::now();
      $busMaintenanceModel->updated_at = \Carbon\Carbon::now();
      $busMaintenanceModel->token = $busOperation['plat_nomor'];
      $busMaintenanceModel->save();

      $response['code'] = 200;
      $response['data']['msg'] = 'transaction successfully executed';
    } catch (\Exception $e) {
      $response['code'] = 400;
      $response['data']['msg'] = 'bus is not registered in our system';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * release maintained bus to bus operation
   *
   * @param $plat_nomor
   * @return \Illuminate\Http\JsonResponse
   */
  public function releaseBusMaintenance($plat_nomor){
    $busOperationModel = new BusOperation();
    $busMaintenanceModel = new BusMaintenance();

    $response = array();

    try{
      $busMaintenance = $busMaintenanceModel->where('plat_nomor', '=', $plat_nomor)
          ->firstOrFail();

      $busOperationModel->plat_nomor = $busMaintenance['plat_nomor'];
      $busOperationModel->device_id = $busMaintenance['token'];
      $busOperationModel->created_at = \Carbon\Carbon::now();
      $busOperationModel->updated_at = \Carbon\Carbon::now();
      $busOperationModel->last_maintenance = \Carbon\Carbon::now();
      $busOperationModel->save();

      $busMaintenance = $busMaintenanceModel->where('plat_nomor', '=', $plat_nomor)
                                            ->delete();

      $response['code'] = 200;
      $response['data']['msg'] = 'bus successfully transferred to bus in operation';
    } catch(\Exception $e){
      $response['code'] = 400;
      $response['data']['msg'] = 'maintained bus not found, make sure bus identifier is correct, or add bus to
      maintenance mode first';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * update bus maintenance diagnosis by the mechanics
   *
   * @param Request $request
   * @param $plat_nomor
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateMaintenanceBusDiagnosis(Request $request, $plat_nomor){
    $busMaintenanceModel = new BusMaintenance();
    $diagnosis = $request->input('diagnosis');
    $response = array();

    try{
      $busMaintenanceModel->where('plat_nomor', '=', $plat_nomor)
                          ->update([
                            'diagnosis'  => $diagnosis
                          ]);

      $response['code'] = 200;
      $response['data']['msg'] = 'bus diagnosis is successfully updated';
    } catch(\Exception $e){
      $response['code'] = 400;
      $response['data']['msg'] = 'bus is not found, make sure bus identifier is correct';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * return list of maintained bus if plat_nomor='all'
   * return object of particular maintained bus if specify plat_nomor
   * return not found if there is currently no one maintained bus/can't find plat_nomor in the table
   *
   * @param $plat_nomor
   * @return \Illuminate\Http\JsonResponse
   */
  public function getBusMaintenance($plat_nomor){
    $busMaintenanceModel = new BusMaintenance();
    $response = array();

    if($plat_nomor == 'all'){
      $busMaintenance = $busMaintenanceModel->select('plat_nomor', 'created_at', 'diagnosis', 'pic_id')
                                            ->get()
                                            ->toArray();
      if($busMaintenance!=null){
        $response['code'] = 200;
        $response['data'] = $busMaintenance;
      } else {
        $response['code'] = 400;
        $response['data']['msg'] = 'bus is not currently in maintenance/bus not found. make sure plat nomor exist';
      }
    } else {
      try{
        $busMaintenance = $busMaintenanceModel->select('plat_nomor', 'created_at', 'diagnosis', 'pic_id')
                                              ->where('plat_nomor', '=', $plat_nomor)
                                              ->firstOrFail();
        $response['code'] = 200;
        $response['data'] = $busMaintenance;
      } catch(\Exception $e){
        $response['code'] = 400;
        $response['data']['msg'] = 'bus is not currently in maintenance/bus not found. make sure plat nomor exist';
      }
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get all bus satisfaction summary for command center
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function allBusSatisfaction(){
    $userFeedbackModel = new UserFeedback();
    try{
      $listUserFeedback = $userFeedbackModel->select('satisfaction', 'directed_to_bus')
          ->whereNotNull('directed_to_bus')
          ->where('directed_to_bus', '!=', "")
          ->get()
          ->toArray();

      $groupUserFeedback = array();
      $counter = 0;
      foreach($listUserFeedback as $userFeedback){
        if($counter == 0){
          //initialization
          $groupUserFeedback[$counter]['plat_nomor'] = $userFeedback['directed_to_bus'];
          $groupUserFeedback[$counter]['rating'] = $userFeedback['satisfaction'];
          $groupUserFeedback[$counter]['input'] = 1;
          $counter++;
        } else {
          //this is the story begin...
          for($counterGroup = 0; $counterGroup<sizeof($groupUserFeedback); $counterGroup++){
            if($userFeedback['directed_to_bus'] == $groupUserFeedback[$counterGroup]['plat_nomor']){
              $groupUserFeedback[$counterGroup]['input']++;
              $groupUserFeedback[$counterGroup]['rating'] =
                  ($groupUserFeedback[$counterGroup]['rating']*($groupUserFeedback[$counterGroup]['input']-1) + $userFeedback['satisfaction'])
                  /$groupUserFeedback[$counterGroup]['input'];
            } else {
              $groupUserFeedback[$counter]['plat_nomor'] = $userFeedback['directed_to_bus'];
              $groupUserFeedback[$counter]['rating'] = $userFeedback['satisfaction'];
              $groupUserFeedback[$counter]['input'] = 1;
              $counter++;
            }
          }
        }
      }

      if (isset($groupUserFeedback[0])) {
        $response = array();
        $response['code'] = 200;
        $response['data'] = $groupUserFeedback;
      } else {
        $response['code'] = 400;
        $response['data']['msg'] = 'could not find rating evaluation';
      }
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'internal error, please try again later or contact administrator';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get list of feedback (praise/complaint) to certain bus operation
   *
   * @param $plat_nomor
   * @return \Illuminate\Http\JsonResponse
   */
  public function detailBusSatisfaction($plat_nomor){
    $userFeedbackModel = new UserFeedback();
    try{
      $listUserFeedback = $userFeedbackModel->where('directed_to_bus', '=', $plat_nomor)
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
        $groupUserFeedback['plat_nomor'] = $userFeedback['directed_to_bus'];
        $groupUserFeedback['input']++;
        $groupUserFeedback['rating'] = ($groupUserFeedback['rating'] + $userFeedback['satisfaction']);
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

      $groupUserFeedback['rating'] = $groupUserFeedback['rating']/$groupUserFeedback['input'];

      $groupUserFeedback['detail_rating'] = $detailRating;

      if (isset($groupUserFeedback['detail_rating'][0])) {
        $response = array();
        $response['code'] = 200;
        $response['data'] = $groupUserFeedback;
      } else {
        $response['code'] = 400;
        $response['data']['msg'] = 'could not find rating evaluation';
      }
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'internal error, please try again later or contact administrator';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get plat_nomor based bus trace
   *
   * @param $plat_nomor
   * @return \Illuminate\Http\JsonResponse
   */
  public function getBusTrace($plat_nomor){
    $busTraceModel = new StoreLocationModel();
    try{
      $busTrace = $busTraceModel->select('plat_nomor', 'route_id', 'latitude', 'longitude', 'avg_speed')
                                ->where('plat_nomor', '=', $plat_nomor)
                                ->orderBy('created_at', 'desc')
                                ->limit(200)
                                ->get()
                                ->toArray();

      $response = array();
      if($busTrace!=null){
        $response['code'] = 200;
        $response['data'] = $busTrace;
      } else {
        $response['code'] = 400;
        $response['data']['msg'] = 'bus not found, make sure plat nomor/bus identifier exist';
      }
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'internal error, please try again later or contact administrator';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * delete bus operation from database based on plat nomor
   *
   * @param $plat_nomor
   * @return \Illuminate\Http\JsonResponse
   */
  public function deleteBusOperation($plat_nomor){
    $busOperationModel = new BusOperation();
    $response = array();

    try{
      $busOperationModel->where('plat_nomor', '=', $plat_nomor)
                        ->delete();

      $response['code'] = 200;
      $response['data']['msg'] = 'bus has been successfully deleted from database';
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'failed to delete bus, please make sure that plat nomor is correct';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }
}
