<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/data-nama', ['as'=>'data-nama','uses'=>'HomeController@nama']);
Route::get('/data-nama/umur/{id}/lokasi/{tempat}', ['as'=>'data-umur','uses'=>'HomeController@umur']);
Route::get('/data-nama/umur-lokasi', ['uses'=>'HomeController@umur_lokasi']);
//Route::get('/admin/system_information/documentation', ['uses'=>'HomeController@documentation']);
Route::post('/API', function(){
session_start();
  header('Content-Type: application/json');
  $modul="";
  $action="";
  $prosesapi=1;
  $error_code="000";
  $error_msg="";
  $returnAPI=array();
  $json = file_get_contents('php://input');
  $obj = json_decode($json);
  if(!empty($obj->modul)){
  $modul=$obj->modul;
  }else{
  $prosesapi=0;
  $returnAPI['error_code']="001";
  $returnAPI['error_msg']="Modul API tidak ada";
  }

  if(!empty($obj->action)){
  $action=$obj->action;
  }else{
  $prosesapi=0;
  $returnAPI['error_code']="001";
  $returnAPI['error_msg']="Action API tidak ada ".$json." aaa";
  }

if($prosesapi==1){


          return App::call('App\Http\Controllers\model_controller_'.$modul.'@page_'.$action,[$obj] );
        //  return redirect()->route('home');

}

});

Route::post('/upload', function(){


});

Route::get('/migrasidb', function(){
  ini_set('max_execution_time', 30); //3 minutes


});
Route::get('/', ['uses'=>'model_controller_home@page_dashboard']);

{write}
