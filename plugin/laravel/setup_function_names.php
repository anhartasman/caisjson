<?php
$ar_fungsi=array();
function setup_database_function_name($objek){
$ar_body_caller=array();
$ar_body_caller_with_name=array();
$ar_nama_fungsi=array();
$ar_checked_objek=array();
  $ar_body_caller=rekur_ar_nama($objek);

   echo "jumlah nama fungsi : ".count($ar_body_caller)."<BR>";
$jummirip=0;
for($i=0; $i<count($ar_body_caller); $i++){
  $thebodycaller=$ar_body_caller[$i];
  $engine=$thebodycaller["process"];
  $additional_name="";
  switch($engine->type){
    case "table":
    $additional_name=$engine->process_name."_".$engine->table_name;
    break;
  }
  $thename="Go_".$engine->type."_for_modul_".$engine->properties_modul."_page_".$engine->properties_page."_".$additional_name;

    $nobody=array();
    $nobody["modul"]=$thebodycaller["modul"];
    $nobody["page"]=$thebodycaller["page"];
    $nobody["table"]=$thebodycaller["table"];
    $nobody["process_name"]=$thebodycaller["process_name"];

    if($thebodycaller["modul"]=="retrieve_data"){
      //echo "ada retrieve<br>";
    }

  if(! in_array($thename,$ar_nama_fungsi)){
    $ar_nama_fungsi[]=$thename;
    $ar_body_caller_with_name[]=array("thecaller"=>$thebodycaller,"func_name"=>$thename);
    //$ar_checked_objek[]=$thebodycaller;
  }else{

      if(! in_array($thebodycaller,$ar_checked_objek)){
        $dapat=0;
        while($dapat==0){
        $temp_name=$thename;
          $temp_name.=rand(1,1000);

            if(! in_array($temp_name,$ar_nama_fungsi)){
              $ar_nama_fungsi[]=$temp_name;

              $ar_body_caller_with_name[]=array("thecaller"=>$thebodycaller,"func_name"=>$temp_name);


              $dapat=1;
            }
        }
      //  echo "uniknya".$temp_name."<BR>";

      }else{
        $jummirip+=1;
      }



  }
    $ar_checked_objek[]=$thebodycaller;

}
echo "ada kemiripan : $jummirip<BR>";

echo " tes panjang ".count($ar_body_caller_with_name)."<BR>";
$_SESSION['ar_fungsi_caller']=$ar_body_caller_with_name;

}


function rekur_ar_nama($objek){
  $ar_nama=array();
  foreach($objek as $key =>  $category){
    $tulisancat=json_encode($category);
    if(is_array($category)){
        //echo "iya moduls".$key."<BR><BR>";
        if($key=="process"){

          $daf_aaa=rekursifcekprop($objek);
          $ar_nama=array_merge($ar_nama,$daf_aaa);
          //$aaa=get_fungsi_name_new2($category->properties_modul,$category->properties_page,$category->type,$category,"");
          //$ar_nama[]=$aaa;
          if(count($ar_nama)>0){
          //echo "jum ar nama : ".count($ar_nama)."<BR>";
          }
        }
      $hasilrekursif=rekur_ar_nama($category,$ar_nama);
      $ar_nama=array_merge($ar_nama,$hasilrekursif);
    }else if (is_object($category)) {
      $hasilrekursif=rekur_ar_nama($category,$ar_nama);
      $ar_nama=array_merge($ar_nama,$hasilrekursif);
      //$ar_nama[]=$aaa;
    //  $daf_stringinclude=array_merge($daf_stringinclude,$hasilrekursif);
    }else{
      //$category->properties_modul="NAMA MODUL";
    }
  }

  return $ar_nama;
}

function rekursifcekprop($process){
  $daf_url_catcher=array();
  //echo "DIPANGGIL";
  //echo "api ".$page_name."<BR>";

    foreach($process as $pro){
      if(is_array($pro)){
        $hasilrekursif=rekursifcekprop($pro);
        $daf_url_catcher=array_merge($daf_url_catcher,$hasilrekursif);
      }else if (is_object($pro)) {
        if(isset($pro->type)){
          switch($pro->type){
            case "table":
          $aaa=get_fungsi_name_new2($pro->properties_modul,$pro->properties_page,$pro->type,$pro,"");
          $daf_url_catcher[]=$aaa;
          break;
          }
        }
        $hasilrekursif=rekursifcekprop($pro);
        $daf_url_catcher=array_merge($daf_url_catcher,$hasilrekursif);
      }else{
        //$category->properties_modul="NAMA MODUL";
      }
    }
  return $daf_url_catcher;
  //akhir rekursifcekurlcatcher
}

function get_fungsi_name_new2($modul,$page,$enginetype,$enginebody,$tambahan){
  $additional_name="";
  $arbalikan=array();
  //$arbalikan["taken"]=0;
  //$ar_fungsi = $_SESSION['ar_fungsi'];
  switch($enginetype){
    case "table":
    $arbalikan["modul"]=$modul;
    $arbalikan["page"]=$page;
    $arbalikan["table"]=$enginebody->table_name;
    $arbalikan["process_name"]=$enginebody->process_name;
    $arbalikan["process"]=$enginebody;

    $additional_name=$enginebody->process_name."_".$enginebody->table_name;
    break;
  }
  $thename="Go_".$enginetype."_for_modul_".$modul."_page_".$page."_".$additional_name;
  $hasilreturn=$thename;
  //$arbalikan["func_name"]=$hasilreturn;

  //$_SESSION['ar_fungsi']=$ar_fungsi;
  return $arbalikan;

  //akhir get_fungsi_name_new
}


function get_fungsi_name_new3($modul,$page,$enginetype,$enginebody,$tambahan){
  $additional_name="";
  //$ar_fungsi = $_SESSION['ar_fungsi'];
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
  //$_SESSION['ar_fungsi']=$ar_fungsi;
  return $objreturn;

  //akhir get_fungsi_name_new
}



 ?>
