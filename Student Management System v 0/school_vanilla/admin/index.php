<?php
session_start();
include "../utils/helpers.php";
include "../config/system.php";
$base_url="http://localhost/school_vanilla";
$nowpath=str_replace($base_url."/","",getCurrentURL());
$url = explode("/",$nowpath);
$segmen1   = $url[0];
$segmen2   = "";
$segmen3   = "";
if(count($url)>2){
$segmen2   = $url[1];
$segmen3   = $url[2];
}
if($segmen2==""){
  $segmen2="info_sekolah";
  $segmen3="berita";
}

?>
<?php
$segmen_name=$segmen2."/".$segmen3;
//echo $segmen_name;
include "../config/database.php";
include "../utils/variables.php";
include "../mvc_controller/controller_".$segmen2.".php";

$system_database = new system_database();
$class = 'model_controller_'.$segmen2;
$main= new $class();
$main->db=$system_database->getDB();
$main->variables=$variables;
include "inc_modul_".$segmen2."_page_".$segmen3.".php";
 ?>
