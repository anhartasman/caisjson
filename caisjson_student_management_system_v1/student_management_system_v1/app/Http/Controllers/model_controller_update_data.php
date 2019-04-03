<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MVC_MODEL\model_tabel_tb_class;
use App\MVC_MODEL\model_tabel_tb_student;

use DB;

class model_controller_update_data extends Controller
{
  /**
  public function __construct() {
      
  }
  **/

    function page_update_dataclass_in_modul_administrative_page_edit_class($obj){
$error_code = "000";


$error_msg = "";


$variables=getVariables();
extract($variables);
$prosesapi=1;
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;
$param_api_name = null;
$param_api_description = null;
$param_api_classadministrativeedit_class_id = null;

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

if(isset($obj->name)){
$param_api_name=$obj->name;
$variables['param_api_name']=$obj->name;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="name tidak ada";
}

if(isset($obj->description)){
$param_api_description=$obj->description;
$variables['param_api_description']=$obj->description;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="description tidak ada";
}

if(isset($obj->classadministrativeedit_class_id)){
$param_api_classadministrativeedit_class_id=$obj->classadministrativeedit_class_id;
$variables['param_api_classadministrativeedit_class_id']=$obj->classadministrativeedit_class_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="classadministrativeedit_class_id tidak ada";
}

if ($prosesapi==1){



$obj_table_tb_class = null; 


$obj_table_tb_class = new model_tabel_tb_class();
$obj_table_tb_class->variables=$variables;




$hasil_updatetb_class = null;



$hasil_updatetb_class = $obj_table_tb_class->Go_table_for_modul_update_data_page_update_dataclass_in_modul_administrative_page_edit_class_update_tb_class($param_api_name,$param_api_description,$param_api_classadministrativeedit_class_id);

$variables['hasil_updatetb_class'] = $hasil_updatetb_class;




$bahan_respon = "{hasil_updatetb_class}";
$bahan_respon=str_replace("{hasil_updatetb_class}",$hasil_updatetb_class,$bahan_respon);
$bahan_respon=str_replace("{hasil_updatetb_class}",$hasil_updatetb_class,$bahan_respon);
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_update_dataclass_in_modul_administrative_page_edit_class

}

function page_update_datastudent_in_modul_people_page_edit_student($obj){
$error_code = "000";


$error_msg = "";


$variables=getVariables();
extract($variables);
$prosesapi=1;
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;
$param_api_name = null;
$param_api_address = null;
$param_api_photo = null;
$param_api_studentpeopleedit_student_id = null;

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

if(isset($obj->name)){
$param_api_name=$obj->name;
$variables['param_api_name']=$obj->name;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="name tidak ada";
}

if(isset($obj->address)){
$param_api_address=$obj->address;
$variables['param_api_address']=$obj->address;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="address tidak ada";
}

if(isset($obj->photo)){
$param_api_photo=$obj->photo;
$variables['param_api_photo']=$obj->photo;
}

if(isset($obj->studentpeopleedit_student_id)){
$param_api_studentpeopleedit_student_id=$obj->studentpeopleedit_student_id;
$variables['param_api_studentpeopleedit_student_id']=$obj->studentpeopleedit_student_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="studentpeopleedit_student_id tidak ada";
}

if ($prosesapi==1){



$obj_table_tb_student = null; 


$obj_table_tb_student = new model_tabel_tb_student();
$obj_table_tb_student->variables=$variables;




$data_diri_tb_student = null;


$data_file_param_api_photo_content = null; 
$data_file_param_api_photo_filename = null; 



$hasil_updatetb_student = null;



$data_diri_tb_student = $obj_table_tb_student->Go_table_for_modul_update_data_page_update_datastudent_in_modul_people_page_edit_student_select_tb_student($param_api_studentpeopleedit_student_id);

$variables['data_diri_tb_student'] = $data_diri_tb_student;

if ( $param_api_photo!=null && $data_diri_tb_student!=null){
$data_file_param_api_photo_content = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $param_api_photo));
$data_file_param_api_photo_filename = "foto_photo_".$base_number_random."_".$base_date_time.".jpg";
$data_file_param_api_photo_filename = str_replace(" ","_",$data_file_param_api_photo_filename);
$data_file_param_api_photo_filename = str_replace(":","_",$data_file_param_api_photo_filename);
$data_file_param_api_photo_filename = str_replace("-","_",$data_file_param_api_photo_filename);
file_put_contents(public_path().$base_upload_directory.$data_file_param_api_photo_filename, $data_file_param_api_photo_content);
$variables['data_file_param_api_photo_filename'] = $data_file_param_api_photo_filename;

}
if ( $data_file_param_api_photo_filename!=null){
if (file_exists(public_path().$base_upload_directory.$data_diri_tb_student['photo'])) {
if (is_file(public_path().$base_upload_directory.$data_diri_tb_student['photo'])) {
unlink(public_path().$base_upload_directory.$data_diri_tb_student['photo']);
}
}

}

$hasil_updatetb_student = $obj_table_tb_student->Go_table_for_modul_update_data_page_update_datastudent_in_modul_people_page_edit_student_update_tb_student($param_api_name,$param_api_address,$data_file_param_api_photo_filename,$param_api_studentpeopleedit_student_id);

$variables['hasil_updatetb_student'] = $hasil_updatetb_student;




$bahan_respon = "{hasil_updatetb_student}";
$bahan_respon=str_replace("{hasil_updatetb_student}",$hasil_updatetb_student,$bahan_respon);
$bahan_respon=str_replace("{hasil_updatetb_student}",$hasil_updatetb_student,$bahan_respon);
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_update_datastudent_in_modul_people_page_edit_student

}



}
