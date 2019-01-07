<?php
$page_name="Edit Data Hotel SMP | Sistem Sekolahan";
$modul_id="tabel_hotel";
$modul_id_page_id="tabel_hotel_edit_hotel";
$copy_base_language_library_web_css=array();
$copy_base_language_library_web_css[]=array("name"=>"select2","path"=>"bower_components/select2/dist/css/select2.min.css");

include ("../inc_body_header.php");
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Edit Data Hotel SMP
        <small>Form Edit Data Hotel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Hotel</a></li>
        <li class="active">Edit Data Hotel SMP</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      

 <div class="row">

          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Form Data Hotel </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
                   <form role="form" name="form_hotel" id="form_hotel" method="POST"  >
<div class="box-body">

<div class="form-group">
  <label>Tingkat</label>
  <select class="form-control form-control" id="pilihan_tingkat"  name="pilihan_tingkat"  >
    <?php print("<option value='"."-1"."' >"."- select -"."</option>");
?>
<?php foreach($daftar_tingkat as $keydaftar_tingkat=>$valuedaftar_tingkat) {
$dapatcari=0;
if ($keydaftar_tingkat == $data_diri_hotel['tingkat_id']){
$dapatcari=1;
}
if ($dapatcari == 1){
print("<option value='".$keydaftar_tingkat."' selected>".$valuedaftar_tingkat."</option>");
}else{
print("<option value='".$keydaftar_tingkat."' >".$valuedaftar_tingkat."</option>");
}

}
?>
  </select>
</div>

<div class="form-group">
  <label>Kelas</label>
  <select class="form-control form-control" id="pilihan_kelas"  name="pilihan_kelas"  >
    <?php print("<option value='"."-1"."' >"."- select -"."</option>");
?>
<?php foreach($daftar_kelas as $keydaftar_kelas=>$valuedaftar_kelas) {
$dapatcari=0;
if ($keydaftar_kelas == $data_diri_hotel['kelas_id']){
$dapatcari=1;
}
if ($dapatcari == 1){
print("<option value='".$keydaftar_kelas."' selected>".$valuedaftar_kelas."</option>");
}else{
print("<option value='".$keydaftar_kelas."' >".$valuedaftar_kelas."</option>");
}

}
?>
  </select>
</div>

<div class="form-group">
  <label>Nama</label>
  <input type="text" class="form-control form-control" id="nama"  name="nama" placeholder="Enter nama"  value="<?php if(isset($data_diri_hotel)){ print($data_diri_hotel['nama']); } ?>" >
</div>

<div class="form-group">
  <label>Email</label>
  <input type="text" class="form-control form-control" id="email"  name="email" placeholder="Enter Email"  value="<?php if(isset($data_diri_hotel)){ print($data_diri_hotel['email']); } ?>" >
</div>

<label>Pelajaran Favorit</label>
<select class="form-control select2" id="pelajaranfavorit"  name="pelajaranfavorit[]" data-placeholder="Select pelajaranfavorit" multiple="multiple"
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
  <input type="text" class="form-control form-control" id="handphone"  name="handphone" placeholder="Isikan nomor handphone"  value="<?php if(isset($data_diri_hotel)){ print($data_diri_hotel['handphone']); } ?>" >
</div>

<div class="form-group">
  <label>Alamat</label>
  <textarea type="text" class="form-control form-control" id="alamat"  name="alamat" placeholder="Isikan alamat" ><?php if(isset($data_diri_hotel)){ print($data_diri_hotel['alamat']); } ?></textarea>
</div>

<div class="form-group">
  <label>Sertifikat</label>

        <textarea id="sertifikat"  name="sertifikat"  rows="10" cols="80"><?php if(isset($data_diri_hotel)){ print($data_diri_hotel['sertifikat']); } ?></textarea>
</div>

<div class="form-group">
  <label>Foto Profil</label>
  <img id="img_of_fotoprofil" src="http://localhost/hargakamar/uploads/<?php print($data_diri_hotel['fotoprofil']);?>" alt="no image" />
  <input type="file" name="fotoprofil" id="fotoprofil">

  <!--<p class="help-block">Example block-level help text here.</p>-->
</div>

<div class="box-footer">
  <button type="button" id="buttonSubmitForm" name="buttonSubmitForm" class="btn btn-primary">Submit Form</button>
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
   var page_id="edit_hotel";
var modul_id="tabel_hotel";
var catch_hotel_id=<?php print($hotel_id); ?>;

var pilihan_tingkat_hotel = 0;
var pilihan_tingkat_hotel_textvalue = null;

var pilihan_kelas_hotel = 0;
var pilihan_kelas_hotel_textvalue = null;

var isian_nama = null;

var isian_email = null;

var isian_pelajaranfavorit = 0;
var isian_pelajaranfavorit_textvalue = null;

var isian_handphone = null;

var isian_alamat = null;

var isian_sertifikat = null;

var isian_fotoprofil = null;
var isian_fotoprofil_file = null;
var isian_fotoprofil_file_content = null;

var isian_buttonSubmitForm = null;

function set_idx_select_pilihan_tingkat(nomidx){


}
$("#pilihan_tingkat").on( 'change', function () {
pilihan_tingkat_hotel_textvalue = $("#pilihan_tingkat option:selected").text();
pilihan_tingkat_hotel = $("#pilihan_tingkat").val();
set_idx_select_pilihan_kelas();

get_pilihan_kelas();


});

function set_idx_select_pilihan_kelas(nomidx){


}



$('.select2').select2();

function set_idx_select_pelajaranfavorit(nomidx){


}




