<?php
namespace core\domain\repository;
use core\domain\entity\entity_directory;
interface directoryInterface {
public function __construct();
  public function createFolder(entity_directory $thefolder);
}
 ?>
