<?php
function func_process_crafted($engine,$pro,$action){
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
  $table_action=$engine;
  $model_name=$table_action->model_name;
  $textinclude='use '.$table_action->model_use_location.';'."\n";
  $include[]=$textinclude;

    $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_crafted_".$model_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>'$'.$model_name.' = null; '."\n");

    $content.="\n";

    $model_func_name=$table_action->func_name;

    if($table_action!=null){
      $isiparam="";
      $arparam=array();
      if(isset($pro->param)){
        for($pa=0; $pa<count($pro->param); $pa++){
          if(!isset($pro->param[$pa]->var_type)){
            $pro->param[$pa]->var_type="variable";
          }
          if(!isset($pro->param[$pa]->variable_type)){
            $isiparam.=create_variable_web($pro->param[$pa]);
          }else{
            $isiparam.=$pro->param[$pa];
          }
          if(!isset($table_action->param[$pa]->name)){
            //echo "VIDA!! ".$model_name." ".count($pro->param)." ";
            //  var_dump($table_action->param[$pa]);
            if(isset($table_action->param[$pa]->var_name)){
              $table_action->param[$pa]->name=get_variable_name($pro->param[$pa]);
            }
          }
          $arparam[]="$".$table_action->param[$pa]->name;
          if($pa+1<count($pro->param)){
            $isiparam.=",";
          }
        }
      }

      $deklarasi[]='$'.$model_name." = new ".$model_name."();\n";
      $deklarasi[]='$'.$model_name.'->variables=$variables;'."\n";
      $deklarasi[]="\n";

      $bahandeklarasi="";
      $bahandeklarasi.='$'.$model_name." = new ".$model_name."();\n";
      $bahandeklarasi.='$'.$model_name.'->variables=$variables;'."\n";
      $bahandeklarasi.="\n";
      $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_craftedcaller_".$model_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");
      $ar_worktodo[]=array("type"=>"add_declaration_to_function","fortop"=>"untukatas","ignore"=>true,"work_id"=>"deklarasi_craftedcallers_".$model_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_","content"=>$bahandeklarasi."\n");
      $ar_worktodo[]=array("type"=>"addinclude","work_id"=>"include_".$model_name."_to_".$controller_nickname,"file_id"=>$controller_nickname,"include_id"=>"crafted_".$model_name."_in_".$controller_nickname,"content"=>$textinclude);
      $ar_worktodo[]=array("type"=>"addinclude","ignore"=>true,"fortop"=>"fileatas","namatabel"=>$model_name,"work_id"=>"","file_id"=>"tabel_".$model_name,"include_id"=>"crafted_".$model_name."_in_".$controller_nickname,"content"=>$textinclude);
      //echo "deklarasi "."deklarasi_tabelcaller_".$model_name."_in_".$page_nickname.$controller_nickname."<BR>";
      $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_outputcraftedcaller_".$table_action->outputVariable."_".$model_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>'$'.$table_action->outputVariable.' = null;'."\n");
      $calldbfunction='$'.$table_action->outputVariable.' = $'.$model_name.'->'.$model_func_name;
      $calldbfunction.="($isiparam);\n";
      $calldbfunction.="\n";
      $content.=$calldbfunction;
      $content.='$variables[\''.$table_action->outputVariable.'\'] = $'.$table_action->outputVariable.";"."\n";

      $dafVariable[]=$table_action->outputVariable;
    }
    /**
    $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_".$model_func_name,"function_id"=>"function_".$model_func_name,"function_name"=>$model_func_name,"param"=>$arparam,"file_id"=>"tabel_".$model_name);
    $bahandeklarasifunctiontabel='$variables=$this->variables;'."\n";
    $bahandeklarasifunctiontabel.='extract($variables);'."\n";
    $bahandeklarasifunctiontabel.='$'.$table_action->outputVariable.' = null;'."\n";

    $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_outputcraftedcaller_".$table_action->outputVariable."_".$model_name."_in_".$page_nickname.$controller_nickname."_function_".$model_func_name,"function_id"=>"function_".$model_func_name,"content"=>$bahandeklarasifunctiontabel."\n");
    $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_table_process_".$model_name."_withoutput_".$table_action->outputVariable."_to_function_".$model_func_name,"function_id"=>"function_".$model_func_name,"content"=>$objproses->content."\n");
    $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"deklarasipreparefooter_themodelof_".$model_func_name,"function_id"=>"function_".$model_func_name,"content"=>'return $'.$table_action->outputVariable.';'."\n");
**/
    //$objproses=create_database_proses($theapi->table,$model_name);

    //  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"use_table_".$model_name."_withoutput_".$table_action->outputVariable."_to_function_".$properties_page."_in_".$properties_modul,"function_id"=>"function_".$page_name_controller,"content"=>$content."\n");
    //echo "banyak ".$ar_worktodo[count($ar_worktodo)-1]["work_id"];
    //akhir caller


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
