<?php
/**
 * Created by PhpStorm.
 * User: radityacandra
 * Date: 26/04/16
 * Time: 0:16
 */

namespace App\Helpers;


class InverseResponse
{
  public static function inverseResponse($response){
    $inverseResponse = array();
    $counterInverse = 0;

    for($i=sizeof($response)-1; $i>=0; $i--){
      $inverseResponse[$counterInverse] = $response[$i];
      $counterInverse++;
    }

    return $inverseResponse;
  }
}