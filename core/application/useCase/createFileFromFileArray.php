<?php
/**
 *
 */
namespace core\application\useCase;
use core\domain\repository\fileInterface;
use core\domain\entity\entity_file;
class createFileFromFileArray
{
  protected $fileRepository;

  public function __construct(fileInterface $file_interface)
  {
    $this->fileRepository = $file_interface;
  }

  public function saveFile($ef){
    for($i=0; $i<count($ef); $i++){
      $savedFile = $this->fileRepository->saveFile($ef[$i]);
    }
  }

}

 ?>
