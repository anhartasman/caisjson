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

      break;
      case "delete":
      $content.='$result_for_'.$table->outputVariable.' = $db->from(\''.$table_name.'\')'."\n";

      break;
      case "bridge":
      //$content.='$databridgeright'.$table->outputVariable.'=array();'."\n";
      //$content.='$databridgeright'.$table->outputVariable.'[]="'.$table->right_table_id.'";'."\n";
      if(!isset($table->left_id->var_type)){
        $table->left_id->var_type="variable";
      }
      if(!isset($table->right_array->var_type)){
        $table->right_array->var_type="variable";
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

                  $content.='if(count($result_for_'.$table->outputVariable.')>$num'.$table->outputVariable.'){'."\n";
                    $content.='$bahan_output'.$table->outputVariable.'=$bahan_output'.$table->outputVariable.'.",";'."\n";
                    $content.='}'."\n";
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

                              function create_web_element_dropdown($dropdown){
                                $myObj= new \stdClass();
                                $namafiletheme="";
                                if(!isset($dropdown->theme)){
                                  $dropdown->theme="normal";
                                }
                                $namafiletheme=$dropdown->type."_theme_".$dropdown->theme;
                                $select_content=bacafile("copy_web_field/".$namafiletheme.".html");

                                $option_list="";
                                if(isset($dropdown->first_option_value) && isset($dropdown->first_option_label)){
                                  $option_list.="<?php ";
                                  $option_list.=get_web_print_option('"'.$dropdown->first_option_value.'"','"'.$dropdown->first_option_label.'"','');
                                  $option_list.="?>"."\n";
                                }
                                $firstloop="";
                                $contentloop="";
                                $closingloop="";
                                if(isset($dropdown->value)){
                                  $tulisanvariabledropdown=create_variable_web($dropdown->value);
                                  $bahankeyvalue=$dropdown->value->var_name;
                                  if(isset($dropdown->value->index)){
                                    if(count($dropdown->value->index)>0){
                                      for($cv=0;$cv<count($dropdown->value->index);$cv++){
                                        $bahankeyvalue.="_".$dropdown->value->index[$cv];
                                      }
                                    }
                                  }

                                  if(!isset($dropdown->value->option_value)){
                                    $myObjcarikey= new \stdClass();
                                    $myObjcarikey->var_type="variable";
                                    $myObjcarikey->var_name='key'.$bahankeyvalue;
                                    $dropdown->value->option_value=$myObjcarikey;
                                  }
                                  if(!isset($dropdown->value->option_label)){
                                    $myObjcarikey= new \stdClass();
                                    $myObjcarikey->var_type="variable";
                                    $myObjcarikey->var_name='value'.$bahankeyvalue;
                                    $dropdown->value->option_label=$myObjcarikey;
                                  }
                                  $variabeloptionvalue=create_variable_web($dropdown->value->option_value);
                                  $variabeloptionlabel=create_variable_web($dropdown->value->option_label);


                                  $firstloop='foreach('.$tulisanvariabledropdown.' as $key'.$bahankeyvalue.'=>$value'.$bahankeyvalue.') {';
                                    $contentloop=get_web_print_option($variabeloptionvalue,$variabeloptionlabel,'');
                                    $closingloop="}";
                                  }
                                  $option_list.="<?php ";
                                  $option_list.=$firstloop."\n";
                                  if(isset($dropdown->search)){
                                    $tulisanvariable=create_variable_web($dropdown->value);
                                    if(!isset($dropdown->value->equal_to)){
                                      $dropdown->value->equal_to='key';
                                    }
                                    if(!isset($dropdown->value->equal_to_index)){
                                      $dropdown->value->equal_to_index=array();
                                    }

                                    $tulisanvariableforeachsearch="";
                                    $bahankeyvaluesearch="";
                                    if(isset($dropdown->search->foreach)){

                                      if(!isset($dropdown->search->foreach->var_type)){
                                        $dropdown->search->foreach->var_type="variable";
                                      }
                                      $bahankeyvaluesearch=$dropdown->search->foreach->var_name;
                                      $tulisanvariableforeachsearch=create_variable_web($dropdown->search->foreach);

                                      if(isset($dropdown->search->foreach->index)){
                                        if(count($dropdown->search->foreach->index)>0){
                                          for($cv=0;$cv<count($dropdown->search->foreach->index);$cv++){
                                            $bahankeyvaluesearch.="_".$dropdown->search->foreach->index[$cv];
                                          }
                                        }
                                      }

                                    }
                                    $tulisanvariableifsearch="null";
                                    if(isset($dropdown->search->if)){
                                      if(!isset($dropdown->search->if->var_type)){
                                        $dropdown->search->if->var_type="variable";
                                      }
                                      $tulisanvariableifsearch=create_variable_web($dropdown->search->if);
                                    }
                                    $tulisanvariablevaluesearch="null";
                                    if(isset($dropdown->search->value)){
                                      if(!isset($dropdown->search->value->var_type)){
                                        $dropdown->search->value->var_type="variable";
                                      }
                                      $tulisanvariablevaluesearch=create_variable_web($dropdown->search->value);
                                    }

                                    if(!isset($dropdown->search->operator)){
                                      $dropdown->search->operator="==";
                                    }

                                    $myObjcarikey= new \stdClass();
                                    $myObjcarikey->var_type="variable";
                                    $myObjcarikey->var_name=$dropdown->value->equal_to;
                                    $myObjcarikey->index=$dropdown->value->equal_to_index;
                                    $equalto=create_variable_web($myObjcarikey);

                                    $contentloop='$dapatcari=0;'."\n";
                                    if(isset($dropdown->search->foreach)){
                                      $contentloop.='foreach('.$tulisanvariableforeachsearch.' as $key'.$bahankeyvaluesearch.'=>$value'.$bahankeyvaluesearch.') {'."\n";
                                        $contentloop.='if ('.$tulisanvariableifsearch.' '.$dropdown->search->operator.' '.$tulisanvariablevaluesearch.'){'."\n";
                                          $contentloop.='$dapatcari=1;'."\n";
                                          $contentloop.='break;'."\n";
                                          $contentloop.='}'."\n";
                                          $contentloop.='}'."\n";
                                          $closingloop="}";
                                        }else{
                                          $contentloop.='if ('.$tulisanvariableifsearch.' '.$dropdown->search->operator.' '.$tulisanvariablevaluesearch.'){'."\n";
                                            $contentloop.='$dapatcari=1;'."\n";
                                            $contentloop.='}'."\n";
                                            $closingloop="}";
                                          }

                                          $contentloop.='if ($dapatcari == 1){'."\n";
                                            $contentloop.=get_web_print_option($variabeloptionvalue,$variabeloptionlabel,'selected');
                                            $contentloop.='}else{'."\n";
                                              $contentloop.=get_web_print_option($variabeloptionvalue,$variabeloptionlabel,'');
                                              $contentloop.='}'."\n";

                                            }
                                            $option_list.=$contentloop."\n";
                                            $option_list.=$closingloop."\n";
                                            $option_list.="?>";

                                            $select_content=str_replace("{label}",$dropdown->label,$select_content);
                                            $select_content=str_replace("{id}",$dropdown->id,$select_content);
                                            $select_content=str_replace("{option_list}",$option_list,$select_content);
                                            if(isset($dropdown->class)){
                                              $select_content=str_replace("{class}",$dropdown->class,$select_content);
                                            }
                                            $select_content=str_replace("<br />","",$select_content);
                                            $myObj->content=$select_content;

                                            $select_js_content="";
                                            $select_js_content_variabelawal="";
                                            if(!isset($dropdown->default)){
                                              $dropdown->default=0;
                                            }
                                            $select_js_content_variabelawal.="var $dropdown->variable = $dropdown->default;\n";
                                            $select_js_content_variabelawal.="var ".$dropdown->variable."_textvalue = null;\n";


                                            $myObjFungsiSet= new \stdClass();
                                            $myObjFungsiSet->func_name="set_idx_select_".$dropdown->id;
                                            //$myObjFungsiSet->func_content="document.getElementById(\"".$page_elemen->dropdown[$c]->id."\").selectedIndex = nomidx;";
                                            $myObjFungsiSet->func_content="$(\"select#".$dropdown->id."\").prop('selectedIndex', nomidx).change();";
                                            $myObjFungsiSet->type="changer";
                                            $myObjFungsiSet->content_generate="auto";
                                            $listenerset=create_web_function($myObjFungsiSet)->content;
                                            $listenerset=str_replace("{func_param}","nomidx",$listenerset);
                                            $select_js_content.=$listenerset;

                                            $myObj->js_content=$select_js_content;
                                            $myObj->varjsawal=$select_js_content_variabelawal;
                                            return $myObj;

                                          }
                                          function create_booleancheck_web(stdClass $checkgroup){

                                            $comparing_content="";
                                            $daf_var=array();
                                            $isset_content="";
                                            if(!isset($checkgroup->operator)){
                                              $checkgroup->operator="and";
                                            }

                                            for ($c=0; $c<count($checkgroup->content); $c++){
                                              if(!isset($checkgroup->content[$c]->type)){
                                                $checkgroup->content[$c]->type="checking";
                                              }
                                              if($checkgroup->content[$c]->type=="group"){
                                                $thegroup=create_booleancheck_web($checkgroup->content[$c]);
                                                $daf_var=array_merge($daf_var,$thegroup->daf_var);
                                                $comparing_content.="(".$thegroup->comparing_content.")";
                                              }else if($checkgroup->content[$c]->type=="checking"){
                                                if(!isset($checkgroup->content[$c]->operator)){
                                                  $checkgroup->content[$c]->operator="==";
                                                }
                                                if(!isset($checkgroup->content[$c]->value->var_type)){
                                                  $checkgroup->content[$c]->value->var_type="variable";
                                                }
                                                if(!isset($checkgroup->content[$c]->check->var_type)){
                                                  $checkgroup->content[$c]->check->var_type="variable";
                                                }
                                                $varcheck=create_variable_web($checkgroup->content[$c]->check);
                                                $varvalue=create_variable_web($checkgroup->content[$c]->value);
                                                $comparing_content.=$varcheck.' '.$checkgroup->content[$c]->operator.' '.$varvalue."\n";
                                                $daf_var[]=$varcheck;
                                                if($c+1>count($checkgroup->content)){
                                                  if($checkgroup->content->operator=="and"){
                                                    $comparing_content.=" && ";
                                                  }else if($checkgroup->content->operator=="or"){
                                                    $comparing_content.=" || ";
                                                  }
                                                }

                                              }
                                              for($d=0; $d<count($daf_var); $d++){
                                                $isset_content.="isset(".$daf_var[$d].")";
                                                if($d+1>count($daf_var)){
                                                  $isset_content.="&&";
                                                }
                                              }
                                              echo $isset_content;
                                            }

                                            $objreturn= new \stdClass();
                                            $objreturn->comparing_content=$comparing_content;
                                            $objreturn->isset_content=$isset_content;
                                            $objreturn->daf_var=$daf_var;
                                            return $objreturn;
                                            //akhir create_booleancheck_web
                                          }
                                          function create_variable_web($value){
                                            $tulisan_variable="";
                                            $isivalue="";
                                            switch($value->var_type){
                                              case "variable":
                                              $tulisan_variable='$'.$value->var_name;
                                              if(isset($value->index)){
                                                if(count($value->index)>0){
                                                  foreach($value->index as $in){
                                                    if (is_object($in)) {
                                                      $tulisan_variable.='['.create_variable_web($in).']';
                                                    }else{
                                                      $tulisan_variable.='[\''.$in.'\']';
                                                    }
                                                  }
                                                }
                                              }
                                              $isivalue='<?php if(isset($'.$value->var_name.')){ print('.$tulisan_variable.'); } ?>';
                                              break;
                                              case "hardcode":
                                              $tulisan_variable=$value->var_name;
                                              $isivalue=$tulisan_variable;
                                              break;
                                            }
                                            return $tulisan_variable;
                                          }
                                          function get_system_directory($direktori){
                                            return "http://localhost/nativecreator/".$direktori;
                                          }
                                          function create_web_function_caller($caller){
                                            $bahanreturn="";
                                            $variable_name="";
                                            if(isset($caller->func_name) && strlen($caller->func_name)>0){
                                              if(isset($caller->variable)){
                                                $variable_name=$caller->variable;
                                                $bahanreturn.="var ".$variable_name." = ";
                                              }else{
                                                $variable_name="return_of_".$caller->func_name;
                                                if(isset($caller->checkReturn)){
                                                  $bahanreturn.="var ".$variable_name." = ";
                                                }
                                              }

                                              $bahanreturn.=$caller->func_name."(";

                                              if(isset($caller->param)){
                                                for ($p=0; $p<count($caller->param); $p++){
                                                  $bahanreturn.=$caller->param[$p];
                                                  if($p<count($caller->param)-1){
                                                    $bahanreturn.=",";
                                                  }
                                                }
                                              }
                                              $bahanreturn.=");\n";

                                            }else if(isset($caller->func_type)){
                                              $variable_name="content";
                                              $myObjFungsi= $caller;
                                              $myObjFungsi->type=$caller->func_type;
                                              $objhasilcreate=create_web_function($myObjFungsi);
                                              $func_param=$objhasilcreate->func_param;
                                              for($fp=0; $fp<count($func_param); $fp++){
                                                if(!strpos("tes".$bahanreturn."tes","var ".$func_param[$fp]["name"]." = ")){
                                                  $bahanreturn.="var ";
                                                }
                                                $bahanreturn.=$func_param[$fp]["name"]." = ".$caller->param[$fp].";"."\n";
                                                if($fp<count($func_param)-1){
                                                  //$isiarrayparam.=",";
                                                }

                                              }
                                              $bahanreturn.=$objhasilcreate->func_body;
                                            }

                                            if(isset($caller->checkReturn)){

                                              for ($cr=0; $cr<count($caller->checkReturn); $cr++){
                                                $bahanreturn.="if (".$variable_name." ".$caller->checkReturn[$cr]->condition." ".$caller->checkReturn[$cr]->if."){"."\n";

                                                  for ($th=0; $th<count($caller->checkReturn[$cr]->then); $th++){
                                                    $bahanreturn.=create_web_function_caller($caller->checkReturn[$cr]->then[$th]);
                                                    $bahanreturn.="\n";
                                                  }
                                                  $bahanreturn.="}"."\n";
                                                }
                                              }
                                              return $bahanreturn;
                                              //akhir create_web_function_caller
                                            }
                                            function create_web_function($func){
                                              $objreturn= new \stdClass();
                                              $content="";
                                              if(isset($func->variable)){
                                                $content.="var $func->variable;\n";
                                              }
                                              $content.="function {func_name}({func_param}){\n";
                                                $content.="{content}\n";
                                                $content.="}\n";
                                                $func_param=array();
                                                $func_body="";
                                                $func_footer="";
                                                $func_content="";
                                                if(isset($func->func_content)){
                                                  if(!empty($func->func_content)){
                                                    $func_content=$func->func_content;
                                                  }
                                                }
                                                if(!isset($func->content_generate)){
                                                  $func->content_generate="auto";
                                                }
                                                if($func->content_generate=="manual"){
                                                  $content=str_replace("{content}","",$content);
                                                }else{
                                                  $tipe="";
                                                  if(!isset($func->type)){
                                                    $tipe="normal";
                                                  }else{
                                                    $tipe=$func->type;
                                                  }
                                                  switch($tipe){
                                                    case "api_shooter":
                                                    $func_param=[];
                                                    $content.="var ajaxjson_".$func->func_name.";"."\n";
                                                    $func_body.="ajaxjson_".$func->func_name." = buatajax();"."\n";
                                                    $func_body.='var url="'.get_system_directory("API")."/".'";'."\n";
                                                    $func_body.="ajaxjson_".$func->func_name.".onreadystatechange = stateChangedjson_".$func->func_name.";"."\n";
                                                    $func_body.='ajaxjson_'.$func->func_name.'.open("POST",url,true);'."\n";
                                                    $func_body.='ajaxjson_'.$func->func_name.'.setRequestHeader("Content-Type", "application/json");'."\n";


                                                    $api_param=array();
                                                    $api_param["modul"]=$func->modul;
                                                    $api_param["action"]=$func->action;
                                                    for($p=0; $p<count($func->param); $p++){
                                                      $api_param_obj=array();
                                                      $api_param[$func->param[$p]->index]=$func->param[$p]->value;
                                                      //$api_param[]=$func->param[$p];
                                                    }
                                                    $encoded_param=json_encode($api_param);
                                                    $encoded_param = preg_replace('/\s*:"([^"]+)"\s*/', ':$1', $encoded_param);
                                                    $encoded_param=str_replace($func->modul,"\"$func->modul\"",$encoded_param);
                                                    $encoded_param=str_replace($func->action,"\"$func->action\"",$encoded_param);

                                                    $func_body.='var data = JSON.stringify('.$encoded_param.');'."\n";
                                                    $func_body.='console.log("Data sent from '.$func->func_name.' : "+data);'."\n";
                                                    $func_body.='ajaxjson_'.$func->func_name.'.send(data);'."\n";

                                                    $copy_base_statechanged="";
                                                    $file = fopen("copy_jsloop/jsloop_statechanged.txt","r");
                                                    while(! feof($file))
                                                    {
                                                      $copy_base_statechanged.=fgets($file). "<br />";
                                                    }
                                                    fclose($file);
                                                    $copy_base_statechanged=str_replace("<br />","",$copy_base_statechanged);

                                                    $func_change=$copy_base_statechanged;
                                                    $func_change=str_replace("{id}",$func->func_name,$func_change);
                                                    $func_change=str_replace("{onAPIReturn}",create_web_onapireturn_listener($func->onAPIReturn),$func_change);
                                                    $content.=$func_change."\n";
                                                    break;
                                                    case "change_datatable_by_json":
                                                    $func_param=array(array("name"=>"data_content"));
                                                    //  $func_body.='alert(data_content);'."\n";
                                                    $func_body.="$('#$func->table_id').dataTable().fnClearTable();"."\n";
                                                    $func_body.='if(data_content.length>0){'."\n";
                                                      $func_body.="$('#$func->table_id').dataTable().fnAddData(data_content);"."\n";
                                                      $func_body.='}'."\n";
                                                      break;
                                                      case "json_extracter":
                                                      $func_param=array(array("name"=>"data"),array("name"=>"target"));
                                                      $func_body.="var obj=JSON.parse(data);"."\n";
                                                      $func_body.="var content=obj[target];"."\n";
                                                      if(isset($func->variable)){
                                                        $func_body.="$func->variable = content;"."\n";
                                                      }
                                                      $func_footer.="return content;"."\n";;
                                                      break;
                                                      case "setter_dropdown":
                                                      $func_param=array(array("name"=>"data_content"));
                                                      $func_body.='if(data_content.length>0){'."\n";
                                                        $func_body.="$('#$func->dropdown_id').html(data_content);"."\n";
                                                        $func_body.='}'."\n";
                                                        break;
                                                        case "link_jumper":
                                                        $func_param=array(array("name"=>"link"));
                                                        $func_body.="window.location.href = link;"."\n";
                                                        break;
                                                        case "page_jumper":
                                                        $func_param=array();
                                                        $thelink=get_project_url_js($func->param[0],$func->param[1],$func->param[2]);
                                                        $func_body.="window.location.href = '".$thelink."';"."\n";
                                                        break;
                                                      }
                                                      $func_content=$func_body."\n".$func_footer;
                                                      $content=str_replace("{content}",$func_content,$content);
                                                    }
                                                    if(isset($func->func_name)){
                                                      $content=str_replace("{func_name}",$func->func_name,$content);
                                                    }
                                                    $isiarrayparam="";
                                                    if(count($func_param)>0){
                                                      for($fp=0; $fp<count($func_param); $fp++){
                                                        $isiarrayparam.=$func_param[$fp]["name"];
                                                        if($fp<count($func_param)-1){
                                                          $isiarrayparam.=",";
                                                        }

                                                      }
                                                      $content=str_replace("{func_param}",$isiarrayparam,$content);
                                                    }
                                                    $content=str_replace("<br />","",$content);
                                                    $objreturn->content=$content;
                                                    $objreturn->func_param=$func_param;
                                                    $objreturn->func_body=$func_body;
                                                    $objreturn->func_footer=$func_footer;

                                                    return $objreturn;

                                                    //akhir create_web_function
                                                  }

                                                  function create_web_onclick_listener($elemen){
                                                    $content='$("#{field_id}").on( \'click\', function () {'."\n";
                                                      $content.="{content}"."\n";
                                                      $content.="});"."\n";

                                                      $listener=str_replace("{field_id}",$elemen->id,$content);
                                                      $listener_content="";
                                                      for ($o=0; $o<count($elemen->onclick); $o++){
                                                        $bahanlistener="";
                                                        $namavarreturn="";
                                                        $bahanlistener=create_web_function_caller($elemen->onclick[$o]);

                                                        $listener_content.=$bahanlistener."\n";
                                                      }
                                                      $listener=str_replace("{content}",$listener_content,$listener);

                                                      return $listener;
                                                    }
                                                    function create_web_onchange_listener($elemen){
                                                      $bahanreturn="";
                                                      $namavariablefield="";
                                                      if(!isset($elemen->variable)){
                                                        $namavariablefield="isian_".$elemen->id;
                                                        $elemen->variable=$namavariablefield;
                                                      }else{
                                                        $namavariablefield=$elemen->variable;
                                                      }
                                                      if(isset($elemen->onchange) && $elemen->type!="image"){
                                                        $content='$("#{elemen_id}").on( \'change\', function () {'."\n";
                                                          $content.="{content}"."\n";
                                                          $content.="});"."\n";

                                                          $listener=str_replace("{elemen_id}",$elemen->id,$content);
                                                          $listener_content="";

                                                          if(!isset($elemen->type)){
                                                            $elemen->type="select";
                                                          }
                                                          switch($elemen->type){
                                                            case "select":
                                                            $listener_content.=$namavariablefield."_textvalue = $(\"#".$elemen->id." option:selected\").text();"."\n";
                                                            $listener_content.=$namavariablefield." = $(\"#".$elemen->id."\").val();"."\n";
                                                            break;
                                                            case "file":
                                                            $listener_content.=$namavariablefield."_file = document.getElementById(\"".$elemen->id."\").files[0];\n";
                                                            $listener_content.="if (".$namavariablefield."_file){\n";
                                                              $listener_content.="var r = new FileReader();\n";
                                                              $listener_content.="r.onload = function(e) {\n";
                                                                $listener_content.="var contents = e.target.result;\n";
                                                                $listener_content.=$namavariablefield."_file_content = contents;\n";
                                                                $listener_content.="}\n";
                                                                $listener_content.="r.readAsDataURL (".$namavariablefield."_file);\n";
                                                                $listener_content.="}\n";
                                                                break;
                                                                case "image_upload":
                                                                $listener_content.=$namavariablefield."_file = document.getElementById(\"".$elemen->id."\").files[0];\n";
                                                                $listener_content.="if (".$namavariablefield."_file){\n";
                                                                  $listener_content.="var r = new FileReader();\n";
                                                                  $listener_content.="r.onload = function(e) {\n";
                                                                    $listener_content.="var contents = e.target.result;\n";
                                                                    $listener_content.="$('#img_of_".$elemen->id."').attr('src', e.target.result);\n";
                                                                    $listener_content.=$namavariablefield."_file_content = contents;\n";
                                                                    $listener_content.="}\n";
                                                                    $listener_content.="r.readAsDataURL (".$namavariablefield."_file);\n";
                                                                    $listener_content.="}\n";
                                                                    break;
                                                                    default:
                                                                    $listener_content.=$namavariablefield." = $(\"#".$elemen->id."\").val();"."\n";
                                                                    break;
                                                                  }

                                                                  for ($o=0; $o<count($elemen->onchange); $o++){

                                                                    $bahanlistener=create_web_function_caller($elemen->onchange[$o]);
                                                                    $listener_content.=$bahanlistener."\n";
                                                                  }
                                                                  $listener=str_replace("{content}",$listener_content,$listener);
                                                                  $bahanreturn=$listener;
                                                                }
                                                                return $bahanreturn;
                                                              }
                                                              function create_web_onapireturn_listener($onapireturn){
                                                                $content="";

                                                                for ($o=0; $o<count($onapireturn); $o++){

                                                                  $bahanlistener=create_web_function_caller($onapireturn[$o]);
                                                                  $content.=$bahanlistener."\n";

                                                                }

                                                                return $content;
                                                              }
                                                              function create_web_onload_listener($elemen){
                                                                $content="";

                                                                for ($o=0; $o<count($elemen->onload); $o++){

                                                                  $bahanlistener=create_web_function_caller($elemen->onload[$o]);
                                                                  $content.=$bahanlistener."\n";

                                                                }

                                                                return $content;
                                                              }
                                                              function create_unique_content($file_address,$content_to_add){
                                                                $konten="";
                                                                $ada=false;
                                                                if (file_exists($file_address)) {
                                                                  $konten=bacafile($file_address);
                                                                }
                                                                if(!strpos("tes".$konten."tes",$content_to_add)){
                                                                  $konten.=$content_to_add."\n";
                                                                }

                                                                file_put_contents($file_address,$konten);
                                                                return $ada;
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
                                                                      function get_web_field($field){
                                                                        $content=new \stdClass();
                                                                        $namafiletheme="";
                                                                        if(!isset($field->theme)){
                                                                          $field->theme="normal";
                                                                        }
                                                                        $namafiletheme=$field->type."_theme_".$field->theme;
                                                                        //echo $namafiletheme;
                                                                        $isicontent=bacafile("copy_web_field/".$namafiletheme.".html");
                                                                        $isijs="";
                                                                        $varjsawal="";
                                                                        $attribute="";
                                                                        $namavariablefield="";
                                                                        if(!isset($field->variable)){
                                                                          $namavariablefield="isian_".$field->id;
                                                                          $field->variable=$namavariablefield;
                                                                        }else{
                                                                          $namavariablefield=$field->variable;
                                                                        }
                                                                        if($field->type!="select"
                                                                        && $field->type!="select2"){
                                                                          // echo $namavariablefield;
                                                                          $varjsawal.="var ".$namavariablefield." = null;\n";
                                                                        }
                                                                        if(isset($field->attribute)){
                                                                          foreach($field->attribute as $key=>$value) {
                                                                            $attribute.=$key."=\"".$value."\"";
                                                                          }
                                                                        }
                                                                        switch($field->type){
                                                                          case "select":
                                                                          $dropdown_content=create_web_element_dropdown($field);
                                                                          $isicontent=$dropdown_content->content;
                                                                          $isijs=$dropdown_content->js_content;
                                                                          $varjsawal.=$dropdown_content->varjsawal;
                                                                          break;
                                                                          case "richtext":
                                                                          $bahanjs=bacafile("copy_jsloop/jsloop_richtext.txt");
                                                                          $bahanjs=str_replace("{elemen_id}",$field->id,$bahanjs);

                                                                          $isijs.=$bahanjs."\n";
                                                                          break;
                                                                          case "file":
                                                                          $varjsawal.="var ".$namavariablefield."_file = null;\n";
                                                                          $varjsawal.="var ".$namavariablefield."_file_content = null;\n";
                                                                          break;
                                                                          case "image_upload":
                                                                          $varjsawal.="var ".$namavariablefield."_file = null;\n";
                                                                          $varjsawal.="var ".$namavariablefield."_file_content = null;\n";
                                                                          break;
                                                                          case "select2":
                                                                          $bahanjs=bacafile("copy_jsloop/jsloop_select2.txt");
                                                                          $bahanjs=str_replace("{elemen_id}",$field->id,$bahanjs);

                                                                          $isijs=$bahanjs."\n";
                                                                          if(isset($dropdown->option_label_from)){
                                                                            switch($field->option_label_from){
                                                                              case "hardcoded_array":

                                                                              break;
                                                                            }
                                                                          }

                                                                          $dropdown_content=create_web_element_dropdown($field);
                                                                          $isicontent=$dropdown_content->content;
                                                                          $isijs.=$dropdown_content->js_content;
                                                                          $varjsawal.=$dropdown_content->varjsawal;
                                                                          break;
                                                                        }

                                                                        if(isset($field->onclick)){
                                                                          $isijs.=create_web_onclick_listener($field);
                                                                        }

                                                                        if(isset($field->onload)){
                                                                          $isijs.=create_web_onload_listener($field);
                                                                        }

                                                                        if(!isset($field->onchange)){
                                                                          $field->onchange=array();
                                                                        }
                                                                        if(isset($field->onchange)){
                                                                          $isijs.=create_web_onchange_listener($field);
                                                                        }
                                                                        $isivalue="";
                                                                        if(isset($field->value)){
                                                                          $tulisanvariable=create_variable_web($field->value);
                                                                          $isivalue='<?php if(isset($'.$field->value->var_name.')){ print('.$tulisanvariable.'); } ?>';

                                                                        }

                                                                        $isicontent=str_replace("{label}",$field->label,$isicontent);
                                                                        $isicontent=str_replace("{id}",$field->id,$isicontent);
                                                                        $isicontent=str_replace("{class}",$field->class,$isicontent);
                                                                        $isicontent=str_replace("{value}",$isivalue,$isicontent);
                                                                        $isicontent=str_replace("{attribute}",$attribute,$isicontent);
                                                                        if(isset($field->src)){
                                                                          $tulisanvariable=create_variable_web($field->src);
                                                                          $isicontent=str_replace("{src}",get_system_directory("uploads")."/<?php print(".$tulisanvariable.");?>",$isicontent);
                                                                        }

                                                                        $content->isicontent=$isicontent;
                                                                        $content->varjsawal=$varjsawal;
                                                                        $content->isijs=$isijs;
                                                                        return $content;
                                                                      }
                                                                      function get_web_print_option($key,$value,$selected){

                                                                        $result='print("<option value=\'".'.$key.'."\' {select}>".'.$value.'."</option>");';
                                                                        $result=str_replace("{select}",$selected,$result);
                                                                        $result=$result."\n";
                                                                        return $result;
                                                                      }

                                                                      function render_html_form_field($page_elemen){
                                                                        $content=new \stdClass();
                                                                        $bahanawaljs="";
                                                                        $variabeljsawal="";
                                                                        $bahanform="";
                                                                        $kontenvariabelform="";
                                                                        $copy_basejs="";

                                                                        $hasilrender=render_html_element_field($page_elemen);
                                                                        $kontenvariabelform=$hasilrender->kontenvariabelform;
                                                                        $kontenfungsivalidasi=$hasilrender->kontenfungsivalidasi;

                                                                        $bahanform.="<form role=\"form\" name=\"{form_id}\" id=\"{form_id}\" {form_attribute}  >"."\n";
                                                                        $bahanform.="<div class=\"".$page_elemen->div_class."\">"."\n";
                                                                        $bahanform.=$hasilrender->bahanform;
                                                                        $bahanform.="</div>"."\n";
                                                                        $bahanform.="</form>"."\n";
                                                                        $bahanform=str_replace("{form_id}",$page_elemen->id,$bahanform);
                                                                        $form_attribute="";

                                                                        foreach($page_elemen->attribute as $key=>$value) {
                                                                          $form_attribute.=$key."=\"".$value."\"";
                                                                        }

                                                                        $bahanform=str_replace("{form_attribute}",$form_attribute,$bahanform);


                                                                        $variabeljsawal.=$hasilrender->variabeljsawal;
                                                                        $bahanawaljs.=$hasilrender->bahanawaljs;

                                                                        $content->kontenvariabelform=$kontenvariabelform;
                                                                        $content->kontenfungsivalidasi=$kontenfungsivalidasi;
                                                                        $content->bahanform=$bahanform;
                                                                        $content->bahanawaljs=$bahanawaljs;
                                                                        $content->variabeljsawal=$variabeljsawal;
                                                                        $content->copy_basejs=$copy_basejs;

                                                                        return $content;
                                                                      }
                                                                      function render_html_element_field($page_elemen){
                                                                        $content=new \stdClass();
                                                                        $bahanawaljs="";
                                                                        $variabeljsawal="";
                                                                        $bahanform="";
                                                                        $kontenvariabelform="";
                                                                        $copy_basejs="";
                                                                        for ($c=0; $c<count($page_elemen->field); $c++){
                                                                          $namavariablefield="";
                                                                          if(!isset($page_elemen->field[$c]->variable)){
                                                                            $namavariablefield="isian_".$page_elemen->field[$c]->id;
                                                                            $page_elemen->field[$c]->variable=$namavariablefield;
                                                                          }else{
                                                                            $namavariablefield=$page_elemen->field[$c]->variable;
                                                                          }

                                                                          switch($page_elemen->field[$c]->type){
                                                                            case "text":
                                                                            $kontenvariabelform.=$namavariablefield." = document.getElementById(\"".$page_elemen->field[$c]->id."\").value;\n";
                                                                            break;
                                                                            case "select":
                                                                            $kontenvariabelform.=$namavariablefield.'_textvalue = $("#'.$page_elemen->field[$c]->id.'option:selected").text();'."\n";
                                                                            $kontenvariabelform.=$namavariablefield.' = $("#'.$page_elemen->field[$c]->id.'").val();'."\n";
                                                                            break;
                                                                            case "select2":
                                                                            $kontenvariabelform.=$namavariablefield.' = $("#'.$page_elemen->field[$c]->id.'").val();'."\n";
                                                                            break;
                                                                            case "number":
                                                                            $kontenvariabelform.=$namavariablefield." = document.getElementById(\"".$page_elemen->field[$c]->id."\").value;\n";
                                                                            break;
                                                                            case "email":
                                                                            $kontenvariabelform.=$namavariablefield." = document.getElementById(\"".$page_elemen->field[$c]->id."\").value;\n";
                                                                            break;
                                                                            case "textarea":
                                                                            $kontenvariabelform.=$namavariablefield." = document.getElementById(\"".$page_elemen->field[$c]->id."\").value;\n";
                                                                            break;
                                                                            case "file":
                                                                            $kontenvariabelform.=$namavariablefield." = document.getElementById(\"".$page_elemen->field[$c]->id."\").value;\n";
                                                                            $kontenvariabelform.=$namavariablefield."_file = document.getElementById(\"".$page_elemen->field[$c]->id."\").files[0];\n";
                                                                            $kontenvariabelform.="if (".$namavariablefield."_file){\n";
                                                                              $kontenvariabelform.="var r = new FileReader();\n";
                                                                              $kontenvariabelform.="r.onload = function(e) {\n";
                                                                                $kontenvariabelform.="var contents = e.target.result;\n";
                                                                                $kontenvariabelform.=$namavariablefield."_file_content = contents;\n";
                                                                                $kontenvariabelform.="}\n";
                                                                                $kontenvariabelform.="r.readAsDataURL (".$namavariablefield."_file);\n";
                                                                                $kontenvariabelform.="}\n";
                                                                                break;
                                                                                case "richtext":
                                                                                $kontenvariabelform.=$namavariablefield." = CKEDITOR.instances.".$page_elemen->field[$c]->id.".getData();\n";
                                                                                break;
                                                                              }

                                                                            }

                                                                            $kontenfungsivalidasi="";
                                                                            for ($c=0; $c<count($page_elemen->field); $c++){
                                                                              //echo $page_elemen->field[$c]->type;

                                                                              $field=get_web_field($page_elemen->field[$c]);
                                                                              $bahanawaljs.="\n".$field->isijs;
                                                                              $variabeljsawal.="\n".$field->varjsawal;
                                                                              $bahanform.="\n".$field->isicontent;
                                                                              if(isset($page_elemen->field[$c]->validation)){

                                                                                foreach($page_elemen->field[$c]->validation as $validate) {

                                                                                  $bahanvalidation=bacafile("copy_jsvalidation/jsvalidation_".$validate->type.".html");

                                                                                  $bahandeklarasi="";
                                                                                  $dataplace=".value";
                                                                                  switch($page_elemen->field[$c]->type){
                                                                                    case "richtext":
                                                                                    $bahandeklarasi='var field_tocheck_{field_id} = CKEDITOR.instances.{field_id}.getData();';
                                                                                    $dataplace="";
                                                                                    break;
                                                                                    default :
                                                                                    $bahandeklarasi='var field_tocheck_{field_id} = document.getElementById("{field_id}");';
                                                                                    break;
                                                                                  }
                                                                                  $bahandeklarasi.="\n";
                                                                                  $bahanvalidation=$bahandeklarasi.$bahanvalidation;
                                                                                  $bahanvalidation=str_replace("{field_id}",$page_elemen->field[$c]->id,$bahanvalidation);
                                                                                  $bahanvalidation=str_replace("{dataplace}",$dataplace,$bahanvalidation);

                                                                                  switch($validate->type){
                                                                                    case "minlength":
                                                                                    $minlength=$validate->length;
                                                                                    $validation_msg="";
                                                                                    if(isset($validate->message)){
                                                                                      $validation_msg=$validate->message;
                                                                                    }
                                                                                    $bahanvalidation=str_replace("{minlength}",$minlength,$bahanvalidation);
                                                                                    $bahanvalidation=str_replace("{validation_msg}",$validation_msg,$bahanvalidation);

                                                                                    break;
                                                                                  }

                                                                                  $kontenfungsivalidasi.=$bahanvalidation;
                                                                                  $kontenfungsivalidasi.="\n";
                                                                                }

                                                                              }

                                                                            }

                                                                            $form_get_variable=bacafile("copy_base/js_form_get_variable.html");
                                                                            $form_get_variable=str_replace("{form_id}",$page_elemen->id,$form_get_variable);
                                                                            $form_get_variable=str_replace("{content}",$kontenvariabelform,$form_get_variable);

                                                                            $bahanawaljs.=$form_get_variable;

                                                                            $fungsivalidasi=bacafile("copy_base/js_validation_function.html");
                                                                            $fungsivalidasi=str_replace("{form_id}",$page_elemen->id,$fungsivalidasi);
                                                                            $fungsivalidasi=str_replace("{content}",$kontenfungsivalidasi,$fungsivalidasi);

                                                                            $bahanawaljs.=$fungsivalidasi;

                                                                            $kontenfungsisubmitformjs="";
                                                                            $fungsisubmitformjs=bacafile("copy_base/js_form_submit.html");
                                                                            $fungsisubmitformjs=str_replace("{form_id}",$page_elemen->id,$fungsisubmitformjs);
                                                                            $fungsisubmitformjs=str_replace("{content}",$kontenfungsisubmitformjs,$fungsisubmitformjs);

                                                                            $bahanawaljs.=$fungsisubmitformjs;

                                                                            $content->kontenvariabelform=$kontenvariabelform;
                                                                            $content->kontenfungsivalidasi=$kontenfungsivalidasi;
                                                                            $content->bahanform=$bahanform;
                                                                            $content->bahanawaljs=$bahanawaljs;
                                                                            $content->variabeljsawal=$variabeljsawal;
                                                                            $content->copy_basejs=$copy_basejs;

                                                                            return $content;

                                                                            //akhir render_html_element_field
                                                                          }

                                                                          function get_project_url_js($modul,$page,$parameter){
                                                                            $linknya=get_system_directory("admin")."/".$modul."/".$page;
                                                                            if($parameter==null){
                                                                              $parameter=array();
                                                                            }
                                                                            for($fp=0; $fp<count($parameter); $fp++){
                                                                              $param=$parameter[$fp];
                                                                              if(!isset($param->value_type)){
                                                                                $param->value_type="hardcore";
                                                                              }
                                                                              if(!isset($param->slash)){
                                                                                $param->slash="/";
                                                                              }
                                                                              switch($param->value_type){
                                                                                case "hardcore":
                                                                                $param->value="'".$param->value."'";
                                                                                break;
                                                                                case "variable":
                                                                                $param->value=$param->value;
                                                                                break;
                                                                              }
                                                                              switch($param->slash){
                                                                                case "/":
                                                                                $linknya.="/".$param->index."/'+".$param->value."+'";
                                                                                break;
                                                                                case "?":
                                                                                $linknya.="?".$param->index."='+".$param->value."+'";
                                                                                break;
                                                                                case "&":
                                                                                $linknya.="&".$param->index."='+".$param->value."+'";
                                                                                break;
                                                                              }
                                                                            }
                                                                            //echo $linknya;
                                                                            return $linknya;
                                                                          }

                                                                          function get_project_url_php($modul,$page,$parameter){
                                                                            $linknya=get_system_directory("admin")."/".$modul."/".$page;

                                                                            for($fp=0; $fp<count($parameter); $fp++){
                                                                              $param=$parameter[$fp];
                                                                              if(!isset($param->value_type)){
                                                                                $param->value_type="hardcore";
                                                                              }
                                                                              if(!isset($param->slash)){
                                                                                $param->slash="/";
                                                                              }
                                                                              switch($param->value_type){
                                                                                case "hardcore":
                                                                                $param->value=$param->value;
                                                                                break;
                                                                                case "variable":
                                                                                $param->value="<?php if(isset($".$param->value.")){ echo".$param->value.";} ?>";
                                                                                break;
                                                                              }
                                                                              switch($param->slash){
                                                                                case "/":
                                                                                $linknya.="/".$param->index."/".$param->value."";
                                                                                break;
                                                                                case "?":
                                                                                $linknya.="?".$param->index."=".$param->value."";
                                                                                break;
                                                                                case "&":
                                                                                $linknya.="&".$param->index."=".$param->value."";
                                                                                break;
                                                                              }
                                                                            }
                                                                            //echo $linknya;
                                                                            return $linknya;
                                                                          }

                                                                          function render_grup_engine(stdClass $thepage){
                                                                            $objreturn=new \stdClass();
                                                                            $content="";
                                                                            $varphpawal=array();
                                                                            $varjsawal="";
                                                                            $deklarasi=array();
                                                                            $include=array();
                                                                            $ar_worktodo=array();
                                                                            $properties_modul=$thepage->properties_modul;
                                                                            $isideklarasi="";
                                                                            $isivarawal="";

                                                                            $incudah=array();
                                                                            $isiinclude="";
                                                                            //echo "nama modul ".$thepage->properties_modul."<BR><BR><BR><BR><BR>";
                                                                            $properties_page=$thepage->properties_page;
                                                                            //echo "nama page ".$properties_page."<BR><BR><BR><BR><BR>";
                                                                            $controller_nickname="controller_".$properties_modul;
                                                                            $page_nickname="page_".$properties_page;
                                                                            $page_name_controller=$page_nickname.$controller_nickname;
                                                                            if(isset($thepage->process) && count($thepage->process)>0){
                                                                            foreach($thepage->process as $pro){
                                                                              $properties_modul=$pro->properties_modul;
                                                                              $properties_page=$pro->properties_page;
                                                                              //  echo $pro->type."<BR>";
                                                                              if(isset($pro->properties_modul)){
                                                                                //echo "nama modul ".$pro->properties_modul."<BR><BR><BR><BR><BR>";
                                                                              }else{
                                                                                //  echo "AAA".$pro->type."<BR><BR><BR>";
                                                                              }
                                                                              $dapetmesin=0;
                                                                              $adaawal="";
                                                                              $adaakhir="";
                                                                              $newcontent="";
                                                                              if(isset($pro->runifnotnull)){
                                                                                if(count($pro->runifnotnull)>0){
                                                                                  $adaawal.='if (';
                                                                                  for($pa=0; $pa<count($pro->runifnotnull); $pa++){
                                                                                    if(!isset($pro->runifnotnull[$pa]->var_type)){
                                                                                      $pro->runifnotnull[$pa]->var_type="variable";
                                                                                    }
                                                                                    $adaawal.=' '.create_variable_web($pro->runifnotnull[$pa]).'!=null';
                                                                                    if($pa+1<count($pro->runifnotnull)){
                                                                                      $adaawal.=' &&';
                                                                                    }
                                                                                  }
                                                                                  $adaawal.='){'."\n";
                                                                                  }
                                                                                }

                                                                                switch($pro->type){
                                                                                  case "url_catcher":
                                                                                  $dapetmesin=1;
                                                                                  if(isset($pro->from_engine) && $pro->from_engine==true){
                                                                                    if(isset($thepage->engine)){
                                                                                      for($eng=0;$eng<count($thepage->engine);$eng++){
                                                                                        if($thepage->engine[$eng]->type=="url_catcher"){
                                                                                          $idxcatch=-1;
                                                                                          for($ca=0; $ca<count($thepage->engine[$eng]->content); $ca++){
                                                                                            if($thepage->engine[$eng]->content[$ca]->id==$pro->id){

                                                                                              $getengine=render_engine("url_catcher",$thepage->engine[$eng]->content[$ca],$pro,null);
                                                                                              $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);
                                                                                              $varjsawal.=$getengine->varjsawal;
                                                                                              $newcontent.=$getengine->content;
                                                                                              //echo "bahan catcher ".$getengine->content."akhir bahan<BR>";
                                                                                              break;
                                                                                            }
                                                                                          }
                                                                                        }
                                                                                      }
                                                                                    }
                                                                                  }else{
                                                                                    $getengine=render_engine("url_catcher",$pro,$pro,null);
                                                                                    $newcontent.=$getengine->content;
                                                                                    $varjsawal.=$getengine->varjsawal;
                                                                                    $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);
                                                                                  }
                                                                                  break;
                                                                                  case "json_to_array":
                                                                                  $dapetmesin=1;
                                                                                  if(isset($pro->from_engine) && $pro->from_engine==true){
                                                                                    if(isset($thepage->engine)){
                                                                                      for($eng=0;$eng<count($thepage->engine);$eng++){
                                                                                        if($thepage->engine[$eng]->type=="json_to_array"){
                                                                                          for($ca=0; $ca<count($thepage->engine[$eng]->content); $ca++){
                                                                                            if($thepage->engine[$eng]->content[$ca]->id==$pro->id){

                                                                                              $theconverter=$thepage->engine[$eng]->content[$ca];
                                                                                              $newcontent.='$'.$theconverter->variable.'=array();'."\n";
                                                                                              $newcontent.='foreach($'.$theconverter->from.' as $key) {'."\n";
                                                                                                $newcontent.='$'.$theconverter->variable.'[$key[\''.$theconverter->index.'\']]=$key[\''.$theconverter->value.'\'];'."\n";
                                                                                                $newcontent.='}'."\n";
                                                                                                $newcontent.='$variables[\''.$theconverter->variable.'\'] = $'.$theconverter->variable.";"."\n";
                                                                                                break;

                                                                                              }
                                                                                            }
                                                                                          }
                                                                                        }
                                                                                      }
                                                                                    }else{
                                                                                      $theconverter=$pro;
                                                                                      $newcontent.='$'.$theconverter->variable.'=array();'."\n";
                                                                                      $newcontent.='foreach($'.$theconverter->from.' as $key) {'."\n";
                                                                                        $newcontent.='$'.$theconverter->variable.'[$key[\''.$theconverter->index.'\']]=$key[\''.$theconverter->value.'\'];'."\n";
                                                                                        $newcontent.='}'."\n";
                                                                                        $newcontent.='$variables[\''.$theconverter->variable.'\'] = $'.$theconverter->variable.";"."\n";

                                                                                      }
                                                                                      break;
                                                                                      case "fileupload":
                                                                                      $dapetmesin=1;
                                                                                      if(isset($pro->from_engine) && $pro->from_engine==true){
                                                                                        if(isset($thepage->engine)){
                                                                                          for($eng=0;$eng<count($thepage->engine);$eng++){
                                                                                            if($thepage->engine[$eng]->type=="fileupload"){
                                                                                              for($ca=0; $ca<count($thepage->engine[$eng]->content); $ca++){
                                                                                                if($thepage->engine[$eng]->content[$ca]->id==$pro->id){
                                                                                                  $f=$thepage->engine[$eng]->content[$ca];
                                                                                                  $getengine=render_engine("fileupload",$f,$pro,$thepage);
                                                                                                  $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);

                                                                                                  for($v=0;$v<count($getengine->varphpawal);$v++){
                                                                                                    $varphpawal[]=$getengine->varphpawal[$v]."\n";
                                                                                                  }
                                                                                                  $newcontent.=$getengine->content."\n";

                                                                                                  break;

                                                                                                }
                                                                                              }
                                                                                            }
                                                                                          }
                                                                                        }
                                                                                      }else{
                                                                                        $getengine=render_engine("fileupload",$pro,$pro,null);
                                                                                        $newcontent.=$getengine->content."\n";
                                                                                        $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);
                                                                                      }
                                                                                      break;
                                                                                      case "file_delete":
                                                                                      $dapetmesin=1;
                                                                                      if(isset($pro->from_engine) && $pro->from_engine==true){
                                                                                        if(isset($thepage->engine)){
                                                                                          for($eng=0;$eng<count($thepage->engine);$eng++){
                                                                                            if($thepage->engine[$eng]->type=="file_delete"){
                                                                                              for($ca=0; $ca<count($thepage->engine[$eng]->content); $ca++){
                                                                                                if($thepage->engine[$eng]->content[$ca]->id==$pro->id){
                                                                                                  $f=$thepage->engine[$eng]->content[$ca];
                                                                                                  $getengine=render_engine("file_delete",$f,$pro,null);
                                                                                                  $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);
                                                                                                  $newcontent.=$getengine->content."\n";
                                                                                                  break;
                                                                                                }
                                                                                              }
                                                                                            }
                                                                                          }
                                                                                        }
                                                                                      }else{
                                                                                        $getengine=render_engine("file_delete",$pro,$pro,null);
                                                                                        $newcontent.=$getengine->content."\n";
                                                                                        $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);
                                                                                      }
                                                                                      break;
                                                                                      case "session":
                                                                                      $dapetmesin=1;
                                                                                      if(isset($pro->from_engine) && $pro->from_engine==true){
                                                                                        if(isset($thepage->engine)){
                                                                                          for($eng=0;$eng<count($thepage->engine);$eng++){
                                                                                            if($thepage->engine[$eng]->type=="session"){
                                                                                              for($ca=0; $ca<count($thepage->engine[$eng]->content); $ca++){
                                                                                                if($thepage->engine[$eng]->content[$ca]->id==$pro->id){
                                                                                                  $f=$thepage->engine[$eng]->content[$ca];
                                                                                                  $getengine=render_engine("session",$f,$pro,null);
                                                                                                  $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);

                                                                                                  $newcontent.=$getengine->content."\n";
                                                                                                  break;
                                                                                                }
                                                                                              }
                                                                                            }
                                                                                          }
                                                                                        }
                                                                                      }else{
                                                                                        $getengine=render_engine("session",$pro,$pro,null);
                                                                                        $newcontent.=$getengine->content."\n";
                                                                                        $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);
                                                                                      }
                                                                                      break;
                                                                                      case "change_page":
                                                                                      $dapetmesin=1;
                                                                                      if(isset($pro->from_engine) && $pro->from_engine==true){
                                                                                        if(isset($thepage->engine)){
                                                                                          for($eng=0;$eng<count($thepage->engine);$eng++){
                                                                                            if($thepage->engine[$eng]->type=="change_page"){
                                                                                              for($ca=0; $ca<count($thepage->engine[$eng]->content); $ca++){
                                                                                                if($thepage->engine[$eng]->content[$ca]->id==$pro->id){
                                                                                                  $f=$thepage->engine[$eng]->content[$ca];
                                                                                                  $getengine=render_engine("change_page",$f,$pro,null);
                                                                                                  $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);
                                                                                                  $newcontent.=$getengine->content."\n";
                                                                                                  break;
                                                                                                }
                                                                                              }
                                                                                            }
                                                                                          }
                                                                                        }
                                                                                      }else{
                                                                                        $getengine=render_engine("change_page",$pro,$pro,null);
                                                                                        $newcontent.=$getengine->content."\n";
                                                                                        $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);
                                                                                      }
                                                                                      break;
                                                                                      case "table":
                                                                                      $dapetmesin=1;
                                                                                      if(isset($pro->from_engine) && $pro->from_engine==true){
                                                                                        if(isset($thepage->engine)){
                                                                                          for($eng=0;$eng<count($thepage->engine);$eng++){
                                                                                            if($thepage->engine[$eng]->type=="table"){
                                                                                              for($ca=0; $ca<count($thepage->engine[$eng]->content); $ca++){
                                                                                                if($thepage->engine[$eng]->content[$ca]->id==$pro->id){
                                                                                                  $f=$thepage->engine[$eng]->content[$ca];
                                                                                                  $getengine=render_engine("table",$f,$pro,null);
                                                                                                  $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);
                                                                                                  for($v=0;$v<count($getengine->include);$v++){
                                                                                                    if(!in_array($getengine->include[$v],$include)){
                                                                                                      $include[]=$getengine->include[$v];
                                                                                                    }
                                                                                                  }
                                                                                                  for($v=0;$v<count($getengine->varphpawal);$v++){
                                                                                                    $varphpawal[]=$getengine->varphpawal[$v]."\n";
                                                                                                  }
                                                                                                  for($v=0;$v<count($getengine->deklarasi);$v++){
                                                                                                    $deklarasi[]=$getengine->deklarasi[$v]."\n";
                                                                                                  }
                                                                                                  $newcontent.=$getengine->content."\n";

                                                                                                  break;
                                                                                                }
                                                                                              }
                                                                                            }
                                                                                          }
                                                                                        }
                                                                                      }else{
                                                                                        $getengine=render_engine("table",$pro,$pro,null);
                                                                                        $newcontent.=$getengine->content."\n";
                                                                                        $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);
                                                                                      }
                                                                                      break;

                                                                                    }

                                                                                    if(isset($pro->runifnotnull)){
                                                                                      if(count($pro->runifnotnull)>0){
                                                                                        $adaakhir.='}'."\n";
                                                                                      }
                                                                                    }

                                                                                    if($dapetmesin==1){

                                                                                      $content.=$adaawal.$newcontent.$adaakhir;
                                                                                      //  echo $content."<BR>";
                                                                                    }

                                                                                    if($pro->type=="url_catcher"){
                                                                                      //echo "catch for function_".$page_name_controller."\n";
                                                                                    }

                                                                                  }
                                                                                  //echo "tipe ".$pro->type.$content."<BR>";
                                                                                  $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"run_process_".$pro->type."_in_function_".$properties_page."_in_".$properties_modul,"function_id"=>"function_".$page_name_controller,"content"=>$content."\n");

                                                                                  //echo "function_id "."function_".$page_name_controller."<BR>";
                                                                                  //  echo "run process "."run_process_".$pro->type."_in_function_".$properties_page."_in_".$properties_modul." content ".$content."<BR>";


                                                                                  for($d=0;$d<count($include);$d++){
                                                                                    if(!in_array($include[$d],$incudah)){
                                                                                      $incudah[]=$include[$d];
                                                                                      $isiinclude.=$include[$d];
                                                                                    }
                                                                                  }

                                                                                  $dekudah=array();
                                                                                  for($d=0;$d<count($deklarasi);$d++){
                                                                                    if(!in_array($deklarasi[$d],$dekudah)){
                                                                                      $dekudah[]=$deklarasi[$d];
                                                                                      $isideklarasi.=$deklarasi[$d];
                                                                                    }
                                                                                  }

                                                                                  $varudah=array();
                                                                                  for($d=0;$d<count($varphpawal);$d++){
                                                                                    if(!in_array($varphpawal[$d],$varudah)){
                                                                                      $varudah[]=$varphpawal[$d];
                                                                                      $isivarawal.=$varphpawal[$d];
                                                                                    }
                                                                                  }

                                                                                  }
                                                                                  $objreturn->content=$content;
                                                                                  $objreturn->varjsawal=$varjsawal;
                                                                                  $objreturn->deklarasi=$isideklarasi;
                                                                                  $objreturn->varphpawal=$isivarawal;
                                                                                  $objreturn->include=$incudah;
                                                                                  $objreturn->ar_worktodo=$ar_worktodo;

                                                                                  return $objreturn;
                                                                                  //akhir render_grup_engine
                                                                                }

                                                                                function render_engine($type,$engine,$pro,$action){
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
                                                                                    case "url_catcher":
                                                                                    $thecatcher=$engine;
                                                                                    $work_id="add_url_catcher_".$thecatcher->variable."_to_function_".$properties_page."_in_".$properties_modul;
                                                                                    $thecontent="";
                                                                                    $thecontent.='$'.$engine->variable.' = null;'."\n";
                                                                                    $thecontent.='for($i=0; $i<count($url_catch); $i++){'."\n";
                                                                                      $thecontent.='if($url_catch[$i]=="'.$thecatcher->catch.'"){'."\n";
                                                                                        $thecontent.='if($i+1<=count($url_catch)){'."\n";
                                                                                          $thecontent.='$'.$thecatcher->variable.' = $url_catch[$i+1];'."\n";
                                                                                          $thecontent.='$variables[\''.$thecatcher->variable.'\'] = $'.$thecatcher->variable.';'."\n";
                                                                                          $thecontent.='}'."\n";
                                                                                          $thecontent.='break;'."\n";
                                                                                          $thecontent.='}'."\n";
                                                                                          $thecontent.='}'."\n";

                                                                                          $content.=$thecontent."\n";

                                                                                          $varjsawal.='var catch_'.$engine->variable.'=<?php print($'.$engine->variable.'); ?>;'."\n";

                                                                                          $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>$work_id,"function_id"=>"function_".$page_name_controller,"content"=>'$url_catch = explode("/",$_SERVER["REQUEST_URI"]);'."\n");

                                                                                          break;
                                                                                          case "table":
                                                                                          $table_action=$engine;
                                                                                          $table_name=$table_action->table_name;
                                                                                          $include[]='include '.'"../mvc_model/model_tabel_'.$table_name.'.php";'."\n";
                                                                                          $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile_tabel_".$table_name,"file_id"=>"tabel_".$table_name,"location"=>"mvc_model/model_tabel_".$table_name.".php","content_from"=>"file","content"=>"file_template/language_php_template_class.php");
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
                                                                                                  $isiparam.=create_variable_web($pro->param[$pa]);
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
                                                                                              $ar_worktodo[]=array("type"=>"addinclude","work_id"=>"include_".$table_name."_to_".$controller_nickname,"file_id"=>$controller_nickname,"include_id"=>$table_name."_in_".$controller_nickname,"content"=>"include \"../mvc_model/model_tabel_".$table_name.".php\";"."\n");
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
                                                                                          case "file_delete":
                                                                                          $content.='if (file_exists($base_upload_directory.'.create_variable_web($engine->file_name).')) {'."\n";
                                                                                            $content.='unlink($base_upload_directory.'.create_variable_web($engine->file_name).');'."\n";
                                                                                            $content.='}'."\n";
                                                                                            break;
                                                                                            case "fileupload":
                                                                                            $varphpawal[]='$data_file_'.$engine->field.'_content = null; '."\n";
                                                                                            $varphpawal[]='$data_file_'.$engine->field.'_filename = null; '."\n";

                                                                                            $bahandeklarasi="";
                                                                                            $bahandeklarasi.='$data_file_'.$engine->field.'_content = null; '."\n";
                                                                                            $bahandeklarasi.='$data_file_'.$engine->field.'_filename = null; '."\n";
                                                                                            $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_fileupload_".$engine->field."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");

                                                                                            $content.='$data_file_'.$engine->field."_content = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', \$".$engine->field."));"."\n";
                                                                                            $filename='$data_file_'.$engine->field."_filename = \"".$engine->file_name."_\".\$base_number_random.\"_\".\$base_date_time.\".$engine->extension\";"."\n";
                                                                                            $content.=$filename;
                                                                                            for ($s=0; $s<count($action->param); $s++){
                                                                                              if(strpos("tes".$filename."tes", '{param_api_'.$action->param[$s]->name."}")){
                                                                                                $content.='$data_file_'.$engine->field.'_filename = str_replace("{param_api_'.$action->param[$s]->name.'}",$param_api_'.$action->param[$s]->name.',$data_file_'.$engine->field.'_filename);'."\n";
                                                                                              }
                                                                                            }
                                                                                            $content.='$data_file_'.$engine->field.'_filename = str_replace(" ","_",$data_file_'.$engine->field.'_filename);'."\n";
                                                                                            $content.='$data_file_'.$engine->field.'_filename = str_replace(":","_",$data_file_'.$engine->field.'_filename);'."\n";
                                                                                            $content.='$data_file_'.$engine->field.'_filename = str_replace("-","_",$data_file_'.$engine->field.'_filename);'."\n";

                                                                                            $content.='file_put_contents($base_upload_directory.$data_file_'.$engine->field.'_filename, $data_file_'.$engine->field.'_content);'."\n";
                                                                                            $content.='$variables[\'data_file_'.$engine->field.'_filename\'] = $data_file_'.$engine->field.'_filename;'."\n";

                                                                                            break;
                                                                                            case "session":


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
                                                                                                      $grupengine=render_grup_engine($engine->ontrue);
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
                                                                                                //render_engine
                                                                                                break;
                                                                                                case "change_page":
                                                                                                $content.='echo "lalalar";'."\n";
                                                                                                break;

                                                                                              }


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
