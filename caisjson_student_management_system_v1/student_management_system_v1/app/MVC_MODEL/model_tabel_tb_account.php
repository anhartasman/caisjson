<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;

use App\MVC_MODEL\model_entity_factory_tabel_tb_account;

use DB;

class model_tabel_tb_account extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getLastId(){
$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;


//end of function getLastId

}

function Go_table_for_modul_retrieve_data_page_login_select_tb_account($param_api_username,$kuncianpassword){
$variables=$this->variables;
extract($variables);
$check_account = null;



$obj_entity_factory_tabel_tb_account = new model_entity_factory_tabel_tb_account();
$obj_entity_factory_tabel_tb_account->variables=$variables;




$datacheck_account=array();
$datacheck_account[]="id";
$datacheck_account[]="username";
$datacheck_account[]="password";
$datacheck_account[]="role";
$wherearraytb_account=array();
$wherearraytb_account[]=array("column"=>"username","operation"=>"=","value"=>$param_api_username);
$wherearraytb_account[]=array("column"=>"password","operation"=>"=","value"=>$kuncianpassword);
$result_for_check_account = $obj_entity_factory_tabel_tb_account->getSingleArray($datacheck_account,$wherearraytb_account);
$check_account = $result_for_check_account;




return $check_account;


//end of function Go_table_for_modul_retrieve_data_page_login_select_tb_account

}



}
