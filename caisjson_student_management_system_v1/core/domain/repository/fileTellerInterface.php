<?php
namespace core\domain\repository;
use core\domain\entity\entity_project_json;
interface fileTellerInterface {
public function __construct(entity_project_json $epj);
  public function doJob(); 
}
 ?>
