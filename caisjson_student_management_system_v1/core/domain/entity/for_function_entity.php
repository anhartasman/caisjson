<?php

namespace core\domain\entity;

class for_function_entity  extends for_file_entity {

protected $function_id="";

public function __construct() {

}

function setFunctionID($fid){
  $this->function_id=$fid;
  return $this;
}

function getFunctionID(){
  return $this->function_id;
}


}
 ?>
