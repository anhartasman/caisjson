<?php

namespace core\domain\entity;

class entity_function_auth extends for_function_entity {

protected $content_footer="";
public function __construct() {

}

function setContentFooter($fn){
  $this->content_footer=$fn;
  return $this;
}

function getContentFooter(){
  return $this->content_footer;
}

}
 ?>
