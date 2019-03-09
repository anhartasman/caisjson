<?php

require_once ("core/domain/repository/fileInterface.php");
require_once ("core/domain/factory/file_factory.php");
require_once ("core/domain/entity/entity_file.php");
require_once ("core/application/useCase/createFileFromFileArray.php");

use core\domain\repository\fileInterface;
use core\domain\factory\file_factory;
use core\application\useCase\createFileFromFileArray;
use core\domain\entity\entity_file;
class testCreateFilesInterface implements fileInterface {
public function __construct(){

}
  public function saveFile(entity_file $thefile){
    //if(file_exists(dirname($thefile->getFilePath()))){
        file_put_contents($thefile->getFilePath(),$thefile->getFileContent());
        echo "File ".$thefile->getFileName()." created in path : ".$thefile->getFilePath()."<br>";
    //}
  }
}

?>
