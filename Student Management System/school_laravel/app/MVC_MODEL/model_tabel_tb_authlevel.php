<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;


use DB;

class model_tabel_tb_authlevel extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getLastId(){
$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;


//end of function getLastId

}

function Go_table_for_modul_account_page_login_select_tb_authlevel($hasil_get_akun_idauth,$hasil_get_akun){
$variables=$this->variables;
extract($variables);
$hasil_get_auth = null;



$datahasil_get_auth=array();
$datahasil_get_auth[]="id";
$datahasil_get_auth[]="level";
$result_for_hasil_get_auth = DB::table('tb_authlevel')
-> where ('id', '=',$hasil_get_akun_id_auth)
->select($datahasil_get_auth)
->get()->toArray();
$result_for_hasil_get_auth = array_map(function($object){return (array) $object;}, $result_for_hasil_get_auth);
$output_contenthasil_get_auth="";
$numhasil_get_auth=0;
$result_for_hasil_get_auth = array_map(function($object){return (array) $object;}, $result_for_hasil_get_auth);
foreach($result_for_hasil_get_auth as $qhasil_get_auth){
$numhasil_get_auth+=1;
$bahan_outputhasil_get_auth="{\\"id\\":\\"".$hasil_get_akun['id']."\\",{\\"email\\":\\"".$hasil_get_akun['email']."\\",{\\"level\\":\\"".$qhasil_get_auth['level']."\\"";
$output_contenthasil_get_auth.=$bahan_outputhasil_get_auth;
}
$hasil_get_auth = $output_contenthasil_get_auth;



return $hasil_get_auth;


//end of function Go_table_for_modul_account_page_login_select_tb_authlevel

}



}
