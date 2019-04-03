<?php
include("std_view.php");
include("std_process.php");
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

$manifest->auth_checking->withisset=true;

require_once("thephp/system_information/system_documentation.php");
$manifest->moduls[]=modul_system_information($thejson);

if(!isset($manifest->auto_crud)){
  $manifest->auto_crud=array();
}
$generated_crud = generate_auto_crud($manifest,$manifest->auto_crud);
$manifest->moduls=array_merge($manifest->moduls,$generated_crud["moduls_list"]);

$page_list=$generated_crud["page_list"];
$api_list=$generated_crud["api_list"];
for($p=0; $p<count($page_list); $p++){

  for($i=0; $i<count($manifest->moduls); $i++){
    if($manifest->moduls[$i]->id==$page_list[$p]->properties_modul){
      $manifest->moduls[$i]->page[]=$page_list[$p];
    //  echo "dada ".$page_list[$p]->id;
    }
  }
}

for($i=0; $i<count($manifest->daf_api); $i++){
  $themanafi=$manifest->daf_api[$i];
  for($a=0; $a<count($api_list); $a++){
    if($api_list[$a]->modul==$themanafi->modul){
      $themanafi->action[]=$api_list[$a];
    }
  }
}

for($i=0; $i<count($manifest->moduls); $i++){
  if(!isset($manifest->moduls[$i]->asclass)){
    $manifest->moduls[$i]->asclass=false;
  }
  $controller_name=$manifest->moduls[$i]->id;
  //echo "raa".$controller_name."<BR>";
  for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
  $thepage=$manifest->moduls[$i]->page[$j];
  if(!isset($thepage->noauth)){
    $thepage->noauth=false;
  }
  if(!$thepage->noauth){
  $page_name=$thepage->id;

  $newkondisiglobal=std_condition();
  $newkondisiglobal->check_condition=$manifest->auth_checking->allow;
  $newkondisiglobal->else=$manifest->auth_checking->onfailed;
  $newkondisiglobal->ontrue->process=$thepage->process;
  $newkondisiglobal->withisset=true;

for($a=0; $a<count($manifest->auth);$a++){
  if($manifest->auth[$a]->moduls==$controller_name){

    for($ap=0; $ap<count($manifest->auth[$a]->pages);$ap++){
      if($manifest->auth[$a]->pages[$ap]==$page_name){
        //echo "Dapet pagename";
        $newkondisi=std_condition();
        $newkondisi->check_condition=$manifest->auth[$a]->allow;
        $newkondisi->else=$manifest->auth_checking->onfailed;
        $newkondisi->ontrue->process=$thepage->process;
        $newkondisiglobal->ontrue->process=array();
        $newkondisiglobal->ontrue->process[]=$newkondisi;
        break;
      }
    }

  }

}


        $std_crafted=std_crafted();
        $std_crafted->type="crafted";
        $std_crafted->model_name="model_controller_auth_config";
        $std_crafted->func_name="register_auth";
        $std_crafted->outputVariable=$manifest->auth_checking->outputVariable;
        $std_crafted->model_use_location="App\global_model\model_controller_auth_config";

        $varkosong=std_variable();
        $varkosong->var_name="\"\"";
        $varkosong->var_type="hardcode";

        $std_crafted->param[]=$varkosong;

        $vars=std_variable();
        $vars->var_name="variables";
        $std_crafted->param[]=$vars;

$thepage->process=array();
$thepage->process[]=$std_crafted;
$thepage->process[]=$newkondisiglobal;

}
}
}
$thejson=$manifest;

require_once("thephp/auth/auth_config.php");
$thejson->moduls[]=modul_auth_config($thejson);
//$thejson->auth[]=auth_modul_supplier();

//echo "TYPENYA : ".var_dump($thejson);
 ?>
