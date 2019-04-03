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



$poin_auth_modul_account = 0; 



$poin_auth_modul_system_information = 0; 



$poin_auth_modul_administrative = 1; 



$auth_modul_administrative_page_list_class = 1; 



$poin_auth_modul_people = 1; 



$auth_modul_people_page_list_student = 1; 



$variables['hasilCekAuth'] = $hasilCekAuth;

$variables['ok_to_continue'] = $ok_to_continue;

$ok_to_continue = true; 
$variables['ok_to_continue'] = $ok_to_continue;

$hasilCekAuth = $variables; 
$variables['hasilCekAuth'] = $hasilCekAuth;

$variables['poin_auth_modul_home'] = $poin_auth_modul_home;

$variables['auth_modul_home_page_dashboard'] = $auth_modul_home_page_dashboard;

$variables['poin_auth_modul_account'] = $poin_auth_modul_account;

$variables['poin_auth_modul_system_information'] = $poin_auth_modul_system_information;

$variables['poin_auth_modul_administrative'] = $poin_auth_modul_administrative;

$variables['auth_modul_administrative_page_list_class'] = $auth_modul_administrative_page_list_class;

$variables['poin_auth_modul_people'] = $poin_auth_modul_people;

$variables['auth_modul_people_page_list_student'] = $auth_modul_people_page_list_student;

$hasilCekAuth = $variables; 
$variables['hasilCekAuth'] = $hasilCekAuth;




return $hasilCekAuth;



//end of function register_auth

}



}
