<?php
$func_param=[];
//write script here

$content.="var ajaxjson_".$func->func_name.";"."\n";


$api_param=array();
$api_param["modul"]=$func->modul;
$api_param["action"]=$func->action;
for($p=0; $p<count($func->param); $p++){
  $api_param_obj=array();
  $api_param[$func->param[$p]->index]=$func->param[$p]->value;
  //$api_param[]=$func->param[$p];
}
$encoded_param=json_encode($api_param);
$encoded_param2=json_encode($api_param);
$encoded_param = preg_replace('/\s*:"([^"]+)"\s*/', ':$1', $encoded_param);
$encoded_param=str_replace($func->modul,"\"$func->modul\"",$encoded_param);
$encoded_param=str_replace($func->action,"\"$func->action\"",$encoded_param);

$nilaiparam="";
$nomurutapi=0;
foreach($api_param as $k=>$v){
  if($k=="modul"){
    $nilaiparam.="\"$k\":\"$v\"";
  }else if($k=="action"){
    $nilaiparam.="\"$k\":\"$v\"";
  }else {
    $nilaiparam.="\"$k\":$v";
  }

  if(($nomurutapi+1)<count($api_param)){
    $nilaiparam.=",";
  }
  $nomurutapi+=1;
}

echo "nilaiparam : ".$nilaiparam."<BR>";

$copy_base_jsvoid=str_replace("{api_param}",'{'.$nilaiparam.'}',$copy_base_jsvoid);
$func_body.=$copy_base_jsvoid;

$copy_base_statechanged="";
$copy_base_statechanged=bacafile("makers/vanilla/htmls/js_loops/jsloop_statechanged.txt");
$copy_base_statechanged=str_replace("<br />","",$copy_base_statechanged);

$func_change=$copy_base_statechanged;
$func_change=str_replace("{id}",$func->func_name,$func_change);
$func_change=str_replace("{onAPIReturn}",create_web_onapireturn_listener($func->onAPIReturn),$func_change);
$content.=$func_change."\n";
/**
if($func->func_name=="get_pilihan_kelas"){
echo "ADANIH!!!!\n\n\n\n".$func_change."\n\n\n";
}
**/


?>
