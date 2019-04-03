@extends('layouts.layout_admin')
@section('content_header_admin')
<?php
if(isset($variables)){
  extract($variables);
}
$page_name="{page_name}";
$modul_id="{modul_id}";
$modul_id_page_id="{modul_id_page_id}";
{copy_base_language_library_web_css}
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
        {page_title}
        <small>{page_subtitle}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">{modul_title}</a></li>
        <li class="active">{page_title}</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php
        }
         ?>
      {page_content}
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
{copy_js}

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
   {footer_js}

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
