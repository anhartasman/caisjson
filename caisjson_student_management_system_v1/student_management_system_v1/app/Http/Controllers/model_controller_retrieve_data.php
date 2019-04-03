<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MVC_MODEL\model_tabel_tb_token;
use App\MVC_MODEL\model_tabel_tb_account;
use App\MVC_MODEL\model_tabel_tb_class;
use App\MVC_MODEL\model_tabel_tb_student;

use DB;

class model_controller_retrieve_data extends Controller
{
  /**
  public function __construct() {
      
  }
  **/

    function page_login($obj){
$error_code = "000";


$error_msg = "";


$variables=getVariables();
extract($variables);
$prosesapi=1;
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;
$param_api_username = null;
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

if(isset($obj->username)){
$param_api_username=$obj->username;
$variables['param_api_username']=$obj->username;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="username tidak ada";
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



$obj_table_tb_token = null; 


$obj_table_tb_token = new model_tabel_tb_token();
$obj_table_tb_token->variables=$variables;




$hasil_deletedata_token = null;


$got_token = null; 






$kuncianpassword = null; 



$obj_table_tb_account = null; 


$obj_table_tb_account = new model_tabel_tb_account();
$obj_table_tb_account->variables=$variables;




$check_account = null;








$hasilacak = null;


$kuncianhasilacak = null; 



$check_token = null;


$expired_date = null; 






$hasil_insert_token = null;


$hasil_insert_token_last_id = null;



$hasil_deletedata_token = $obj_table_tb_token->Go_table_for_modul_retrieve_data_page_login_delete_tb_token($base_date_time);

$variables['hasil_deletedata_token'] = $hasil_deletedata_token;

$got_token = 0; 
$variables['got_token'] = $got_token;

$kuncianpassword = hash('sha256',$param_api_password,false); 


$check_account = $obj_table_tb_account->Go_table_for_modul_retrieve_data_page_login_select_tb_account($param_api_username,$kuncianpassword);

$variables['check_account'] = $check_account;

if ($check_account == null
){
$error_msg = "Gagal login"; 
$variables['error_msg'] = $error_msg;

$error_code = "001"; 
$variables['error_code'] = $error_code;

}

if ($check_account != null
){
while ($got_token == 0
){
$acakhasilacak = rand(1,1000000);
$hasilacak = $base_date_time."".$acakhasilacak;

$kuncianhasilacak = hash('sha256',$hasilacak,false); 


$check_token = $obj_table_tb_token->Go_table_for_modul_retrieve_data_page_login_select_tb_token($kuncianhasilacak);

$variables['check_token'] = $check_token;

if ($check_token == null
){
$expired_date = date("Y-m-d H:i:s");
$expired_date = date_create_from_format("Y-m-d H:i:s",$expired_date);
$expired_date = date_add($expired_date,date_interval_create_from_date_string("7 days"))->format("Y-m-d H:i:s");
$variables['expired_date'] = $expired_date;

$got_token = 1; 
$variables['got_token'] = $got_token;


$hasil_insert_token = $obj_table_tb_token->Go_table_for_modul_retrieve_data_page_login_insert_tb_token($check_account,$kuncianhasilacak,$expired_date);

$hasil_insert_token_last_id = $obj_table_tb_token->getLastId();
$variables['hasil_insert_token'] = $hasil_insert_token;

$_SESSION['auth_level'] = 3;

$_SESSION['auth_role'] = $check_account['role'];

$_SESSION['auth_token'] = $kuncianhasilacak;

$_SESSION['sudahlogin'] = 1;

}

}

}




$bahan_respon = "{\"token\":\"".$kuncianhasilacak."\",\"expired_date\":\"".$expired_date."\"}";
$response_data = json_decode($bahan_respon);
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_login

}

function page_retrieve_dataclass_in_modul_administrative_page_list_class($obj){
$error_code = "000";


$error_msg = "";


$variables=getVariables();
extract($variables);
$prosesapi=1;
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;

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

if ($prosesapi==1){



$obj_table_tb_class = null; 


$obj_table_tb_class = new model_tabel_tb_class();
$obj_table_tb_class->variables=$variables;




$hasil_retrievetb_class = null;



$hasil_retrievetb_class = $obj_table_tb_class->Go_table_for_modul_retrieve_data_page_retrieve_dataclass_in_modul_administrative_page_list_class_select_tb_class();

$variables['hasil_retrievetb_class'] = $hasil_retrievetb_class;




$bahan_respon = "[{hasil_retrievetb_class}]";
$bahan_respon=str_replace("{hasil_retrievetb_class}",$hasil_retrievetb_class,$bahan_respon);
$bahan_respon=str_replace("{hasil_retrievetb_class}",$hasil_retrievetb_class,$bahan_respon);
$response_data = json_decode($bahan_respon);
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_retrieve_dataclass_in_modul_administrative_page_list_class

}

function page_retrieve_datastudent_in_modul_people_page_list_student($obj){
$error_code = "000";


$error_msg = "";


$variables=getVariables();
extract($variables);
$prosesapi=1;
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;

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

if ($prosesapi==1){



$obj_table_tb_student = null; 


$obj_table_tb_student = new model_tabel_tb_student();
$obj_table_tb_student->variables=$variables;




$hasil_retrievetb_student = null;



$hasil_retrievetb_student = $obj_table_tb_student->Go_table_for_modul_retrieve_data_page_retrieve_datastudent_in_modul_people_page_list_student_select_tb_student();

$variables['hasil_retrievetb_student'] = $hasil_retrievetb_student;




$bahan_respon = "[{hasil_retrievetb_student}]";
$bahan_respon=str_replace("{hasil_retrievetb_student}",$hasil_retrievetb_student,$bahan_respon);
$bahan_respon=str_replace("{hasil_retrievetb_student}",$hasil_retrievetb_student,$bahan_respon);
$response_data = json_decode($bahan_respon);
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_retrieve_datastudent_in_modul_people_page_list_student

}



}
