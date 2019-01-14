<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;

use App\MVC_MODEL\model_tabel_tb_jem_pelajaran;

use DB;

class model_tabel_tb_siswa extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getLastId(){
$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;


//end of function getLastId

}

function Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_siswa($siswa_id){
$variables=$this->variables;
extract($variables);
$data_diri_siswa = null;



$datadata_diri_siswa=array();
$datadata_diri_siswa[]="id";
$datadata_diri_siswa[]="nama";
$datadata_diri_siswa[]="email";
$datadata_diri_siswa[]="handphone";
$datadata_diri_siswa[]="alamat";
$datadata_diri_siswa[]="sertifikat";
$datadata_diri_siswa[]="tingkat_id";
$datadata_diri_siswa[]="kelas_id";
$datadata_diri_siswa[]="fotoprofil";
$result_for_data_diri_siswa = DB::table('tb_siswa')
-> where ('id', '=',$siswa_id)
->select($datadata_diri_siswa)
->first();
$result_for_data_diri_siswa = (array) $result_for_data_diri_siswa;
$data_diri_siswa = $result_for_data_diri_siswa;



return $data_diri_siswa;


//end of function Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_siswa

}

function Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_siswa($siswa_id){
$variables=$this->variables;
extract($variables);
$data_diri_siswa = null;



$datadata_diri_siswa=array();
$datadata_diri_siswa[]="id";
$datadata_diri_siswa[]="nama";
$datadata_diri_siswa[]="email";
$datadata_diri_siswa[]="handphone";
$datadata_diri_siswa[]="alamat";
$datadata_diri_siswa[]="sertifikat";
$datadata_diri_siswa[]="tingkat_id";
$datadata_diri_siswa[]="kelas_id";
$datadata_diri_siswa[]="fotoprofil";
$result_for_data_diri_siswa = DB::table('tb_siswa')
-> where ('id', '=',$siswa_id)
->select($datadata_diri_siswa)
->first();
$result_for_data_diri_siswa = (array) $result_for_data_diri_siswa;
$data_diri_siswa = $result_for_data_diri_siswa;



return $data_diri_siswa;


//end of function Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_siswa

}

function Go_table_for_modul_report_page_get_students_select_tb_siswa($param_api_tingkat_id,$param_api_kelas_id,$obj_table_tb_jem_pelajaran,$obj_table_tb_pelajaran){
$variables=$this->variables;
extract($variables);
$hasil_get_students = null;



$obj_table_tb_jem_pelajaran = new model_tabel_tb_jem_pelajaran();
$obj_table_tb_jem_pelajaran->variables=$variables;




$datahasil_get_students=array();
$datahasil_get_students[]="id";
$datahasil_get_students[]="nama";
$datahasil_get_students[]="email";
$datahasil_get_students[]="handphone";
$datahasil_get_students[]="alamat";
$datahasil_get_students[]="fotoprofil";
$result_for_hasil_get_students = DB::table('tb_siswa')
-> where ('kelas_id', '=',$param_api_kelas_id)
-> where ('tingkat_id', '=',$param_api_tingkat_id)
->select($datahasil_get_students)
->get()->toArray();
$result_for_hasil_get_students = array_map(function($object){return (array) $object;}, $result_for_hasil_get_students);
$output_contenthasil_get_students="";
$numhasil_get_students=0;
$result_for_hasil_get_students = array_map(function($object){return (array) $object;}, $result_for_hasil_get_students);
foreach($result_for_hasil_get_students as $qhasil_get_students){
$numhasil_get_students+=1;

$hasilbridge = $obj_table_tb_jem_pelajaran->Go_table_for_modul_report_page_get_students_select_tb_jem_pelajaran($qhasil_get_students,$obj_table_tb_pelajaran);

$variables['hasilbridge'] = $hasilbridge;

$bahan_outputhasil_get_students="[\"".$qhasil_get_students['id']."\",\"".$qhasil_get_students['nama']."\",\"".$qhasil_get_students['email']."\",\"".$hasilbridge."\",\"<a href=http://localhost/school_laravel/admin/tabel_siswa/edit_siswa/id/".$qhasil_get_students['id'].">Edit ID ".$qhasil_get_students['id']."</a>\",\"<a href=http://localhost/school_laravel/admin/tabel_siswa/delete_siswa/id/".$qhasil_get_students['id'].">Delete ID ".$qhasil_get_students['id']."</a>\"]";
if(count($result_for_hasil_get_students)>$numhasil_get_students){
$bahan_outputhasil_get_students=$bahan_outputhasil_get_students.",";
}
$output_contenthasil_get_students.=$bahan_outputhasil_get_students;
}
$hasil_get_students = $output_contenthasil_get_students;



return $hasil_get_students;


//end of function Go_table_for_modul_report_page_get_students_select_tb_siswa

}

