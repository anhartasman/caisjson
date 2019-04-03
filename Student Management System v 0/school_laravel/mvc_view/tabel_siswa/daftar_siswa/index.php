<?php
$page_name="Daftar Siswa | Sistem Sekolahan";
$modul_id="tabel_siswa";
$modul_id_page_id="tabel_siswa_daftar_siswa";
$copy_base_language_library_web_css=array();

include ("../inc_body_header.php");
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Daftar Siswa
        <small>Daftar Siswa</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tabel Siswa</a></li>
        <li class="active">Daftar Siswa</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      

  <div class="row">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Daftar Siswa <th><a href="http://localhost/hargakamar/admin/tabel_siswa/add_siswa">Tambah</a></th>
</h3>
            </div>
            <form role="form" name="form_cari_tabel" id="form_cari_tabel" method="post"  >
<div class="box-header">

Tingkat <select class="" id="tingkat_kelas"  name="tingkat_kelas"  >
    <?php print("<option value='"."-1"."' >"."- select -"."</option>");
?>
<?php 


?>
  </select>

Kelas <select class="" id="pilih_kelas"  name="pilih_kelas"  >
    <?php print("<option value='"."-1"."' >"."- select -"."</option>");
?>
<?php 


?>
  </select>

Status <select class="" id="pilih_status"  name="pilih_status"  >
    <?php print("<option value='"."-1"."' >"."- select -"."</option>");
?>
<?php foreach($status_siswa as $keystatus_siswa=>$valuestatus_siswa) {
print("<option value='".$keystatus_siswa."' >".$valuestatus_siswa."</option>");

}
?>
  </select>
</div>
</form>
 
            <!-- /.box-header -->
            <div class="box-body">
              <table id="tabel_siswa" class="table table-bordered table-striped">
                <thead>
                <tr>
                <th>ID</th>
<th>Nama</th>
<th>Email</th>
<th>Pelajaran Favorit</th>
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
<td></th>

                </tr>
                </tbody>
                <tfoot>
                <tr>
                  <th>ID</th>
<th>Nama</th>
<th>Email</th>
<th>Pelajaran Favorit</th>
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


<!-- DataTables -->
<script src="<?=$base_url?>/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=$base_url?>/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
 


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
   var page_id="daftar_siswa";
var modul_id="tabel_siswa";

var pilihan_tingkat = 0;
var pilihan_tingkat_textvalue = null;

var pilihan_kelas = 0;
var pilihan_kelas_textvalue = null;

var pilihan_status = 0;
var pilihan_status_textvalue = null;

$('#tabel_siswa').DataTable({
  'paging'      : true,
  'lengthChange': true,
  'searching'   : true,
  'ordering'    : true,
  'info'        : true,
  'autoWidth'   : false
});

function set_idx_select_tingkat_kelas(nomidx){


}
$("#tingkat_kelas").on( 'change', function () {
pilihan_tingkat_textvalue = $("#tingkat_kelas option:selected").text();
pilihan_tingkat = $("#tingkat_kelas").val();
set_idx_select_pilih_kelas();

get_pilihan_kelas();


});
get_tingkat_kelas();


function set_idx_select_pilih_kelas(nomidx){


}
$("#pilih_kelas").on( 'change', function () {
pilihan_kelas_textvalue = $("#pilih_kelas option:selected").text();
pilihan_kelas = $("#pilih_kelas").val();
set_tabel_siswa();


});

function set_idx_select_pilih_status(nomidx){


}
function get_variable_of_form_form_cari_tabel(){ 

pilihan_tingkat_textvalue = $("#tingkat_kelasoption:selected").text();
pilihan_tingkat = $("#tingkat_kelas").val();
pilihan_kelas_textvalue = $("#pilih_kelasoption:selected").text();
pilihan_kelas = $("#pilih_kelas").val();
pilihan_status_textvalue = $("#pilih_statusoption:selected").text();
pilihan_status = $("#pilih_status").val();


//end of get_variable_of_form_form_cari_tabel
}
function check_validation_form_form_cari_tabel(){
var valid_status=true;
var valid_msg="";



if(valid_status==false){
  alert(valid_msg);
}

return valid_status;

//end of check_validation_form_form_cari_tabel
}
function submit_form_form_cari_tabel(){
     
}
function get_pilihan_kelas(){
ajaxjson_get_pilihan_kelas = buatajax();
var url="http://localhost/hargakamar/API/";
ajaxjson_get_pilihan_kelas.onreadystatechange = stateChangedjson_get_pilihan_kelas;
ajaxjson_get_pilihan_kelas.open("POST",url,true);
ajaxjson_get_pilihan_kelas.setRequestHeader("Content-Type", "application/json");
var data = JSON.stringify({"modul":"report","action":"get_kelas","tingkat_id":pilihan_tingkat});
console.log("Data sent from get_pilihan_kelas : "+data);
ajaxjson_get_pilihan_kelas.send(data);


}
var ajaxjson_get_pilihan_kelas;
function stateChangedjson_get_pilihan_kelas(){
  var this_html_response;
   if (ajaxjson_get_pilihan_kelas.readyState==4){
     this_html_response=ajaxjson_get_pilihan_kelas.responseText;
     console.log("response from get_pilihan_kelas : "+ajaxjson_get_pilihan_kelas.responseText);
     if(this_html_response.length>0){
     var hasilExtractJSONKelas = extractJSONKelas(this_html_response,"response_data");

set_dropdown_pilihan_kelas(hasilExtractJSONKelas);


      }
    }
}

