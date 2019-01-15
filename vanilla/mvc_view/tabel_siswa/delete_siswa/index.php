<?php
$page_name="Hapus Data Siswa SMP | Sistem Sekolahan";
$modul_id="tabel_siswa";
$modul_id_page_id="tabel_siswa_delete_siswa";
$copy_base_language_library_web_css=array();
$copy_base_language_library_web_css[]=array("name"=>"select2","path"=>"bower_components\/select2\/dist\/css\/select2.min.css");

include ("../inc_body_header.php");
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Hapus Data Siswa SMP
        <small>Form Hapus Data Siswa</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tabel Siswa</a></li>
        <li class="active">Hapus Data Siswa SMP</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      

 <div class="row">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Form Hapus Data Siswa </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
                   <form role="form" name="form_siswa" id="form_siswa" method="POST"  >
<div class="box-body">

<div class="form-group">
  <label>Tingkat</label>
  <?php if(isset($daftar_tingkat)){ print($daftar_tingkat[$data_diri_siswa['tingkat_id']]); } ?>
</div>

<div class="form-group">
  <label>Kelas</label>
  <?php if(isset($daftar_kelas)){ print($daftar_kelas[$data_diri_siswa['kelas_id']]); } ?>
</div>

<div class="form-group">
  <label>Nama</label>
  <?php if(isset($data_diri_siswa)){ print($data_diri_siswa['nama']); } ?>
</div>

<div class="form-group">
  <label>Email</label>
  <?php if(isset($data_diri_siswa)){ print($data_diri_siswa['email']); } ?>
</div>

<label>Pelajaran Favorit</label>
<select class="form-control select2" id="pelajaranfavorit"  name="pelajaranfavorit[]" data-placeholder="Select pelajaranfavorit" disabled="disabled"
        style="width: 100%;">
  <?php print("<option value='"."-1"."' >"."- select -"."</option>");
?>
<?php foreach($daftar_pelajaran as $keydaftar_pelajaran=>$valuedaftar_pelajaran) {
$dapatcari=0;
foreach($hasilbridge as $keyhasilbridge=>$valuehasilbridge) {
if ($keydaftar_pelajaran == $keyhasilbridge){
$dapatcari=1;
break;
}
}
if ($dapatcari == 1){
print("<option value='".$keydaftar_pelajaran."' selected>".$valuedaftar_pelajaran."</option>");
}else{
print("<option value='".$keydaftar_pelajaran."' >".$valuedaftar_pelajaran."</option>");
}

}
?>
</select>

<div class="form-group">
  <label>Handphone</label>
  <?php if(isset($data_diri_siswa)){ print($data_diri_siswa['handphone']); } ?>
</div>

<div class="form-group">
  <label>Alamat</label>
  <textarea type="text" class="form-control form-control" id="alamat"  name="alamat" disabled="disabled" ><?php if(isset($data_diri_siswa)){ print($data_diri_siswa['alamat']); } ?></textarea>
</div>

<div class="form-group">
  <label>Sertifikat</label>

        <textarea id="sertifikat"  name="sertifikat" disabled="disabled" rows="10" cols="80"><?php if(isset($data_diri_siswa)){ print($data_diri_siswa['sertifikat']); } ?></textarea>
</div>

<div class="form-group">
  <label>Foto Profil</label>
  <img id="img_of_fotoprofil" src="http://localhost/school_vanilla/uploads/<?php print($data_diri_siswa['fotoprofil']);?>" alt="no image" />  
</div>

<div class="box-footer">
  <button type="button" id="buttonSubmitForm" name="buttonSubmitForm" class="btn btn-primary">Hapus Data</button>
</div>
</div>
</form>

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

<!-- Select2 -->
<script src="<?=$base_url?>/bower_components/select2/dist/js/select2.full.min.js"></script>


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
   var page_id="delete_siswa";
var modul_id="tabel_siswa";
var catch_siswa_id=<?php print($siswa_id); ?>;

var pilihan_tingkat_siswa = null;

var pilihan_kelas_siswa = null;

var isian_nama = null;

var isian_email = null;

var isian_pelajaranfavorit = 0;
var isian_pelajaranfavorit_textvalue = null;

var isian_handphone = null;

var isian_alamat = null;

var isian_sertifikat = null;

var isian_fotoprofil = null;

var isian_buttonSubmitForm = null;





$('.select2').select2();

function set_idx_select_pelajaranfavorit(nomidx){


}




CKEDITOR.replace('sertifikat')
//$('#sertifikat').wysihtml5();



$("#buttonSubmitForm").on( 'click', function () {
delete_data_siswa();


});
function get_variable_of_form_form_siswa(){ 

isian_pelajaranfavorit = $("#pelajaranfavorit").val();
isian_alamat = document.getElementById("alamat").value;
isian_sertifikat = CKEDITOR.instances.sertifikat.getData();


//end of get_variable_of_form_form_siswa
}
function check_validation_form_form_siswa(){
var valid_status=true;
var valid_msg="";



if(valid_status==false){
  alert(valid_msg);
}

return valid_status;

//end of check_validation_form_form_siswa
}
function submit_form_form_siswa(){
     
}
function delete_data_siswa(){
ajaxjson_delete_data_siswa = buatajax();
var url="http://localhost/school_vanilla/API/";
ajaxjson_delete_data_siswa.onreadystatechange = stateChangedjson_delete_data_siswa;
ajaxjson_delete_data_siswa.open("POST",url,true);
ajaxjson_delete_data_siswa.setRequestHeader("Content-Type", "application/json");
var data = JSON.stringify({"modul":"report","action":"delete_data_siswa","siswa_id":catch_siswa_id});
console.log("Data sent from delete_data_siswa : "+data);
ajaxjson_delete_data_siswa.send(data);


}
var ajaxjson_delete_data_siswa;
function stateChangedjson_delete_data_siswa(){
  var this_html_response;
   if (ajaxjson_delete_data_siswa.readyState==4){
     this_html_response=ajaxjson_delete_data_siswa.responseText;
     console.log("response from delete_data_siswa : "+ajaxjson_delete_data_siswa.responseText);
     if(this_html_response.length>0){
     var hasilEkstrakDelete = ekstrakHasilDelete(this_html_response,"response_data");
if (hasilEkstrakDelete == 1){
pindahHalaman("tabel_siswa","daftar_siswa");

}


      }
    }
}

var hasilEkstrakDelete;
function ekstrakHasilDelete(dataekstrakHasilDelete,targetekstrakHasilDelete){
var objekstrakHasilDelete=JSON.parse(dataekstrakHasilDelete);
var content_of_ekstrakHasilDelete=objekstrakHasilDelete[targetekstrakHasilDelete];
hasilEkstrakDelete = content_of_ekstrakHasilDelete;

return content_of_ekstrakHasilDelete;

}
function pindahHalaman(modulpindahHalaman,pagepindahHalaman){
window.location.href = 'http://localhost/school_vanilla/admin/'+modulpindahHalaman+'/'+pagepindahHalaman;


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
