<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;

use App\MVC_MODEL\model_entity_factory_tabel_tb_token;

use DB;

class model_tabel_tb_token extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getLastId(){
$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;


//end of function getLastId

}

function Go_table_for_modul_retrieve_data_page_login_delete_tb_token($base_date_time){
$variables=$this->variables;
extract($variables);
$hasil_deletedata_token = null;



$obj_entity_factory_tabel_tb_token = new model_entity_factory_tabel_tb_token();
$obj_entity_factory_tabel_tb_token->variables=$variables;




$datahasil_deletedata_token=array();
$wherearraytb_token=array();
$wherearraytb_token[]=array("column"=>"expired_date","operation"=>"<=","value"=>$base_date_time);
$result_for_hasil_deletedata_token = $obj_entity_factory_tabel_tb_token->delete_data($wherearraytb_token);
$hasil_deletedata_token = $result_for_hasil_deletedata_token["body"];




return $hasil_deletedata_token;


//end of function Go_table_for_modul_retrieve_data_page_login_delete_tb_token

}

function Go_table_for_modul_retrieve_data_page_login_select_tb_token($kuncianhasilacak){
$variables=$this->variables;
extract($variables);
$check_token = null;



$obj_entity_factory_tabel_tb_token = new model_entity_factory_tabel_tb_token();
$obj_entity_factory_tabel_tb_token->variables=$variables;




$datacheck_token=array();
$datacheck_token[]="token";
$wherearraytb_token=array();
$wherearraytb_token[]=array("column"=>"token","operation"=>"=","value"=>$kuncianhasilacak);
$result_for_check_token = $obj_entity_factory_tabel_tb_token->getSingleArray($datacheck_token,$wherearraytb_token);
$check_token = $result_for_check_token;




return $check_token;


//end of function Go_table_for_modul_retrieve_data_page_login_select_tb_token

}

function Go_table_for_modul_retrieve_data_page_login_insert_tb_token($check_account,$kuncianhasilacak,$expired_date){
$variables=$this->variables;
extract($variables);
$hasil_insert_token = null;
$hasil_insert_token_last_id = null;



$obj_entity_factory_tabel_tb_token = new model_entity_factory_tabel_tb_token();
$obj_entity_factory_tabel_tb_token->variables=$variables;




$datahasil_insert_token=array();
$datahasil_insert_token["id_a"]=$check_account['id'];
$datahasil_insert_token["token"]=$kuncianhasilacak;
$datahasil_insert_token["expired_date"]=$expired_date;
$result_for_hasil_insert_token = $obj_entity_factory_tabel_tb_token->insert_data($datahasil_insert_token);
$hasil_insert_token = $result_for_hasil_insert_token["body"];

$hasil_insert_token_last_id = $hasil_insert_token["last_id"];
$this->last_id = $hasil_insert_token_last_id;



return $hasil_insert_token;


//end of function Go_table_for_modul_retrieve_data_page_login_insert_tb_token

}



}
