<?php
/**
 *
 */
namespace core\application\useCase;
use core\domain\repository\workInterface;
use core\domain\factory\work_factory;
class get_folder_content
{
  protected $works;

  public function __construct(workInterface $pji)
  {
    $this->works = $w;
  }

  public function getFolderContent($project_configuration){
    $teller = $this->projectInterface->getFileComposer();

    return $teller;
  }


}

 ?>
