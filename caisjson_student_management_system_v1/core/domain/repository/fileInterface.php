<?php
namespace core\domain\repository;
use core\domain\entity\entity_file;
interface fileInterface {
public function __construct();
  public function saveFile(entity_file $thefile);
}
 ?>
