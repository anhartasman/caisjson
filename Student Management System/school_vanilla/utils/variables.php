<?php
$variables=array();
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

 ?>
