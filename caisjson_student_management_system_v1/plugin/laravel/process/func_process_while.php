<?php
function func_process_while($engine,$pro,$action){
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

  $objchecksession=new \stdClass();
  $objchecksession->type="group";
  $objchecksession->operator="and";
  $objchecksession->content=$engine->check_condition;
  $thegroup=create_booleancheck_web($objchecksession);
  $content.="while (".$thegroup->comparing_content."){"."\n";


      if(isset($engine->onloop)){

        if(isset($engine->onloop->process)){
          for($w=0; $w<count($engine->onloop->process);$w++){
            $engine->onloop->process[$w]->dalamgenggaman=true;
          }
          $grupengine=render_grup_engine($engine->onloop);
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
