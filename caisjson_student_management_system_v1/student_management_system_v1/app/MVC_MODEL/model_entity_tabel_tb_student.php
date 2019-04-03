<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;


use DB;

class model_entity_tabel_tb_student extends Model
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

function getaddress(){
return $this->address;


//end of function getaddress

}

function setaddress($address){
$this->address=$address;


//end of function setaddress

}

function getphoto(){
return $this->photo;


//end of function getphoto

}

function setphoto($photo){
$this->photo=$photo;


//end of function setphoto

}



}
