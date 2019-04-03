<?php
include 'koneksiSQL.php';
include 'fungsi.php';
$myfile = fopen("project_manifest.json", "r") or die("Unable to open file!");
$isijson= fread($myfile,filesize("project_manifest.json"));
//$isijson=trim($isijson);
$cariinclude=explode('{"include":"',$isijson);
  for($car=1;$car<count($cariinclude);$car++){
    $bahanambil=explode('"}',$cariinclude[$car]);
    $ambil=$bahanambil[0];
    $copy_ambil=bacafile($ambil);
    $copy_ambil=str_replace("<br />","",$copy_ambil);
    $isijson=str_replace('{"include":"'.$ambil.'"}',$copy_ambil,$isijson);
    //echo '{"include":"'.$ambil.'"}';
  }
$manifest = json_decode($isijson); // decode the JSON into an associative array
//echo $isijson;
$copy_baseheader=bacafile("copy_base/inc_body_header.php");
$copy_basefooter=bacafile("copy_base/inc_body_footer.php");
$copy_basesidetreeview=bacafile("copy_base/sidemenutreeview.txt");
$copy_basesideli=bacafile("copy_base/sidemenuli.txt");
$copy_baseclass=bacafile("copy_base/class.php");
$copy_base_statechanged=bacafile("copy_jsloop/jsloop_statechanged.txt");
$copy_base_statechanged=str_replace("<br />","",$copy_base_statechanged);


$system_content="";
for($i=0; $i<count($manifest->global_variables); $i++){
$system_content.=create_web_variable($manifest->global_variables[$i]);
$system_content.='$variables["'.$manifest->global_variables[$i]->name.'"]=$'.$manifest->global_variables[$i]->name.';'."\n";
}
//file_put_contents("admin/"."inc_modul_".$manifest->moduls[$i]->id."_page_".$manifest->moduls[$i]->page[$j]->id.".php",$writemodul);

$config_system_content=bacafile("copy_base/config_variables.php");
$config_system_content=str_replace("<br />","",$config_system_content);
$config_system_content=str_replace("{write}",$system_content,$config_system_content);
file_put_contents("utils/variables.php",$config_system_content);


