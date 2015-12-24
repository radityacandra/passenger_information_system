<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\StoreLocationModel;
use Symfony\Component\HttpKernel\HttpCache\Store;

class StoreLocationController extends Controller
{
    /**
     * controller buat handle request post ke URI /report_location
     * attribut post ada rute_id, lat, long, speed, semua dikirim plain form request
     * @param Request $requests
     */
    public function postLocation(Request $requests){
        $location = new StoreLocationModel;
        $location->route_id = $requests->input('rute_id');
        $location->latitude = $requests->input('lat');
        $location->longitude = $requests->input('long');
        $location->avg_speed = $requests->input('speed');
        $location->save();

        if($location->save()){
            $response = "data berhasil disimpan";
            echo $response;
        }
    }

    /**
     * buat get arrival estimation berdasarkan id bus
     */
    public function reportLocation(){
        $location = new StoreLocationModel;
        $data = $location->take(1)->get();
        echo(json_encode($data));
    }

    //TODO get token

    public function accessDenied(){
        return view('Forbidden');
    }
}
