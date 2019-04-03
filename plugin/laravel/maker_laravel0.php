<?php
require_once ("core/domain/factory/file_factory.php");
use core\domain\repository\projectConceptToFileIndexesInterface;
use core\domain\factory\file_factory;
use core\domain\factory\file_include_factory;
use core\domain\factory\function_content_factory;
use core\domain\factory\function_factory;
use core\domain\factory\function_declaration_factory;
use core\domain\factory\function_auth_factory;
use core\domain\factory\function_footer_factory;
use core\domain\factory\directory_factory;
use core\domain\factory\entity_function_auth;
use core\domain\factory\file_indexes_factory;
class conceptConverter implements projectConceptToFileIndexesInterface{
protected $theconcept;
protected $concept_config;
public function __construct($concept_config,$theconcept){
  $this->concept_config=$concept_config;
    $this->theconcept=$theconcept;
}
function convertToFileIndexes(){
  $tellers=$this->file_teller($this->concept_config,$this->theconcept);
  $indexes=$this->file_composer($tellers["works"],$this->concept_config);
  return $indexes;
}
function file_teller($theconfig,$thejson){
$paket=array();
        $bahan_respon = "";
        $web_config=null;
        $generated_code="";
    if(isset($thejson->compiler_info["teller_include"])){
    for($j=0; $j<count($thejson->compiler_info["teller_include"]); $j++){
      include $thejson->compiler_info["teller_include"][$j]["file_path_to_include"];
      $prop=$thejson->compiler_info["teller_include"][$j]["properties"];
      $propvar=$thejson->compiler_info["teller_include"][$j]["properties_equal_var"];
      if($thejson->compiler_info["teller_include"][$j]["for"]=="config"){
      echo "added config properties from teller : ".$prop."<br>";
      $theconfig->$prop=($$propvar);
      }
    }
    }
    $filedirection=$theconfig->web_localpath;
    $pecahslash=explode('/',$theconfig->web_url);
    $folderakhir="";
      for($p=count($pecahslash)-1;$p>0;$p--){
      //  echo "pecahslash ".$pecahslash[$p]."\n";
        if(strlen($pecahslash[$p])>0){
          $folderakhir=$pecahslash[$p];
          break;
        }
      }
    $theconfig->web_folder=$folderakhir;
    //echo $thejson->project_config[$j]->config_type."\n";
    $ar_worktodo=array();
    $manifest = $thejson;
    echo "MAKERPATH : ".$theconfig->maker_path."<BR>";
    //include $theconfig->maker_path;
    $isi_ar=$this->makeLaravel($manifest);
    $ar_worktodo=array_merge($ar_worktodo,$isi_ar);
return array("works"=>$ar_worktodo,"theconfig"=>$theconfig);
  //akhir file_teller
}
function file_composer($ar_worktodo,$theconfig){
    $ar_files=array();
    $ar_directories=array();
    $ar_functions=array();
    $ar_file_functions=array();
    $ar_contents=array();
    $ar_declarations=array();
    $ar_function_declaration=array();
    $ar_footer=array();
    $ar_function_footer=array();
    $ar_func_content=array();
    $ar_function_content=array();
    $ar_includes=array();
    $ar_function_includes=array();
    $ar_auth=array();
    $ar_function_auth=array();
    $filedirection=$theconfig->web_localpath;
             echo "<BR><BR><BR>panjang work : ".count($ar_worktodo)."<BR><BR><BR>";
             $finished_work_id=array();
             $exists_files_id=array();
             $exists_folder_id=array();
             $exists_files_include=array();
             $ar_canceled_work_id=array();
             for($w=0; $w<count($ar_worktodo);$w++){
               if($ar_worktodo[$w]["type"]=="cancelwork"){
                 $ar_canceled_work_id[]=$ar_worktodo[$w]["cancel_work_id"];
                 //echo "ADA CANCEL"."<BR>";
               }else{
                 //echo "GAK ADA ".$ar_worktodo[$w]["type"]."<BR>";
               }
                 if($ar_worktodo[$w]["type"]=="add_declaration_to_function"){
                     //echo "ADA ADF ".$ar_worktodo[$w]["work_id"]."<BR>";
                 }
             }
             for($w=0; $w<count($ar_worktodo);$w++){
               if(isset($ar_worktodo[$w]["function_id"])){
                 $_SESSION['index_of_'.'footer'.'_function_'.$ar_worktodo[$w]["function_id"]]=0;
                 $_SESSION['index_of_'.'content'.'_function_'.$ar_worktodo[$w]["function_id"]]=0;
                 $_SESSION['index_of_'.'declaration'.'_function_'.$ar_worktodo[$w]["function_id"]]=0;
               }
             }
             for($w=0; $w<count($ar_worktodo);$w++){
              // echo "work_id : ".$ar_worktodo[$w]["work_id"]." type : ".$ar_worktodo[$w]["type"]."<br>";
               if((!in_array($ar_worktodo[$w]["work_id"],$finished_work_id)) && (!in_array($ar_worktodo[$w]["work_id"],$ar_canceled_work_id))){
                 switch($ar_worktodo[$w]["type"]){
                   case "addfile":
                   if(!in_array($ar_worktodo[$w]["file_id"],$exists_files_id)){
                   $class_content="";
                         if(!isset($ar_worktodo[$w]["content_from"])){
                           $ar_worktodo[$w]["content_from"]="string";
                         }
                         switch($ar_worktodo[$w]["content_from"]){
                           case "file":
                           //echo "baca file ".$ar_files[$w]["content"];
                           if (file_exists($filedirection.$ar_worktodo[$w]["content"])) {
                             $class_content=bacafile($filedirection.$ar_worktodo[$w]["content"]);
                           }
                           break;
                           case "string":
                           $class_content=$ar_worktodo[$w]["content"];
                           break;
                         }
                     $ff = new file_factory();
                     //echo "file idnya : ".$ar_worktodo[$w]["file_id"]."<BR>";
                     $ff->create($ar_worktodo[$w]["file_id"],$ar_worktodo[$w]["location"],$class_content);
                     $ar_files[]=$ff->getFile();
                     $exists_files_id[]=$ar_worktodo[$w]["file_id"];
                   }
                   break;
                   case "addinclude":
                   if(!in_array($ar_worktodo[$w]["work_id"],$exists_files_include)){
                   //echo "terjadi addinclunde ".$ar_worktodo[$w]["file_id"]."<BR>";
                     $fif = new file_include_factory();
                     $fif->create($ar_worktodo[$w]["work_id"],$ar_worktodo[$w]["file_id"],$ar_worktodo[$w]["content"]);
                     $ar_includes[]=$fif->getFileInclude();
                     $exists_files_include[]=$ar_worktodo[$w]["work_id"];
                   }
                   break;
                   case "addfunction":
                   if(!in_array($ar_worktodo[$w],$ar_functions)){
                     $ar_functions[]=$ar_worktodo[$w];
                     $fif = new function_factory();
                     $fif->create($ar_worktodo[$w]["file_id"]
                     ,$ar_worktodo[$w]["function_id"]
                     ,$ar_worktodo[$w]["function_name"]
                     ,$ar_worktodo[$w]["param"]
                     ,""
                    );
                    $ar_file_functions[]=$fif->getFunction();
                   }
                   break;
                   case "add_auth":
                   if(!in_array($ar_worktodo[$w],$ar_auth)){
                     $ar_auth[]=$ar_worktodo[$w];
                     $faf = new function_auth_factory();
                     $faf->create($ar_worktodo[$w]["function_id"]
                     ,$ar_worktodo[$w]["content"]
                     ,$ar_worktodo[$w]["content_footer"]
                    );
                    $ar_function_auth[]=$faf->getFunctionAuth();
                   }
                   break;
                   case "add_declaration_to_function":
                   if(!in_array($ar_worktodo[$w],$ar_declarations)){
                     $ar_declarations[]=$ar_worktodo[$w];
                     $nomindexes=0;
                     $whatoffunction="declaration";
                     if(!isset($_SESSION['index_of_'.$whatoffunction.'_function_'.$ar_worktodo[$w]["function_id"]])){
                       $nomindexes=0;
                     }else{
                       $nomindexes=$_SESSION['index_of_'.$whatoffunction.'_function_'.$ar_worktodo[$w]["function_id"]];
                     }
                     $nomindexes+=1;
                     $_SESSION['index_of_'.$whatoffunction.'_function_'.$ar_worktodo[$w]["function_id"]]=$nomindexes;
                     $faf = new function_declaration_factory();
                     $faf->create($ar_worktodo[$w]["function_id"]
                     ,$ar_worktodo[$w]["content"]
                     ,$nomindexes
                    );
                    $ar_function_declaration[]=$faf->getFunctionDeclaration();
                   }
                   break;
                   case "add_footer_to_function":
                   if(!in_array($ar_worktodo[$w],$ar_footer)){
                     $ar_footer[]=$ar_worktodo[$w];
                     $nomindexes=0;
                     $whatoffunction="footer";
                     if(!isset($_SESSION['index_of_'.$whatoffunction.'_function_'.$ar_worktodo[$w]["function_id"]])){
                       $nomindexes=0;
                      // echo "belum ada";
                     }else{
                       $nomindexes=$_SESSION['index_of_'.$whatoffunction.'_function_'.$ar_worktodo[$w]["function_id"]];
                     }
                     $nomindexes+=1;
                     $_SESSION['index_of_'.$whatoffunction.'_function_'.$ar_worktodo[$w]["function_id"]]=$nomindexes;
                     $faf = new function_footer_factory();
                     $faf->create($ar_worktodo[$w]["function_id"]
                     ,$ar_worktodo[$w]["content"]
                     ,$nomindexes
                    );
                    $ar_function_footer[]=$faf->getFunctionFooter();
                   }
                   break;
                   case "add_to_function":
                   if(!in_array($ar_worktodo[$w],$ar_func_content)){
                     $ar_func_content[]=$ar_worktodo[$w];
                     $nomindexes=0;
                     $whatoffunction="content";
                     if(!isset($_SESSION['index_of_'.$whatoffunction.'_function_'.$ar_worktodo[$w]["function_id"]])){
                       $nomindexes=0;
                     }else{
                       $nomindexes=$_SESSION['index_of_'.$whatoffunction.'_function_'.$ar_worktodo[$w]["function_id"]];
                     }
                     $nomindexes+=1;
                     $_SESSION['index_of_'.$whatoffunction.'_function_'.$ar_worktodo[$w]["function_id"]]=$nomindexes;
                     $faf = new function_content_factory();
                     $faf->create($ar_worktodo[$w]["function_id"]
                     ,$ar_worktodo[$w]["content"]
                     ,$nomindexes
                    );
                    $ar_function_content[]=$faf->getFunctionContent();
                  //   var_dump($ar_worktodo[$w]);
                   }
                   for($wf=0; $wf<count($ar_functions);$wf++){
                     if($ar_functions[$wf]["function_id"]==$ar_worktodo[$w]["function_id"]){
                       //echo "ada cocok ".$ar_functions[$wf]["function_id"]."<BR>";
                     }else {
                       //echo "tidak cocok ".$ar_functions[$wf]["function_id"]." dengan ".$ar_worktodo[$w]["function_id"]."<BR>";
                     }
                   }
                   //echo "nambah isi fungsi";
                   break;
                   case "makedirectory":
                   if(!in_array($ar_worktodo[$w]["directory_id"],$exists_folder_id)){
                     $faf = new directory_factory();
                     $faf->create($ar_worktodo[$w]["directory_id"]
                     ,$ar_worktodo[$w]["location"]
                    );
                     $ar_directories[]=$faf->getDirectory();
                     $exists_folder_id[]=$ar_worktodo[$w]["directory_id"];
                   }
                   break;
                 }
                 $finished_work_id[]=$ar_worktodo[$w]["work_id"];
               }
             }
             echo "<BR><BR><BR>panjang include : ".count($exists_files_include)."<BR><BR><BR>";
    $paket=array(
      "language"=>"php"
      ,"ar_files"=>$ar_files
      ,"ar_directories"=>$ar_directories
      ,"ar_includes"=>$ar_includes
      ,"ar_functions"=>$ar_file_functions
      ,"ar_contents"=>$ar_contents
      ,"ar_declarations"=>$ar_declarations
      ,"ar_footer"=>$ar_footer
      ,"ar_function_content"=>$ar_function_content
      ,"ar_auth"=>$ar_auth
      ,"theconfig"=>$theconfig
    );
    //$ar_function_footer=array_reverse($ar_function_footer);
    $fif = new file_indexes_factory();
    $fif->create($ar_directories
    ,$ar_files
    ,$ar_includes
    ,$ar_file_functions
    ,$ar_function_auth
    ,$ar_function_declaration
    ,$ar_function_content
    ,$ar_function_footer);
return $fif->getFileIndexes();
  //akhir file_composer
}
function makeLaravel($manifest){
  include 'helper_makelaravel.php';
  include 'process/registered_process.php';
  for($p=0; $p<count($all_process); $p++){
    echo $all_process[$p]["file"]."<BR>";
    include "process/".$all_process[$p]["file"];
  }
  $requested_html = $_SESSION['caisconfig_'.$_SESSION['config_type']]->requested_html;
      for($r=0; $r<count($requested_html);$r++){
        if($requested_html[$r]["key"]=="form_field_listener"){
            include($requested_html[$r]["file"]);
        }
      }
  $theconfig=null;
  for($j=0; $j<count($manifest->project_config); $j++){
    if($manifest->project_config[$j]->config_type=="weblaravel"){
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
  $copy_baselayout=bacafile($filedirection."copy_base/layout_admin.blade.php");
  $copy_baseheader=bacafile($filedirection."copy_base/inc_body_header.php");
  $copy_basefooter=bacafile($filedirection."copy_base/inc_body_footer.php");
  $copy_basesidetreeview=bacafile($filedirection."copy_base/sidemenutreeview.txt");
  $copy_basesideli=bacafile($filedirection."copy_base/sidemenuli.txt");
  $copy_baseclass=bacafile($filedirection."copy_base/class.php");
  $daf_variables="";
  for($i=0; $i<count($manifest->global_variables); $i++){
  $daf_variables.=create_web_variable($manifest->global_variables[$i]);
  $daf_variables.='$variables["'.$manifest->global_variables[$i]->name.'"]=$'.$manifest->global_variables[$i]->name.';'."\n";
  }
  $config_system_content=bacafile($filedirection."copy_base/config_variables.php");
  $config_system_content=str_replace("<br />","",$config_system_content);
  $config_system_content=str_replace("{write}",$daf_variables,$config_system_content);
  //$ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileutilvariables","file_id"=>"fileutilvariables","location"=>"utils/variables.php","content_from"=>"string","content"=>$config_system_content);
  $system_content="";
  $config_system_content=bacafile($filedirection."copy_base/config_system.php");
  $config_system_content=str_replace("<br />","",$config_system_content);
  $config_system_content=str_replace("{write}",$system_content,$config_system_content);
  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileconfig_system","file_id"=>"config_system","location"=>"config/system.php","content_from"=>"string","content"=>$config_system_content);
  $config_system_content=bacafile($filedirection."copy_base/config_database.php");
  $config_system_content=str_replace("<br />","",$config_system_content);
  if(!isset($theconfig->database_port)){
    $theconfig->database_port="3306";
  }
  $config_system_content=str_replace("{database_host}",$theconfig->database_host,$config_system_content);
  $config_system_content=str_replace("{database_port}",$theconfig->database_port,$config_system_content);
  $config_system_content=str_replace("{database_name}",$theconfig->database_name,$config_system_content);
  $config_system_content=str_replace("{database_username}",$theconfig->database_username,$config_system_content);
  $config_system_content=str_replace("{database_password}",$theconfig->database_password,$config_system_content);
  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileconfig_database","file_id"=>"config_database","location"=>"config/database.php","content_from"=>"string","content"=>$config_system_content);
  $config_system_content=bacafile($filedirection."copy_base/env.php");
  $config_system_content=str_replace("<br />","",$config_system_content);
  $config_system_content=str_replace("{database_host}",$theconfig->database_host,$config_system_content);
  $config_system_content=str_replace("{database_port}",$theconfig->database_port,$config_system_content);
  $config_system_content=str_replace("{database_name}",$theconfig->database_name,$config_system_content);
  $config_system_content=str_replace("{database_username}",$theconfig->database_username,$config_system_content);
  $config_system_content=str_replace("{database_password}",$theconfig->database_password,$config_system_content);
  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileconfig_env","file_id"=>"config_env","location"=>".env","content_from"=>"string","content"=>$config_system_content);
  $bahansidemenu="";
    $daf_stringinclude=rekursifcekinclude($manifest,"");
  //echo "DAF STRING INCLUDE ".count($daf_stringinclude);
  $tulisanmanifest=json_encode($manifest);
  for($i=0; $i<count($daf_stringinclude); $i++){
    $tulisanmanifest=str_replace($daf_stringinclude[$i]["from"],$daf_stringinclude[$i]["to"],$tulisanmanifest);
  }
  $manifest=json_decode($tulisanmanifest);
  //JSON sudah lengkap
  $isiroute="";
  for($i=0; $i<count($manifest->moduls); $i++){
    $controller_name=$manifest->moduls[$i]->id;
      for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
      $thepage=$manifest->moduls[$i]->page[$j];
      $func_name=$thepage->id;
      $urlroute="/admin/".$controller_name."/".$func_name;
      $daf_url_catcher=rekursifcekurlcatcher($thepage->process);
        for($d=0; $d<count($daf_url_catcher); $d++){
          $urlroute.="/".$daf_url_catcher[$d]["catch"]."/{".$daf_url_catcher[$d]["catch"]."}";
        }
      $isiroute.="Route::get('".$urlroute."', ['uses'=>'model_controller_".$controller_name."@page_".$func_name."']);\n";
  }
  }
  $docsfilelocation="resources/views/mvc_view/system_information/documentation";
  $ar_worktodo[]=array("type"=>"makedirectory","work_id"=>"makedirectorydocumentation","directory_id"=>"folderdocumentation","location"=>$docsfilelocation);
  $copy_baseindexmodul=bacafile($filedirection."copy_base/frame_adminpage.php");
  $copy_basedocumentation=bacafile($filedirection."copy_base/documentation.php");
  $isidataspage="";
  $nomidx=1;
  for($i=0; $i<count($manifest->moduls); $i++){
    $controller_name=$manifest->moduls[$i]->id;
      for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
      $thepage=$manifest->moduls[$i]->page[$j];
      $func_name=$thepage->id;
      $urlroute="/admin/".$controller_name."/".$func_name;
      $isiplace="";
      for($pl=0;$pl<count($manifest->moduls[$i]->page[$j]->placement);$pl++){
        $isiplace.=$manifest->moduls[$i]->page[$j]->placement[$pl]->place.",";
      }
      $isidataspage.="<tr>";
      $isidataspage.="<td>".$nomidx."</td>";
      $isidataspage.="<td>".$controller_name."</td>";
      $isidataspage.="<td>".$func_name."</td>";
      $isidataspage.="<td>".$isiplace."</td>";
      $isidataspage.="</tr>";
      $nomidx+=1;
    }
  }
  $copy_basedocumentation=str_replace("{datas_page}",$isidataspage,$copy_basedocumentation);
  $isidatasapi="";
  $nomidx=1;
  for($d=0; $d<count($manifest->daf_api); $d++){
    $manifest->daf_api[$d]->modul=$manifest->daf_api[$d]->modul;
    $controller_name=$manifest->daf_api[$d]->modul;
   for($act=0; $act<count($manifest->daf_api[$d]->action); $act++){
      $action=$manifest->daf_api[$d]->action[$act];
      $action->properties_modul=$controller_name;
      $action->properties_page=$action->action;
      //echo "properties_page : ".$action->properties_page."<BR>";
      $func_name=$action->action;
      $isiparam="";
      for($f=0; $f<count($action->param); $f++){
        if(!isset($action->param[$f]->mandatory)){
          $action->param[$f]->mandatory=false;
        }
        $isiparam.=$action->param[$f]->name."(".(int)$action->param[$f]->mandatory.")".",";
      }
      $isidatasapi.="<tr>";
      $isidatasapi.="<td>".$nomidx."</td>";
      $isidatasapi.="<td>".$controller_name."</td>";
      $isidatasapi.="<td>".$func_name."</td>";
      $isidatasapi.="<td>".$isiparam."</td>";
      $isidatasapi.="<td>"."{cais_web_url}/API"."</td>";
      $isidatasapi.="</tr>";
      $nomidx+=1;
    }
  }
  $copy_basedocumentation=str_replace("{datas_api}",$isidatasapi,$copy_basedocumentation);
  $bahancopy_baseindexmodul=$copy_baseindexmodul;
  $bahanpagecontent="";
  $bahanreplacemasal=array(
    "{modul_id_page_id}"=>""
    ,"{modul_id}"=>""
    ,"{page_name}"=>"Documentation | System Information"
    //,"{copy_basecss}"=>$isicopy_basecss
    ,"{page_title}"=>"Documentation"
    ,"{page_subtitle}"=>"Documentation"
    ,"{page_content}"=>$copy_basedocumentation
    ,"{footer_js}"=>""
    ,"{copy_js}"=>""
    ,"{modul_title}"=>""
    ,"<br />"=>""
  );
  $bahancopy_baseindexmodul=replacemasal($bahanreplacemasal,$bahancopy_baseindexmodul);
  $bahanreplacemasal=array();
  for($lib=0; $lib<count($libraries_warehouse); $lib++){
    $bahanreplacemasal["{copy_base_language_".$libraries_warehouse[$lib]."}"]="";
  }
  $bahancopy_baseindexmodul=replacemasal($bahanreplacemasal,$bahancopy_baseindexmodul);
  //file_put_contents($foldermvcviewpage."/index.php",$bahancopy_baseindexmodul);
  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"writefileto".$docsfilelocation."/index.blade.php","file_id"=>$docsfilelocation."/index.blade.php","location"=>$docsfilelocation."/index.blade.php","content_from"=>"string","content"=>$bahancopy_baseindexmodul);
  //$ar_worktodo[]=array("type"=>"addfile","work_id"=>"makefiledocumentation","directory_id"=>"filedocumentation","location"=>$docsfilelocation."/index.blade.php","content_from"=>"string","content"=>"tes tertulis");
  $config_system_content=bacafile($filedirection."copy_base/routes_web.php");
  $config_system_content=str_replace("<br />","",$config_system_content);
  $config_system_content=str_replace("{write}",$isiroute,$config_system_content);
  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileconfig_routes_web","file_id"=>"config_routes_web","location"=>"routes/web.php","content_from"=>"string","content"=>$config_system_content);
  $config_system_content=bacafile($filedirection."copy_base/routes_web.php");
  $config_system_content=str_replace("<br />","",$config_system_content);
  $config_system_content=str_replace("{write}",$isiroute,$config_system_content);
  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileconfig_routes_web","file_id"=>"config_routes_web","location"=>"routes/web.php","content_from"=>"string","content"=>$config_system_content);
  $config_system_content=bacafile($filedirection."copy_base/config_helpers.php");
  $config_system_content=str_replace("<br />","",$config_system_content);
  $config_system_content=str_replace("{write_variables}",$daf_variables,$config_system_content);
  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile_helpers","file_id"=>"file_helpers","location"=>"app/helpers.php","content_from"=>"string","content"=>$config_system_content);
  for($i=0; $i<count($manifest->moduls); $i++){
    $controller_name=$manifest->moduls[$i]->id;
      for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
      $thepage=$manifest->moduls[$i]->page[$j];
        $thepage->properties_modul=$controller_name;
          $thepage->properties_page=$thepage->id;
      $func_name=$thepage->id;
        foreach($thepage as $category){
          if(is_array($category)){
            rekursifmodulpage($category,$controller_name,$func_name,"weblaravel");
          }else if (is_object($category)) {
            $category->properties_modul=$controller_name;
            $category->properties_page=$thepage->properties_page;
              rekursifmodulpage($category,$controller_name,$func_name,"weblaravel");
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
                  rekursifmodulpage($category,$controller_name,$func_name,"weblaravel");
                }else if (is_object($category)) {
                  $category->properties_modul=$controller_name;
                  $category->properties_page=$action->properties_page;
                    rekursifmodulpage($category,$controller_name,$func_name,"weblaravel");
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
                        //echo "properties_page : ".$action->properties_modul."<BR>";
                      }
                    }
                                for($i=0; $i<count($manifest->moduls); $i++){
                                  $controller_name=$manifest->moduls[$i]->id;
                                  //echo "controller ".$controller_name."<BR>";
                                  $controller_nickname="controller_".$controller_name;
                                  $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile".$controller_nickname,"file_id"=>$controller_nickname,"location"=>"app/Http/Controllers/model_".$controller_nickname.".php","content_from"=>"file","content"=>"file_template/language_php_template_controller.php");
                                    for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
                                    $thepage=$manifest->moduls[$i]->page[$j];
                                    $page_name=$thepage->id;
                                    $page_nickname="page_".$page_name;
                                    $page_name_controller=$page_nickname.$controller_nickname;
                                    for($a=0; $a<count($manifest->auth);$a++){
                                      if($manifest->auth[$a]->moduls==$controller_name){
                                        if(in_array($page_name,$manifest->auth[$a]->pages)){
                                        $pakaiauth=$manifest->auth[$a];
                                          $pakaiauth->properties_modul=$manifest->auth[$a]->moduls;
                                            $pakaiauth->properties_page=$thepage->id;
                                              foreach($pakaiauth as $category){
                                                if(is_array($category)){
                                                  rekursifmodulpage($category,$controller_name,$func_name,"weblaravel");
                                                }else if (is_object($category)) {
                                                  $category->properties_modul=$controller_name;
                                                  $category->properties_page=$thepage->properties_page;
                                                    rekursifmodulpage($category,$controller_name,$func_name,"weblaravel");
                                                }else{
                                                  //echo $category;
                                                  //$category->properties_modul="NAMA MODUL";
                                                }
                                              }
                                        }
                                      }
                                    }
                                    }
                                }
          include("setup_function_names.php");
          setup_database_function_name($manifest);
                      for($i=0; $i<count($manifest->moduls); $i++){
                        $controller_name=$manifest->moduls[$i]->id;
                        //echo "controller ".$controller_name."<BR>";
                        $controller_nickname="controller_".$controller_name;
                        $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile".$controller_nickname,"file_id"=>$controller_nickname,"location"=>"app/Http/Controllers/model_".$controller_nickname.".php","content_from"=>"file","content"=>"file_template/language_php_template_controller.php");
                          for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
                          $thepage=$manifest->moduls[$i]->page[$j];
                          $page_name=$thepage->id;
                          $page_nickname="page_".$page_name;
                          $page_name_controller=$page_nickname.$controller_nickname;
                          $auth_content="";
                          $ada_auth=0;
                          $pakaiauth=null;
                          for($a=0; $a<count($manifest->auth);$a++){
                            if($manifest->auth[$a]->moduls==$controller_name){
                              if(in_array($page_name,$manifest->auth[$a]->pages)){
                              $pakaiauth=$manifest->auth[$a];
                                $pakaiauth->properties_modul=$manifest->auth[$a]->moduls;
                                  $pakaiauth->properties_page=$thepage->id;
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
                          $isielse="";
                          if($ada_auth==1){
                            $auth_footer="}else{\n";
                              for($w=0; $w<count($pakaiauth->onfailed->process);$w++){
                                $pakaiauth->onfailed->process[$w]->dalamgenggaman=true;
                                  //var_dump($pakaiauth->onfailed->process[$w]->properties_modul);
                              }
                              $grupengine=render_grup_engine($pakaiauth->onfailed);
                              //$varphpawal[]=$grupengine->varphpawal;
                              $ar_worktodo=array_merge($ar_worktodo,$grupengine->ar_worktodo);
                              $isielse=$grupengine->content;
                              $auth_footer.=$isielse;
                            $auth_footer.="}\n}else{\n";
                          $auth_footer.=$isielse."\n";
                        $auth_footer.="}\n";
                          $ar_worktodo[]=array("type"=>"add_auth","work_id"=>"add_auth_to".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>$auth_content."\n","content_footer"=>$auth_footer."\n");
                          }
                          $ar_worktodo[]=array("type"=>"addinclude","work_id"=>"include_".$page_nickname."_to_".$controller_nickname,"file_id"=>$controller_nickname,"include_id"=>$page_nickname,"content"=>"use App\MVC_MODEL\\model_".$page_nickname.";"."\n");
                          $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"function_name"=>$page_nickname,"param"=>array(),"file_id"=>$controller_nickname);
                          $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile".$page_nickname,"file_id"=>$page_nickname,"location"=>"app/MVC_MODEL/model_".$page_nickname.".php","content_from"=>"file","content"=>"file_template/language_php_template_class.php");
                          $bahandeklarasi="session_start();\n";
                          $bahandeklarasi.='$obj_'.$page_name." = new model_page_".$page_name."();\n";
                          $bahandeklarasi.='$variables=getVariables();'."\n";
                          $bahandeklarasi.='extract($variables);'."\n";
                          $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_themodelof_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");
                          $firstfooter_content='return view("mvc_view/'.$controller_name.'/'.$page_name.'/index",compact("variables"));'."\n";
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
                        $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile".$controller_nickname,"file_id"=>$controller_nickname,"location"=>"app/Http/Controllers/model_".$controller_nickname.".php","content_from"=>"file","content"=>"file_template/language_php_template_controller.php");
                        for($act=0; $act<count($manifest->daf_api[$d]->action); $act++){
                          $action=$manifest->daf_api[$d]->action[$act];
                          $func_name=$action->action;
                          //echo "page api ".$controller_name."<BR>";
                                      $dafVariable=array();
                                      foreach($action->process as $pro){
                                        if(is_array($pro)){
                                          //echo $key."<BR>";
                                          //$dafVariable=array_merge($dafVariable,renderwhattodo($key,$category,$isitoproses));
                                          $dafVariable=array_merge($dafVariable,rekursifdafVariable($pro));
                                        }else if (is_object($pro)) {
                                          //echo $key."<BR>";
                                          if(isset($pro->outputVariable)){
                                          $dafVariable[]=$pro->outputVariable;
                                          }
                                          $dafVariable=array_merge($dafVariable,rekursifdafVariable($pro));
                                        }else{
                                        }
                                      }
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
                          $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"function_name"=>$page_nickname,"param"=>array('$obj'),"file_id"=>$controller_nickname);
                          $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_variabel_error_code_in_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>'$error_code = "000";'."\n");
                          $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_variabel_error_msg_in_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>'$error_msg = "";'."\n");
                          $bahandeklarasiapi="";
                          $varphpawal="";
                          $bahandeklarasiapi.='$variables=getVariables();'."\n";
                          $bahandeklarasiapi.='extract($variables);'."\n";
                          $bahandeklarasiapi.='$prosesapi=1;'."\n";
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
                          $ledakanresponse= (explode("v{",$action->response_output));
                             for($l=1;$l<count($ledakanresponse);$l++) {
                               $ledakanresponsedalam= explode("}v",$ledakanresponse[$l]);
                               $dapatkurunganlama="v{".$ledakanresponsedalam[0]."}v";
                               $ledakanresponsedalam[0]=str_replace("'","\"",$ledakanresponsedalam[0]);
                               $dapatkurungan="{".$ledakanresponsedalam[0]."}";
                               $bahanjsonledakan=json_decode($dapatkurungan);
                               $tes=  $bahanjsonledakan;
                               if(!isset($tes->var_type)){
                               $tes->var_type="variable";
                               }
                                 //echo "gak ada ".$tes->var_name;
                               $bikinvar=create_variable_web($tes);
                               $dapatkurunganbaru=str_replace('"','\"',$dapatkurungan);
                               //echo $dapatkurunganlama;
                               $action->response_output=str_replace($dapatkurunganlama,'".'.$bikinvar.'."',$action->response_output);
                               //$bahanfooter.='$bahan_respon=str_replace("'.$dapatkurunganlama.'",'.$bikinvar.',$bahan_respon);'."\n";
                             }
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
                        }
                        }
                        //akhir daf_api
                      }
          //var_dump($manifest);
          $bahansidemenu.='<?php'."\n";
          for($i=0; $i<count($manifest->moduls); $i++){
            $controller_name=$manifest->moduls[$i]->id;
            $jumpageplacement=0;
            for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
              if(isset($manifest->moduls[$i]->page[$j]->placement)){
                if(count($manifest->moduls[$i]->page[$j]->placement)>0){
                  $jumpageplacement+=1;
                }
              }
            }
            $bahansidemenu.="\n".'$poin_auth_modul_'.$controller_name.' = '.$jumpageplacement.';';
            for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
              $thepage=$manifest->moduls[$i]->page[$j];
              $func_name=$thepage->id;
           for($a=0; $a<count($manifest->auth);$a++){
             if($manifest->auth[$a]->moduls==$controller_name){
             for($p=0; $p<count($manifest->auth[$a]->pages);$p++){
               if($manifest->auth[$a]->pages[$p]==$thepage->id){
               if(isset($thepage->placement)){
                 if(count($thepage->placement)>0){
              $bahansidemenu.="\n // check auth ".$func_name;
              $bahansidemenu.="\n".'$auth_'.$func_name.' = -1;';
                }
              }
            }
          }
        }
      }
              //->auth
              for($a=0; $a<count($manifest->auth);$a++){
                if($manifest->auth[$a]->moduls==$controller_name){
                for($p=0; $p<count($manifest->auth[$a]->pages);$p++){
                  if($manifest->auth[$a]->pages[$p]==$thepage->id){
                    if(isset($thepage->placement)){
                      if(count($thepage->placement)>0){
                    $objchecksession->content=$manifest->auth[$a]->allow;
                    $thegroup=create_booleancheck_web($objchecksession);
                    $bahansidemenu.="\nif (".'$auth_'.$func_name." == -1){"."\n";
                    $bahansidemenu.="\n"."if (".$thegroup->isset_content."){"."\n";
                    $bahansidemenu.="if (".$thegroup->comparing_content."){"."\n";
                    $bahansidemenu.="\n".'$auth_'.$func_name.' = 1;';
                    $bahansidemenu.="\n".'}'."\n".'}'."\n".'}';
                    }
                  }
                  }
                }
                for($p=0; $p<count($manifest->auth[$a]->pages);$p++){
                  if($manifest->auth[$a]->pages[$p]==$manifest->moduls[$i]->page[$j]->id){
                if(isset($manifest->moduls[$i]->page[$j]->placement)){
                  if(count($manifest->moduls[$i]->page[$j]->placement)>0){
                    $bahansidemenu.="\n"."if (".'$auth_'.$func_name." == -1){"."\n";
                    $bahansidemenu.="\n".'$poin_auth_modul_'.$controller_name.' -= 1;';
                    $bahansidemenu.="\n".'}';
                  }
                }
                  }
                }
              }
              }
            }
          }
          $bahansidemenu.="\n".'?>'."\n";
          for($i=0; $i<count($manifest->moduls); $i++){
            $controller_name=$manifest->moduls[$i]->id;
            $controller_nickname="controller_".$controller_name;
            $foldermvcview='resources/views/mvc_view/'.$controller_name;
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
                $adagotplace=0;
                for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
                //  echo "CETAAK".$manifest->moduls[$i]->page[$j]->id."<BR>";
                //    var_dump($manifest->moduls[$i]->page[$j]->placement)."<BR>";
                    $gotplace=0;
                    for($pl=0;$pl<count($manifest->moduls[$i]->page[$j]->placement);$pl++){
                      echo "place ".$manifest->moduls[$i]->page[$j]->placement[$pl]->place."\n";
                      if($manifest->moduls[$i]->page[$j]->placement[$pl]->place=="sidemenu"){
                        $gotplace=1;
                        $adagotplace=1;
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
                  $bahanmenuli.="\n".'<?php if(isset($auth_'.$manifest->moduls[$i]->page[$j]->id.') && $auth_'.$manifest->moduls[$i]->page[$j]->id.' == 1){ ?>';
                  $bahanmenuli.="\n".$menuli;
                  $bahanmenuli.="\n".'<?php } ?>';
                  }
                }
                $bahantreeview=str_replace("{modul_id}",$manifest->moduls[$i]->id,$bahantreeview);
                $bahantreeview=str_replace("{modul_title}",$manifest->moduls[$i]->title,$bahantreeview);
                $bahantreeview=str_replace("{li}",$bahanmenuli,$bahantreeview);
                if($adagotplace==1){
                  $bahansidemenu.="\n".'<?php if($poin_auth_modul_'.$controller_name.' > 0){ ?>';
                  $bahansidemenu.="\n".$bahantreeview;
                  $bahansidemenu.="\n".'<?php } ?>';
                //$bahansidemenu.="\n".$bahantreeview;
                }
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
              for($r=0; $r<count($requested_html);$r++){
                if($requested_html[$r]["key"]=="form_field_css_insert"){
                    $isicopy_baselanguage[$requested_html[$r]["language"]]='$copy_base_language_'.$requested_html[$r]["language"].'=array();'."\n";
                }
                if($requested_html[$r]["key"]=="page_element_css_insert"){
                    $isicopy_baselanguage[$requested_html[$r]["language"]]='$copy_base_language_'.$requested_html[$r]["language"].'=array();'."\n";
                }
              }
              if(isset($manifest->js_vars)){
              for($lib=0; $lib<count($manifest->js_vars); $lib++){
                $varphp=create_variable_web($manifest->js_vars[$lib]->var);
                $variabeljsawal.="<?php if(isset(".$varphp.")){ ?>\n";
                $variabeljsawal.='var '.$manifest->js_vars[$lib]->js_var.' = "<?php print('.create_variable_web($manifest->js_vars[$lib]->var).');?>";'."\n";
                $variabeljsawal.="<?php } ?>\n";
              }
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
                $alamatelemenjsinsert="";
                for($r=0; $r<count($requested_html);$r++){
                  if($requested_html[$r]["key"]=="page_element_js_insert"){
                    if($requested_html[$r]["type"]==$manifest->moduls[$i]->page[$j]->elemen[$e]->type){
                      $alamatelemenjsinsert=$requested_html[$r]["file"];
                    }
                  }
                }
                for($r=0; $r<count($requested_html);$r++){
                  if($requested_html[$r]["key"]=="page_element_css_insert"){
                      if($requested_html[$r]["type"]==$manifest->moduls[$i]->page[$j]->elemen[$e]->type){
                        if (!in_array($requested_html[$r]["language"].$requested_html[$r]["key"].$requested_html[$r]["type"].$requested_html[$r]["path"], $arlibs)){
                          $isicopy_baselanguage[$requested_html[$r]["language"]].='$copy_base_language_'.$requested_html[$r]["language"].'[]=array("name"=>"'.$requested_html[$r]["type"].'","path"=>"'.$requested_html[$r]["path"].'");'."\n";
                          $arlibs[]=$requested_html[$r]["language"].$requested_html[$r]["key"].$requested_html[$r]["type"].$requested_html[$r]["path"];
                        }
                      }
                    }
                }
                if (file_exists($alamatelemenjsinsert)) {
                $isicopyjs=bacafile($alamatelemenjsinsert);
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
                              $isicopy_baselanguage[$thelib->language].='$copy_base_language_'.$thelib->language.'[]=array("name"=>"'.$thelibrary->name.'","path"=>"public/"."'.$thelibrary->path.'");'."\n";
                              $arlibs[]=$thelib->language.$thelibrary->type;
                            }
                            }
                          }
                        }
                        for($r=0; $r<count($requested_html);$r++){
                          if($requested_html[$r]["key"]=="form_field_css_insert"){
                            if($requested_html[$r]["type"]==$thefield->type){
                              if (!in_array($requested_html[$r]["language"].$requested_html[$r]["key"].$requested_html[$r]["type"].$requested_html[$r]["path"], $arlibs)){
                                $isicopy_baselanguage[$requested_html[$r]["language"]].='$copy_base_language_'.$requested_html[$r]["language"].'[]=array("name"=>"'.$requested_html[$r]["type"].'","path"=>"'.$requested_html[$r]["path"].'");'."\n";
                                $arlibs[]=$requested_html[$r]["language"].$requested_html[$r]["key"].$requested_html[$r]["type"].$requested_html[$r]["path"];
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
                            $alamatfieldjsinsert="";
                            for($r=0; $r<count($requested_html);$r++){
                              if($requested_html[$r]["key"]=="form_field_js_insert"){
                                if($requested_html[$r]["type"]==$thefield->type){
                                  $alamatfieldjsinsert=$requested_html[$r]["file"];
                                  break;
                                }
                              }
                            }
                  if (file_exists($alamatfieldjsinsert)) {
                  $isiloopjs=bacafile($alamatfieldjsinsert);
                  $copy_basejs.="\n".$isiloopjs;
                  }else{
                  }
                  }
                }
              }
              $alamatfieldjsloop="";
              for($r=0; $r<count($requested_html);$r++){
                if($requested_html[$r]["key"]=="page_element_js_declaration"){
                  if($requested_html[$r]["type"]==$manifest->moduls[$i]->page[$j]->elemen[$e]->type){
                    $alamatfieldjsloop=$requested_html[$r]["file"];
                    break;
                  }
                }
              }
                  if (file_exists($alamatfieldjsloop)) {
                  $isiloopjs=bacafile($alamatfieldjsloop);
                  $isiloopjs=str_replace("{elemen_id}",$manifest->moduls[$i]->page[$j]->elemen[$e]->id,$isiloopjs);
                  $page_elemen=$manifest->moduls[$i]->page[$j]->elemen[$e];
                  for($r=0; $r<count($requested_html);$r++){
                    if($requested_html[$r]["key"]=="page_element_script"){
                      if($requested_html[$r]["type"]==$manifest->moduls[$i]->page[$j]->elemen[$e]->type){
                        include($requested_html[$r]["file"]);
                        break;
                      }
                    }
                  }
                  $bahanawaljs.="\n".$isiloopjs;
                  }else{
                  }
                  $alamatpagelement="";
                  for($r=0; $r<count($requested_html);$r++){
                    if($requested_html[$r]["key"]=="page_element"){
                      if($requested_html[$r]["type"]==$manifest->moduls[$i]->page[$j]->elemen[$e]->type){
                        $alamatpagelement=$requested_html[$r]["file"];
                        break;
                      }
                    }
                  }
                  if (file_exists($alamatpagelement)) {
                  $isicontent=bacafile($alamatpagelement);
                  $page_elemen=$manifest->moduls[$i]->page[$j]->elemen[$e];
                  for($r=0; $r<count($requested_html);$r++){
                    if($requested_html[$r]["key"]=="page_element_script"){
                      if($requested_html[$r]["type"]==$page_elemen->type){
                        include($requested_html[$r]["file"]);
                        break;
                      }
                    }
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
              for($r=0; $r<count($requested_html);$r++){
                if($requested_html[$r]["key"]=="form_field_css_insert"){
                      $bahanreplacemasal["{copy_base_language_".$requested_html[$r]["language"]."}"]=$isicopy_baselanguage[$requested_html[$r]["language"]];
                }
                  if($requested_html[$r]["key"]=="page_element_css_insert"){
                        $bahanreplacemasal["{copy_base_language_".$requested_html[$r]["language"]."}"]=$isicopy_baselanguage[$requested_html[$r]["language"]];
                  }
              }
              $bahancopy_baseindexmodul=replacemasal($bahanreplacemasal,$bahancopy_baseindexmodul);
              $bahanreplacemasal=array();
              for($lib=0; $lib<count($libraries_warehouse); $lib++){
                $bahanreplacemasal["{copy_base_language_".$libraries_warehouse[$lib]."}"]="";
              }
              $bahancopy_baseindexmodul=replacemasal($bahanreplacemasal,$bahancopy_baseindexmodul);
              //file_put_contents($foldermvcviewpage."/index.php",$bahancopy_baseindexmodul);
              $ar_worktodo[]=array("type"=>"addfile","work_id"=>"writefileto".$foldermvcviewpage."/index.blade.php","file_id"=>$foldermvcviewpage."/index.blade.php","location"=>$foldermvcviewpage."/index.blade.php","content_from"=>"string","content"=>$bahancopy_baseindexmodul);
            }
              //akhir for page
            }
          //akhir for modul
          }
          $copy_baselayout=replacemasal(array(
            "{sidemenu}"=>$bahansidemenu
            ,"{js_functions}"=>""
            ,"{copy_js}"=>""
            ,"<br />"=>""),$copy_baselayout);
          $copy_baselayout=str_replace("<br />","",$copy_baselayout);
          $ar_worktodo[]=array("type"=>"addfile","work_id"=>"writelayout_frame_admin","file_id"=>"layout_frame_admin","location"=>"resources/views/layouts/layout_admin.blade.php","content_from"=>"string","content"=>$copy_baselayout);
  return $ar_worktodo;
}
}
 ?>
