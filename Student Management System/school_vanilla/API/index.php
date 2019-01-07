<?php
session_start();
include "../utils/helpers.php";
include "../config/system.php";
header('Content-Type: application/json');
$modul="";
$action="";
$prosesapi=1;
$error_code="000";
$error_msg="";
$returnAPI=array();
$nowpath=str_replace($base_url."/","",getCurrentURL());
$url = explode("/",$nowpath);

  $json = file_get_contents('php://input');
  $obj = json_decode($json);
  if(!empty($obj->modul)){
  $modul=$obj->modul;
  }else{
  $prosesapi=0;
  $returnAPI['error_code']="001";
  $returnAPI['error_msg']="Modul API tidak ada";
  }

  if(!empty($obj->action)){
  $action=$obj->action;
  }else{
  $prosesapi=0;
  $returnAPI['error_code']="001";
  $returnAPI['error_msg']="Action API tidak ada ".$json." aaa";
  }

if($prosesapi==1){

  include "../config/database.php";
  include "../utils/variables.php";
  include "../mvc_controller/controller_".$modul.".php";

  $system_database = new system_database();
  $variables["modul"]=$modul;
  $variables["action"]=$action;
  $variables["obj"]=$obj;

  $returnAPI['modul']=$modul;
  $returnAPI['action']=$action;

$class = 'model_controller_'.$modul;
$main= new $class();
$main->db=$system_database->getDB();
$main->variables=$variables;
include "inc_modul_".$modul."_page_".$action.".php";
}
                $hasil=json_encode($returnAPI);
                //echo $hasil;
 ?>
