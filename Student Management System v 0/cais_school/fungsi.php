<?php
function get_string_between($string, $start, $end){
  $string = ' ' . $string;
  $ini = strpos($string, $start);
  if ($ini == 0) return '';
  $ini += strlen($start);
  $len = strpos($string, $end, $ini) - $ini;
  return substr($string, $ini, $len);
}
function render_html_element_field($page_elemen){
  $content=new \stdClass();
  $bahanawaljs="";
  $variabeljsawal="";
  $bahanform="";
  $kontenvariabelform="";
  $copy_basejs="";
  for ($c=0; $c<count($page_elemen->field); $c++){
    $namavariablefield="";
    if(!isset($page_elemen->field[$c]->variable)){
      $namavariablefield="isian_".$page_elemen->field[$c]->id;
      $page_elemen->field[$c]->variable=$namavariablefield;
    }else{
      $namavariablefield=$page_elemen->field[$c]->variable;
    }

$requested_html = $_SESSION['caisconfig_'.$_SESSION['config_type']]->requested_html;
//    var_dump($requested_html);
//echo $namafiletheme;
$isicontent="";
for($r=0; $r<count($requested_html);$r++){
  if($requested_html[$r]["key"]=="form_field_get_value"){
    if($requested_html[$r]["type"]==$page_elemen->field[$c]->type){
      $kontenvariabelform.=$requested_html[$r]["get_value"];
      break;
    }
  }
}
$kontenvariabelform=str_replace("{field_variable}",$namavariablefield,$kontenvariabelform);
$kontenvariabelform=str_replace("{field_id}",$page_elemen->field[$c]->id,$kontenvariabelform);



      }

      $kontenfungsivalidasi="";
      for ($c=0; $c<count($page_elemen->field); $c++){
        //echo $page_elemen->field[$c]->type;

        $field=get_web_field($page_elemen->field[$c]);
        $bahanawaljs.="\n".$field->isijs;
        $variabeljsawal.="\n".$field->varjsawal;
        $bahanform.="\n".$field->isicontent;
        if(isset($page_elemen->field[$c]->validation)){

          foreach($page_elemen->field[$c]->validation as $validate) {

            $bahanvalidation="";

            $bahandeklarasi="";
            $dataplace=".value";
            for($r=0; $r<count($requested_html);$r++){
              if($requested_html[$r]["key"]=="form_field_validation"){
                if($requested_html[$r]["type"]==$validate->type){
                  $bahanvalidation=bacafile($requested_html[$r]["file"]);
                  break;
                }
              }
            }

            for($r=0; $r<count($requested_html);$r++){
              if($requested_html[$r]["key"]=="form_field_get_value_validation"){
                if($requested_html[$r]["type"]==$page_elemen->field[$c]->type){
                  $bahandeklarasi=$requested_html[$r]["get_value"];
                  $dataplace=$requested_html[$r]["dataplace"];
                  break;
                }
              }
            }

            $bahandeklarasi.="\n";
            $bahanvalidation=$bahandeklarasi.$bahanvalidation;
            $bahanvalidation=str_replace("{field_id}",$page_elemen->field[$c]->id,$bahanvalidation);
            $bahanvalidation=str_replace("{dataplace}",$dataplace,$bahanvalidation);


            for($r=0; $r<count($requested_html);$r++){
              if($requested_html[$r]["key"]=="form_field_validation"){
                if($requested_html[$r]["type"]==$validate->type){

                  for($rr=0; $rr<count($requested_html[$r]["replaces"]);$rr++){
                    $bahanfrom=$requested_html[$r]["replaces"][$rr]["from"];
                    $bahanvalidation=str_replace($requested_html[$r]["replaces"][$rr]["to"],$validate->$bahanfrom,$bahanvalidation);

                  }
                  break;
                }
              }
            }

            $kontenfungsivalidasi.=$bahanvalidation;
            $kontenfungsivalidasi.="\n";
          }

        }

      }

      $form_get_variable=bacafile($_SESSION['caisconfig_'.$_SESSION['config_type']]->web_localpath."copy_base/js_form_get_variable.html");
      $form_get_variable=str_replace("{form_id}",$page_elemen->id,$form_get_variable);
      $form_get_variable=str_replace("{content}",$kontenvariabelform,$form_get_variable);

      $bahanawaljs.=$form_get_variable;

      $fungsivalidasi=bacafile($_SESSION['caisconfig_'.$_SESSION['config_type']]->web_localpath."copy_base/js_validation_function.html");
      $fungsivalidasi=str_replace("{form_id}",$page_elemen->id,$fungsivalidasi);
      $fungsivalidasi=str_replace("{content}",$kontenfungsivalidasi,$fungsivalidasi);

      $bahanawaljs.=$fungsivalidasi;

      $kontenfungsisubmitformjs="";
      $fungsisubmitformjs=bacafile($_SESSION['caisconfig_'.$_SESSION['config_type']]->web_localpath."copy_base/js_form_submit.html");
      $fungsisubmitformjs=str_replace("{form_id}",$page_elemen->id,$fungsisubmitformjs);
      $fungsisubmitformjs=str_replace("{content}",$kontenfungsisubmitformjs,$fungsisubmitformjs);

      $bahanawaljs.=$fungsisubmitformjs;

      $content->kontenvariabelform=$kontenvariabelform;
      $content->kontenfungsivalidasi=$kontenfungsivalidasi;
      $content->bahanform=$bahanform;
      $content->bahanawaljs=$bahanawaljs;
      $content->variabeljsawal=$variabeljsawal;
      $content->copy_basejs=$copy_basejs;

      return $content;

      //akhir render_html_element_field
    }

    function render_html_form_field($page_elemen){
      $content=new \stdClass();
      $bahanawaljs="";
      $variabeljsawal="";
      $bahanform="";
      $kontenvariabelform="";
      $copy_basejs="";

      $hasilrender=render_html_element_field($page_elemen);
      $kontenvariabelform=$hasilrender->kontenvariabelform;
      $kontenfungsivalidasi=$hasilrender->kontenfungsivalidasi;

      $bahanform.="<form role=\"form\" name=\"{form_id}\" id=\"{form_id}\" {form_attribute}  >"."\n";
      $bahanform.="<div class=\"".$page_elemen->div_class."\">"."\n";
      $bahanform.=$hasilrender->bahanform;
      $bahanform.="</div>"."\n";
      $bahanform.="</form>"."\n";
      $bahanform=str_replace("{form_id}",$page_elemen->id,$bahanform);
      $form_attribute="";

      foreach($page_elemen->attribute as $key=>$value) {
        $form_attribute.=$key."=\"".$value."\"";
      }

      $bahanform=str_replace("{form_attribute}",$form_attribute,$bahanform);


      $variabeljsawal.=$hasilrender->variabeljsawal;
      $bahanawaljs.=$hasilrender->bahanawaljs;

      $content->kontenvariabelform=$kontenvariabelform;
      $content->kontenfungsivalidasi=$kontenfungsivalidasi;
      $content->bahanform=$bahanform;
      $content->bahanawaljs=$bahanawaljs;
      $content->variabeljsawal=$variabeljsawal;
      $content->copy_basejs=$copy_basejs;

      return $content;
    }
    function bacafile($file_address){
      $content="";
      if (file_exists($file_address)) {
        $file = fopen($file_address,"r");
        while(! feof($file))
        {
          $content.=fgets($file). "<br />";
        }
        fclose($file);
      }else{
        echo "tak ada file $file_address <br>";
      }
      $content=str_replace("<br />","",$content);

      return $content;
    }

    function json_validate($string)
    {
      json_decode($string);
      return (json_last_error() == JSON_ERROR_NONE);
    }

    function get_fungsi_name_new($modul,$page,$enginetype,$enginebody,$tambahan){
      $additional_name="";
      $ar_fungsi = $_SESSION['ar_fungsi'];
      switch($enginetype){
        case "table":
        $additional_name=$enginebody->process_name."_".$enginebody->table_name;
        break;
      }
      $thename="Go_".$enginetype."_for_modul_".$modul."_page_".$page."_".$additional_name;
      $hasilreturn=$thename;
      $dapatengine=0;
      for($a=0; $a<count($ar_fungsi); $a++){
        if($ar_fungsi[$a]["enginetype"]==$enginetype){
          $dapatengine=1;
          $dapatmodul=0;
          //  var_dump($ar_fungsi[$a]["modul"][0]["modul"]);
          for($m=0; $m<count($ar_fungsi[$a]["modul"]); $m++){
            if($ar_fungsi[$a]["modul"][$m]["modul"]==$modul){

              $dapatmodul=1;
              $dapatpage=0;
              for($p=0; $p<count($ar_fungsi[$a]["modul"][$m]["page"]); $p++){
                if($ar_fungsi[$a]["modul"][$m]["page"][$p]["page"]==$page){
                  $dapatpage=1;
                  $thepage=$ar_fungsi[$a]["modul"][$m]["page"][$p];
                  $dapat=0;
                  //  echo count($thepage["name_list"])."<BR>";
                  while($dapat==0){
                    for($n=0; $n<count($thepage["name_list"]); $n++){
                      //  echo $thepage["name_list"][$n]["body"]->id."<BR>";
                      //echo json_encode($enginebody)."<BR>";
                      if($thepage["name_list"][$n]["body"]==$enginebody){
                        $dapat=1;
                        $hasilreturn=$thepage["name_list"][$n]["function_name"];
                        break;
                      }
                    }
                    if($dapat==0){

                      $bisapasang=1;
                      for($n=0; $n<count($thepage["name_list"]); $n++){
                        if($thepage["name_list"][$n]["function_name"]==$thename){
                          $thename.=rand(1,1000);
                          $bisapasang=0;
                          break;
                        }
                      }
                      if($bisapasang==1){
                        $objbaru=array();
                        $objbaru["function_name"]=$thename;
                        $objbaru["body"]=$enginebody;
                        $ar_fungsi[$a]["modul"][$m]["page"][$p]["name_list"][]=$objbaru;
                        $hasilreturn=$thename;
                        $dapat=1;
                      }
                    }
                  }
                }
              }
              if($dapatpage==0){
                $objbaru=array("page"=>$page,"name_list"=>array(array("function_name"=>$thename,"body"=>$enginebody)));
                $ar_fungsi[$a]["modul"][$m]["page"][]=$objbaru;
                //  echo "GADA ".$modul." page ".$page;
                $hasilreturn=$thename;
              }
            }
          }
          if($dapatmodul==0){
            //  echo "GADA ".$modul." ".$thename;
            $objbaru=array("modul"=>$modul,"page"=>array(array("page"=>$page,"name_list"=>array(array("function_name"=>$thename,"body"=>$enginebody)))));
            $ar_fungsi[$a]["modul"][]=$objbaru;
            $hasilreturn=$thename;
          }
        }
      }

      if($dapatengine==0){
        //  echo "GADA enginetype ".$enginetype;
        $objbaru=array("enginetype"=>$enginetype,"modul"=>array(array("modul"=>$modul,"page"=>array(array("page"=>$page,"name_list"=>array(array("function_name"=>$thename,"body"=>$enginebody)))))));

        $ar_fungsi[]=$objbaru;
        $hasilreturn=$thename;
      }

      //echo count($ar_fungsi)."<BR>";
      $objreturn=new \stdClass();

      $objreturn->function_name=$hasilreturn;
      $objreturn->ar_fungsi=$ar_fungsi;
      $_SESSION['ar_fungsi']=$ar_fungsi;
      return $objreturn;

      //akhir get_fungsi_name_new
    }
    function rekursifcekurlcatcher($process){
      $daf_url_catcher=array();
      //echo "DIPANGGIL";
      //echo "api ".$page_name."<BR>";
      $tulisankode=json_encode($process);
      if(strpos("tes".$tulisankode."tes","url_catcher")){
        foreach($process as $pro){
          if(is_array($pro)){
            $hasilrekursif=rekursifcekurlcatcher($pro);
            $daf_url_catcher=array_merge($daf_url_catcher,$hasilrekursif);
          }else if (is_object($pro)) {
            if(isset($pro->type)){
              if($pro->type=="url_catcher"){
                $bahancatch=array("catch" => $pro->catch,
                "variable" => $pro->variable);
                $daf_url_catcher[]=$bahancatch;
              }
            }
            $hasilrekursif=rekursifcekurlcatcher($pro);
            $daf_url_catcher=array_merge($daf_url_catcher,$hasilrekursif);
          }else{
            //$category->properties_modul="NAMA MODUL";
          }
        }
      }
      return $daf_url_catcher;
      //akhir rekursifcekurlcatcher
    }
    function rekursifdafVariable($isiprocess){
      $dafVariable=array();
      foreach($isiprocess as $pro){
        //echo "TERPANGGIL";
        if(is_array($pro)){
          //echo $key."<BR>";
          //$dafVariable=array_merge($dafVariable,renderwhattodo($key,$category,$isitoproses));
          $dafVariable=array_merge($dafVariable,rekursifdafVariable($pro));
        }else if (is_object($pro)) {
          //echo $key."<BR>";
          if(isset($pro->outputVariable)){
          $dafVariable[]=$pro->outputVariable;
          }
          $dafVariable=array_merge($dafVariable,rekursifdafVariable($pro));
        }else{
        }
      }
      return $dafVariable;
    }
    function rekursifcekinclude($kodenya,$filedirection){
      $daf_stringinclude=array();
      //echo "DIPANGGIL";
      //echo "api ".$page_name."<BR>";
      $tulisankode=json_encode($kodenya);
      if(strpos("tes".$tulisankode."tes","include_file")){
        foreach($kodenya as $category){
          $tulisancat=json_encode($category);
          if(is_array($category)){
            $hasilrekursif=rekursifcekinclude($category,$filedirection);
            $daf_stringinclude=array_merge($daf_stringinclude,$hasilrekursif);
          }else if (is_object($category)) {
            if(isset($category->type)){
              if($category->type=="include_file"){
                //  echo "ADA INCLUDE ".$category->include."\n";
                $isijsonfile=bacafile($filedirection.$category->include);
                $tulisancat=json_encode($category);
                //    echo "ISI INCLUDE ".$isijsonfile."\n";
                //      echo "ISI tulisancat ".$tulisancat."\n";
                $bahanreplace=array("from" => $tulisancat,
                "to" => $isijsonfile);
                $daf_stringinclude[]=$bahanreplace;
                $calonobj=json_decode($isijsonfile);
                $category=$calonobj;
              }
            }
            $hasilrekursif=rekursifcekinclude($category,$filedirection);
            $daf_stringinclude=array_merge($daf_stringinclude,$hasilrekursif);
          }else{
            //$category->properties_modul="NAMA MODUL";
          }
        }
      }
      return $daf_stringinclude;
    }

    function rekursifmodulpage($arnya,$con_name,$page_name,$compileto){
      //echo "DIPANGGIL";
      //echo "api ".$page_name."<BR>";
      foreach($arnya as $category){
        if(is_array($category)){
          rekursifmodulpage($category,$con_name,$page_name,$compileto);
        }else if (is_object($category)) {
          $category->properties_modul=$con_name;
          $category->properties_page=$page_name;
          $category->properties_compileto=$compileto;
          rekursifmodulpage($category,$con_name,$page_name,$compileto);
        }else{
          //$category->properties_modul="NAMA MODUL";
        }
      }

    }

    function rekursifcekfunction($arnya,$modul_id,$page_id){
      //echo "DIPANGGIL";
      //echo "api ".$page_name."<BR>";
      $ar_func=array();
      $tulisankode=json_encode($arnya);
      if(strpos("tes".$tulisankode."tes","func_type")){
        foreach($arnya as $category){
          if(is_array($category)){
            $hasilrekursif=rekursifcekfunction($category,$modul_id,$page_id);
            $ar_func=array_merge($ar_func,$hasilrekursif);
          }else if (is_object($category)) {
            if(isset($category->func_type)){
              if($category->func_type!="callfunction"){
                $category->modul_id=$modul_id;
                $category->page_id=$page_id;
                $func=create_web_function($category);
                $ar_func[]=$func;
              }

            }
            $hasilrekursif=rekursifcekfunction($category,$modul_id,$page_id);
            $ar_func=array_merge($ar_func,$hasilrekursif);
          }else{
            //$category->properties_modul="NAMA MODUL";
          }
        }
        //echo "ADA NIH \n";
      }
      //akhir rekursifcekfunction
      return $ar_func;
    }



    function rekursifprosesmodulpage($isitoproses,$controller_name,$model_name){
      $ar_worktodo=array();
      foreach($isitoproses as $key=>$category){
        if(is_array($category)){
          //echo $key."<BR>";
          $ar_worktodo=array_merge($ar_worktodo,renderwhattodo($key,$category,$isitoproses));
          $ar_worktodo=array_merge($ar_worktodo,rekursifprosesmodulpage($category,$controller_name,$model_name));
        }else if (is_object($category)) {
          //echo $key."<BR>";
          $ar_worktodo=array_merge($ar_worktodo,renderwhattodo($key,$category,$isitoproses));
          $ar_worktodo=array_merge($ar_worktodo,rekursifprosesmodulpage($category,$controller_name,$model_name));
        }else{
        }
      }
      return $ar_worktodo;
    }

    function renderwhattodo($key,$obj,$bodyawal){
      $ar_worktodo=array();
      $key=(string)$key;
      if($key=="process"){
        if(isset($bodyawal->func_name)){
        echo "key ".$bodyawal->func_name."<BR>";
        }
        //var_dump($bodyawal)."<BR>";
        $grupengine=render_grup_engine((object)$bodyawal);
        for($iw=0;$iw<count($grupengine->ar_worktodo);$iw++){
          if(isset($grupengine->ar_worktodo[$iw]["fortop"])){
            switch($grupengine->ar_worktodo[$iw]["fortop"]){
              case "untukatas":
              if(isset($bodyawal->func_name)){
              $grupengine->ar_worktodo[$iw]["ignore"]=false;
              echo "ADAATAS".$bodyawal->func_name;
              $grupengine->ar_worktodo[$iw]["function_id"]="function_".$bodyawal->func_name;
              //$ar_worktodo[$iw]["content"]="ASDASD";
              }
              break;
              case "fileatas":
              if(isset($bodyawal->table_name)){
              $grupengine->ar_worktodo[$iw]["ignore"]=false;
              echo "fileatas".$bodyawal->table_name;
              $grupengine->ar_worktodo[$iw]["file_id"]="tabel_".$bodyawal->table_name;
              $grupengine->ar_worktodo[$iw]["work_id"]="includes_".$bodyawal->table_name."_to_".$grupengine->ar_worktodo[$iw]["namatabel"];
              //$grupengine->ar_worktodo[$iw]["content"]=create_text_include_model("model_tabel_".$bodyawal->table_name);
              //$ar_worktodo[$iw]["content"]="ASDASD";
              }
              break;
            }
          }

        }
        $ar_worktodo=array_merge($ar_worktodo,$grupengine->ar_worktodo);
        //print($grupengine->deklarasi)."<BR>";
        //echo $obj->title;
        echo "<BR>";
      }

      return $ar_worktodo;
    }


    function replacemasal($ar_replace,$konten){
      $content=$konten;
      foreach($ar_replace as $key=>$value){
        $content=str_replace($key,$value,$content);
        //echo "replace ".$key." dengan ".$value."<BR>";
      }
      return $content;
    }





      function get_web_field($field){
        $content=new \stdClass();
        $namafiletheme="";
        if(!isset($field->theme)){
          $field->theme="normal";
        }
        $namafiletheme=$field->type."_theme_".$field->theme;
            $requested_html = $_SESSION['caisconfig_'.$_SESSION['config_type']]->requested_html;
        //    var_dump($requested_html);
        //echo $namafiletheme;
        $isicontent="";
        for($r=0; $r<count($requested_html);$r++){
          if($requested_html[$r]["key"]=="form_field"){
            if($requested_html[$r]["name"]==$namafiletheme){
              $isicontent=bacafile($requested_html[$r]["file"]);

              if(strlen($isicontent)==0){
              echo "kosong field ".$namafiletheme." ".$requested_html[$r]["file"]." ".$isicontent;
              }
              break;
            }
          }
        }
        
        $isijs="";
        $varjsawal="";
        $attribute="";
        $namavariablefield="";
        if(!isset($field->variable)){
          $namavariablefield="isian_".$field->id;
          $field->variable=$namavariablefield;
        }else{
          $namavariablefield=$field->variable;
        }
        if($field->type!="select"
        && $field->type!="select2"){
          // echo $namavariablefield;
          $varjsawal.="var ".$namavariablefield." = null;\n";
        }
        if(isset($field->attribute)){
          foreach($field->attribute as $key=>$value) {
            $attribute.=$key."=\"".$value."\"";
          }
        }
        $requested_html = $_SESSION['caisconfig_'.$_SESSION['config_type']]->requested_html;
        //    var_dump($requested_html);
        //echo $namafiletheme;
        $dapetreq=false;
        for($r=0; $r<count($requested_html);$r++){
          if($requested_html[$r]["key"]=="form_field_js"){
            if($requested_html[$r]["type"]==$field->type){
              if (file_exists($requested_html[$r]["file"])) {
                $dapetreq=true;
              include($requested_html[$r]["file"]);
              }
              break;
            }
          }
        }



        if(isset($field->listeners)){
          for ($lis=0; $lis<count($field->listeners); $lis++){
            $tolisten=$field->listeners[$lis];

            for($r=0; $r<count($requested_html);$r++){
              if($requested_html[$r]["key"]=="form_field_listener"){
                if($requested_html[$r]["listen"]==$tolisten->listen){
                  $isijs.=call_user_func($requested_html[$r]["func_name"],$field,$tolisten);
                  break;
                }
              }
            }

          }
        }

$isivalue="";
if(isset($field->value)){
  $tulisanvariable=create_variable_web($field->value);
  $isivalue='<?php if(isset($'.$field->value->var_name.')){ print('.$tulisanvariable.'); } ?>';

}

$isicontent=str_replace("{label}",$field->label,$isicontent);
$isicontent=str_replace("{id}",$field->id,$isicontent);
$isicontent=str_replace("{class}",$field->class,$isicontent);
$isicontent=str_replace("{value}",$isivalue,$isicontent);
$isicontent=str_replace("{attribute}",$attribute,$isicontent);
if(isset($field->src)){
  $tulisanvariable=create_variable_web($field->src);
  $isicontent=str_replace("{src}",get_public_assets_directory("uploads")."/<?php print(".$tulisanvariable.");?>",$isicontent);
}

$content->isicontent=$isicontent;
$content->varjsawal=$varjsawal;
$content->isijs=$isijs;
return $content;
}
function get_web_print_option($key,$value,$selected){

  $result='print("<option value=\'".'.$key.'."\' {select}>".'.$value.'."</option>");';
  $result=str_replace("{select}",$selected,$result);
  $result=$result."\n";
  return $result;
}

