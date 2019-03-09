<?php
$registered_compilers=array();
$registered_compilers[]=array("name"=>"web","desc"=>"Native Web","makers_folder"=>"vanilla","maker_folder_path"=>"plugin/vanilla","maker_path"=>"plugin/vanilla/maker_php.php","presenter_path"=>"plugin/vanilla/presenter.php","maker_func"=>"makePHP","teller_include"=>array(array("for"=>"config","properties"=>"requested_html","properties_equal_var"=>"requested_html","file"=>"/htmls/registered_htmls.php")));
$registered_compilers[]=array("name"=>"weblaravel","desc"=>"Laravel's Web","makers_folder"=>"laravel","maker_folder_path"=>"plugin/laravel","maker_path"=>"plugin/laravel/maker_laravel.php","presenter_path"=>"plugin/laravel/presenter.php","maker_func"=>"makeLaravel","teller_include"=>array(array("for"=>"config","properties"=>"requested_html","properties_equal_var"=>"requested_html","file"=>"/htmls/registered_htmls.php")));
 ?>
