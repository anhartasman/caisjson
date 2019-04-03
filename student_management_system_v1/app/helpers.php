<?php
function getCurrentURL()
{

      $currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
      $currentURL .= $_SERVER["SERVER_NAME"];

      if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
      {
          $currentURL .= ":".$_SERVER["SERVER_PORT"];
      }

          $currentURL .= $_SERVER["REQUEST_URI"];

      return $currentURL;

}

function getVariables(){
$variables=array();
$base_url="http://localhost/student_management_system_v1";
$base_upload_directory="/uploads/";
$variables['base_url']=$base_url;
$variables['base_number_random']=rand(1,1000000);
$variables['base_date']=date("Y-m-d");
$variables['base_date_time']=date("Y-m-d h:i:s");
$variables['base_upload_directory']=$base_upload_directory;

$status_laporan=array();
$status_laporan['0']="Belum dikonfirmasi";
$status_laporan['1']="Sudah konfirmasi";
$status_laporan['2']="Selesai";
$status_laporan['3']="Dicancel";
$variables["status_laporan"]=$status_laporan;
$status_siswa=array();
$status_siswa['0']="Asli";
$status_siswa['1']="Pindahan";
$status_siswa['2']="Dikeluarkan";
$status_siswa['3']="Bermasalah";
$variables["status_siswa"]=$status_siswa;
$status_hotel=array();
$status_hotel['0']="Asli";
$status_hotel['1']="Pindahan";
$status_hotel['2']="Dikeluarkan";
$status_hotel['3']="Bermasalah";
$variables["status_hotel"]=$status_hotel;
$bintang_hotel=array();
$bintang_hotel['0']="0";
$bintang_hotel['1']="1";
$bintang_hotel['2']="2";
$bintang_hotel['3']="3";
$bintang_hotel['4']="4";
$bintang_hotel['5']="5";
$variables["bintang_hotel"]=$bintang_hotel;


  return $variables;
}

 ?>
