<?php
function create_web_onclick_listener($elemen,$tolisten){
  $content='$("#{field_id}").on( \'click\', function () {'."\n";
    $content.="{content}"."\n";
    $content.="});"."\n";

    $listener=str_replace("{field_id}",$elemen->id,$content);
    $listener_content="";
    for ($o=0; $o<count($tolisten->functions); $o++){
      $bahanlistener="";
      $namavarreturn="";
      $bahanlistener=create_web_function_caller($tolisten->functions[$o]);

      $listener_content.=$bahanlistener."\n";
    }
    $listener=str_replace("{content}",$listener_content,$listener);

    return $listener;
  }
 ?>
