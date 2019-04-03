@extends('layouts.layout_admin')
@section('content_header_admin')
<?php
if(isset($variables)){
  extract($variables);
}
$page_name="edit student | Student Management System";
$modul_id="people";
$modul_id_page_id="people_edit_student";
$copy_base_language_library_web_css=array();

?>
@endsection
@section('content_admin')
  <!-- Content Wrapper. Contains page content -->
  <?php
  $modal="tidak";
  if(isset($_GET['modal'])){
    $modal="iya";
  }
   ?>
   <?php
   if($modal=="tidak"){
    ?>
    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title">Default Modal</h4>
          </div>
          <div class="modal-body">
            <p><div id="bahanmodal">
            </div></p>
          </div>
          <!--modal button
          <div class="modal-footer">
            <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save changes</button>
          </div>
        -->
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        edit student
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">people</a></li>
        <li class="active">edit student</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php
        }
         ?>
      

 <div class="row">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Form student </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
                   <form role="form" name="form_edit_student_in_modul_people_page_edit_student" id="form_edit_student_in_modul_people_page_edit_student" method="POST"  >
<div class="box-body">

<div class="form-group">
  <label>name</label>
  <input type="text" class="form-control form-control" id="field_namemodul_people_page_edit_student"  name="field_namemodul_people_page_edit_student" placeholder="Isi name"  value="<?php if(isset($data_diri_tb_student)){ print($data_diri_tb_student['name']); } ?>" >
</div>

<div class="form-group">
  <label>address</label>
  <input type="text" class="form-control form-control" id="field_addressmodul_people_page_edit_student"  name="field_addressmodul_people_page_edit_student" placeholder="Isi address"  value="<?php if(isset($data_diri_tb_student)){ print($data_diri_tb_student['address']); } ?>" >
</div>

<div class="form-group">
  <label>photo</label>
  <img id="img_of_field_photomodul_people_page_edit_student" src="http://localhost/student_management_system_v1/public/uploads/<?php print($data_diri_tb_student['photo']);?>" alt="no image" />
  <input type="file" name="field_photomodul_people_page_edit_student" id="field_photomodul_people_page_edit_student">

  <!--<p class="help-block">Example block-level help text here.</p>-->
</div>

<div class="box-footer">
  <button type="button" id="submit_button_editstudent_in_modul_people_page_edit_student" name="submit_button_editstudent_in_modul_people_page_edit_student" class="btn btn-primary">Update</button>
</div>
</div>
</form>

              <!-- /.box-body --> 
          </div>


          </div>

      <!-- /.row -->
          <?php
          if($modal=="tidak"){
           ?>
    </section>
    <!-- /.content -->

  </div>
  <?php
  }
   ?>
  @endsection

  @section('content_footer_admin')

     <?php
     if($modal=="tidak"){
      ?>
<!-- jQuery 3 -->
<script src="{{ asset('public/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('public/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('public/bower_components/raphael/raphael.min.js') }}"></script>
<script src="{{ asset('public/bower_components/morris.js/morris.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('public/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
<!-- jvectormap -->
<script src="{{ asset('public/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
<script src="{{ asset('public/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('public/bower_components/jquery-knob/dist/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('public/bower_components/moment/min/moment.min.js') }}"></script>
<script src="{{ asset('public/bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<!-- datepicker -->
<script src="{{ asset('public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- CK Editor -->
<script src="{{ asset('public/bower_components/ckeditor/ckeditor.js') }}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ asset('public/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('public/bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- AdminLTE for demo purposes
<script src="{{ asset('public/dist/js/demo.js') }}"></script>
-->
<!-- AdminLTE App -->
<script src="{{ asset('public/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes)
<script src="{{ asset('public/dist/js/pages/dashboard.js') }}"></script>
 -->
 <!-- jQuery Modal
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.js"></script>
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-modal/0.9.1/jquery.modal.min.css" />
 -->

 
 <!-- Add mousewheel plugin (this is optional) -->
 <script type="text/javascript" src="{{ asset('public/fancybox/lib/jquery.mousewheel-3.0.6.pack.js') }}"></script>

 <!-- Add fancyBox -->
 <link rel="stylesheet" href="{{ asset('public/fancybox/source/jquery.fancybox.css?v=2.1.7') }}" type="text/css" media="screen" />
 <script type="text/javascript" src="{{ asset('public/fancybox/source/jquery.fancybox.pack.js?v=2.1.7') }}"></script>

 <!-- Optionally add helpers - button, thumbnail and/or media -->
 <link rel="stylesheet" href="{{ asset('public/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5') }}" type="text/css" media="screen" />
 <script type="text/javascript" src="{{ asset('public/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5') }}"></script>
 <script type="text/javascript" src="{{ asset('public/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6') }}"></script>

 <link rel="stylesheet" href="{{ asset('public/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7') }}" type="text/css" media="screen" />
 <script type="text/javascript" src="{{ asset('public/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7') }}"></script>


 <?php } ?>


