<?php
$page_name="Documentation | System Information";
$modul_id="";
$modul_id_page_id="";

include ("../inc_body_header.php");
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Documentation
        <small>Documentation</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#"></a></li>
        <li class="active">Documentation</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      
<div class="row">
  <div class="col-xs-12">
    <h2 class="page-header">
      <i class="fa fa-globe"></i> Pages.
      <small class="pull-right">Date: 2/10/2014</small>
    </h2>
  </div>
  <!-- /.col -->
</div>

<!-- Table row -->
<div class="row">
  <div class="col-xs-12 table-responsive">
    <table class="table table-striped">
      <thead>
      <tr>
        <th>Idx</th>
        <th>Modul</th>
        <th>Page</th>
        <th>Placement</th>
      </tr>
      </thead>
      <tbody>
        <!--
      <tr>
        <td>1</td>
        <td>Call of Duty</td>
        <td>455-981-221</td>
        <td>El snort testosterone trophy driving gloves handsome</td>
        <td>$64.50</td>
      </tr>
       -->
      <tr><td>1</td><td>tabel_siswa</td><td>add_siswa</td><td></td></tr><tr><td>2</td><td>tabel_siswa</td><td>edit_siswa</td><td></td></tr><tr><td>3</td><td>tabel_siswa</td><td>delete_siswa</td><td></td></tr><tr><td>4</td><td>tabel_siswa</td><td>daftar_siswa</td><td>sidemenu,</td></tr>
      </tbody>
    </table>
  </div>
  <!-- /.col -->
</div>

<div class="row">
  <div class="col-xs-12">
    <h2 class="page-header">
      <i class="fa fa-globe"></i> APIs.
      <small class="pull-right">Date: 2/10/2014</small>
    </h2>
  </div>
  <!-- /.col -->
</div>
<!-- Table row -->
<div class="row">
  <div class="col-xs-12 table-responsive">
    <table class="table table-striped">
      <thead>
      <tr>
        <th>Idx</th>
        <th>Modul</th>
        <th>Action</th>
        <th>Parameters</th>
        <th>URL</th>
      </tr>
      </thead>
      <tbody>
        <!--
      <tr>
        <td>1</td>
        <td>Call of Duty</td>
        <td>455-981-221</td>
        <td>El snort testosterone trophy driving gloves handsome</td>
        <td>$64.50</td>
      </tr>
       -->
      <tr><td>1</td><td>account</td><td>login</td><td>email(1),password(1),</td><td>http://localhost/school_vanilla/API</td></tr><tr><td>2</td><td>report</td><td>get_students</td><td>kelas_id(1),tingkat_id(1),</td><td>http://localhost/school_vanilla/API</td></tr><tr><td>3</td><td>report</td><td>get_tingkat</td><td></td><td>http://localhost/school_vanilla/API</td></tr><tr><td>4</td><td>report</td><td>get_kelas</td><td>tingkat_id(1),</td><td>http://localhost/school_vanilla/API</td></tr><tr><td>5</td><td>report</td><td>insert_data_siswa</td><td>kelas_id(1),tingkat_id(1),nama(1),email(1),alamat(1),sertifikat(1),handphone(1),fotoprofil(1),pelajaran_favorit(0),</td><td>http://localhost/school_vanilla/API</td></tr><tr><td>6</td><td>report</td><td>update_data_siswa</td><td>siswa_id(1),kelas_id(1),tingkat_id(1),nama(1),email(1),alamat(1),sertifikat(1),handphone(1),pelajaran_favorit(1),fotoprofil(0),</td><td>http://localhost/school_vanilla/API</td></tr><tr><td>7</td><td>report</td><td>delete_data_siswa</td><td>siswa_id(1),</td><td>http://localhost/school_vanilla/API</td></tr>
      </tbody>
    </table>
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
<?php
include ("../inc_body_footer.php");
?>

<!-- jQuery 3 -->
<script src="<?=$base_url?>/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?=$base_url?>/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=$base_url?>/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?=$base_url?>/bower_components/raphael/raphael.min.js"></script>
<script src="<?=$base_url?>/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?=$base_url?>/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?=$base_url?>/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?=$base_url?>/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?=$base_url?>/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?=$base_url?>/bower_components/moment/min/moment.min.js"></script>
<script src="<?=$base_url?>/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?=$base_url?>/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- CK Editor -->
<script src="<?=$base_url?>/bower_components/ckeditor/ckeditor.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="<?=$base_url?>/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- FastClick -->
<script src="<?=$base_url?>/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE for demo purposes
<script src="<?=$base_url?>/dist/js/demo.js"></script>
-->
<!-- AdminLTE App -->
<script src="<?=$base_url?>/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes)
<script src="<?=$base_url?>/dist/js/pages/dashboard.js"></script>
 -->


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
