<?php

namespace core\domain\factory;
use core\domain\entity\entity_function_footer;
class function_footer_factory {

protected $thefunctionfooter;

public function create($a,$b,$c) {
    $newentity = new entity_function_footer();
    $newentity->setFunctionID($a);
    $newentity->setContent($b);
    $newentity->setIndex($c);
    $this->thefunctionfooter=$newentity;
    return $this;
}

public function getFunctionFooter() {
    return $this->thefunctionfooter;
}

}
 ?>
