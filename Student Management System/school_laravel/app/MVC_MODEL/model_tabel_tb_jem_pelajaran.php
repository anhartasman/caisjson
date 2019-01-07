<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;

use App\MVC_MODEL\model_tabel_tb_pelajaran;

use DB;

class model_tabel_tb_jem_pelajaran extends Model
{
  /**
  public function __construct() {
      
  }
  **/

    function getLastId(){
$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;


//end of function getLastId

}

function Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_jem_pelajaran($data_diri_siswa){
$variables=$this->variables;
extract($variables);
$hasilbridge = null;



$datahasilbridge=array();
$datahasilbridge[]="id";
$datahasilbridge[]="idp";
$datahasilbridge[]="ids";
$result_for_hasilbridge = DB::table('tb_jem_pelajaran')
-> where ('ids', '=',$data_diri_siswa['id'])
->select($datahasilbridge)
->get()->toArray();
$result_for_hasilbridge = array_map(function($object){return (array) $object;}, $result_for_hasilbridge);
$hasilbridge_array=array();
foreach($result_for_hasilbridge as $key) {
$hasilbridge_array[$key['idp']]=$key['idp'];
}
$hasilbridge = $hasilbridge_array;



return $hasilbridge;


//end of function Go_table_for_modul_tabel_siswa_page_edit_siswa_select_tb_jem_pelajaran

}

function Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_jem_pelajaran($data_diri_siswa){
$variables=$this->variables;
extract($variables);
$hasilbridge = null;



$datahasilbridge=array();
$datahasilbridge[]="id";
$datahasilbridge[]="idp";
$datahasilbridge[]="ids";
$result_for_hasilbridge = DB::table('tb_jem_pelajaran')
-> where ('ids', '=',$data_diri_siswa['id'])
->select($datahasilbridge)
->get()->toArray();
$result_for_hasilbridge = array_map(function($object){return (array) $object;}, $result_for_hasilbridge);
$hasilbridge_array=array();
foreach($result_for_hasilbridge as $key) {
$hasilbridge_array[$key['idp']]=$key['idp'];
}
$hasilbridge = $hasilbridge_array;



return $hasilbridge;


//end of function Go_table_for_modul_tabel_siswa_page_delete_siswa_select_tb_jem_pelajaran

}

function Go_table_for_modul_report_page_get_students_select_tb_jem_pelajaran($qhasil_get_students,$obj_table_tb_pelajaran){
$variables=$this->variables;
extract($variables);
$hasilbridge = null;



$obj_table_tb_pelajaran = new model_tabel_tb_pelajaran();
$obj_table_tb_pelajaran->variables=$variables;




$datahasilbridge=array();
$datahasilbridge[]="id";
$datahasilbridge[]="idp";
$datahasilbridge[]="ids";
$result_for_hasilbridge = DB::table('tb_jem_pelajaran')
-> where ('ids', '=',$qhasil_get_students['id'])
->select($datahasilbridge)
->get()->toArray();
$result_for_hasilbridge = array_map(function($object){return (array) $object;}, $result_for_hasilbridge);
$output_contenthasilbridge="";
$numhasilbridge=0;
$result_for_hasilbridge = array_map(function($object){return (array) $object;}, $result_for_hasilbridge);
foreach($result_for_hasilbridge as $qhasilbridge){
$numhasilbridge+=1;

$hasilpelajaran = $obj_table_tb_pelajaran->Go_table_for_modul_report_page_get_students_select_tb_pelajaran($qhasilbridge);

$variables['hasilpelajaran'] = $hasilpelajaran;

$bahan_outputhasilbridge="".$hasilpelajaran."";
if(count($result_for_hasilbridge)>$numhasilbridge){
$bahan_outputhasilbridge=$bahan_outputhasilbridge.",";
}
$output_contenthasilbridge.=$bahan_outputhasilbridge;
}
$hasilbridge = $output_contenthasilbridge;



return $hasilbridge;


//end of function Go_table_for_modul_report_page_get_students_select_tb_jem_pelajaran

}

function Go_table_for_modul_report_page_insert_data_siswa_bridge_tb_jem_pelajaran($hasil_get_id_id,$param_api_pelajaran_favorit){
$variables=$this->variables;
extract($variables);
$hasil_bridge_pelajaran = null;



$datahasil_bridge_pelajaran=array();
$result_for_hasil_bridge_pelajaran = DB::table('tb_jem_pelajaran')
-> where ('ids', '=',$hasil_get_id_id)
->select(array("id","ids","idp"))
->get()->toArray();
$result_for_hasil_bridge_pelajaran = array_map(function($object){return (array) $object;}, $result_for_hasil_bridge_pelajaran);
$hasil_bridge_pelajaran = $result_for_hasil_bridge_pelajaran;
$jum_bridge_hasil_bridge_pelajaran = count($hasil_bridge_pelajaran);
$jum_right_array_param_api_pelajaran_favorit = count($param_api_pelajaran_favorit);
if($jum_bridge_hasil_bridge_pelajaran > $jum_right_array_param_api_pelajaran_favorit){
$bedajum_bridge_hasil_bridge_pelajaran = $jum_bridge_hasil_bridge_pelajaran - $jum_right_array_param_api_pelajaran_favorit;
for($ib=0;$ib<count($hasil_bridge_pelajaran);$ib++){
if(!in_array($hasil_bridge_pelajaran[$ib]["idp"],$param_api_pelajaran_favorit)){
DB::table('tb_jem_pelajaran')->where("id",$hasil_bridge_pelajaran[$ib]["id"])->delete();
}
}
}else if($jum_bridge_hasil_bridge_pelajaran < $jum_right_array_param_api_pelajaran_favorit){
$bedajum_bridge_hasil_bridge_pelajaran = $jum_right_array_param_api_pelajaran_favorit - $jum_bridge_hasil_bridge_pelajaran;
for($ir=0; $ir<$bedajum_bridge_hasil_bridge_pelajaran; $ir++) {
DB::table('tb_jem_pelajaran')
->insert(array("idp"=>$param_api_pelajaran_favorit[$ir],"ids"=>$hasil_get_id_id));
}
for($ir=0; $ir<count($result_for_hasil_bridge_pelajaran); $ir++) {
DB::table('tb_jem_pelajaran')->where("id",$result_for_hasil_bridge_pelajaran[$ir]["id"])
->update(array("idp"=>$param_api_pelajaran_favorit[$bedajum_bridge_hasil_bridge_pelajaran+$ir]));
}
}else{
for($ir=0; $ir<count($result_for_hasil_bridge_pelajaran); $ir++) {
DB::table('tb_jem_pelajaran')->where("id",$result_for_hasil_bridge_pelajaran[$ir]["id"])
->update(array("idp"=>$param_api_pelajaran_favorit[$ir]));
}
}
$result_for_hasil_bridge_pelajaran = DB::table('tb_jem_pelajaran')
-> where ('ids', '=',$hasil_get_id_id)
->select(array("id","ids","idp"))
->get()->toArray();
$result_for_hasil_bridge_pelajaran = array_map(function($object){return (array) $object;}, $result_for_hasil_bridge_pelajaran);
$hasil_bridge_pelajaran = $result_for_hasil_bridge_pelajaran;



return $hasil_bridge_pelajaran;


//end of function Go_table_for_modul_report_page_insert_data_siswa_bridge_tb_jem_pelajaran

}

function Go_table_for_modul_report_page_update_data_siswa_bridge_tb_jem_pelajaran($param_api_siswa_id,$param_api_pelajaran_favorit){
$variables=$this->variables;
extract($variables);
$hasil_bridge_pelajaran = null;



$datahasil_bridge_pelajaran=array();
$result_for_hasil_bridge_pelajaran = DB::table('tb_jem_pelajaran')
-> where ('ids', '=',$param_api_siswa_id)
->select(array("id","ids","idp"))
->get()->toArray();
$result_for_hasil_bridge_pelajaran = array_map(function($object){return (array) $object;}, $result_for_hasil_bridge_pelajaran);
$hasil_bridge_pelajaran = $result_for_hasil_bridge_pelajaran;
$jum_bridge_hasil_bridge_pelajaran = count($hasil_bridge_pelajaran);
$jum_right_array_param_api_pelajaran_favorit = count($param_api_pelajaran_favorit);
if($jum_bridge_hasil_bridge_pelajaran > $jum_right_array_param_api_pelajaran_favorit){
$bedajum_bridge_hasil_bridge_pelajaran = $jum_bridge_hasil_bridge_pelajaran - $jum_right_array_param_api_pelajaran_favorit;
for($ib=0;$ib<count($hasil_bridge_pelajaran);$ib++){
if(!in_array($hasil_bridge_pelajaran[$ib]["idp"],$param_api_pelajaran_favorit)){
DB::table('tb_jem_pelajaran')->where("id",$hasil_bridge_pelajaran[$ib]["id"])->delete();
}
}
}else if($jum_bridge_hasil_bridge_pelajaran < $jum_right_array_param_api_pelajaran_favorit){
$bedajum_bridge_hasil_bridge_pelajaran = $jum_right_array_param_api_pelajaran_favorit - $jum_bridge_hasil_bridge_pelajaran;
for($ir=0; $ir<$bedajum_bridge_hasil_bridge_pelajaran; $ir++) {
DB::table('tb_jem_pelajaran')
->insert(array("idp"=>$param_api_pelajaran_favorit[$ir],"ids"=>$param_api_siswa_id));
}
for($ir=0; $ir<count($result_for_hasil_bridge_pelajaran); $ir++) {
DB::table('tb_jem_pelajaran')->where("id",$result_for_hasil_bridge_pelajaran[$ir]["id"])
->update(array("idp"=>$param_api_pelajaran_favorit[$bedajum_bridge_hasil_bridge_pelajaran+$ir]));
}
}else{
for($ir=0; $ir<count($result_for_hasil_bridge_pelajaran); $ir++) {
DB::table('tb_jem_pelajaran')->where("id",$result_for_hasil_bridge_pelajaran[$ir]["id"])
->update(array("idp"=>$param_api_pelajaran_favorit[$ir]));
}
}
$result_for_hasil_bridge_pelajaran = DB::table('tb_jem_pelajaran')
-> where ('ids', '=',$param_api_siswa_id)
->select(array("id","ids","idp"))
->get()->toArray();
$result_for_hasil_bridge_pelajaran = array_map(function($object){return (array) $object;}, $result_for_hasil_bridge_pelajaran);
$hasil_bridge_pelajaran = $result_for_hasil_bridge_pelajaran;



return $hasil_bridge_pelajaran;


//end of function Go_table_for_modul_report_page_update_data_siswa_bridge_tb_jem_pelajaran

}



}
