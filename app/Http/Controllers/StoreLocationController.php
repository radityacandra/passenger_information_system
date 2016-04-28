<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Httpful\Httpful;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\HttpCache\Store;

use App\StoreLocationModel;
use App\BusOperation;
use App\BusStop;
use App\ArrivalEstimation;
use App\BusRoute;
use App\BusStopHistory;
use App\SpeedViolation;

use App\Helpers\RandomString;

class StoreLocationController extends Controller
{
  public $plat_nomor, $rute_id, $avg_speed;
  public $busLat, $busLon;
  /**
   * controller buat handle request post ke URI /report_location
   * attribut post ada rute_id, lat, long, speed, semua dikirim plain form request
   *
   * @param Request $requests
   * @return \Illuminate\Http\JsonResponse
   */
  public function postLocation(Request $requests){
    $plat = $requests->input('plat');
    $this->plat_nomor = $plat;

    $input_token = $requests->input('token');

    $bus = new BusOperation;
    $reference_token = $bus->select('token')->where('plat_nomor','=', $plat)->get()->toArray();

    if($input_token==$reference_token[0]['token']){
      $location = new StoreLocationModel;
      $location->route_id = $requests->input('rute_id');
      $this->rute_id = $requests->input('rute_id');
      $location->latitude = $requests->input('lat');
      $this->busLat = $requests->input('lat');
      $location->longitude = $requests->input('long');
      $this->busLon = $requests->input('long');
      $location->avg_speed = $requests->input('speed');
      $this->avg_speed = $requests->input('speed');
      $location->plat_nomor = $plat;
      $location->save();

      if($location->save()){
        $this->getLastBusStop();
        $this->selectBusHistory();
        //$this->checkBusIteration();
        $this->getAllBusStop();
        $this->updateBusOperation();
        $this->checkBusLocationStatus();
        $this->checkBusStopHistory();
        $this->detectSpeedViolation();
      }
    }
    else{
      $this->response['data']['msg'] = 'transaction failed, make sure all fields are filled';
      $this->response['code'] = 400;
      return response()->json($this->response);
    }
  }

  /**
   * buat get arrival estimation berdasarkan id bus
   * DEPRECATED
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function reportLocation(){
    $location = new StoreLocationModel;
    $data = $location->take(1)->get();
    echo json_encode($data);

    return response()->json($data);
  }

  /**
   * get token bus, need plat nomor and device_id for authorization
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function getTokenBus(Request $request){
    $plat_nomor = $request->input('plat');
    $token_secret = $request->input('token');
    $bus = new BusOperation;
    $busDetail = $bus->where('plat_nomor', '=', $plat_nomor)
                      ->where('device_id', '=', $token_secret)
                      ->get()->toArray();

    $response = array();

    if(sizeof($busDetail>0)){
      $token = RandomString::randomString();
      $bus->where('plat_nomor', '=', $plat_nomor)
          ->update(['token' => $token]);
      $response['data']['token'] = $token;
      $response['code'] = 200;
    } else{
      $response['data']['msg'] = 'device_id / plat nomor doesnt match';
      $response['code'] = 400;
    }

    return response()->json($response);
  }

  public function accessDenied(){
    return view('Forbidden');
  }

  /**
   * update bus operation current location and speed based on bus plat nomor
   */
  public function updateBusOperation(){
    $busOperationModel = new BusOperation();
    $busOperationModel->where('plat_nomor', '=', $this->plat_nomor)
                      ->update([
                          'rute_id'       => $this->rute_id,
                          'last_latitude' => $this->busLat,
                          'last_longitude'=> $this->busLon,
                          'avg_speed'     => $this->avg_speed,
                          'updated_at'    => Carbon::now()
                        ]);
  }

  public $listBusHistory;
  /**
   * get all visited bus stop based on plat nomor
   */
  public function selectBusHistory(){
    $busHistoryModel = new BusStopHistory();
    $busHistory = $busHistoryModel->where('plat_nomor', '=', $this->plat_nomor)
                                  ->get()
                                  ->toArray();
    $counter = 0;
    foreach($busHistory as $itemBusHistory){
      $this->listBusHistory[$counter] = $itemBusHistory['halte_id'];
      $counter++;
    }
  }

