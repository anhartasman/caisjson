<?php

function modul_system_information($thejson){
  $themodul = std_modul();
  $themodul->id="system_information";
  $themodul->title="System Information";
  $themodul->subtitle="";

  $themodul->page[]=page_documentation($thejson);

  return $themodul;
}

function page_documentation($thejson){
  $manifest=$thejson;
  $thepage=std_page();
  $thepage->id="documentation";
  $thepage->title="System Documentation";


  return $thepage;
}


 ?>
