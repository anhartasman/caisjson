<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;

use App\MVC_MODEL\model_entity_factory_tabel_tb_student;

use DB;

class model_tabel_tb_student extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getLastId(){
$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;


//end of function getLastId

}

function Go_table_for_modul_people_page_edit_student_select_tb_student($student_in_modul_people_page_edit_student_id){
$variables=$this->variables;
extract($variables);
$data_diri_tb_student = null;



$obj_entity_factory_tabel_tb_student = new model_entity_factory_tabel_tb_student();
$obj_entity_factory_tabel_tb_student->variables=$variables;




$datadata_diri_tb_student=array();
$datadata_diri_tb_student[]="name";
$datadata_diri_tb_student[]="address";
$datadata_diri_tb_student[]="photo";
$wherearraytb_student=array();
$wherearraytb_student[]=array("column"=>"id","operation"=>"=","value"=>$student_in_modul_people_page_edit_student_id);
$result_for_data_diri_tb_student = $obj_entity_factory_tabel_tb_student->getSingleArray($datadata_diri_tb_student,$wherearraytb_student);
$data_diri_tb_student = $result_for_data_diri_tb_student;




return $data_diri_tb_student;


//end of function Go_table_for_modul_people_page_edit_student_select_tb_student

}

function Go_table_for_modul_people_page_delete_student_select_tb_student($student_in_modul_people_page_delete_student_id){
$variables=$this->variables;
extract($variables);
$data_diri_tb_student = null;



$obj_entity_factory_tabel_tb_student = new model_entity_factory_tabel_tb_student();
$obj_entity_factory_tabel_tb_student->variables=$variables;




$datadata_diri_tb_student=array();
$datadata_diri_tb_student[]="name";
$datadata_diri_tb_student[]="address";
$datadata_diri_tb_student[]="photo";
$wherearraytb_student=array();
$wherearraytb_student[]=array("column"=>"id","operation"=>"=","value"=>$student_in_modul_people_page_delete_student_id);
$result_for_data_diri_tb_student = $obj_entity_factory_tabel_tb_student->getSingleArray($datadata_diri_tb_student,$wherearraytb_student);
$data_diri_tb_student = $result_for_data_diri_tb_student;




return $data_diri_tb_student;


//end of function Go_table_for_modul_people_page_delete_student_select_tb_student

}

function Go_table_for_modul_retrieve_data_page_retrieve_datastudent_in_modul_people_page_list_student_select_tb_student(){
$variables=$this->variables;
extract($variables);
$hasil_retrievetb_student = null;



$obj_entity_factory_tabel_tb_student = new model_entity_factory_tabel_tb_student();
$obj_entity_factory_tabel_tb_student->variables=$variables;




$datahasil_retrievetb_student=array();
$datahasil_retrievetb_student[]="name";
$datahasil_retrievetb_student[]="photo";
$datahasil_retrievetb_student[]="address";
$datahasil_retrievetb_student[]="id";
$wherearraytb_student=array();
$result_for_hasil_retrievetb_student = $obj_entity_factory_tabel_tb_student->getArrayArray($datahasil_retrievetb_student,$wherearraytb_student);
$output_contenthasil_retrievetb_student="";
$numhasil_retrievetb_student=0;
foreach($result_for_hasil_retrievetb_student as $qhasil_retrievetb_student){
$numhasil_retrievetb_student+=1;
$bahan_outputhasil_retrievetb_student="[\"".$qhasil_retrievetb_student['name']."\"".",\"<img src='http://localhost/student_management_system_v1/public/uploads/".$qhasil_retrievetb_student['photo']."'  width='30px' height='30px' />\",\"".$qhasil_retrievetb_student['address']."\"".",\"<a href='".url("")."/admin/people/edit_student/id/".$qhasil_retrievetb_student['id']."' class='table_link'scannedkey='Array'><img src='http://localhost/student_management_system_v1/public/uploads/edit_icon.png' width='30px' height='30px' /></a>\",\"<a href='".url("")."/admin/people/delete_student/id/".$qhasil_retrievetb_student['id']."' class='table_link'scannedkey='Array'><img src='http://localhost/student_management_system_v1/public/uploads/delete_icon.png' width='30px' height='30px' /></a>\"]";
if(count($result_for_hasil_retrievetb_student)>$numhasil_retrievetb_student){
$bahan_outputhasil_retrievetb_student=$bahan_outputhasil_retrievetb_student.",";
}
$output_contenthasil_retrievetb_student.=$bahan_outputhasil_retrievetb_student;
}
$hasil_retrievetb_student = $output_contenthasil_retrievetb_student;



return $hasil_retrievetb_student;


//end of function Go_table_for_modul_retrieve_data_page_retrieve_datastudent_in_modul_people_page_list_student_select_tb_student

}

