<?php
include "../mvc_model/model_tabel_tb_siswa.php";
include "../mvc_model/model_tabel_tb_jem_pelajaran.php";
include "../mvc_model/model_tabel_tb_pelajaran.php";
include "../mvc_model/model_tabel_tb_tingkat.php";
include "../mvc_model/model_tabel_tb_kelas.php";

class model_controller_report {

public function __construct() {
    
}

function page_get_students(){
$variables=$this->variables;
extract($variables);
$prosesapi=1;
$error_code="000";
$error_msg="";
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;
$param_api_kelas_id = null;
$param_api_tingkat_id = null;

if(isset($obj->modul)){
$param_api_modul=$obj->modul;
$variables['param_api_modul']=$obj->modul;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="modul tidak ada";
}

if(isset($obj->action)){
$param_api_action=$obj->action;
$variables['param_api_action']=$obj->action;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="action tidak ada";
}

if(isset($obj->kelas_id)){
$param_api_kelas_id=$obj->kelas_id;
$variables['param_api_kelas_id']=$obj->kelas_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="kelas_id tidak ada";
}

if(isset($obj->tingkat_id)){
$param_api_tingkat_id=$obj->tingkat_id;
$variables['param_api_tingkat_id']=$obj->tingkat_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="tingkat_id tidak ada";
}

if ($prosesapi==1){



$obj_table_tb_siswa = null; 


$obj_table_tb_siswa = new model_tabel_tb_siswa();
$obj_table_tb_siswa->db=$this->db;
$obj_table_tb_siswa->variables=$variables;




$hasil_get_students = null;


$obj_table_tb_jem_pelajaran = null; 


$obj_table_tb_jem_pelajaran = new model_tabel_tb_jem_pelajaran();
$obj_table_tb_jem_pelajaran->db=$this->db;
$obj_table_tb_jem_pelajaran->variables=$variables;




$hasilbridge = null;


$obj_table_tb_pelajaran = null; 


$obj_table_tb_pelajaran = new model_tabel_tb_pelajaran();
$obj_table_tb_pelajaran->db=$this->db;
$obj_table_tb_pelajaran->variables=$variables;




$hasilpelajaran = null;



$hasil_get_students = $obj_table_tb_siswa->Go_table_for_modul_report_page_get_students_select_tb_siswa($param_api_tingkat_id,$param_api_kelas_id,$obj_table_tb_jem_pelajaran,$obj_table_tb_pelajaran);

$variables['hasil_get_students'] = $hasil_get_students;




$bahan_respon = "[{hasil_get_students}]";
$bahan_respon=str_replace("{hasil_get_students}",$hasil_get_students,$bahan_respon);
$bahan_respon=str_replace("{hasil_get_students}",$hasil_get_students,$bahan_respon);
$response_data = json_decode($bahan_respon);
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_get_students

}

function page_get_tingkat(){
$variables=$this->variables;
extract($variables);
$prosesapi=1;
$error_code="000";
$error_msg="";
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;

if(isset($obj->modul)){
$param_api_modul=$obj->modul;
$variables['param_api_modul']=$obj->modul;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="modul tidak ada";
}

if(isset($obj->action)){
$param_api_action=$obj->action;
$variables['param_api_action']=$obj->action;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="action tidak ada";
}

if ($prosesapi==1){



$obj_table_tb_tingkat = null; 


$obj_table_tb_tingkat = new model_tabel_tb_tingkat();
$obj_table_tb_tingkat->db=$this->db;
$obj_table_tb_tingkat->variables=$variables;




$hasil_get_tingkat = null;



$hasil_get_tingkat = $obj_table_tb_tingkat->Go_table_for_modul_report_page_get_tingkat_select_tb_tingkat();

$variables['hasil_get_tingkat'] = $hasil_get_tingkat;




$bahan_respon = "<option value='-1'>- select -</option>{hasil_get_tingkat}";
$bahan_respon=str_replace("{hasil_get_tingkat}",$hasil_get_tingkat,$bahan_respon);
$bahan_respon=str_replace("{hasil_get_tingkat}",$hasil_get_tingkat,$bahan_respon);
$response_data = $bahan_respon;
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_get_tingkat

}

function page_get_kelas(){
$variables=$this->variables;
extract($variables);
$prosesapi=1;
$error_code="000";
$error_msg="";
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;
$param_api_tingkat_id = null;

if(isset($obj->modul)){
$param_api_modul=$obj->modul;
$variables['param_api_modul']=$obj->modul;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="modul tidak ada";
}

if(isset($obj->action)){
$param_api_action=$obj->action;
$variables['param_api_action']=$obj->action;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="action tidak ada";
}

if(isset($obj->tingkat_id)){
$param_api_tingkat_id=$obj->tingkat_id;
$variables['param_api_tingkat_id']=$obj->tingkat_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="tingkat_id tidak ada";
}

if ($prosesapi==1){



$obj_table_tb_kelas = null; 


$obj_table_tb_kelas = new model_tabel_tb_kelas();
$obj_table_tb_kelas->db=$this->db;
$obj_table_tb_kelas->variables=$variables;




$hasil_get_kelas = null;



$hasil_get_kelas = $obj_table_tb_kelas->Go_table_for_modul_report_page_get_kelas_select_tb_kelas($param_api_tingkat_id);

$variables['hasil_get_kelas'] = $hasil_get_kelas;




$bahan_respon = "<option value='-1'>- select -</option>{hasil_get_kelas}";
$bahan_respon=str_replace("{hasil_get_kelas}",$hasil_get_kelas,$bahan_respon);
$bahan_respon=str_replace("{hasil_get_kelas}",$hasil_get_kelas,$bahan_respon);
$response_data = $bahan_respon;
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_get_kelas

}

function page_insert_data_siswa(){
$variables=$this->variables;
extract($variables);
$prosesapi=1;
$error_code="000";
$error_msg="";
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;
$param_api_kelas_id = null;
$param_api_tingkat_id = null;
$param_api_nama = null;
$param_api_email = null;
$param_api_alamat = null;
$param_api_sertifikat = null;
$param_api_handphone = null;
$param_api_fotoprofil = null;
$param_api_pelajaran_favorit = null;

if(isset($obj->modul)){
$param_api_modul=$obj->modul;
$variables['param_api_modul']=$obj->modul;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="modul tidak ada";
}

if(isset($obj->action)){
$param_api_action=$obj->action;
$variables['param_api_action']=$obj->action;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="action tidak ada";
}

if(isset($obj->kelas_id)){
$param_api_kelas_id=$obj->kelas_id;
$variables['param_api_kelas_id']=$obj->kelas_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="kelas_id tidak ada";
}

if(isset($obj->tingkat_id)){
$param_api_tingkat_id=$obj->tingkat_id;
$variables['param_api_tingkat_id']=$obj->tingkat_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="tingkat_id tidak ada";
}

if(isset($obj->nama)){
$param_api_nama=$obj->nama;
$variables['param_api_nama']=$obj->nama;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="nama tidak ada";
}

if(isset($obj->email)){
$param_api_email=$obj->email;
$variables['param_api_email']=$obj->email;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="email tidak ada";
}

if(isset($obj->alamat)){
$param_api_alamat=$obj->alamat;
$variables['param_api_alamat']=$obj->alamat;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="alamat tidak ada";
}

if(isset($obj->sertifikat)){
$param_api_sertifikat=$obj->sertifikat;
$variables['param_api_sertifikat']=$obj->sertifikat;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="sertifikat tidak ada";
}

if(isset($obj->handphone)){
$param_api_handphone=$obj->handphone;
$variables['param_api_handphone']=$obj->handphone;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="handphone tidak ada";
}

if(isset($obj->fotoprofil)){
$param_api_fotoprofil=$obj->fotoprofil;
$variables['param_api_fotoprofil']=$obj->fotoprofil;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="fotoprofil tidak ada";
}

if(isset($obj->pelajaran_favorit)){
$param_api_pelajaran_favorit=$obj->pelajaran_favorit;
$variables['param_api_pelajaran_favorit']=$obj->pelajaran_favorit;
}

if ($prosesapi==1){



$data_file_param_api_fotoprofil_content = null; 
$data_file_param_api_fotoprofil_filename = null; 



$obj_table_tb_siswa = null; 


$obj_table_tb_siswa = new model_tabel_tb_siswa();
$obj_table_tb_siswa->db=$this->db;
$obj_table_tb_siswa->variables=$variables;




$hasil_insert_siswa = null;


$hasil_get_id = null;


$obj_table_tb_jem_pelajaran = null; 


$obj_table_tb_jem_pelajaran = new model_tabel_tb_jem_pelajaran();
$obj_table_tb_jem_pelajaran->db=$this->db;
$obj_table_tb_jem_pelajaran->variables=$variables;




$hasil_bridge_pelajaran = null;


$data_file_param_api_fotoprofil_content = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $param_api_fotoprofil));
$data_file_param_api_fotoprofil_filename = "foto_profil_siswa_{param_api_nama}_".$base_number_random."_".$base_date_time.".jpg";
$data_file_param_api_fotoprofil_filename = str_replace(" ","_",$data_file_param_api_fotoprofil_filename);
$data_file_param_api_fotoprofil_filename = str_replace(":","_",$data_file_param_api_fotoprofil_filename);
$data_file_param_api_fotoprofil_filename = str_replace("-","_",$data_file_param_api_fotoprofil_filename);
file_put_contents($base_upload_directory.$data_file_param_api_fotoprofil_filename, $data_file_param_api_fotoprofil_content);
$variables['data_file_param_api_fotoprofil_filename'] = $data_file_param_api_fotoprofil_filename;

if ( $data_file_param_api_fotoprofil_filename!=null){

$hasil_insert_siswa = $obj_table_tb_siswa->Go_table_for_modul_report_page_insert_data_siswa_insert_tb_siswa($param_api_tingkat_id,$param_api_kelas_id,$param_api_nama,$param_api_email,$param_api_alamat,$param_api_sertifikat,$param_api_handphone,$data_file_param_api_fotoprofil_filename);

$variables['hasil_insert_siswa'] = $hasil_insert_siswa;

}

$hasil_get_id = $obj_table_tb_siswa->Go_table_for_modul_report_page_insert_data_siswa_select_tb_siswa($data_file_param_api_fotoprofil_filename);

$variables['hasil_get_id'] = $hasil_get_id;

if ( $hasil_get_id!=null){

$hasil_bridge_pelajaran = $obj_table_tb_jem_pelajaran->Go_table_for_modul_report_page_insert_data_siswa_bridge_tb_jem_pelajaran($hasil_get_id['id'],$param_api_pelajaran_favorit);

$variables['hasil_bridge_pelajaran'] = $hasil_bridge_pelajaran;

}



$bahan_respon = "{hasil_insert_siswa}";
$bahan_respon=str_replace("{hasil_insert_siswa}",$hasil_insert_siswa,$bahan_respon);
$bahan_respon=str_replace("{hasil_insert_siswa}",$hasil_insert_siswa,$bahan_respon);
$response_data = $bahan_respon;
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_insert_data_siswa

}

function page_update_data_siswa(){
$variables=$this->variables;
extract($variables);
$prosesapi=1;
$error_code="000";
$error_msg="";
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;
$param_api_siswa_id = null;
$param_api_kelas_id = null;
$param_api_tingkat_id = null;
$param_api_nama = null;
$param_api_email = null;
$param_api_alamat = null;
$param_api_sertifikat = null;
$param_api_handphone = null;
$param_api_pelajaran_favorit = null;
$param_api_fotoprofil = null;

if(isset($obj->modul)){
$param_api_modul=$obj->modul;
$variables['param_api_modul']=$obj->modul;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="modul tidak ada";
}

if(isset($obj->action)){
$param_api_action=$obj->action;
$variables['param_api_action']=$obj->action;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="action tidak ada";
}

if(isset($obj->siswa_id)){
$param_api_siswa_id=$obj->siswa_id;
$variables['param_api_siswa_id']=$obj->siswa_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="siswa_id tidak ada";
}

if(isset($obj->kelas_id)){
$param_api_kelas_id=$obj->kelas_id;
$variables['param_api_kelas_id']=$obj->kelas_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="kelas_id tidak ada";
}

if(isset($obj->tingkat_id)){
$param_api_tingkat_id=$obj->tingkat_id;
$variables['param_api_tingkat_id']=$obj->tingkat_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="tingkat_id tidak ada";
}

if(isset($obj->nama)){
$param_api_nama=$obj->nama;
$variables['param_api_nama']=$obj->nama;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="nama tidak ada";
}

if(isset($obj->email)){
$param_api_email=$obj->email;
$variables['param_api_email']=$obj->email;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="email tidak ada";
}

if(isset($obj->alamat)){
$param_api_alamat=$obj->alamat;
$variables['param_api_alamat']=$obj->alamat;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="alamat tidak ada";
}

if(isset($obj->sertifikat)){
$param_api_sertifikat=$obj->sertifikat;
$variables['param_api_sertifikat']=$obj->sertifikat;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="sertifikat tidak ada";
}

if(isset($obj->handphone)){
$param_api_handphone=$obj->handphone;
$variables['param_api_handphone']=$obj->handphone;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="handphone tidak ada";
}

if(isset($obj->pelajaran_favorit)){
$param_api_pelajaran_favorit=$obj->pelajaran_favorit;
$variables['param_api_pelajaran_favorit']=$obj->pelajaran_favorit;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="pelajaran_favorit tidak ada";
}

if(isset($obj->fotoprofil)){
$param_api_fotoprofil=$obj->fotoprofil;
$variables['param_api_fotoprofil']=$obj->fotoprofil;
}

if ($prosesapi==1){



$obj_table_tb_siswa = null; 


$obj_table_tb_siswa = new model_tabel_tb_siswa();
$obj_table_tb_siswa->db=$this->db;
$obj_table_tb_siswa->variables=$variables;




$data_diri_siswa = null;


$data_file_param_api_fotoprofil_content = null; 
$data_file_param_api_fotoprofil_filename = null; 



$hasil_updatedata_siswa = null;


$hasil_updatefoto_siswa = null;


$obj_table_tb_jem_pelajaran = null; 


$obj_table_tb_jem_pelajaran = new model_tabel_tb_jem_pelajaran();
$obj_table_tb_jem_pelajaran->db=$this->db;
$obj_table_tb_jem_pelajaran->variables=$variables;




$hasil_bridge_pelajaran = null;



$data_diri_siswa = $obj_table_tb_siswa->Go_table_for_modul_report_page_update_data_siswa_select_tb_siswa($param_api_siswa_id);

$variables['data_diri_siswa'] = $data_diri_siswa;

if ( $param_api_fotoprofil!=null){
$data_file_param_api_fotoprofil_content = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $param_api_fotoprofil));
$data_file_param_api_fotoprofil_filename = "foto_profil_siswa_{param_api_nama}_".$base_number_random."_".$base_date_time.".jpg";
$data_file_param_api_fotoprofil_filename = str_replace("{param_api_nama}",$param_api_nama,$data_file_param_api_fotoprofil_filename);
$data_file_param_api_fotoprofil_filename = str_replace(" ","_",$data_file_param_api_fotoprofil_filename);
$data_file_param_api_fotoprofil_filename = str_replace(":","_",$data_file_param_api_fotoprofil_filename);
$data_file_param_api_fotoprofil_filename = str_replace("-","_",$data_file_param_api_fotoprofil_filename);
file_put_contents($base_upload_directory.$data_file_param_api_fotoprofil_filename, $data_file_param_api_fotoprofil_content);
$variables['data_file_param_api_fotoprofil_filename'] = $data_file_param_api_fotoprofil_filename;

}
if ( $data_file_param_api_fotoprofil_filename!=null){
if (file_exists($base_upload_directory.$data_diri_siswa['fotoprofil'])) {
unlink($base_upload_directory.$data_diri_siswa['fotoprofil']);
}

}

$hasil_updatedata_siswa = $obj_table_tb_siswa->Go_table_for_modul_report_page_update_data_siswa_update_tb_siswa($param_api_siswa_id,$param_api_tingkat_id,$param_api_kelas_id,$param_api_nama,$param_api_email,$param_api_alamat,$param_api_sertifikat,$param_api_handphone);

$variables['hasil_updatedata_siswa'] = $hasil_updatedata_siswa;

if ( $data_file_param_api_fotoprofil_filename!=null){

$hasil_updatefoto_siswa = $obj_table_tb_siswa->Go_table_for_modul_report_page_update_data_siswa_update_tb_siswa610($param_api_siswa_id,$data_file_param_api_fotoprofil_filename);

$variables['hasil_updatefoto_siswa'] = $hasil_updatefoto_siswa;

}

$hasil_bridge_pelajaran = $obj_table_tb_jem_pelajaran->Go_table_for_modul_report_page_update_data_siswa_bridge_tb_jem_pelajaran($param_api_siswa_id,$param_api_pelajaran_favorit);

$variables['hasil_bridge_pelajaran'] = $hasil_bridge_pelajaran;




$bahan_respon = "{hasil_updatedata_siswa}";
$bahan_respon=str_replace("{hasil_updatedata_siswa}",$hasil_updatedata_siswa,$bahan_respon);
$bahan_respon=str_replace("{hasil_updatedata_siswa}",$hasil_updatedata_siswa,$bahan_respon);
$response_data = $bahan_respon;
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_update_data_siswa

}

function page_delete_data_siswa(){
$variables=$this->variables;
extract($variables);
$prosesapi=1;
$error_code="000";
$error_msg="";
$response_data="";
$returnAPI=array();

$param_api_modul = null;
$param_api_action = null;
$param_api_siswa_id = null;

if(isset($obj->modul)){
$param_api_modul=$obj->modul;
$variables['param_api_modul']=$obj->modul;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="modul tidak ada";
}

if(isset($obj->action)){
$param_api_action=$obj->action;
$variables['param_api_action']=$obj->action;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="action tidak ada";
}

if(isset($obj->siswa_id)){
$param_api_siswa_id=$obj->siswa_id;
$variables['param_api_siswa_id']=$obj->siswa_id;
}else{
$prosesapi=0;
$error_code="001";
$error_msg="siswa_id tidak ada";
}

if ($prosesapi==1){



$obj_table_tb_siswa = null; 


$obj_table_tb_siswa = new model_tabel_tb_siswa();
$obj_table_tb_siswa->db=$this->db;
$obj_table_tb_siswa->variables=$variables;




$data_diri_siswa = null;


$hasil_deletedata_siswa = null;



$data_diri_siswa = $obj_table_tb_siswa->Go_table_for_modul_report_page_delete_data_siswa_select_tb_siswa($param_api_siswa_id);

$variables['data_diri_siswa'] = $data_diri_siswa;

if ( $data_diri_siswa!=null){
if (file_exists($base_upload_directory.$data_diri_siswa['fotoprofil'])) {
unlink($base_upload_directory.$data_diri_siswa['fotoprofil']);
}

}
if ( $data_diri_siswa!=null){

$hasil_deletedata_siswa = $obj_table_tb_siswa->Go_table_for_modul_report_page_delete_data_siswa_delete_tb_siswa($param_api_siswa_id);

$variables['hasil_deletedata_siswa'] = $hasil_deletedata_siswa;

}



$bahan_respon = "{hasil_deletedata_siswa}";
$bahan_respon=str_replace("{hasil_deletedata_siswa}",$hasil_deletedata_siswa,$bahan_respon);
$bahan_respon=str_replace("{hasil_deletedata_siswa}",$hasil_deletedata_siswa,$bahan_respon);
$response_data = $bahan_respon;
}

$returnAPI['error_code']=$error_code;
$returnAPI['error_msg']=$error_msg;
$returnAPI["response_data"]=$response_data;
$hasil=json_encode($returnAPI);
echo $hasil;



//end of function page_delete_data_siswa

}


}
?>
