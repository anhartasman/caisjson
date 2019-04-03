<?php
function func_process_string_href($engine,$pro,$action){
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

  if(!isset($engine->strings)){
    $engine->strings=array();
  }

  if(!isset($engine->divider)){
    $engine->divider="";
  }

  $bahandeklarasi="";
  $bahandeklarasi.='$'.$engine->outputVariable.' = null;';
  $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_uniqcode_".$engine->outputVariable."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");

    $bahanvarhref=create_variable_web($engine->href);

      $bahanvarlabel=create_variable_web($engine->label);

  $content.='$'.$engine->outputVariable.' = ';
  $isihref='"'.'<a href=\"".'.$bahanvarhref.'."\">".'.$bahanvarlabel.'."</a>"';

  $content.=$isihref.';'."\n";

    $content.='$variables[\''.$engine->outputVariable.'\'] = '.$isihref.';'."\n";

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
