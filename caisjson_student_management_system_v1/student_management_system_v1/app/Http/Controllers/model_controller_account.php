<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\MVC_MODEL\model_page_login;
use App\MVC_MODEL\model_page_logout;
use App\global_model\model_controller_auth_config;

use DB;

class model_controller_account extends Controller
{
  /**
  public function __construct() {
      
  }
  **/

    function page_login(){
session_start();
$obj_login = new model_page_login();
$variables=getVariables();
extract($variables);



$obj_login->variables=$variables;

return view("mvc_view/account/login/index",compact("variables"));



//end of function page_login

}

function page_logout(){
session_start();
$obj_logout = new model_page_logout();
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
if ( isset( $_COOKIE[session_name()] ) ){
setcookie( session_name(), "", time()-3600, "/" );
//clear session from globals
$_SESSION = array();
//clear session from disk
 session_destroy();
}

header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}

}else{
header("Location: http://localhost/student_management_system_v1/admin/account/login");
die();
}






$obj_logout->variables=$variables;

return view("mvc_view/account/logout/index",compact("variables"));



//end of function page_logout

}



}