function Go_table_for_modul_report_page_insert_data_siswa_insert_tb_siswa($param_api_tingkat_id,$param_api_kelas_id,$param_api_nama,$param_api_email,$param_api_alamat,$param_api_sertifikat,$param_api_handphone,$data_file_param_api_fotoprofil_filename){
$variables=$this->variables;
extract($variables);
$hasil_insert_siswa = null;
$hasil_insert_siswa_last_id = null;



$datahasil_insert_siswa=array();
$datahasil_insert_siswa['kelas_id']=$param_api_kelas_id;
$datahasil_insert_siswa['tingkat_id']=$param_api_tingkat_id;
$datahasil_insert_siswa['nama']=$param_api_nama;
$datahasil_insert_siswa['email']=$param_api_email;
$datahasil_insert_siswa['alamat']=$param_api_alamat;
$datahasil_insert_siswa['sertifikat']=$param_api_sertifikat;
$datahasil_insert_siswa['handphone']=$param_api_handphone;
$datahasil_insert_siswa['fotoprofil']=$data_file_param_api_fotoprofil_filename;
$result_for_hasil_insert_siswa = DB::table('tb_siswa')
->insert($datahasil_insert_siswa);
$hasil_insert_siswa = $result_for_hasil_insert_siswa;
$hasil_insert_siswa_last_id = DB::getPdo()->lastInsertId();
$this->last_id = $hasil_insert_siswa_last_id;



return $hasil_insert_siswa;


//end of function Go_table_for_modul_report_page_insert_data_siswa_insert_tb_siswa

}

function Go_table_for_modul_report_page_insert_data_siswa_select_tb_siswa($data_file_param_api_fotoprofil_filename){
$variables=$this->variables;
extract($variables);
$hasil_get_id = null;



$datahasil_get_id=array();
$datahasil_get_id[]="id";
$result_for_hasil_get_id = DB::table('tb_siswa')
-> where ('fotoprofil', '=',$data_file_param_api_fotoprofil_filename)
->select($datahasil_get_id)
->first();
$result_for_hasil_get_id = (array) $result_for_hasil_get_id;
$hasil_get_id = $result_for_hasil_get_id;



return $hasil_get_id;


//end of function Go_table_for_modul_report_page_insert_data_siswa_select_tb_siswa

}

function Go_table_for_modul_report_page_update_data_siswa_select_tb_siswa($param_api_siswa_id){
$variables=$this->variables;
extract($variables);
$data_diri_siswa = null;



$datadata_diri_siswa=array();
$datadata_diri_siswa[]="id";
$datadata_diri_siswa[]="nama";
$datadata_diri_siswa[]="email";
$datadata_diri_siswa[]="handphone";
$datadata_diri_siswa[]="alamat";
$datadata_diri_siswa[]="sertifikat";
$datadata_diri_siswa[]="tingkat_id";
$datadata_diri_siswa[]="kelas_id";
$datadata_diri_siswa[]="fotoprofil";
$result_for_data_diri_siswa = DB::table('tb_siswa')
-> where ('id', '=',$param_api_siswa_id)
->select($datadata_diri_siswa)
->first();
$result_for_data_diri_siswa = (array) $result_for_data_diri_siswa;
$data_diri_siswa = $result_for_data_diri_siswa;



return $data_diri_siswa;


//end of function Go_table_for_modul_report_page_update_data_siswa_select_tb_siswa

}