var hasilExtractJSONKelas;
function extractJSONKelas(dataextractJSONKelas,targetextractJSONKelas){
hasilExtractJSONKelas = content_of_extractJSONKelas;

return content_of_extractJSONKelas;

}
function set_dropdown_pilihan_kelas(data_contentset_dropdown_pilihan_kelas){


}
function get_tingkat_kelas(){
ajaxjson_get_tingkat_kelas = buatajax();
var url="http://localhost/hargakamar/API/";
ajaxjson_get_tingkat_kelas.onreadystatechange = stateChangedjson_get_tingkat_kelas;
ajaxjson_get_tingkat_kelas.open("POST",url,true);
ajaxjson_get_tingkat_kelas.setRequestHeader("Content-Type", "application/json");
var data = JSON.stringify({"modul":"report","action":"get_tingkat"});
console.log("Data sent from get_tingkat_kelas : "+data);
ajaxjson_get_tingkat_kelas.send(data);


}
var ajaxjson_get_tingkat_kelas;
function stateChangedjson_get_tingkat_kelas(){
  var this_html_response;
   if (ajaxjson_get_tingkat_kelas.readyState==4){
     this_html_response=ajaxjson_get_tingkat_kelas.responseText;
     console.log("response from get_tingkat_kelas : "+ajaxjson_get_tingkat_kelas.responseText);
     if(this_html_response.length>0){
     var hasilExtractJSONTingkat = extractJSONTingkat(this_html_response,"response_data");

set_dropdown_tingkat(hasilExtractJSONTingkat);


      }
    }
}

var hasilExtractJSONTingkat;
function extractJSONTingkat(dataextractJSONTingkat,targetextractJSONTingkat){
hasilExtractJSONTingkat = content_of_extractJSONTingkat;

return content_of_extractJSONTingkat;

}
function set_dropdown_tingkat(data_contentset_dropdown_tingkat){


}
function set_tabel_siswa(){
ajaxjson_set_tabel_siswa = buatajax();
var url="http://localhost/hargakamar/API/";
ajaxjson_set_tabel_siswa.onreadystatechange = stateChangedjson_set_tabel_siswa;
ajaxjson_set_tabel_siswa.open("POST",url,true);
ajaxjson_set_tabel_siswa.setRequestHeader("Content-Type", "application/json");
var data = JSON.stringify({"modul":"report","action":"get_students","tingkat_id":pilihan_tingkat,"kelas_id":pilihan_kelas});
console.log("Data sent from set_tabel_siswa : "+data);
ajaxjson_set_tabel_siswa.send(data);


}
var ajaxjson_set_tabel_siswa;
function stateChangedjson_set_tabel_siswa(){
  var this_html_response;
   if (ajaxjson_set_tabel_siswa.readyState==4){
     this_html_response=ajaxjson_set_tabel_siswa.responseText;
     console.log("response from set_tabel_siswa : "+ajaxjson_set_tabel_siswa.responseText);
     if(this_html_response.length>0){
     var hasilExtractJSON = extractJSONIsiTable(this_html_response,"response_data");

set_isi_tabel_siswa(hasilExtractJSON);


      }
    }
}

var hasilExtractJSON;
function extractJSONIsiTable(dataextractJSONIsiTable,targetextractJSONIsiTable){
hasilExtractJSON = content_of_extractJSONIsiTable;

return content_of_extractJSONIsiTable;

}
function set_isi_tabel_siswa(data_content){


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
