<?php
include "../mvc_model/model_page_documentation.php";

class model_controller_system_information {

public function __construct() {
    
}

function page_documentation(){
$obj_documentation = new model_page_documentation();
$obj_documentation->db=$this->db;
$variables=$this->variables;
extract($variables);



$obj_documentation->variables=$variables;

include "../mvc_view/system_information/documentation/index.php";



//end of function page_documentation

}


}
?>
