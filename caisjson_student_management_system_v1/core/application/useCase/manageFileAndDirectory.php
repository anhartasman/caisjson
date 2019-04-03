<?php
/**
 *
 */
namespace core\application\useCase;
use core\domain\repository\fileInterface;
use core\domain\repository\directoryInterface;
use core\domain\entity\entity_file;
use core\domain\entity\entity_directory;
class manageFileAndDirectory
{
  protected $fileRepository;
  protected $directoryRepository;

  public function __construct(fileInterface $file_interface,directoryInterface $folder_interface)
  {
    $this->fileRepository = $file_interface;
    $this->directoryRepository = $folder_interface;
  }

  public function saveFile(entity_file $ef){
    $savedFile = $this->fileRepository->saveFile($ef);
  }

  public function createFolder(entity_directory $ef){
    $savedDirectory = $this->directoryRepository->createFolder($ef);
  }

}

 ?>
