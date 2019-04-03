@extends('layouts.layout_admin')
@section('content_header_admin')
<?php
if(isset($variables)){
  extract($variables);
}
$page_name="edit class | Student Management System";
$modul_id="administrative";
$modul_id_page_id="administrative_edit_class";
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
        edit class
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">administrative</a></li>
        <li class="active">edit class</li>
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
              <h3 class="box-title">Form class </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
                   <form role="form" name="form_edit_class_in_modul_administrative_page_edit_class" id="form_edit_class_in_modul_administrative_page_edit_class" method="POST"  >
<div class="box-body">

<div class="form-group">
  <label>name</label>
  <input type="text" class="form-control form-control" id="field_namemodul_administrative_page_edit_class"  name="field_namemodul_administrative_page_edit_class" placeholder="Isi name"  value="<?php if(isset($data_diri_tb_class)){ print($data_diri_tb_class['name']); } ?>" >
</div>

<div class="form-group">
  <label>description</label>
  <input type="text" class="form-control form-control" id="field_descriptionmodul_administrative_page_edit_class"  name="field_descriptionmodul_administrative_page_edit_class" placeholder="Isi description"  value="<?php if(isset($data_diri_tb_class)){ print($data_diri_tb_class['description']); } ?>" >
</div>

<div class="box-footer">
  <button type="button" id="submit_button_editclass_in_modul_administrative_page_edit_class" name="submit_button_editclass_in_modul_administrative_page_edit_class" class="btn btn-primary">Update</button>
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
   var page_id="edit_class";
var modul_id="administrative";
<?php $class_in_modul_administrative_page_edit_class_id = str_replace("?modal=iya","",$class_in_modul_administrative_page_edit_class_id); ?>
<?php $class_in_modul_administrative_page_edit_class_id = str_replace("&modal=iya","",$class_in_modul_administrative_page_edit_class_id); ?>
var catch_class_in_modul_administrative_page_edit_class_id=<?php print($class_in_modul_administrative_page_edit_class_id); ?>;

var isian_field_namemodul_administrative_page_edit_class = null;

var isian_field_descriptionmodul_administrative_page_edit_class = null;

var isian_submit_button_editclass_in_modul_administrative_page_edit_class = null;



$("<?php if(isset($prepage)){print($prepage);} ?>#submit_button_editclass_in_modul_administrative_page_edit_class").on( 'click', function () {
var return_of_get_variable_of_form_form_edit_class_in_modul_administrative_page_edit_class = get_variable_of_form_form_edit_class_in_modul_administrative_page_edit_class();

var return_of_check_validation_form_form_edit_class_in_modul_administrative_page_edit_class = check_validation_form_form_edit_class_in_modul_administrative_page_edit_class();
if (return_of_check_validation_form_form_edit_class_in_modul_administrative_page_edit_class == true){
var hasil_upload_data_classmodul_administrative_page_edit_class = upload_data_class_in_modul_administrative_page_edit_class();

}


});
function get_variable_of_form_form_edit_class_in_modul_administrative_page_edit_class(){ 

isian_field_namemodul_administrative_page_edit_class = document.getElementById("field_namemodul_administrative_page_edit_class").value;
isian_field_descriptionmodul_administrative_page_edit_class = document.getElementById("field_descriptionmodul_administrative_page_edit_class").value;


//end of get_variable_of_form_form_edit_class_in_modul_administrative_page_edit_class
}
function check_validation_form_form_edit_class_in_modul_administrative_page_edit_class(){
var valid_status=true;
var valid_msg="";

var field_tocheck_field_namemodul_administrative_page_edit_class = document.getElementById("field_namemodul_administrative_page_edit_class");
if (field_tocheck_field_namemodul_administrative_page_edit_class.value.length < 1) {
  valid_status=false;
  valid_msg+="Isi name,";
}

var field_tocheck_field_descriptionmodul_administrative_page_edit_class = document.getElementById("field_descriptionmodul_administrative_page_edit_class");
if (field_tocheck_field_descriptionmodul_administrative_page_edit_class.value.length < 1) {
  valid_status=false;
  valid_msg+="Isi description,";
}



if(valid_status==false){
  alert(valid_msg);
}

return valid_status;

//end of check_validation_form_form_edit_class_in_modul_administrative_page_edit_class
}
function submit_form_form_edit_class_in_modul_administrative_page_edit_class(){
     
}
var el_of_form_edit_class_in_modul_administrative_page_edit_class = document.getElementById("form_edit_class_in_modul_administrative_page_edit_class");

