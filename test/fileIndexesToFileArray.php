<?php

require_once ("core/domain/repository/directoryInterface.php");
require_once ("core/domain/factory/directory_factory.php");
require_once ("core/domain/entity/entity_directory.php");
require_once ("core/application/useCase/convertFileIndexesToFileArray.php");

use core\domain\repository\directoryInterface;
use core\domain\factory\directory_factory;
use core\application\useCase\convertFileIndexesToFileArray;
class fileIndexesToFileArray implements directoryInterface {
public function __construct(){

}
  public function createFolder(entity_directory $thefolder){
      if (!file_exists($thefolder->getDirectoryPath())) {
        mkdir($thefolder->getDirectoryPath(), 0777, true);
        echo "Folder ".$thefolder->getDirectoryName()." created with path : ".$thefolder->getDirectoryPath()."<br>";
      }else{
        echo "Error. Folder ".$thefolder->getDirectoryName()." already exist in path : ".$thefolder->getDirectoryPath()."<br>";
      }

  }
}




 ?>