  /**
   * check bus post current position iteration. current iteration is every 15 seconds
   * so, if iteration is 160 (40 mins of total current location post request), system will make request to google maps
   * api (distance matrix) to avoid over quota
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function checkBusIteration(){
    $busOperationModel = new BusOperation();
    $busOperation = $busOperationModel->where('plat_nomor', '=', $this->plat_nomor)
                                      ->get()
                                      ->toArray();
    $response = array();

    if(sizeof($busOperation)>0 && $busOperation!=null){
      //if there is a record about that bus, we will take action
      if($busOperation[0]['iterasi_arrival_check'] >= 0){
        $this->getAllBusStop();
        $busOperationModel->where('plat_nomor', '=', $this->plat_nomor)
                          ->update([
                            'iterasi_arrival_check' => 0
                          ]);
      } else {
        $busOperationModel->where('plat_nomor', '=', $this->plat_nomor)
                          ->update([
                              'iterasi_arrival_check' => $busOperation[0]['iterasi_arrival_check'] + 1
                          ]);
      }
    } else {
      //if there is no record, we will throw 404 response
      $response['code'] = 404;
      $response['data']['msg'] = 'bus in operation not found, make sure plat nomor is correct and not being maintained';

      return response()->json($response);
    }
  }

  public $listBusStopDuration = array();
  /**
   * get all bus stop duration arrival to current bus route
   * EXCEPT previously visited bus stop
   * todo: filter nearest bus stop
   */
  public function getAllBusStop(){
    $counter = 0;
    $busRouteModel = new BusRoute();
    if(sizeof($this->listBusHistory) > 0){
      $listBusRoute = $busRouteModel->where('rute_id', '=', '1A')
          ->whereNotIn('halte_id', $this->listBusHistory)
          ->with('detailHalte')
          ->get()
          ->toArray();
    } else {
      $listBusRoute = $busRouteModel->where('rute_id', '=', '1A')
          ->with('detailHalte')
          ->get()
          ->toArray();
    }

    //find normally finish, normally start, and nearest bus stop
    $lastBusStop = 0; //not exist
    $firstBusStop = 0;
    $waypoints = '';

    foreach($listBusRoute as $busRoute){
      //find normally finish
      if($busRoute['urutan']>$lastBusStop){
        $lastBusStop = $busRoute['urutan'];
      }

      //handle if bus is starting operation not from start route
      if($busRoute['urutan'] == 1){
        $firstBusStop = 1;
      }
    }

    try{
      $busStopHistoryModel = new BusStopHistory();
      $busStopHistory = $busStopHistoryModel->where('plat_nomor', '=', $this->plat_nomor)
          ->where('rute_id', '=', $this->rute_id)
          ->firstOrFail();

      $nearestBusStop = $busRouteModel->where('halte_id', '=', $busStopHistory['halte_id'])
                                  ->where('rute_id', '=', $busStopHistory['rute_id'])
                                  ->orderBy('urutan', 'desc')
                                  ->first();

      $initialBusStop = $nearestBusStop['urutan']+1;
      echo 'initial bus stop: '.$initialBusStop.'<br>';
      echo 'last bus stop: '.$lastBusStop.'<br>';
      echo 'first bus stop: '.$firstBusStop.'<br>';
      //echo json_encode($response).'<br>';
      /*foreach($listBusRoute as $busRoute){
        echo $busRoute['urutan'].'<br><br>';
      }*/
      foreach($listBusRoute as $busRoute){
        echo $busRoute['urutan'].'<br><br>';
        echo 'initial bus stop: '.$initialBusStop.'<br>';
        if($initialBusStop == $busRoute['urutan']){
          echo 'condition 1 '.$busRoute['urutan'].'<br>';
          $param = array(
              'units'       => 'metric',
              'origin'     => $this->busLat . ', ' . $this->busLon,
              'destination'=> $busRoute['detail_halte']['latitude'] . ', ' . $busRoute['detail_halte']['longitude'],
              'key'         => 'AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU'
          );

          $url = 'https://maps.googleapis.com/maps/api/directions/json?' . http_build_query($param);
          echo $url.'<br>';
          $response = \Httpful\Request::get($url)->send();
          $dataResponse = json_decode($response->raw_body, true);
          $dataResponse['halte_id'] = $busRoute['detail_halte']['halte_id'];
          $this->listBusStopDuration[$counter] = $dataResponse;
          $counter++;
        } else if($busRoute['urutan'] > $initialBusStop){
          echo 'condition 2 '.$busRoute['urutan'].'<br>';
          $tempInitial = $initialBusStop;
          $selisih = $busRoute['urutan'] - $initialBusStop;
          if($selisih>15){
            $selisih = 15;
          }
          for($i = 0; $i<$selisih; $i++){
            if($i == 0){
              //initialization bus stop
              $waypoints = 'via:'.$listBusRoute[$initialBusStop]['detail_halte']['latitude'].', '
                  .$listBusRoute[$initialBusStop]['detail_halte']['longitude'];
            } else {
              $waypoints = $waypoints.'|via:'.$listBusRoute[$initialBusStop]['detail_halte']['latitude'].', '
                  .$listBusRoute[$initialBusStop]['detail_halte']['longitude'];
            }
            $initialBusStop++;
          }
          $initialBusStop = $tempInitial;

          $param = array(
              'units'       => 'metric',
              'origin'      => $this->busLat.', '.$this->busLon,
              'destination' => $busRoute['detail_halte']['latitude'].', '.$busRoute['detail_halte']['longitude'],
              'waypoints'   => $waypoints,
              'key'         => 'AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU'
          );

          $url = 'https://maps.googleapis.com/maps/api/directions/json?' . http_build_query($param);;
          echo $url.'<br>';
          $response = \Httpful\Request::get($url)->send();
          $dataResponse = json_decode($response->raw_body, true);
          $dataResponse['halte_id'] = $busRoute['detail_halte']['halte_id'];
          $this->listBusStopDuration[$counter] = $dataResponse;
          $counter++;
        } else if($busRoute['urutan'] < $initialBusStop){
          echo 'condition 3 '.$busRoute['urutan'].'<br>';
          $tempInitial = $initialBusStop;
          $selisih = $lastBusStop - $initialBusStop;
          if($selisih>15){
            $selisih = 15;
          }

          for($i = 0; $i<$selisih; $i++){
            if($i == 0){
              //initialization bus stop
              $waypoints = 'via:'.$listBusRoute[$initialBusStop]['detail_halte']['latitude'].', '
                  .$listBusRoute[$initialBusStop]['detail_halte']['longitude'];
            } else {
              $waypoints = $waypoints.'|via:'.$listBusRoute[$initialBusStop]['detail_halte']['latitude'].', '
                  .$listBusRoute[$initialBusStop]['detail_halte']['longitude'];
            }
            $initialBusStop++;
          }
          $initialBusStop = $tempInitial;

          $selisih = $initialBusStop - $busRoute['urutan'];
          if($selisih>15){
            $selisih = 15;
          }
          for($i = 0; $i<$selisih; $i++){
            $waypoints = $waypoints.'|via:'.$listBusRoute[$i]['detail_halte']['latitude'].', '
                .$listBusRoute[$i]['detail_halte']['longitude'];
          }

          $param = array(
              'units'       => 'metric',
              'origin'      => $this->busLat.', '.$this->busLon,
              'destination' => $busRoute['detail_halte']['latitude'].', '.$busRoute['detail_halte']['longitude'],
              'waypoints'   => $waypoints,
              'key'         => 'AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU'
          );

          $url = 'https://maps.googleapis.com/maps/api/directions/json?' . http_build_query($param);
          echo 'waypoints '.$waypoints.'<br>';
          echo $url.'<br>';
          $response = \Httpful\Request::get($url)->send();
          $dataResponse = json_decode($response->raw_body, true);
          $dataResponse['halte_id'] = $busRoute['detail_halte']['halte_id'];
          $this->listBusStopDuration[$counter] = $dataResponse;
          $counter++;
        }
        $waypoints='';
      }
    }catch(\Exception $e) {
      echo $e;
      foreach($response as $busRoute){
        $param = array(
            'units'       => 'metric',
            'origin'     => $this->busLat . ', ' . $this->busLon,
            'destination'=> $busRoute['detail_halte']['latitude'] . ', ' . $busRoute['detail_halte']['longitude'],
            'key'         => 'AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU'
        );

        $url = 'https://maps.googleapis.com/maps/api/directions/json?' . http_build_query($param);
        $response = \Httpful\Request::get($url)->send();
        $dataResponse = json_decode($response->raw_body, true);
        $dataResponse['halte_id'] = $busRoute['detail_halte']['halte_id'];
        $this->listBusStopDuration[$counter] = $dataResponse;
        $counter++;
      }
    }

    $this->makeOrUpdateAllArrivalEstimation();
  }

