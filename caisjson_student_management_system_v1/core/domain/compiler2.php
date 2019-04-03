<?php

class compiler {

public function __construct() {

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
    include $theconfig->maker_path;
    $isi_ar=call_user_func($theconfig->maker_func,$manifest);
    $ar_worktodo=array_merge($ar_worktodo,$isi_ar);



return array("works"=>$ar_worktodo,"theconfig"=>$theconfig);
  //akhir file_teller
}

function file_composer($ar_worktodo,$theconfig){

    $ar_files=array();
    $ar_directories=array();
    $ar_functions=array();
    $ar_contents=array();
    $ar_declarations=array();
    $ar_footer=array();
    $ar_function_content=array();
    $ar_includes=array();
    $ar_auth=array();


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
              // echo "work_id : ".$ar_worktodo[$w]["work_id"]." type : ".$ar_worktodo[$w]["type"]."<br>";
               if((!in_array($ar_worktodo[$w]["work_id"],$finished_work_id)) && (!in_array($ar_worktodo[$w]["work_id"],$ar_canceled_work_id))){

                 switch($ar_worktodo[$w]["type"]){
                   case "addfile":
                   if(!in_array($ar_worktodo[$w]["file_id"],$exists_files_id)){
                     $ar_files[]=$ar_worktodo[$w];
                     $exists_files_id[]=$ar_worktodo[$w]["file_id"];
                   }
                   break;
                   case "addinclude":
                   if(!in_array($ar_worktodo[$w]["work_id"],$exists_files_include)){
                     $ar_includes[]=$ar_worktodo[$w];
                     $exists_files_include[]=$ar_worktodo[$w]["work_id"];
                   }
                   break;
                   case "addfunction":
                   if(!in_array($ar_worktodo[$w],$ar_functions)){
                     $ar_functions[]=$ar_worktodo[$w];
                   }
                   break;
                   case "add_auth":
                   if(!in_array($ar_worktodo[$w],$ar_auth)){
                     $ar_auth[]=$ar_worktodo[$w];
                   }
                   break;
                   case "add_declaration_to_function":
                   if(!in_array($ar_worktodo[$w],$ar_declarations)){
                     $ar_declarations[]=$ar_worktodo[$w];
                   }
                   break;
                   case "add_footer_to_function":
                   if(!in_array($ar_worktodo[$w],$ar_footer)){
                     $ar_footer[]=$ar_worktodo[$w];
                   }
                   break;
                   case "add_to_function":
                   if(!in_array($ar_worktodo[$w],$ar_function_content)){
                     $ar_function_content[]=$ar_worktodo[$w];
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
                     $ar_directories[]=$ar_worktodo[$w];
                     $exists_folder_id[]=$ar_worktodo[$w]["directory_id"];
                   }
                   break;
                 }

                 $finished_work_id[]=$ar_worktodo[$w]["work_id"];
               }
             }

                          for($w=0; $w<count($finished_work_id);$w++){
                          //  echo "selesai ".$finished_work_id[$w]."<BR>";
                          }

    $paket=array(
      "language"=>"php"
      ,"ar_files"=>$ar_files
      ,"ar_directories"=>$ar_directories
      ,"ar_includes"=>$ar_includes
      ,"ar_functions"=>$ar_functions
      ,"ar_contents"=>$ar_contents
      ,"ar_declarations"=>$ar_declarations
      ,"ar_footer"=>$ar_footer
      ,"ar_function_content"=>$ar_function_content
      ,"ar_auth"=>$ar_auth
      ,"theconfig"=>$theconfig
    );

return $paket;
  //akhir file_composer
}

