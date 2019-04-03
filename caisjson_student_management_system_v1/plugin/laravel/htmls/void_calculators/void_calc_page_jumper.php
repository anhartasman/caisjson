<?php
$func_param=array(array("name"=>"modul".$func->func_name),array("name"=>"page".$func->func_name));
$thelink=get_project_url_js("modul".$func->func_name,"page".$func->func_name,$func->page_jumper_package);
$copy_base_jsvoid=str_replace("{thelink}",$thelink,$copy_base_jsvoid);
$func_body.=$copy_base_jsvoid;
 ?>
