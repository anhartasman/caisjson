<?php

function modul_supplier(){
  $themodul = std_modul();
  $themodul->id="supplier";
  $themodul->title="Supplier";
  $themodul->subtitle="";
  $themodul->ignore=false;
  $themodul->placement[]=std_place_sidemenu();

  require_once("thephp/supplier/daftar_supplier.php");
  $themodul->page[]=modul_supplier_page_daftar_supplier();

  return $themodul;
}

function auth_modul_supplier(){
  $themodul = std_auth();
  $themodul->moduls="supplier";
  $themodul->pages[]="daftar_supplier";


      $std_auth=new \stdClass();
      $std_auth->check=std_variable();
      $std_auth->check->var_name="status_laporan";
      $std_auth->operator="!=";
      $std_auth->value=std_variable();
      $std_auth->value->var_type="hardcode";
      $std_auth->value->var_name="null";
  $themodul->allow[]=$std_auth;

  return $themodul;
}

 ?>
