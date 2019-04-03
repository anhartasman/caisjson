<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;

use App\MVC_MODEL\model_tabel_tb_tingkat;

use DB;

class model_tabel_tb_tingkat extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getLastId(){
$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;


//end of function getLastId

}

function Go_table_for_modul_tabel_siswa_page_add_siswa_select_tb_tingkat(){
$variables=$this->variables;
extract($variables);
$daftar_tingkat = null;



$datadaftar_tingkat=array();
$datadaftar_tingkat[]="id";
$datadaftar_tingkat[]="nama";
$result_for_daftar_tingkat = DB::table('tb_tingkat')
->select($datadaftar_tingkat)
->get()->toArray();
$result_for_daftar_tingkat = array_map(function($object){return (array) $object;}, $result_for_daftar_tingkat);
$daftar_tingkat_array=array();
foreach($result_for_daftar_tingkat as $key) {
$daftar_tingkat_array[$key['id']]=$key['nama'];
}
$daftar_tingkat = $daftar_tingkat_array;



return $daftar_tingkat;


//end of function Go_table_for_modul_tabel_siswa_page_add_siswa_select_tb_tingkat

}

function Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_tingkat(){
$variables=$this->variables;
extract($variables);
$daftar_tingkat = null;



$datadaftar_tingkat=array();
$datadaftar_tingkat[]="id";
$datadaftar_tingkat[]="nama";
$result_for_daftar_tingkat = DB::table('tb_tingkat')
->select($datadaftar_tingkat)
->get()->toArray();
$result_for_daftar_tingkat = array_map(function($object){return (array) $object;}, $result_for_daftar_tingkat);
$daftar_tingkat_array=array();
foreach($result_for_daftar_tingkat as $key) {
$daftar_tingkat_array[$key['id']]=$key['nama'];
}
$daftar_tingkat = $daftar_tingkat_array;



return $daftar_tingkat;


//end of function Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_tingkat

}

function Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_tingkat($data_diri_siswa){
$variables=$this->variables;
extract($variables);
$daftar_tingkat = null;



$datadaftar_tingkat=array();
$datadaftar_tingkat[]="id";
$datadaftar_tingkat[]="nama";
$result_for_daftar_tingkat = DB::table('tb_tingkat')
-> where ('id', '=',$data_diri_siswa['tingkat_id'])
->select($datadaftar_tingkat)
->get()->toArray();
$result_for_daftar_tingkat = array_map(function($object){return (array) $object;}, $result_for_daftar_tingkat);
$daftar_tingkat_array=array();
foreach($result_for_daftar_tingkat as $key) {
$daftar_tingkat_array[$key['id']]=$key['nama'];
}
$daftar_tingkat = $daftar_tingkat_array;



return $daftar_tingkat;


//end of function Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_tingkat

}

function Go_table_for_modul_report_page_get_tingkat_select_tb_tingkat(){
$variables=$this->variables;
extract($variables);
$hasil_get_tingkat = null;



$datahasil_get_tingkat=array();
$datahasil_get_tingkat[]="id";
$datahasil_get_tingkat[]="nama";
$result_for_hasil_get_tingkat = DB::table('tb_tingkat')
->select($datahasil_get_tingkat)
->get()->toArray();
$result_for_hasil_get_tingkat = array_map(function($object){return (array) $object;}, $result_for_hasil_get_tingkat);
$output_contenthasil_get_tingkat="";
$numhasil_get_tingkat=0;
$result_for_hasil_get_tingkat = array_map(function($object){return (array) $object;}, $result_for_hasil_get_tingkat);
foreach($result_for_hasil_get_tingkat as $qhasil_get_tingkat){
$numhasil_get_tingkat+=1;
$bahan_outputhasil_get_tingkat="<option value='".$qhasil_get_tingkat['id']."'>".$qhasil_get_tingkat['nama']."</option>";
$output_contenthasil_get_tingkat.=$bahan_outputhasil_get_tingkat;
}
$hasil_get_tingkat = $output_contenthasil_get_tingkat;



return $hasil_get_tingkat;


//end of function Go_table_for_modul_report_page_get_tingkat_select_tb_tingkat

}



}
