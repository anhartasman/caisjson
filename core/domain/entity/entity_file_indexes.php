<?php

namespace core\domain\entity;

class entity_file_indexes {

protected $folders=array();
protected $files=array();
protected $file_includes=array();
protected $file_functions=array();
protected $function_auth=array();
protected $function_declaration=array();
protected $function_content=array();
protected $function_footer=array();


public function __construct() {

}

public function setFolders($folders){
  $this->folders=$folders;
  return $this;
}

public function getFolders(){

  return $this->folders;
}

public function setFiles($files){
  $this->files=$files;
  return $this;
}

public function getFiles(){

  return $this->files;
}

public function setFileIncludes($file_includes){
  $this->file_includes=$file_includes;
  return $this;

}

public function getFileIncludes(){

  return $this->file_includes;

}

public function setFileFunctions($file_functions){
  $this->file_functions=$file_functions;
  return $this;

}

public function getFileFunctions(){

  return $this->file_functions;

}

public function setFunctionAuth($function_auth){
  $this->function_auth=$function_auth;
  return $this;

}

public function getFunctionAuth(){

  return $this->function_auth;

}

public function setFunctionDeclaration($function_declaration){
  $this->function_declaration=$function_declaration;
  return $this;

}

public function getFunctionDeclaration(){

  return $this->function_declaration;

}

public function setFunctionContent($function_content){
  $this->function_content=$function_content;
  return $this;

}

public function getFunctionContent(){

  return $this->function_content;

}

public function setFunctionFooter($function_footer){
  $this->function_footer=$function_footer;
  return $this;

}

public function getFunctionFooter(){

  return $this->function_footer;

}


}
 ?>
