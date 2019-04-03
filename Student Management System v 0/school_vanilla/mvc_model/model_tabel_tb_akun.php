<?php

class model_tabel_tb_akun {

public function __construct() {
    
}

function Go_table_for_modul_account_page_login_select_tb_akun($param_api_email,$param_api_password){
$variables=$this->variables;
$db=$this->db;
extract($variables);
$hasil_get_akun = null;



$datahasil_get_akun=array();
$datahasil_get_akun[]="id";
$datahasil_get_akun[]="email";
$datahasil_get_akun[]="password";
$datahasil_get_akun[]="idauth";
$result_for_hasil_get_akun = $db->from('tb_akun')
-> where ('email =',$email)
-> where ('password =',$password)
->select($datahasil_get_akun)
->one();
$hasil_get_akun = $result_for_hasil_get_akun;



return $hasil_get_akun;


//end of function Go_table_for_modul_account_page_login_select_tb_akun

}


}
?>