function file_worker($package,$filedirection){
  $language=$package["language"];
  $theconfig=$package["theconfig"];
  $ar_files=$package["ar_files"];
  $ar_functions=$package["ar_functions"];
  $ar_contents=$package["ar_contents"];
  $ar_declarations=$package["ar_declarations"];
  $ar_footer=$package["ar_footer"];
  $ar_function_content=$package["ar_function_content"];
  $ar_includes=$package["ar_includes"];
  $ar_directories=$package["ar_directories"];
  $ar_auth=$package["ar_auth"];

  echo "<BR><BR><BR>jumlah directories : ".count($ar_directories)."<BR>";
  for($w=0; $w<count($ar_directories);$w++){
    echo "- ".$ar_directories[$w]["location"];

    if (!file_exists($filedirection.$ar_directories[$w]["location"])) {
      mkdir($filedirection.$ar_directories[$w]["location"], 0777, true);
      echo ": done ";
    }
    echo "<BR>";

  }

  echo "<BR><BR><BR>jumlah files : ".count($ar_files)."<BR>";
  for($w=0; $w<count($ar_files);$w++){
    $boxcontent="";
    $include_content="";
    $class_content="";
    $class_content_write="";
    echo "<b>file_name : ".$ar_files[$w]["file_id"]."</b><BR>";
    echo "file_location : ".$ar_files[$w]["location"]."<BR>";

    if(!isset($ar_files[$w]["content_from"])){
      $ar_files[$w]["content_from"]="string";
    }

    switch($ar_files[$w]["content_from"]){
      case "file":
      //echo "baca file ".$ar_files[$w]["content"];
      if (file_exists($filedirection.$ar_files[$w]["content"])) {
        $class_content=bacafile($filedirection.$ar_files[$w]["content"]);
      }
      break;
      case "string":
      $class_content=$ar_files[$w]["content"];
      break;
    }
    //$class_content="AAA";
    $the_file_includes=array();
    $the_file_included=array();
    for($wf=0; $wf<count($ar_includes);$wf++){
      if($ar_includes[$wf]["file_id"]==$ar_files[$w]["file_id"]){
        if(!in_array($ar_includes[$wf]["include_id"],$the_file_included)){
          $the_file_includes[]=$ar_includes[$wf];
          $the_file_included[]=$ar_includes[$wf]["include_id"];
        }
      }
    }
    echo "<BR>";

    echo "jumlah includes : ".count($the_file_includes)."<BR>";
    echo "includes : ";
    for($wf=0; $wf<count($the_file_includes);$wf++){
      echo $the_file_includes[$wf]["include_id"].",";
      $include_content.=$the_file_includes[$wf]["content"];
    }
    echo "<BR>";

    $the_file_functions=array();
    for($wf=0; $wf<count($ar_functions);$wf++){
      if($ar_functions[$wf]["file_id"]==$ar_files[$w]["file_id"]){
        $the_file_functions[]=$ar_functions[$wf];
      }
    }
    echo "<BR>jumlah functions : ".count($the_file_functions)."<BR> ";
    echo "functions : ";
    for($wf=0; $wf<count($the_file_functions);$wf++){
      echo $the_file_functions[$wf]["function_name"].",";
      $function_param="";
      for($fu=0;$fu<count($the_file_functions[$wf]["param"]);$fu++){
        $function_param.=$the_file_functions[$wf]["param"][$fu];
        if($fu+1<count($the_file_functions[$wf]["param"])){
          $function_param.=",";
        }
      }
      if(!isset($the_file_functions[$wf]["starter"])){
        $the_file_functions[$wf]["starter"]="function";
      }
      $class_content_write.=$the_file_functions[$wf]["starter"]." ".$the_file_functions[$wf]["function_name"]."(".$function_param."){"."\n";


        for($fc=0; $fc<count($ar_declarations);$fc++){
          if($ar_declarations[$fc]["function_id"]==$the_file_functions[$wf]["function_id"]){
            $class_content_write.=$ar_declarations[$fc]["content"]."\n\n";
              //echo "deklarasi var ".$ar_declarations[$fc]["content"].",";
          }
        }

        $function_content="";
        for($fc=0; $fc<count($ar_function_content);$fc++){
          if($ar_function_content[$fc]["function_id"]==$the_file_functions[$wf]["function_id"]){
            $function_content.=$ar_function_content[$fc]["content"]."\n\n";
            //echo $ar_function_content[$fc]["content"]."\n\n";
          }
        }

        for($fc=0; $fc<count($ar_footer);$fc++){
          //$class_content_write.=$ar_function_content[$fc]["function_id"]."-".$the_file_functions[$wf]["function_id"]."\n";
          if($ar_footer[$fc]["function_id"]==$the_file_functions[$wf]["function_id"]){
            $function_content.=$ar_footer[$fc]["content"]."\n\n";
          }
        }

        for($a=0; $a<count($ar_auth);$a++){
          if($ar_auth[$a]["function_id"]==$the_file_functions[$wf]["function_id"]){
            $function_content=$ar_auth[$a]["content"].$function_content.$ar_auth[$a]["content_footer"];
          }
        }
        $class_content_write.=$function_content;

        $class_content_write.="//end of ".$the_file_functions[$wf]["starter"]." ".$the_file_functions[$wf]["function_name"]."\n\n";
        $class_content_write.="}"."\n\n";

      }
      echo "<BR><BR>";

      $class_content=str_replace("{write}",$class_content_write,$class_content);
      $class_content=str_replace("{construct_content}","",$class_content);
      $class_content=str_replace("{model_name}","model_".$ar_files[$w]["file_id"],$class_content);
      $class_content=str_replace("{include}",$include_content,$class_content);

      if(strpos("tes".$class_content."tes","{{")){

        $ledakan= (explode("{{",$class_content));
        for($l=1;$l<count($ledakan);$l++) {
          $subledakan= (explode("}}",$ledakan[$l]));
          $kontennya=$subledakan[0];
          $jsonkon=json_decode("{".$kontennya."}");
          if(isset($jsonkon->var_name)){
            $bahanvar=create_variable_web($jsonkon);
          //echo "Kontennya".$bahanvar;
          $class_content=str_replace("{{".$subledakan[0]."}}","{{".$bahanvar."}}",$class_content);

          }
          //$class_content=str_replace("properties_".$subledakan[0]."\"".$subledakan[1]."\"","",$class_content);
        }

      }

            if(strpos("tes".$class_content."tes","{cais_public_assets_")){

              $ledakan= (explode("{cais_public_assets_",$class_content));
              for($l=1;$l<count($ledakan);$l++) {
                $subledakan= (explode("}",$ledakan[$l]));
                $kontennya=$subledakan[0];
                $isidirektori=get_public_assets_directory($kontennya);
                $class_content=str_replace("{cais_public_assets_".$subledakan[0]."}",$isidirektori,$class_content);

                //$class_content=str_replace("properties_".$subledakan[0]."\"".$subledakan[1]."\"","",$class_content);
              }

            }
                  $ledakan= (explode("properties_",$class_content));

                    for($l=1;$l<count($ledakan);$l++) {
                      $subledakan= (explode("\"",$ledakan[$l]));
                      $class_content=str_replace("properties_".$subledakan[0]."\"".$subledakan[1]."\"","",$class_content);
                    }

      $class_content=str_replace("{cais_web_url}",$theconfig->web_url,$class_content);
      $class_content=str_replace("{cais_web_folder}",$theconfig->web_folder,$class_content);

      //echo "<textarea style=\"width:500px; height:100px\" >".$class_content."</textarea><br><br>";
      //echo "<pre><code class=\"language-markup\" style=\"max-height: 15px;overflow: scroll;\">".$class_content."</code></pre><br>";
      //nonaktifkan komen untuk menulis ke file
      //echo $class_content."\n";

      file_put_contents($filedirection.$ar_files[$w]["location"],$class_content);

      //echo "tulis ke ".$filedirection.$ar_files[$w]["location"]."\n";
    }

    echo "<br><br><br>";

    //end of file_worker
  }

}
 ?>
