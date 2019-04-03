<?php
function func_process_url_catcher($engine,$pro,$action){
  $objreturn=new \stdClass();
  $content="";
  $varjsawal="";
  $include=array();
  $deklarasi=array();
  $varphpawal=array();
  $ar_worktodo=array();
  $properties_modul=$pro->properties_modul;
  $properties_page=$pro->properties_page;
  $controller_nickname="controller_".$properties_modul;
  $page_nickname="page_".$properties_page;
  $page_name_controller=$page_nickname.$controller_nickname;
  $work_id="";
  //------------------------
  //tempat skrip
  $thecatcher=$engine;

  $work_id="add_url_catcher_".$thecatcher->variable."_to_function_".$properties_page."_in_".$properties_modul;
  $thecontent="";
  $thecontent.='$'.$engine->variable.' = null;'."\n";
  $thecontent.='for($i=0; $i<count($url_catch); $i++){'."\n";
    $thecontent.='if($url_catch[$i]=="'.$thecatcher->catch.'"){'."\n";
      $thecontent.='if($i+1<=count($url_catch)){'."\n";
        $thecontent.='$'.$thecatcher->variable.' = $url_catch[$i+1];'."\n";
        $thecontent.='if(strpos("tes".$'.$engine->variable.'."tes","modal=iya")){'."\n";
        $thecontent.='$variables["prepage"] = ".modal ";'."\n";
        $thecontent.='}'."\n";
        $thecontent.='$'.$engine->variable.' = str_replace("?modal=iya","",$'.$engine->variable.');'."\n";
        $thecontent.='$'.$engine->variable.' = str_replace("&modal=iya","",$'.$engine->variable.');'."\n";
        $thecontent.='$variables[\''.$thecatcher->variable.'\'] = $'.$thecatcher->variable.';'."\n";
        $thecontent.='}'."\n";
        $thecontent.='break;'."\n";
        $thecontent.='}'."\n";
        $thecontent.='}'."\n";

        $content.=$thecontent."\n";

        $varjsawal.='<?php $'.$engine->variable.' = str_replace("?modal=iya","",$'.$engine->variable.'); ?>'."\n";
        $varjsawal.='<?php $'.$engine->variable.' = str_replace("&modal=iya","",$'.$engine->variable.'); ?>'."\n";
        $varjsawal.='var catch_'.$engine->variable.'=<?php print($'.$engine->variable.'); ?>;'."\n";

        $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>$work_id,"function_id"=>"function_".$page_name_controller,"content"=>'$url_catch = explode("/",$_SERVER["REQUEST_URI"]);'."\n");

  //------------------
  //balikan
  $objreturn->content=$content;
  $objreturn->varjsawal=$varjsawal;
  $objreturn->deklarasi=$deklarasi;
  $objreturn->varphpawal=$varphpawal;
  $objreturn->include=$include;
  $objreturn->ar_worktodo=$ar_worktodo;
  //echo "kerja nyata ".count($objreturn->ar_worktodo)."<BR>";
  //akhir render_engine
  return $objreturn;

}
?>
