<?php

namespace core\domain\factory;
use core\domain\entity\entity_function_auth;
class function_auth_factory {

protected $thefunctionauth;

public function create($a,$b,$c) {
    $newentity = new entity_function_auth();
    $newentity->setFunctionID($a);
    $newentity->setContent($b);
    $newentity->setContentFooter($c); 
    $this->thefunctionauth=$newentity;
    return $this;
}

public function getFunctionAuth() {
    return $this->thefunctionauth;
}

}
 ?>