function Go_table_for_modul_insert_data_page_insert_datastudent_in_modul_people_page_add_student_insert_tb_student($param_api_name,$param_api_address,$data_file_param_api_photo_filename){
$variables=$this->variables;
extract($variables);
$hasil_inserttb_student = null;
$hasil_inserttb_student_last_id = null;



$obj_entity_factory_tabel_tb_student = new model_entity_factory_tabel_tb_student();
$obj_entity_factory_tabel_tb_student->variables=$variables;




$datahasil_inserttb_student=array();
$datahasil_inserttb_student["name"]=$param_api_name;
$datahasil_inserttb_student["address"]=$param_api_address;
$datahasil_inserttb_student["photo"]=$data_file_param_api_photo_filename;
$result_for_hasil_inserttb_student = $obj_entity_factory_tabel_tb_student->insert_data($datahasil_inserttb_student);
$hasil_inserttb_student = $result_for_hasil_inserttb_student["body"];

$hasil_inserttb_student_last_id = $hasil_inserttb_student["last_id"];
$this->last_id = $hasil_inserttb_student_last_id;



return $hasil_inserttb_student;


//end of function Go_table_for_modul_insert_data_page_insert_datastudent_in_modul_people_page_add_student_insert_tb_student

}

function Go_table_for_modul_update_data_page_update_datastudent_in_modul_people_page_edit_student_select_tb_student($param_api_studentpeopleedit_student_id){
$variables=$this->variables;
extract($variables);
$data_diri_tb_student = null;



$obj_entity_factory_tabel_tb_student = new model_entity_factory_tabel_tb_student();
$obj_entity_factory_tabel_tb_student->variables=$variables;




$datadata_diri_tb_student=array();
$datadata_diri_tb_student[]="photo";
$wherearraytb_student=array();
$wherearraytb_student[]=array("column"=>"id","operation"=>"=","value"=>$param_api_studentpeopleedit_student_id);
$result_for_data_diri_tb_student = $obj_entity_factory_tabel_tb_student->getSingleArray($datadata_diri_tb_student,$wherearraytb_student);
$data_diri_tb_student = $result_for_data_diri_tb_student;




return $data_diri_tb_student;


//end of function Go_table_for_modul_update_data_page_update_datastudent_in_modul_people_page_edit_student_select_tb_student

}

function Go_table_for_modul_update_data_page_update_datastudent_in_modul_people_page_edit_student_update_tb_student($param_api_name,$param_api_address,$data_file_param_api_photo_filename,$param_api_studentpeopleedit_student_id){
$variables=$this->variables;
extract($variables);
$hasil_updatetb_student = null;



$obj_entity_factory_tabel_tb_student = new model_entity_factory_tabel_tb_student();
$obj_entity_factory_tabel_tb_student->variables=$variables;




$datahasil_updatetb_student=array();
$dataupdatetb_student=array();
$dataupdatetb_student["name"]=$param_api_name;
$dataupdatetb_student["address"]=$param_api_address;
$dataupdatetb_student["photo"]=$data_file_param_api_photo_filename;
$wheredataupdatetb_student=array();
$wheredataupdatetb_student[]=array("column"=>"id","operation"=>"=","value"=>$param_api_studentpeopleedit_student_id);
$result_for_hasil_updatetb_student = $obj_entity_factory_tabel_tb_student->update_data($dataupdatetb_student,$wheredataupdatetb_student);
$hasil_updatetb_student = $result_for_hasil_updatetb_student["body"];




return $hasil_updatetb_student;


//end of function Go_table_for_modul_update_data_page_update_datastudent_in_modul_people_page_edit_student_update_tb_student

}

function Go_table_for_modul_delete_data_page_delete_datastudent_in_modul_people_page_delete_student_delete_tb_student($param_api_studentpeopledelete_student_id){
$variables=$this->variables;
extract($variables);
$hasil_deletetb_student = null;



$obj_entity_factory_tabel_tb_student = new model_entity_factory_tabel_tb_student();
$obj_entity_factory_tabel_tb_student->variables=$variables;




$datahasil_deletetb_student=array();
$wherearraytb_student=array();
$wherearraytb_student[]=array("column"=>"id","operation"=>"=","value"=>$param_api_studentpeopledelete_student_id);
$result_for_hasil_deletetb_student = $obj_entity_factory_tabel_tb_student->delete_data($wherearraytb_student);
$hasil_deletetb_student = $result_for_hasil_deletetb_student["body"];




return $hasil_deletetb_student;


//end of function Go_table_for_modul_delete_data_page_delete_datastudent_in_modul_people_page_delete_student_delete_tb_student

}



}
