<?php

namespace App\global_model;

use Illuminate\Database\Eloquent\Model;

use App\MVC_MODEL\model_page_register_auth;

use DB;

class model_controller_auth_config extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function register_auth($allowedroles,$datas){
$variables=getVariables();
extract($variables);



$hasilCekAuth = null; 



$ok_to_continue = true; 






$variables = null; 



$poin_auth_modul_home = 1; 



$auth_modul_home_page_dashboard = 1; 



$poin_auth_modul_tabel_hotel = 2; 



$auth_modul_tabel_hotel_page_daftar_hotel = -1; 






$auth_modul_tabel_hotel_page_daftar_fasilitas_hotel = -1; 



$poin_auth_modul_information = 3; 



$auth_modul_information_page_daftar_contact = 1; 



$auth_modul_information_page_daftar_breakfast = 1; 



$auth_modul_information_page_daftar_roomtype = 1; 



$poin_auth_modul_partner = 2; 



$auth_modul_partner_page_daftar_hotelgroup = -1; 



$auth_modul_partner_page_daftar_supplier = -1; 



$poin_auth_modul_city = 5; 



$auth_modul_city_page_daftar_airport = 1; 



$auth_modul_city_page_daftar_lokasi = 1; 



$auth_modul_city_page_daftar_kota = 1; 



$auth_modul_city_page_daftar_negara = 1; 



$auth_modul_city_page_daftar_provinsi = 1; 



$variables['hasilCekAuth'] = $hasilCekAuth;

$variables['ok_to_continue'] = $ok_to_continue;

$ok_to_continue = true; 
$variables['ok_to_continue'] = $ok_to_continue;

$hasilCekAuth = $variables; 
$variables['hasilCekAuth'] = $hasilCekAuth;

$variables['poin_auth_modul_home'] = $poin_auth_modul_home;

$variables['auth_modul_home_page_dashboard'] = $auth_modul_home_page_dashboard;

$variables['poin_auth_modul_tabel_hotel'] = $poin_auth_modul_tabel_hotel;

$variables['auth_modul_tabel_hotel_page_daftar_hotel'] = $auth_modul_tabel_hotel_page_daftar_hotel;

if ($status_laporan != null
){
if ($hasilCekAuth['ok_to_continue'] == true
){
$auth_modul_tabel_hotel_page_daftar_hotel = 1; 
$variables['auth_modul_tabel_hotel_page_daftar_hotel'] = $auth_modul_tabel_hotel_page_daftar_hotel;

}

}

if ($auth_modul_tabel_hotel_page_daftar_hotel == -1
){
$poin_auth_modul_tabel_hotel -= 1; 
$variables['poin_auth_modul_tabel_hotel'] = $poin_auth_modul_tabel_hotel;

}

$variables['auth_modul_tabel_hotel_page_daftar_fasilitas_hotel'] = $auth_modul_tabel_hotel_page_daftar_fasilitas_hotel;

if ($status_laporan != null
){
if ($hasilCekAuth['ok_to_continue'] == true
){
$auth_modul_tabel_hotel_page_daftar_fasilitas_hotel = 1; 
$variables['auth_modul_tabel_hotel_page_daftar_fasilitas_hotel'] = $auth_modul_tabel_hotel_page_daftar_fasilitas_hotel;

}

}

if ($auth_modul_tabel_hotel_page_daftar_fasilitas_hotel == -1
){
$poin_auth_modul_tabel_hotel -= 1; 
$variables['poin_auth_modul_tabel_hotel'] = $poin_auth_modul_tabel_hotel;

}

$variables['poin_auth_modul_information'] = $poin_auth_modul_information;

$variables['auth_modul_information_page_daftar_contact'] = $auth_modul_information_page_daftar_contact;

$variables['auth_modul_information_page_daftar_breakfast'] = $auth_modul_information_page_daftar_breakfast;

$variables['auth_modul_information_page_daftar_roomtype'] = $auth_modul_information_page_daftar_roomtype;

$variables['poin_auth_modul_partner'] = $poin_auth_modul_partner;

$variables['auth_modul_partner_page_daftar_hotelgroup'] = $auth_modul_partner_page_daftar_hotelgroup;

if ($status_laporan != null
){
if ($hasilCekAuth['ok_to_continue'] == true
){
$auth_modul_partner_page_daftar_hotelgroup = 1; 
$variables['auth_modul_partner_page_daftar_hotelgroup'] = $auth_modul_partner_page_daftar_hotelgroup;

}

}

if ($auth_modul_partner_page_daftar_hotelgroup == -1
){
$poin_auth_modul_partner -= 1; 
$variables['poin_auth_modul_partner'] = $poin_auth_modul_partner;

}

$variables['auth_modul_partner_page_daftar_supplier'] = $auth_modul_partner_page_daftar_supplier;

if ($status_laporan != null
){
if ($hasilCekAuth['ok_to_continue'] == true
){
$auth_modul_partner_page_daftar_supplier = 1; 
$variables['auth_modul_partner_page_daftar_supplier'] = $auth_modul_partner_page_daftar_supplier;

}

}

if ($auth_modul_partner_page_daftar_supplier == -1
){
$poin_auth_modul_partner -= 1; 
$variables['poin_auth_modul_partner'] = $poin_auth_modul_partner;

}

$variables['poin_auth_modul_city'] = $poin_auth_modul_city;

$variables['auth_modul_city_page_daftar_airport'] = $auth_modul_city_page_daftar_airport;

$variables['auth_modul_city_page_daftar_lokasi'] = $auth_modul_city_page_daftar_lokasi;

$variables['auth_modul_city_page_daftar_kota'] = $auth_modul_city_page_daftar_kota;

$variables['auth_modul_city_page_daftar_negara'] = $auth_modul_city_page_daftar_negara;

$variables['auth_modul_city_page_daftar_provinsi'] = $auth_modul_city_page_daftar_provinsi;

$hasilCekAuth = $variables; 
$variables['hasilCekAuth'] = $hasilCekAuth;




return $hasilCekAuth;



//end of function register_auth

}



}
