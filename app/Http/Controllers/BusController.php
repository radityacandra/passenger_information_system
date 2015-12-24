<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BusController extends Controller
{
    public function addBus(Request $requests){
        $plat_nomor = $requests->input('plat_nomor');
        $rute = $requests->input('rute');
        //untuk store token bus
        $random = substr(md5(rand()), 0, 10);

    }
}