  public $nearestBusStop = array();
  /**
   * get nearest bus stop between all bus stop duration grabbed from google distance matrix
   * todo: get last bus stop
   */
  public function filterNearestBusStop(){
    $counter = 0;
    foreach ($this->listBusStopDuration as $durationResponse){

      if($counter == 0){
        $this->nearestBusStop = $durationResponse;
      } else{
        if((integer)$durationResponse['routes'][0]['legs'][0]['duration']['value'] < (integer)
            $this->nearestBusStop['routes'][0]['legs'][0]['duration']['value']){
          $this->nearestBusStop = $durationResponse;
        }
      }

      $counter++;
    }
  }

  public $busStop = array();
  /*
   * get last visited bus stop bus operation
   * todo: make/update arrival estimation
   */
  public function getLastBusStop(){
    $busStopModel = new BusStop();
    $busStop = $busStopModel->where('last_bus', '=', $this->plat_nomor)
                            ->orderBy('halte_id', 'desc')
                            ->first();
    $this->busStop = $busStop;
  }

  public $response = array();
  /**
   * insert or update arrival estimation
   * if it already exist, just update
   * if it not exist yet, insert new arrival estimation
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function makeOrUpdateAllArrivalEstimation(){
    foreach($this->listBusStopDuration as $busStopDuration){
      $arrivalEstimationModel = new ArrivalEstimation();
      $arrivalEstimation = $arrivalEstimationModel->where('plat_nomor', '=', $this->plat_nomor)
          ->where('halte_id_tujuan', '=', $busStopDuration['halte_id'])
          ->first();

      //echo $busStopDuration['rows'][0]['elements'][0]['duration']['value'].'<br />';

      if(sizeof($arrivalEstimation) == 0){
        //make new record in arrival_estimation
        $arrivalEstimationModel1 = new ArrivalEstimation();
        $arrivalEstimationModel1->created_at = Carbon::now();
        $arrivalEstimationModel1->updated_at = Carbon::now();
        $arrivalEstimationModel1->halte_id_tujuan = $busStopDuration['halte_id'];
        //if bus is just depart from garage, halte id is empty, then we must prepare
        if(isset($this->busStop['halte_id'])){
          $arrivalEstimationModel1->halte_id_asal = $this->busStop['halte_id'];
        }
        $arrivalEstimationModel1->waktu_kedatangan = $busStopDuration['routes'][0]['legs'][0]['duration']['value'];
        $arrivalEstimationModel1->jarak = $busStopDuration['routes'][0]['legs'][0]['distance']['value'];
        $arrivalEstimationModel1->rute_id = $this->rute_id;
        $arrivalEstimationModel1->plat_nomor = $this->plat_nomor;
        $arrivalEstimationModel1->save();
        $this->response['code'] = 200;
        $this->response['data']['msg'] = 'make new arrival estimation';
      } else{
        //update value in arrival_estimation
        //if bus is just depart from garage, halte id is empty, then we must prepare
        $halte_id_asal = 0;
        if(isset($this->busStop['halte_id'])){
          $halte_id_asal = $this->busStop['halte_id'];
        }

        $arrivalEstimationModel2 = new ArrivalEstimation();
        $arrivalEstimationModel2->where('plat_nomor', '=', $this->plat_nomor)
                                ->where('halte_id_tujuan', '=', $busStopDuration['halte_id'])
                                ->update([
                                    'updated_at'      => Carbon::now(),
                                    'waktu_kedatangan'=>
                                        $busStopDuration['routes'][0]['legs'][0]['duration']['value'],
                                    'jarak'           =>
                                        $busStopDuration['routes'][0]['legs'][0]['distance']['value'],
                                    'halte_id_asal'   => $halte_id_asal
                                ]);
        $this->response['code'] = 200;
        $this->response['data']['msg'] = 'update arrival estimation';
      }
    }

    echo json_encode($this->response);
  }

  /**
   * check if bus has arrived to nearest bus stop on its route
   * todo: detect if bus has arrived to certain bus stop
   */
  public function checkBusLocationStatus(){
    $this->filterNearestBusStop();
    if($this->nearestBusStop['routes'][0]['legs'][0]['distance']['value']<=15){
      $arrivalEstimationModel = new ArrivalEstimation();
      $arrivalEstimationModel->where('halte_id_tujuan', '=', $this->nearestBusStop['halte_id'])
                              ->delete();

      $busStop = new BusStop();
      $busStop->where('halte_id', '=', $this->nearestBusStop['halte_id'])
              ->update(['last_bus' => $this->plat_nomor]);

      $busStopHistoryModel = new BusStopHistory();
      $busStopHistoryModel->plat_nomor = $this->plat_nomor;
      $busStopHistoryModel->halte_id = $this->nearestBusStop['halte_id'];
      $busStopHistoryModel->rute_id = $this->rute_id;
      $busStopHistoryModel->save();
    }
  }

