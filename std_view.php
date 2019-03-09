<?php
function std_include($stdinclude){

    $std_include=new \stdClass();
    $std_include->type="include_file";
    $std_include->include=$stdinclude;

    return $std_include;
}

function std_project(){

    $std_project=new \stdClass();
    $std_project->project_name="";
    $std_project->project_subtitle="";
    $std_project->project_config=array();
    $std_project->auth=array();
    $std_project->moduls=array();
    $std_project->element=array();
    $std_project->functions=array();
    $std_project->process=array();
    $std_project->global_variables=array();
    $std_project->libraries=array();
    $std_project->daf_api=array();

    return $std_project;
}

function std_project_config(){

    $std_project=new \stdClass();
    $std_project->config_type="";
    $std_project->database_host="";
    $std_project->database_name="";
    $std_project->database_port="3306";
    $std_project->database_username="";
    $std_project->database_password="";
    $std_project->web_url="";
    $std_project->web_localpath="";
    $std_project->web_description="";

    return $std_project;
}

function std_auth(){

    $std_auth=new \stdClass();
    $std_auth->moduls=array();
    $std_auth->pages=array();
    $std_auth->allow=array();
    $std_auth->onfailed=new \stdClass();
    $std_auth->onfailed->process=array();

    return $std_auth;
}

function std_variable(){

    $std_variable=new \stdClass();
    $std_variable->var_type="variable";
    $std_variable->var_name="";

    return $std_variable;
}


function std_place_sidemenu(){

    $std_place=new \stdClass();
    $std_place->place="sidemenu";

    return $std_place;
}

function std_modul(){

    $std_modul=new \stdClass();
    $std_modul->id="";
    $std_modul->title="";
    $std_modul->subtitle="";
    $std_modul->ignore=false;
    $std_modul->page=array();
    $std_modul->placement=array();

    return $std_modul;
}

function std_page(){

    $std_page=new \stdClass();
    $std_page->id="";
    $std_page->title="";
    $std_page->subtitle="";
    $std_page->frame="adminpage";
    $std_page->ignore=false;
    $std_page->placement=array();
    $std_page->elemen=array();
    $std_page->functions=array();
    $std_page->process=array();

    return $std_page;
}
function std_element_tabel() {

  $std_element_tabel=new \stdClass();
  $std_element_tabel->type="tabel";
  $std_element_tabel->id="";
  $std_element_tabel->title="";
  $std_element_tabel->columns=array();
  $std_element_tabel->link=new \stdClass();
  $std_element_tabel->link->head=array();
  $std_element_tabel->listeners=array();
  $std_element_tabel->forms=array();

  return $std_element_form;
}
function std_link_head() {

  $link_head=new \stdClass();
  $link_head->position="head";
  $link_head->type="modul_page";
  $link_head->modul="";
  $link_head->page="";
  $link_head->label="";

  return $link_head;
}

function std_element_form() {

  $std_element_form=new \stdClass();
  $std_element_form->type="form";
  $std_element_form->id="";
  $std_element_form->title="";
  $std_element_form->link=null;
  $std_element_form->listeners=array();
  $std_element_form->forms=array();

  return $std_element_form;
}

function std_form() {

$std_form=new \stdClass();
$std_form->id="";
$std_form->div_class="box-body";
$std_form->attribute=new \stdClass();
$std_form->attribute->method="POST";
$std_form->field=array();

  return $std_form;
}

function std_form_field_select2(){

  $std_form_field_select2=new \stdClass();
  $std_form_field_select2->type="select2";
  $std_form_field_select2->id="";
  $std_form_field_select2->label="";
  $std_form_field_select2->variable="";
  $std_form_field_select2->class="";
  $std_form_field_select2->theme="normal";
  $std_form_field_select2->first_option_label="- select -";
  $std_form_field_select2->first_option_value="-1";
  $std_form_field_select2->value=new \stdClass();
  $std_form_field_select2->attribute=new \stdClass();
  $std_form_field_select2->listeners=array();
  $std_form_field_select2->validation=array();

  return $std_form_field_select2;

}

