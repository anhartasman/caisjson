<?php
function func_process_set_variable($engine,$pro,$action){
    //$backtrace = debug_backtrace();

    //print_r( $backtrace  );
    //echo "<BR>";
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

  $varphpawal[]=create_variable_web($engine->var).' = null; '."\n";
  $kasihequal=true;
  if(isset($engine->equal->var_type)){
    if($engine->equal->var_type=="hardcode"){
      $kasihequal=false;
    }
  }
  if($kasihequal){
    $varphpawal[]=create_variable_web($engine->equal).' = null; '."\n";
  }

  $bahandeklarasivar="";
  $bahandeklarasiequal="";
  $bahandeklarasivar=create_variable_web($engine->var).' = null; '."\n";

  if($kasihequal){
  $bahandeklarasiequal=create_variable_web($engine->equal).' = null; '."\n";
  }

  $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_variabel_".get_variable_name($engine->var)."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasivar."\n");
  $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_variabel_".get_variable_name($engine->equal)."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasiequal."\n");

  $varvar=create_variable_web($engine->var);
  $varequal=create_variable_web($engine->equal);
  $clossing="";
  if(isset($engine->clossing)){
    $clossing=$engine->clossing;
  }
  $content.=$varvar." = ".$clossing.$varequal.$clossing."; \n";

  $objreturn->content=$content;
  $objreturn->varjsawal=$varjsawal;
  $objreturn->deklarasi=$deklarasi;
  $objreturn->varphpawal=$varphpawal;
  $objreturn->include=$include;
  $objreturn->ar_worktodo=$ar_worktodo;
  //echo "kerja nyata ".count($objreturn->ar_worktodo)."<BR>";
  //akhir render_engine
  //echo "tes";
  return $objreturn;

}
?>
