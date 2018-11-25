<?php
function makePHP($manifest){
include 'helper_makephp.php';
$theconfig=null;
for($j=0; $j<count($manifest->project_config); $j++){
  if($manifest->project_config[$j]->config_type=="web"){
  $theconfig=$manifest->project_config[$j];
  break;
  }
}

$libraries_warehouse=array(
  "library_web_css"
  ,"library_web_js"
);

$filedirection=$theconfig->web_localpath;

$base_url=$theconfig->web_url;

$ar_worktodo=array();
$copy_baseheader=bacafile($filedirection."copy_base/inc_body_header.php");
$copy_basefooter=bacafile($filedirection."copy_base/inc_body_footer.php");
$copy_basesidetreeview=bacafile($filedirection."copy_base/sidemenutreeview.txt");
$copy_basesideli=bacafile($filedirection."copy_base/sidemenuli.txt");
$copy_baseclass=bacafile($filedirection."copy_base/class.php");
$copy_base_statechanged=bacafile($filedirection."copy_jsloop/jsloop_statechanged.txt");
$copy_base_statechanged=str_replace("<br />","",$copy_base_statechanged);


$system_content="";
for($i=0; $i<count($manifest->global_variables); $i++){
$system_content.=create_web_variable($manifest->global_variables[$i]);
$system_content.='$variables["'.$manifest->global_variables[$i]->name.'"]=$'.$manifest->global_variables[$i]->name.';'."\n";
}
//file_put_contents("admin/"."inc_modul_".$manifest->moduls[$i]->id."_page_".$manifest->moduls[$i]->page[$j]->id.".php",$writemodul);

$config_system_content=bacafile($filedirection."copy_base/config_variables.php");
$config_system_content=str_replace("<br />","",$config_system_content);
$config_system_content=str_replace("{write}",$system_content,$config_system_content);
$ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileutilvariables","file_id"=>"fileutilvariables","location"=>"utils/variables.php","content_from"=>"string","content"=>$config_system_content);

$config_system_content=bacafile($filedirection."copy_base/config_system.php");
$config_system_content=str_replace("<br />","",$config_system_content);
$config_system_content=str_replace("{write}",$system_content,$config_system_content);
$ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileconfig_system","file_id"=>"config_system","location"=>"config/system.php","content_from"=>"string","content"=>$config_system_content);

$config_system_content=bacafile($filedirection."copy_base/config_database.php");
$config_system_content=str_replace("<br />","",$config_system_content);
$config_system_content=str_replace("{database_host}",$theconfig->database_host,$config_system_content);
$config_system_content=str_replace("{database_name}",$theconfig->database_name,$config_system_content);
$config_system_content=str_replace("{database_username}",$theconfig->database_username,$config_system_content);
$config_system_content=str_replace("{database_password}",$theconfig->database_password,$config_system_content);
$ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileconfig_database","file_id"=>"config_database","location"=>"config/database.php","content_from"=>"string","content"=>$config_system_content);

$config_system_content=bacafile($filedirection."copy_base/config_htaccess_admin.php");
$config_system_content=str_replace("<br />","",$config_system_content);
$config_system_content=str_replace("{write}",$system_content,$config_system_content);
$ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileconfig_htaccess_admin","file_id"=>"config_htaccess_admin","location"=>"admin/.htaccess","content_from"=>"string","content"=>$config_system_content);

$config_system_content=bacafile($filedirection."copy_base/config_htaccess_api.php");
$config_system_content=str_replace("<br />","",$config_system_content);
$config_system_content=str_replace("{write}",$system_content,$config_system_content);
$ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileconfig_htaccess_api","file_id"=>"config_htaccess_api","location"=>"API/.htaccess","content_from"=>"string","content"=>$config_system_content);


$bahansidemenu="";

  $daf_stringinclude=rekursifcekinclude($manifest,"");
//echo "DAF STRING INCLUDE ".count($daf_stringinclude);
$tulisanmanifest=json_encode($manifest);
for($i=0; $i<count($daf_stringinclude); $i++){
  $tulisanmanifest=str_replace($daf_stringinclude[$i]["from"],$daf_stringinclude[$i]["to"],$tulisanmanifest);
}

$manifest=json_decode($tulisanmanifest);

for($i=0; $i<count($manifest->moduls); $i++){

  $controller_name=$manifest->moduls[$i]->id;
    for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
    $thepage=$manifest->moduls[$i]->page[$j];
      $thepage->properties_modul=$controller_name;
        $thepage->properties_page=$thepage->id;
    $func_name=$thepage->id;

      foreach($thepage as $category){
        if(is_array($category)){
          rekursifmodulpage($category,$controller_name,$func_name,"web");
        }else if (is_object($category)) {
          $category->properties_modul=$controller_name;
          $category->properties_page=$thepage->properties_page;
            rekursifmodulpage($category,$controller_name,$func_name,"web");
        }else{
          //echo $category;
          //$category->properties_modul="NAMA MODUL";
        }
      }

    }

}

        for($d=0; $d<count($manifest->daf_api); $d++){
          $manifest->daf_api[$d]->modul=$manifest->daf_api[$d]->modul;
          $controller_name=$manifest->daf_api[$d]->modul;
         for($act=0; $act<count($manifest->daf_api[$d]->action); $act++){
            $action=$manifest->daf_api[$d]->action[$act];
            $action->properties_modul=$controller_name;
            $action->properties_page=$action->action;
            //echo "properties_page : ".$action->properties_page."<BR>";
            $func_name=$action->action;

            foreach($action as $category){
              if(is_array($category)){
                rekursifmodulpage($category,$controller_name,$func_name,"web");
              }else if (is_object($category)) {
                $category->properties_modul=$controller_name;
                $category->properties_page=$action->properties_page;
                  rekursifmodulpage($category,$controller_name,$func_name,"web");
              }else{
                //echo $category;
                //$category->properties_modul="NAMA MODUL";
              }
            }

          }
        }


                    for($i=0; $i<count($manifest->moduls); $i++){

                      $controller_name=$manifest->moduls[$i]->id;
                      //echo "controller ".$controller_name."<BR>";
                      $controller_nickname="controller_".$controller_name;
                      $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile".$controller_nickname,"file_id"=>$controller_nickname,"location"=>"mvc_controller/".$controller_nickname.".php","content_from"=>"file","content"=>"file_template/language_php_template_class.php");
                        for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
                        $thepage=$manifest->moduls[$i]->page[$j];
                        $page_name=$thepage->id;
                        $page_nickname="page_".$page_name;
                        $page_name_controller=$page_nickname.$controller_nickname;
                        $page_nickname="page_".$page_name;
                        $page_name_controller=$page_nickname.$controller_nickname;

                        $auth_content="";
                        $ada_auth=0;
                        for($a=0; $a<count($manifest->auth);$a++){
                          if($manifest->auth[$a]->moduls==$controller_name){
                            if(in_array($page_name,$manifest->auth[$a]->pages)){

                              $ada_auth=1;
                              $objchecksession=new \stdClass();
                              $objchecksession->type="group";
                              $objchecksession->operator="and";
                              $objchecksession->content=$manifest->auth[$a]->allow;

                              $thegroup=create_booleancheck_web($objchecksession);
                              $auth_content.="if (".$thegroup->isset_content."){"."\n";
                              $auth_content.="if (".$thegroup->comparing_content."){"."\n";

                            }

                          }
                        }

                        if($ada_auth==1){
                          $auth_footer="}\n}";
                        $ar_worktodo[]=array("type"=>"add_auth","work_id"=>"add_auth_to".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>$auth_content."\n","content_footer"=>$auth_footer."\n");
                        }

                        $ar_worktodo[]=array("type"=>"addinclude","work_id"=>"include_".$page_nickname."_to_".$controller_nickname,"file_id"=>$controller_nickname,"include_id"=>$page_nickname,"content"=>"include \"../mvc_model/model_".$page_nickname.".php\";"."\n");
                        $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"function_name"=>$page_nickname,"param"=>array(),"file_id"=>$controller_nickname);
                        $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile".$page_nickname,"file_id"=>$page_nickname,"location"=>"mvc_model/model_".$page_nickname.".php","content_from"=>"file","content"=>"file_template/language_php_template_class.php");

                        $bahandeklarasi='$obj_'.$page_name." = new model_page_".$page_name."();\n";
                        $bahandeklarasi.='$obj_'.$page_name.'->db=$this->db;'."\n";
                        $bahandeklarasi.='$variables=$this->variables;'."\n";
                        $bahandeklarasi.='extract($variables);'."\n";

                        $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_themodelof_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");
                        $firstfooter_content='include "../mvc_view/'.$controller_name.'/'.$page_name.'/index.php";'."\n";
                        $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"deklarasipreparefooter_themodelof_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>'$obj_'.$page_name.'->variables=$variables;');
                        $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"deklarasifooter_themodelof_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>$firstfooter_content."\n");

                          foreach($thepage as $key=>$category){
                            if(is_array($category)){
                            //echo $key."<BR>";
                                                $ar_worktodo=array_merge($ar_worktodo,renderwhattodo($key,$category,$thepage));
                              $ar_worktodo=array_merge($ar_worktodo,rekursifprosesmodulpage($category,$controller_name,$page_name));
                            }else if (is_object($category)) {
                            //echo $key."<BR>";
                              $ar_worktodo=array_merge($ar_worktodo,renderwhattodo($key,$category,$thepage));
                                $ar_worktodo=array_merge($ar_worktodo,rekursifprosesmodulpage($category,$controller_name,$page_name));
                            }else{
                            }
                          }

                        }

                    }

                    for($d=0; $d<count($manifest->daf_api); $d++){
                      $controller_name=$manifest->daf_api[$d]->modul;
                      if(!isset($manifest->daf_api[$d]->ignore)){
                        $manifest->daf_api[$d]->ignore=false;
                      }
                      //echo "controller ".$controller_name."<BR>";
                      //var_dump($manifest->daf_api[$d])."<BR>";
                      if(!$manifest->daf_api[$d]->ignore){
                      $controller_nickname="controller_".$controller_name;
                      $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile".$controller_nickname,"file_id"=>$controller_nickname,"location"=>"mvc_controller/".$controller_nickname.".php","content_from"=>"file","content"=>"file_template/language_php_template_class.php");
                      for($act=0; $act<count($manifest->daf_api[$d]->action); $act++){
                        $action=$manifest->daf_api[$d]->action[$act];
                        $func_name=$action->action;
                        //echo "page api ".$controller_name."<BR>";


                                    $dafVariable=array();

                                    if(isset($action->process)){

                                      foreach($action->process as $pro){

                                          if(isset($pro->outputVariable)){
                                          $dafVariable[]=$pro->outputVariable;
                                          }
                                          switch($pro->type){
                                            case "table":


                                                       if(isset($action->engine)){
                                                         for($eng=0;$eng<count($action->engine);$eng++){
                                                           if($action->engine[$eng]->type=="table"){

                                                             for($ca=0; $ca<count($action->engine[$eng]->content); $ca++){
                                                               if($action->engine[$eng]->content[$ca]->id==$pro->id){
                                                                 $table_action=$action->engine[$eng]->content[$ca];
                                                                 if($table_action!=null){
                                                                 $dafVariable[]=$table_action->outputVariable;
                                                                 }
                                                                 break;
                                                               }
                                                             }

                                                           }
                                                         }
                                                       }

                                            break;
                                          }
                                      }

                                      //akhir isset proses
                                    }


                        $page_nickname="page_".$func_name;
                        $page_name_controller=$page_nickname.$controller_nickname;
                        //echo "page name controller ".$page_name_controller."<BR>";
                        //$ar_worktodo[]=array("type"=>"addinclude","work_id"=>"include_".$page_nickname."_to_".$controller_nickname,"file_id"=>$controller_nickname,"include_id"=>$page_nickname,"content"=>"include \"../mvc_model/model_".$page_nickname.".php\";"."\n");
                        $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"function_name"=>$page_nickname,"param"=>array(),"file_id"=>$controller_nickname);
                        $bahandeklarasiapi="";
                        $varphpawal="";
                        $bahandeklarasiapi.='$variables=$this->variables;'."\n";
                        $bahandeklarasiapi.='extract($variables);'."\n";
                        $bahandeklarasiapi.='$prosesapi=1;'."\n";
                        $bahandeklarasiapi.='$error_code="000";'."\n";
                        $bahandeklarasiapi.='$error_msg="";'."\n";
                        $bahandeklarasiapi.='$response_data="";'."\n";
                        $bahandeklarasiapi.='$returnAPI=array();'."\n\n";
                        $bahandeklarasiapi.="{varphpawal}"."\n";
                        $cekmodul=get_web_check_apiparam("modul",true);
                        $cekaction=get_web_check_apiparam("action",true);
                        $varphpawal.=$cekmodul->varphpawal."\n";
                        $varphpawal.=$cekaction->varphpawal."\n";
                        $bahandeklarasiapi.=$cekmodul->content."\n";
                        $bahandeklarasiapi.=$cekaction->content."\n";
                           for($f=0; $f<count($action->param); $f++){
                             if(!isset($action->param[$f]->mandatory)){
                               $action->param[$f]->mandatory=false;
                             }
                             $cekparam=get_web_check_apiparam($action->param[$f]->name,$action->param[$f]->mandatory);
                             $varphpawal.=$cekparam->varphpawal."\n";
                             $bahandeklarasiapi.=$cekparam->content."\n";

                           }
                       $bahandeklarasiapi=str_replace("{varphpawal}",$varphpawal,$bahandeklarasiapi);

                        $bahandeklarasiapi.='if ($prosesapi==1){'."\n";
                        $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_themodelof_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasiapi."\n");


                        $bahanfooter='$bahan_respon = "'.$action->response_output."\";"."\n";
                        foreach($dafVariable as $a) {
                          if(strpos("tes".$action->response_output."tes","{".$a."}")){
                          $bahanfooter.='$bahan_respon=str_replace("{'.$a.'}",$'.$a.',$bahan_respon);'."\n";
                          }
                         }
                        if(isset($action->response_type)){
                          switch($action->response_type){
                            case "json":

                            if(isset($action->json_encode) && $action->json_encode){
                              $bahanfooter.='$response_data = json_decode(json_encode($bahan_respon))'.";"."\n";
                            }else{
                            $bahanfooter.='$response_data = json_decode($bahan_respon)'.";"."\n";
                          }
                            break;
                            case "text":
                            $bahanfooter.='$response_data = $bahan_respon'.";"."\n";
                            break;
                          }
                        }else{
                        $bahanfooter.='$response_data = $bahan_respon'.";"."\n";
                        }

                        $bahanfooter.='}'."\n\n";
                        $bahanfooter.='$returnAPI[\'error_code\']=$error_code;'."\n";
                        $bahanfooter.='$returnAPI[\'error_msg\']=$error_msg;'."\n";
                        $bahanfooter.='$returnAPI["response_data"]=$response_data;'."\n";
                        $bahanfooter.='$hasil=json_encode($returnAPI);'."\n";
                        $bahanfooter.='echo $hasil;'."\n";
                        $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"deklarasi_footer_of_modelof_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>$bahanfooter."\n");

                        //$ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile".$page_nickname,"file_id"=>$page_nickname,"location"=>"mvc_model/model_".$page_nickname.".php");

                        foreach($action as $key=>$category){
                          if(is_array($category)){
                          //echo $key."<BR>";
                            $ar_worktodo=array_merge($ar_worktodo,renderwhattodo($key,$category,$action));
                            $ar_worktodo=array_merge($ar_worktodo,rekursifprosesmodulpage($category,$controller_name,$func_name));
                          }else if (is_object($category)) {
                          //echo $key."<BR>";
                            $ar_worktodo=array_merge($ar_worktodo,renderwhattodo($key,$category,$action));
                            $ar_worktodo=array_merge($ar_worktodo,rekursifprosesmodulpage($category,$controller_name,$func_name));
                          }else{
                          }
                        }

                       $writemodul="<?php"."\n";
                       $writemodul.='$main->page_'.$func_name.'(); '."\n";
                       $writemodul.='?> '."\n";
                       $foldermodul="API/"."inc_modul_".$controller_name."_page_".$func_name.".php";

                       $ar_worktodo[]=array("type"=>"addfile","work_id"=>"writefiletomodul".$foldermodul,"file_id"=>$foldermodul,"location"=>$foldermodul,"content_from"=>"string","content"=>$writemodul);
                      }
                      }
                      //akhir daf_api
                    }

        //var_dump($manifest);

        for($i=0; $i<count($manifest->moduls); $i++){

          $controller_name=$manifest->moduls[$i]->id;
          $controller_nickname="controller_".$controller_name;
          $foldermvcview='mvc_view/'.$controller_name;
          $folderlink='admin/'.$controller_name;
          $bahanmenuli="";
          $bahantreeview=$copy_basesidetreeview;
          $myObj= new \stdClass();
          $myObj->place="sidemenu";

        /**
          if (!file_exists($foldermvcview)) {
            mkdir($foldermvcview, 0777, true);
          }
          **/
          //echo "place ";
          $ar_worktodo[]=array("type"=>"makedirectory","work_id"=>"makedirectorymvcview".$controller_name,"directory_id"=>$foldermvcview,"location"=>$foldermvcview);

          //  if (in_array($myObj, $manifest->moduls[$i]->placement)){
              //echo "modul_title ".$manifest->moduls[$i]->title."<BR>";
              //echo "CETAAK".var_dump($manifest->moduls[$i]->page[$j]->placement)."<BR>";
              for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
              //  echo "CETAAK".$manifest->moduls[$i]->page[$j]->id."<BR>";
              //    var_dump($manifest->moduls[$i]->page[$j]->placement)."<BR>";

                  $gotplace=0;
                  for($pl=0;$pl<count($manifest->moduls[$i]->page[$j]->placement);$pl++){
                    echo "place ".$manifest->moduls[$i]->page[$j]->placement[$pl]->place."\n";
                    if($manifest->moduls[$i]->page[$j]->placement[$pl]->place=="sidemenu"){
                      $gotplace=1;
                    }
                  }
                if ($gotplace==1){
                //echo "ADA SIDEMENU<BR>";
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
             //}

          for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
            if(!isset($manifest->moduls[$i]->page[$j]->ignore)){
              $manifest->moduls[$i]->page[$j]->ignore=false;
            }
            if($manifest->moduls[$i]->page[$j]->ignore==false){

            if(!isset($manifest->moduls[$i]->page[$j]->frame)){
              $manifest->moduls[$i]->page[$j]->frame="adminpage";
            }

            $bahanawaljs="";
            $variabeljsawal="";
            $copy_basejs="";
            $arlibcss=array();
            $arlibs=array();
            //$isicopy_basecss='$copy_basecss=array();'."\n";
            $isicopy_baselanguage=array();
            for($lib=0; $lib<count($manifest->libraries); $lib++){
              $thelib=$manifest->libraries[$lib];
              //var_dump($thelib);
              $isicopy_baselanguage[$thelib->language]='$copy_base_language_'.$thelib->language.'=array();'."\n";
            }
            $thepage=$manifest->moduls[$i]->page[$j];
            $func_name=$thepage->id;
            $page_name=$thepage->id;
            $page_nickname="page_".$page_name;
            $page_name_controller=$page_nickname.$controller_nickname;


            $variabeljsawal.="var page_id=\"".$manifest->moduls[$i]->page[$j]->id."\";\n";
            $variabeljsawal.="var modul_id=\"".$manifest->moduls[$i]->id."\";\n";

              $foldermvcviewpage=$foldermvcview.'/'.$manifest->moduls[$i]->page[$j]->id;

              /**
              if (!file_exists($foldermvcviewpage)) {
                mkdir($foldermvcviewpage, 0777, true);
              }
              **/
              $ar_worktodo[]=array("type"=>"makedirectory","work_id"=>"makedirectorymvcview".$page_name_controller,"directory_id"=>$page_name_controller,"location"=>$foldermvcviewpage);


              if(isset($thepage->process)){

                $grupengine=render_grup_engine($thepage);
                $variabeljsawal.=$grupengine->varjsawal;
                //akhir isset proses
              }

            $bahanpagecontent="";
            for($e=0; $e<count($manifest->moduls[$i]->page[$j]->elemen); $e++){
              if (file_exists($filedirection."copy_jsinsert/jsinsert_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt")) {

              $isicopyjs=bacafile($filedirection."copy_jsinsert/jsinsert_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt");
              //echo $isicopyjs;
              $copy_basejs.="\n".$isicopyjs;


            }
            if(isset($manifest->moduls[$i]->page[$j]->elemen[$e]->forms)){

              for($fm=0; $fm<count($manifest->moduls[$i]->page[$j]->elemen[$e]->forms); $fm++){
                    for($fmf=0; $fmf<count($manifest->moduls[$i]->page[$j]->elemen[$e]->forms[$fm]->field); $fmf++){
                      $thefield=$manifest->moduls[$i]->page[$j]->elemen[$e]->forms[$fm]->field[$fmf];

                      for($lib=0; $lib<count($manifest->libraries); $lib++){
                        $thelib=$manifest->libraries[$lib];
                        for($l=0; $l<count($thelib->libraries); $l++){
                          $thelibrary=$thelib->libraries[$l];
                          if (!in_array($thelib->language.$thelibrary->type, $arlibs)){
                          if($thelibrary->type=="field_".$thefield->type){
                            $isicopy_baselanguage[$thelib->language].='$copy_base_language_'.$thelib->language.'[]=array("name"=>"'.$thelibrary->name.'","path"=>"'.$thelibrary->path.'");'."\n";
                            $arlibs[]=$thelib->language.$thelibrary->type;
                          }
                          }
                        }
                      }
                      /**
                          if (!in_array($thefield->type, $arlibcss)){
                          for($lib=0; $lib<count($manifest->library_web_css); $lib++){
                            if($manifest->library_web_css[$lib]->type=="field_".$thefield->type){
                              $isicopy_basecss.='$copy_basecss[]=array("name"=>"'.$manifest->library_web_css[$lib]->name.'","path"=>"'.$manifest->library_web_css[$lib]->path.'");'."\n";
                              $arlibcss[]=$thefield->type;

                              }
                            }
                          }
                          **/
                if (file_exists($filedirection."copy_jsinsertlibrary_formfield/jsformfield_".$thefield->type.".txt")) {
                $isiloopjs=bacafile($filedirection."copy_jsinsertlibrary_formfield/jsformfield_".$thefield->type.".txt");
                $copy_basejs.="\n".$isiloopjs;
                }else{
                  //echo "tak ada "."copy_jsloop/jsloop_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt";
                }


                }

              }

            }
                if (file_exists($filedirection."copy_jsloop/jsloop_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt")) {
                $isiloopjs=bacafile($filedirection."copy_jsloop/jsloop_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt");
                $isiloopjs=str_replace("{elemen_id}",$manifest->moduls[$i]->page[$j]->elemen[$e]->id,$isiloopjs);
                $bahanawaljs.="\n".$isiloopjs;


                }else{
                  //echo "tak ada "."copy_jsloop/jsloop_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt";
                }

                if (file_exists($filedirection."copy_elemen/elemen_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt")) {

                $isicontent=bacafile($filedirection."copy_elemen/elemen_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt");
                $page_elemen=$manifest->moduls[$i]->page[$j]->elemen[$e];
                switch($page_elemen->type){
                  case "tabel":
                  $bahanth="";
                  $bahantd="";
                  for ($c=0; $c<count($page_elemen->columns); $c++){
                    $bahanth.="<th>".$page_elemen->columns[$c]."</th>\n";
                    $bahantd.="<td></th>\n";
                  }

                  //$bahanth.="<th><a href=\"aaa\">AAA</a></th>\n";

                $isicontent=str_replace("{list_th}",$bahanth,$isicontent);
                  $isicontent=str_replace("{list_td}",$bahantd,$isicontent);
                  break;
                  case "form":


                  break;
                }

                $bahanform="";
                if(isset($page_elemen->forms)){
                $daftarform=$page_elemen->forms;
                for($df=0; $df<count($daftarform); $df++){

                  $hasilrender=render_html_form_field($daftarform[$df]);
                  $kontenvariabelform=$hasilrender->kontenvariabelform;
                  $kontenfungsivalidasi=$hasilrender->kontenfungsivalidasi;
                  $variabeljsawal.=$hasilrender->variabeljsawal;
                  $bahanawaljs.=$hasilrender->bahanawaljs;
                  $bahanform.=$hasilrender->bahanform;
                }


                }
                $isicontent=str_replace("{bahanform}",$bahanform,$isicontent);

                if(isset($page_elemen->listeners)){
                //echo  "ADA INI ".var_dump($page_elemen)."\n";
                for ($lis=0; $lis<count($page_elemen->listeners); $lis++){
                  $tolisten=$page_elemen->listeners[$lis];

                  //echo $tolisten->listen. "ADA INI \n";
                  switch($tolisten->listen){
                    case "onload":
                    //echo "ADA INI \n";
                    for ($c=0; $c<count($tolisten->functions); $c++){
                    $bahanawaljs.=$tolisten->functions[$c]->func_name."(";


                   if(isset($tolisten->functions[$c]->func_param)){
                        for ($p=0; $p<count($tolisten->functions[$c]->func_param); $p++){
                          $bahanawaljs.=$tolisten->functions[$c]->func_param[$p];
                          if($p<count($tolisten->functions[$c]->func_param)-1){
                            $bahanawaljs.=",";
                          }
                        }
                      }
                        $bahanawaljs.=");\n";

                    }
                    break;
                  }

                }
              }else{
              //  echo "GAK ADA \n";
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
                if(isset($page_elemen->link->head)){
                for ($l=0; $l<count($page_elemen->link->head); $l++){
                  $thelink=$page_elemen->link->head[$l];
                  $thehref="";
                  $thelabel="";
                  if(!isset($thelink->type)){
                    $thelink->type="normal";
                  }
                  if(!isset($thelink->param)){
                    $thelink->param=[];
                  }
                  if(!isset($thelink->href)){
                    $thelink->href="";
                  }
                  if(!isset($thelink->label)){
                    $thelink->label="";
                  }
                  switch($thelink->type){
                    case "normal":
                    $thehref=$thelink->href;
                    $thelabel=$thelink->label;
                    break;
                    case "modul_page":
                    $thehref=get_project_url_php($thelink->modul,$thelink->page,$thelink->param);
                    $thelabel=$thelink->label;
                    break;
                  }
                  $headlink.="<th><a href=\"".$thehref."\">".$thelabel."</a></th>\n";
                }
                }
                $isicontent=str_replace("{head_link}",$headlink,$isicontent);
                }
                $bahanpagecontent.="\n".$isicontent;


                }

              //akhir for elemen
            }

            $current_page=$manifest->moduls[$i]->page[$j];
            $current_modul=$manifest->moduls[$i];

            $ar_funcs=rekursifcekfunction($current_page,$current_modul->id,$current_page->id);
            $ar_func_done=array();
            for($f=0; $f<count($ar_funcs); $f++){
              $thefunc=$ar_funcs[$f];
              //var_dump($thefunc);
              if(!in_array($thefunc->func_name,$ar_func_done)){
              $func=$thefunc->content;
              $func=str_replace("{func_param}","",$func);
              $bahanawaljs.=$func;

              $ar_func_done[]=$thefunc->func_name;
              }
              //rekursif
            }
            /**
            for($f=0; $f<count($current_page->functions); $f++){
              $thefunc=$current_page->functions[$f];
              $thefunc->modul_id=$current_modul->id;
              $thefunc->page_id=$current_page->id;
              $func=create_web_function($thefunc)->content;
              $func=str_replace("{func_param}","",$func);
              $bahanawaljs.=$func;
              //rekursif
            }
            **/

            $bahanawaljs=$variabeljsawal.$bahanawaljs;

            $copy_baseindexmodul=bacafile($filedirection."copy_base/frame_".$current_page->frame.".php");
            $bahancopy_baseindexmodul=$copy_baseindexmodul;
            $bahanreplacemasal=array(

              "{modul_id_page_id}"=>$current_modul->id."_".$current_page->id
              ,"{modul_id}"=>$current_modul->id
              ,"{page_name}"=>$current_page->title." | ".$manifest->project_name
              //,"{copy_basecss}"=>$isicopy_basecss
              ,"{page_title}"=>$current_page->title
              ,"{page_subtitle}"=>$current_page->subtitle
              ,"{page_content}"=>$bahanpagecontent
              ,"{footer_js}"=>$bahanawaljs
              ,"{copy_js}"=>$copy_basejs
              ,"{modul_title}"=>$current_modul->title
              ,"<br />"=>""

            );
            for($lib=0; $lib<count($manifest->libraries); $lib++){
              $thelib=$manifest->libraries[$lib];
              $bahanreplacemasal["{copy_base_language_".$thelib->language."}"]=$isicopy_baselanguage[$thelib->language];
            }
            $bahancopy_baseindexmodul=replacemasal($bahanreplacemasal,$bahancopy_baseindexmodul);
            $bahanreplacemasal=array();
            for($lib=0; $lib<count($libraries_warehouse); $lib++){
              $bahanreplacemasal["{copy_base_language_".$libraries_warehouse[$lib]."}"]="";
            }
            $bahancopy_baseindexmodul=replacemasal($bahanreplacemasal,$bahancopy_baseindexmodul);

            //file_put_contents($foldermvcviewpage."/index.php",$bahancopy_baseindexmodul);
            $ar_worktodo[]=array("type"=>"addfile","work_id"=>"writefileto".$foldermvcviewpage."/index.php","file_id"=>$foldermvcviewpage."/index.php","location"=>$foldermvcviewpage."/index.php","content_from"=>"string","content"=>$bahancopy_baseindexmodul);

            $writemodul="<?php"."\n";
            $writemodul.='$main->page_'.$current_page->id.'(); '."\n";
            $writemodul.='?> '."\n";
            $foldermodul="admin/"."inc_modul_".$controller_name."_page_".$current_page->id.".php";
            //file_put_contents($foldermodul,$writemodul);
            $ar_worktodo[]=array("type"=>"addfile","work_id"=>"writefiletomodul".$foldermodul,"file_id"=>$foldermodul,"location"=>$foldermodul,"content_from"=>"string","content"=>$writemodul);

          }
            //akhir for page
          }

        //akhir for modul
        }


        $copy_baseheader=str_replace("{sidemenu}",$bahansidemenu,$copy_baseheader);
        $copy_baseheader=str_replace("<br />","",$copy_baseheader);

        //file_put_contents("inc_body_header.php",$copy_baseheader);
        $ar_worktodo[]=array("type"=>"addfile","work_id"=>"writeheader"."inc_body_header.php","file_id"=>"inc_body_header.php","location"=>"inc_body_header.php","content_from"=>"string","content"=>$copy_baseheader);

        $copy_basefooter=replacemasal(array("{js_functions}"=>"","{copy_js}"=>"","<br />"=>""),$copy_basefooter);
        //file_put_contents("inc_body_footer.php",$copy_basefooter);
        $ar_worktodo[]=array("type"=>"addfile","work_id"=>"writefooter"."inc_body_footer.php","file_id"=>"inc_body_footer.php","location"=>"inc_body_footer.php","content_from"=>"string","content"=>$copy_basefooter);

return $ar_worktodo;

}

 ?>
