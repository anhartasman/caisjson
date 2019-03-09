<?php

$content.="var ".$func->outputVariable." = \"\";"."\n";
$func_param=array();
$func_body.="var bahan_".$func->outputVariable." = \"\";"."\n";
if(isset($func->param )){
  if(count($func->param)>0){
    $func_body.="bahan_".$func->outputVariable." = ";
    for($i=0;$i<count($func->param);$i++){
      $func_body.=$func->param[$i];
      if(($i+1)<count($func->param)){
        $func_body.=" + ";
      }
    }
    $func_body.=";\n";
  }
}
$func_body.=$func->outputVariable." = bahan_".$func->outputVariable.";"."\n";
?>
