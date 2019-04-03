<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;


use DB;

class model_tabel_tb_kelas extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getLastId(){
$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;


//end of function getLastId

}

function Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_kelas($data_diri_siswa_tingkat_id){
$variables=$this->variables;
extract($variables);
$daftar_kelas = null;



$datadaftar_kelas=array();
$datadaftar_kelas[]="id";
$datadaftar_kelas[]="nama";
$result_for_daftar_kelas = DB::table('tb_kelas')
-> where ('tingkat_id', '=',$data_diri_siswa_tingkat_id)
->select($datadaftar_kelas)
->get()->toArray();
$result_for_daftar_kelas = array_map(function($object){return (array) $object;}, $result_for_daftar_kelas);
$daftar_kelas_array=array();
foreach($result_for_daftar_kelas as $key) {
$daftar_kelas_array[$key['id']]=$key['nama'];
}
$daftar_kelas = $daftar_kelas_array;



return $daftar_kelas;


//end of function Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_kelas

}

function Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_kelas($data_diri_siswa){
$variables=$this->variables;
extract($variables);
$daftar_kelas = null;



$datadaftar_kelas=array();
$datadaftar_kelas[]="id";
$datadaftar_kelas[]="nama";
$result_for_daftar_kelas = DB::table('tb_kelas')
-> where ('id', '=',$data_diri_siswa['kelas_id'])
->select($datadaftar_kelas)
->get()->toArray();
$result_for_daftar_kelas = array_map(function($object){return (array) $object;}, $result_for_daftar_kelas);
$daftar_kelas_array=array();
foreach($result_for_daftar_kelas as $key) {
$daftar_kelas_array[$key['id']]=$key['nama'];
}
$daftar_kelas = $daftar_kelas_array;



return $daftar_kelas;


//end of function Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_kelas

}

function Go_table_for_modul_report_page_get_kelas_select_tb_kelas($param_api_tingkat_id){
$variables=$this->variables;
extract($variables);
$hasil_get_kelas = null;



$datahasil_get_kelas=array();
$datahasil_get_kelas[]="id";
$datahasil_get_kelas[]="nama";
$result_for_hasil_get_kelas = DB::table('tb_kelas')
-> where ('tingkat_id', '=',$param_api_tingkat_id)
->select($datahasil_get_kelas)
->get()->toArray();
$result_for_hasil_get_kelas = array_map(function($object){return (array) $object;}, $result_for_hasil_get_kelas);
$output_contenthasil_get_kelas="";
$numhasil_get_kelas=0;
$result_for_hasil_get_kelas = array_map(function($object){return (array) $object;}, $result_for_hasil_get_kelas);
foreach($result_for_hasil_get_kelas as $qhasil_get_kelas){
$numhasil_get_kelas+=1;
$bahan_outputhasil_get_kelas="<option value='".$qhasil_get_kelas['id']."'>".$qhasil_get_kelas['nama']."</option>";
$output_contenthasil_get_kelas.=$bahan_outputhasil_get_kelas;
}
$hasil_get_kelas = $output_contenthasil_get_kelas;



return $hasil_get_kelas;


//end of function Go_table_for_modul_report_page_get_kelas_select_tb_kelas

}



}
