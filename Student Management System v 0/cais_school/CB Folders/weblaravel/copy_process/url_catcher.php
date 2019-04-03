${variable} = null;
for($i=0; $i<count($url_catch); $i++){
if($url_catch[$i]=="{catch}"){
if($i+1<=count($url_catch)){
${variable} = $url_catch[$i+1];
$variables['{variable}'] = ${variable};
}
break;
}
}
