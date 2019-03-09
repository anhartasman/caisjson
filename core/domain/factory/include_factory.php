<?php

namespace core\domain\factory;
use core\domain\entity\entity_include;
class include_factory {

protected $theinclude;

public function create($a,$b,$c) {
    $newentity = new entity_include();
    $newentity->setFileID($a);
    $newentity->setID($b);
    $newentity->setContent($c);
    $this->theinclude=$newentity;
    return $this;
}

public function getInclude() {
    return $this->theinclude;
}

}
 ?>