function Go_table_for_modul_report_page_update_data_siswa_update_tb_siswa($param_api_siswa_id,$param_api_tingkat_id,$param_api_kelas_id,$param_api_nama,$param_api_email,$param_api_alamat,$param_api_sertifikat,$param_api_handphone){
$variables=$this->variables;
extract($variables);
$hasil_updatedata_siswa = null;



$datahasil_updatedata_siswa=array();
$datahasil_updatedata_siswa['kelas_id']=$param_api_kelas_id;
$datahasil_updatedata_siswa['tingkat_id']=$param_api_tingkat_id;
$datahasil_updatedata_siswa['nama']=$param_api_nama;
$datahasil_updatedata_siswa['email']=$param_api_email;
$datahasil_updatedata_siswa['alamat']=$param_api_alamat;
$datahasil_updatedata_siswa['sertifikat']=$param_api_sertifikat;
$datahasil_updatedata_siswa['handphone']=$param_api_handphone;
$result_for_hasil_updatedata_siswa = DB::table('tb_siswa')
-> where ('id', '=',$param_api_siswa_id)
->update($datahasil_updatedata_siswa);
$hasil_updatedata_siswa = $result_for_hasil_updatedata_siswa;



return $hasil_updatedata_siswa;


//end of function Go_table_for_modul_report_page_update_data_siswa_update_tb_siswa

}

function Go_table_for_modul_report_page_update_data_siswa_update_tb_siswa520($param_api_siswa_id,$data_file_param_api_fotoprofil_filename){
$variables=$this->variables;
extract($variables);
$hasil_updatefoto_siswa = null;



$datahasil_updatefoto_siswa=array();
$datahasil_updatefoto_siswa['fotoprofil']=$data_file_param_api_fotoprofil_filename;
$result_for_hasil_updatefoto_siswa = DB::table('tb_siswa')
-> where ('id', '=',$param_api_siswa_id)
->update($datahasil_updatefoto_siswa);
$hasil_updatefoto_siswa = $result_for_hasil_updatefoto_siswa;



return $hasil_updatefoto_siswa;


//end of function Go_table_for_modul_report_page_update_data_siswa_update_tb_siswa520

}

function Go_table_for_modul_report_page_delete_data_siswa_select_tb_siswa($param_api_siswa_id){
$variables=$this->variables;
extract($variables);
$data_diri_siswa = null;



$datadata_diri_siswa=array();
$datadata_diri_siswa[]="id";
$datadata_diri_siswa[]="nama";
$datadata_diri_siswa[]="email";
$datadata_diri_siswa[]="handphone";
$datadata_diri_siswa[]="alamat";
$datadata_diri_siswa[]="sertifikat";
$datadata_diri_siswa[]="tingkat_id";
$datadata_diri_siswa[]="kelas_id";
$datadata_diri_siswa[]="fotoprofil";
$result_for_data_diri_siswa = DB::table('tb_siswa')
-> where ('id', '=',$param_api_siswa_id)
->select($datadata_diri_siswa)
->first();
$result_for_data_diri_siswa = (array) $result_for_data_diri_siswa;
$data_diri_siswa = $result_for_data_diri_siswa;



return $data_diri_siswa;


//end of function Go_table_for_modul_report_page_delete_data_siswa_select_tb_siswa

}

function Go_table_for_modul_report_page_delete_data_siswa_delete_tb_siswa($param_api_siswa_id){
$variables=$this->variables;
extract($variables);
$hasil_deletedata_siswa = null;



$datahasil_deletedata_siswa=array();
$result_for_hasil_deletedata_siswa = DB::table('tb_siswa')
-> where ('id', '=',$param_api_siswa_id)
->delete();
$hasil_deletedata_siswa = $result_for_hasil_deletedata_siswa;



return $hasil_deletedata_siswa;


//end of function Go_table_for_modul_report_page_delete_data_siswa_delete_tb_siswa

}



}