// Execute a function when the user releases a key on the keyboard
el_of_form_edit_class_in_modul_administrative_page_edit_class.addEventListener("keyup", function(event) {
  // Number 13 is the "Enter" key on the keyboard
  if (event.keyCode === 13) {
    // Cancel the default action, if needed
    event.preventDefault();
    // Trigger the button element with a click
    //document.getElementById("myBtn").click();
    var return_of_get_variable_of_form_form_edit_class_in_modul_administrative_page_edit_class = get_variable_of_form_form_edit_class_in_modul_administrative_page_edit_class();

var return_of_check_validation_form_form_edit_class_in_modul_administrative_page_edit_class = check_validation_form_form_edit_class_in_modul_administrative_page_edit_class();
if (return_of_check_validation_form_form_edit_class_in_modul_administrative_page_edit_class == true){
var return_of_upload_data_class_in_modul_administrative_page_edit_class = upload_data_class_in_modul_administrative_page_edit_class();

}


  }
});
var hasil_upload_data_classmodul_administrative_page_edit_class;
function upload_data_class_in_modul_administrative_page_edit_class(){
ajaxjson_upload_data_class_in_modul_administrative_page_edit_class = buatajax();
var url="http://localhost/student_management_system_v1/API";
ajaxjson_upload_data_class_in_modul_administrative_page_edit_class.onreadystatechange = stateChangedjson_upload_data_class_in_modul_administrative_page_edit_class;
ajaxjson_upload_data_class_in_modul_administrative_page_edit_class.open("POST",url,true);
ajaxjson_upload_data_class_in_modul_administrative_page_edit_class.setRequestHeader("Content-Type", "application/json");
var data = JSON.stringify({"modul":"update_data","action":"update_dataclass_in_modul_administrative_page_edit_class","name":isian_field_namemodul_administrative_page_edit_class,"description":isian_field_descriptionmodul_administrative_page_edit_class,"classadministrativeedit_class_id":catch_class_in_modul_administrative_page_edit_class_id});
console.log("Data sent from upload_data_class_in_modul_administrative_page_edit_class : "+data);
ajaxjson_upload_data_class_in_modul_administrative_page_edit_class.send(data);


}
var ajaxjson_upload_data_class_in_modul_administrative_page_edit_class;
function stateChangedjson_upload_data_class_in_modul_administrative_page_edit_class(){
  var this_html_response;
   if (ajaxjson_upload_data_class_in_modul_administrative_page_edit_class.readyState==4){
     this_html_response=ajaxjson_upload_data_class_in_modul_administrative_page_edit_class.responseText;
     console.log("response from upload_data_class_in_modul_administrative_page_edit_class : "+ajaxjson_upload_data_class_in_modul_administrative_page_edit_class.responseText);
     if(this_html_response.length>0){



     var hasilekstrakclass_in_modul_administrative_page_edit_class = ekstrakHasilUploadclass_in_modul_administrative_page_edit_class(this_html_response,"error_code");
if (hasilekstrakclass_in_modul_administrative_page_edit_class == 000){
jumpketabelclass_in_modul_administrative_page_edit_class("administrative","list_class");

}



          setListeners();
      }
    }
}

var hasilekstrakclass_in_modul_administrative_page_edit_class;
function ekstrakHasilUploadclass_in_modul_administrative_page_edit_class(dataekstrakHasilUploadclass_in_modul_administrative_page_edit_class,targetekstrakHasilUploadclass_in_modul_administrative_page_edit_class){
var objekstrakHasilUploadclass_in_modul_administrative_page_edit_class=JSON.parse(dataekstrakHasilUploadclass_in_modul_administrative_page_edit_class);
var content_of_ekstrakHasilUploadclass_in_modul_administrative_page_edit_class=objekstrakHasilUploadclass_in_modul_administrative_page_edit_class[targetekstrakHasilUploadclass_in_modul_administrative_page_edit_class];
hasilekstrakclass_in_modul_administrative_page_edit_class = content_of_ekstrakHasilUploadclass_in_modul_administrative_page_edit_class;

return content_of_ekstrakHasilUploadclass_in_modul_administrative_page_edit_class;

}
function jumpketabelclass_in_modul_administrative_page_edit_class(moduljumpketabelclass_in_modul_administrative_page_edit_class,pagejumpketabelclass_in_modul_administrative_page_edit_class){
window.location.href = 'http://localhost/student_management_system_v1/admin/'+moduljumpketabelclass_in_modul_administrative_page_edit_class+'/'+pagejumpketabelclass_in_modul_administrative_page_edit_class;


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
