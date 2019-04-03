<?php
$requested_html = array();
$requested_html[] = array("key"=>"form_field","name"=>"button_theme_normal","file"=>"plugin/laravel/htmls/form_fields/button_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"button_theme_filter","file"=>"plugin/laravel/htmls/form_fields/button_theme_filter.html");
$requested_html[] = array("key"=>"form_field","name"=>"datepicker_theme_normal","file"=>"plugin/laravel/htmls/form_fields/datepicker_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"datepicker_theme_filter","file"=>"plugin/laravel/htmls/form_fields/datepicker_theme_filter.html");
$requested_html[] = array("key"=>"form_field","name"=>"timepicker_theme_normal","file"=>"plugin/laravel/htmls/form_fields/timepicker_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"email_theme_normal","file"=>"plugin/laravel/htmls/form_fields/email_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"file_theme_normal","file"=>"plugin/laravel/htmls/form_fields/file_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"image_theme_normal","file"=>"plugin/laravel/htmls/form_fields/image_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"image_upload_theme_normal","file"=>"plugin/laravel/htmls/form_fields/image_upload_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"number_theme_normal","file"=>"plugin/laravel/htmls/form_fields/number_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"password_theme_normal","file"=>"plugin/laravel/htmls/form_fields/password_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"richtext_theme_normal","file"=>"plugin/laravel/htmls/form_fields/richtext_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"richtext_view_theme_normal","file"=>"plugin/laravel/htmls/form_fields/richtext_view_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"select_theme_admin","file"=>"plugin/laravel/htmls/form_fields/select_theme_admin.html");
$requested_html[] = array("key"=>"form_field","name"=>"select_theme_normal","file"=>"plugin/laravel/htmls/form_fields/select_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"select","file"=>"plugin/laravel/htmls/form_fields/select.html");
$requested_html[] = array("key"=>"form_field","name"=>"select2_theme_filter","file"=>"plugin/laravel/htmls/form_fields/select2_theme_filter.html");
$requested_html[] = array("key"=>"form_field","name"=>"select2_theme_normal","file"=>"plugin/laravel/htmls/form_fields/select2_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"text_theme_normal","file"=>"plugin/laravel/htmls/form_fields/text_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"text_view_theme_normal","file"=>"plugin/laravel/htmls/form_fields/text_view_theme_normal.html");
$requested_html[] = array("key"=>"form_field","name"=>"textarea_theme_normal","file"=>"plugin/laravel/htmls/form_fields/textarea_theme_normal.html");

$requested_html[] = array("key"=>"form_field_js","type"=>"datepicker","file"=>"plugin/laravel/htmls/form_field_js/field_js_datepicker.php");
$requested_html[] = array("key"=>"form_field_js","type"=>"timepicker","file"=>"plugin/laravel/htmls/form_field_js/field_js_timepicker.php");
$requested_html[] = array("key"=>"form_field_js","type"=>"file","file"=>"plugin/laravel/htmls/form_field_js/field_js_file.php");
$requested_html[] = array("key"=>"form_field_js","type"=>"image_upload","file"=>"plugin/laravel/htmls/form_field_js/field_js_image_upload.php");
$requested_html[] = array("key"=>"form_field_js","type"=>"richtext","file"=>"plugin/laravel/htmls/form_field_js/field_js_richtext.php");
$requested_html[] = array("key"=>"form_field_js","type"=>"select","file"=>"plugin/laravel/htmls/form_field_js/field_js_select.php");
$requested_html[] = array("key"=>"form_field_js","type"=>"select2","file"=>"plugin/laravel/htmls/form_field_js/field_js_select2.php");

$requested_html[] = array("key"=>"form_field_get_value","type"=>"text","get_value"=>"{field_variable} = document.getElementById(\"{field_id}\").value;\n");
$requested_html[] = array("key"=>"form_field_get_value","type"=>"password","get_value"=>"{field_variable} = document.getElementById(\"{field_id}\").value;\n");
$requested_html[] = array("key"=>"form_field_get_value","type"=>"select","get_value"=>"{field_variable}_textvalue = $(\"<?php if(isset(\$prepage)){print(\$prepage);} ?>#{field_id}option:selected\").text();\n{field_variable} = $(\"<?php if(isset(\$prepage)){print(\$prepage);} ?>#{field_id}\").val();\n");
$requested_html[] = array("key"=>"form_field_get_value","type"=>"select2","get_value"=>"{field_variable} = $(\"<?php if(isset(\$prepage)){print(\$prepage);} ?>#{field_id}\").val();\n");
$requested_html[] = array("key"=>"form_field_get_value","type"=>"number","get_value"=>"{field_variable} = document.getElementById(\"{field_id}\").value;\n");
$requested_html[] = array("key"=>"form_field_get_value","type"=>"email","get_value"=>"{field_variable} = document.getElementById(\"{field_id}\").value;\n");
$requested_html[] = array("key"=>"form_field_get_value","type"=>"textarea","get_value"=>"{field_variable} = document.getElementById(\"{field_id}\").value;\n");
$requested_html[] = array("key"=>"form_field_get_value","type"=>"datepicker","get_value"=>"{field_variable} = document.getElementById(\"{field_id}\").value;\n");
$requested_html[] = array("key"=>"form_field_get_value","type"=>"timepicker","get_value"=>"{field_variable} = document.getElementById(\"{field_id}\").value;\n");

$getvalue_file="{field_variable} = document.getElementById(\"{field_id}\").value;\n";
$getvalue_file.="{field_variable}_file = document.getElementById(\"{field_id}\").files[0];\n";
$getvalue_file.="if ({field_variable}_file){\n";
  $getvalue_file.="var r = new FileReader();\n";
  $getvalue_file.="r.onload = function(e) {\n";
    $getvalue_file.="var contents = e.target.result;\n";
    $getvalue_file.="{field_variable}_file_content = contents;\n";
    $getvalue_file.="}\n";
    $getvalue_file.="r.readAsDataURL ({field_variable}_file);\n";
    $getvalue_file.="}\n";

$requested_html[] = array("key"=>"form_field_get_value","type"=>"file","get_value"=>$getvalue_file);
$requested_html[] = array("key"=>"form_field_get_value","type"=>"richtext","get_value"=>"{field_variable} = CKEDITOR.instances.{field_id}.getData();\n");

$requested_html[] = array("key"=>"form_field_get_value_validation","type"=>"text","dataplace"=>".value","get_value"=>"var field_tocheck_{field_id} = document.getElementById(\"{field_id}\");");
$requested_html[] = array("key"=>"form_field_get_value_validation","type"=>"password","dataplace"=>".value","get_value"=>"var field_tocheck_{field_id} = document.getElementById(\"{field_id}\");");
$requested_html[] = array("key"=>"form_field_get_value_validation","type"=>"select","dataplace"=>".value","get_value"=>"var field_tocheck_{field_id} = document.getElementById(\"{field_id}\");");
$requested_html[] = array("key"=>"form_field_get_value_validation","type"=>"select2","dataplace"=>".value","get_value"=>"var field_tocheck_{field_id} = document.getElementById(\"{field_id}\");");
$requested_html[] = array("key"=>"form_field_get_value_validation","type"=>"number","dataplace"=>".value","get_value"=>"var field_tocheck_{field_id} = document.getElementById(\"{field_id}\");");
$requested_html[] = array("key"=>"form_field_get_value_validation","type"=>"email","dataplace"=>".value","get_value"=>"var field_tocheck_{field_id} = document.getElementById(\"{field_id}\");");
$requested_html[] = array("key"=>"form_field_get_value_validation","type"=>"textarea","dataplace"=>".value","get_value"=>"var field_tocheck_{field_id} = document.getElementById(\"{field_id}\");");
$requested_html[] = array("key"=>"form_field_get_value_validation","type"=>"file","dataplace"=>".value","get_value"=>"var field_tocheck_{field_id} = document.getElementById(\"{field_id}\");");
$requested_html[] = array("key"=>"form_field_get_value_validation","type"=>"richtext","dataplace"=>"","get_value"=>"var field_tocheck_{field_id} = CKEDITOR.instances.{field_id}.getData();");
$requested_html[] = array("key"=>"form_field_get_value_validation","type"=>"datepicker","dataplace"=>".value","get_value"=>"var field_tocheck_{field_id} = document.getElementById(\"{field_id}\");");
$requested_html[] = array("key"=>"form_field_get_value_validation","type"=>"timepicker","dataplace"=>".value","get_value"=>"var field_tocheck_{field_id} = document.getElementById(\"{field_id}\");");

$requested_html[] = array("key"=>"form_field_validation","type"=>"minlength","replaces"=>array(array("from"=>"length","to"=>"{minlength}"),array("from"=>"message","to"=>"{validation_msg}")),"file"=>"plugin/laravel/htmls/form_field_validations/jsvalidation_minlength.html");

$requested_html[] = array("key"=>"form_field_listener","listen"=>"onclick","file"=>"plugin/laravel/htmls/form_field_listener/field_listener_onclick.php","func_name"=>"create_web_onclick_listener");
$requested_html[] = array("key"=>"form_field_listener","listen"=>"onload","file"=>"plugin/laravel/htmls/form_field_listener/field_listener_onload.php","func_name"=>"create_web_onload_listener");
$requested_html[] = array("key"=>"form_field_listener","listen"=>"onchange","file"=>"plugin/laravel/htmls/form_field_listener/field_listener_onchange.php","func_name"=>"create_web_onchange_listener");

$requested_html[] = array("key"=>"form_field_js_insert","type"=>"select2","file"=>"plugin/laravel/htmls/js_inserts/jsformfield_select2.txt");
$requested_html[] = array("key"=>"form_field_js_insert","type"=>"timepicker","file"=>"plugin/laravel/htmls/js_inserts/jsformfield_timepicker.txt");
$requested_html[] = array("key"=>"form_field_css_insert","type"=>"select2","path"=>"public/bower_components/select2/dist/css/select2.min.css","language"=>"library_web_css");
$requested_html[] = array("key"=>"form_field_css_insert","type"=>"timepicker","path"=>"public/plugins/timepicker/bootstrap-timepicker.min.css","language"=>"library_web_css");

$requested_html[] = array("key"=>"void_calculator","name"=>"api_shooter","file"=>"plugin/laravel/htmls/void_calculators/void_calc_api_shooter.php");
$requested_html[] = array("key"=>"void_calculator","name"=>"concat_var","file"=>"plugin/laravel/htmls/void_calculators/void_calc_concat_var.php");
$requested_html[] = array("key"=>"void_calculator","name"=>"change_datatable_by_json","file"=>"plugin/laravel/htmls/void_calculators/void_calc_change_datatable_by_json.php");
$requested_html[] = array("key"=>"void_calculator","name"=>"json_extracter","file"=>"plugin/laravel/htmls/void_calculators/void_calc_json_extracter.php");
$requested_html[] = array("key"=>"void_calculator","name"=>"setter_dropdown","file"=>"plugin/laravel/htmls/void_calculators/void_calc_setter_dropdown.php");
$requested_html[] = array("key"=>"void_calculator","name"=>"link_jumper","file"=>"plugin/laravel/htmls/void_calculators/void_calc_link_jumper.php");
$requested_html[] = array("key"=>"void_calculator","name"=>"page_jumper","file"=>"plugin/laravel/htmls/void_calculators/void_calc_page_jumper.php");

$requested_html[] = array("key"=>"void_script","name"=>"api_shooter","file"=>"plugin/laravel/htmls/void_scripts/api_shooter.html");
$requested_html[] = array("key"=>"void_script","name"=>"concat_var","file"=>"plugin/laravel/htmls/void_scripts/concat_var.html");
$requested_html[] = array("key"=>"void_script","name"=>"change_datatable_by_json","file"=>"plugin/laravel/htmls/void_scripts/change_datatable_by_json.html");
$requested_html[] = array("key"=>"void_script","name"=>"json_extracter","file"=>"plugin/laravel/htmls/void_scripts/json_extracter.html");
$requested_html[] = array("key"=>"void_script","name"=>"setter_dropdown","file"=>"plugin/laravel/htmls/void_scripts/setter_dropdown.html");
$requested_html[] = array("key"=>"void_script","name"=>"link_jumper","file"=>"plugin/laravel/htmls/void_scripts/link_jumper.html");
$requested_html[] = array("key"=>"void_script","name"=>"page_jumper","file"=>"plugin/laravel/htmls/void_scripts/page_jumper.html");


$requested_html[] = array("key"=>"page_element_script","type"=>"tabel","file"=>"plugin/laravel/htmls/page_element_scripts/tabel.php");
$requested_html[] = array("key"=>"page_element","type"=>"tabel","file"=>"plugin/laravel/htmls/page_elements/elemen_tabel.txt");
$requested_html[] = array("key"=>"page_element","type"=>"form","file"=>"plugin/laravel/htmls/page_elements/elemen_form.txt");
$requested_html[] = array("key"=>"page_element","type"=>"dropzone","file"=>"plugin/laravel/htmls/page_elements/elemen_dropzone.txt");
$requested_html[] = array("key"=>"page_element_js_insert","type"=>"tabel","file"=>"plugin/laravel/htmls/js_inserts/jsinsert_tabel.txt");
$requested_html[] = array("key"=>"page_element_js_declaration","type"=>"tabel","file"=>"plugin/laravel/htmls/js_loops/jsloop_tabel.txt");
$requested_html[] = array("key"=>"page_element","type"=>"calendar","file"=>"plugin/laravel/htmls/page_elements/elemen_calendar.txt");
$requested_html[] = array("key"=>"page_element_js_insert","type"=>"calendar","file"=>"plugin/laravel/htmls/js_inserts/jsinsert_calendar.txt");
$requested_html[] = array("key"=>"page_element_js_declaration","type"=>"calendar","file"=>"plugin/laravel/htmls/js_loops/jsloop_calendar.txt");
$requested_html[] = array("key"=>"page_element_css_insert","type"=>"calendar","path"=>"public/bower_components/fullcalendar/dist/fullcalendar.min.css","language"=>"library_web_css");
$requested_html[] = array("key"=>"page_element_js_insert","type"=>"dropzone","file"=>"plugin/laravel/htmls/js_inserts/jsinsert_dropzone.txt");
$requested_html[] = array("key"=>"page_element_js_declaration","type"=>"dropzone","file"=>"plugin/laravel/htmls/js_loops/jsloop_dropzone.txt");
$requested_html[] = array("key"=>"page_element_css_insert","type"=>"dropzone","path"=>"public/dropzone_assets/dropzone.css","language"=>"library_web_css");
$requested_html[] = array("key"=>"page_element_script","type"=>"dropzone","file"=>"plugin/laravel/htmls/page_element_scripts/dropzone.php");

$requested_html[] = array("key"=>"js_insert","name"=>"","file"=>"js_inserts/");
$requested_html[] = array("key"=>"css_insert","name"=>"","file"=>"css_inserts/");
$requested_html[] = array("key"=>"void_script","name"=>"","file"=>"void_scripts/");
$requested_html[] = array("key"=>"element_declarations","name"=>"","file"=>"element_declarations/");
$requested_html[] = array("key"=>"page_element_script","type"=>"calendar","file"=>"plugin/laravel/htmls/page_element_scripts/calendar.php");

 ?>
