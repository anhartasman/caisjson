<?php

namespace App\global_model;

use Illuminate\Database\Eloquent\Model;
use App\MVC_MODEL\model_tabel_tb_breakfast;


use DB;

class model_auth extends Model
{

  public function __construct() {
$this->dafmenu=array();
$dafvar=array();
$obj_table_tb_breakfast = new model_tabel_tb_breakfast();
 // check auth dashboard in modul home
$dafvar["auth_modul_home_page_dashboard"] = -1;
 // check auth daftar_hotel in modul tabel_hotel
$dafvar["auth_modul_tabel_hotel_page_daftar_hotel"] = -1;
 // check auth daftar_fasilitas_hotel in modul tabel_hotel
$dafvar["auth_modul_tabel_hotel_page_daftar_fasilitas_hotel"] = -1;
 // check auth daftar_contact in modul information
$dafvar["auth_modul_information_page_daftar_contact"] = 1;
 // check auth daftar_breakfast in modul information
$dafvar["auth_modul_information_page_daftar_breakfast"] = 1;
 // check auth daftar_roomtype in modul information
$dafvar["auth_modul_information_page_daftar_roomtype"] = 1;
 // check auth daftar_hotelgroup in modul partner
$dafvar["auth_modul_partner_page_daftar_hotelgroup"] = -1;
 // check auth daftar_supplier in modul partner
$dafvar["auth_modul_partner_page_daftar_supplier"] = -1;
 // check auth daftar_airport in modul city
$dafvar["auth_modul_city_page_daftar_airport"] = 1;
 // check auth daftar_lokasi in modul city
$dafvar["auth_modul_city_page_daftar_lokasi"] = 1;
 // check auth daftar_kota in modul city
$dafvar["auth_modul_city_page_daftar_kota"] = 1;
 // check auth daftar_negara in modul city
$dafvar["auth_modul_city_page_daftar_negara"] = 1;
 // check auth daftar_provinsi in modul city
$dafvar["auth_modul_city_page_daftar_provinsi"] = 1;

$this->dafvar=$dafvar;
  }


  function get_sidemenus_visibility(){

    return $this->dafvar;
  }



}
