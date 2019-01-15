<?php
include ("fungsicreator.php");
include 'koneksiSQL.php';
include 'fungsi.php';
$myfile = fopen("project_manifest.json", "r") or die("Unable to open file!");
$isijson= fread($myfile,filesize("project_manifest.json"));
$manifest = json_decode($isijson); // decode the JSON into an associative array

$copy_baseindexmodul="";
$file = fopen("copy_base/indexmodul.php","r");
while(! feof($file))
  {
  $copy_baseindexmodul.=fgets($file). "<br />";
  }
fclose($file);

$copy_baseheader="";
$file = fopen("copy_base/inc_body_header.php","r");
while(! feof($file))
  {
  $copy_baseheader.=fgets($file). "<br />";
  }
fclose($file);

$copy_basefooter="";
$file = fopen("copy_base/inc_body_footer.php","r");
while(! feof($file))
  {
  $copy_basefooter.=fgets($file). "<br />";
  }
fclose($file);

$copy_basesidetreeview="";
$file = fopen("copy_base/sidemenutreeview.txt","r");
while(! feof($file))
  {
  $copy_basesidetreeview.=fgets($file). "<br />";
  }
fclose($file);

$copy_basesideli="";
$file = fopen("copy_base/sidemenuli.txt","r");
while(! feof($file))
  {
  $copy_basesideli.=fgets($file). "<br />";
  }
fclose($file);

$copy_baseclass="";
$file = fopen("copy_base/class.php","r");
while(! feof($file))
  {
  $copy_baseclass.=fgets($file). "<br />";
  }
fclose($file);

$copy_base_statechanged="";
$file = fopen("copy_jsloop/jsloop_statechanged.txt","r");
while(! feof($file))
  {
  $copy_base_statechanged.=fgets($file). "<br />";
  }
fclose($file);
$copy_base_statechanged=str_replace("<br />","",$copy_base_statechanged);


$system_content="";
for($i=0; $i<count($manifest->global_variables); $i++){
$system_content.=create_web_variable($manifest->global_variables[$i]);
$system_content.='$variables["'.$manifest->global_variables[$i]->name.'"]=$'.$manifest->global_variables[$i]->name.';'."\n";
}
//file_put_contents("admin/"."inc_modul_".$manifest->moduls[$i]->id."_page_".$manifest->moduls[$i]->page[$j]->id.".php",$writemodul);

$config_system_content="";
$file = fopen("copy_base/config_system.php","r");
while(! feof($file))
  {
  $config_system_content.=fgets($file). "<br />";
  }
fclose($file);
$config_system_content=str_replace("<br />","",$config_system_content);
$config_system_content=str_replace("{write}",$system_content,$config_system_content);
file_put_contents("config/system.php",$config_system_content);


