<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MVC_MODEL\model_tabel_tb_akun;
use App\MVC_MODEL\model_tabel_tb_authlevel;

use DB;

class model_controller_account extends Controller
{
  /**
  public function __construct() {
      
  }
  **/

    function page_login($obj){
$variables=getVariables();
extract($variables);
$prosesapi=1;
$error_code="000";
$error_msg="";
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;
$param_api_email = null;
$param_api_password = null;

if(isset($obj->modul)){
$param_api_modul=$obj->modul;
$variables['param_api_modul']=$obj->modul;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="modul tidak ada";
}

if(isset($obj->action)){
$param_api_action=$obj->action;
$variables['param_api_action']=$obj->action;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="action tidak ada";
}

if(isset($obj->email)){
$param_api_email=$obj->email;
$variables['param_api_email']=$obj->email;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="email tidak ada";
}

if(isset($obj->password)){
$param_api_password=$obj->password;
$variables['param_api_password']=$obj->password;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="password tidak ada";
}

if ($prosesapi==1){



$obj_table_tb_akun = null; 


$obj_table_tb_akun = new model_tabel_tb_akun();
$obj_table_tb_akun->variables=$variables;




$hasil_get_akun = null;


$obj_table_tb_authlevel = null; 


$obj_table_tb_authlevel = new model_tabel_tb_authlevel();
$obj_table_tb_authlevel->variables=$variables;




$hasil_get_auth = null;



$hasil_get_akun = $obj_table_tb_akun->Go_table_for_modul_account_page_login_select_tb_akun($param_api_email,$param_api_password);

$variables['hasil_get_akun'] = $hasil_get_akun;

if ( $hasil_get_akun!=null){

$hasil_get_auth = $obj_table_tb_authlevel->Go_table_for_modul_account_page_login_select_tb_authlevel($hasil_get_akun['idauth'],$hasil_get_akun);

$variables['hasil_get_auth'] = $hasil_get_auth;

}



$bahan_respon = "{hasil_get_auth}";
$bahan_respon=str_replace("{hasil_get_auth}",$hasil_get_auth,$bahan_respon);
$bahan_respon=str_replace("{hasil_get_auth}",$hasil_get_auth,$bahan_respon);
$response_data = $bahan_respon;
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_login

}



}
