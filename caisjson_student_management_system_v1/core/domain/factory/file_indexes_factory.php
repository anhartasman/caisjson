<?php

namespace core\domain\factory;
use core\domain\entity\entity_file_indexes;
class file_indexes_factory {

protected $thefileindexes;

public function create($folders,$a,$b,$c,$d,$e,$f,$g) {
    $newentity = new entity_file_indexes();
    $newentity->setFolders($folders);
    $newentity->setFiles($a);
    $newentity->setFileIncludes($b);
    $newentity->setFileFunctions($c);
    $newentity->setFunctionAuth($d);
    $newentity->setFunctionDeclaration($e);
    $newentity->setFunctionContent($f);
    $newentity->setFunctionFooter($g);
    //$newentity->setFunctio($g);

    $this->thefileindexes=$newentity;
    return $this;
}

public function getFileIndexes() {
    return $this->thefileindexes;
}

}
 ?>
