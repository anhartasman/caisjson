<?php
$bahanjs=bacafile("plugin/vanilla/htmls/js_loops/jsloop_select2.txt");
$bahanjs=str_replace("{elemen_id}",$field->id,$bahanjs);

$isijs=$bahanjs."\n";
if(isset($dropdown->option_label_from)){
  switch($field->option_label_from){
    case "hardcoded_array":

    break;
  }
}

$dropdown_content=create_web_element_dropdown($field);
$isicontent=$dropdown_content->content;
$isijs.=$dropdown_content->js_content;
$varjsawal.=$dropdown_content->varjsawal;
 ?>
