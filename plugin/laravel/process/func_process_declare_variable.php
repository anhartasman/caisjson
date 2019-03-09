<?php
function func_process_declare_variable($engine,$pro,$action){
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

  $varphpawal[]=create_variable_web($engine->body).' = null; '."\n";

  $bahandeklarasi="";
  $bahandeklarasi.=create_variable_web($engine->body).' = null; '."\n";
  $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_variabel_".get_variable_name($engine->body)."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");

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
