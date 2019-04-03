<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;

use App\MVC_MODEL\model_entity_factory_tabel_tb_class;

use DB;

class model_tabel_tb_class extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getLastId(){
$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;


//end of function getLastId

}

function Go_table_for_modul_administrative_page_edit_class_select_tb_class($class_in_modul_administrative_page_edit_class_id){
$variables=$this->variables;
extract($variables);
$data_diri_tb_class = null;



$obj_entity_factory_tabel_tb_class = new model_entity_factory_tabel_tb_class();
$obj_entity_factory_tabel_tb_class->variables=$variables;




$datadata_diri_tb_class=array();
$datadata_diri_tb_class[]="name";
$datadata_diri_tb_class[]="description";
$wherearraytb_class=array();
$wherearraytb_class[]=array("column"=>"id","operation"=>"=","value"=>$class_in_modul_administrative_page_edit_class_id);
$result_for_data_diri_tb_class = $obj_entity_factory_tabel_tb_class->getSingleArray($datadata_diri_tb_class,$wherearraytb_class);
$data_diri_tb_class = $result_for_data_diri_tb_class;




return $data_diri_tb_class;


//end of function Go_table_for_modul_administrative_page_edit_class_select_tb_class

}

function Go_table_for_modul_administrative_page_delete_class_select_tb_class($class_in_modul_administrative_page_delete_class_id){
$variables=$this->variables;
extract($variables);
$data_diri_tb_class = null;



$obj_entity_factory_tabel_tb_class = new model_entity_factory_tabel_tb_class();
$obj_entity_factory_tabel_tb_class->variables=$variables;




$datadata_diri_tb_class=array();
$datadata_diri_tb_class[]="name";
$datadata_diri_tb_class[]="description";
$wherearraytb_class=array();
$wherearraytb_class[]=array("column"=>"id","operation"=>"=","value"=>$class_in_modul_administrative_page_delete_class_id);
$result_for_data_diri_tb_class = $obj_entity_factory_tabel_tb_class->getSingleArray($datadata_diri_tb_class,$wherearraytb_class);
$data_diri_tb_class = $result_for_data_diri_tb_class;




return $data_diri_tb_class;


//end of function Go_table_for_modul_administrative_page_delete_class_select_tb_class

}

function Go_table_for_modul_retrieve_data_page_retrieve_dataclass_in_modul_administrative_page_list_class_select_tb_class(){
$variables=$this->variables;
extract($variables);
$hasil_retrievetb_class = null;



$obj_entity_factory_tabel_tb_class = new model_entity_factory_tabel_tb_class();
$obj_entity_factory_tabel_tb_class->variables=$variables;




$datahasil_retrievetb_class=array();
$datahasil_retrievetb_class[]="name";
$datahasil_retrievetb_class[]="description";
$datahasil_retrievetb_class[]="id";
$wherearraytb_class=array();
$result_for_hasil_retrievetb_class = $obj_entity_factory_tabel_tb_class->getArrayArray($datahasil_retrievetb_class,$wherearraytb_class);
$output_contenthasil_retrievetb_class="";
$numhasil_retrievetb_class=0;
foreach($result_for_hasil_retrievetb_class as $qhasil_retrievetb_class){
$numhasil_retrievetb_class+=1;
$bahan_outputhasil_retrievetb_class="[\"".$qhasil_retrievetb_class['name']."\"".",\"".$qhasil_retrievetb_class['description']."\"".",\"<a href='".url("")."/admin/administrative/edit_class/id/".$qhasil_retrievetb_class['id']."' class='table_link'scannedkey='Array'><img src='http://localhost/student_management_system_v1/public/uploads/edit_icon.png' width='30px' height='30px' /></a>\",\"<a href='".url("")."/admin/administrative/delete_class/id/".$qhasil_retrievetb_class['id']."' class='table_link'scannedkey='Array'><img src='http://localhost/student_management_system_v1/public/uploads/delete_icon.png' width='30px' height='30px' /></a>\"]";
if(count($result_for_hasil_retrievetb_class)>$numhasil_retrievetb_class){
$bahan_outputhasil_retrievetb_class=$bahan_outputhasil_retrievetb_class.",";
}
$output_contenthasil_retrievetb_class.=$bahan_outputhasil_retrievetb_class;
}
$hasil_retrievetb_class = $output_contenthasil_retrievetb_class;



return $hasil_retrievetb_class;


//end of function Go_table_for_modul_retrieve_data_page_retrieve_dataclass_in_modul_administrative_page_list_class_select_tb_class

}

