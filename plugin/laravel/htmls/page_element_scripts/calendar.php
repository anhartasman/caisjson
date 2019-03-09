<?php

//$bahanth.="<th><a href=\"aaa\">AAA</a></th>\n";
echo "DARI CALENDAR ".$alamatpagelement;
$elemen_value_var='$value_'.$page_elemen->id;
if(isset($page_elemen->value_var)){
$elemen_value_var=create_variable_web($page_elemen->value_var);
$isiloopjs=str_replace("{elemen_value_var}",$elemen_value_var,$isiloopjs);
$isiloopjs=str_replace("{elemen_value_start_date}",$page_elemen->value_start_date,$isiloopjs);
$isiloopjs=str_replace("{elemen_value_end_date}",$page_elemen->value_end_date,$isiloopjs);
$isiloopjs=str_replace("{elemen_value_title}",$page_elemen->value_title,$isiloopjs);
}
 ?>
