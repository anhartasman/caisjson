<?php
namespace core\domain\repository;
use core\domain\entity\entity_project_json;
interface fileComposerInterface {
public function __construct(fileTellerInterface $fti);
  public function doJob();
}
 ?>
