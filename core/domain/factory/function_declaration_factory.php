<?php

namespace core\domain\factory;
use core\domain\entity\entity_declaration;
class function_declaration_factory {

protected $thefunctiondeclaration;

public function create($a,$b,$c) {
    $newentity = new entity_declaration();
    $newentity->setFunctionID($a);
    $newentity->setContent($b);
    $newentity->setIndex($c);
    $this->thefunctiondeclaration=$newentity;
    return $this;
}

public function getFunctionDeclaration() {
    return $this->thefunctiondeclaration;
}

}
 ?>
