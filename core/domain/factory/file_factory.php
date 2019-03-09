<?php

namespace core\domain\factory;
use core\domain\entity\entity_file;
class file_factory {

protected $thefile;

public function create($fid,$fn,$fp) {
    $newfile = new entity_file();
    $newfile->setFileID($fid);
    $newfile->setFileName($fid);
    $newfile->setFilePath($fn);
    $newfile->setFileContent($fp);
    $this->thefile=$newfile;
    return $this;
}

public function getFile() {
    return $this->thefile;
}

}
 ?>
