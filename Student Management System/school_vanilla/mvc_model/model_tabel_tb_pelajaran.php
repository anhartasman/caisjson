<?php

class model_tabel_tb_pelajaran {

public function __construct() {
    
}

function Go_table_for_modul_tabel_siswa_page_add_siswa_select_tb_pelajaran(){
$variables=$this->variables;
$db=$this->db;
extract($variables);
$daftar_pelajaran = null;



$datadaftar_pelajaran=array();
$datadaftar_pelajaran[]="id";
$datadaftar_pelajaran[]="nama";
$result_for_daftar_pelajaran = $db->from('tb_pelajaran')
->select($datadaftar_pelajaran)
->many();
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
$db=$this->db;
extract($variables);
$daftar_pelajaran = null;



$datadaftar_pelajaran=array();
$datadaftar_pelajaran[]="id";
$datadaftar_pelajaran[]="nama";
$result_for_daftar_pelajaran = $db->from('tb_pelajaran')
->select($datadaftar_pelajaran)
->many();
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
$db=$this->db;
extract($variables);
$daftar_pelajaran = null;



$datadaftar_pelajaran=array();
$datadaftar_pelajaran[]="id";
$datadaftar_pelajaran[]="nama";
$result_for_daftar_pelajaran = $db->from('tb_pelajaran')
->select($datadaftar_pelajaran)
->many();
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
$db=$this->db;
extract($variables);
$hasilpelajaran = null;



$datahasilpelajaran=array();
$datahasilpelajaran[]="id";
$datahasilpelajaran[]="nama";
$result_for_hasilpelajaran = $db->from('tb_pelajaran')
-> where ('id =',$qhasilbridge['idp'])
->select($datahasilpelajaran)
->many();
$output_contenthasilpelajaran="";
$numhasilpelajaran=0;
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
?>
