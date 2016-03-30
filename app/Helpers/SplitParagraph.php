<?php
/**
 * Created by PhpStorm.
 * User: radityacandra
 * Date: 30/03/16
 * Time: 1:33
 */

namespace App\Helpers;


class SplitParagraph
{
  /**
   * check word count in some paragraph and split it to maximum 100 word if too many word in paragraph
   * @param $input
   * @return string result
   */
  public static function splitParagraph($input){
    $result = '';
    $clean_input = strip_tags($input);
    $word_array = explode(' ', $clean_input);
    if(sizeof($word_array<=100)){
      $result = implode(' ', $word_array);
    }else{
      for($i = 101; $i<sizeof($word_array); $i++){
        unset($word_array[$i]);
      }
      $result = implode(' ', $word_array);
    }
    return $result;
  }
}