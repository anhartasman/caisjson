<?php
function create_web_onload_listener($elemen,$tolisten){
  $content="";

  for ($o=0; $o<count($tolisten->functions); $o++){

    $bahanlistener=create_web_function_caller($tolisten->functions[$o]);
    $content.=$bahanlistener."\n";

  }

  return $content;
}
 ?>
