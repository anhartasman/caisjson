<?php
$page_name="{page_name}";
$modul_id="{modul_id}";
$modul_id_page_id="{modul_id_page_id}";
include ("../inc_body_header.php");
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        {page_title}
        <small>{page_subtitle}</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Data tables</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      {page_content}
      <!-- /.row -->
    </section>

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
{copy_js}

<script>
  $(function () {

        var isifile="";
        $("<?php if(isset($prepage)){print($prepage);} ?>#buttonSubmit").on( 'click', function () {
        var file = document.getElementById('foto').files[0];

          var formData = JSON.stringify($("<?php if(isset($prepage)){print($prepage);} ?>#formaddsiswa").serializeArray());
          //alert(file);

        if (file) {
          var r = new FileReader();
          r.onload = function(e) {
              var contents = e.target.result;
              /**
            alert("name: " + file.name + "n"
                  +"type: " + file.type + "n"
                  +"size: " + file.size + " bytesn"
                  + "starts with: " + contents
            );
            **/
          //alert(contents);
          isifile=contents;
           kirimData();
          $('<?php if(isset($prepage)){print($prepage);} ?>#blah').attr('src', e.target.result);
          }
          r.readAsDataURL (file);
        //  r.readAsBinaryString (file);
        }

        var fd = new FormData();

            //var formData = new FormData($("<?php if(isset($prepage)){print($prepage);} ?>#formaddsiswa")[0]);
        //fd.append("file", file);
        //fd.append("isFirst", true);
        fd.append("modul", "report");
        fd.append("action", "addsiswa");
        fd.append("filegambar", "5");


        });

        function kirimData(){

              var associativeArray = {};
          associativeArray["modul"] = "report";
          associativeArray["action"] = "addsiswa";
          associativeArray["filegambar"] = isifile;

          var dataString = JSON.stringify(associativeArray);
                $.ajax({
                  url: "http://localhost/nativecreator/API/",
                  type: "POST",
                  data: dataString,
             dataType: 'text',
                  processData: false,
                  contentType: false,
                  success: function (res) {
                    //document.getElementById("response").innerHTML = res;
                    //alert(JSON.stringify(res));
                    alert(res);
                  },
             error: function(jqXHR, textStatus, errorThrown){
               alert(textStatus, errorThrown);
            }
                });
        }



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
                  //  $('<?php if(isset($prepage)){print($prepage);} ?>#bodyexample1').html(data);
                  var string = "UpdateBootProfile,PASS,00:00:00";
                  var array = datarjsonisitabel.split(",");
                  var data = [
                      array
                  ];
                  $('<?php if(isset($prepage)){print($prepage);} ?>#sample_1').dataTable().fnClearTable();
                  var obj=JSON.parse(datarjsonisitabel);

                  if(obj.list!=null){
                                        if(obj.listidtabel==null){
                      alert("kosong");
                    }
                    listidtabel=obj.listidtabel;

                  $('<?php if(isset($prepage)){print($prepage);} ?>#sample_1').dataTable().fnAddData(obj.list);
                    $("<?php if(isset($prepage)){print($prepage);} ?>#isifooter").html(obj.isifooter);
                  }else{
                    $("<?php if(isset($prepage)){print($prepage);} ?>#isifooter").html("");
                  }

                   }
                   //alert(jsonisitabel);

                 }
            }


   });
   {footer_js}


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
