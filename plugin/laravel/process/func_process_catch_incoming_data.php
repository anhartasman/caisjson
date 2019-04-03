<?php
function func_process_catch_incoming_data($engine,$pro,$action){
  $objreturn=new \stdClass();
  $content="";
  $varjsawal="";
  $include=array();
  $deklarasi=array();
  $varphpawal=array();
  $ar_worktodo=array();
  $properties_modul=$pro->properties_modul;
  $properties_page=$pro->properties_page;
  $controller_nickname="controller_".$properties_modul;
  $page_nickname="page_".$properties_page;
  $page_name_controller=$page_nickname.$controller_nickname;
  $work_id="";
  //------------------------
  //tempat skrip
  if(!isset($engine->catch_by)){
    $engine->catch_by="get";
  }

  if(!isset($engine->catch_variable)){
    $engine->catch_variable=$engine->catch;
  }

  $bahandeklarasi='$'.$engine->catch_variable.'=null;';
  $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_variabel_".$engine->catch_variable."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");


  switch($engine->catch_by){
    case "get":
    $content='$'.$engine->catch_variable.'=$_GET["'.$engine->catch.'"];'."\n";
    break;
    case "post":
    $content='$'.$engine->catch_variable.'=$_POST["'.$engine->catch.'"];'."\n";
    break;
  }
  //------------------
  //balikan
  $objreturn->content=$content;
  $objreturn->varjsawal=$varjsawal;
  $objreturn->deklarasi=$deklarasi;
  $objreturn->varphpawal=$varphpawal;
  $objreturn->include=$include;
  $objreturn->ar_worktodo=$ar_worktodo;
  //echo "kerja nyata ".count($objreturn->ar_worktodo)."<BR>";
  //akhir render_engine
  return $objreturn;

}
?>
