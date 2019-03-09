<?php
include("std_view.php");
//$thejson=null;
$thenewjson =  std_project();
$laravelconfig=std_project_config();

$laravelconfig->config_type="weblaravellokal";
$laravelconfig->database_host="localhost";
$laravelconfig->database_name="belajarcrud";
$laravelconfig->database_username="root";
$laravelconfig->database_password="";
$laravelconfig->web_url="http:\/\/localhost\/hargakamar";
$laravelconfig->web_localpath="..\/hargakamar\/";
$laravelconfig->web_description="Sistem Informasi Hotel";

$thenewjson->project_config[]=$laravelconfig;

$laravelconfig->config_type="weblaravel";
$laravelconfig->database_host="10.20.30.5";
$laravelconfig->database_name="managementhotel";
$laravelconfig->database_port="3908";
$laravelconfig->database_username="anhar";
$laravelconfig->database_password="4nH4rDB!";
$laravelconfig->web_url="http://managementhotel.infiniqa.com";
$laravelconfig->web_localpath="..\/hargakamar_publish\/";
$laravelconfig->web_description="Sistem Informasi Hotel";

$thenewjson->project_config[]=$laravelconfig;

require_once("thephp/supplier/daftar_modul.php");

//$thejson->moduls[]=modul_supplier();
//$thejson->auth[]=auth_modul_supplier();

//echo "TYPENYA : ".var_dump($thejson);
 ?>