function std_form_field_text(){

$std_form_field_text=new \stdClass();
$std_form_field_text->type="text";
$std_form_field_text->id="";
$std_form_field_text->label="";
$std_form_field_text->variable=null;
$std_form_field_text->class="form-control";
$std_form_field_text->theme="normal";
$std_form_field_text->attribute=new \stdClass();
$std_form_field_text->listeners=array();
$std_form_field_text->validation=array();

return $std_form_field_text;

}

function std_form_field_textarea(){

$std_form_field_textarea=new \stdClass();
$std_form_field_textarea->type="textarea";
$std_form_field_textarea->id="";
$std_form_field_textarea->label="";
$std_form_field_textarea->variable=null;
$std_form_field_textarea->class="form-control";
$std_form_field_textarea->theme="normal";
$std_form_field_textarea->attribute=new \stdClass();
$std_form_field_textarea->listeners=array();
$std_form_field_textarea->validation=array();

return $std_form_field_textarea;

}

function std_form_field_image_upload(){

$std_form_field_image_upload=new \stdClass();
$std_form_field_image_upload->type="image_upload";
$std_form_field_image_upload->id="";
$std_form_field_image_upload->label="";
$std_form_field_image_upload->variable=null;
$std_form_field_image_upload->src=new \stdClass();
$std_form_field_image_upload->class="form-control";
$std_form_field_image_upload->theme="normal";
$std_form_field_image_upload->attribute=new \stdClass();
$std_form_field_image_upload->listeners=array();
$std_form_field_image_upload->validation=array();

return $std_form_field_image_upload;

}

function std_form_field_image(){

$std_form_field_image=new \stdClass();
$std_form_field_image->type="image";
$std_form_field_image->id="";
$std_form_field_image->label="";
$std_form_field_image->variable="";
$std_form_field_image->class="form-control";
$std_form_field_image->src=new \stdClass();
$std_form_field_image->theme="normal";
$std_form_field_image->attribute=new \stdClass();
$std_form_field_image->listeners=array();
$std_form_field_image->validation=array();

return $std_form_field_image;

}

function std_form_field_datepicker(){

$std_form_field_datepicker=new \stdClass();
$std_form_field_datepicker->type="datepicker";
$std_form_field_datepicker->id="";
$std_form_field_datepicker->label="";
$std_form_field_datepicker->variable=null;
$std_form_field_datepicker->class="form-control";
$std_form_field_datepicker->theme="normal";
$std_form_field_datepicker->date_format="yyyy-mm-dd";
$std_form_field_datepicker->listeners=array();
$std_form_field_datepicker->validation=array();

return $std_form_field_datepicker;

}

function std_form_field_email(){
  $std_form_field_email=new \stdClass();
  $std_form_field_email->type="email";
  $std_form_field_email->id="";
  $std_form_field_email->label="";
  $std_form_field_email->variable=null;
  $std_form_field_email->class="form-control";
  $std_form_field_email->theme="normal";
  $std_form_field_email->attribute=new \stdClass();
  $std_form_field_email->listeners=array();
  $std_form_field_email->validation=array();

  return $std_form_field_email;
}

function std_form_field_file(){

$std_form_field_file=new \stdClass();
$std_form_field_file->type="file";
$std_form_field_file->id="";
$std_form_field_file->label="";
$std_form_field_file->variable=null;
$std_form_field_file->class="form-control";
$std_form_field_file->theme="normal";
$std_form_field_file->attribute=new \stdClass();
$std_form_field_file->listeners=array();
$std_form_field_file->validation=array();

return $std_form_field_file;

}

function std_form_field_number(){

$std_form_field_number=new \stdClass();
$std_form_field_number->type="number";
$std_form_field_number->id="";
$std_form_field_number->label="";
$std_form_field_number->variable=null;
$std_form_field_number->class="form-control";
$std_form_field_number->theme="normal";
$std_form_field_number->attribute=new \stdClass();
$std_form_field_number->listeners=array();
$std_form_field_number->validation=array();

return $std_form_field_number;

}

