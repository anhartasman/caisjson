<?php
$contentname="content_of_".$func->func_name;
$func_param=array(array("name"=>"data".$func->func_name),array("name"=>"target".$func->func_name));
$func_body.=$copy_base_jsvoid;
if(isset($func->variable)){
  $func_body.="$func->variable = ".$contentname.";"."\n";
}
$func_footer.="return ".$contentname.";"."\n";
?>
