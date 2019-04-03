<?php
function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

function bacafile($file_address){
  $content="";
  if (file_exists($file_address)) {
  $file = fopen($file_address,"r");
  while(! feof($file))
    {
    $content.=fgets($file). "<br />";
    }
  fclose($file);
   }
   $content=str_replace("<br />","",$content);

   return $content;
}

    function json_validate($string)
    {
      json_decode($string);
      return (json_last_error() == JSON_ERROR_NONE);
    }

        function get_fungsi_name_new($modul,$page,$enginetype,$enginebody,$tambahan){
          $additional_name="";
           $ar_fungsi = $_SESSION['ar_fungsi'];
          switch($enginetype){
            case "table":
            $additional_name=$enginebody->process_name."_".$enginebody->table_name;
            break;
          }
          $thename="Go_".$enginetype."_for_modul_".$modul."_page_".$page."_".$additional_name;
          $hasilreturn=$thename;
            $dapatengine=0;
          for($a=0; $a<count($ar_fungsi); $a++){
            if($ar_fungsi[$a]["enginetype"]==$enginetype){
              $dapatengine=1;
                $dapatmodul=0;
              //  var_dump($ar_fungsi[$a]["modul"][0]["modul"]);
            for($m=0; $m<count($ar_fungsi[$a]["modul"]); $m++){
              if($ar_fungsi[$a]["modul"][$m]["modul"]==$modul){

                $dapatmodul=1;
                $dapatpage=0;
               for($p=0; $p<count($ar_fungsi[$a]["modul"][$m]["page"]); $p++){
                if($ar_fungsi[$a]["modul"][$m]["page"][$p]["page"]==$page){
                $dapatpage=1;
                  $thepage=$ar_fungsi[$a]["modul"][$m]["page"][$p];
              $dapat=0;
              //  echo count($thepage["name_list"])."<BR>";
              while($dapat==0){
              for($n=0; $n<count($thepage["name_list"]); $n++){
            //  echo $thepage["name_list"][$n]["body"]->id."<BR>";
            //echo json_encode($enginebody)."<BR>";
                if($thepage["name_list"][$n]["body"]==$enginebody){
                  $dapat=1;
                  $hasilreturn=$thepage["name_list"][$n]["function_name"];
                  break;
                }
              }
              if($dapat==0){

              $bisapasang=1;
              for($n=0; $n<count($thepage["name_list"]); $n++){
                if($thepage["name_list"][$n]["function_name"]==$thename){
                  $thename.=rand(1,1000);
                  $bisapasang=0;
                  break;
                }
              }
              if($bisapasang==1){
                $objbaru=array();
                $objbaru["function_name"]=$thename;
                $objbaru["body"]=$enginebody;
                $ar_fungsi[$a]["modul"][$m]["page"][$p]["name_list"][]=$objbaru;
                $hasilreturn=$thename;
                $dapat=1;
              }
              }
              }
              }
              }
              if($dapatpage==0){
                $objbaru=array("page"=>$page,"name_list"=>array(array("function_name"=>$thename,"body"=>$enginebody)));
                $ar_fungsi[$a]["modul"][$m]["page"][]=$objbaru;
                //  echo "GADA ".$modul." page ".$page;
                $hasilreturn=$thename;
              }
              }
              }
              if($dapatmodul==0){
              //  echo "GADA ".$modul." ".$thename;
                $objbaru=array("modul"=>$modul,"page"=>array(array("page"=>$page,"name_list"=>array(array("function_name"=>$thename,"body"=>$enginebody)))));
                $ar_fungsi[$a]["modul"][]=$objbaru;
                $hasilreturn=$thename;
              }
            }
          }

          if($dapatengine==0){
          //  echo "GADA enginetype ".$enginetype;
            $objbaru=array("enginetype"=>$enginetype,"modul"=>array(array("modul"=>$modul,"page"=>array(array("page"=>$page,"name_list"=>array(array("function_name"=>$thename,"body"=>$enginebody)))))));

            $ar_fungsi[]=$objbaru;
            $hasilreturn=$thename;
          }

          //echo count($ar_fungsi)."<BR>";
          $objreturn=new \stdClass();

          $objreturn->function_name=$hasilreturn;
          $objreturn->ar_fungsi=$ar_fungsi;
          $_SESSION['ar_fungsi']=$ar_fungsi;
          return $objreturn;

          //akhir get_fungsi_name_new
        }

function rekursifmodulpage($arnya,$con_name,$page_name){
//echo "api ".$page_name."<BR>";
  foreach($arnya as $category){
    if(is_array($category)){
      rekursifmodulpage($category,$con_name,$page_name);
    }else if (is_object($category)) {
      $category->properties_modul=$con_name;
        $category->properties_page=$page_name;
        rekursifmodulpage($category,$con_name,$page_name);
    }else{
      //$category->properties_modul="NAMA MODUL";
    }
  }

}



function rekursifprosesmodulpage($isitoproses,$controller_name,$model_name){
  $ar_worktodo=array();
                foreach($isitoproses as $key=>$category){
                  if(is_array($category)){
                  //echo $key."<BR>";
                    $ar_worktodo=array_merge($ar_worktodo,renderwhattodo($key,$category,$isitoproses));
                    $ar_worktodo=array_merge($ar_worktodo,rekursifprosesmodulpage($category,$controller_name,$model_name));
                  }else if (is_object($category)) {
                  //echo $key."<BR>";
                    $ar_worktodo=array_merge($ar_worktodo,renderwhattodo($key,$category,$isitoproses));
                    $ar_worktodo=array_merge($ar_worktodo,rekursifprosesmodulpage($category,$controller_name,$model_name));
                  }else{
                  }
                }
 return $ar_worktodo;
}

function renderwhattodo($key,$obj,$bodyawal){
  $ar_worktodo=array();
  $key=(string)$key;
  if($key=="process"){
  //echo "key ".$key."<BR>";
  //var_dump($bodyawal)."<BR>";
  $grupengine=render_grup_engine((object)$bodyawal);
  $ar_worktodo=array_merge($ar_worktodo,$grupengine->ar_worktodo);
  //print($grupengine->deklarasi)."<BR>";
    //echo $obj->title;
    echo "<BR>";
  }

  return $ar_worktodo;
}


function replacemasal($ar_replace,$konten){
  $content=$konten;
  foreach($ar_replace as $key=>$value){
    $content=str_replace($key,$value,$content);
    //echo "replace ".$key." dengan ".$value."<BR>";
  }
  return $content;
}

  function write_the_files($package){
    $language=$package["language"];

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

        if (!file_exists($ar_directories[$w]["location"])) {
          mkdir($ar_directories[$w]["location"], 0777, true);
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
        if (file_exists($ar_files[$w]["content"])) {
          $class_content=bacafile($ar_files[$w]["content"]);
        }
        break;
        case "string":
        $class_content=$ar_files[$w]["content"];
        break;
      }

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
      //echo "<textarea style=\"width:500px; height:100px\" >".$class_content."</textarea><br><br>";
      //echo "<pre><code class=\"language-markup\" style=\"max-height: 15px;overflow: scroll;\">".$class_content."</code></pre><br>";
      //nonaktifkan komen untuk menulis ke file
      //file_put_contents($ar_files[$w]["location"],$class_content);
      //echo "tulis ke ".$ar_files[$w]["location"],$class_content."\n";
    }

      echo "<br><br><br>";

      //end of write_the_files
  }

 ?>
