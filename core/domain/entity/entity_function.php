<?php

namespace core\domain\entity;

class entity_function extends for_file_entity {

protected $name="";
protected $parameters=array();
protected $starter="";

public function __construct() {

}

function setName($fn){
  $this->name=$fn;
  return $this;
}

function setParameters($fp){
  $this->parameters=$fp;
  return $this;
}

function setStarter($fp){
  $this->starter=$fp;
  return $this;
}

function getName(){
  return $this->name;
}

function getParameters(){
  return $this->parameters;
}

function getStarter(){
  return $this->starter;
}

}
 ?>
