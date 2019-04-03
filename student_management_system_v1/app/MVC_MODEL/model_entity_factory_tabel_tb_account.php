<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;

use App\MVC_MODEL\model_entity_tabel_tb_account;
use App\MVC_MODEL\model_port_database;

use DB;

class model_entity_factory_tabel_tb_account extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getArrayArray($selectarraytb_account,$wherearraytb_account){
$obj_port_database = new model_port_database();



$result_for_getArray = $obj_port_database->selectMany("tb_account",$selectarraytb_account,$wherearraytb_account);
$result_for_getArray = array_map(function($object){return (array) $object;}, $result_for_getArray);



return $result_for_getArray;


//end of function getArrayArray

}

function getSingleArray($selectarraytb_account,$wherearraytb_account){
$obj_port_database = new model_port_database();



$result_for_getArray = $obj_port_database->selectSingle("tb_account",$selectarraytb_account,$wherearraytb_account);
$result_for_getArray = (array) $result_for_getArray;



return $result_for_getArray;


//end of function getSingleArray

}

function insert_data($insertArraytb_account){
$obj_port_database = new model_port_database();



$result_for_insert = $obj_port_database->insert_data("tb_account",$insertArraytb_account);



return $result_for_insert;


//end of function insert_data

}

function delete_data($deleteArraytb_account){
$obj_port_database = new model_port_database();



$result_for_delete = $obj_port_database->delete_data("tb_account",$deleteArraytb_account);



return $result_for_delete;


//end of function delete_data

}

function update_data($updateArraytb_account,$whereArraytb_account){
$obj_port_database = new model_port_database();



$result_for_update = $obj_port_database->update_data("tb_account",$updateArraytb_account,$whereArraytb_account);



return $result_for_update;


//end of function update_data

}



}
