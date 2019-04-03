<?php
function func_process_table($engine,$pro,$action){
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
  $table_name=$table_action->table_name;
  $include[]=create_text_include_model('model_tabel_'.$table_name);
  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile_tabel_".$table_name,"file_id"=>"tabel_".$table_name,"location"=>create_text_model_file_location("model_tabel_".$table_name),"content_from"=>"file","content"=>"file_template/language_php_template_class.php");
  if(!isset($engine->need)){
    $engine->need="caller";
  }
  // echo $engine->need;
  $objproses=create_database_proses($table_action,$table_action->table_name);
  for($v=0; $v<count($objproses->varphpawal);$v++){
    $varphpawal[]=$objproses->varphpawal[$v];
  }
  if($engine->need=="content"){

    $content.=$objproses->content;
  }else if($engine->need=="caller"){
    $varphpawal[]='$obj_table_'.$table_name.' = null; '."\n";
    $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_obj_table_".$table_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>'$obj_table_'.$table_name.' = null; '."\n");

    $content.="\n";
    //echo $table_action->table_name->properties_modul."\n";
    if(!isset($table_action->func_name)){
      $aaa=get_fungsi_name_new($table_action->properties_modul,$table_action->properties_page,"table",$table_action,"");
      $table_action->func_name=$aaa->function_name;
    }

    $model_func_name="";
    $model_func_name=$table_action->func_name;
    //echo $model_func_name;

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
            //echo "VIDA!! ".$table_name." ".count($pro->param)." ";
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

      $deklarasi[]='$obj_table_'.$table_name." = new model_tabel_".$table_name."();\n";
      $deklarasi[]='$obj_table_'.$table_name.'->db=$this->db;'."\n";
      $deklarasi[]='$obj_table_'.$table_name.'->variables=$variables;'."\n";
      $deklarasi[]="\n";

      $bahandeklarasi="";
      $bahandeklarasi.='$obj_table_'.$table_name." = new model_tabel_".$table_name."();\n";
      $bahandeklarasi.='$obj_table_'.$table_name.'->db=$this->db;'."\n";
      $bahandeklarasi.='$obj_table_'.$table_name.'->variables=$variables;'."\n";
      $bahandeklarasi.="\n";
      $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_tabelcaller_".$table_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");
      $ar_worktodo[]=array("type"=>"add_declaration_to_function","fortop"=>"untukatas","ignore"=>true,"work_id"=>"deklarasi_tabelcallers_".$table_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_","content"=>$bahandeklarasi."\n");
      $ar_worktodo[]=array("type"=>"addinclude","work_id"=>"include_".$table_name."_to_".$controller_nickname,"file_id"=>$controller_nickname,"include_id"=>$table_name."_in_".$controller_nickname,"content"=>create_text_include_model("model_tabel_".$table_name));
      $ar_worktodo[]=array("type"=>"addinclude","ignore"=>true,"fortop"=>"fileatas","namatabel"=>$table_name,"work_id"=>"","file_id"=>"tabel_".$table_name,"include_id"=>$table_name."_in_".$controller_nickname,"content"=>create_text_include_model("model_tabel_".$table_name));
      //echo "deklarasi "."deklarasi_tabelcaller_".$table_name."_in_".$page_nickname.$controller_nickname."<BR>";
      $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_outputtabelcaller_".$table_action->outputVariable."_".$table_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>'$'.$table_action->outputVariable.' = null;'."\n");
      $content.='$'.$table_action->outputVariable.' = $obj_table_'.$table_name.'->'.$model_func_name;
      $content.="($isiparam);\n";
      $content.="\n";
      $content.='$variables[\''.$table_action->outputVariable.'\'] = $'.$table_action->outputVariable.";"."\n";

      $dafVariable[]=$table_action->outputVariable;
    }
    $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_".$model_func_name,"function_id"=>"function_".$model_func_name,"function_name"=>$model_func_name,"param"=>$arparam,"file_id"=>"tabel_".$table_name);
    $bahandeklarasifunctiontabel='$variables=$this->variables;'."\n";
    $bahandeklarasifunctiontabel.='$db=$this->db;'."\n";
    $bahandeklarasifunctiontabel.='extract($variables);'."\n";
    $bahandeklarasifunctiontabel.='$'.$table_action->outputVariable.' = null;'."\n";
    $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_outputtabelcaller_".$table_action->outputVariable."_".$table_name."_in_".$page_nickname.$controller_nickname."_function_".$model_func_name,"function_id"=>"function_".$model_func_name,"content"=>$bahandeklarasifunctiontabel."\n");
    $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_table_process_".$table_name."_withoutput_".$table_action->outputVariable."_to_function_".$model_func_name,"function_id"=>"function_".$model_func_name,"content"=>$objproses->content."\n");
    $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"deklarasipreparefooter_themodelof_".$model_func_name,"function_id"=>"function_".$model_func_name,"content"=>'return $'.$table_action->outputVariable.';'."\n");

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
