<?php

namespace core\domain\factory;
use core\domain\entity\entity_include;
class file_include_factory {

protected $thefileinclude;

public function create($id,$a,$b) {
    $newfileinclude = new entity_include();
    $newfileinclude->setID($id);
    $newfileinclude->setFileID($a);
    $newfileinclude->setContent($b);
    $this->thefileinclude=$newfileinclude;
    return $this;
}

public function getFileInclude() {
    return $this->thefileinclude;
}

}
 ?>