  /**
   * check bus stop history,
   * if last visited bus is the last bus stop on its route, then delete record that related to that bus
   */
  public function checkBusStopHistory(){

    $busStopHistoryModel = new BusStopHistory();
    $busStopHistory = $busStopHistoryModel->where('plat_nomor', '=', $this->plat_nomor)
                                          ->orderBy('arrival_history', 'desc')
                                          ->with('routeOrder')
                                          ->take(1)
                                          ->get()
                                          ->toArray();

    if(sizeof($busStopHistory > 0) && $busStopHistory!=null){
      $busRouteModel = new BusRoute();
      $lastRouteOrder = $busRouteModel->where('rute_id', '=', $busStopHistory[0]['rute_id'])
          ->orderBy('urutan', 'desc')
          ->take(1)
          ->get()
          ->toArray();

      //if bus has reach the last bus stop on its route, then delete related record
      if($busStopHistory[0]['route_order']['urutan'] == $lastRouteOrder[0]['urutan']){
        $busStopHistoryModel = new BusStopHistory();
        $busStopHistoryModel->where('plat_nomor', '=', $this->plat_nomor)
                            ->delete();
      }
    }
  }

  /**
   * detect bus speed, if above safe level, we will report it!
   * todo: report it!
   */
  public function detectSpeedViolation(){
    $plat_nomor = $this->plat_nomor;
    $speed = $this->avg_speed;
    $speedViolationModel = new SpeedViolation();
    $speedViolation = $speedViolationModel->where('plat_nomor', '=', $plat_nomor)
                                          ->get()
                                          ->toArray();

    if($speed>60){
      if(sizeof($speedViolation)>0 && $speedViolation!=null){
        $speedViolationModel->where('plat_nomor', '=', $plat_nomor)
                            ->update([
                              'updated_at'      => \Carbon\Carbon::now(),
                              'speed_violation' => $speed,
                              'on_violation'    => true,
                              'count_violation' => $speedViolation[0]['count_violation'] + 1
                            ]);
      } else {
        $speedViolationModel->created_at = \Carbon\Carbon::now();
        $speedViolationModel->updated_at = \Carbon\Carbon::now();
        $speedViolationModel->plat_nomor = $plat_nomor;
        $speedViolationModel->on_violation = true;
        $speedViolationModel->count_violation = 1;
        $speedViolationModel->save();
      }
    } else {
      if(sizeof($speedViolation)>0){
        $speedViolationModel->where('plat_nomor', '=', $plat_nomor)
                            ->update([
                                'updated_at'      => \Carbon\Carbon::now(),
                                'on_violation'    => false
                            ]);
      }
    }
  }

  /**
   * get list of / 1 object bus that did minimum one speed violation
   *
   * @param $plat_nomor
   * @return \Illuminate\Http\JsonResponse
   */
  public function listBusViolation($plat_nomor){
    $speedViolationModel = new SpeedViolation();
    $response = array();
    if($plat_nomor == 'all'){
      $speedViolation = $speedViolationModel->where('on_violation', '=', true)
                                            ->get()
                                            ->toArray();
      $response['data'] = $speedViolation;
      $response['code'] = 200;
    } else {
      try{
        $speedViolation = $speedViolationModel->where('plat_nomor', '=', $plat_nomor)
                                              ->firstOrFail();
        $response['data'] = $speedViolation;
        $response['code'] = 200;
      } catch (\Exception $e){
        $response['data']['msg'] = 'Bus never did a single violation';
        $response['code'] = 200;
      }
    }

    return response()->json($response);
  }
}
