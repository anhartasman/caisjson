<?php
function func_process_generate_unique_code($engine,$pro,$action){
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
  if(!isset($engine->withautonumber)){
    $engine->withautonumber=true;
  }
  if(!isset($engine->names)){
    $engine->names=array();
  }
  if(!isset($engine->minnumber)){
    $engine->minnumber=1;
  }
  if(!isset($engine->maxnumber)){
    $engine->maxnumber=1000000;
  }

  $bahandeklarasi="";
  $bahandeklarasi.='$'.$engine->outputVariable.' = null;';
  $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_uniqcode_".$engine->outputVariable."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");

  $content.='$acak'.$engine->outputVariable.' = rand('.$engine->minnumber.','.$engine->maxnumber.');'."\n";
  $content.='$'.$engine->outputVariable.' = ';
  for($i=0; $i<count($engine->names);$i++){
    $bahanvar=create_variable_web($engine->names[$i]);
    $content.=$bahanvar;
    if(($i+1)<count($engine->names)){
      $content.='."'.$engine->divider.'".';
    }
  }
  if($engine->withautonumber){
    $content.='."'.$engine->divider.'".$acak'.$engine->outputVariable.';'."\n";
  }
  //------------------
  //balikan
  //$content.="HAHAH";
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
