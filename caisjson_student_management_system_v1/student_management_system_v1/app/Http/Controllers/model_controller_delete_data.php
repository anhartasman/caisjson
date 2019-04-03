<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MVC_MODEL\model_tabel_tb_class;
use App\MVC_MODEL\model_tabel_tb_student;

use DB;

class model_controller_delete_data extends Controller
{
  /**
  public function __construct() {
      
  }
  **/

    function page_delete_dataclass_in_modul_administrative_page_delete_class($obj){
$error_code = "000";


$error_msg = "";


$variables=getVariables();
extract($variables);
$prosesapi=1;
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;
$param_api_classadministrativedelete_class_id = null;

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

if(isset($obj->classadministrativedelete_class_id)){
$param_api_classadministrativedelete_class_id=$obj->classadministrativedelete_class_id;
$variables['param_api_classadministrativedelete_class_id']=$obj->classadministrativedelete_class_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="classadministrativedelete_class_id tidak ada";
}

if ($prosesapi==1){



$obj_table_tb_class = null; 


$obj_table_tb_class = new model_tabel_tb_class();
$obj_table_tb_class->variables=$variables;




$hasil_deletetb_class = null;



$hasil_deletetb_class = $obj_table_tb_class->Go_table_for_modul_delete_data_page_delete_dataclass_in_modul_administrative_page_delete_class_delete_tb_class($param_api_classadministrativedelete_class_id);

$variables['hasil_deletetb_class'] = $hasil_deletetb_class;




$bahan_respon = "{hasil_deletetb_class}";
$bahan_respon=str_replace("{hasil_deletetb_class}",$hasil_deletetb_class,$bahan_respon);
$bahan_respon=str_replace("{hasil_deletetb_class}",$hasil_deletetb_class,$bahan_respon);
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_delete_dataclass_in_modul_administrative_page_delete_class

}

function page_delete_datastudent_in_modul_people_page_delete_student($obj){
$error_code = "000";


$error_msg = "";


$variables=getVariables();
extract($variables);
$prosesapi=1;
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;
$param_api_studentpeopledelete_student_id = null;

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

if(isset($obj->studentpeopledelete_student_id)){
$param_api_studentpeopledelete_student_id=$obj->studentpeopledelete_student_id;
$variables['param_api_studentpeopledelete_student_id']=$obj->studentpeopledelete_student_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="studentpeopledelete_student_id tidak ada";
}

if ($prosesapi==1){



$obj_table_tb_student = null; 


$obj_table_tb_student = new model_tabel_tb_student();
$obj_table_tb_student->variables=$variables;




$hasil_deletetb_student = null;



$hasil_deletetb_student = $obj_table_tb_student->Go_table_for_modul_delete_data_page_delete_datastudent_in_modul_people_page_delete_student_delete_tb_student($param_api_studentpeopledelete_student_id);

$variables['hasil_deletetb_student'] = $hasil_deletetb_student;




$bahan_respon = "{hasil_deletetb_student}";
$bahan_respon=str_replace("{hasil_deletetb_student}",$hasil_deletetb_student,$bahan_respon);
$bahan_respon=str_replace("{hasil_deletetb_student}",$hasil_deletetb_student,$bahan_respon);
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_delete_datastudent_in_modul_people_page_delete_student

}



}