$bahansidemenu="";
for($i=0; $i<count($manifest->moduls); $i++){

  $foldermvcview='mvc_view/'.$manifest->moduls[$i]->id;
  $folderlink='admin/'.$manifest->moduls[$i]->id;
  $bahanmenuli="";
  $bahantreeview=$copy_basesidetreeview;
  $myObj= new \stdClass();
  $myObj->place="sidemenu";

  if (!file_exists($foldermvcview)) {
    mkdir($foldermvcview, 0777, true);
  }

    if (in_array($myObj, $manifest->moduls[$i]->placement)){
      for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
        if (in_array($myObj, $manifest->moduls[$i]->page[$j]->placement)){
        $foldermvcviewpage=$foldermvcview.'/'.$manifest->moduls[$i]->page[$j]->id;
        $folderlinkpage=$folderlink.'/'.$manifest->moduls[$i]->page[$j]->id;
        $menuli=$copy_basesideli;
        $menuli=str_replace("{modul_id_page_id}",$manifest->moduls[$i]->id."_".$manifest->moduls[$i]->page[$j]->id,$menuli);
        $menuli=str_replace("{page_url}",$base_url."/".$folderlinkpage,$menuli);
        $menuli=str_replace("{page_title}",$manifest->moduls[$i]->page[$j]->title,$menuli);
        $bahanmenuli.="\n".$menuli;
        }
      }
      $bahantreeview=str_replace("{modul_id}",$manifest->moduls[$i]->id,$bahantreeview);
      $bahantreeview=str_replace("{modul_title}",$manifest->moduls[$i]->title,$bahantreeview);
      $bahantreeview=str_replace("{li}",$bahanmenuli,$bahantreeview);
      $bahansidemenu.="\n".$bahantreeview;
     }

  for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
    if(!isset($manifest->moduls[$i]->page[$j]->ignore)){
      $manifest->moduls[$i]->page[$j]->ignore=false;
    }
    if($manifest->moduls[$i]->page[$j]->ignore==false){

    if(!isset($manifest->moduls[$i]->page[$j]->frame)){
      $manifest->moduls[$i]->page[$j]->frame="adminpage";
    }

    $bahanawaljs="";
    $variabeljsawal="";
    $copy_basejs="";
    $arlibcss=array();
    $isicopy_basecss='$copy_basecss=array();'."\n";
    $thepage=$manifest->moduls[$i]->page[$j];
    $variabeljsawal.="var page_id=\"".$manifest->moduls[$i]->page[$j]->id."\";\n";
    $variabeljsawal.="var modul_id=\"".$manifest->moduls[$i]->id."\";\n";

      $foldermvcviewpage=$foldermvcview.'/'.$manifest->moduls[$i]->page[$j]->id;
      if (!file_exists($foldermvcviewpage)) {
        mkdir($foldermvcviewpage, 0777, true);
      }

      if(isset($thepage->process)){
        $grupengine=render_grup_engine($thepage);
        $variabeljsawal.=$grupengine->varjsawal;
        //akhir isset proses
      }

    $bahanpagecontent="";
    for($e=0; $e<count($manifest->moduls[$i]->page[$j]->elemen); $e++){
      if (file_exists("copy_jsinsert/jsinsert_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt")) {

      $isicopyjs=bacafile("copy_jsinsert/jsinsert_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt");
      //echo $isicopyjs;
      $copy_basejs.="\n".$isicopyjs;


    }
    if(isset($manifest->moduls[$i]->page[$j]->elemen[$e]->forms)){

      for($fm=0; $fm<count($manifest->moduls[$i]->page[$j]->elemen[$e]->forms); $fm++){
            for($fmf=0; $fmf<count($manifest->moduls[$i]->page[$j]->elemen[$e]->forms[$fm]->field); $fmf++){
              $thefield=$manifest->moduls[$i]->page[$j]->elemen[$e]->forms[$fm]->field[$fmf];

                  if (!in_array($thefield->type, $arlibcss)){
                  for($lib=0; $lib<count($manifest->library_web_css); $lib++){
                    if($manifest->library_web_css[$lib]->type=="field_".$thefield->type){
                      $isicopy_basecss.='$copy_basecss[]=array("name"=>"'.$manifest->library_web_css[$lib]->name.'","path"=>"'.$manifest->library_web_css[$lib]->path.'");'."\n";
                      $arlibcss[]=$thefield->type;

                      }
                    }
                  }
        if (file_exists("copy_jsinsertlibrary_formfield/jsformfield_".$thefield->type.".txt")) {
        $isiloopjs=bacafile("copy_jsinsertlibrary_formfield/jsformfield_".$thefield->type.".txt");
        $copy_basejs.="\n".$isiloopjs;
        }else{
          //echo "tak ada "."copy_jsloop/jsloop_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt";
        }


        }

      }

    }
        if (file_exists("copy_jsloop/jsloop_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt")) {
        $isiloopjs=bacafile("copy_jsloop/jsloop_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt");
        $isiloopjs=str_replace("{elemen_id}",$manifest->moduls[$i]->page[$j]->elemen[$e]->id,$isiloopjs);
        $bahanawaljs.="\n".$isiloopjs;


        }else{
          //echo "tak ada "."copy_jsloop/jsloop_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt";
        }

        if (file_exists("copy_elemen/elemen_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt")) {

        $isicontent=bacafile("copy_elemen/elemen_".$manifest->moduls[$i]->page[$j]->elemen[$e]->type.".txt");
        $page_elemen=$manifest->moduls[$i]->page[$j]->elemen[$e];
        switch($page_elemen->type){
          case "tabel":
          $bahanth="";
          $bahantd="";
          for ($c=0; $c<count($page_elemen->columns); $c++){
            $bahanth.="<th>".$page_elemen->columns[$c]."</th>\n";
            $bahantd.="<td></th>\n";
          }

          //$bahanth.="<th><a href=\"aaa\">AAA</a></th>\n";

        $isicontent=str_replace("{list_th}",$bahanth,$isicontent);
          $isicontent=str_replace("{list_td}",$bahantd,$isicontent);
          break;
          case "form":


          break;
        }

        $bahanform="";
        if(isset($page_elemen->forms)){
        $daftarform=$page_elemen->forms;
        for($df=0; $df<count($daftarform); $df++){

          $hasilrender=render_html_form_field($daftarform[$df]);
          $kontenvariabelform=$hasilrender->kontenvariabelform;
          $kontenfungsivalidasi=$hasilrender->kontenfungsivalidasi;
          $variabeljsawal.=$hasilrender->variabeljsawal;
          $bahanawaljs.=$hasilrender->bahanawaljs;
          $bahanform.=$hasilrender->bahanform;
        }


        }
        $isicontent=str_replace("{bahanform}",$bahanform,$isicontent);

        for ($c=0; $c<count($page_elemen->onload); $c++){
        $bahanawaljs.=$page_elemen->onload[$c]->func_name."(";

            for ($p=0; $p<count($page_elemen->onload[$c]->param); $p++){
              $bahanawaljs.=$page_elemen->onload[$c]->param[$p];
              if($p<count($page_elemen->onload[$c]->param)-1){
                $bahanawaljs.=",";
              }
            }
            $bahanawaljs.=");\n";

        }

        if(isset($page_elemen->attribute)){
          $bahanattribute="";

           foreach($page_elemen->attribute as $key=>$value) {
             $bahanattribute.=$key."=\"".$value."\"";
           }
        $isicontent=str_replace("{elemen_attribute}",$bahanattribute,$isicontent);
        }
        $isicontent=str_replace("{elemen_id}",$page_elemen->id,$isicontent);
        $isicontent=str_replace("{elemen_title}",$page_elemen->title,$isicontent);
        if(isset($page_elemen->link)){
        $headlink="";
        for ($l=0; $l<count($page_elemen->link->head); $l++){
          $thelink=$page_elemen->link->head[$l];
          $thehref="";
          $thelabel="";
          if(!isset($thelink->type)){
            $thelink->type="normal";
          }
          if(!isset($thelink->param)){
            $thelink->param=[];
          }
          if(!isset($thelink->href)){
            $thelink->href="";
          }
          if(!isset($thelink->label)){
            $thelink->label="";
          }
          switch($thelink->type){
            case "normal":
            $thehref=$thelink->href;
            $thelabel=$thelink->label;
            break;
            case "modul_page":
            $thehref=get_project_url_php($thelink->modul,$thelink->page,$thelink->param);
            $thelabel=$thelink->label;
            break;
          }
          $headlink.="<th><a href=\"".$thehref."\">".$thelabel."</a></th>\n";
        }
        $isicontent=str_replace("{head_link}",$headlink,$isicontent);
        }
        $bahanpagecontent.="\n".$isicontent;


        }

      //akhir for elemen
    }


    for($f=0; $f<count($manifest->moduls[$i]->page[$j]->functions); $f++){
      $thefunc=$manifest->moduls[$i]->page[$j]->functions[$f];
      $thefunc->modul_id=$manifest->moduls[$i]->id;
      $thefunc->page_id=$manifest->moduls[$i]->page[$j]->id;
      $func=create_web_function($thefunc)->content;
      $func=str_replace("{func_param}","",$func);
      $bahanawaljs.=$func;
    }

    $bahanawaljs=$variabeljsawal.$bahanawaljs;

    $copy_baseindexmodul=bacafile("copy_base/frame_".$manifest->moduls[$i]->page[$j]->frame.".php");
    $bahancopy_baseindexmodul=$copy_baseindexmodul;
    $bahancopy_baseindexmodul=str_replace("{modul_id_page_id}",$manifest->moduls[$i]->id."_".$manifest->moduls[$i]->page[$j]->id,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{modul_id}",$manifest->moduls[$i]->id,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{page_name}",$manifest->moduls[$i]->page[$j]->title." | ".$manifest->project_name,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{copy_basecss}",$isicopy_basecss,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{page_title}",$manifest->moduls[$i]->page[$j]->title,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{page_subtitle}",$manifest->moduls[$i]->page[$j]->subtitle,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{page_content}",$bahanpagecontent,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{footer_js}",$bahanawaljs,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{copy_js}",$copy_basejs,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("{modul_title}",$manifest->moduls[$i]->title,$bahancopy_baseindexmodul);
    $bahancopy_baseindexmodul=str_replace("<br />","",$bahancopy_baseindexmodul);

    file_put_contents($foldermvcviewpage."/index.php",$bahancopy_baseindexmodul);

    $writemodul="<?php"."\n";
    $writemodul.='$main->page_'.$manifest->moduls[$i]->page[$j]->id.'(); '."\n";
    $writemodul.='?> '."\n";
    file_put_contents("admin/"."inc_modul_".$manifest->moduls[$i]->id."_page_".$manifest->moduls[$i]->page[$j]->id.".php",$writemodul);

  }
    //akhir for page
  }