function Go_table_for_modul_insert_data_page_insert_dataclass_in_modul_administrative_page_add_class_insert_tb_class($param_api_name,$param_api_description){
$variables=$this->variables;
extract($variables);
$hasil_inserttb_class = null;
$hasil_inserttb_class_last_id = null;



$obj_entity_factory_tabel_tb_class = new model_entity_factory_tabel_tb_class();
$obj_entity_factory_tabel_tb_class->variables=$variables;




$datahasil_inserttb_class=array();
$datahasil_inserttb_class["name"]=$param_api_name;
$datahasil_inserttb_class["description"]=$param_api_description;
$result_for_hasil_inserttb_class = $obj_entity_factory_tabel_tb_class->insert_data($datahasil_inserttb_class);
$hasil_inserttb_class = $result_for_hasil_inserttb_class["body"];

$hasil_inserttb_class_last_id = $hasil_inserttb_class["last_id"];
$this->last_id = $hasil_inserttb_class_last_id;



return $hasil_inserttb_class;


//end of function Go_table_for_modul_insert_data_page_insert_dataclass_in_modul_administrative_page_add_class_insert_tb_class

}

function Go_table_for_modul_update_data_page_update_dataclass_in_modul_administrative_page_edit_class_update_tb_class($param_api_name,$param_api_description,$param_api_classadministrativeedit_class_id){
$variables=$this->variables;
extract($variables);
$hasil_updatetb_class = null;



$obj_entity_factory_tabel_tb_class = new model_entity_factory_tabel_tb_class();
$obj_entity_factory_tabel_tb_class->variables=$variables;




$datahasil_updatetb_class=array();
$dataupdatetb_class=array();
$dataupdatetb_class["name"]=$param_api_name;
$dataupdatetb_class["description"]=$param_api_description;
$wheredataupdatetb_class=array();
$wheredataupdatetb_class[]=array("column"=>"id","operation"=>"=","value"=>$param_api_classadministrativeedit_class_id);
$result_for_hasil_updatetb_class = $obj_entity_factory_tabel_tb_class->update_data($dataupdatetb_class,$wheredataupdatetb_class);
$hasil_updatetb_class = $result_for_hasil_updatetb_class["body"];




return $hasil_updatetb_class;


//end of function Go_table_for_modul_update_data_page_update_dataclass_in_modul_administrative_page_edit_class_update_tb_class

}

function Go_table_for_modul_delete_data_page_delete_dataclass_in_modul_administrative_page_delete_class_delete_tb_class($param_api_classadministrativedelete_class_id){
$variables=$this->variables;
extract($variables);
$hasil_deletetb_class = null;



$obj_entity_factory_tabel_tb_class = new model_entity_factory_tabel_tb_class();
$obj_entity_factory_tabel_tb_class->variables=$variables;




$datahasil_deletetb_class=array();
$wherearraytb_class=array();
$wherearraytb_class[]=array("column"=>"id","operation"=>"=","value"=>$param_api_classadministrativedelete_class_id);
$result_for_hasil_deletetb_class = $obj_entity_factory_tabel_tb_class->delete_data($wherearraytb_class);
$hasil_deletetb_class = $result_for_hasil_deletetb_class["body"];




return $hasil_deletetb_class;


//end of function Go_table_for_modul_delete_data_page_delete_dataclass_in_modul_administrative_page_delete_class_delete_tb_class

}



}
