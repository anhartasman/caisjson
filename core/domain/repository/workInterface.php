<?php
namespace core\domain\repository;
use core\domain\entity\entity_work;
interface workInterface {
public function __construct($works);
  public function addWorkToArray(entity_work $work);
  public function getFolderContent($project_configuration);
}
 ?>
