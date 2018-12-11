<?php
session_start();
$job="";

if(isset($_GET['job'])){
  $job=$_GET['job'];
}
if (file_exists('fungsi.php')) {
      require_once('fungsi.php');
}
switch($job){
  case "compile":

  include "jobs/compiler.php";

  $platform="";
  if(isset($_GET['platform'])){
    $platform=$_GET['platform'];
  }

  $main_file="";
  if(isset($_GET['main_file'])){
    $main_file=$_GET['main_file'];
  }


  $namafilejson=$main_file.".json";
  $file_address_json="thejson/".$namafilejson;

  if (file_exists($file_address_json)) {
    $generated_code= bacafile($file_address_json);

    $thejson=json_decode($generated_code);

          $objcompiler=new compiler();

          $file_teller=$objcompiler->file_teller($platform,$thejson);
          $file_composer=$objcompiler->file_composer($file_teller["works"],$file_teller["theconfig"]);
          $bahan_respon=$objcompiler->file_worker($file_composer,$file_teller["theconfig"]->web_localpath);

          $response_data = ($file_composer);
  }

  break;
}

 ?>
