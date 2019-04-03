<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>CAIS Framework</title>
	<link href="creatorassets/css/prism.css" rel="stylesheet" />
  <style>

  @import url(https://fonts.googleapis.com/css?family=Questrial);
  @import url(https://fonts.googleapis.com/css?family=Arvo);

  @font-face {
  	src: url(https://lea.verou.me/logo.otf);
  	font-family: 'LeaVerou';
  }


  code, pre {
  	font-family: Consolas, Monaco, 'Andale Mono', 'Lucida Console', monospace;
  	hyphens: none;
  }

  pre {
  	max-height: 30em;
  	overflow: auto;
  }

  pre > code.highlight {
  	outline: .4em solid red;
  	outline-offset: .4em;
  }

  </style>
</head>
<body>
	<script src="creatorassets/js/prism.js"></script>
  <?php
include 'koneksiSQL.php';
include 'fungsi.php';
include 'makers/maker_php.php';
$myfile = fopen("project_manifest.json", "r") or die("Unable to open file!");
$isijson= fread($myfile,filesize("project_manifest.json"));
$ar_worktodo=array();

//$isijson=trim($isijson);
$cariinclude=explode('{"include":"',$isijson);
  for($car=1;$car<count($cariinclude);$car++){
    $bahanambil=explode('"}',$cariinclude[$car]);
    $ambil=$bahanambil[0];
    $copy_ambil=bacafile($ambil);
    $copy_ambil=str_replace("<br />","",$copy_ambil);
    $isijson=str_replace('{"include":"'.$ambil.'"}',$copy_ambil,$isijson);
    //echo '{"include":"'.$ambil.'"}';
  }
$manifest = json_decode($isijson); // decode the JSON into an associative array
//echo $isijson;


$ar_fungsi=new \stdClass();
$ar_fungsi_baru=array();
$_SESSION['ar_fungsi']=$ar_fungsi_baru;
$ar_files=array();
$ar_directories=array();
$ar_functions=array();
$ar_contents=array();
$ar_declarations=array();
$ar_footer=array();
$ar_function_content=array();
$ar_includes=array();
$ar_auth=array();

$ar_worktodo=array_merge($ar_worktodo,makePHP($manifest));

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
);

write_the_file($paket);

function write_the_file($package){
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
    file_put_contents($ar_files[$w]["location"],$class_content);

  }

    echo "<br><br><br>";

    //end of write_the_file
}

 ?>
</body>
</html>
