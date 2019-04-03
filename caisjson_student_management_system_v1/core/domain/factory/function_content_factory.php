<?php

namespace core\domain\factory;
use core\domain\entity\entity_function_content;
class function_content_factory {

protected $thefunctioncontent;

public function create($a,$b,$c) {
    $newentity = new entity_function_content();
    $newentity->setFunctionID($a);
    $newentity->setContent($b);
    $newentity->setIndex($c);
    $this->thefunctioncontent=$newentity;
    return $this;
}

public function getFunctionContent() {
    return $this->thefunctioncontent;
}

}
 ?>
