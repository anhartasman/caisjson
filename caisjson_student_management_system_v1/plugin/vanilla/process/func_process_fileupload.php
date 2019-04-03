<?php
function func_process_fileupload($engine,$pro,$action){
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

  $varphpawal[]='$data_file_'.$engine->field.'_content = null; '."\n";
  $varphpawal[]='$data_file_'.$engine->field.'_filename = null; '."\n";

  $bahandeklarasi="";
  $bahandeklarasi.='$data_file_'.$engine->field.'_content = null; '."\n";
  $bahandeklarasi.='$data_file_'.$engine->field.'_filename = null; '."\n";
  $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_fileupload_".$engine->field."_in_".$page_nickname.$controller_nickname,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");

  $content.='$data_file_'.$engine->field."_content = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', \$".$engine->field."));"."\n";
  $filename='$data_file_'.$engine->field."_filename = \"".$engine->file_name."_\".\$base_number_random.\"_\".\$base_date_time.\".$engine->extension\";"."\n";
  $content.=$filename;
  if(isset($pro->param)){
    for ($s=0; $s<count($pro->param); $s++){
      //echo "ADA ".get_variable_name($pro->param[$s])." \n";
      if(strpos("tes".$filename."tes", '{'.get_variable_name($pro->param[$s])."}")){
        $content.='$data_file_'.$engine->field.'_filename = str_replace("{'.get_variable_name($pro->param[$s]).'}",$'.get_variable_name($pro->param[$s]).',$data_file_'.$engine->field.'_filename);'."\n";
      }
    }
  }else{
    //var_dump($action);
  }
  $content.='$data_file_'.$engine->field.'_filename = str_replace(" ","_",$data_file_'.$engine->field.'_filename);'."\n";
  $content.='$data_file_'.$engine->field.'_filename = str_replace(":","_",$data_file_'.$engine->field.'_filename);'."\n";
  $content.='$data_file_'.$engine->field.'_filename = str_replace("-","_",$data_file_'.$engine->field.'_filename);'."\n";

  $content.='file_put_contents('.create_text_upload_directory().'.$data_file_'.$engine->field.'_filename, $data_file_'.$engine->field.'_content);'."\n";
  $content.='$variables[\'data_file_'.$engine->field.'_filename\'] = $data_file_'.$engine->field.'_filename;'."\n";
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
