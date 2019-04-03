<?php
namespace core\domain\repository;
use core\domain\entity\entity_project_json;
interface projectInterface {
public function __construct(entity_project_json $epj);
  public function getFileTeller();
  public function getWorkFromTeller();
}
 ?>
