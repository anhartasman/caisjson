<?php
include "../mvc_model/model_tabel_tb_tingkat.php";

class model_tabel_tb_tingkat {

public function __construct() {
    
}

function Go_table_for_modul_tabel_siswa_page_add_siswa_select_tb_tingkat(){
$variables=$this->variables;
$db=$this->db;
extract($variables);
$daftar_tingkat = null;



$datadaftar_tingkat=array();
$datadaftar_tingkat[]="id";
$datadaftar_tingkat[]="nama";
$result_for_daftar_tingkat = $db->from('tb_tingkat')
->select($datadaftar_tingkat)
->many();
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
$db=$this->db;
extract($variables);
$daftar_tingkat = null;



$datadaftar_tingkat=array();
$datadaftar_tingkat[]="id";
$datadaftar_tingkat[]="nama";
$result_for_daftar_tingkat = $db->from('tb_tingkat')
->select($datadaftar_tingkat)
->many();
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
$db=$this->db;
extract($variables);
$daftar_tingkat = null;



$datadaftar_tingkat=array();
$datadaftar_tingkat[]="id";
$datadaftar_tingkat[]="nama";
$result_for_daftar_tingkat = $db->from('tb_tingkat')
-> where ('id =',$data_diri_siswa['tingkat_id'])
->select($datadaftar_tingkat)
->many();
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
$db=$this->db;
extract($variables);
$hasil_get_tingkat = null;



$datahasil_get_tingkat=array();
$datahasil_get_tingkat[]="id";
$datahasil_get_tingkat[]="nama";
$result_for_hasil_get_tingkat = $db->from('tb_tingkat')
->select($datahasil_get_tingkat)
->many();
$output_contenthasil_get_tingkat="";
$numhasil_get_tingkat=0;
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
?>
