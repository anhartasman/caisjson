<?php
/**
 *
 */
namespace core\application\useCase;
use core\domain\repository\directoryInterface;
class createFolderFromDirectoryArray
{
  protected $directoryRepository;

  public function __construct(directoryInterface $folder_interface)
  {
    $this->directoryRepository = $folder_interface;
  }

  public function createFolder($ef){
  for($i=0; $i<count($ef); $i++){
    $savedDirectory = $this->directoryRepository->createFolder($ef[$i]);
  }
  }

}

 ?>
