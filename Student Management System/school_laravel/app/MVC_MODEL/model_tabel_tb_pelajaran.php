<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;


use DB;

class model_tabel_tb_pelajaran extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getLastId(){
$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;


//end of function getLastId

}

function Go_table_for_modul_tabel_siswa_page_add_siswa_select_tb_pelajaran(){
$variables=$this->variables;
extract($variables);
$daftar_pelajaran = null;



$datadaftar_pelajaran=array();
$datadaftar_pelajaran[]="id";
$datadaftar_pelajaran[]="nama";
$result_for_daftar_pelajaran = DB::table('tb_pelajaran')
->select($datadaftar_pelajaran)
->get()->toArray();
$result_for_daftar_pelajaran = array_map(function($object){return (array) $object;}, $result_for_daftar_pelajaran);
$daftar_pelajaran_array=array();
foreach($result_for_daftar_pelajaran as $key) {
$daftar_pelajaran_array[$key['id']]=$key['nama'];
}
$daftar_pelajaran = $daftar_pelajaran_array;



return $daftar_pelajaran;


//end of function Go_table_for_modul_tabel_siswa_page_add_siswa_select_tb_pelajaran

}

function Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_pelajaran(){
$variables=$this->variables;
extract($variables);
$daftar_pelajaran = null;



$datadaftar_pelajaran=array();
$datadaftar_pelajaran[]="id";
$datadaftar_pelajaran[]="nama";
$result_for_daftar_pelajaran = DB::table('tb_pelajaran')
->select($datadaftar_pelajaran)
->get()->toArray();
$result_for_daftar_pelajaran = array_map(function($object){return (array) $object;}, $result_for_daftar_pelajaran);
$daftar_pelajaran_array=array();
foreach($result_for_daftar_pelajaran as $key) {
$daftar_pelajaran_array[$key['id']]=$key['nama'];
}
$daftar_pelajaran = $daftar_pelajaran_array;



return $daftar_pelajaran;


//end of function Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_pelajaran

}

function Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_pelajaran(){
$variables=$this->variables;
extract($variables);
$daftar_pelajaran = null;



$datadaftar_pelajaran=array();
$datadaftar_pelajaran[]="id";
$datadaftar_pelajaran[]="nama";
$result_for_daftar_pelajaran = DB::table('tb_pelajaran')
->select($datadaftar_pelajaran)
->get()->toArray();
$result_for_daftar_pelajaran = array_map(function($object){return (array) $object;}, $result_for_daftar_pelajaran);
$daftar_pelajaran_array=array();
foreach($result_for_daftar_pelajaran as $key) {
$daftar_pelajaran_array[$key['id']]=$key['nama'];
}
$daftar_pelajaran = $daftar_pelajaran_array;



return $daftar_pelajaran;


//end of function Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_pelajaran

}

function Go_table_for_modul_report_page_get_students_select_tb_pelajaran($qhasilbridge){
$variables=$this->variables;
extract($variables);
$hasilpelajaran = null;



$datahasilpelajaran=array();
$datahasilpelajaran[]="id";
$datahasilpelajaran[]="nama";
$result_for_hasilpelajaran = DB::table('tb_pelajaran')
-> where ('id', '=',$qhasilbridge['idp'])
->select($datahasilpelajaran)
->get()->toArray();
$result_for_hasilpelajaran = array_map(function($object){return (array) $object;}, $result_for_hasilpelajaran);
$output_contenthasilpelajaran="";
$numhasilpelajaran=0;
$result_for_hasilpelajaran = array_map(function($object){return (array) $object;}, $result_for_hasilpelajaran);
foreach($result_for_hasilpelajaran as $qhasilpelajaran){
$numhasilpelajaran+=1;
$bahan_outputhasilpelajaran="".$qhasilpelajaran['nama']."";
if(count($result_for_hasilpelajaran)>$numhasilpelajaran){
$bahan_outputhasilpelajaran=$bahan_outputhasilpelajaran.",";
}
$output_contenthasilpelajaran.=$bahan_outputhasilpelajaran;
}
$hasilpelajaran = $output_contenthasilpelajaran;



return $hasilpelajaran;


//end of function Go_table_for_modul_report_page_get_students_select_tb_pelajaran

}



}
