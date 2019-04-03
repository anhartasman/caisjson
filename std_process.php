<?php


function std_declare_variable(){

    $std_project=new \stdClass();
    $std_project->type="declare_variable";
    $std_project->body=std_variable();

    return $std_project;
}

function std_set_variable(){

    $std_project=new \stdClass();
    $std_project->type="set_variable";
    $std_project->var=std_variable();
    $std_project->equal=std_variable();

    return $std_project;
}

function std_condition(){

    $std_condition=new \stdClass();
    $std_condition->type="condition";
    $std_condition->check_condition=array();
    $std_condition->ontrue=new \stdClass();
    $std_condition->ontrue->process=array();

    return $std_condition;
}

function std_check(){

    $std_check=new \stdClass();
    $std_check->check=std_variable();
    $std_check->operator="==";
    $std_check->value=std_variable();

    return $std_check;
}

function std_crafted(){
  $std_crafted=new \stdClass();
  $std_crafted->type="";
  $std_crafted->model_name="";
  $std_crafted->func_name="";
  $std_crafted->outputVariable="";
  $std_crafted->model_use_location="";
  $std_crafted->param=array();

  return $std_crafted;
}

function std_url_catcher(){
  $std_url_catcher=new \stdClass();
  $std_url_catcher->runifnotnull=array();
  $std_url_catcher->from_engine=false;
  $std_url_catcher->type="url_catcher";
  $std_url_catcher->catch="";
  $std_url_catcher->variable="";
  return $std_url_catcher;
}

function std_fileupload(){
  $std_fileupload=new \stdClass();
  $std_fileupload->runifnotnull=array();
  $std_fileupload->from_engine=false;
  $std_fileupload->type="fileupload";
  $std_fileupload->id=null;
  $std_fileupload->field="";
  $std_fileupload->file_name="";
  $std_fileupload->extension="jpg";
  $std_fileupload->param=array();
  return $std_fileupload;
}

function std_filedelete(){
  $std_filedelete=new \stdClass();
  $std_filedelete->runifnotnull=array();
  $std_filedelete->from_engine=false;
  $std_filedelete->type="file_delete";
  $std_filedelete->id=null;
  $std_filedelete->file_name=new \stdClass();
  $std_filedelete->param=array();
  return $std_filedelete;
}



 ?>
