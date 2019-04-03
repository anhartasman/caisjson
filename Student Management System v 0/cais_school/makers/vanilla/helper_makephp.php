<?php
function formatrupiah($data)
{
  $cekanya=number_format($data,0,',','.');
  return $cekanya;
}
function create_web_loop($param){
  $content="for (".$param."){"."\n";
    $content.="{content}"."\n";
    $content.="}"."\n";

    return $content;
  }

  function create_web_variable($var_data){
    $var_name='$'.$var_data->name;
    $content=$var_name.'=';
    switch($var_data->type){
      case "array":
      $content.='array();'."\n";
      for($c=0; $c<count($var_data->content); $c++){
        $content.=$var_name.'[\''.$var_data->content[$c]->index.'\']="'.$var_data->content[$c]->value.'";'."\n";

      }

      break;
    }
    return $content;
  }

  function create_database_proses($table,$table_name){

    $objreturn=new \stdClass();
    $content="";
    $content.='$data'.$table->outputVariable.'=array();'."\n";
    $varphpawal=array();
    $varphpawal[]='$'.$table->outputVariable.';'."\n";
    switch($table->process_name){
      case "insert":
      foreach($table->array_data as $a) {
        if(!isset($a->value->var_type)){
          $a->value->var_type="variable";
        }
        $content.='$data'.$table->outputVariable.'[\''.$a->index.'\']='.create_variable_web($a->value).';'."\n";
      }
      $content.='$result_for_'.$table->outputVariable.' = $db->from(\''.$table_name.'\')'."\n";

      break;
      case "update":
      foreach($table->array_data as $a) {
        if(!isset($a->value->var_type)){
          $a->value->var_type="variable";
        }
        $content.='$data'.$table->outputVariable.'[\''.$a->index.'\']='.create_variable_web($a->value).';'."\n";
      }
      $content.='$result_for_'.$table->outputVariable.' = $db->from(\''.$table_name.'\')'."\n";

      break;
      case "select":
      foreach($table->array_data as $a) {
        $content.='$data'.$table->outputVariable.'[]="'.$a.'";'."\n";
      }
      $content.='$result_for_'.$table->outputVariable.' = $db->from(\''.$table_name.'\')'."\n";
      if(isset($table->distinct)){
        if($table->distinct==true){
          $content.='->distinct()';
        }
      }
      break;
      case "delete":
      $content.='$result_for_'.$table->outputVariable.' = $db->from(\''.$table_name.'\')'."\n";

      break;
      case "bridge":
      //$content.='$databridgeright'.$table->outputVariable.'=array();'."\n";
      //$content.='$databridgeright'.$table->outputVariable.'[]="'.$table->right_table_id.'";'."\n";
      if(!isset($table->left_id)){
        if(!isset($table->left_id->var_type)){
          $table->left_id->var_type="variable";
        }
      }
      if(!isset($table->right_array)){
        if(!isset($table->right_array->var_type)){
          $table->right_array->var_type="variable";
        }
      }
      $content.='$result_for_'.$table->outputVariable.' = $db->from(\''.$table_name.'\')'."\n";
      $content.='-> where (\''.$table->left_bridge_column.' =\','.create_variable_web($table->left_id).')'."\n";
      $content.='->select(array("id","'.$table->left_bridge_column.'","'.$table->right_bridge_column.'"))'."\n";

      $content.='->many();'."\n";

      break;
    }


    switch($table->process_name){
      case "insert":
      $content.='->insert($data'.$table->outputVariable.')'."\n";
      $content.='->'.$table->execute.'();'."\n";
      break;
      case "update":
      if(isset($table->where)){

        for ($s=0; $s<count($table->where); $s++){
          $content.='-> where (\''.$table->where[$s]->index.' '.$table->where[$s]->operator.'\','.create_variable_web($table->where[$s]->value).')'."\n";

        }
      }
      $content.='->update($data'.$table->outputVariable.')'."\n";
      $content.='->'.$table->execute.'();'."\n";
      break;
      case "delete":
      if(isset($table->where)){

        for ($s=0; $s<count($table->where); $s++){
          $content.='-> where (\''.$table->where[$s]->index.' '.$table->where[$s]->operator.'\','.create_variable_web($table->where[$s]->value).')'."\n";

        }
      }
      $content.='->delete()'."\n";
      $content.='->'.$table->execute.'();'."\n";
      break;
      case "select":
      if(isset($table->join)){
        $bahanjoin='-> join (\''.$table->join->table.'\',array({isiarray}))'."\n";
        $isiarray="";
        for ($s=0; $s<count($table->join->where); $s++){
          $isiarray.='\''.$table->join->where[$s]->index.'\' => '.create_variable_web($table->join->where[$s]->value);
          if($s+1>count($table->join->where)){
            $isiarray.=",";
          }
        }
        $bahanjoin=str_replace("{isiarray}",$isiarray,$bahanjoin);
        $content.=$bahanjoin;
      }
      if(isset($table->where)){

        for ($s=0; $s<count($table->where); $s++){
          $content.='-> where (\''.$table->where[$s]->index.' '.$table->where[$s]->operator.'\','.create_variable_web($table->where[$s]->value).')'."\n";

        }
      }
      $content.='->select($data'.$table->outputVariable.')'."\n";
      $content.='->'.$table->execute.'();'."\n";
      break;
    }

    if(isset($table->output)){
      switch($table->execute){
        case "many":
        $bahan_output="";
        switch($table->output_generate){
          case "manual":
          $table->output=str_replace("\"","\\\"",$table->output);
          $bahan_output=$table->output;
          break;
          case "table_column":
          $isioutput="[";

          if(is_array($table->output)){
            for($io=0;$io<count($table->output);$io++){
              $theoutput=$table->output[$io];
              switch($theoutput->type){
                case "label":
                $isioutput.='\"'.$theoutput->label.'\"';
                break;
                case "link":
                $isioutput.='\"'."<a href='".$theoutput->href."'>".$theoutput->label."</a>".'\"';
                break;
              }
              if($io<count($table->output)-1){
                $isioutput.=",";
              }
            }
          }
          $isioutput.="]";
          $table->output=$isioutput;
          $bahan_output=$table->output;
          break;
        }
        $content.='$output_content'.$table->outputVariable.'="";'."\n";
        $content.='$num'.$table->outputVariable.'=0;'."\n";
        $content.='foreach($result_for_'.$table->outputVariable.' as $q'.$table->outputVariable.'){'."\n";
          $content.='$num'.$table->outputVariable.'+=1;'."\n";

          if(isset($table->bridge)){
            $objproses=create_database_proses($table->bridge,$table->bridge->table);

            $content.=$objproses->content;
            $content.='foreach($result_for_'.$table->outputVariable.' as $q'.$table->outputVariable.'){'."\n";
              $content.='}'."\n";
            }

            if(isset($table->process)){
              foreach($table->process as $pro){

                switch($pro->type){

                  case "table":
                  if(isset($table->engine)){
                    for($eng=0;$eng<count($table->engine);$eng++){
                      if($table->engine[$eng]->type=="table"){
                        for($ca=0; $ca<count($table->engine[$eng]->content); $ca++){
                          if($table->engine[$eng]->content[$ca]->id==$pro->id){
                            $table->engine[$eng]->content[$ca]->need="content";

                          }
                        }
                      }
                    }
                  }
                  break;
                }
              }
              $grupengine=render_grup_engine($table);
              $varphpawal[]=$grupengine->varphpawal;
              $content.=$grupengine->content;
            }

            $ledakan= (explode("v{",$table->output));

              foreach($table->array_data as $a) {
                if(strpos("tes".$table->output."tes","{".$a."}")){
                  //$content.='$bahan_output'.$table->outputVariable.'=str_replace("{'.$a.'}",$q'.$table->outputVariable.'[\''.$a.'\'],$bahan_output'.$table->outputVariable.');'."\n";

                }
              }

              $ledakan= (explode("v{",$table->output));
                for($l=1;$l<count($ledakan);$l++) {
                  $ledakandalam= explode("}v",$ledakan[$l]);
                  $dapatkurunganlama="v{".$ledakandalam[0]."}v";
                  $ledakandalam[0]=str_replace("'","\"",$ledakandalam[0]);
                  $dapatkurungan="{".$ledakandalam[0]."}";
                  $bahanjsonledakan=json_decode($dapatkurungan);
                  $tes=  $bahanjsonledakan;
                  $tes->var_type="variable";
                  $bikinvar=create_variable_web($tes);
                  $dapatkurunganbaru=str_replace('"','\"',$dapatkurungan);
                  //echo $dapatkurunganlama;
                  $bahan_output=str_replace($dapatkurunganlama,'".'.$bikinvar.'."',$bahan_output);

                }
                //$bahan_output=str_replace("v{","",$dapatkurungan);
                $content.='$bahan_output'.$table->outputVariable.'="'.$bahan_output.'";'."\n";
                if(isset($table->output_divider)){
                  if(strlen($table->output_divider)>0){
                    $content.='if(count($result_for_'.$table->outputVariable.')>$num'.$table->outputVariable.'){'."\n";
                      $content.='$bahan_output'.$table->outputVariable.'=$bahan_output'.$table->outputVariable.'."'.$table->output_divider.'";'."\n";
                      $content.='}'."\n";
                    }
                  }


                  $content.='$output_content'.$table->outputVariable.'.=$bahan_output'.$table->outputVariable.';'."\n";
                  $content.='}'."\n";
                  $content.='$'.$table->outputVariable.' = $output_content'.$table->outputVariable.';'."\n";

                  break;
                }
              }else if (isset($table->to_array)){
                $content.='$'.$table->outputVariable.'_array=array();'."\n";
                $content.='foreach($result_for_'.$table->outputVariable.' as $key) {'."\n";
                  $content.='$'.$table->outputVariable.'_array[$key[\''.$table->to_array->index.'\']]=$key[\''.$table->to_array->value.'\'];'."\n";
                  $content.='}'."\n";
                  $content.='$'.$table->outputVariable.' = $'.$table->outputVariable."_array;"."\n";
                }else{
                  $content.='$'.$table->outputVariable.' = $result_for_'.$table->outputVariable.";"."\n";
                }
                if ($table->process_name=="bridge"){
                  $content.='$jum_bridge_'.$table->outputVariable.' = count($'.$table->outputVariable.");"."\n";
                  $content.='$jum_right_array_'.$table->right_array->var_name.' = count('.create_variable_web($table->right_array).");"."\n";
                  $content.='if($jum_bridge_'.$table->outputVariable.' > $jum_right_array_'.$table->right_array->var_name.'){'."\n";
                    $content.='$bedajum_bridge_'.$table->outputVariable.' = $jum_bridge_'.$table->outputVariable.' - $jum_right_array_'.$table->right_array->var_name.";"."\n";
                    $content.='for($ib=0;$ib<count($'.$table->outputVariable.');$ib++){'."\n";
                      $content.='if(!in_array($'.$table->outputVariable.'[$ib]["'.$table->right_bridge_column.'"],'.create_variable_web($table->right_array).')){'."\n";
                        $content.='$db->from(\''.$table_name.'\')->where("id",$'.$table->outputVariable.'[$ib]["id"])->delete()->execute();'."\n";
                        $content.='}'."\n";
                        $content.='}'."\n";


                        $content.='}else if($jum_bridge_'.$table->outputVariable.' < $jum_right_array_'.$table->right_array->var_name.'){'."\n";
                          $content.='$bedajum_bridge_'.$table->outputVariable.' = $jum_right_array_'.$table->right_array->var_name.' - $jum_bridge_'.$table->outputVariable.";"."\n";

                          $content.='for($ir=0; $ir<$bedajum_bridge_'.$table->outputVariable.'; $ir++) {'."\n";
                            $content.='$db->from(\''.$table_name.'\')'."\n";
                            $content.='->insert(array("'.$table->right_bridge_column.'"=>'.create_variable_web($table->right_array).'[$ir],"'.$table->left_bridge_column.'"=>'.create_variable_web($table->left_id).'))'."\n";
                            $content.='->execute();'."\n";

                            $content.='}'."\n";

                            $content.='for($ir=0; $ir<count($result_for_'.$table->outputVariable.'); $ir++) {'."\n";
                              $content.='$db->from(\''.$table_name.'\')->where("id",$result_for_'.$table->outputVariable.'[$ir]["id"])'."\n";
                              $content.='->update(array("'.$table->right_bridge_column.'"=>'.create_variable_web($table->right_array).'[$bedajum_bridge_'.$table->outputVariable.'+$ir]))'."\n";
                              $content.='->execute();'."\n";
                              $content.='}'."\n";

                              $content.='}else{'."\n";

                                $content.='for($ir=0; $ir<count($result_for_'.$table->outputVariable.'); $ir++) {'."\n";

                                  $content.='$db->from(\''.$table_name.'\')->where("id",$result_for_'.$table->outputVariable.'[$ir]["id"])'."\n";
                                  $content.='->update(array("'.$table->right_bridge_column.'"=>'.create_variable_web($table->right_array).'[$ir]))'."\n";
                                  $content.='->execute();'."\n";
                                  $content.='}'."\n";

                                  $content.='}'."\n";

                                  $content.='$result_for_'.$table->outputVariable.' = $db->from(\''.$table_name.'\')'."\n";
                                  $content.='-> where (\''.$table->left_bridge_column.' =\','.create_variable_web($table->left_id).')'."\n";
                                  $content.='->select(array("id","'.$table->left_bridge_column.'","'.$table->right_bridge_column.'"))'."\n";
                                  $content.='->many();'."\n";
                                  $content.='$'.$table->outputVariable.' = $result_for_'.$table->outputVariable.";"."\n";

                                }
                                $objreturn->content=$content;
                                $objreturn->varphpawal=$varphpawal;
                                return $objreturn;
                                //end of create_database_proses
                              }

                              function get_public_assets_directory($direktori){
                                return "{cais_web_url}/".$direktori;
                              }

                              function get_web_check_apiparam($param,$mandatory){
                                $content='if(isset($obj->'.$param.')){'."\n";
                                  $content.='$param_api_'.$param.'=$obj->'.$param.';'."\n";
                                  $content.='$variables[\'param_api_'.$param.'\']=$obj->'.$param.';'."\n";
                                  if($mandatory){
                                    $content.='}else{'."\n";
                                      $content.='$prosesapi=0;'."\n";
                                      $content.='$error_code="001";'."\n";
                                      $content.='$error_msg="'.$param.' tidak ada";'."\n";
                                    }
                                    $content.='}'."\n";
                                    $varphpawal='$param_api_'.$param.' = null;';
                                    $objreturn= new \stdClass();
                                    $objreturn->content=$content;
                                    $objreturn->varphpawal=$varphpawal;
                                    return $objreturn;
                                  }
                                  function get_web_database_query($table){
                                    $content='$db->from(\''.$table->table_name.'\')'."\n";
                                    $selected="";
                                    for ($s=0; $s<count($table->select); $s++){
                                      $selected.='\''.$table->select[$s].'\'';
                                      if($s<count($table->select)-1){
                                        $selected.=",";
                                      }
                                    }
                                    for ($s=0; $s<count($table->where); $s++){
                                      $content.='-> where (\''.$table->where[$s]->index.' '.$table->where[$s]->operator.'\','.$table->where[$s]->value.')'."\n";

                                    }
                                    $content.='->select(array('.$selected.'))'."\n";
                                    $content.='->'.$table->fetch.'();'."\n";
                                    $content.="\n\n";
                                    $content.='$bahanreturn=array();'."\n";
                                    $content.='foreach($query as $q){'."\n";
                                      $content.='$ret=array();'."\n";
                                      for ($o=0; $o<count($table->output); $o++){
                                        $content.='$bahanretret="'.$table->output[$o]->value.'";'."\n";
                                        for ($s=0; $s<count($table->select); $s++){
                                          if(strpos("tes".$table->output[$o]->value."tes", $table->select[$s])){
                                            $content.='$bahanretret=str_replace("{'.$table->select[$s].'}",$q["'.$table->select[$s].'"],$bahanretret);'."\n";
                                          }
                                        }
                                        switch($table->output[$o]->type){
                                          case "link":
                                          $content.='$bahanretret=str_replace($bahanretret,"<a href=\"$bahanretret\">'.$table->output[$o]->label.'</a>",$bahanretret);'."\n";

                                          break;
                                        }
                                        $content.='$ret[]=$bahanretret;'."\n";
                                      }
                                      $content.='foreach($q as $aa){'."\n";
                                        //$content.='$ret[]=$aa;'."\n";
                                        $content.='}'."\n";
                                        $content.='$bahanreturn[]=$ret;'."\n";
                                        $content.='}'."\n";
                                        $content.='$response_data=$query;'."\n";
                                        //$content.='$response_data=$bahanreturn;'."\n";
                                        return $content;
                                      }

                                            function create_text_model_location($modelname){
                                              return '"../mvc_model/'.$modelname;
                                            }

                                            function create_text_model_file_location($modelname){
                                              return "mvc_model/".$modelname.".php";
                                            }

                                            function create_text_include_model($modelname){
                                              return 'include '.create_text_model_location($modelname).'.php";'."\n";
                                            }

                                            function create_text_upload_directory(){
                                              return '$base_upload_directory';
                                            }

                                            function render_self_engine($type,$engine,$pro,$action){
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
                                              //echo "prop ".$pro->properties_modul." page ".$pro->properties_page."<BR>";
                                              switch($type){
                                                      case "table":
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
                                                        //$objproses=create_database_proses($theapi->table,$table_name);

                                                        //  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"use_table_".$table_name."_withoutput_".$table_action->outputVariable."_to_function_".$properties_page."_in_".$properties_modul,"function_id"=>"function_".$page_name_controller,"content"=>$content."\n");
                                                        //echo "banyak ".$ar_worktodo[count($ar_worktodo)-1]["work_id"];
                                                        //akhir caller
                                                      }
                                                      break;

                                                          }


                                                          $objreturn->content=$content;
                                                          $objreturn->varjsawal=$varjsawal;
                                                          $objreturn->deklarasi=$deklarasi;
                                                          $objreturn->varphpawal=$varphpawal;
                                                          $objreturn->include=$include;
                                                          $objreturn->ar_worktodo=$ar_worktodo;
                                                          //echo "kerja nyata ".count($objreturn->ar_worktodo)."<BR>";
                                                          //akhir render_self_engine
                                                          return $objreturn;
                                                        }


                                                        ?>
