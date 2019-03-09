<?php

namespace core\domain\factory;
use core\domain\entity\entity_function;
class function_factory {

protected $thefunction;

public function create($a,$b,$c,$d,$e) {
    $newentity = new entity_function();
    $newentity->setFileID($a);
    $newentity->setID($b);
    $newentity->setName($c);
    $newentity->setParameters($d);
    $newentity->setContent($e);
    $this->thefunction=$newentity;
    return $this;
}

public function getFunction() {
    return $this->thefunction;
}

}
 ?>
