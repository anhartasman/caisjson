<?php

namespace core\domain\entity;

class entity_work {

protected $work_type;
protected $work_id;
protected $work_body;

public function __construct() {

}

function setWorkType($wt){
  $this->work_type=$wt;
  return $this;
}

function setWorkID($id){
  $this->work_id=$id;
  return $this;
}
function setWorkBody($wb){
  $this->work_body=$wb;
  return $this;
}

function getWorkType(){
  return $this->work_type;
}

function getWorkID(){
  return $this->work_id;
}

function getWorkBody(){
  return $this->work_body;
}

}
 ?>
