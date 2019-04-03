<?php
function func_process_thetime($engine,$pro,$action){
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

  $varphpawal[]='$'.$engine->variable.' = null; '."\n";

  $bahandeklarasi="";
  $bahandeklarasi.='$'.$engine->variable.' = null; '."\n";
  $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_variabel_".$engine->variable."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");

  //$timezone="Asia/Bangkok";
  //$content.='date_default_timezone_set(\"'.$timezone.'\");'."\n";
  $content.='$'.$engine->variable." = date(\"".$engine->format."\");\n";
  $content.='$'.$engine->variable." = date_create_from_format(\"".$engine->format."\",$".$engine->variable.");\n";
  if(isset($engine->create_interval)){
    $content.='$'.$engine->variable.' = date_'.$engine->create_interval->operator."($".$engine->variable.",date_interval_create_from_date_string(\"".$engine->create_interval->interval."\"))->format(\"".$engine->format."\");\n";
  }
  $content.='$variables[\''.$engine->variable.'\'] = $'.$engine->variable.";"."\n";

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