<script>
  $(function () {



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
   var page_id="edit_student";
var modul_id="people";
<?php $student_in_modul_people_page_edit_student_id = str_replace("?modal=iya","",$student_in_modul_people_page_edit_student_id); ?>
<?php $student_in_modul_people_page_edit_student_id = str_replace("&modal=iya","",$student_in_modul_people_page_edit_student_id); ?>
var catch_student_in_modul_people_page_edit_student_id=<?php print($student_in_modul_people_page_edit_student_id); ?>;

var isian_field_namemodul_people_page_edit_student = null;

var isian_field_addressmodul_people_page_edit_student = null;

var isian_field_photomodul_people_page_edit_student = null;
var isian_field_photomodul_people_page_edit_student_file = null;
var isian_field_photomodul_people_page_edit_student_file_content = null;

var isian_submit_button_editstudent_in_modul_people_page_edit_student = null;



$("<?php if(isset($prepage)){print($prepage);} ?>#field_photomodul_people_page_edit_student").on( 'change', function () {
isian_field_photomodul_people_page_edit_student_file = document.getElementById("field_photomodul_people_page_edit_student").files[0];
if (isian_field_photomodul_people_page_edit_student_file){
var r = new FileReader();
r.onload = function(e) {
var contents = e.target.result;
$('<?php if(isset($prepage)){print($prepage);} ?>#img_of_field_photomodul_people_page_edit_student').attr('src', e.target.result);
isian_field_photomodul_people_page_edit_student_file_content = contents;
}
r.readAsDataURL (isian_field_photomodul_people_page_edit_student_file);
}

});

$("<?php if(isset($prepage)){print($prepage);} ?>#submit_button_editstudent_in_modul_people_page_edit_student").on( 'click', function () {
var return_of_get_variable_of_form_form_edit_student_in_modul_people_page_edit_student = get_variable_of_form_form_edit_student_in_modul_people_page_edit_student();

var return_of_check_validation_form_form_edit_student_in_modul_people_page_edit_student = check_validation_form_form_edit_student_in_modul_people_page_edit_student();
if (return_of_check_validation_form_form_edit_student_in_modul_people_page_edit_student == true){
var hasil_upload_data_studentmodul_people_page_edit_student = upload_data_student_in_modul_people_page_edit_student();

}


});
function get_variable_of_form_form_edit_student_in_modul_people_page_edit_student(){ 

isian_field_namemodul_people_page_edit_student = document.getElementById("field_namemodul_people_page_edit_student").value;
isian_field_addressmodul_people_page_edit_student = document.getElementById("field_addressmodul_people_page_edit_student").value;


//end of get_variable_of_form_form_edit_student_in_modul_people_page_edit_student
}
function check_validation_form_form_edit_student_in_modul_people_page_edit_student(){
var valid_status=true;
var valid_msg="";

var field_tocheck_field_namemodul_people_page_edit_student = document.getElementById("field_namemodul_people_page_edit_student");
if (field_tocheck_field_namemodul_people_page_edit_student.value.length < 1) {
  valid_status=false;
  valid_msg+="Isi name,";
}

var field_tocheck_field_addressmodul_people_page_edit_student = document.getElementById("field_addressmodul_people_page_edit_student");
if (field_tocheck_field_addressmodul_people_page_edit_student.value.length < 1) {
  valid_status=false;
  valid_msg+="Isi address,";
}



if(valid_status==false){
  alert(valid_msg);
}

return valid_status;

//end of check_validation_form_form_edit_student_in_modul_people_page_edit_student
}
function submit_form_form_edit_student_in_modul_people_page_edit_student(){
     
}
var el_of_form_edit_student_in_modul_people_page_edit_student = document.getElementById("form_edit_student_in_modul_people_page_edit_student");

// Execute a function when the user releases a key on the keyboard
el_of_form_edit_student_in_modul_people_page_edit_student.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    //document.getElementById("myBtn").click();
    var return_of_get_variable_of_form_form_edit_student_in_modul_people_page_edit_student = get_variable_of_form_form_edit_student_in_modul_people_page_edit_student();

var return_of_check_validation_form_form_edit_student_in_modul_people_page_edit_student = check_validation_form_form_edit_student_in_modul_people_page_edit_student();
if (return_of_check_validation_form_form_edit_student_in_modul_people_page_edit_student == true){
var return_of_upload_data_student_in_modul_people_page_edit_student = upload_data_student_in_modul_people_page_edit_student();

}


  }
});
var hasil_upload_data_studentmodul_people_page_edit_student;
function upload_data_student_in_modul_people_page_edit_student(){
ajaxjson_upload_data_student_in_modul_people_page_edit_student = buatajax();
var url="http://localhost/student_management_system_v1/API";
ajaxjson_upload_data_student_in_modul_people_page_edit_student.onreadystatechange = stateChangedjson_upload_data_student_in_modul_people_page_edit_student;
ajaxjson_upload_data_student_in_modul_people_page_edit_student.open("POST",url,true);
ajaxjson_upload_data_student_in_modul_people_page_edit_student.setRequestHeader("Content-Type", "application/json");
var data = JSON.stringify({"modul":"update_data","action":"update_datastudent_in_modul_people_page_edit_student","name":isian_field_namemodul_people_page_edit_student,"address":isian_field_addressmodul_people_page_edit_student,"photo":isian_field_photomodul_people_page_edit_student_file_content,"studentpeopleedit_student_id":catch_student_in_modul_people_page_edit_student_id});
console.log("Data sent from upload_data_student_in_modul_people_page_edit_student : "+data);
ajaxjson_upload_data_student_in_modul_people_page_edit_student.send(data);


}
var ajaxjson_upload_data_student_in_modul_people_page_edit_student;
function stateChangedjson_upload_data_student_in_modul_people_page_edit_student(){
  var this_html_response;
   if (ajaxjson_upload_data_student_in_modul_people_page_edit_student.readyState==4){
     this_html_response=ajaxjson_upload_data_student_in_modul_people_page_edit_student.responseText;
     console.log("response from upload_data_student_in_modul_people_page_edit_student : "+ajaxjson_upload_data_student_in_modul_people_page_edit_student.responseText);
     if(this_html_response.length>0){



     var hasilekstrakstudent_in_modul_people_page_edit_student = ekstrakHasilUploadstudent_in_modul_people_page_edit_student(this_html_response,"error_code");
if (hasilekstrakstudent_in_modul_people_page_edit_student == 000){
jumpketabelstudent_in_modul_people_page_edit_student("people","list_student");

}



          setListeners();
      }
    }
}