function create_web_element_dropdown($dropdown){
  $myObj= new \stdClass();
  $namafiletheme="";
  if(!isset($dropdown->theme)){
    $dropdown->theme="normal";
  }
  $namafiletheme=$dropdown->type."_theme_".$dropdown->theme;
  $select_content="";
  $requested_html = $_SESSION['caisconfig_'.$_SESSION['config_type']]->requested_html;

  $alamatselect="";
  for($r=0; $r<count($requested_html);$r++){
    if($requested_html[$r]["key"]=="form_field"){
      if($requested_html[$r]["name"]==$namafiletheme){
        $alamatselect=$requested_html[$r]["file"];

        break;
      }
    }
  }

  $select_content=bacafile($alamatselect);

  $option_list="";
  if(isset($dropdown->first_option_value) && isset($dropdown->first_option_label)){
    $option_list.="<?php ";
    $option_list.=get_web_print_option('"'.$dropdown->first_option_value.'"','"'.$dropdown->first_option_label.'"','');
    $option_list.="?>"."\n";
  }
  $firstloop="";
  $contentloop="";
  $closingloop="";
  if(isset($dropdown->value)){
    $tulisanvariabledropdown=create_variable_web($dropdown->value);
    $bahankeyvalue=$dropdown->value->var_name;
    if(isset($dropdown->value->index)){
      if(count($dropdown->value->index)>0){
        for($cv=0;$cv<count($dropdown->value->index);$cv++){
          $bahankeyvalue.="_".$dropdown->value->index[$cv];
        }
      }
    }

    if(!isset($dropdown->value->option_value)){
      $myObjcarikey= new \stdClass();
      $myObjcarikey->var_type="variable";
      $myObjcarikey->var_name='key'.$bahankeyvalue;
      $dropdown->value->option_value=$myObjcarikey;
    }
    if(!isset($dropdown->value->option_label)){
      $myObjcarikey= new \stdClass();
      $myObjcarikey->var_type="variable";
      $myObjcarikey->var_name='value'.$bahankeyvalue;
      $dropdown->value->option_label=$myObjcarikey;
    }

    $variabeloptionvalue=create_variable_web($dropdown->value->option_value);
    $variabeloptionlabel=create_variable_web($dropdown->value->option_label);


    $firstloop='foreach('.$tulisanvariabledropdown.' as $key'.$bahankeyvalue.'=>$value'.$bahankeyvalue.') {';
      $contentloop=get_web_print_option($variabeloptionvalue,$variabeloptionlabel,'');
      $closingloop="}";
    }
    $option_list.="<?php ";
    $option_list.=$firstloop."\n";
    if(isset($dropdown->search)){
      if(!isset($dropdown->value)){
        //  echo "TIDAK ADA VALUE!!!!!\n";
        //  var_dump($dropdown);
      }else{
        //  echo "ADA VALUE!!!!\n";
        //  var_dump($dropdown->value);
        //    echo "\n";
      }
      $tulisanvariable=create_variable_web($dropdown->value);
      if(!isset($dropdown->value->equal_to)){
        $dropdown->value->equal_to='key';
      }
      if(!isset($dropdown->value->equal_to_index)){
        $dropdown->value->equal_to_index=array();
      }

      $tulisanvariableforeachsearch="";
      $bahankeyvaluesearch="";
      if(isset($dropdown->search->foreach)){

        if(!isset($dropdown->search->foreach->var_type)){
          $dropdown->search->foreach->var_type="variable";
        }
        $bahankeyvaluesearch=$dropdown->search->foreach->var_name;
        $tulisanvariableforeachsearch=create_variable_web($dropdown->search->foreach);

        if(isset($dropdown->search->foreach->index)){
          if(count($dropdown->search->foreach->index)>0){
            for($cv=0;$cv<count($dropdown->search->foreach->index);$cv++){
              $bahankeyvaluesearch.="_".$dropdown->search->foreach->index[$cv];
            }
          }
        }

      }
      $tulisanvariableifsearch="null";
      if(isset($dropdown->search->if)){
        if(!isset($dropdown->search->if->var_type)){
          $dropdown->search->if->var_type="variable";
        }
        $tulisanvariableifsearch=create_variable_web($dropdown->search->if);
      }
      $tulisanvariablevaluesearch="null";
      if(isset($dropdown->search->value)){
        if(!isset($dropdown->search->value->var_type)){
          $dropdown->search->value->var_type="variable";
        }
        $tulisanvariablevaluesearch=create_variable_web($dropdown->search->value);
      }

      if(!isset($dropdown->search->operator)){
        $dropdown->search->operator="==";
      }

      $myObjcarikey= new \stdClass();
      $myObjcarikey->var_type="variable";
      $myObjcarikey->var_name=$dropdown->value->equal_to;
      $myObjcarikey->index=$dropdown->value->equal_to_index;
      $equalto=create_variable_web($myObjcarikey);

      $contentloop='$dapatcari=0;'."\n";
      if(isset($dropdown->search->foreach)){
        $contentloop.='foreach('.$tulisanvariableforeachsearch.' as $key'.$bahankeyvaluesearch.'=>$value'.$bahankeyvaluesearch.') {'."\n";
          $contentloop.='if ('.$tulisanvariableifsearch.' '.$dropdown->search->operator.' '.$tulisanvariablevaluesearch.'){'."\n";
            $contentloop.='$dapatcari=1;'."\n";
            $contentloop.='break;'."\n";
            $contentloop.='}'."\n";
            $contentloop.='}'."\n";
            $closingloop="}";
          }else{
            $contentloop.='if ('.$tulisanvariableifsearch.' '.$dropdown->search->operator.' '.$tulisanvariablevaluesearch.'){'."\n";
              $contentloop.='$dapatcari=1;'."\n";
              $contentloop.='}'."\n";
              $closingloop="}";
            }

            $contentloop.='if ($dapatcari == 1){'."\n";
              $contentloop.=get_web_print_option($variabeloptionvalue,$variabeloptionlabel,'selected');
              $contentloop.='}else{'."\n";
                $contentloop.=get_web_print_option($variabeloptionvalue,$variabeloptionlabel,'');
                $contentloop.='}'."\n";

              }
              $option_list.=$contentloop."\n";
              $option_list.=$closingloop."\n";
              $option_list.="?>";

              $select_content=str_replace("{label}",$dropdown->label,$select_content);
              $select_content=str_replace("{id}",$dropdown->id,$select_content);
              $select_content=str_replace("{option_list}",$option_list,$select_content);
              if(isset($dropdown->class)){
                $select_content=str_replace("{class}",$dropdown->class,$select_content);
              }
              $select_content=str_replace("<br />","",$select_content);
              $myObj->content=$select_content;

              $select_js_content="";
              $select_js_content_variabelawal="";
              if(!isset($dropdown->default)){
                $dropdown->default=0;
              }
              $select_js_content_variabelawal.="var $dropdown->variable = $dropdown->default;\n";
              $select_js_content_variabelawal.="var ".$dropdown->variable."_textvalue = null;\n";


              $myObjFungsiSet= new \stdClass();
              $myObjFungsiSet->func_name="set_idx_select_".$dropdown->id;
              //$myObjFungsiSet->func_content="document.getElementById(\"".$page_elemen->dropdown[$c]->id."\").selectedIndex = nomidx;";
              $myObjFungsiSet->func_content="$(\"select#".$dropdown->id."\").prop('selectedIndex', nomidx).change();";
              $myObjFungsiSet->type="changer";
              $myObjFungsiSet->content_generate="auto";
              $listenerset=create_web_function($myObjFungsiSet)->content;
              $listenerset=str_replace("{func_param}","nomidx",$listenerset);
              $select_js_content.=$listenerset;

              $myObj->js_content=$select_js_content;
              $myObj->varjsawal=$select_js_content_variabelawal;
              return $myObj;

              //akhir create_web_element_dropdown
            }

            function create_booleancheck_web(stdClass $checkgroup){

              $comparing_content="";
              $daf_var=array();
              $isset_content="";
              if(!isset($checkgroup->operator)){
                $checkgroup->operator="and";
              }

              for ($c=0; $c<count($checkgroup->content); $c++){
                if(!isset($checkgroup->content[$c]->type)){
                  $checkgroup->content[$c]->type="checking";
                }
                if($checkgroup->content[$c]->type=="group"){
                  $thegroup=create_booleancheck_web($checkgroup->content[$c]);
                  $daf_var=array_merge($daf_var,$thegroup->daf_var);
                  $comparing_content.="(".$thegroup->comparing_content.")";
                }else if($checkgroup->content[$c]->type=="checking"){
                  if(!isset($checkgroup->content[$c]->operator)){
                    $checkgroup->content[$c]->operator="==";
                  }
                  if(!isset($checkgroup->content[$c]->value->var_type)){
                    $checkgroup->content[$c]->value->var_type="variable";
                  }
                  if(!isset($checkgroup->content[$c]->check->var_type)){
                    $checkgroup->content[$c]->check->var_type="variable";
                  }
                  $varcheck=create_variable_web($checkgroup->content[$c]->check);
                  $varvalue=create_variable_web($checkgroup->content[$c]->value);
                  $comparing_content.=$varcheck.' '.$checkgroup->content[$c]->operator.' '.$varvalue."\n";
                  $daf_var[]=$varcheck;
                  if($c+1>count($checkgroup->content)){
                    if($checkgroup->content->operator=="and"){
                      $comparing_content.=" && ";
                    }else if($checkgroup->content->operator=="or"){
                      $comparing_content.=" || ";
                    }
                  }

                }
                for($d=0; $d<count($daf_var); $d++){
                  $isset_content.="isset(".$daf_var[$d].")";
                  if($d+1>count($daf_var)){
                    $isset_content.="&&";
                  }
                }
                echo $isset_content;
              }

              $objreturn= new \stdClass();
              $objreturn->comparing_content=$comparing_content;
              $objreturn->isset_content=$isset_content;
              $objreturn->daf_var=$daf_var;
              return $objreturn;
              //akhir create_booleancheck_web
            }
            function get_variable_name($value){
              $bahankeyvalue=$value->var_name;
              if(isset($value->index)){
                if(count($value->index)>0){
                  for($cv=0;$cv<count($value->index);$cv++){
                    $bahankeyvalue.="_".$value->index[$cv];
                  }
                }
              }
              return $bahankeyvalue;
            }
            function create_variable_web($value){
              $tulisan_variable="";
              $isivalue="";
              //echo "valuenya ".var_dump($value)."\n";
              if(!isset($value->var_type)){
                $value->var_type="variable";
              }
              switch($value->var_type){
                case "variable":
                $tulisan_variable='$'.$value->var_name;
                if(isset($value->index)){
                  if(count($value->index)>0){
                    foreach($value->index as $in){
                      if (is_object($in)) {
                        $tulisan_variable.='['.create_variable_web($in).']';
                      }else{
                        $tulisan_variable.='[\''.$in.'\']';
                      }
                    }
                  }
                }
                $isivalue='<?php if(isset($'.$value->var_name.')){ print('.$tulisan_variable.'); } ?>';
                break;
                case "hardcode":
                $tulisan_variable=$value->var_name;
                $isivalue=$tulisan_variable;
                break;
              }
              return $tulisan_variable;
            }
            function get_system_directory($direktori){
              return "{cais_web_url}/".$direktori;
            }
            function create_web_function_caller($caller){
              $bahanreturn="";
              $variable_name="";
              if(!isset($caller->func_type)){
                if(strlen($caller->func_name)>0){

                  if(isset($caller->variable)){
                    $variable_name=$caller->variable;
                    $bahanreturn.="var ".$variable_name." = ";
                  }else{
                    $variable_name="return_of_".$caller->func_name;
                    if(isset($caller->checkReturn)){
                      $bahanreturn.="var ".$variable_name." = ";
                    }
                  }

                  $bahanreturn.=$caller->func_name."(";

                  if(isset($caller->param)){
                    for ($p=0; $p<count($caller->param); $p++){
                      $bahanreturn.=$caller->param[$p];
                      if($p<count($caller->param)-1){
                        $bahanreturn.=",";
                      }
                    }
                  }

                  $bahanreturn.=");\n";
                }
              }else if(isset($caller->func_type)){
                $func_name="thefunc".rand(1,100000);
                if(isset($caller->func_name)){
                  if(strlen($caller->func_name)>0){
                    $func_name=$caller->func_name;
                  }
                }
                if(isset($caller->variable)){
                  $variable_name=$caller->variable;
                  $bahanreturn.="var ".$variable_name." = ";
                }else{
                  $variable_name="return_of_".$func_name;
                  if(isset($caller->checkReturn)){
                    $bahanreturn.="var ".$variable_name." = ";
                  }
                }

                $bahanreturn.=$func_name."(";

                if(isset($caller->func_param)){
                  for ($p=0; $p<count($caller->func_param); $p++){
                    $bahanreturn.=$caller->func_param[$p];
                    if($p<count($caller->func_param)-1){
                      $bahanreturn.=",";
                    }
                  }
                }

                $bahanreturn.=");\n";
              }

              if(isset($caller->checkReturn)){

                for ($cr=0; $cr<count($caller->checkReturn); $cr++){
                  $bahanreturn.="if (".$variable_name." ".$caller->checkReturn[$cr]->condition." ".$caller->checkReturn[$cr]->if."){"."\n";

                    for ($th=0; $th<count($caller->checkReturn[$cr]->then); $th++){
                      $bahanreturn.=create_web_function_caller($caller->checkReturn[$cr]->then[$th]);
                      $bahanreturn.="\n";
                    }
                    $bahanreturn.="}"."\n";
                  }
                }
                return $bahanreturn;
                //akhir create_web_function_caller
              }
              function create_web_function($func){
                $objreturn= new \stdClass();
                $content="";
                if(isset($func->variable)){
                  $content.="var $func->variable;\n";
                }
                $content.="function {func_name}({func_param}){\n";
                  $content.="{content}\n";
                  $content.="}\n";
                  $func_param=array();
                  $func_body="";
                  $func_footer="";
                  $func_content="";
                  if(isset($func->func_content)){
                    if(!empty($func->func_content)){
                      $func_content=$func->func_content;
                    }
                  }
                  if(!isset($func->content_generate)){
                    $func->content_generate="auto";
                  }
                  if($func->content_generate=="manual"){
                    $content=str_replace("{content}","",$content);
                  }else{
                    $tipe="";
                    if(!isset($func->type)){
                      $tipe="normal";
                    }else{
                      $tipe=$func->type;
                    }
                    $copy_base_jsvoid="";
                    $requested_html = $_SESSION['caisconfig_'.$_SESSION['config_type']]->requested_html;

                    for($r=0; $r<count($requested_html);$r++){
                      if($requested_html[$r]["key"]=="void_script"){
                        if($requested_html[$r]["name"]==$tipe){
                          if (file_exists($requested_html[$r]["file"])) {
                            $copy_base_jsvoid=bacafile($requested_html[$r]["file"]);
                            $copy_base_jsvoid=str_replace("{func_name}",$func->func_name,$copy_base_jsvoid);

                          }
                          break;
                        }
                      }
                    }


                    $dapetreq=false;
                    for($r=0; $r<count($requested_html);$r++){
                      if($requested_html[$r]["key"]=="void_calculator"){
                        if($requested_html[$r]["name"]==$tipe){
                          if (file_exists($requested_html[$r]["file"])) {
                            $dapetreq=true;
                          include($requested_html[$r]["file"]);
                          }
                          break;
                        }
                      }
                    }
                    if(!$dapetreq){
                      $func_body.=$copy_base_jsvoid;
                    }


                      $func_content=$func_body."\n".$func_footer;
                      $content=str_replace("{content}",$func_content,$content);
                    }
                    $func_name="thefunc".rand(1,100000);
                    if(isset($func->func_name)){
                      $func_name=$func->func_name;
                      $content=str_replace("{func_name}",$func->func_name,$content);
                    }
                    $isiarrayparam="";
                    if(count($func_param)>0){
                      for($fp=0; $fp<count($func_param); $fp++){
                        $isiarrayparam.=$func_param[$fp]["name"];
                        if($fp<count($func_param)-1){
                          $isiarrayparam.=",";
                        }

                      }
                      $content=str_replace("{func_param}",$isiarrayparam,$content);
                    }
                    $content=str_replace("<br />","",$content);
                    $objreturn->content=$content;
                    $objreturn->func_param=$func_param;
                    $objreturn->func_body=$func_body;
                    $objreturn->func_name=$func_name;
                    $objreturn->func_footer=$func_footer;

                    return $objreturn;

                    //akhir create_web_function
                  }



                              function create_web_onapireturn_listener($onapireturn){
                                $content="";

                                for ($o=0; $o<count($onapireturn); $o++){

                                  $bahanlistener=create_web_function_caller($onapireturn[$o]);
                                  $content.=$bahanlistener."\n";

                                }

                                return $content;
                              }

                              function create_unique_content($file_address,$content_to_add){
                                $konten="";
                                $ada=false;
                                if (file_exists($file_address)) {
                                  $konten=bacafile($file_address);
                                }
                                if(!strpos("tes".$konten."tes",$content_to_add)){
                                  $konten.=$content_to_add."\n";
                                }

                                file_put_contents($file_address,$konten);
                                return $ada;
                              }

                              function get_project_url_js($modul,$page,$parameter){
                                $linknya=get_system_directory("admin")."/'+".$modul."+'/'+".$page;
                                if($parameter==null){
                                  $parameter=array();
                                }
                                $bahanparam="";
                                for($fp=0; $fp<count($parameter); $fp++){
                                  $param=$parameter[$fp];
                                  if(!isset($param->value_type)){
                                    $param->value_type="hardcode";
                                  }
                                  if(!isset($param->slash)){
                                    $param->slash="/";
                                  }
                                  switch($param->value_type){
                                    case "hardcode":
                                    $param->value="'".$param->value."'";
                                    break;
                                    case "variable":
                                    $param->value=$param->value;
                                    break;
                                  }
                                  switch($param->slash){
                                    case "/":
                                    $bahanparam.="/".$param->index."/'+".$param->value."+'";
                                    break;
                                    case "?":
                                    $bahanparam.="?".$param->index."='+".$param->value."+'";
                                    break;
                                    case "&":
                                    $bahanparam.="&".$param->index."='+".$param->value."+'";
                                    break;
                                  }
                                }
                                if(count($parameter)>0){
                                  $linknya.="+'".$bahanparam."'";
                                }
                                //echo $linknya;
                                return $linknya;
                              }

                              function get_project_url_php($modul,$page,$parameter){
                                $linknya=get_system_directory("admin")."/".$modul."/".$page;

                                for($fp=0; $fp<count($parameter); $fp++){
                                  $param=$parameter[$fp];
                                  if(!isset($param->value_type)){
                                    $param->value_type="hardcode";
                                  }
                                  if(!isset($param->slash)){
                                    $param->slash="/";
                                  }
                                  switch($param->value_type){
                                    case "hardcode":
                                    $param->value=$param->value;
                                    break;
                                    case "variable":
                                    $param->value="<?php if(isset($".$param->value.")){ echo $".$param->value.";} ?>";
                                    break;
                                  }
                                  switch($param->slash){
                                    case "/":
                                    $linknya.="/".$param->index."/".$param->value."";
                                    break;
                                    case "?":
                                    $linknya.="?".$param->index."=".$param->value."";
                                    break;
                                    case "&":
                                    $linknya.="&".$param->index."=".$param->value."";
                                    break;
                                  }
                                }
                                //echo $linknya;
                                return $linknya;
                              }

                              function render_grup_engine(stdClass $thepage){
                                $objreturn=new \stdClass();
                                $content="";
                                $varphpawal=array();
                                $varjsawal="";
                                $deklarasi=array();
                                $include=array();
                                $ar_worktodo=array();
                                $properties_modul=$thepage->properties_modul;
                                $isideklarasi="";
                                $isivarawal="";

                                $incudah=array();
                                $isiinclude="";
                                //echo "nama modul ".$thepage->properties_modul."<BR><BR><BR><BR><BR>";
                                $properties_page=$thepage->properties_page;
                                //echo "nama page ".$properties_page."<BR><BR><BR><BR><BR>";
                                $controller_nickname="controller_".$properties_modul;
                                $page_nickname="page_".$properties_page;
                                $page_name_controller=$page_nickname.$controller_nickname;
                                if(isset($thepage->process) && count($thepage->process)>0){
                                  foreach($thepage->process as $pro){
                                    $properties_modul=$pro->properties_modul;
                                    $properties_page=$pro->properties_page;
                                    //  echo $pro->type."<BR>";
                                    if(isset($pro->properties_modul)){
                                      //echo "nama modul ".$pro->properties_modul."<BR><BR><BR><BR><BR>";
                                    }else{
                                      //  echo "AAA".$pro->type."<BR><BR><BR>";
                                    }
                                    $dapetmesin=0;
                                    $adaawal="";
                                    $adaakhir="";
                                    $newcontent="";
                                    if(isset($pro->runifnotnull)){
                                      if(count($pro->runifnotnull)>0){
                                        $adaawal.='if (';
                                        for($pa=0; $pa<count($pro->runifnotnull); $pa++){
                                          if(!isset($pro->runifnotnull[$pa]->var_type)){
                                            $pro->runifnotnull[$pa]->var_type="variable";
                                          }
                                          $adaawal.=' '.create_variable_web($pro->runifnotnull[$pa]).'!=null';
                                          if($pa+1<count($pro->runifnotnull)){
                                            $adaawal.=' &&';
                                          }
                                        }
                                        $adaawal.='){'."\n";
                                        }
                                      }

                                      $dapetmesin=1;
                                      $getengine=render_engine($pro->type,$pro,$pro,null);
                                      $newcontent.=$getengine->content."\n";
                                      if(isset($getengine->varjsawal)){
                                      $varjsawal.=$getengine->varjsawal;
                                      }
                                      $ar_worktodo=array_merge($ar_worktodo,$getengine->ar_worktodo);


                                          if(isset($pro->runifnotnull)){
                                            if(count($pro->runifnotnull)>0){
                                              $adaakhir.='}'."\n";
                                            }
                                          }

                                          if($dapetmesin==1){

                                            $content.=$adaawal.$newcontent.$adaakhir;
                                            //  echo $content."<BR>";
                                          }


                                        }
                                        //echo "tipe ".$pro->type.$content."<BR>";
                                        $ar_worktodo[]=array("type"=>"add_to_function","work_id"=>"run_process_".$pro->type."_in_function_".$properties_page."_in_".$properties_modul,"function_id"=>"function_".$page_name_controller,"content"=>$content."\n");

                                        //echo "function_id "."function_".$page_name_controller."<BR>";
                                        //  echo "run process "."run_process_".$pro->type."_in_function_".$properties_page."_in_".$properties_modul." content ".$content."<BR>";


                                        for($d=0;$d<count($include);$d++){
                                          if(!in_array($include[$d],$incudah)){
                                            $incudah[]=$include[$d];
                                            $isiinclude.=$include[$d];
                                          }
                                        }

                                        $dekudah=array();
                                        for($d=0;$d<count($deklarasi);$d++){
                                          if(!in_array($deklarasi[$d],$dekudah)){
                                            $dekudah[]=$deklarasi[$d];
                                            $isideklarasi.=$deklarasi[$d];
                                          }
                                        }

                                        $varudah=array();
                                        for($d=0;$d<count($varphpawal);$d++){
                                          if(!in_array($varphpawal[$d],$varudah)){
                                            $varudah[]=$varphpawal[$d];
                                            $isivarawal.=$varphpawal[$d];
                                          }
                                        }

                                      }
                                      /**
                                      if(isset($pro->process)){
                                        $grupengine=render_grup_engine($pro);
                                        $ar_worktodo=array_merge($ar_worktodo,$grupengine->ar_worktodo);
                                        $content.=$grupengine->content;
                                        $isideklarasi.=$grupengine->deklarasi;
                                        echo "IYA ADA ".$grupengine->varphpawal;
                                      }
                                      **/

                                      $objreturn->content=$content;
                                      $objreturn->varjsawal=$varjsawal;
                                      $objreturn->deklarasi=$isideklarasi;
                                      $objreturn->varphpawal=$isivarawal;
                                      $objreturn->include=$incudah;
                                      $objreturn->ar_worktodo=$ar_worktodo;

                                      return $objreturn;
                                      //akhir render_grup_engine
                                    }

                              function render_engine($type,$engine,$pro,$action){
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

                                //echo "prop ".$pro->properties_modul." page ".$pro->properties_page."<BR>";
                                $objrender=call_user_func("func_process_".$type,$engine,$pro,$action);
                                $content=$objrender->content;
                                $varjsawal=$objrender->varjsawal;
                                $deklarasi=$objrender->deklarasi;
                                $varphpawal=$objrender->varphpawal;
                                $include=$objrender->include;
                                $ar_worktodo=$objrender->ar_worktodo;



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
