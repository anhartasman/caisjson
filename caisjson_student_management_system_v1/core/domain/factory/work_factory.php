<?php

namespace core\domain\factory;
use core\domain\entity\entity_work;
class work_factory {

protected $thework;

public function create($work) {
    $newwork = new entity_work();
    $newwork->setWorkType($work["type"]);
    $newwork->setWorkID($work["work_id"]);
    $newwork->setWorkBody($work);
    $this->thework=$newwork;
    return $this;
}

public function getWork() {
    return $this->thework;
}

}
 ?>
