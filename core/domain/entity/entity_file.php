<?php

namespace core\domain\entity;

class entity_file extends for_file_entity {

protected $file_name="";
protected $file_path="";
protected $file_content="";
protected $id="";

public function __construct() {

}

function setFileName($fn){
  $this->file_name=$fn;
  return $this;
}

function setFilePath($fp){
  $this->file_path=$fp;
  return $this;
}

function setFileContent($fc){
  $this->file_content=$fc;
  return $this;
}

function setID($id){
  $this->id=$id;
  return $this;
}

function setFileID($id){
  $this->id=$id;
  return $this;
}

function getFileName(){
  return $this->file_name;
}

function getFilePath(){
  return $this->file_path;
}

function getFileContent(){
  return $this->file_content;
}

function getID(){
  return $this->id;
}

function getFileID(){
  return $this->id;
}

}
 ?>