var hasilekstrakstudent_in_modul_people_page_edit_student;
function ekstrakHasilUploadstudent_in_modul_people_page_edit_student(dataekstrakHasilUploadstudent_in_modul_people_page_edit_student,targetekstrakHasilUploadstudent_in_modul_people_page_edit_student){
var objekstrakHasilUploadstudent_in_modul_people_page_edit_student=JSON.parse(dataekstrakHasilUploadstudent_in_modul_people_page_edit_student);
var content_of_ekstrakHasilUploadstudent_in_modul_people_page_edit_student=objekstrakHasilUploadstudent_in_modul_people_page_edit_student[targetekstrakHasilUploadstudent_in_modul_people_page_edit_student];
hasilekstrakstudent_in_modul_people_page_edit_student = content_of_ekstrakHasilUploadstudent_in_modul_people_page_edit_student;

return content_of_ekstrakHasilUploadstudent_in_modul_people_page_edit_student;

}
function jumpketabelstudent_in_modul_people_page_edit_student(moduljumpketabelstudent_in_modul_people_page_edit_student,pagejumpketabelstudent_in_modul_people_page_edit_student){
window.location.href = 'http://localhost/student_management_system_v1/admin/'+moduljumpketabelstudent_in_modul_people_page_edit_student+'/'+pagejumpketabelstudent_in_modul_people_page_edit_student;


}


   <?php
   if($modal=="tidak"){
    ?>
    setListeners();
    function setListeners(){
      $("<?php if(isset($prepage)){print($prepage);} ?>.fancybox").fancybox({
		prevEffect	: 'none',
		nextEffect	: 'none',
		helpers	: {
			title	: {
				type: 'outside'
			},
			thumbs	: {
				width	: 50,
				height	: 50
			}
		}
	});

      $('.table_link').click(function(event) {
        //alert("AAA");
        event.preventDefault();
        this.blur(); // Manually remove focus from clicked link.
        $.get(this.href+"?modal=iya", function(htmla) {
          //$("<div class='modal'><p>"+htmla+"</p></div>").appendTo('body').modal();
          $( "#bahanmodal" ).html( htmla );
          $( "#modal-default" ).modal({
    });
        });
      });
    }
<?php } ?>

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
@endsection
