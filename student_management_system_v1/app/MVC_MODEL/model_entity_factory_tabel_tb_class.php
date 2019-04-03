<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;

use App\MVC_MODEL\model_entity_tabel_tb_class;
use App\MVC_MODEL\model_port_database;

use DB;

class model_entity_factory_tabel_tb_class extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getArrayArray($selectarraytb_class,$wherearraytb_class){
$obj_port_database = new model_port_database();



$result_for_getArray = $obj_port_database->selectMany("tb_class",$selectarraytb_class,$wherearraytb_class);
$result_for_getArray = array_map(function($object){return (array) $object;}, $result_for_getArray);



return $result_for_getArray;


//end of function getArrayArray

}

function getSingleArray($selectarraytb_class,$wherearraytb_class){
$obj_port_database = new model_port_database();



$result_for_getArray = $obj_port_database->selectSingle("tb_class",$selectarraytb_class,$wherearraytb_class);
$result_for_getArray = (array) $result_for_getArray;



return $result_for_getArray;


//end of function getSingleArray

}

function insert_data($insertArraytb_class){
$obj_port_database = new model_port_database();



$result_for_insert = $obj_port_database->insert_data("tb_class",$insertArraytb_class);



return $result_for_insert;


//end of function insert_data

}

function delete_data($deleteArraytb_class){
$obj_port_database = new model_port_database();



$result_for_delete = $obj_port_database->delete_data("tb_class",$deleteArraytb_class);



return $result_for_delete;


//end of function delete_data

}

function update_data($updateArraytb_class,$whereArraytb_class){
$obj_port_database = new model_port_database();



$result_for_update = $obj_port_database->update_data("tb_class",$updateArraytb_class,$whereArraytb_class);



return $result_for_update;


//end of function update_data

}



}
