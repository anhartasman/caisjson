<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\MVC_MODEL\siswa;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $datasiswa = new siswa();
      print_r($datasiswa->tampilkanData());

        return view('home');
    }

    public function nama(){

      return view('data_nama');
    }
    public function umur($id,$tempat){
      return 'Umur : '.$id.' , Lokasi : '.$tempat;
    }

    public function umur_lokasi(Request $request){
      $datas = User::get();
      return view('data_nama',compact('datas'));
    }

    public function documentation(){
      return view('mvc_view/system_information/documentation/index');
    }
}
