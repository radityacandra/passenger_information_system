<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Httpful\Httpful;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Mockery\CountValidator\Exception;
use Symfony\Component\HttpKernel\HttpCache\Store;

use App\StoreLocationModel;
use App\BusOperation;
use App\BusStop;
use App\ArrivalEstimation;
use App\BusRoute;
use App\BusStopHistory;
use App\SpeedViolation;
use App\Route;

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
		$routeModel = new route();
		
		$plat = $requests->input('plat');
		$this->plat_nomor = $plat;
		
		$input_token = $requests->input('token');
		
		$bus = new BusOperation;
		$reference_token = $bus->select('token')->where('plat_nomor','=', $plat)->get()->toArray();
		
		try {
			if($input_token==$reference_token[0]['token']){
				$location = new StoreLocationModel;
				$location->route_id = $requests->input('rute_id');
				$this->rute_id = $requests->input('rute_id');
				
				$routeModel->where('rute_id', '=', $this->rute_id)
						->firstOrFail();
				$flagCheck = $this->checkBusIteration();
				
				$location->latitude = $requests->input('lat');
				$this->busLat = $requests->input('lat');
				$location->longitude = $requests->input('long');
				$this->busLon = $requests->input('long');
				$location->avg_speed = $requests->input('speed');
				$this->avg_speed = $requests->input('speed');
				$location->plat_nomor = $plat;
				$location->save();
				
				if($flagCheck){
					if($location->save()){
						$this->getLastBusStop();
						$this->selectBusHistory();
						try{
							$this->getAllBusStop();
						} catch(\Exception $e){
							$this->response['data']['msg'] = 'internal error, cannot make request to third pary service or temporary connection down, please try again or report it';
							$this->response['code'] = 500;
							header("Access-Control-Allow-Origin: *");
							return response()->json($this->response);
						}
						$this->updateBusOperation();
						$this->checkBusLocationStatus();
						$this->checkBusStopHistory();
						$this->detectSpeedViolation();
						
						//all operation successfull
						header("Access-Control-Allow-Origin: *");
						return response()->json($this->response);
					} else {
						$this->response['data']['msg'] = 'internal error, cannot save data to database, please try again or report it';
						$this->response['code'] = 500;
						
						header("Access-Control-Allow-Origin: *");
						return response()->json($this->response);
					}
				} else {
					$this->updateBusOperation();
					$this->response['code'] = 200;
					$this->response['data']['msg'] = 'update bus coordinate location';
					
					header("Access-Control-Allow-Origin: *");
					return response()->json($this->response);
				}
			} else {
				$this->response['data']['msg'] = 'transaction failed, make sure you enter a valid token';
				$this->response['code'] = 400;
				header("Access-Control-Allow-Origin: *");
				return response()->json($this->response);
			}
		} catch(\Exception $e){
			$this->response['data']['msg'] = 'one or more of your parameter value is invalid, make sure you send correct parameter';
			$this->response['code'] = 400;
			header("Access-Control-Allow-Origin: *");
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

    header("Access-Control-Allow-Origin: *");
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
   * check bus post current position iteration. current iteration is every 1,5 minutes
   * so, if iteration is 160 (40 mins of total current location post request), system will make request to google maps
   * api (directions) to avoid over quota
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function checkBusIteration(){
    $busOperationModel = new BusOperation();
    $busOperation = $busOperationModel->where('plat_nomor', '=', $this->plat_nomor)
                                      ->get()
                                      ->toArray();

    if(sizeof($busOperation)>0 && $busOperation!=null){
      //if there is a record about that bus, we will take action
      if($busOperation[0]['iterasi_arrival_check'] >= 4){
        $busOperationModel->where('plat_nomor', '=', $this->plat_nomor)
                          ->update([
                            'iterasi_arrival_check' => 0
                          ]);

        return false;
      } else {
        $busOperationModel->where('plat_nomor', '=', $this->plat_nomor)
                          ->update([
                              'iterasi_arrival_check' => $busOperation[0]['iterasi_arrival_check'] + 1
                          ]);
        return true;
      }
    } else {
      //if there is no record, exception will be thrown
      throw new Exception("Bus Not Found");
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
      $listBusRoute = $busRouteModel->where('rute_id', '=', $this->rute_id)
          ->whereNotIn('halte_id', $this->listBusHistory)
          ->with('detailHalte')
          ->get()
          ->toArray();
    } else {
      $listBusRoute = $busRouteModel->where('rute_id', '=', $this->rute_id)
          ->with('detailHalte')
          ->get()
          ->toArray();
    }

    //find normally finish, normally start, and nearest bus stop
    $lastBusStop = 0; //not exist
    $firstBusStop = 0;
    $indexLastBusStop = -1;
    $indexFirstBusStop = -1;
    $indexInitialBusStop = -1;
    $waypoints = '';
    $busStopIdWaypoint = '';

    try{
      $busStopHistoryModel = new BusStopHistory();
      $busStopHistory = $busStopHistoryModel->where('plat_nomor', '=', $this->plat_nomor)
          ->where('rute_id', '=', $this->rute_id)
          ->orderBy('arrival_history', 'desc')
          ->get()
          ->toArray();

      if($busStopHistory==null){
        throw new \Exception('arrival history not found');
      }

      $nearestBusStop = $busRouteModel->where('halte_id', '=', $busStopHistory[0]['halte_id'])
                                  ->where('rute_id', '=', $busStopHistory[0]['rute_id'])
                                  ->orderBy('urutan', 'desc')
                                  ->first();

      $initialBusStop = $nearestBusStop['urutan']+1;

      foreach($listBusRoute as $busRoute){
        //find normally finish
        if($busRoute['urutan']>$lastBusStop){
          $lastBusStop = $busRoute['urutan'];
          $indexLastBusStop = $counter;
        }

        //handle if bus is starting operation not from start route
        if($busRoute['urutan'] == 1){
          $firstBusStop = 1;
          $indexFirstBusStop = 0;
        }

        if($busRoute['urutan'] == $initialBusStop){
          $indexInitialBusStop = $counter;
        }
        $counter++;
      }

      $counter = 0;

//      echo 'initial bus stop: '.$initialBusStop.'<br>';
//      echo 'index initial bus stop: '.$indexInitialBusStop.'<br>';
//      echo 'last bus stop: '.$lastBusStop.'<br>';
//      echo 'index last bus stop: '.$indexLastBusStop.'<br>';
//      echo 'first bus stop: '.$firstBusStop.'<br>';
//      echo 'index first bus stop: '.$indexFirstBusStop.'<br>';

      foreach($listBusRoute as $busRoute){
//        echo $busRoute['urutan'].'<br><br>';
//        echo 'initial bus stop: '.$initialBusStop.'<br>';
        if($initialBusStop == $busRoute['urutan']){
          //if bus stop being estimated is nearest bus stop
//          echo 'condition 1 '.$busRoute['urutan'].'<br>';
          $param = array(
              'units'       => 'metric',
              'origin'     => $this->busLat . ', ' . $this->busLon,
              'destination'=> $busRoute['detail_halte']['latitude'] . ', ' . $busRoute['detail_halte']['longitude'],
              'key'         => 'AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU'
          );

          $url = 'https://maps.googleapis.com/maps/api/directions/json?' . http_build_query($param);
//          echo $url.'<br>';
          $response = \Httpful\Request::get($url)->send();
          $dataResponse = json_decode($response->raw_body, true);
          $dataResponse['halte_id'] = $busRoute['detail_halte']['halte_id'];
          $this->listBusStopDuration[$counter] = $dataResponse;
          $counter++;
        } else if($busRoute['urutan'] > $initialBusStop){
          //if bus stop being estimated is bus stop next to nearest bus stop
          //example: nearest => 5, next bus => 6,7
//          echo 'condition 2 '.$busRoute['urutan'].'<br>';
          $tempIndexInitial = $indexInitialBusStop;
          $selisih = $counter - $indexInitialBusStop;
          if($selisih>15){
            $selisih = 15;
          }
          for($i = 0; $i<$selisih; $i++){
            if($i == 0){
              //initialization bus stop
              $waypoints = 'via:'.$listBusRoute[$indexInitialBusStop]['detail_halte']['latitude'].', '
                  .$listBusRoute[$initialBusStop]['detail_halte']['longitude'];
              //for debugging purpose
              $busStopIdWaypoint = $listBusRoute[$indexInitialBusStop]['detail_halte']['halte_id'];
            } else {
              $waypoints = $waypoints.'|via:'.$listBusRoute[$indexInitialBusStop]['detail_halte']['latitude'].', '
                  .$listBusRoute[$initialBusStop]['detail_halte']['longitude'];
              //for debugging purpose
              $busStopIdWaypoint = $busStopIdWaypoint.', '.$listBusRoute[$indexInitialBusStop]['detail_halte']['halte_id'];
            }
            $indexInitialBusStop++;
          }
          $indexInitialBusStop = $tempIndexInitial;

          $param = array(
              'units'       => 'metric',
              'origin'      => $this->busLat.', '.$this->busLon,
              'destination' => $busRoute['detail_halte']['latitude'].', '.$busRoute['detail_halte']['longitude'],
              'waypoints'   => $waypoints,
              'key'         => 'AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU'
          );

          $url = 'https://maps.googleapis.com/maps/api/directions/json?' . http_build_query($param);
//          echo $url.'<br>';
//          echo 'route waypoints: '.$busStopIdWaypoint.'<br>';
          $response = \Httpful\Request::get($url)->send();
          $dataResponse = json_decode($response->raw_body, true);
          $dataResponse['halte_id'] = $busRoute['detail_halte']['halte_id'];
          $this->listBusStopDuration[$counter] = $dataResponse;
          $counter++;
        } else if($busRoute['urutan'] < $initialBusStop){
          /**********************************************************************
           * if bus stop being estimated is before the nearest bus stop         *
           * this case only happen if bus start not from the beginning of route *
           * example rute 1A => 1,2,3,4,5,6,7,8,9                               *
           * bus start from garage and heading to 4                             *
           * then estimation for 2 is through waypoint 5,6,7,8,9,1              *
           **********************************************************************/
//          echo 'condition 3 '.$busRoute['urutan'].'<br>';
          $tempIndexInitial = $indexInitialBusStop;
          $selisih = $indexLastBusStop - $indexInitialBusStop;
          if($selisih>15){
            $selisih = 15;
          }

          for($i = 0; $i<$selisih; $i++){
            if($i == 0){
              //initialization bus stop
              $waypoints = 'via:'.$listBusRoute[$indexInitialBusStop]['detail_halte']['latitude'].', '
                  .$listBusRoute[$initialBusStop]['detail_halte']['longitude'];
              //for debugging purpose
              $busStopIdWaypoint = $listBusRoute[$indexInitialBusStop]['detail_halte']['halte_id'];
            } else {
              $waypoints = $waypoints.'|via:'.$listBusRoute[$indexInitialBusStop]['detail_halte']['latitude'].', '
                  .$listBusRoute[$initialBusStop]['detail_halte']['longitude'];
              //for debugging purpose
              $busStopIdWaypoint = $busStopIdWaypoint.', '.$listBusRoute[$indexInitialBusStop]['detail_halte']['halte_id'];
            }
            $indexInitialBusStop++;
          }
          $indexInitialBusStop = $tempIndexInitial;

          $selisih = $counter - $indexFirstBusStop;
          if($selisih>15){
            $selisih = 15;
          }
          for($i = 0; $i<$selisih; $i++){
            $waypoints = $waypoints.'|via:'.$listBusRoute[$i]['detail_halte']['latitude'].', '
                .$listBusRoute[$i]['detail_halte']['longitude'];
            //for debugging purpose
            $busStopIdWaypoint = $busStopIdWaypoint.', '.$listBusRoute[$i]['detail_halte']['halte_id'];
          }

          $param = array(
              'units'       => 'metric',
              'origin'      => $this->busLat.', '.$this->busLon,
              'destination' => $busRoute['detail_halte']['latitude'].', '.$busRoute['detail_halte']['longitude'],
              'waypoints'   => $waypoints,
              'key'         => 'AIzaSyDkN-x6OugkPjuxqgibtHe3bSTt5y3WoRU'
          );

          $url = 'https://maps.googleapis.com/maps/api/directions/json?' . http_build_query($param);
//          echo $url.'<br>';
//          echo 'route waypoints: '.$busStopIdWaypoint.'<br>';
          $response = \Httpful\Request::get($url)->send();
          $dataResponse = json_decode($response->raw_body, true);
          $dataResponse['halte_id'] = $busRoute['detail_halte']['halte_id'];
          $this->listBusStopDuration[$counter] = $dataResponse;
          $counter++;
        }
        //reset waypoint each change of bus stop ETA
        $waypoints='';
        $busStopIdWaypoint='';
      }
    }catch(\Exception $e) {
//      echo $e;
      foreach($listBusRoute as $busRoute){
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
      $speedViolation = $speedViolationModel->where('plat_nomor', '=', $plat_nomor)
          ->get()
          ->toArray();
      if($speedViolation!=null){
        $response['data'] = $speedViolation;
        $response['code'] = 200;
      } else {
        $response['data']['msg'] = 'Bus never did a single violation';
        $response['code'] = 200;
      }
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }
}
