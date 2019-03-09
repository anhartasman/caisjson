<?php
function func_process_session($engine,$pro,$action){
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
  if(isset($engine->set_session)){
    for ($s=0; $s<count($engine->set_session); $s++){
      if(!isset($engine->set_session[$s]->value->var_type)){
        $engine->set_session[$s]->value->var_type="variable";
      }
      $content.='$_SESSION[\''.$engine->set_session[$s]->session.'\'] = '.create_variable_web($engine->set_session[$s]->value).';'."\n";
    }
  }

  if(isset($engine->destroy_session) && $engine->destroy_session==true){

    $content.='if ( isset( $_COOKIE[session_name()] ) ){'."\n";
      $content.='setcookie( session_name(), “”, time()-3600, “/” );'."\n";
      $content.='//clear session from globals'."\n";
      $content.='$_SESSION = array();'."\n";
      $content.='//clear session from disk'."\n";
      $content.=' session_destroy();'."\n";
      $content.='}'."\n";

    }

    //terusin. check session diganti ke cek variabel biasa
    if(isset($engine->check_session) && count($engine->check_session)>0){

      $objchecksession=new \stdClass();
      $objchecksession->type="group";
      $objchecksession->operator="and";
      $objchecksession->content=$engine->check_session;
      $thegroup=create_booleancheck_web($objchecksession);
      $content.="if (".$thegroup->comparing_content."){"."\n";
        if(isset($engine->ontrue)){

          if(isset($engine->ontrue->process)){
            for($w=0; $w<count($engine->ontrue->process);$w++){
              $engine->ontrue->process[$w]->dalamgenggaman=true;
            }
            $grupengine=render_grup_engine($engine->ontrue);
            $varjsawal.=$grupengine->varjsawal;
            $ar_worktodo=array_merge($ar_worktodo,$grupengine->ar_worktodo);
            $content.=$grupengine->content;
            $current_function="function_page_".$engine->properties_page."controller_".$engine->properties_modul;
            //    echo $current_function."<BR>";
            for($w=0; $w<count($ar_worktodo);$w++){
              if($ar_worktodo[$w]["type"]=="add_to_function" && $ar_worktodo[$w]["function_id"]==$current_function){
                //echo "cancel ".$ar_worktodo[$w]["function_id"]."<BR>";
                $ar_worktodo[]=array("type"=>"cancelwork","work_id"=>"cancelwork".$ar_worktodo[$w]["work_id"],"cancel_work_id"=>$ar_worktodo[$w]["work_id"]);
              }
            }

          }
        }
        $content.='}'."\n";
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
