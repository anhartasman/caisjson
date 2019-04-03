<?php
function func_process_json_to_array($engine,$pro,$action){
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
  $theconverter=$pro;
  $content.='$'.$theconverter->variable.'=array();'."\n";
  $content.='foreach($'.$theconverter->from.' as $key) {'."\n";
    $content.='$'.$theconverter->variable.'[$key[\''.$theconverter->index.'\']]=$key[\''.$theconverter->value.'\'];'."\n";
    $content.='}'."\n";
    $content.='$variables[\''.$theconverter->variable.'\'] = $'.$theconverter->variable.";"."\n";

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