$bahansidemenu="";
$butuhjs="";
for($i=0; $i<count($manifest->moduls); $i++){

  $foldermvcview='mvc_view/'.$manifest->moduls[$i]->id;
  $folderlink='admin/'.$manifest->moduls[$i]->id;
  $bahanmenuli="";
  $bahantreeview=$copy_basesidetreeview;
  $myObj= new \stdClass();
  $myObj->place="sidemenu";

  if (!file_exists($foldermvcview)) {
    mkdir($foldermvcview, 0777, true);
  }

    if (in_array($myObj, $manifest->moduls[$i]->placement)){
      for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
        if (in_array($myObj, $manifest->moduls[$i]->page[$j]->placement)){
        $foldermvcviewpage=$foldermvcview.'/'.$manifest->moduls[$i]->page[$j]->id;
        $folderlinkpage=$folderlink.'/'.$manifest->moduls[$i]->page[$j]->id;
        $menuli=$copy_basesideli;
        $menuli=str_replace("{modul_id_page_id}",$manifest->moduls[$i]->id."_".$manifest->moduls[$i]->page[$j]->id,$menuli);
        $menuli=str_replace("{page_url}",$base_url."/".$folderlinkpage,$menuli);
        $menuli=str_replace("{page_title}",$manifest->moduls[$i]->page[$j]->title,$menuli);
        $bahanmenuli.="\n".$menuli;
        }
      }
      $bahantreeview=str_replace("{modul_id}",$manifest->moduls[$i]->id,$bahantreeview);
      $bahantreeview=str_replace("{modul_title}",$manifest->moduls[$i]->title,$bahantreeview);
      $bahantreeview=str_replace("{li}",$bahanmenuli,$bahantreeview);
      $bahansidemenu.="\n".$bahantreeview;
     }

  for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
    $bahanawaljs="";
    $copy_basejs="";
    $bahanawaljs.="var page_id=\"".$manifest->moduls[$i]->page[$j]->id."\";\n";
    $bahanawaljs.="var modul_id=\"".$manifest->moduls[$i]->id."\";\n";

      $foldermvcviewpage=$foldermvcview.'/'.$manifest->moduls[$i]->page[$j]->id;
      if (!file_exists($foldermvcviewpage)) {
        mkdir($foldermvcviewpage, 0777, true);
      }


    $bahanpagecontent="";
    for($e=0; $e<count($manifest->moduls[$i]->page[$j]->elemen); $e++){
      if (file_exists("copy_jsinsert/jsinsert_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt")) {

      $isicopyjs="";
      $file = fopen("copy_jsinsert/jsinsert_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt","r");
      while(! feof($file))
        {
        $isicopyjs.=fgets($file). "<br />";
        }
      fclose($file);
      $copy_basejs.="\n".$isicopyjs;


      }
        if (file_exists("copy_jsloop/jsloop_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt")) {

        $isiloopjs="";
        $file = fopen("copy_jsloop/jsloop_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt","r");
        while(! feof($file))
          {
          $isiloopjs.=fgets($file). "<br />";
          }
        fclose($file);
        $isiloopjs=str_replace("{elemen_id}",$manifest->moduls[$i]->page[$j]->elemen[$e]->id,$isiloopjs);
        $bahanawaljs.="\n".$isiloopjs;


        }

        if (file_exists("copy_elemen/elemen_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt")) {

        $isicontent="";
        $file = fopen("copy_elemen/elemen_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt","r");
        while(! feof($file))
          {
          $isicontent.=fgets($file). "<br />";
          }
        fclose($file);
        $page_elemen=$manifest->moduls[$i]->page[$j]->elemen[$e];
        switch($page_elemen->type){
          case "tabel":
          $bahanth="";
          $bahantd="";
          $bahandropdown="";
          for ($c=0; $c<count($page_elemen->columns); $c++){
            $bahanth.="<th>".$page_elemen->columns[$c]."</th>\n";
            $bahantd.="<td></th>\n";
          }

          //$bahanth.="<th><a href=\"aaa\">AAA</a></th>\n";

        for ($c=0; $c<count($page_elemen->dropdown); $c++){
            $spinner=create_web_element_dropdown($page_elemen->dropdown[$c]);
            $bahandropdown.=$spinner->content."\n";
            $attribute="";

             foreach($page_elemen->dropdown[$c]->attribute as $key=>$value) {
               $attribute.=$key."=\"".$value."\"";
             }
             $bahandropdown=str_replace("{attribute}",$attribute,$bahandropdown);
            $bahanawaljs.="\n".$spinner->js_content;

            //akhir loop dropdown
          }

          $isicontent=str_replace("{list_select}",$bahandropdown,$isicontent);
          $isicontent=str_replace("{list_th}",$bahanth,$isicontent);
          $isicontent=str_replace("{list_td}",$bahantd,$isicontent);
          break;
          case "form":
          $bahanform="";
          $kontenfungsivalidasi="";
          for ($c=0; $c<count($page_elemen->field); $c++){
            //echo $page_elemen->field[$c]->type;

            $field=get_web_field($page_elemen->field[$c]);
            $bahanawaljs.="\n".$field->isijs;
            $bahanform.="\n".$field->isicontent;


            if(isset($page_elemen->field[$c]->validation)){

               foreach($page_elemen->field[$c]->validation as $validate) {

                 $bahanvalidation=bacafile("copy_jsvalidation/jsvalidation_".$validate->type.".html");


                  $bahanvalidation=str_replace("{field_id}",$page_elemen->field[$c]->id,$bahanvalidation);

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
          $fungsivalidasi=bacafile("copy_base/js_validation_function.html");
          $fungsivalidasi=str_replace("{form_id}",$page_elemen->id,$fungsivalidasi);
          $fungsivalidasi=str_replace("{content}",$kontenfungsivalidasi,$fungsivalidasi);

          $bahanawaljs.=$fungsivalidasi;

          $kontenfungsisubmitformjs="";
          $fungsisubmitformjs=bacafile("copy_base/js_form_submit.html");
          $fungsisubmitformjs=str_replace("{form_id}",$page_elemen->id,$fungsisubmitformjs);
          $fungsisubmitformjs=str_replace("{content}",$kontenfungsisubmitformjs,$fungsisubmitformjs);

          $bahanawaljs.=$fungsisubmitformjs;

          $isicontent=str_replace("{bahanform}",$bahanform,$isicontent);


          break;
        }
        for ($c=0; $c<count($page_elemen->onload); $c++){
        $bahanawaljs.=$page_elemen->onload[$c]->func_name."(";

            for ($p=0; $p<count($page_elemen->onload[$c]->param); $p++){
              $bahanawaljs.=$page_elemen->onload[$c]->param[$p];
              if($p<count($page_elemen->onload[$c]->param)-1){
                $bahanawaljs.=",";
              }
            }
            $bahanawaljs.=");\n";

        }

        if(isset($page_elemen->attribute)){
          $bahanattribute="";

           foreach($page_elemen->attribute as $key=>$value) {
             $bahanattribute.=$key."=\"".$value."\"";
           }
        $isicontent=str_replace("{elemen_attribute}",$bahanattribute,$isicontent);
        }
        $isicontent=str_replace("{elemen_id}",$page_elemen->id,$isicontent);
        $isicontent=str_replace("{elemen_title}",$page_elemen->title,$isicontent);
        if(isset($page_elemen->link)){
        $headlink="";
        for ($l=0; $l<count($page_elemen->link->head); $l++){
          $headlink.="<th><a href=\"".$page_elemen->link->head[$l]->href."\">".$page_elemen->link->head[$l]->label."</a></th>\n";
        }
        $isicontent=str_replace("{head_link}",$headlink,$isicontent);
        }
        $bahanpagecontent.="\n".$isicontent;


        }

      //akhir for elemen
    }


    for($f=0; $f<count($manifest->moduls[$i]->page[$j]->functions); $f++){
      $thefunc=$manifest->moduls[$i]->page[$j]->functions[$f];
      $thefunc->modul_id=$manifest->moduls[$i]->id;
      $thefunc->page_id=$manifest->moduls[$i]->page[$j]->id;
      $func=create_web_function($thefunc);
      $func=str_replace("{func_param}","",$func);
      $bahanawaljs.=$func;
    }


    $bahancopy_baseindexmodul=$copy_baseindexmodul;
    $bahancopy_baseindexmodul=str_replace("{modul_id_page_id}",$manifest->moduls[$i]->id."_".$manifest->moduls[$i]->page[$j]->id,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{modul_id}",$manifest->moduls[$i]->id,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{page_name}",$manifest->moduls[$i]->page[$j]->title." | ".$manifest->project_name,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{page_title}",$manifest->moduls[$i]->page[$j]->title,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{page_subtitle}",$manifest->moduls[$i]->page[$j]->subtitle,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{page_content}",$bahanpagecontent,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{footer_js}",$bahanawaljs,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{copy_js}",$copy_basejs,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{modul_title}",$manifest->moduls[$i]->title,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("<br />","",$bahancopy_baseindexmodul);

    file_put_contents($foldermvcviewpage."/index.php",$bahancopy_baseindexmodul);

    $writemodul="<?php"."\n";
    $writemodul.='$main->page_'.$manifest->moduls[$i]->page[$j]->id.'(); '."\n";
    $writemodul.='?> '."\n";
    file_put_contents("admin/"."inc_modul_".$manifest->moduls[$i]->id."_page_".$manifest->moduls[$i]->page[$j]->id.".php",$writemodul);
    //akhir for page
  }

//akhir for modul
}

$dafModul=array();
for($m=0; $m<count($manifest->moduls); $m++){
  $controller_name=$manifest->moduls[$m]->id;
  $dafModul[$m]["controller_name"]=$controller_name;
  $dafModul[$m]["funcs"]=array();
  $write="";
  $include="";
 for($p=0; $p<count($manifest->moduls[$m]->page); $p++){
   $func_name=$manifest->moduls[$m]->page[$p]->id;

   $function_content="";
   $function_content.='$obj_'.$func_name." = new model_".$func_name."();\n";
   $function_content.='$obj_'.$func_name.'->db=$this->db;'."\n";
   $function_content.='$variables=$this->variables;'."\n";
   $function_content.='extract($variables);'."\n";
   $function_content.='$obj_'.$func_name.'->variables=$variables;'."\n";

   $function_content.='include "../mvc_view/'.$controller_name.'/'.$func_name.'/index.php";'."\n";
   $include.='include '.'"../mvc_model/model_'.$func_name.'.php";'."\n";
   $loop_func=get_string_between($copy_baseclass,"{loop_func}","{/loop_func}");
   $loop_func=str_replace("{func_name}","page_".$func_name,$loop_func);
   $loop_func=str_replace("{function_content}",$function_content,$loop_func);
   $loop_func=str_replace("<br />","",$loop_func);
   $write.=$loop_func."\n";
   $writemodel_function="";

       $function_content="";
       $model_content=$copy_baseclass;
       $model_content=str_replace("{write}",$writemodel_function,$model_content);
       $model_content=str_replace("{model_name}","model_".$func_name,$model_content);
       $model_content=str_replace("{construct_content}","",$model_content);
       $model_content=str_replace("{function_content}",$function_content,$model_content);
       $model_content=str_replace("{include}","",$model_content);
       $model_content=str_replace("<br />","",$model_content);
       file_put_contents("mvc_model/"."model_".$func_name.".php",$model_content);


 }
    $construct_content="";

    $model_content=$copy_baseclass;
    $model_content=str_replace("{write}",$write,$model_content);
    $model_content=str_replace("{model_name}","controller_".$controller_name,$model_content);
    $model_content=str_replace("{construct_content}",$construct_content,$model_content);
    $model_content=str_replace("{include}",$include,$model_content);
    $model_content=str_replace("<br />","",$model_content);
    file_put_contents("mvc_controller/"."controller_".$controller_name.".php",$model_content);

//akhir loop moduls
}

$ar_table=new \stdClass();
$ar_table_name=array();
        for($d=0; $d<count($manifest->daf_api); $d++){
          $controller_name=$manifest->daf_api[$d]->modul;
          $controller_content="";
          $construct_content="";
          $include="";
         for($act=0; $act<count($manifest->daf_api[$d]->action); $act++){

            $loop_func=get_string_between($copy_baseclass,"{loop_func}","{/loop_func}");
            $func_name=$manifest->daf_api[$d]->action[$act]->action;
            $loop_func=str_replace("{func_name}","page_".$func_name,$loop_func);
            $loop_func=str_replace("<br />","",$loop_func);
            $function_content="";

            switch($table_name=$manifest->daf_api[$d]->action[$act]->type){
              case "read_table":

                $table_name=$manifest->daf_api[$d]->action[$act]->table->table_name;
                $include.='include '.'"../mvc_model/model_tabel_'.$table_name.'.php";'."\n";

                if (!in_array($table_name, $ar_table_name)){
                  $ar_table_name[]=$table_name;

                  $ar_table->$table_name= new \stdClass();
                  $ar_table->$table_name->table_name=$table_name;

                  $bahanapi= new \stdClass();

                  $bahanapi->column=array();
                  $bahanapi->func_name="";
                  $bahanapi->table=$manifest->daf_api[$d]->action[$act]->table;
                  $bahanapi->api_type=$table_name=$manifest->daf_api[$d]->action[$act]->type;
                  $bahanapi->action=$manifest->daf_api[$d]->action[$act];

                  $ar_table->$table_name->api_array=[$bahanapi];
                }
                $model_func_name="getDataForModul_".$controller_name."_Action_".$func_name;
                $ar_table->$table_name->func_name=$model_func_name;

                $function_content.='$obj_'.$table_name." = new model_tabel_".$table_name."();\n";
                $function_content.='$obj_'.$table_name.'->db=$this->db;'."\n";
                $function_content.='$variables=$this->variables;'."\n";
                $function_content.='extract($variables);'."\n";
                $function_content.='$obj_'.$table_name.'->variables=$variables;'."\n";
                $function_content.='$obj_'.$table_name.'->'.$model_func_name.'();'."\n";
                //$function_content.='include "../mvc_view/'.$controller_name.'/'.$func_name.'/index.php";'."\n";

                $function_content.="\n";
                //akhir read_table
              break;
              case "manage_table":

                 for($t=0; $t<count($manifest->daf_api[$d]->action[$act]->table); $t++){
                   $table_action=$manifest->daf_api[$d]->action[$act]->table[$t];
                   $table_name=$table_action->table_name;

                   if (!in_array($table_name, $ar_table_name)){
                     $ar_table_name[]=$table_name;

                     $ar_table->$table_name= new \stdClass();
                     $ar_table->$table_name->table_name=$table_name;

                     $bahanapi= new \stdClass();

                     $bahanapi->column=array();
                     $bahanapi->func_name="";
                     $bahanapi->table=$table_action;
                     $bahanapi->api_type=$table_name=$manifest->daf_api[$d]->action[$act]->type;
                     $bahanapi->action=$manifest->daf_api[$d]->action[$act];

                     $ar_table->$table_name->api_array=[$bahanapi];

                   }

                   $model_func_name="manage".$table_action->process_name."DataForModul_".$controller_name."_Action_".$func_name;
                   $ar_table->$table_name->func_name=$model_func_name;
/**
                   $function_content.='$obj_'.$table_name." = new model_tabel_".$table_name."();\n";
                   $function_content.='$obj_'.$table_name.'->db=$this->db;'."\n";
                   $function_content.='$variables=$this->variables;'."\n";
                   $function_content.='extract($variables);'."\n";
                   $function_content.='$obj_'.$table_name.'->variables=$variables;'."\n";
                   $function_content.='$obj_'.$table_name.'->'.$model_func_name.'();'."\n";
                   //$function_content.='include "../mvc_view/'.$controller_name.'/'.$func_name.'/index.php";'."\n";
**/
                   $function_content.="\n";

                 }

              break;
            }

            $loop_func=str_replace("{function_content}",$function_content,$loop_func);

            $controller_content.=$loop_func."\n";

            $writemodul="<?php"."\n";
            $writemodul.='$main->page_'.$func_name.'(); '."\n";
            $writemodul.='?> '."\n";
            file_put_contents("API/"."inc_modul_".$controller_name."_page_".$func_name.".php",$writemodul);


          }

          $model_content=$copy_baseclass;
          $model_content=str_replace("{write}",$controller_content,$model_content);
          $model_content=str_replace("{model_name}","controller_".$controller_name,$model_content);
          $model_content=str_replace("{construct_content}",$construct_content,$model_content);
          $model_content=str_replace("{include}",$include,$model_content);
          $model_content=str_replace("<br />","",$model_content);

          file_put_contents("mvc_controller/"."controller_".$controller_name.".php",$model_content);
        //akhir loop daf_api
      }

   for($t=0; $t<count($ar_table_name); $t++){
     $table_content="";
     $construct_content="";
     $table_include="";
     $table_name=$ar_table_name[$t];
     $apifunction_content='$variables=$this->variables;'."\n";
     $apifunction_content.='$db=$this->db;'."\n";
     $apifunction_content.='extract($variables);'."\n";
     $apifunction_content.='$prosesapi=1;'."\n";
     $apifunction_content.='$error_code="000";'."\n";
     $apifunction_content.='$error_msg="";'."\n";
     $apifunction_content.='$response_data="";'."\n";
     $apifunction_content.='$returnAPI=array();'."\n\n";
     $apifunction_content.=get_web_check_apiparam("modul")."\n";
     $apifunction_content.=get_web_check_apiparam("action")."\n";
        for($f=0; $f<count($ar_table->$table_name->action->param); $f++){

          $apifunction_content.=get_web_check_apiparam($ar_table->$table_name->action->param[$f])."\n";

        }
     $apifunction_content.='if ($prosesapi==1){'."\n";
     $apifunction_content.='{api_process_content}'."\n";
     $apifunction_content.='}'."\n\n";
     $apifunction_content.='$returnAPI[\'error_code\']=$error_code;'."\n";
     $apifunction_content.='$returnAPI[\'error_msg\']=$error_msg;'."\n";
     $apifunction_content.='$returnAPI["response_data"]=$response_data;'."\n";
     $apifunction_content.='$hasil=json_encode($returnAPI);'."\n";
     $apifunction_content.='echo $hasil;'."\n";

     $api_process_content='$response_data;'."\n";
     $api_process_content.='$query='.get_web_database_query($ar_table->$table_name->table);
     if(isset($ar_table->$table_name->action->special)){
       if($ar_table->$table_name->action->special=="table_content"){
         /**
         $api_process_content.='if(isset($obj->table_modul) && isset($obj->table_page)){'."\n";
         $api_process_content.='if(isset($obj->table_id)){'."\n";
         $api_process_content.='switch($obj->table_id){'."\n";

              for($f=0; $f<count($ar_table->$table_name->action->param); $f++){
              }

         $api_process_content.='for($i=0;$i<count($bahanreturn);$i++){'."\n";
         $api_process_content.='}'."\n";
         $api_process_content.='}'."\n";
         $api_process_content.='}'."\n";
         $api_process_content.='}'."\n";//terusin
         **/
         $api_process_content.='$response_data=$bahanreturn;'."\n";
       }else if($ar_table->$table_name->action->special=="dropdown_content"){
         $api_process_content.='$dropdown_content="<option value=\'-1\'>- select -</option>";'."\n";
         $api_process_content.='foreach($bahanreturn as $q){'."\n";
         $api_process_content.='$dropdown_content.="<option value=\'".$q[0]."\'>".$q[1]."</option>";'."\n";
         $api_process_content.='}'."\n";
         $api_process_content.='$response_data=$dropdown_content;'."\n";
       }
     }
     $api_process_content.="\n";

     $apifunction_content=str_replace("{api_process_content}",$api_process_content,$apifunction_content);

          $loop_func=get_string_between($copy_baseclass,"{loop_func}","{/loop_func}");
          $func_name=$ar_table->$table_name->func_name;
          $loop_func=str_replace("{func_name}",$func_name,$loop_func);
          $loop_func=str_replace("{function_content}",$apifunction_content,$loop_func);
          $loop_func=str_replace("<br />","",$loop_func);
          $table_content.=$loop_func."\n\n";


     $model_content=$copy_baseclass;
     $model_content=str_replace("{write}",$table_content,$model_content);
     $model_content=str_replace("{model_name}","model_tabel_".$table_name,$model_content);
     $model_content=str_replace("{construct_content}",$construct_content,$model_content);
     $model_content=str_replace("{include}",$table_include,$model_content);
     $model_content=str_replace("<br />","",$model_content);

     file_put_contents("mvc_model/"."model_tabel_".$table_name.".php",$model_content);

   }


$copy_baseheader=str_replace("{sidemenu}",$bahansidemenu,$copy_baseheader);
$copy_baseheader=str_replace("<br />","",$copy_baseheader);

file_put_contents("inc_body_header.php",$copy_baseheader);

$copy_basefooter=str_replace("{js_functions}","",$copy_basefooter);
$copy_basefooter=str_replace("{copy_js}","",$copy_basefooter);
$copy_basefooter=str_replace("<br />","",$copy_basefooter);
file_put_contents("inc_body_footer.php",$copy_basefooter);


 ?>
