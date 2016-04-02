<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\BusOperation;

class BusController extends Controller
{
  public function addBus(Request $requests){
    $plat_nomor = $requests->input('plat_nomor');
    $rute = $requests->input('rute');
    //untuk store token bus
    $random_token = substr(md5(rand()), 0, 10);

    $bus = new BusOperation;
    $bus->plat_nomor = $plat_nomor;
    $bus->rute_id = $rute;
    $bus->token = $random_token;
    $bus->save();
  }

  public function displayForm(){
    return view('sign_up_bus');
  }

  public function listAllBusOperation(){
    $busOperationModel = new BusOperation();
    $busOperation = $busOperationModel->get()
                                      ->toArray();

    $response = array();
    $response['code'] = 200;
    $response['data'] = $busOperation;
    echo json_encode($response);
  }
}
