@extends('layouts.layout_admin')
@section('content_header_admin')
<?php
if(isset($variables)){
  extract($variables);
}
$page_name="list student | Student Management System";
$modul_id="people";
$modul_id_page_id="people_list_student";
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
        list student
        <small></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">people</a></li>
        <li class="active">list student</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php
        }
         ?>
      

  <div class="row">
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">tabel of student <th><a href="http://localhost/student_management_system_v1/admin/people/add_student">Tambah</a></th>
</h3>
            </div>
            
            <!-- /.box-header -->
            <div class="box-body">
              <table id="table_student_in_modul_people_page_list_student" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>name</th>
<th>photo</th>
<th>address</th>
<th></th>
<th></th>

                </tr>
                </thead>
                <tbody>
                <tr>
                  <td></th>
<td></th>
<td></th>
<td></th>
<td></th>

                </tr>
                </tbody>
                <tfoot>
                <tr>
                  <th>name</th>
<th>photo</th>
<th>address</th>
<th></th>
<th></th>

                </tr>
                </tfoot>
              </table>
            </div>
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


<!-- DataTables -->
<script src="{{ asset('public/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>


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
   var page_id="list_student";
var modul_id="people";

$('<?php if(isset($prepage)){print($prepage);} ?>#table_student_in_modul_people_page_list_student').DataTable({
  'paging'      : true,
  'lengthChange': true,
  'searching'   : true,
  'ordering'    : true,
  'info'        : true,
  'autoWidth'   : false
  ,'drawCallback': function( settings ) {
    setListeners();
    }
});
retrieve_data_student_in_modul_people_page_list_student();
function retrieve_data_student_in_modul_people_page_list_student(){
ajaxjson_retrieve_data_student_in_modul_people_page_list_student = buatajax();
var url="http://localhost/student_management_system_v1/API";
ajaxjson_retrieve_data_student_in_modul_people_page_list_student.onreadystatechange = stateChangedjson_retrieve_data_student_in_modul_people_page_list_student;
ajaxjson_retrieve_data_student_in_modul_people_page_list_student.open("POST",url,true);
ajaxjson_retrieve_data_student_in_modul_people_page_list_student.setRequestHeader("Content-Type", "application/json");
var data = JSON.stringify({"modul":"retrieve_data","action":"retrieve_datastudent_in_modul_people_page_list_student"});
console.log("Data sent from retrieve_data_student_in_modul_people_page_list_student : "+data);
ajaxjson_retrieve_data_student_in_modul_people_page_list_student.send(data);


}
var ajaxjson_retrieve_data_student_in_modul_people_page_list_student;
function stateChangedjson_retrieve_data_student_in_modul_people_page_list_student(){
  var this_html_response;
   if (ajaxjson_retrieve_data_student_in_modul_people_page_list_student.readyState==4){
     this_html_response=ajaxjson_retrieve_data_student_in_modul_people_page_list_student.responseText;
     console.log("response from retrieve_data_student_in_modul_people_page_list_student : "+ajaxjson_retrieve_data_student_in_modul_people_page_list_student.responseText);
     if(this_html_response.length>0){



     var hasilekstrakstudent_in_modul_people_page_list_student = ekstrakHasilUploadstudent_in_modul_people_page_list_student(this_html_response,"response_data");

setTabelstudent_in_modul_people_page_list_student(hasilekstrakstudent_in_modul_people_page_list_student);



          setListeners();
      }
    }
}

var hasilekstrakstudent_in_modul_people_page_list_student;
function ekstrakHasilUploadstudent_in_modul_people_page_list_student(dataekstrakHasilUploadstudent_in_modul_people_page_list_student,targetekstrakHasilUploadstudent_in_modul_people_page_list_student){
var objekstrakHasilUploadstudent_in_modul_people_page_list_student=JSON.parse(dataekstrakHasilUploadstudent_in_modul_people_page_list_student);
var content_of_ekstrakHasilUploadstudent_in_modul_people_page_list_student=objekstrakHasilUploadstudent_in_modul_people_page_list_student[targetekstrakHasilUploadstudent_in_modul_people_page_list_student];
hasilekstrakstudent_in_modul_people_page_list_student = content_of_ekstrakHasilUploadstudent_in_modul_people_page_list_student;

return content_of_ekstrakHasilUploadstudent_in_modul_people_page_list_student;

}
function setTabelstudent_in_modul_people_page_list_student(data_content){
$('<?php if(isset($prepage)){print($prepage);} ?>#table_student_in_modul_people_page_list_student').dataTable().fnClearTable();
if(data_content.length>0){
$('<?php if(isset($prepage)){print($prepage);} ?>#table_student_in_modul_people_page_list_student').dataTable().fnAddData(data_content);
}


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