//akhir for modul
}

$ar_table=new \stdClass();
$ar_fungsi=new \stdClass();
$ar_table_name=array();
$dafModul=array();
for($m=0; $m<count($manifest->moduls); $m++){
  $controller_name=$manifest->moduls[$m]->id;
  $dafModul[$m]["controller_name"]=$controller_name;
  $dafModul[$m]["funcs"]=array();
  $write="";
  $include="";
  $ar_table_name_inside_page_modul=array();
 for($p=0; $p<count($manifest->moduls[$m]->page); $p++){
    $function_content="";
   $thepage=$manifest->moduls[$m]->page[$p];


              if(isset($thepage->engine)){
                for($eng=0;$eng<count($thepage->engine);$eng++){
                  if($thepage->engine[$eng]->type=="url_catcher"){

                    if(count($thepage->engine[$eng]->content)>0){
                      $function_content.='$url_catch = explode("/",$_SERVER["REQUEST_URI"]);'."\n";
                    }
                  }
                }
              }
   $func_name=$thepage->id;

   $function_content.='$obj_'.$func_name." = new model_".$func_name."();\n";
   $function_content.='$obj_'.$func_name.'->db=$this->db;'."\n";
   $function_content.='$variables=$this->variables;'."\n";
   $function_content.='extract($variables);'."\n";

   $dafVariable=array();
   $ar_table_name_inside_api_action=array();
   if(isset($thepage->process)){
     $grupengine=render_grup_engine($thepage);
     $function_content.=$grupengine->content;

     foreach($thepage->process as $pro){

         switch($pro->type){
           case "table":
                      if(isset($thepage->engine)){
                        for($eng=0;$eng<count($thepage->engine);$eng++){
                          if($thepage->engine[$eng]->type=="table"){

                            for($ca=0; $ca<count($thepage->engine[$eng]->content); $ca++){
                              if($thepage->engine[$eng]->content[$ca]->id==$pro->id){
                                $table_action=$thepage->engine[$eng]->content[$ca];
                                $table_name=$table_action->table_name;
                                $func_name_now=get_fungsi_name($ar_fungsi,$controller_name,$func_name,"crud_".$table_action->process_name."DataForModul_".$controller_name."_Page_".$func_name,$table_name);
                                $ar_fungsi=$func_name_now->ar_fungsi;
                                $table_action->func_name=$func_name_now->hasilreturn;
                                $table_action->need="caller";
                                $getengine=render_engine("table",$table_action,$pro,null);


                                 if (!in_array($table_name, $ar_table_name_inside_page_modul)){
                                   $ar_table_name_inside_page_modul[]=$table_name;
                                   $include.='include '.'"../mvc_model/model_tabel_'.$table_name.'.php";'."\n";
                                 }
                                 if (!in_array($table_name, $ar_table_name)){

                                  $ar_table_name[]=$table_name;

                                  $ar_table->$table_name= new \stdClass();
                                  $ar_table->$table_name->table_name=$table_name;
                                  $ar_table->$table_name->api_array=array();

                                }
                                $bahanapi= new \stdClass();
                                $bahanapi->func_name=$func_name_now->hasilreturn;
                                $bahanapi->table=$table_action;
                                $bahanapi->action=$thepage;
                                $ar_table->$table_name->api_array[]=$bahanapi;


                                if (!in_array($table_name, $ar_table_name_inside_api_action)){
                                  $ar_table_name_inside_api_action[]=$table_name;
                                  $function_content.=$getengine->deklarasi;
                                }

                                if($table_action!=null){
                                $function_content.=$getengine->content."\n";

                                $dafVariable[]=$table_action->outputVariable;
                                }
                                break;
                              }
                            }

                          }
                        }
                      }

           break;
         }
     }
     //akhir isset proses
   }

   $function_content.='$obj_'.$func_name.'->variables=$variables;'."\n";

   $function_content.='include "../mvc_view/'.$controller_name.'/'.$func_name.'/index.php";'."\n";
   $include.='include '.'"../mvc_model/model_'.$func_name.'.php";'."\n";
   $loop_func=get_string_between($copy_baseclass,"{loop_func}","{/loop_func}");
   $loop_func=str_replace("{func_name}","page_".$func_name,$loop_func);
   $loop_func=str_replace("{param}","",$loop_func);
   $loop_func=str_replace("{function_content}",$function_content,$loop_func);
   $loop_func=str_replace("<br />","",$loop_func);
   $write.=$loop_func."\n";
   $writemodel_function="";

       $model_content=$copy_baseclass;
       $model_content=str_replace("{write}",$writemodel_function,$model_content);
       $model_content=str_replace("{model_name}","model_".$func_name,$model_content);
       $model_content=str_replace("{construct_content}","",$model_content);
       $model_content=str_replace("{function_content}",$function_content,$model_content);
       $model_content=str_replace("{include}","",$model_content);
       $model_content=str_replace("<br />","",$model_content);
       file_put_contents("mvc_model/"."model_".$func_name.".php",$model_content);


 }
    $construct_content="";

    $model_content=$copy_baseclass;
    $model_content=str_replace("{write}",$write,$model_content);
    $model_content=str_replace("{model_name}","controller_".$controller_name,$model_content);
    $model_content=str_replace("{construct_content}",$construct_content,$model_content);
    $model_content=str_replace("{include}",$include,$model_content);
    $model_content=str_replace("<br />","",$model_content);
    file_put_contents("mvc_controller/"."controller_".$controller_name.".php",$model_content);

//akhir loop moduls
}

        for($d=0; $d<count($manifest->daf_api); $d++){
          $controller_name=$manifest->daf_api[$d]->modul;
          $controller_content="";
          $construct_content="";
          $include="";
          $ar_table_name_inside_api_modul=array();
         for($act=0; $act<count($manifest->daf_api[$d]->action); $act++){
            $action=$manifest->daf_api[$d]->action[$act];
            $loop_func=get_string_between($copy_baseclass,"{loop_func}","{/loop_func}");
            $func_name=$action->action;
            $loop_func=str_replace("{func_name}","page_".$func_name,$loop_func);
            $loop_func=str_replace("{param}","",$loop_func);
            $loop_func=str_replace("<br />","",$loop_func);
            $function_content="";
            $varphpawal="";
            $function_content.='$variables=$this->variables;'."\n";
            $function_content.='extract($variables);'."\n";
            $function_content.='$prosesapi=1;'."\n";
            $function_content.='$error_code="000";'."\n";
            $function_content.='$error_msg="";'."\n";
            $function_content.='$response_data="";'."\n";
            $function_content.='$returnAPI=array();'."\n\n";
            $function_content.="{varphpawal}"."\n";
            $cekmodul=get_web_check_apiparam("modul",true);
            $cekaction=get_web_check_apiparam("action",true);
            $varphpawal.=$cekmodul->varphpawal."\n";
            $varphpawal.=$cekaction->varphpawal."\n";
            $function_content.=$cekmodul->content."\n";
            $function_content.=$cekaction->content."\n";
               for($f=0; $f<count($action->param); $f++){
                 if(!isset($action->param[$f]->mandatory)){
                   $action->param[$f]->mandatory=false;
                 }
                 $cekparam=get_web_check_apiparam($action->param[$f]->name,$action->param[$f]->mandatory);
                 $varphpawal.=$cekparam->varphpawal."\n";
                 $function_content.=$cekparam->content."\n";

               }
            $function_content.='if ($prosesapi==1){'."\n";
            $function_content.='{api_process_content}'."\n";
            $function_content.='}'."\n\n";
            $function_content.='$returnAPI[\'error_code\']=$error_code;'."\n";
            $function_content.='$returnAPI[\'error_msg\']=$error_msg;'."\n";
            $function_content.='$returnAPI["response_data"]=$response_data;'."\n";
            $function_content.='$hasil=json_encode($returnAPI);'."\n";
            $function_content.='echo $hasil;'."\n";
            $apifunction_content="";

            $dafVariable=array();
            $ar_table_name_inside_api_action=array();
            if(isset($action->process)){
             $grupengine=render_grup_engine($action);
             $apifunction_content.=$grupengine->content;
             $varphpawal.=$grupengine->varphpawal;

            foreach($action->process as $pro){


              switch($pro->type){
                case "table":
                $dapetpro=0;
                $table_name=null;
                $table_action=null;
                if(isset($action->engine)){
                  for($eng=0;$eng<count($action->engine);$eng++){
                    if($action->engine[$eng]->type=="table"){
                      for($ca=0; $ca<count($action->engine[$eng]->content); $ca++){
                        if($action->engine[$eng]->content[$ca]->id==$pro->id){
                          $dapetpro=1;
                          $table_action=$action->engine[$eng]->content[$ca];
                          $table_name=$table_action->table_name;

                          $func_name_now=get_fungsi_name($ar_fungsi,$controller_name,$func_name,"crud_".$table_action->process_name."DataForModul_".$controller_name."_Action_".$func_name,$table_name);
                          $ar_fungsi=$func_name_now->ar_fungsi;
                          $table_action->func_name=$func_name_now->hasilreturn;
                          $table_action->need="caller";
                          $getengine=render_engine("table",$table_action,$pro,null);

                          if (!in_array($table_name, $ar_table_name_inside_api_modul)){
                            $ar_table_name_inside_api_modul[]=$table_name;
                            $include.='include '.'"../mvc_model/model_tabel_'.$table_name.'.php";'."\n";
                          }
                          if (!in_array($table_name, $ar_table_name)){

                           $ar_table_name[]=$table_name;

                           $ar_table->$table_name= new \stdClass();
                           $ar_table->$table_name->table_name=$table_name;
                           $ar_table->$table_name->api_array=array();

                          }
                          $bahanapi= new \stdClass();
                          $bahanapi->func_name=$func_name_now->hasilreturn;
                          $bahanapi->table=$table_action;
                          $bahanapi->api_type=$action->type;
                          $bahanapi->action=$action;
                          $ar_table->$table_name->api_array[]=$bahanapi;

                          if (!in_array($table_name, $ar_table_name_inside_api_action)){
                           $ar_table_name_inside_api_action[]=$table_name;

                           $varphpawal.=$getengine->varphpawal;
                           $apifunction_content.=$getengine->deklarasi;

                          }
                             if($table_action!=null){
                             $apifunction_content.=$getengine->content."\n";
                             $dafVariable[]=$table_action->outputVariable;
                             }
                             $function_content.="\n";
                          break;
                        }
                      }

                    }
                  }
                }
                break;

              }


            }
            }
                 $apifunction_content.='$bahan_respon = "'.$action->response_output."\";"."\n";
                 foreach($dafVariable as $a) {
                   if(strpos("tes".$action->response_output."tes","{".$a."}")){
                   $apifunction_content.='$bahan_respon=str_replace("{'.$a.'}",$'.$a.',$bahan_respon);'."\n";
                   }
                  }
                 if(isset($action->response_type)){
                   switch($action->response_type){
                     case "json":

                     if(isset($action->json_encode) && $action->json_encode){
                       $apifunction_content.='$response_data = json_decode(json_encode($bahan_respon))'.";"."\n";
                     }else{
                     $apifunction_content.='$response_data = json_decode($bahan_respon)'.";"."\n";
                   }
                     break;
                   }
                 }else{
                 $apifunction_content.='$response_data = $bahan_respon'.";"."\n";
                 }


            $function_content=str_replace("{api_process_content}",$apifunction_content,$function_content);
            $function_content=str_replace("{varphpawal}",$varphpawal,$function_content);
            $loop_func=str_replace("{function_content}",$function_content,$loop_func);

            $controller_content.=$loop_func."\n";

            $writemodul="<?php"."\n";
            $writemodul.='$main->page_'.$func_name.'(); '."\n";
            $writemodul.='?> '."\n";
            file_put_contents("API/"."inc_modul_".$controller_name."_page_".$func_name.".php",$writemodul);


          }

          $model_content=$copy_baseclass;
          $model_content=str_replace("{write}",$controller_content,$model_content);
          $model_content=str_replace("{model_name}","controller_".$controller_name,$model_content);
          $model_content=str_replace("{construct_content}",$construct_content,$model_content);
          $model_content=str_replace("{include}",$include,$model_content);
          $model_content=str_replace("<br />","",$model_content);

          file_put_contents("mvc_controller/"."controller_".$controller_name.".php",$model_content);
        //akhir loop daf_api
      }

         for($t=0; $t<count($ar_table_name); $t++){
           $table_content="";
           $construct_content="";
           $table_include="";
           $table_name=$ar_table_name[$t];

           for($ar=0; $ar<count($ar_table->$table_name->api_array); $ar++){
             $theapi=$ar_table->$table_name->api_array[$ar];
             $apifunction_content="";
             $varphpawal="";

             //$apifunction_content.='$'.$theapi->table->outputVariable.';'."\n";
             $apifunction_content.='$variables=$this->variables;'."\n";
             $apifunction_content.='$db=$this->db;'."\n";
             $apifunction_content.='extract($variables);'."\n";
             $objproses=create_database_proses($theapi->table,$table_name);
             $varphpawal.=$objproses->varphpawal;
             $apifunction_content.=$objproses->content;
             //$apifunction_content.=create_database_proses($theapi->table,$table_name);

             $thereturn='$'.$theapi->table->outputVariable;
             if(isset($theapi->table->json_encode) && $theapi->table->json_encode){
               $thereturn="json_encode(".$thereturn.")";
             }
             $apifunction_content.='return '.$thereturn.';'."\n";


            $loop_func=get_string_between($copy_baseclass,"{loop_func}","{/loop_func}");
            $isiparam="";
            if(isset($theapi->table->param)){
              for($pa=0; $pa<count($theapi->table->param); $pa++){
                $isiparam.="$".$theapi->table->param[$pa]->name;
                if($pa+1<count($theapi->table->param)){
                  $isiparam.=",";
                }
              }
            }
            $func_name=$theapi->func_name;
            $loop_func=str_replace("{func_name}",$func_name,$loop_func);
            $loop_func=str_replace("{param}",$isiparam,$loop_func);
            $apifunction_content=$varphpawal."\n".$apifunction_content;
            $loop_func=str_replace("{function_content}",$apifunction_content,$loop_func);
            $loop_func=str_replace("<br />","",$loop_func);
            $table_content.=$loop_func."\n\n";

           }


                $model_content=$copy_baseclass;
                $model_content=str_replace("{write}",$table_content,$model_content);
                $model_content=str_replace("{model_name}","model_tabel_".$table_name,$model_content);
                $model_content=str_replace("{construct_content}",$construct_content,$model_content);
                $model_content=str_replace("{include}",$table_include,$model_content);
                $model_content=str_replace("<br />","",$model_content);

                file_put_contents("mvc_model/"."model_tabel_".$table_name.".php",$model_content);


         }