function std_form_field_password(){

$std_form_field_password=new \stdClass();
$std_form_field_password->type="password";
$std_form_field_password->id="";
$std_form_field_password->label="";
$std_form_field_password->variable=null;
$std_form_field_password->class="form-control";
$std_form_field_password->theme="normal";
$std_form_field_password->attribute=new \stdClass();
$std_form_field_password->listeners=array();
$std_form_field_password->validation=array();

return $std_form_field_password;

}

function std_form_field_richtext(){

$std_form_field_richtext=new \stdClass();
$std_form_field_richtext->type="richtext";
$std_form_field_richtext->id="";
$std_form_field_richtext->label="";
$std_form_field_richtext->variable=null;
$std_form_field_richtext->class="form-control";
$std_form_field_richtext->theme="normal";
$std_form_field_richtext->attribute=new \stdClass();
$std_form_field_richtext->listeners=array();
$std_form_field_richtext->validation=array();

return $std_form_field_richtext;

}

function std_form_field_richtext_view(){

$std_form_field_richtext_view=new \stdClass();
$std_form_field_richtext_view->type="richtext_view";
$std_form_field_richtext_view->id="";
$std_form_field_richtext_view->label="";
$std_form_field_richtext_view->value=new \stdClass();
$std_form_field_richtext_view->class="form-control";
$std_form_field_richtext_view->theme="normal";
$std_form_field_richtext_view->attribute=new \stdClass();
$std_form_field_richtext_view->listeners=array();
$std_form_field_richtext_view->validation=array();

return $std_form_field_richtext_view;

}

function std_form_field_text_view(){

$std_form_field_text_view=new \stdClass();
$std_form_field_text_view->type="text_view";
$std_form_field_text_view->id="";
$std_form_field_text_view->label="";
$std_form_field_text_view->value=new \stdClass();
$std_form_field_text_view->class="form-control";
$std_form_field_text_view->theme="normal";
$std_form_field_text_view->attribute=new \stdClass();
$std_form_field_text_view->listeners=array();
$std_form_field_text_view->validation=array();

return $std_form_field_text_view;

}

function std_form_field_select(){

$std_form_field_select=new \stdClass();
$std_form_field_select->type="select";
$std_form_field_select->id="";
$std_form_field_select->label="";
$std_form_field_select->variable=null;
$std_form_field_select->class="form-control";
$std_form_field_select->theme="normal";
$std_form_field_select->first_option_label="- select -";
$std_form_field_select->first_option_value="-1";
$std_form_field_select->value=new \stdClass();
$std_form_field_select->attribute=new \stdClass();
$std_form_field_select->listeners=array();
$std_form_field_select->validation=array();

return $std_form_field_select;

}

function std_form_field_timepicker(){

$std_form_field_timepicker=new \stdClass();
$std_form_field_timepicker->type="timepicker";
$std_form_field_timepicker->id="";
$std_form_field_timepicker->label="";
$std_form_field_timepicker->variable=null;
$std_form_field_timepicker->class="form-control";
$std_form_field_timepicker->theme="normal";
$std_form_field_timepicker->date_format="yyyy-mm-dd";
$std_form_field_timepicker->attribute=new \stdClass();
$std_form_field_timepicker->listeners=array();
$std_form_field_timepicker->validation=array();

return $std_form_field_timepicker;

}

function std_form_field_button(){

$std_form_field_button=new \stdClass();
$std_form_field_button->type="button";
$std_form_field_button->id="";
$std_form_field_button->label="";
$std_form_field_button->class="form-control";
$std_form_field_button->theme="normal";
$std_form_field_button->attribute=new \stdClass();
$std_form_field_button->listeners=array();
$std_form_field_button->validation=array();

return $std_form_field_button;

}

 ?>
