<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\InfoLive;
use App\Helpers\SplitParagraph;

class NewsController extends Controller
{
  /**
   * get three most recent news update
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function getNewsFeed(){
    $infoModel = new InfoLive();
    $listInfo = $infoModel->orderBy('news_id', 'desc')
        ->take(3)
        ->get()
        ->toArray();

    for($i = 0; $i<sizeof($listInfo); $i++){
      $listInfo[$i]['content'] = SplitParagraph::splitParagraph($listInfo[$i]['content']);
    }

    $response = array();
    $response['code'] = 200;
    $response['data'] = $listInfo;

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * get news feed detail
   *
   * @param $news_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function getCertainNewsFeed($news_id){
    $newsModel = new InfoLive();
    $response = array();

    try{
      $news = $newsModel->where('news_id', '=', $news_id)
          ->firstOrFail();

      $response['code'] = 200;
      $response['data'] = $news;
    } catch(\Exception $e){
      $response['code'] = 400;
      $response['data']['msg'] = 'news not found, make sure news id is right';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * add new news to database
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function addNewsFeed(Request $request){
    $newsModel = new InfoLive();
    $response = array();

    try{
      $newsModel->created_at = \Carbon\Carbon::now();
      $newsModel->updated_at = \Carbon\Carbon::now();
      $newsModel->judul = $request->title;
      $newsModel->content = $request->news;
      if($request->exists('author')){
        $newsModel->penulis = $request->author;
      }
      $newsModel->save();

      $response['code'] = 200;
      $response['data']['msg'] = 'news has been successfully added to database';
    } catch(\Exception $e){
      $response['code'] = 400;
      $response['data']['msg'] = 'there are missing parameter, check your request';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * update news title, content, or author
   *
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function updateNewsFeed(Request $request){
    $newsModel = new InfoLive();
    $response = array();

    try{
      $newsId = $request->news_id;
    } catch(\Exception $e){
      $response['code'] = 400;
      $response['data']['msg'] = 'there is no news_id parameter, please check your request';

      header("Access-Control-Allow-Origin: *");
      return response()->json($response);
    }

    if($request->exists('title')){
      $newsModel->where('news_id', '=', $newsId)
                ->update([
                  'judul' => $request->title
                ]);
    }

    if($request->exists('news')){
      $newsModel->where('news_id', '=', $newsId)
          ->update([
              'content' => $request->news
          ]);
    }

    if($request->exists('author')){
      $newsModel->where('news_id', '=', $newsId)
          ->update([
              'penulis' => $request->author
          ]);
    }

    $response['code'] = 200;
    $response['data']['msg'] = 'news has been successfully updated from database';

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }

  /**
   * delete news feed from database
   *
   * @param $news_id
   * @return \Illuminate\Http\JsonResponse
   */
  public function deleteNewsFeed($news_id){
    $newsModel = new InfoLive();
    $response = array();

    try{
      $newsModel->where('news_id', '=', $news_id)
                ->delete();

      $response['code'] = 200;
      $response['data']['msg'] = 'news has been successfully deleted from database';
    } catch (\Exception $e){
      $response['code'] = 500;
      $response['data']['msg'] = 'there is no news found, make sure news_id is correct';
    }

    header("Access-Control-Allow-Origin: *");
    return response()->json($response);
  }
}