CKEDITOR.replace('sertifikat')
//$('#sertifikat').wysihtml5();


$("#fotoprofil").on( 'change', function () {
isian_fotoprofil_file = document.getElementById("fotoprofil").files[0];
if (isian_fotoprofil_file){
var r = new FileReader();
r.onload = function(e) {
var contents = e.target.result;
$('#img_of_fotoprofil').attr('src', e.target.result);
isian_fotoprofil_file_content = contents;
}
r.readAsDataURL (isian_fotoprofil_file);
}

});

$("#buttonSubmitForm").on( 'click', function () {
get_variable_of_form_form_hotel();

var return_of_check_validation_form_form_hotel = check_validation_form_form_hotel();
if (return_of_check_validation_form_form_hotel == true){
update_data_hotel_barua();

}


});
function get_variable_of_form_form_hotel(){ 

pilihan_tingkat_hotel_textvalue = $("#pilihan_tingkatoption:selected").text();
pilihan_tingkat_hotel = $("#pilihan_tingkat").val();
pilihan_kelas_hotel_textvalue = $("#pilihan_kelasoption:selected").text();
pilihan_kelas_hotel = $("#pilihan_kelas").val();
isian_nama = document.getElementById("nama").value;
isian_email = document.getElementById("email").value;
isian_pelajaranfavorit = $("#pelajaranfavorit").val();
isian_handphone = document.getElementById("handphone").value;
isian_alamat = document.getElementById("alamat").value;
isian_sertifikat = CKEDITOR.instances.sertifikat.getData();


//end of get_variable_of_form_form_hotel
}
function check_validation_form_form_hotel(){
var valid_status=true;
var valid_msg="";

var field_tocheck_nama = document.getElementById("nama");
if (field_tocheck_nama.value.length < 1) {
  valid_status=false;
  valid_msg+="Harap isikan nama,";
}

var field_tocheck_email = document.getElementById("email");
if (field_tocheck_email.value.length < 1) {
  valid_status=false;
  valid_msg+="Harap isikan email,";
}

var field_tocheck_email = document.getElementById("email");

var field_tocheck_handphone = document.getElementById("handphone");
if (field_tocheck_handphone.value.length < 1) {
  valid_status=false;
  valid_msg+="Harap isikan nomor handphone,";
}

var field_tocheck_handphone = document.getElementById("handphone");

var field_tocheck_alamat = document.getElementById("alamat");
if (field_tocheck_alamat.value.length < 1) {
  valid_status=false;
  valid_msg+="Harap isikan alamat,";
}

var field_tocheck_sertifikat = CKEDITOR.instances.sertifikat.getData();
if (field_tocheck_sertifikat.length < 1) {
  valid_status=false;
  valid_msg+="Harap isikan sertifikat,";
}



if(valid_status==false){
  alert(valid_msg);
}

return valid_status;

//end of check_validation_form_form_hotel
}
function submit_form_form_hotel(){
     
}
function get_pilihan_kelas(){
ajaxjson_get_pilihan_kelas = buatajax();
var url="http://localhost/hargakamar/API/";
ajaxjson_get_pilihan_kelas.onreadystatechange = stateChangedjson_get_pilihan_kelas;
ajaxjson_get_pilihan_kelas.open("POST",url,true);
ajaxjson_get_pilihan_kelas.setRequestHeader("Content-Type", "application/json");
var data = JSON.stringify({"modul":"report","action":"get_kelas","tingkat_id":pilihan_tingkat_hotel});
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
function update_data_hotel_barua(){
ajaxjson_update_data_hotel_barua = buatajax();
var url="http://localhost/hargakamar/API/";
ajaxjson_update_data_hotel_barua.onreadystatechange = stateChangedjson_update_data_hotel_barua;
ajaxjson_update_data_hotel_barua.open("POST",url,true);
ajaxjson_update_data_hotel_barua.setRequestHeader("Content-Type", "application/json");
var data = JSON.stringify({"modul":"report","action":"update_data_hotel","hotel_id":catch_hotel_id,"nama":isian_nama,"pelajaran_favorit":isian_pelajaranfavorit,"email":isian_email,"tingkat_id":pilihan_tingkat_hotel,"kelas_id":pilihan_kelas_hotel,"alamat":isian_alamat,"handphone":isian_handphone,"fotoprofil":isian_fotoprofil_file_content,"sertifikat":isian_sertifikat});
console.log("Data sent from update_data_hotel_barua : "+data);
ajaxjson_update_data_hotel_barua.send(data);


}
var ajaxjson_update_data_hotel_barua;
function stateChangedjson_update_data_hotel_barua(){
  var this_html_response;
   if (ajaxjson_update_data_hotel_barua.readyState==4){
     this_html_response=ajaxjson_update_data_hotel_barua.responseText;
     console.log("response from update_data_hotel_barua : "+ajaxjson_update_data_hotel_barua.responseText);
     if(this_html_response.length>0){
     var hasilUpdateDataHotela = ekstrakHasilUpdatea(this_html_response,"response_data");
if (hasilUpdateDataHotela == 1){
jumpketabel("tabel_hotel","daftar_hotel");

}


      }
    }
}

var hasilUpdateDataHotela;
function ekstrakHasilUpdatea(dataekstrakHasilUpdatea,targetekstrakHasilUpdatea){
hasilUpdateDataHotela = content_of_ekstrakHasilUpdatea;

return content_of_ekstrakHasilUpdatea;

}
function jumpketabel(moduljumpketabel,pagejumpketabel){


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
