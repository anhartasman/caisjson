<?php
include "../mvc_model/model_page_add_siswa.php";
include "../mvc_model/model_tabel_tb_tingkat.php";
include "../mvc_model/model_tabel_tb_pelajaran.php";
include "../mvc_model/model_page_edit_siswa.php";
include "../mvc_model/model_tabel_tb_siswa.php";
include "../mvc_model/model_tabel_tb_jem_pelajaran.php";
include "../mvc_model/model_tabel_tb_kelas.php";
include "../mvc_model/model_page_delete_siswa.php";
include "../mvc_model/model_page_daftar_siswa.php";

class model_controller_tabel_siswa {

public function __construct() {
    
}

function page_add_siswa(){
$obj_add_siswa = new model_page_add_siswa();
$obj_add_siswa->db=$this->db;
$variables=$this->variables;
extract($variables);



$obj_table_tb_tingkat = null; 


$obj_table_tb_tingkat = new model_tabel_tb_tingkat();
$obj_table_tb_tingkat->db=$this->db;
$obj_table_tb_tingkat->variables=$variables;




$daftar_tingkat = null;


$obj_table_tb_pelajaran = null; 


$obj_table_tb_pelajaran = new model_tabel_tb_pelajaran();
$obj_table_tb_pelajaran->db=$this->db;
$obj_table_tb_pelajaran->variables=$variables;




$daftar_pelajaran = null;



$daftar_tingkat = $obj_table_tb_tingkat->Go_table_for_modul_tabel_siswa_page_add_siswa_select_tb_tingkat();

$variables['daftar_tingkat'] = $daftar_tingkat;


$daftar_pelajaran = $obj_table_tb_pelajaran->Go_table_for_modul_tabel_siswa_page_add_siswa_select_tb_pelajaran();

$variables['daftar_pelajaran'] = $daftar_pelajaran;




$obj_add_siswa->variables=$variables;

include "../mvc_view/tabel_siswa/add_siswa/index.php";



//end of function page_add_siswa

}

function page_edit_siswa(){
$obj_edit_siswa = new model_page_edit_siswa();
$obj_edit_siswa->db=$this->db;
$variables=$this->variables;
extract($variables);



$url_catch = explode("/",$_SERVER["REQUEST_URI"]);


$obj_table_tb_siswa = null; 


$obj_table_tb_siswa = new model_tabel_tb_siswa();
$obj_table_tb_siswa->db=$this->db;
$obj_table_tb_siswa->variables=$variables;




$data_diri_siswa = null;


$obj_table_tb_pelajaran = null; 


$obj_table_tb_pelajaran = new model_tabel_tb_pelajaran();
$obj_table_tb_pelajaran->db=$this->db;
$obj_table_tb_pelajaran->variables=$variables;




$daftar_pelajaran = null;


$obj_table_tb_jem_pelajaran = null; 


$obj_table_tb_jem_pelajaran = new model_tabel_tb_jem_pelajaran();
$obj_table_tb_jem_pelajaran->db=$this->db;
$obj_table_tb_jem_pelajaran->variables=$variables;




$hasilbridge = null;


$obj_table_tb_tingkat = null; 


$obj_table_tb_tingkat = new model_tabel_tb_tingkat();
$obj_table_tb_tingkat->db=$this->db;
$obj_table_tb_tingkat->variables=$variables;




$daftar_tingkat = null;


$obj_table_tb_kelas = null; 


$obj_table_tb_kelas = new model_tabel_tb_kelas();
$obj_table_tb_kelas->db=$this->db;
$obj_table_tb_kelas->variables=$variables;




$daftar_kelas = null;


$siswa_id = null;
for($i=0; $i<count($url_catch); $i++){
if($url_catch[$i]=="id"){
if($i+1<=count($url_catch)){
$siswa_id = $url_catch[$i+1];
$variables['siswa_id'] = $siswa_id;
}
break;
}
}


$data_diri_siswa = $obj_table_tb_siswa->Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_siswa($siswa_id);

$variables['data_diri_siswa'] = $data_diri_siswa;


$daftar_pelajaran = $obj_table_tb_pelajaran->Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_pelajaran();

$variables['daftar_pelajaran'] = $daftar_pelajaran;


$hasilbridge = $obj_table_tb_jem_pelajaran->Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_jem_pelajaran($data_diri_siswa);

$variables['hasilbridge'] = $hasilbridge;


$daftar_tingkat = $obj_table_tb_tingkat->Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_tingkat();

$variables['daftar_tingkat'] = $daftar_tingkat;


$daftar_kelas = $obj_table_tb_kelas->Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_kelas($data_diri_siswa['tingkat_id']);

$variables['daftar_kelas'] = $daftar_kelas;




$obj_edit_siswa->variables=$variables;

include "../mvc_view/tabel_siswa/edit_siswa/index.php";



//end of function page_edit_siswa

}

function page_delete_siswa(){
$obj_delete_siswa = new model_page_delete_siswa();
$obj_delete_siswa->db=$this->db;
$variables=$this->variables;
extract($variables);



$url_catch = explode("/",$_SERVER["REQUEST_URI"]);


$obj_table_tb_siswa = null; 


$obj_table_tb_siswa = new model_tabel_tb_siswa();
$obj_table_tb_siswa->db=$this->db;
$obj_table_tb_siswa->variables=$variables;




$data_diri_siswa = null;


$obj_table_tb_tingkat = null; 


$obj_table_tb_tingkat = new model_tabel_tb_tingkat();
$obj_table_tb_tingkat->db=$this->db;
$obj_table_tb_tingkat->variables=$variables;




$daftar_tingkat = null;


$obj_table_tb_pelajaran = null; 


$obj_table_tb_pelajaran = new model_tabel_tb_pelajaran();
$obj_table_tb_pelajaran->db=$this->db;
$obj_table_tb_pelajaran->variables=$variables;




$daftar_pelajaran = null;


$obj_table_tb_jem_pelajaran = null; 


$obj_table_tb_jem_pelajaran = new model_tabel_tb_jem_pelajaran();
$obj_table_tb_jem_pelajaran->db=$this->db;
$obj_table_tb_jem_pelajaran->variables=$variables;




$hasilbridge = null;


$obj_table_tb_kelas = null; 


$obj_table_tb_kelas = new model_tabel_tb_kelas();
$obj_table_tb_kelas->db=$this->db;
$obj_table_tb_kelas->variables=$variables;




$daftar_kelas = null;


$siswa_id = null;
for($i=0; $i<count($url_catch); $i++){
if($url_catch[$i]=="id"){
if($i+1<=count($url_catch)){
$siswa_id = $url_catch[$i+1];
$variables['siswa_id'] = $siswa_id;
}
break;
}
}


$data_diri_siswa = $obj_table_tb_siswa->Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_siswa($siswa_id);

$variables['data_diri_siswa'] = $data_diri_siswa;


$daftar_tingkat = $obj_table_tb_tingkat->Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_tingkat($data_diri_siswa);

$variables['daftar_tingkat'] = $daftar_tingkat;


$daftar_pelajaran = $obj_table_tb_pelajaran->Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_pelajaran();

$variables['daftar_pelajaran'] = $daftar_pelajaran;


$hasilbridge = $obj_table_tb_jem_pelajaran->Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_jem_pelajaran($data_diri_siswa);

$variables['hasilbridge'] = $hasilbridge;


$daftar_kelas = $obj_table_tb_kelas->Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_kelas($data_diri_siswa);

$variables['daftar_kelas'] = $daftar_kelas;




$obj_delete_siswa->variables=$variables;

include "../mvc_view/tabel_siswa/delete_siswa/index.php";



//end of function page_delete_siswa

}

function page_daftar_siswa(){
$obj_daftar_siswa = new model_page_daftar_siswa();
$obj_daftar_siswa->db=$this->db;
$variables=$this->variables;
extract($variables);



$obj_daftar_siswa->variables=$variables;

include "../mvc_view/tabel_siswa/daftar_siswa/index.php";



//end of function page_daftar_siswa

}


}
?>
