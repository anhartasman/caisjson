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
  $namespace="App\MVC_MODEL";
  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile_tabel_".$table_name,"file_id"=>"tabel_".$table_name,"location"=>create_text_model_file_location("model_tabel_".$table_name),"content_from"=>"file","autopath_targetitem"=>true,"content"=>"file_template/language_php_template_class.php","replaces"=>array(array("search"=>"{namespace}","replace"=>$namespace)));
  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile_entity_tabel_".$table_name,"file_id"=>"entity_tabel_".$table_name,"location"=>create_text_model_file_location("model_entity_tabel_".$table_name),"content_from"=>"file","autopath_targetitem"=>true,"content"=>"file_template/language_php_template_class.php","replaces"=>array(array("search"=>"{namespace}","replace"=>$namespace)));
  $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_getlastid".$table_name,"function_id"=>"function_getlastid".$table_name,"function_name"=>"getLastId","param"=>[],"file_id"=>"tabel_".$table_name);
  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_function_getlastid".$table_name."_content","function_id"=>"function_getlastid".$table_name,"content"=>'$the_id=0;if(isset($this->last_id)){$the_id=$this->last_id;} return $the_id;'."\n");
  $ar_worktodo[]=array("type"=>"addinclude","work_id"=>"include_entity_".$table_name."_factory_to_".$table_name,"file_id"=>"tabel_".$table_name,"include_id"=>"entity_".$table_name."_factory_in_".$table_name,"content"=>create_text_include_model("model_entity_factory_tabel_".$table_name));

  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile_entityfactory_tabel_".$table_name,"file_id"=>"entity_factory_tabel_".$table_name,"location"=>create_text_model_file_location("model_entity_factory_tabel_".$table_name),"content_from"=>"file","autopath_targetitem"=>true,"content"=>"file_template/language_php_template_class.php","replaces"=>array(array("search"=>"{namespace}","replace"=>$namespace)));
  $ar_worktodo[]=array("type"=>"addinclude","work_id"=>"include_".$table_name."_to_entityfactory_tabel_".$table_name,"file_id"=>"entity_factory_tabel_".$table_name,"include_id"=>$table_name."_in_entityfactory_tabel_".$table_name,"content"=>create_text_include_model("model_entity_tabel_".$table_name));
  $ar_worktodo[]=array("type"=>"addinclude","work_id"=>"include_portdatabase_to_entityfactory_tabel_".$table_name,"file_id"=>"entity_factory_tabel_".$table_name,"include_id"=>"portdatabase_in_entityfactory_tabel_","content"=>create_text_include_model("model_port_database"));
  $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_getarrayarray_from_factory_of_entity_".$table_name,"function_id"=>"getarrayarray_from_factory_of_entity_".$table_name,"function_name"=>"getArrayArray","param"=>['$selectarray'.$table_name,'$wherearray'.$table_name],"file_id"=>"entity_factory_tabel_".$table_name);
  $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_getsinglearray_from_factory_of_entity_".$table_name,"function_id"=>"getsinglearray_from_factory_of_entity_".$table_name,"function_name"=>"getSingleArray","param"=>['$selectarray'.$table_name,'$wherearray'.$table_name],"file_id"=>"entity_factory_tabel_".$table_name);
  $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_insertdata_to_factory_of_entity_".$table_name,"function_id"=>"insertdata_to_factory_of_entity_".$table_name,"function_name"=>"insert_data","param"=>['$insertArray'.$table_name],"file_id"=>"entity_factory_tabel_".$table_name);
  $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_deletedata_to_factory_of_entity_".$table_name,"function_id"=>"deletedata_to_factory_of_entity_".$table_name,"function_name"=>"delete_data","param"=>['$deleteArray'.$table_name],"file_id"=>"entity_factory_tabel_".$table_name);
  $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_updatedata_to_factory_of_entity_".$table_name,"function_id"=>"updatedata_to_factory_of_entity_".$table_name,"function_name"=>"update_data","param"=>['$updateArray'.$table_name,'$whereArray'.$table_name],"file_id"=>"entity_factory_tabel_".$table_name);



  $bahandeklarasi="";
  $bahandeklarasi.='$obj_port_database = new model_port_database();'."\n";
  //$bahandeklarasi.='$obj_port_database->variables=$variables;'."\n";
  $bahandeklarasi.="\n";
  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_to_function_"."getarrayarray_from_factory_of_entity_".$table_name,"function_id"=>"getarrayarray_from_factory_of_entity_".$table_name,"content"=>$bahandeklarasi);
  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_to_function_"."getsinglearray_from_factory_of_entity_".$table_name,"function_id"=>"getsinglearray_from_factory_of_entity_".$table_name,"content"=>$bahandeklarasi);
  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_to_function_"."insertdata_to_factory_of_entity_".$table_name,"function_id"=>"insertdata_to_factory_of_entity_".$table_name,"content"=>$bahandeklarasi);
  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_to_function_"."deletedata_to_factory_of_entity_".$table_name,"function_id"=>"deletedata_to_factory_of_entity_".$table_name,"content"=>$bahandeklarasi);
  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_to_function_"."updatedata_to_factory_of_entity_".$table_name,"function_id"=>"updatedata_to_factory_of_entity_".$table_name,"content"=>$bahandeklarasi);

  $bahandeklarasi="";
  $bahandeklarasi.='$result_for_getArray = $obj_port_database->selectMany("'.$table_name.'",$selectarray'.$table_name.',$wherearray'.$table_name.');'."\n";
  $bahandeklarasi.='$result_for_getArray = array_map(function($object){return (array) $object;}, $result_for_getArray);'."\n";
  $bahandeklarasi.="\n";
  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_useportdatabase_to_function_"."getarrayarray_from_factory_of_entity_".$table_name,"function_id"=>"getarrayarray_from_factory_of_entity_".$table_name,"content"=>$bahandeklarasi);

  $bahandeklarasi="";
  $bahandeklarasi.='$result_for_getArray = $obj_port_database->selectSingle("'.$table_name.'",$selectarray'.$table_name.',$wherearray'.$table_name.');'."\n";
  $bahandeklarasi.='$result_for_getArray = (array) $result_for_getArray;'."\n";
  $bahandeklarasi.="\n";
  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_useportdatabase_to_function_"."getsinglearray_from_factory_of_entity_".$table_name,"function_id"=>"getsinglearray_from_factory_of_entity_".$table_name,"content"=>$bahandeklarasi);

  $bahandeklarasi="";
  $bahandeklarasi.='$result_for_insert = $obj_port_database->insert_data("'.$table_name.'",$insertArray'.$table_name.');'."\n";
  $bahandeklarasi.="\n";
  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_useportdatabase_to_function_"."insertdata_to_factory_of_entity_".$table_name,"function_id"=>"insertdata_to_factory_of_entity_".$table_name,"content"=>$bahandeklarasi);

  $bahandeklarasi="";
  $bahandeklarasi.='$result_for_delete = $obj_port_database->delete_data("'.$table_name.'",$deleteArray'.$table_name.');'."\n";
  $bahandeklarasi.="\n";
  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_useportdatabase_to_function_"."deletedata_to_factory_of_entity_".$table_name,"function_id"=>"deletedata_to_factory_of_entity_".$table_name,"content"=>$bahandeklarasi);

  $bahandeklarasi="";
  $bahandeklarasi.='$result_for_update = $obj_port_database->update_data("'.$table_name.'",$updateArray'.$table_name.',$whereArray'.$table_name.');'."\n";
  $bahandeklarasi.="\n";
  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_useportdatabase_to_function_"."updatedata_to_factory_of_entity_".$table_name,"function_id"=>"updatedata_to_factory_of_entity_".$table_name,"content"=>$bahandeklarasi);


  $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"return_useportdatabase_to_function_"."getarrayarray_from_factory_of_entity_".$table_name,"function_id"=>"getarrayarray_from_factory_of_entity_".$table_name,"content"=>'return $result_for_getArray;'."\n");
  $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"return_useportdatabase_to_function_"."getsinglearray_from_factory_of_entity_".$table_name,"function_id"=>"getsinglearray_from_factory_of_entity_".$table_name,"content"=>'return $result_for_getArray;'."\n");
  $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"return_useportdatabase_to_function_"."insertdata_to_factory_of_entity_".$table_name,"function_id"=>"insertdata_to_factory_of_entity_".$table_name,"content"=>'return $result_for_insert;'."\n");
  $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"return_useportdatabase_to_function_"."deletedata_to_factory_of_entity_".$table_name,"function_id"=>"deletedata_to_factory_of_entity_".$table_name,"content"=>'return $result_for_delete;'."\n");
  $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"return_useportdatabase_to_function_"."updatedata_to_factory_of_entity_".$table_name,"function_id"=>"updatedata_to_factory_of_entity_".$table_name,"content"=>'return $result_for_update;'."\n");

  $dafprop=array();
  if($table_action->process_name=="insert" || $table_action->process_name=="update"){

      for($v=0; $v<count($table_action->array_data);$v++){
        $dafprop[]=$table_action->array_data[$v]->index;
      }

  }

  for($v=0; $v<count($dafprop);$v++){
    $function_id_baru="get".$dafprop[$v]."ofTable".$table_name;
    $function_id_setbaru="set".$dafprop[$v]."ofTable".$table_name;
    $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_".$function_id_baru,"function_id"=>"function_".$function_id_baru,"function_name"=>"get".$dafprop[$v],"param"=>[],"file_id"=>"entity_tabel_".$table_name);
    $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_getthis_to_function_".$function_id_baru,"function_id"=>"function_".$function_id_baru,"content"=>'return $this->'.$dafprop[$v].';'."\n");

    $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_".$function_id_setbaru,"function_id"=>"function_".$function_id_setbaru,"function_name"=>"set".$dafprop[$v],"param"=>['$'.$dafprop[$v]],"file_id"=>"entity_tabel_".$table_name);
    $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_setthis_to_function_".$function_id_setbaru,"function_id"=>"function_".$function_id_setbaru,"content"=>'$this->'.$dafprop[$v].'=$'.$dafprop[$v].';'."\n");
  }

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
      $deklarasi[]='$obj_table_'.$table_name.'->variables=$variables;'."\n";
      $deklarasi[]="\n";

      $bahandeklarasi="";
      $bahandeklarasi.='$obj_table_'.$table_name." = new model_tabel_".$table_name."();\n";
      $bahandeklarasi.='$obj_table_'.$table_name.'->variables=$variables;'."\n";
      $bahandeklarasi.="\n";

      $bahandeklarasifactory="";
      $bahandeklarasifactory.='$obj_entity_factory_tabel_'.$table_name." = new model_entity_factory_tabel_".$table_name."();\n";
      $bahandeklarasifactory.='$obj_entity_factory_tabel_'.$table_name.'->variables=$variables;'."\n";
      $bahandeklarasifactory.="\n";

      $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_tabelcaller_".$table_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");
      $ar_worktodo[]=array("type"=>"add_declaration_to_function","fortop"=>"untukatas","ignore"=>true,"work_id"=>"deklarasi_tabelcallers_".$table_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_","content"=>$bahandeklarasi."\n");
      $ar_worktodo[]=array("type"=>"addinclude","work_id"=>"include_".$table_name."_to_".$controller_nickname,"file_id"=>$controller_nickname,"include_id"=>$table_name."_in_".$controller_nickname,"content"=>create_text_include_model("model_tabel_".$table_name));
      $ar_worktodo[]=array("type"=>"addinclude","ignore"=>true,"fortop"=>"fileatas","namatabel"=>$table_name,"work_id"=>"","file_id"=>"tabel_".$table_name,"include_id"=>$table_name."_in_".$controller_nickname,"content"=>create_text_include_model("model_tabel_".$table_name));
      //echo "deklarasi "."deklarasi_tabelcaller_".$table_name."_in_".$page_nickname.$controller_nickname."<BR>";
      $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_outputtabelcaller_".$table_action->outputVariable."_".$table_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>'$'.$table_action->outputVariable.' = null;'."\n");
      $calldbfunction='$'.$table_action->outputVariable.' = $obj_table_'.$table_name.'->'.$model_func_name;
      $calldbfunction.="($isiparam);\n";
      $calldbfunction.="\n";
      $content.=$calldbfunction;
      if(isset($table_action->process_name)){
      if($table_action->process_name=="insert"){
        $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_last_id_".$table_action->outputVariable."_".$table_name."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>'$'.$table_action->outputVariable.'_last_id = null;'."\n");
        $content.='$'.$table_action->outputVariable.'_last_id = $obj_table_'.$table_name.'->getLastId();'."\n";
      }
      }
      $content.='$variables[\''.$table_action->outputVariable.'\'] = $'.$table_action->outputVariable.";"."\n";

      $dafVariable[]=$table_action->outputVariable;
    }
    $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_".$model_func_name,"function_id"=>"function_".$model_func_name,"function_name"=>$model_func_name,"param"=>$arparam,"file_id"=>"tabel_".$table_name);
    $bahandeklarasifunctiontabel='$variables=$this->variables;'."\n";
    $bahandeklarasifunctiontabel.='extract($variables);'."\n";
    $bahandeklarasifunctiontabel.='$'.$table_action->outputVariable.' = null;'."\n";
    if(isset($table_action->process_name)){
    if($table_action->process_name=="insert"){
    $bahandeklarasifunctiontabel.='$'.$table_action->outputVariable.'_last_id = null;'."\n";
    }
    }
    $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_outputtabelcaller_".$table_action->outputVariable."_".$table_name."_in_".$page_nickname.$controller_nickname."_function_".$model_func_name,"function_id"=>"function_".$model_func_name,"content"=>$bahandeklarasifunctiontabel."\n");
    $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_tabel_factory_".$table_action->table_name."_in_".$model_func_name,"function_id"=>"function_".$model_func_name,"content"=>$bahandeklarasifactory."\n");
    $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"add_table_process_".$table_name."_withoutput_".$table_action->outputVariable."_to_function_".$model_func_name,"function_id"=>"function_".$model_func_name,"content"=>$objproses->content."\n");
    $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"deklarasipreparefooter_themodelof_".$model_func_name,"function_id"=>"function_".$model_func_name,"content"=>'return $'.$table_action->outputVariable.';'."\n");
    //$objproses=create_database_proses($theapi->table,$table_name);

    //  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"use_table_".$table_name."_withoutput_".$table_action->outputVariable."_to_function_".$properties_page."_in_".$properties_modul,"function_id"=>"function_".$page_name_controller,"content"=>$content."\n");
    //echo "banyak ".$ar_worktodo[count($ar_worktodo)-1]["work_id"];
    //akhir caller
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
