<?php
function getCurrentURL()
{

      $currentURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
      $currentURL .= $_SERVER["SERVER_NAME"];

      if($_SERVER["SERVER_PORT"] != "80" && $_SERVER["SERVER_PORT"] != "443")
      {
          $currentURL .= ":".$_SERVER["SERVER_PORT"];
      }

          $currentURL .= $_SERVER["REQUEST_URI"];

      return $currentURL;

}

function getVariables(){
$variables=array();
$base_url="{cais_web_url}";
$base_upload_directory="/uploads/";
$variables['base_url']=$base_url;
$variables['base_number_random']=rand(1,1000000);
$variables['base_date']=date("Y-m-d");
$variables['base_date_time']=date("Y-m-d h:i:s");
$variables['base_upload_directory']=$base_upload_directory;

{write_variables}

  return $variables;
}

 ?>
