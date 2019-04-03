<?php
if(isset($variables)){
  extract($variables);
}
?>
<?php
$page_name="Login | Student Management System";
$modul_id="account";
$modul_id_page_id="account_login";
$copy_base_language_library_web_css=array();

?>

<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=$page_name?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?=$base_url?>/public/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?=$base_url?>/public/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?=$base_url?>/public/bower_components/Ionicons/css/ionicons.min.css">

    <?php

    if(isset($copy_base_language_library_web_css)){
      for($c=0; $c<count($copy_base_language_library_web_css);$c++){
        print("<!-- ".$copy_base_language_library_web_css[$c]["name"]." -->"."\n");
        print("<link rel=\"stylesheet\" href=\"".$base_url."/".$copy_base_language_library_web_css[$c]["path"]."\">"."\n");

      }
    }

     ?>
  <!-- Theme style -->
  <link rel="stylesheet" href="<?=$base_url?>/public/dist/css/AdminLTE.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?=$base_url?>/public/plugins/iCheck/square/blue.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="<?=$base_url?>/index2.html"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Login</p>

      

 <div class="row">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Form Login </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
                   <form role="form" name="form_login" id="form_login" method="POST"  >
<div class="box-body">

<div class="form-group">
  <label>Username</label>
  <input type="text" class="form-control form-control" id="username"  name="username" placeholder="Enter username"  value="" >
</div>

<div class="form-group has-feedback">
  <label>Password</label>
  <input type="password" class="form-control form-control" id="password"  name="password" placeholder="Enter password" value="" >
  <span class="glyphicon glyphicon-lock form-control-feedback"></span>
</div>

<div class="box-footer">
  <button type="button" id="buttonSubmitForm" name="buttonSubmitForm" class="btn btn-primary">Login</button>
</div>
</div>
</form>

              <!-- /.box-body --> 
          </div>


          </div>

    <!-- /.social-auth-links -->

    <a href="#">I forgot my password</a><br>
    <a href="register.html" class="text-center">Register a new membership</a>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?=$base_url?>/public/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=$base_url?>/public/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?=$base_url?>/public/plugins/iCheck/icheck.min.js"></script>


<script>
  $(function () {

    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' /* optional */
    });

                         	var ajaxjsonisitabel;
             function ambildatatabel(){

               ajaxjsonisitabel = buatajax();
               var url="http://berkahniaga.com/bendajaya/public/admin/keuangan/pengajuantopup/carijson/"+isipilthn+"/"+isipilbln+"/"+isipilstatus;
               //url=url+"?q="+nip;
               //url=url+"&sid="+Math.random();
               ajaxjsonisitabel.onreadystatechange=stateChangedjsonisitabel;
               ajaxjsonisitabel.open("GET",url,true);
               ajaxjsonisitabel.send(null);

             }

             function stateChangedjsonisitabel(){
               var datarjsonisitabel;
                if (ajaxjsonisitabel.readyState==4){
                  datarjsonisitabel=ajaxjsonisitabel.responseText;
                  if(datarjsonisitabel.length>0){
                    jsonisitabel=datarjsonisitabel;
                      //    alert('ada');
                    //document.getElementById("hasilkirim").html = data;
                  //  $('#bodyexample1').html(data);
                  var string = "UpdateBootProfile,PASS,00:00:00";
                  var array = datarjsonisitabel.split(",");
                  var data = [
                      array
                  ];
                  $('#sample_1').dataTable().fnClearTable();
                  var obj=JSON.parse(datarjsonisitabel);

                  if(obj.list!=null){
                                        if(obj.listidtabel==null){
                      alert("kosong");
                    }
                    listidtabel=obj.listidtabel;

                  $('#sample_1').dataTable().fnAddData(obj.list);
                    $("#isifooter").html(obj.isifooter);
                  }else{
                    $("#isifooter").html("");
                  }

                   }
                   //alert(jsonisitabel);

                 }
            }


   });
   var page_id="login";
var modul_id="account";

var isian_username = null;

var isian_password = null;

var isian_buttonSubmitForm = null;



$("<?php if(isset($prepage)){print($prepage);} ?>#buttonSubmitForm").on( 'click', function () {
get_variable_of_form_form_login();

var return_of_check_validation_form_form_login = check_validation_form_form_login();
if (return_of_check_validation_form_form_login == true){
upload_data_account();

}


});
function get_variable_of_form_form_login(){ 

isian_username = document.getElementById("username").value;
isian_password = document.getElementById("password").value;


//end of get_variable_of_form_form_login
}
function check_validation_form_form_login(){
var valid_status=true;
var valid_msg="";

var field_tocheck_username = document.getElementById("username");
if (field_tocheck_username.value.length < 1) {
  valid_status=false;
  valid_msg+="Please fill in the username,";
}

var field_tocheck_password = document.getElementById("password");
if (field_tocheck_password.value.length < 1) {
  valid_status=false;
  valid_msg+="Please fill in the password,";
}



if(valid_status==false){
  alert(valid_msg);
}

return valid_status;

//end of check_validation_form_form_login
}
function submit_form_form_login(){
     
}
var el_of_form_login = document.getElementById("form_login");

// Execute a function when the user releases a key on the keyboard
el_of_form_login.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    //document.getElementById("myBtn").click();
    get_variable_of_form_form_login();

var return_of_check_validation_form_form_login = check_validation_form_form_login();
if (return_of_check_validation_form_form_login == true){
upload_data_account();

}


  }
});
function upload_data_account(){
ajaxjson_upload_data_account = buatajax();
var url="http://localhost/student_management_system_v1/API";
ajaxjson_upload_data_account.onreadystatechange = stateChangedjson_upload_data_account;
ajaxjson_upload_data_account.open("POST",url,true);
ajaxjson_upload_data_account.setRequestHeader("Content-Type", "application/json");
var data = JSON.stringify({"modul":"retrieve_data","action":"login","username":isian_username,"password":isian_password});
console.log("Data sent from upload_data_account : "+data);
ajaxjson_upload_data_account.send(data);


}
var ajaxjson_upload_data_account;
function stateChangedjson_upload_data_account(){
  var this_html_response;
   if (ajaxjson_upload_data_account.readyState==4){
     this_html_response=ajaxjson_upload_data_account.responseText;
     console.log("response from upload_data_account : "+ajaxjson_upload_data_account.responseText);
     if(this_html_response.length>0){



     var hasilLogin = ekstrakHasilUpload(this_html_response,"error_code");
if (hasilLogin == 000){
jumpketabel("home","dashboard");

}



          setListeners();
      }
    }
}

var hasilLogin;
function ekstrakHasilUpload(dataekstrakHasilUpload,targetekstrakHasilUpload){
var objekstrakHasilUpload=JSON.parse(dataekstrakHasilUpload);
var content_of_ekstrakHasilUpload=objekstrakHasilUpload[targetekstrakHasilUpload];
hasilLogin = content_of_ekstrakHasilUpload;

return content_of_ekstrakHasilUpload;

}
function jumpketabel(moduljumpketabel,pagejumpketabel){
window.location.href = 'http://localhost/student_management_system_v1/admin/'+moduljumpketabel+'/'+pagejumpketabel;


}



                       function buatajax(){
                         if (window.XMLHttpRequest){
                           return new XMLHttpRequest();
                         }
                         if (window.ActiveXObject){
                            return new ActiveXObject("Microsoft.XMLHTTP");
                          }
                          return null;
                        }
</script>

</body>
</html>
