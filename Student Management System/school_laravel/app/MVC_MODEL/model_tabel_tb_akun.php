<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;


use DB;

class model_tabel_tb_akun extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getLastId(){
$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;


//end of function getLastId

}

function Go_table_for_modul_account_page_login_select_tb_akun($param_api_email,$param_api_password){
$variables=$this->variables;
extract($variables);
$hasil_get_akun = null;



$datahasil_get_akun=array();
$datahasil_get_akun[]="id";
$datahasil_get_akun[]="email";
$datahasil_get_akun[]="password";
$datahasil_get_akun[]="idauth";
$result_for_hasil_get_akun = DB::table('tb_akun')
-> where ('email', '=',$email)
-> where ('password', '=',$password)
->select($datahasil_get_akun)
->first();
$result_for_hasil_get_akun = (array) $result_for_hasil_get_akun;
$hasil_get_akun = $result_for_hasil_get_akun;



return $hasil_get_akun;


//end of function Go_table_for_modul_account_page_login_select_tb_akun

}



}
