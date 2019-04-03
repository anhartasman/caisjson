<?php
$bahanth="";
$bahantd="";
for ($c=0; $c<count($page_elemen->columns); $c++){
  $bahanth.="<th>".$page_elemen->columns[$c]."</th>\n";
  $bahantd.="<td></th>\n";
}

//$bahanth.="<th><a href=\"aaa\">AAA</a></th>\n";

$isicontent=str_replace("{list_th}",$bahanth,$isicontent);
$isicontent=str_replace("{list_td}",$bahantd,$isicontent);
 ?>
