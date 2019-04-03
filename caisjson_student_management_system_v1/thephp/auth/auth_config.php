<?php

function modul_auth_config($thejson){
  $themodul = std_modul();
  $themodul->id="auth_config";
  $themodul->title="Auth Config";
  $themodul->subtitle="";
  $themodul->asclass=true;

  $themodul->page[]=page_register_auth($thejson);

  return $themodul;
}

function page_register_auth($thejson){
  $manifest=$thejson;
  $thepage=std_page();
  $thepage->id="register_auth";
  $thepage->title="Register Auth";
  $thepage->page_func_param=array();
  $thepage->page_func_param[]='$allowedroles';
  $thepage->page_func_param[]='$datas';


  $vars=std_variable();
  $vars->var_name="variables";

              $hasilauth=std_variable();
              $hasilauth->var_name=$manifest->auth_checking->outputVariable;

              $stdsetvar=std_declare_variable();
              $stdsetvar->body=$hasilauth;

              $thepage->process[]=$stdsetvar;

$bahansidemenu="";
$newpageprogress=array();
              for($i=0; $i<count($manifest->moduls); $i++){

                $controller_name=$manifest->moduls[$i]->id;
                $arsidemenu==array();
                $jumpageplacement=0;
                for($j=0; $j<count($manifest->moduls[$i]->page); $j++){
                  if(isset($manifest->moduls[$i]->page[$j]->placement)){
                    for($jp=0; $jp<count($manifest->moduls[$i]->page[$j]->placement); $jp++){
                      $theplacement=$manifest->moduls[$i]->page[$j]->placement[$jp];
                    if($theplacement->place=="sidemenu"){
                      $jumpageplacement+=1;
                      $arsidemenu[]=$manifest->moduls[$i]->page[$j]->id;
                    }
                    }
                  }
                }

                $authberkaspoin=std_variable();
                $authberkaspoin->var_name="poin_auth_modul_".$controller_name;


                $authberkasequal=std_variable();
                $authberkasequal->var_name=$jumpageplacement;
                $authberkasequal->var_type="hardcode";

                $stdsetvar=std_declare_variable();
                $stdsetvar->body=$authberkaspoin;
                $stdsetvar->default_value=$authberkasequal;

                $newpageprogress[]=$stdsetvar;

                $bahansidemenu.="\n".'$poin_auth_modul_'.$controller_name.' = '.$jumpageplacement.';';
                for($j=0; $j<count($manifest->moduls[$i]->page); $j++){

                    if(in_array($manifest->moduls[$i]->page[$j]->id,$arsidemenu)){
                  $thepagetocheck=$manifest->moduls[$i]->page[$j];
                  $func_name=$thepagetocheck->id;

                  $nilaiawalauth="1";
               for($a=0; $a<count($manifest->auth);$a++){
                 if($manifest->auth[$a]->moduls==$controller_name){
                   if(in_array($thepagetocheck->id,$manifest->auth[$a]->pages)){

                   if(isset($thepagetocheck->placement)){
                     if(count($thepagetocheck->placement)>0){
                     $nilaiawalauth="-1";
                    }
                  }

                  }
                }
              }

              $authberkas=std_variable();
              $authberkas->var_name="auth_modul_".$controller_name.'_page_'.$func_name;


              $authberkasequal=std_variable();
              $authberkasequal->var_name=$nilaiawalauth;
              $authberkasequal->var_type="hardcode";

              $stdsetvar=std_declare_variable();
              $stdsetvar->body=$authberkas;
              $stdsetvar->default_value=$authberkasequal;


              $newpageprogress[]=$stdsetvar;

              $bahansidemenu.="\n".'$auth_modul_'.$controller_name.'_page_'.$func_name.' = '.$nilaiawalauth.';';
                  //->auth


                  for($a=0; $a<count($manifest->auth);$a++){
                    if($manifest->auth[$a]->moduls==$controller_name){
                      if(in_array($thepagetocheck->id,$manifest->auth[$a]->pages)){

                        if(isset($thepagetocheck->placement)){
                          for($jp=0; $jp<count($manifest->moduls[$i]->page[$j]->placement); $jp++){
                            $theplacement=$manifest->moduls[$i]->page[$j]->placement[$jp];
                          if($theplacement->place=="sidemenu"){
                            $authberkasequal=std_variable();
                            $authberkasequal->var_name=1;
                            $authberkasequal->var_type="hardcode";

                            $stdsetvar=std_set_variable();
                            $stdsetvar->var=$authberkas;
                            $stdsetvar->equal=$authberkasequal;

                            $newkondisi=std_condition();
                            $newkondisi->check_condition=$manifest->auth[$a]->allow;
                            $newkondisi->ontrue->process[]=$stdsetvar;

                            $newkondisiglobal=std_condition();
                            $newkondisiglobal->check_condition=$manifest->auth_checking->allow;
                            $newkondisiglobal->ontrue->process[]=$newkondisi;
                            $newkondisiglobal->withisset=true;

                            $newpageprogress[]=$newkondisiglobal;
                        break;
                        }
                        }
                      }
                    }



                  }
                  }

if($nilaiawalauth==-1){
                    $minsatu=std_variable();
                    $minsatu->var_name=-1;
                    $minsatu->var_type="hardcode";

                    $satu=std_variable();
                    $satu->var_name=1;
                    $satu->var_type="hardcode";

                  $cekminsatu=std_check();
                  $cekminsatu->check=$authberkas;
                  $cekminsatu->operator="==";
                  $cekminsatu->value=$minsatu;


                    $authberkasequal=std_variable();
                    $authberkasequal->var_name=1;
                    $authberkasequal->var_type="hardcode";

                    $stdsetvar=std_set_variable();
                    $stdsetvar->var=$authberkaspoin;
                    $stdsetvar->equal=$satu;
                    $stdsetvar->operator="-=";

                  $kondisicekminsatu=std_condition();
                  $kondisicekminsatu->check_condition[]=$cekminsatu;
                  $kondisicekminsatu->ontrue->process[]=$stdsetvar;

                  $newpageprogress[]=$kondisicekminsatu;
                }
                }
                }
              }

  $stdsetvar=std_set_variable();
  $stdsetvar->var=$hasilauth;
  $stdsetvar->equal=$vars;
  $thepage->process=array_merge($thepage->process,$manifest->auth_checking->process);
  $thepage->process[]=$stdsetvar;

  $thepage->process=array_merge($thepage->process,$newpageprogress);

  $thepage->outputVariable=$manifest->auth_checking->outputVariable;


  $thepage->process[]=$stdsetvar;

  return $thepage;
}


 ?>
