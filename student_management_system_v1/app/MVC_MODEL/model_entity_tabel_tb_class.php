<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;


use DB;

class model_entity_tabel_tb_class extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getname(){
return $this->name;


//end of function getname

}

function setname($name){
$this->name=$name;


//end of function setname

}

function getdescription(){
return $this->description;


//end of function getdescription

}

function setdescription($description){
$this->description=$description;


//end of function setdescription

}



}
