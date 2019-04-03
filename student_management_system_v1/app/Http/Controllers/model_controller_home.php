<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MVC_MODEL\model_page_dashboard;
use App\global_model\model_controller_auth_config;

use DB;

class model_controller_home extends Controller
{
  /**
  public function __construct() {
      
  }
  **/

    function page_dashboard(){
session_start();
$obj_dashboard = new model_page_dashboard();
$variables=getVariables();
extract($variables);



$model_controller_auth_config = null; 


$model_controller_auth_config = new model_controller_auth_config();
$model_controller_auth_config->variables=$variables;




$hasilCekAuth = null;



$hasilCekAuth = $model_controller_auth_config->register_auth("",$variables);

$variables['hasilCekAuth'] = $hasilCekAuth;

if (isset($_SESSION['sudahlogin'])){
if ($_SESSION['sudahlogin'] != null
){
}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}






$obj_dashboard->variables=$variables;

return view("mvc_view/home/dashboard/index",compact("variables"));



//end of function page_dashboard

}



}
