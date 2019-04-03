<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MVC_MODEL\model_page_list_student;
use App\global_model\model_controller_auth_config;
use App\MVC_MODEL\model_page_add_student;
use App\MVC_MODEL\model_page_edit_student;
use App\MVC_MODEL\model_tabel_tb_student;
use App\MVC_MODEL\model_page_delete_student;

use DB;

class model_controller_people extends Controller
{
  /**
  public function __construct() {
      
  }
  **/

    function page_list_student(){
session_start();
$obj_list_student = new model_page_list_student();
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






$obj_list_student->variables=$variables;

return view("mvc_view/people/list_student/index",compact("variables"));



//end of function page_list_student

}

function page_add_student(){
session_start();
$obj_add_student = new model_page_add_student();
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






$obj_add_student->variables=$variables;

return view("mvc_view/people/add_student/index",compact("variables"));



//end of function page_add_student

}

function page_edit_student(){
session_start();
$obj_edit_student = new model_page_edit_student();
$variables=getVariables();
extract($variables);



$model_controller_auth_config = null; 


$model_controller_auth_config = new model_controller_auth_config();
$model_controller_auth_config->variables=$variables;




$hasilCekAuth = null;


$url_catch = explode("/",$_SERVER["REQUEST_URI"]);


$obj_table_tb_student = null; 


$obj_table_tb_student = new model_tabel_tb_student();
$obj_table_tb_student->variables=$variables;




$data_diri_tb_student = null;



$hasilCekAuth = $model_controller_auth_config->register_auth("",$variables);

$variables['hasilCekAuth'] = $hasilCekAuth;

if (isset($_SESSION['sudahlogin'])){
if ($_SESSION['sudahlogin'] != null
){
$student_in_modul_people_page_edit_student_id = null;
for($i=0; $i<count($url_catch); $i++){
if($url_catch[$i]=="id"){
if($i+1<=count($url_catch)){
$student_in_modul_people_page_edit_student_id = $url_catch[$i+1];
if(strpos("tes".$student_in_modul_people_page_edit_student_id."tes","modal=iya")){
$variables["prepage"] = ".modal ";
}
$student_in_modul_people_page_edit_student_id = str_replace("?modal=iya","",$student_in_modul_people_page_edit_student_id);
$student_in_modul_people_page_edit_student_id = str_replace("&modal=iya","",$student_in_modul_people_page_edit_student_id);
$variables['student_in_modul_people_page_edit_student_id'] = $student_in_modul_people_page_edit_student_id;
}
break;
}
}



$data_diri_tb_student = $obj_table_tb_student->Go_table_for_modul_people_page_edit_student_select_tb_student($student_in_modul_people_page_edit_student_id);

$variables['data_diri_tb_student'] = $data_diri_tb_student;

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}






$obj_edit_student->variables=$variables;

return view("mvc_view/people/edit_student/index",compact("variables"));



//end of function page_edit_student

}

function page_delete_student(){
session_start();
$obj_delete_student = new model_page_delete_student();
$variables=getVariables();
extract($variables);



$model_controller_auth_config = null; 


$model_controller_auth_config = new model_controller_auth_config();
$model_controller_auth_config->variables=$variables;




$hasilCekAuth = null;


$url_catch = explode("/",$_SERVER["REQUEST_URI"]);


$obj_table_tb_student = null; 


$obj_table_tb_student = new model_tabel_tb_student();
$obj_table_tb_student->variables=$variables;




$data_diri_tb_student = null;



$hasilCekAuth = $model_controller_auth_config->register_auth("",$variables);

$variables['hasilCekAuth'] = $hasilCekAuth;

if (isset($_SESSION['sudahlogin'])){
if ($_SESSION['sudahlogin'] != null
){
$student_in_modul_people_page_delete_student_id = null;
for($i=0; $i<count($url_catch); $i++){
if($url_catch[$i]=="id"){
if($i+1<=count($url_catch)){
$student_in_modul_people_page_delete_student_id = $url_catch[$i+1];
if(strpos("tes".$student_in_modul_people_page_delete_student_id."tes","modal=iya")){
$variables["prepage"] = ".modal ";
}
$student_in_modul_people_page_delete_student_id = str_replace("?modal=iya","",$student_in_modul_people_page_delete_student_id);
$student_in_modul_people_page_delete_student_id = str_replace("&modal=iya","",$student_in_modul_people_page_delete_student_id);
$variables['student_in_modul_people_page_delete_student_id'] = $student_in_modul_people_page_delete_student_id;
}
break;
}
}



$data_diri_tb_student = $obj_table_tb_student->Go_table_for_modul_people_page_delete_student_select_tb_student($student_in_modul_people_page_delete_student_id);

$variables['data_diri_tb_student'] = $data_diri_tb_student;

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}






$obj_delete_student->variables=$variables;

return view("mvc_view/people/delete_student/index",compact("variables"));



//end of function page_delete_student

}



}
