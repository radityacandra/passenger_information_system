<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Illuminate\Support\Facades\View;

class UserController extends Controller
{
  public function addUser(Request $request){
    $userModel = new User();
    $userModel->name = $request->input('username');
    $userModel->email = $request->input('email');
    $userModel->password = $request->input('password');
    $userModel->created_at = Carbon::now();
    $userModel->updated_at = Carbon::now();

    try{
      $userModel->profile_img = $request->input('profile_img');
    }catch (\Exception $e){
      $userModel->profile_img = 'https://qph.is.quoracdn.net/main-qimg-3b0b70b336bbae35853994ce0aa25013?convert_to_webp=true';
    }

    try{
      $userModel->alamat = $request->input('alamat');
    }catch (\Exception $e){
    //nothing to do if there is no address set
    }
    $userModel->save();
  }

  public function updateUser(Request $request){
    try{
      $userModel = new User();
      $userModel->where('username', '=', $request->username)
                ->update([
                  'email' => $request->email
                ]);
    }catch (\Exception $e){
    //nothing to do
    }

    try{
      $userModel = new User();
      $userModel->where('username', '=', $request->username)
                ->where('password', '=', $request->old_password)
                ->first();

      if(sizeof($userModel>0)){
        $userModel = new User();
        $userModel->where('username', '=', $request->username)
                  ->update([
                      'password' => $request->new_password
                  ]);
      }
    }catch (\Exception $e){
      //nothing to do
    }

    try{
      $userModel = new User();
      $userModel->where('username', '=', $request->username)
                ->update([
                  'profile_img' => $request->profile_img
                ]);
    }catch (\Exception $e){
      //nothing to do
    }

    try{
      $userModel = new User();
      $userModel->where('username', '=', $request->username)
          ->update([
              'alamat' => $request->alamat
          ]);
    }catch (\Exception $e){
      //nothing to do
    }
  }

  public function displayLogin(){
    return view('dashboard_login');
  }

  public function authenticateUser(Request $request){
    $userModel = new User();
    $user = $userModel->where('email', '=', $request->input('input_email'))
                      ->where('password', '=', $request->input('input_password'))
                      ->get()->toArray();

    if(sizeof($user>0) && $user!=null){
      echo sizeof($user);
      return redirect()->route('home');
    } else{
      return redirect()->action('UserController@displayLogin');
    }
  }

  public function displayHome(){
    $baseUrl = 'http://localhost:8000/api';


  }
}