function get_fungsi_name($ar_fungsi,$modul,$page,$thename,$namatambahan){
  $hasilreturn=$thename;
  $nowname=$thename;
  if($namatambahan!=null){
    $nowname.="_tambahan_".$namatambahan;
  }
  $objreturn=new \stdClass();

  if(!isset($ar_fungsi->$modul)){
    $ar_fungsi->$modul=new \stdClass();
    $ar_fungsi->$modul->$page=new \stdClass();
  }
  if(!isset($ar_fungsi->$modul->$page)){
    $ar_fungsi->$modul->$page=new \stdClass();
  }
  $dapat=0;
  while($dapat==0){
  if(!isset($ar_fungsi->$modul->$page->$nowname)){
    $ar_fungsi->$modul->$page->$nowname=1;
    $dapat=1;
  }else{
    $nowname.=rand(1,1000);
  }
  }
  //echo $nowname."<BR>";
  $hasilreturn=$nowname;
  $objreturn->hasilreturn=$hasilreturn;
  $objreturn->ar_fungsi=$ar_fungsi;
  return $objreturn;
}
/**
   for($t=0; $t<count($ar_table_name); $t++){
     $table_content="";
     $construct_content="";
     $table_include="";
     $table_name=$ar_table_name[$t];

     $apifunction_content='$variables=$this->variables;'."\n";
     $apifunction_content.='$db=$this->db;'."\n";
     $apifunction_content.='extract($variables);'."\n";
     $apifunction_content.='$prosesapi=1;'."\n";
     $apifunction_content.='$error_code="000";'."\n";
     $apifunction_content.='$error_msg="";'."\n";
     $apifunction_content.='$response_data="";'."\n";
     $apifunction_content.='$returnAPI=array();'."\n\n";
     $apifunction_content.=get_web_check_apiparam("modul")."\n";
     $apifunction_content.=get_web_check_apiparam("action")."\n";
        for($f=0; $f<count($ar_table->$table_name->action->param); $f++){

          $apifunction_content.=get_web_check_apiparam($ar_table->$table_name->action->param[$f])."\n";

        }
     $apifunction_content.='if ($prosesapi==1){'."\n";
     $apifunction_content.='{api_process_content}'."\n";
     $apifunction_content.='}'."\n\n";
     $apifunction_content.='$returnAPI[\'error_code\']=$error_code;'."\n";
     $apifunction_content.='$returnAPI[\'error_msg\']=$error_msg;'."\n";
     $apifunction_content.='$returnAPI["response_data"]=$response_data;'."\n";
     $apifunction_content.='$hasil=json_encode($returnAPI);'."\n";
     $apifunction_content.='echo $hasil;'."\n";

     $api_process_content=''."\n";
        for($ar=0; $ar<count($ar_table->$table_name->api_array); $ar++){
          $theapi=$ar_table->$table_name->api_array[$ar];

          $api_process_content.='$query='.get_web_database_query($theapi->table);
          if(isset($theapi->action->special)){
            if($theapi->action->special=="table_content"){

              $api_process_content.='$response_data=$bahanreturn;'."\n";
            }else if($theapi->action->special=="dropdown_content"){
              $api_process_content.='$dropdown_content="<option value=\'-1\'>- select -</option>";'."\n";
              $api_process_content.='foreach($bahanreturn as $q){'."\n";
              $api_process_content.='$dropdown_content.="<option value=\'".$q[0]."\'>".$q[1]."</option>";'."\n";
              $api_process_content.='}'."\n";
              $api_process_content.='$response_data=$dropdown_content;'."\n";
            }
          }
          $api_process_content.="\n";
        }

        $apifunction_content=str_replace("{api_process_content}",$api_process_content,$apifunction_content);

             $loop_func=get_string_between($copy_baseclass,"{loop_func}","{/loop_func}");
             $func_name=$ar_table->$table_name->func_name;
             $loop_func=str_replace("{func_name}",$func_name,$loop_func);
             $loop_func=str_replace("{function_content}",$apifunction_content,$loop_func);
             $loop_func=str_replace("<br />","",$loop_func);
             $table_content.=$loop_func."\n\n";



     $model_content=$copy_baseclass;
     $model_content=str_replace("{write}",$table_content,$model_content);
     $model_content=str_replace("{model_name}","model_tabel_".$table_name,$model_content);
     $model_content=str_replace("{construct_content}",$construct_content,$model_content);
     $model_content=str_replace("{include}",$table_include,$model_content);
     $model_content=str_replace("<br />","",$model_content);

     file_put_contents("mvc_model/"."model_tabel_".$table_name.".php",$model_content);

   }
**/

$copy_baseheader=str_replace("{sidemenu}",$bahansidemenu,$copy_baseheader);
$copy_baseheader=str_replace("<br />","",$copy_baseheader);

file_put_contents("inc_body_header.php",$copy_baseheader);

$copy_basefooter=str_replace("{js_functions}","",$copy_basefooter);
$copy_basefooter=str_replace("{copy_js}","",$copy_basefooter);
$copy_basefooter=str_replace("<br />","",$copy_basefooter);
file_put_contents("inc_body_footer.php",$copy_basefooter);


 ?>
