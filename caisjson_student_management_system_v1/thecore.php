<?php
      require_once('registered_compilers.php');
require_once("core/domain/entity/for_file_entity.php");
require_once ("core/domain/entity/for_function_entity.php");
require_once ("core/domain/entity/entity_file.php");
require_once ("core/domain/entity/entity_function.php");
require_once ("core/domain/entity/entity_function_auth.php");
require_once ("core/domain/entity/entity_function_footer.php");
require_once ("core/domain/entity/entity_function_content.php");
require_once ("core/domain/entity/entity_declaration.php");
require_once ("core/domain/entity/entity_directory.php");
require_once ("core/domain/entity/entity_work.php");
require_once ("core/domain/entity/entity_include.php");
require_once ("core/domain/entity/entity_file_indexes.php");
require_once ("core/domain/factory/file_factory.php");
require_once ("core/domain/factory/file_include_factory.php");
require_once ("core/domain/factory/directory_factory.php");
require_once ("core/domain/factory/work_factory.php");
require_once ("core/domain/factory/function_factory.php");
require_once ("core/domain/factory/function_auth_factory.php");
require_once ("core/domain/factory/file_indexes_factory.php");
require_once ("core/domain/factory/function_declaration_factory.php");
require_once ("core/domain/factory/function_content_factory.php");
require_once ("core/domain/factory/function_footer_factory.php");
require_once ("core/domain/repository/fileInterface.php");
require_once ("core/domain/repository/directoryInterface.php");
require_once ("core/domain/repository/projectConceptToFileIndexesInterface.php");
require_once ("core/domain/repository/projectInterface.php");
require_once ("core/domain/repository/fileTellerInterface.php");
require_once ("core/domain/repository/fileWorkerInterface.php");
require_once ("core/domain/repository/fileComposerInterface.php");
require_once ("core/domain/repository/workInterface.php");
require_once ("core/application/useCase/manageFileAndDirectory.php");
require_once ("core/application/useCase/convertFileIndexesToFileArray.php");
use core\domain\factory\file_factory;
use core\domain\factory\directory_factory;
use core\domain\factory\work_factory;
use core\application\useCase\manageFileAndDirectory;
use core\domain\repository\fileInterface;
use core\domain\repository\directoryInterface;
use core\domain\repository\projectInterface;
use core\domain\repository\fileTellerInterface;
use core\domain\repository\fileWorkerInterface;
use core\domain\repository\fileComposerInterface;
use core\domain\repository\workInterface;
use core\domain\entity\entity_work;
use core\domain\entity\for_file_entity;
use core\application\useCase\createFolderFromDirectoryArray;
use core\application\useCase\createFileFromFileArray;
use core\application\useCase\convertFileIndexesToFileArray;

$job="";

include("test/createDirectory.php");
include("test/createFile.php");

$tesfolder = new testCreateFoldersInterface();

$obj_folder_creator = new createFolderFromDirectoryArray($tesfolder);

$tesfile = new testCreateFilesInterface();
$obj_file_creator = new createFileFromFileArray($tesfile);

//**************HOW THE CORE WORKS(1/3)*****************************************//
//*************************************************************************//
//STEP 1 : CALL conceptConverter TO GENERATE FILE INDEXES
       require_once($file_config->maker_path);
       $conceptConverter = new conceptConverter($file_config,$thejson);
       $file_indexes=$conceptConverter->convertToFileIndexes();
//*************************************************************************//

//**************HOW THE CORE WORKS(2/3)*****************************************//
//*************************************************************************//
//STEP 2 : CREATE FILES ARRAY AND FOLDERS ARRAY FROM FILE INDEXES

        $fileindexesconverter = new convertFileIndexesToFileArray($file_indexes);
        $fileArray=$fileindexesconverter->createFileArray();
//*************************************************************************//

        $filedirection=$file_config->web_localpath;
        for($fa=0; $fa<count($fileArray); $fa++){
          $fileArray[$fa]->setFilePath($filedirection.$fileArray[$fa]->getFilePath());

          $class_content=$fileArray[$fa]->getFileContent();
          if(strpos("tes".$class_content."tes","{cais_public_assets_")){

            $ledakan= (explode("{cais_public_assets_",$class_content));
            for($l=1;$l<count($ledakan);$l++) {
              $subledakan= (explode("}",$ledakan[$l]));
              $kontennya=$subledakan[0];
              $isidirektori=get_public_assets_directory($kontennya);
              $class_content=str_replace("{cais_public_assets_".$subledakan[0]."}",$isidirektori,$class_content);

            }

          }
                $ledakan= (explode("properties_",$class_content));

                  for($l=1;$l<count($ledakan);$l++) {
                    $subledakan= (explode("\"",$ledakan[$l]));
                    $class_content=str_replace("properties_".$subledakan[0]."\"".$subledakan[1]."\"","",$class_content);
                  }

          $class_content=str_replace("{cais_web_url}",$theconfig->web_url,$class_content);
          $class_content=str_replace("{cais_web_folder}",$theconfig->web_folder,$class_content);

          $fileArray[$fa]->setFileContent($class_content);

        }

        //echo "JUM FOLDER : ".count($folder_content->getFileIndexes()->getFolders())."<BR>";
        $folderArray=$file_indexes->getFolders();
        for($fa=0; $fa<count($folderArray); $fa++){
          $folderArray[$fa]->setDirectoryPath($filedirection.$folderArray[$fa]->getDirectoryPath());
        }
//**************HOW THE CORE WORKS(3/3)*****************************************//
//*************************************************************************//
               //STEP 3 : CREATE FILES AND FOLDERS FROM FILES ARRAY AND FOLDERS ARRAY

        $obj_folder_creator->createFolder($folderArray);
        $obj_file_creator->saveFile($fileArray);
//**************************************************************************//



 ?>
