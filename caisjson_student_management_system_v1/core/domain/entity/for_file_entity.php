<?php

namespace core\domain\entity;

class for_file_entity {

protected $content="";
protected $id="";
protected $file_id="";
protected $index=0;

public function __construct() {

}

function setIndex($index){
  $this->index=$index;
  return $this;
}

function getIndex(){
  return $this->index;
}

function setFileID($fid){
  $this->file_id=$fid;
  return $this;
}

function getFileID(){
  return $this->file_id;
}

function setID($id){
  $this->id=$id;
  return $this;
}

function getID(){
  return $this->id;
}

function setContent($c){
  $this->content=$c;
  return $this;
}

function getContent(){
  return $this->content;
}


}
 ?>
