<?php

namespace App\Http\Controllers;

use App\BusOperation;
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
    try{
      $arrivalEstimation = $arrivalEstimationModel->where('halte_id_tujuan', '=', $halte_id)
                                                  ->orderBy('waktu_kedatangan', 'asc')
                                                  ->take(10)
                                                  ->get()
                                                  ->toArray();

      $this->listArrivalEstimation = $arrivalEstimation;
      if(isset($arrivalEstimation[0])){
        $response = array();
        $response['code'] = 200;
        $response['data'] = $this->listArrivalEstimation;
      } else{
        $response['code'] = 400;
        $response['data']['msg'] = "cannot find bus directing to this bus stop. Please try again later";
      }
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'Internal server error. Please contact administrator';
    }

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
    try{
      $arrivalEstimation = $arrivalEstimationModel->where('halte_id_tujuan', $halte_id)
                                                  ->orderBy('waktu_kedatangan', 'asc')
                                                  ->take(1)
                                                  ->get()
                                                  ->toArray();

      if(isset($arrivalEstimation[0])){
      	$busOperationModel = new BusOperation();
	      $lastPosition = $busOperationModel->select('last_latitude', 'last_longitude')
			                                    ->where('plat_nomor', '=', $arrivalEstimation[0]['plat_nomor'])
			                                    ->first();
	      
        $this->nearestArrivalEtimation = $arrivalEstimation[0];

        $response = array();
        $response['code'] = 200;
        $response['data'] = $this->nearestArrivalEtimation;
	      $response['data']['bus_latitude'] = $lastPosition['last_latitude'];
	      $response['data']['bus_longitude'] = $lastPosition['last_longitude'];
      } else {
        $response['code'] = 400;
        $response['data']['msg'] = 'cannot find nearest bus, please try again later';
      }
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'internal error, please try again later or contact administrator';
    }

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
    try{
      $busStopHistory = $busStopHistoryModel->where('halte_id', '=', $halte_id)
                                            ->orderBy('arrival_history', 'desc')
                                            ->take(10)
                                            ->get()
                                            ->toArray();

      if (isset($busStopHistory[0])) {
        $response = array();
        $response['code'] = 200;
        $response['data'] = $busStopHistory;
      } else {
        $response['code'] = 400;
        $response['data']['msg'] = 'there is no bus visited this bus stop yet';
      }
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'internal error, please try again later or contact administrator';
    }

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
	  $busRouteModel = new BusRoute();
	  $arrivalEstimationModel = new ArrivalEstimation();
	  $busStopHistoryModel = new BusStopHistory();
	  
    try{
      $busStop = $busStopModel->where('halte_id', '=', $halte_id)
                              ->first();
	    
      if ($busStop!=null) {
      	//algorithm for searching extra information
	      $routePass = $busRouteModel->select('rute_id')
			      ->where('halte_id', '=', $halte_id)
			      ->groupBy('rute_id')
			      ->get()
			      ->toArray();

        $arrivalEstimation = $arrivalEstimationModel->where('halte_id_tujuan', '=', $halte_id)
                                                  ->orderBy('waktu_kedatangan', 'asc')
                                                  ->take(10)
                                                  ->get()
                                                  ->toArray();
        
        $counter = 0;
        $tempContainer = array();                                          
        foreach ($arrivalEstimation as $value) {
          $urutan = $busRouteModel->select('urutan')
                                  ->where('rute_id', '=', $value['rute_id'])
                                  ->first();

          $urutan = $urutan['urutan'] + 1;                        

          $toHalte = $busRouteModel->where('rute_id', '=', $value['rute_id'])
                                    ->where('urutan', '=', $urutan)
                                    ->with('detailHalte')
                                    ->first();                          
                                    
          $urutan = $urutan['urutan'] + 1;
          $tempContainer[$counter] = $value;
          $tempContainer[$counter]['to_halte']['halte_id'] = $toHalte['halte_id'];
          $tempContainer[$counter]['to_halte']['nama_halte']  = $toHalte['detailHalte']['nama_halte'];
          $counter++;
        }                                              
      	
      	$busStop['rute_pass'] = $routePass;
	      $busStop['bus_directing'] = $tempContainer;
        $response = array();
        $response['code'] = 200;
        $response['data'] = $busStop;
      } else{
        $response['code'] = 400;
        $response['data']['msg'] = 'bus stop data could not be found, make sure type a correct bus stop identifier';
      }
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'internal error, please try again later or contact administrator';
    }

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
    try{
      $listBusStop = $busStopModel->select('halte_id', 'nama_halte', 'lokasi_halte')
		                              ->get()
                                  ->toArray();

      if (isset($listBusStop[0])) {
        $response = array();
        $response['code'] = 200;
        $response['data'] = $listBusStop;
      } else{
        $response['code'] = 400;
        $response['data']['msg'] = 'there is no bus stop could be found, please contact administrator';
      }
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'internal error, please try again later or contact administrator';
    }

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
    try{
      $arrivalEstimation = $arrivalEstimationModel->where('halte_id_tujuan', $halte_id)
          ->orderBy('waktu_kedatangan', 'asc')
          ->take(1)
          ->get()
          ->toArray();

      if (isset($arrivalEstimation[0]['rute_id'])) {
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
      } else {
        $response['code'] = 400;
        $response['data']['msg'] = 'could not find nearest bus. Please try again later';
      }
    } catch (\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'internal error, please try again later or contact administrator';
    }


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
    try{
      $arrivalEstimation = $arrivalEstimationModel->with('thisHalte')
                                                  ->with('toHalte')
                                                  ->get()
                                                  ->toArray();

      if (isset($arrivalEstimation)) {
        $response = array();
        $response['code'] = 200;
        $response['data'] = $arrivalEstimation;
      } else {
        $response['code'] = 400;
        $response['data']['msg'] = 'could not find nearest bus. Please try again later';
      }
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'internal error, please try again later or contact administrator';
    }

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
    try{
      $arrivalEstimation = $arrivalEstimationModel->where('arrival_code', '=', $arrival_code)
                                                  ->with('thisHalte')
                                                  ->with('toHalte')
                                                  ->first();

      if ($arrivalEstimation!=null) {
        $response = array();
        $response['code'] = 200;
        $response['data'] = $arrivalEstimation;
      } else {
        $response['code'] = 400;
        $response['data']['msg'] = 'could not find arrival schedule. make sure you type a correct arrival code';
      }
    } catch(\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'internal error, please try again later or contact administrator';
    }

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
    try{
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
              ($groupUserFeedback[$counterGroup]['rating']*($groupUserFeedback[$counterGroup]['input']-1) + $userFeedback['satisfaction'])
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
   * get detail feedback (praise/complaint) to certain bus stop
   *
   * @param $halte_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function detailBusStopSatisfaction($halte_id){
    $userFeedbackModel = new UserFeedback();
    try{
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
      $response['code'] = 400;
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
