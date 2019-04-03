<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MVC_MODEL\model_page_list_class;
use App\global_model\model_controller_auth_config;
use App\MVC_MODEL\model_page_add_class;
use App\MVC_MODEL\model_page_edit_class;
use App\MVC_MODEL\model_tabel_tb_class;
use App\MVC_MODEL\model_page_delete_class;

use DB;

class model_controller_administrative extends Controller
{
  /**
  public function __construct() {
      
  }
  **/

    function page_list_class(){
session_start();
$obj_list_class = new model_page_list_class();
$variables=getVariables();
extract($variables);



$model_controller_auth_config = null; 


$model_controller_auth_config = new model_controller_auth_config();
$model_controller_auth_config->variables=$variables;




$hasilCekAuth = null;



$hasilCekAuth = $model_controller_auth_config->register_auth("",$variables);

$variables['hasilCekAuth'] = $hasilCekAuth;

if (isset($_SESSION['sudahlogin'])){
if ($_SESSION['sudahlogin'] != null
){
}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}






$obj_list_class->variables=$variables;

return view("mvc_view/administrative/list_class/index",compact("variables"));



//end of function page_list_class

}

function page_add_class(){
session_start();
$obj_add_class = new model_page_add_class();
$variables=getVariables();
extract($variables);



$model_controller_auth_config = null; 


$model_controller_auth_config = new model_controller_auth_config();
$model_controller_auth_config->variables=$variables;




$hasilCekAuth = null;



$hasilCekAuth = $model_controller_auth_config->register_auth("",$variables);

$variables['hasilCekAuth'] = $hasilCekAuth;

if (isset($_SESSION['sudahlogin'])){
if ($_SESSION['sudahlogin'] != null
){
}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}






$obj_add_class->variables=$variables;

return view("mvc_view/administrative/add_class/index",compact("variables"));



//end of function page_add_class

}

function page_edit_class(){
session_start();
$obj_edit_class = new model_page_edit_class();
$variables=getVariables();
extract($variables);



$model_controller_auth_config = null; 


$model_controller_auth_config = new model_controller_auth_config();
$model_controller_auth_config->variables=$variables;




$hasilCekAuth = null;


$url_catch = explode("/",$_SERVER["REQUEST_URI"]);


$obj_table_tb_class = null; 


$obj_table_tb_class = new model_tabel_tb_class();
$obj_table_tb_class->variables=$variables;




$data_diri_tb_class = null;



$hasilCekAuth = $model_controller_auth_config->register_auth("",$variables);

$variables['hasilCekAuth'] = $hasilCekAuth;

if (isset($_SESSION['sudahlogin'])){
if ($_SESSION['sudahlogin'] != null
){
$class_in_modul_administrative_page_edit_class_id = null;
for($i=0; $i<count($url_catch); $i++){
if($url_catch[$i]=="id"){
if($i+1<=count($url_catch)){
$class_in_modul_administrative_page_edit_class_id = $url_catch[$i+1];
if(strpos("tes".$class_in_modul_administrative_page_edit_class_id."tes","modal=iya")){
$variables["prepage"] = ".modal ";
}
$class_in_modul_administrative_page_edit_class_id = str_replace("?modal=iya","",$class_in_modul_administrative_page_edit_class_id);
$class_in_modul_administrative_page_edit_class_id = str_replace("&modal=iya","",$class_in_modul_administrative_page_edit_class_id);
$variables['class_in_modul_administrative_page_edit_class_id'] = $class_in_modul_administrative_page_edit_class_id;
}
break;
}
}



$data_diri_tb_class = $obj_table_tb_class->Go_table_for_modul_administrative_page_edit_class_select_tb_class($class_in_modul_administrative_page_edit_class_id);

$variables['data_diri_tb_class'] = $data_diri_tb_class;

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}






$obj_edit_class->variables=$variables;

return view("mvc_view/administrative/edit_class/index",compact("variables"));



//end of function page_edit_class

}

function page_delete_class(){
session_start();
$obj_delete_class = new model_page_delete_class();
$variables=getVariables();
extract($variables);



$model_controller_auth_config = null; 


$model_controller_auth_config = new model_controller_auth_config();
$model_controller_auth_config->variables=$variables;




$hasilCekAuth = null;


$url_catch = explode("/",$_SERVER["REQUEST_URI"]);


$obj_table_tb_class = null; 


$obj_table_tb_class = new model_tabel_tb_class();
$obj_table_tb_class->variables=$variables;




$data_diri_tb_class = null;



$hasilCekAuth = $model_controller_auth_config->register_auth("",$variables);

$variables['hasilCekAuth'] = $hasilCekAuth;

if (isset($_SESSION['sudahlogin'])){
if ($_SESSION['sudahlogin'] != null
){
$class_in_modul_administrative_page_delete_class_id = null;
for($i=0; $i<count($url_catch); $i++){
if($url_catch[$i]=="id"){
if($i+1<=count($url_catch)){
$class_in_modul_administrative_page_delete_class_id = $url_catch[$i+1];
if(strpos("tes".$class_in_modul_administrative_page_delete_class_id."tes","modal=iya")){
$variables["prepage"] = ".modal ";
}
$class_in_modul_administrative_page_delete_class_id = str_replace("?modal=iya","",$class_in_modul_administrative_page_delete_class_id);
$class_in_modul_administrative_page_delete_class_id = str_replace("&modal=iya","",$class_in_modul_administrative_page_delete_class_id);
$variables['class_in_modul_administrative_page_delete_class_id'] = $class_in_modul_administrative_page_delete_class_id;
}
break;
}
}



$data_diri_tb_class = $obj_table_tb_class->Go_table_for_modul_administrative_page_delete_class_select_tb_class($class_in_modul_administrative_page_delete_class_id);

$variables['data_diri_tb_class'] = $data_diri_tb_class;

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}






$obj_delete_class->variables=$variables;

return view("mvc_view/administrative/delete_class/index",compact("variables"));



//end of function page_delete_class

}



}
