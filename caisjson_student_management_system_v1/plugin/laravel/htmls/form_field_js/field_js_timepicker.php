<?php

$bahanjs=bacafile("plugin/laravel/htmls/js_loops/jsloop_timepicker.txt");
$bahanjs=str_replace("{elemen_id}",$field->id,$bahanjs);
$date_format="dd/mm/yyyy";
if(isset($field->date_format)){
  $date_format=$field->date_format;
}
$bahanjs=str_replace("{date_format}",$date_format,$bahanjs);
$isijs.=$bahanjs."\n";
 ?>
