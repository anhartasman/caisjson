<?php

namespace core\domain\entity;

class entity_directory {

protected $directory_name="";
protected $directory_path="";

public function __construct() {

}

function setDirectoryName($fn){
  $this->directory_name=$fn;
  return $this;
}

function setDirectoryPath($fp){
  $this->directory_path=$fp;
  return $this;
}

function getDirectoryName(){
  return $this->directory_name;
}

function getDirectoryPath(){
  return $this->directory_path;
}

}
 ?>
