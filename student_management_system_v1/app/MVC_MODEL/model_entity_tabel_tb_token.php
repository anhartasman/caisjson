<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;


use DB;

class model_entity_tabel_tb_token extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getid_a(){
return $this->id_a;


//end of function getid_a

}

function setid_a($id_a){
$this->id_a=$id_a;


//end of function setid_a

}

function gettoken(){
return $this->token;


//end of function gettoken

}

function settoken($token){
$this->token=$token;


//end of function settoken

}

function getexpired_date(){
return $this->expired_date;


//end of function getexpired_date

}

function setexpired_date($expired_date){
$this->expired_date=$expired_date;


//end of function setexpired_date

}



}
