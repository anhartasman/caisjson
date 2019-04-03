<?php
function create_web_onchange_listener($elemen,$tolisten){
  $bahanreturn="";
  $namavariablefield="";
  if(!isset($elemen->variable)){
    $namavariablefield="isian_".$elemen->id;
    $elemen->variable=$namavariablefield;
  }else{
    $namavariablefield=$elemen->variable;
  }
  if($elemen->type!="image"){
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
        $listener_content.=$namavariablefield."_textvalue = $(\"<?php if(isset(\$prepage)){print(\$prepage);} ?>#".$elemen->id." option:selected\").text();"."\n";
        $listener_content.=$namavariablefield." = $(\"<?php if(isset(\$prepage)){print(\$prepage);} ?>#".$elemen->id."\").val();"."\n";
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
                $listener_content.=$namavariablefield." = $(\"<?php if(isset(\$prepage)){print(\$prepage);} ?>#".$elemen->id."\").val();"."\n";
                break;
              }

              for ($o=0; $o<count($tolisten->functions); $o++){

                $bahanlistener=create_web_function_caller($tolisten->functions[$o]);
                $listener_content.=$bahanlistener."\n";

              }
              $listener=str_replace("{content}",$listener_content,$listener);
              $bahanreturn=$listener;
            }
            return $bahanreturn;
          }
 ?>
