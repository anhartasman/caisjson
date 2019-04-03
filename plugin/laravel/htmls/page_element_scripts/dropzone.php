<?php
//$bahanth.="<th><a href=\"aaa\">AAA</a></th>\n";

switch($page_elemen->useby){
  case "hotel_images":
  $isiloopjs=str_replace("{dropzone_ajax_file_list_url}","\"{cais_web_url}/admin/tabel_hotel/dropzone_hotel_images?hotel_id=\"+catch_hotel_id",$isiloopjs);
  $isiloopjs=str_replace("{dropzone_ajax_upload_url}","\"{cais_web_url}/admin/tabel_hotel/upload_hotel_images\"",$isiloopjs);
  break;
}
?>
