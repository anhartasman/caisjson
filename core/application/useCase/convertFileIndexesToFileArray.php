<?php
/**
 *
 */
namespace core\application\useCase;
use core\domain\entity\entity_file_indexes;
use core\domain\factory\file_factory;
class convertFileIndexesToFileArray
{
  protected $fileindexes;

  public function __construct(entity_file_indexes $fileindexes)
  {
    $this->fileindexes = $fileindexes;
  }
  function cmp($a, $b)
{
return $a->getIndex() > $b->getIndex();
}

  public function createFileArray(){
    $ar_files=$this->fileindexes->getFiles();
    $ar_folders=$this->fileindexes->getFolders();
    $file_array=array();
    echo "<BR><BR><BR>jumlah directories : ".count($ar_folders)."<BR>";
    for($w=0; $w<count($ar_folders);$w++){;
    echo "folder location : ".$ar_folders[$w]->getDirectoryPath()."<BR>";
    }
    echo "<BR><BR><BR>jumlah files : ".count($ar_files)."<BR>";
    for($w=0; $w<count($ar_files);$w++){
      $boxcontent="";
      $include_content="";
      $class_content=$ar_files[$w]->getFileContent();
      $class_content_write="";
      echo "<b>file_name : ".$ar_files[$w]->getFileName()."</b><BR>";
      echo "file_location : ".$ar_files[$w]->getFilePath()."<BR>";


      $the_file_includes=array();
      $the_file_included=array();
      $ar_includes=$this->fileindexes->getFileIncludes();
      for($wf=0; $wf<count($ar_includes);$wf++){
      //  echo "cek addinclunde ".$ar_files[$w]->getFileID()."<BR>";
        if($ar_includes[$wf]->getFileID()==$ar_files[$w]->getFileID()){
        //  echo "ADA SAMA ";
          if(!in_array($ar_includes[$wf]->getID(),$the_file_included)){
            $the_file_includes[]=$ar_includes[$wf];
            $the_file_included[]=$ar_includes[$wf]->getID();
          }
        }
      }
      echo "<BR>";

      echo "jumlah includes : ".count($the_file_includes)."<BR>";
      echo "includes : ";
      for($wf=0; $wf<count($the_file_includes);$wf++){
        echo $the_file_includes[$wf]->getID().",";
        $include_content.=$the_file_includes[$wf]->getContent();
      }
      echo "<BR>";

      $the_file_functions=array();
      $ar_functions=$this->fileindexes->getFileFunctions();
      for($wf=0; $wf<count($ar_functions);$wf++){

        if($ar_functions[$wf]->getFileID()==$ar_files[$w]->getFileID()){
          $the_file_functions[]=$ar_functions[$wf];
        }
      }
      echo "<BR>jumlah functions : ".count($the_file_functions)."<BR> ";
      echo "functions : ";
      for($wf=0; $wf<count($the_file_functions);$wf++){
        echo $the_file_functions[$wf]->getName().",";
        $function_param="";
        for($fu=0;$fu<count($the_file_functions[$wf]->getParameters());$fu++){
          $function_param.=$the_file_functions[$wf]->getParameters()[$fu];
          if($fu+1<count($the_file_functions[$wf]->getParameters())){
            $function_param.=",";
          }
        }
        if($the_file_functions[$wf]->getStarter()==""){
          $the_file_functions[$wf]->setStarter("function");
        }
        $class_content_write.=$the_file_functions[$wf]->getStarter()." ".$the_file_functions[$wf]->getName()."(".$function_param."){"."\n";


          $ar_declarations=$this->fileindexes->getFunctionDeclaration();
          $ar_declarationsnya=array();
          for($fc=0; $fc<count($ar_declarations);$fc++){
            //echo var_dump($ar_declarations[$fc])."<BR>";
            if($ar_declarations[$fc]->getFunctionID()==$the_file_functions[$wf]->getID()){
              //$class_content_write.=$ar_declarations[$fc]->getContent()."\n\n";
              $ar_declarationsnya[]=$ar_declarations[$fc];
                //echo "deklarasi var ".$ar_declarations[$fc]->getContent().",";
            }
          }

          $ar_declaration_index=array();
          for($fc=0; $fc<count($ar_declarationsnya);$fc++){
             //echo "aaa ".$ar_footernya[$fc]->getIndex()."<BR>";
             $ar_declaration_index[]=$ar_declarationsnya[$fc]->getIndex();
          }

          sort($ar_declaration_index);
        for($fci=0; $fci<count($ar_declaration_index);$fci++){
        for($fc=0; $fc<count($ar_declarationsnya);$fc++){
          if($ar_declarationsnya[$fc]->getIndex()==$ar_declaration_index[$fci]){
            $class_content_write.=$ar_declarationsnya[$fc]->getContent()."\n\n";
          }
        }
      }

          $function_content="";
          $ar_function_content=$this->fileindexes->getFunctionContent();
          $ar_function_contentnya=array();
          for($fc=0; $fc<count($ar_function_content);$fc++){
            if($ar_function_content[$fc]->getFunctionID()==$the_file_functions[$wf]->getID()){
              //$function_content.=$ar_function_content[$fc]->getContent()."\n\n";
              $ar_function_contentnya[]=$ar_function_content[$fc];
            }
          }

          $ar_footer_index=array();
          for($fc=0; $fc<count($ar_function_contentnya);$fc++){
             //echo "aaa ".$ar_footernya[$fc]->getIndex()."<BR>";
             $ar_footer_index[]=$ar_function_contentnya[$fc]->getIndex();
          }

          sort($ar_footer_index);
        for($fci=0; $fci<count($ar_footer_index);$fci++){
        for($fc=0; $fc<count($ar_function_contentnya);$fc++){
          if($ar_function_contentnya[$fc]->getIndex()==$ar_footer_index[$fci]){
            $function_content.=$ar_function_contentnya[$fc]->getContent()."\n\n";
          }
        }
        }

          $ar_footer=$this->fileindexes->getFunctionFooter();
          $ar_footernya=array();
          //echo "jumlah footer : ".count($ar_footer);
          for($fc=0; $fc<count($ar_footer);$fc++){
            if($ar_footer[$fc]->getFunctionID()==$the_file_functions[$wf]->getID()){
              //$function_content.=$ar_footer[$fc]->getContent()."\n\n";
              $ar_footernya[]=$ar_footer[$fc];
              //echo "ADA SAMA nih ".$the_file_functions[$wf]->getID()."<BR>";
            }
          }

          $ar_index=array();
          for($fc=0; $fc<count($ar_footernya);$fc++){
             //echo "aaa ".$ar_footernya[$fc]->getIndex()."<BR>";
             $ar_index[]=$ar_footernya[$fc]->getIndex();
          }

          sort($ar_index);

 //$ar_footernya=usort($ar_footernya, array($this,'cmp'));
  //echo "hasil sort".var_dump($ar_index)."<BR>";
for($fci=0; $fci<count($ar_index);$fci++){
for($fc=0; $fc<count($ar_footernya);$fc++){
  if($ar_footernya[$fc]->getIndex()==$ar_index[$fci]){
    $function_content.=$ar_footernya[$fc]->getContent()."\n\n";
  }
}
}

          $ar_auth=$this->fileindexes->getFunctionAuth();
          for($a=0; $a<count($ar_auth);$a++){
            if($ar_auth[$a]->getFunctionID()==$the_file_functions[$wf]->getID()){
              $function_content=$ar_auth[$a]->getContent().$function_content.$ar_auth[$a]->getContentFooter();
            }
          }
          $class_content_write.=$function_content;

          $class_content_write.="//end of ".$the_file_functions[$wf]->getStarter()." ".$the_file_functions[$wf]->getName()."\n\n";
          $class_content_write.="}"."\n\n";

        } 
        echo "<BR><BR>";

        $class_content=str_replace("{write}",$class_content_write,$class_content);
        $class_content=str_replace("{construct_content}","",$class_content);
        echo "diterima id ".$ar_files[$w]->getFileID()."<BR>";
        $class_content=str_replace("{model_name}","model_".$ar_files[$w]->getFileID(),$class_content);
        $class_content=str_replace("{include}",$include_content,$class_content);

        if(strpos("tes".$class_content."tes","{{")){

          $ledakan= (explode("{{",$class_content));
          for($l=1;$l<count($ledakan);$l++) {
            $subledakan= (explode("}}",$ledakan[$l]));
            $kontennya=$subledakan[0];
            $jsonkon=json_decode("{".$kontennya."}");
            if(isset($jsonkon->var_name)){
              $bahanvar=create_variable_web($jsonkon);
            //echo "Kontennya".$bahanvar;
            $class_content=str_replace("{{".$subledakan[0]."}}","{{".$bahanvar."}}",$class_content);

            }
            //$class_content=str_replace("properties_".$subledakan[0]."\"".$subledakan[1]."\"","",$class_content);
          }

        }

/** UNTUK LUAR
              if(strpos("tes".$class_content."tes","{cais_public_assets_")){

                $ledakan= (explode("{cais_public_assets_",$class_content));
                for($l=1;$l<count($ledakan);$l++) {
                  $subledakan= (explode("}",$ledakan[$l]));
                  $kontennya=$subledakan[0];
                  $isidirektori=get_public_assets_directory($kontennya);
                  $class_content=str_replace("{cais_public_assets_".$subledakan[0]."}",$isidirektori,$class_content);

                  //$class_content=str_replace("properties_".$subledakan[0]."\"".$subledakan[1]."\"","",$class_content);
                }

              }
                    $ledakan= (explode("properties_",$class_content));

                      for($l=1;$l<count($ledakan);$l++) {
                        $subledakan= (explode("\"",$ledakan[$l]));
                        $class_content=str_replace("properties_".$subledakan[0]."\"".$subledakan[1]."\"","",$class_content);
                      }

        $class_content=str_replace("{cais_web_url}",$theconfig->web_url,$class_content);
        $class_content=str_replace("{cais_web_folder}",$theconfig->web_folder,$class_content);
**/
        //echo "<textarea style=\"width:500px; height:100px\" >".$class_content."</textarea><br><br>";
        //echo "<pre><code class=\"language-markup\" style=\"max-height: 15px;overflow: scroll;\">".$class_content."</code></pre><br>";
        //nonaktifkan komen untuk menulis ke file
        //echo $class_content."\n";

        //file_put_contents($filedirection.$ar_files[$w]["location"],$class_content);

        $ff = new file_factory();
        $ff->create($ar_files[$w]->getFileName(),$ar_files[$w]->getFilePath(),$class_content);
        $file_array[]=$ff->getFile();
        //echo "tulis ke ".$filedirection.$ar_files[$w]["location"]."\n";
      }

      return $file_array;
  }

}

 ?>
