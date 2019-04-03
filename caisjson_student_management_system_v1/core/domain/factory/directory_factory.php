<?php

namespace core\domain\factory;
use core\domain\entity\entity_directory;
class directory_factory {

protected $thedirectory;

public function create($fn,$fp) {
    $newdirectory = new entity_directory();
    $newdirectory->setDirectoryName($fn);
    $newdirectory->setDirectoryPath($fp);
    $this->thedirectory=$newdirectory;
    return $this;
}

public function getDirectory() {
    return $this->thedirectory;
}

}
 ?>
