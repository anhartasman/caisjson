<?php
function get_uniktabelmodulpage($tablename,$page){
  $inmodulinpage="modul_".$page->properties_modul."_page_".$page->properties_page;
  $tableinmodulinpage=$tablename->page."_in_".$inmodulinpage;

return $tableinmodulinpage;
}

function get_uniknamemodulpage($thename,$page){
  $inmodulinpage="modul_".$page->properties_modul."_page_".$page->properties_page;
  $tableinmodulinpage=$thename."_in_".$inmodulinpage;

return $tableinmodulinpage;
}

function get_string_between($string, $start, $end)
{
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0)
    {
        return '';
    }
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}
function render_html_element_field($page_elemen)
{
    $content = new \stdClass();
    $bahanawaljs = "";
    $variabeljsawal = "";
    $bahanform = "";
    $kontenvariabelform = "";
    $copy_basejs = "";
    for ($c = 0;$c < count($page_elemen->field);$c++)
    {
        $namavariablefield = "";
        if (!isset($page_elemen->field[$c]->variable))
        {
            $namavariablefield = "isian_" . $page_elemen->field[$c]->id;
            $page_elemen->field[$c]->variable = $namavariablefield;
        }
        else
        {
            $namavariablefield = $page_elemen->field[$c]->variable;
        }

        $requested_html = $_SESSION['caisconfig_' . $_SESSION['config_type']]->requested_html;
        //    var_dump($requested_html);
        //echo $namafiletheme;
        $isicontent = "";
        for ($r = 0;$r < count($requested_html);$r++)
        {
            if ($requested_html[$r]["key"] == "form_field_get_value")
            {
                if ($requested_html[$r]["type"] == $page_elemen->field[$c]->type)
                {
                    $kontenvariabelform .= $requested_html[$r]["get_value"];
                    break;
                }
            }
        }
        $kontenvariabelform = str_replace("{field_variable}", $namavariablefield, $kontenvariabelform);
        $kontenvariabelform = str_replace("{field_id}", $page_elemen->field[$c]->id, $kontenvariabelform);
    }

    $kontenfungsivalidasi = "";
    for ($c = 0;$c < count($page_elemen->field);$c++)
    {
        //echo $page_elemen->field[$c]->type;
        $field = get_web_field($page_elemen->field[$c]);
        $bahanawaljs .= "\n" . $field->isijs;
        $variabeljsawal .= "\n" . $field->varjsawal;
        $bahanform .= "\n" . $field->isicontent;
        if (isset($page_elemen->field[$c]->validation))
        {
            foreach ($page_elemen->field[$c]->validation as $validate)
            {
                $bahanvalidation = "";

                $bahandeklarasi = "";
                $dataplace = ".value";
                for ($r = 0;$r < count($requested_html);$r++)
                {
                    if ($requested_html[$r]["key"] == "form_field_validation")
                    {
                        if ($requested_html[$r]["type"] == $validate->type)
                        {
                            $bahanvalidation = bacafile($requested_html[$r]["file"]);
                            break;
                        }
                    }
                }

                for ($r = 0;$r < count($requested_html);$r++)
                {
                    if ($requested_html[$r]["key"] == "form_field_get_value_validation")
                    {
                        if ($requested_html[$r]["type"] == $page_elemen->field[$c]->type)
                        {
                            $bahandeklarasi = $requested_html[$r]["get_value"];
                            $dataplace = $requested_html[$r]["dataplace"];
                            break;
                        }
                    }
                }

                $bahandeklarasi .= "\n";
                $bahanvalidation = $bahandeklarasi . $bahanvalidation;
                $bahanvalidation = str_replace("{field_id}", $page_elemen->field[$c]->id, $bahanvalidation);
                $bahanvalidation = str_replace("{dataplace}", $dataplace, $bahanvalidation);

                for ($r = 0;$r < count($requested_html);$r++)
                {
                    if ($requested_html[$r]["key"] == "form_field_validation")
                    {
                        if ($requested_html[$r]["type"] == $validate->type)
                        {
                            for ($rr = 0;$rr < count($requested_html[$r]["replaces"]);$rr++)
                            {
                                $bahanfrom = $requested_html[$r]["replaces"][$rr]["from"];
                                $bahanvalidation = str_replace($requested_html[$r]["replaces"][$rr]["to"], $validate->$bahanfrom, $bahanvalidation);
                            }
                            break;
                        }
                    }
                }

                $kontenfungsivalidasi .= $bahanvalidation;
                $kontenfungsivalidasi .= "\n";
            }
        }
    }

    $form_get_variable = bacafile($_SESSION['caisconfig_' . $_SESSION['config_type']]->target_items . "copy_base/js_form_get_variable.html");
    $form_get_variable = str_replace("{form_id}", $page_elemen->id, $form_get_variable);
    $form_get_variable = str_replace("{content}", $kontenvariabelform, $form_get_variable);

    $bahanawaljs .= $form_get_variable;

    $fungsivalidasi = bacafile($_SESSION['caisconfig_' . $_SESSION['config_type']]->target_items . "copy_base/js_validation_function.html");
    $fungsivalidasi = str_replace("{form_id}", $page_elemen->id, $fungsivalidasi);
    $fungsivalidasi = str_replace("{content}", $kontenfungsivalidasi, $fungsivalidasi);

    $bahanawaljs .= $fungsivalidasi;

    $kontenfungsisubmitformjs = "";
    $fungsisubmitformjs = bacafile($_SESSION['caisconfig_' . $_SESSION['config_type']]->target_items . "copy_base/js_form_submit.html");
    $fungsisubmitformjs = str_replace("{form_id}", $page_elemen->id, $fungsisubmitformjs);
    $fungsisubmitformjs = str_replace("{content}", $kontenfungsisubmitformjs, $fungsisubmitformjs);

    $bahanawaljs .= $fungsisubmitformjs;

    $kontenfungsienterformjs = "";
    //echo "form ".$page_elemen->id;
    if (isset($page_elemen->listeners))
    {
        //echo "jumlah listener ".count($page_elemen->listeners);
        for ($lis = 0;$lis < count($page_elemen->listeners);$lis++)
        {
            $tolisten = $page_elemen->listeners[$lis];

            //echo $tolisten->listen. "ADA INI \n";
            switch ($tolisten->listen)
            {
                case "onEnter":
                    //echo "ADA onEnter \n";
                    for ($c = 0;$c < count($tolisten->functions);$c++)
                    {
                        $bahanlistener = create_web_function_caller($tolisten->functions[$c]);

                        $kontenfungsienterformjs .= $bahanlistener . "\n";
                    }

                break;
            }
        }
    }

    $fungsienterformjs = bacafile($_SESSION['caisconfig_' . $_SESSION['config_type']]->target_items . "copy_base/js_form_enter.html");
    $fungsienterformjs = str_replace("{form_id}", $page_elemen->id, $fungsienterformjs);
    $fungsienterformjs = str_replace("{content}", $kontenfungsienterformjs, $fungsienterformjs);

    $bahanawaljs .= $fungsienterformjs;

    $content->kontenvariabelform = $kontenvariabelform;
    $content->kontenfungsivalidasi = $kontenfungsivalidasi;
    $content->bahanform = $bahanform;
    $content->bahanawaljs = $bahanawaljs;
    $content->variabeljsawal = $variabeljsawal;
    $content->copy_basejs = $copy_basejs;

    return $content;

    //akhir render_html_element_field

}

function render_html_form_field($page_elemen)
{
    $content = new \stdClass();
    $bahanawaljs = "";
    $variabeljsawal = "";
    $bahanform = "";
    $kontenvariabelform = "";
    $copy_basejs = "";

    $hasilrender = render_html_element_field($page_elemen);
    $kontenvariabelform = $hasilrender->kontenvariabelform;
    $kontenfungsivalidasi = $hasilrender->kontenfungsivalidasi;

    $bahanform .= "<form role=\"form\" name=\"{form_id}\" id=\"{form_id}\" {form_attribute}  >" . "\n";
    $bahanform .= "<div class=\"" . $page_elemen->div_class . "\">" . "\n";
    $bahanform .= $hasilrender->bahanform;
    $bahanform .= "</div>" . "\n";
    $bahanform .= "</form>" . "\n";
    $bahanform = str_replace("{form_id}", $page_elemen->id, $bahanform);
    $form_attribute = "";

    if (isset($page_elemen->attribute))
    {
        foreach ($page_elemen->attribute as $key => $value)
        {
            $form_attribute .= $key . "=\"" . $value . "\"";
        }
    }

    $bahanform = str_replace("{form_attribute}", $form_attribute, $bahanform);

    $variabeljsawal .= $hasilrender->variabeljsawal;
    $bahanawaljs .= $hasilrender->bahanawaljs;

    $content->kontenvariabelform = $kontenvariabelform;
    $content->kontenfungsivalidasi = $kontenfungsivalidasi;
    $content->bahanform = $bahanform;
    $content->bahanawaljs = $bahanawaljs;
    $content->variabeljsawal = $variabeljsawal;
    $content->copy_basejs = $copy_basejs;

    return $content;
}
function bacafile($file_address)
{
    $content = "";
    if (file_exists($file_address))
    {
        $file = fopen($file_address, "r");
        while (!feof($file))
        {
            $content .= fgets($file) . "<br />";
        }
        fclose($file);
    }
    else
    {
        echo "tak ada file $file_address <br>";
    }
    $content = str_replace("<br />", "", $content);

    return $content;
}

function json_validate($string)
{
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

function generate_auto_crud2($manifest){
$result=array();
$moduls=array();
$moduls_list=array();
$ready_moduls=array();
$page=array();
$default_moduls=array();

for($m=0; $m<count($manifest->moduls); $m++){
$themodul=$manifest->moduls[$m];
for($mp=0; $mp<count($themodul->page); $mp++){
  $thepage=$themodul->page[$mp];
  for($mpe=0; $mpe<count($thepage->elemen); $mpe++){
    $theelemen=$thepage->elemen[$mpe];
    if($theelemen->type=="auto_crud"){
      echo "ADA CRUD";
      $theelemen->modul=$themodul->id;
      $theelemen->page=$thepage->id;


                  $thepage_list_table = std_element_tabel();
                  $thepage_list_table->id="table_".$theelemen->id;
                  $thepage_list_table->title=$theelemen->title;
                  $table_column=array();
                  for($dc=0; $dc<count($theelemen->column); $dc++){
                    $table_column[]=$theelemen->column[$dc]->column;
                  }
                  $thepage_list_table->columns=$table_column;

                  $thepage->elemen[]=$thepage_list_table;

                  $thepage_add = std_page();
                  $thepage_add->id="add_".$theelemen->id."_in_".$thepage->id;
                  $thepage_add->title="add ".$theelemen->title;
                  $themodul->page[]=$thepage_add;

                  $thepage_edit = std_page();
                  $thepage_edit->id="edit_".$theelemen->id."_in_".$thepage->id;
                  $thepage_edit->title="edit ".$theelemen->title;
                  $themodul->page[]=$thepage_edit;

                  $thepage_delete = std_page();
                  $thepage_delete->id="delete_".$theelemen->id."_in_".$thepage->id;
                  $thepage_delete->title="delete ".$theelemen->title;
                  $themodul->page[]=$thepage_delete;

    }
  }

}

}


$result["moduls_list"]=$moduls;

return $result;
// end of generate_auto_crud
}

function generate_auto_crud($manifest,$auto_crud){
$result=array();
$moduls=array();
$moduls_list=array();
$page_list=array();
$api_list=array();
$default_moduls=array();

for($m=0; $m<count($manifest->moduls); $m++){
$default_moduls[]=$manifest->moduls[$m]->id;
}


for($ac=0; $ac<count($auto_crud); $ac++){
  $bahan_crud=$auto_crud[$ac];

if(!in_array($bahan_crud->modul,$default_moduls)){
if(!in_array($bahan_crud->modul,$moduls)){
$moduls[]=$bahan_crud->modul;

    $themodul = std_modul();
    $themodul->id=$bahan_crud->modul;
    $themodul->title=$bahan_crud->modul;
    $themodul->placement[]=std_place_sidemenu();
    $moduls_list[]=$themodul;

}
}

        for($bm=0; $bm<count($bahan_crud->master); $bm++){

                  $thecrud=$bahan_crud->master[$bm];
                  $thecrud->modul=$bahan_crud->modul;
                  $thecrud->page=$bahan_crud->page;

                  $thepage_list = std_page();
                  $thepage_list->id="list_".$thecrud->page;
                  $thepage_list->title="list ".$thecrud->page;
                  $thepage_list->properties_modul=$thecrud->modul;
                  $thepage_list->properties_page=$thepage_list->id;
                  $thepage_list->placement[]=std_place_sidemenu();




                  $thepage_list_table = std_element_tabel();
                  $thepage_list_table->id="table_".get_uniktabelmodulpage($thecrud,$thepage_list);
                  $thepage_list_table->title="tabel of ".$thecrud->page;
                  $table_column=array();
                  $api_process_select_column=array();
                  for($dc=0; $dc<count($thecrud->column); $dc++){
                    if(!isset($thecrud->column[$dc]->label)){
                      $thecrud->column[$dc]->label=$thecrud->column[$dc]->column;
                    }
                    if(!isset($thecrud->column[$dc]->type)){
                      $thecrud->column[$dc]->type="label";
                    }

                    $table_column[]=$thecrud->column[$dc]->label;

                    $column_text=$thecrud->column[$dc]->column;
                    $api_process_select_column[]=$column_text;
                  }
                  $api_process_select_tb_column=$api_process_select_column;
                  $api_process_select_tb_column[]="id";

                  $table_column[]="";
                  $table_column[]="";

                  $thepage_list_table->columns=$table_column;

                  $link_head=std_link_head();
                  $link_head->modul=$thecrud->modul;
                  $link_head->page="add_".$thecrud->page;
                  $link_head->label="Tambah";

                  $thepage_list_table->link->head[]=$link_head;


                  $thepage_add = std_page();
                  $thepage_add->id="add_".$thecrud->page;
                  $thepage_add->title="add ".$thecrud->page;
                  $thepage_add->properties_modul=$thecrud->modul;
                  $thepage_add->properties_page=$thepage_add->id;

                  $form_element_add=std_element_form();
                  $form_element_add->id="element_form_".$thecrud->table;
                  $form_element_add->title="Form ".$thecrud->page;

                  $api_param_insert=array();
                  $api_process_param_insert=array();
                  $api_process_array_data_insert=array();
                  $api_process_insert_on_loop=array();

                  $form_add=std_form();
                  $form_add->table=$thecrud->table;
                  $form_add->id="form_add_".get_uniknamemodulpage($thecrud->page,$thepage_list);
                  $form_add->title="Form ".$thecrud->page;
                  $form_add->properties_modul=$thecrud->modul;
                  $form_add->properties_page=$thepage_add->id;

                  for($dcf=0; $dcf<count($thecrud->field_add->field); $dcf++){
                    $thefield=$thecrud->field_add->field[$dcf];
                    $thefield->properties_modul=$form_add->properties_modul;
                    $thefield->properties_page=$form_add->properties_page;

                    if(!isset($thefield->type)){
                      $thefield->type="textfield";
                    }
                    $text_field=std_form_general_field_with_validation($thefield);

                    $form_add->field[]=$text_field;


                    $std_api_param_insert = new \stdClass();
                    $std_api_param_insert->name=$thefield->field;
                    if($thefield->type=="textfield"){
                      $std_api_param_insert->mandatory=true;
                    }else{
                      $std_api_param_insert->mandatory=false;
                    }


                    if($thefield->type=="textfield"){
                    $api_param_insert[]=$std_api_param_insert;

                    $std_api_process_param_insert = new \stdClass();
                    $std_api_process_param_insert->var_name="param_api_".$thefield->field;
                    $api_process_param_insert[]=$std_api_process_param_insert;

                    $std_api_array_data_insert = new \stdClass();
                    $std_api_array_data_insert->index=$thefield->field;
                    $std_api_array_data_insert->operator="=";
                    $std_api_array_data_insert->value=$std_api_process_param_insert;

                    $api_process_array_data_insert[]=$std_api_array_data_insert;
                    }else if($thefield->type=="image_upload"){
                      $std_process_upload=std_fileupload();
                      $std_process_upload->field="param_api_".$thefield->field;
                      $std_process_upload->file_name="foto_".$thefield->field;

                      $stdparam = std_variable();
                      $stdparam->var_name="param_api_".$thefield->field;
                      $std_process_upload->runifnotnull[]=$stdparam;
                      $std_process_upload->param[]=$stdparam;

                      $api_process_insert_on_loop[]=$std_process_upload;


                      $api_param_insert[]=$std_api_param_insert;

                      $std_api_process_param_insert = new \stdClass();
                      $std_api_process_param_insert->var_name="data_file_param_api_".$thefield->field."_filename";
                      $api_process_param_insert[]=$std_api_process_param_insert;

                      $std_api_array_data_insert = new \stdClass();
                      $std_api_array_data_insert->index=$thefield->field;
                      $std_api_array_data_insert->operator="=";
                      $std_api_array_data_insert->value=$std_api_process_param_insert;

                      $api_process_array_data_insert[]=$std_api_array_data_insert;

                    }

                  }

                  $submitbutton=std_form_field_button();
                  $submitbutton->id="submit_button_".get_uniknamemodulpage($thecrud->page,$thepage_list);
                  $submitbutton->label="Insert";
                  $submitbutton->properties_modul=$form_add->properties_modul;
                  $submitbutton->properties_page=$form_add->properties_page;


                  $apishooter_insert=std_form_js_api_shooter_auto_insert_update("insert_data",$thecrud->table,$thecrud->modul,$thecrud->page,$thecrud->field_add->field,$form_add,$thecrud);


                  $callfunctiononenter=std_form_js_callfunction();
                  $function_uplad_data_name="upload_data_".get_uniktabelmodulpage($thecrud,$thepage_add);

                  $callfunctiononenter->func_name=$function_uplad_data_name;

                  $submitbutton->listeners[]=std_form_general_submit($form_add,$apishooter_insert,"onclick");

                  $form_add->field[]=$submitbutton;


                  $form_add->listeners[]=std_form_general_submit($form_add,$callfunctiononenter,"onEnter");

                  //echo var_dump($form_add->listeners)." ADA ENTER<BR>";

                  $listenOnLoad=std_form_listener_onload();

                  $apishooter_retrieve=std_form_js_api_shooter_auto_retrieve("retrieve_data",$thecrud,$thepage_list);

                  $listenOnLoad->functions[]=$apishooter_retrieve;
                  $thepage_list_table->listeners[]=$listenOnLoad;

                  $thepage_list->elemen[]=$thepage_list_table;

                  $form_element_add->forms[]=$form_add;
                  $thepage_add->elemen[]=$form_element_add;


                  $std_api_insert = std_api();
                  $std_api_insert->modul="insert_data";
                  $std_api_insert->action="insert_data".get_uniknamemodulpage($thecrud->page,$thepage_add);
                  $std_api_insert->param=$api_param_insert;
                  $std_api_insert->response_output="{hasil_insert".$thecrud->table."}";

                  $std_process_insert = std_process_table();
                  $std_process_insert->table_name=$thecrud->table;
                  $std_process_insert->execute="execute";
                  $std_process_insert->process_name="insert";
                  $std_process_insert->param=$api_process_param_insert;
                  $std_process_insert->array_data=$api_process_array_data_insert;
                  $std_process_insert->outputVariable="hasil_insert".$thecrud->table;

                  $std_api_insert->process=$api_process_insert_on_loop;
                  $std_api_insert->process[]=$std_process_insert;

                  $api_list[]=$std_api_insert;


                  $std_api_retrieve = std_api();
                  $std_api_retrieve->modul="retrieve_data";
                  $std_api_retrieve->action="retrieve_data".get_uniktabelmodulpage($thecrud,$thepage_list);
                  $std_api_retrieve->response_output="[{hasil_retrieve".$thecrud->table."}]";
                  $std_api_retrieve->response_type="json";

                  $std_process_retrieve = std_process_table();
                  $std_process_retrieve->table_name=$thecrud->table;
                  $std_process_retrieve->execute="many";
                  $std_process_retrieve->process_name="select";
                  $std_process_retrieve->output_generate="table_column";
                  $std_process_retrieve->array_data=$api_process_select_tb_column;
                  $std_process_retrieve->outputVariable="hasil_retrieve".$thecrud->table;
                  $std_process_retrieve->output=array();
                  $std_process_retrieve->output_divider=",";
                  for($sd=0; $sd<count($thecrud->column); $sd++){

                    //echo var_dump($api_process_select_column[$sd])."DADADA";
                    switch($thecrud->column[$sd]->type){
                      case "label":
                      $std_api_output = new \stdClass();
                      $std_api_output->type = "variable";
                      $std_api_output->value = new \stdClass();
                      $std_api_output->value->var_name="qhasil_retrieve".$thecrud->table;
                      //$std_api_output->value->index=array("bakso");
                      $std_api_output->value->index[]=$thecrud->column[$sd]->column;
                      $std_process_retrieve->output[]=$std_api_output;
                      break;
                      case "image":
                      $std_api_output = new \stdClass();
                      $std_api_output->type = "image";
                      $std_api_output->label = "gambar";
                      $std_api_output->image = "{cais_public_assets_uploads}/v{'var_name':'qhasil_retrieve".$thecrud->table."','index':['".$thecrud->column[$sd]->column."']}v";

/**
                      $srcimage = std_variable();
                      $srcimage->var_name="qhasil_retrieve".$thecrud->table;
                      //$std_api_output->value->index=array("bakso");
                      $srcimage->index[]=$api_process_select_column[$sd];
                      $std_api_output->src = $srcimage;
                      **/

                      $std_process_retrieve->output[]=$std_api_output;
                      break;
                    }
                  }
                  $std_api_output_link_edit = new \stdClass();
                  $std_api_output_link_edit->type = "link";
                  $std_api_output_link_edit->label = "Edit";
                  $std_api_output_link_edit->attribute = new \stdClass();
                  $std_api_output_link_edit->attribute->class="table_link";
                  $std_api_output_link_edit->image="{cais_public_assets_uploads}/edit_icon.png";
                  $std_api_output_link_edit->href="{cais_public_url}/admin/".$thecrud->modul."/edit_".$thecrud->page."/id/v{'var_name':'qhasil_retrieve".$thecrud->table."','index':['id']}v";

                  $std_process_retrieve->output[]=$std_api_output_link_edit;

                  $std_api_output_link_delete = new \stdClass();
                  $std_api_output_link_delete->type = "link";
                  $std_api_output_link_delete->label = "Delete";
                  $std_api_output_link_delete->attribute = new \stdClass();
                  $std_api_output_link_delete->attribute->class="table_link";
                  $std_api_output_link_delete->image="{cais_public_assets_uploads}/delete_icon.png";
                  $std_api_output_link_delete->href="{cais_public_url}/admin/".$thecrud->modul."/delete_".$thecrud->page."/id/v{'var_name':'qhasil_retrieve".$thecrud->table."','index':['id']}v";


                  $std_process_retrieve->output[]=$std_api_output_link_delete;

                  $std_api_retrieve->process[]=$std_process_retrieve;


                  $api_list[]=$std_api_retrieve;


                  $thepage_edit = std_page();
                  $thepage_edit->id="edit_".$thecrud->page;
                  $thepage_edit->title="edit ".$thecrud->page;
                  $thepage_edit->properties_modul=$thecrud->modul;
                  $thepage_edit->properties_page=$thepage_edit->id;

                  $form_element_edit=std_element_form();
                  $form_element_edit->id="element_form_".$thecrud->table;
                  $form_element_edit->title="Form ".$thecrud->page;

                  $api_param_update=array();
                  $api_process_param_update=array();
                  $api_process_array_data_update=array();
                  $api_process_wherearray_data_update=array();
                  $api_process_update_on_loop=array();

                  $form_edit=std_form();
                  $form_edit->table=$thecrud->table;
                  $form_edit->id="form_edit_".get_uniknamemodulpage($thecrud->page,$thepage_edit);
                  $form_edit->title="Form ".$thecrud->page;
                  $form_edit->properties_modul=$thepage_edit->properties_modul;
                  $form_edit->properties_page=$thepage_edit->properties_page;

                  $api_process_select_one_edit_page=array();

                  for($dcf=0; $dcf<count($thecrud->field_edit->field); $dcf++){
                    $thefield=$thecrud->field_edit->field[$dcf];
                    $thefield->properties_modul=$form_edit->properties_modul;
                    $thefield->properties_page=$form_edit->properties_page;

                    if(!isset($thefield->type)){
                      $thefield->type="textfield";
                    }

                    $text_field=std_form_general_field_with_validation($thefield);

                    $form_edit->field[]=$text_field;


                    $std_api_param_update = new \stdClass();
                    $std_api_param_update->name=$thefield->field;
                    if($thefield->type=="textfield"){
                      $std_api_param_update->mandatory=true;
                    }else{
                      $std_api_param_update->mandatory=false;
                    }

                    if($thefield->type=="textfield"){
                    $api_param_update[]=$std_api_param_update;

                    $std_api_process_param_update = new \stdClass();
                    $std_api_process_param_update->var_name="param_api_".$thefield->field;
                    $api_process_param_update[]=$std_api_process_param_update;

                    $std_api_array_data_update = new \stdClass();
                    $std_api_array_data_update->index=$thefield->field;
                    $std_api_array_data_update->operator="=";
                    $std_api_array_data_update->value=$std_api_process_param_update;

                    $api_process_array_data_update[]=$std_api_array_data_update;
                    }else if($thefield->type=="image_upload"){

                      $std_process_retrieve_for_delete = std_process_table();
                      $std_process_retrieve_for_delete->table_name=$thecrud->table;
                      $std_process_retrieve_for_delete->execute="one";
                      $std_process_retrieve_for_delete->process_name="select";
                      $std_process_retrieve_for_delete->output_generate="auto";
                      $std_process_retrieve_for_delete->array_data[]=$thefield->field;
                      $std_process_retrieve_for_delete->outputVariable="data_diri_".$thecrud->table;

                      $std_process_retrieve_for_delete_where = new \stdClass();
                      $std_process_retrieve_for_delete_where->index="id";
                      $std_process_retrieve_for_delete_where->operator="=";

                      $std_process_retrieve_for_delete_where_value = new \stdClass();
                      $std_process_retrieve_for_delete_where_value->var_name="param_api_".$thecrud->page.$form_edit->properties_modul.$form_edit->properties_page."_id";

                      $std_process_retrieve_for_delete_where->value=$std_process_retrieve_for_delete_where_value;
                      $std_process_retrieve_for_delete->param[]=$std_process_retrieve_for_delete_where_value;
                      $std_process_retrieve_for_delete->where[]=$std_process_retrieve_for_delete_where;

                      $api_process_update_on_loop[]=$std_process_retrieve_for_delete;


                      $std_process_upload=std_fileupload();
                      $std_process_upload->field="param_api_".$thefield->field;
                      $std_process_upload->file_name="foto_".$thefield->field;

                      $stdparam = std_variable();
                      $stdparam->var_name="param_api_".$thefield->field;

                      $stdparamdatadiri = std_variable();
                      $stdparamdatadiri->var_name="data_diri_".$thecrud->table;


                      $std_process_upload->runifnotnull[]=$stdparam;
                      $std_process_upload->runifnotnull[]=$stdparamdatadiri;
                      $std_process_upload->param[]=$stdparam;

                      $api_process_update_on_loop[]=$std_process_upload;

                      $stdparamfiledelete = std_variable();
                      $stdparamfiledelete->var_name="data_diri_".$thefield->field."_filename";

                      $stdparamfiledeleteindex = std_variable();
                      $stdparamfiledeleteindex->var_name="data_diri_".$thecrud->table;
                      $stdparamfiledeleteindex->index[]=$thefield->field;

                      $std_process_file_delete=std_filedelete();
                      $std_process_file_delete->file_name=$stdparamfiledeleteindex;

                      $stdparamdelete = std_variable();
                      $stdparamdelete->var_name="data_file_param_api_".$thefield->field."_filename";
                      $std_process_file_delete->runifnotnull[]=$stdparamdelete;

                      $api_process_update_on_loop[]=$std_process_file_delete;


                      $api_param_update[]=$std_api_param_update;

                      $std_api_process_param_update = new \stdClass();
                      $std_api_process_param_update->var_name="data_file_param_api_".$thefield->field."_filename";
                      $api_process_param_update[]=$std_api_process_param_update;

                      $std_api_array_data_update = new \stdClass();
                      $std_api_array_data_update->index=$thefield->field;
                      $std_api_array_data_update->operator="=";
                      $std_api_array_data_update->value=$std_api_process_param_update;

                      $api_process_array_data_update[]=$std_api_array_data_update;

                    }

                    $api_process_select_one_edit_page[]=$thefield->field;
                  }


                  $std_api_param_update = new \stdClass();
                  $std_api_param_update->name=$thecrud->page.$form_edit->properties_modul.$form_edit->properties_page."_id";
                  $std_api_param_update->mandatory=true;

                  $api_param_update[]=$std_api_param_update;

                  $std_api_process_param_update = new \stdClass();
                  $std_api_process_param_update->var_name="param_api_".$thecrud->page.$form_edit->properties_modul.$form_edit->properties_page."_id";
                  $api_process_param_update[]=$std_api_process_param_update;

                  $std_api_wherearray_data_update = new \stdClass();
                  $std_api_wherearray_data_update->index="id";
                  $std_api_wherearray_data_update->operator="=";
                  $std_api_wherearray_data_update->value=$std_api_process_param_update;

                  $api_process_wherearray_data_update[]=$std_api_wherearray_data_update;


                  $submitbutton_update=std_form_field_button();
                  $submitbutton_update->id="submit_button_edit".get_uniknamemodulpage($thecrud->page,$form_edit);
                  $submitbutton_update->label="Update";
                  $submitbutton_update->properties_modul=$form_edit->properties_modul;
                  $submitbutton_update->properties_page=$form_edit->properties_page;


                  $apishooter_update=std_form_js_api_shooter_auto_insert_update("update_data",$thecrud->table,$thecrud->modul,$thecrud->page,$thecrud->field_edit->field,$form_edit,$thecrud);


                  $callfunctiononenter=std_form_js_callfunction();
                  $function_uplad_data_name="upload_data_".get_uniktabelmodulpage($thecrud,$thepage_edit);
                  $callfunctiononenter->func_name=$function_uplad_data_name;

                  $submitbutton_update->listeners[]=std_form_general_submit($form_edit,$apishooter_update,"onclick");

                  $form_edit->field[]=$submitbutton_update;


                  $form_edit->listeners[]=std_form_general_submit($form_edit,$callfunctiononenter,"onEnter");

                  $std_api_update = std_api();
                  $std_api_update->modul="update_data";
                  $std_api_update->action="update_data".get_uniknamemodulpage($thecrud->page,$thepage_edit);
                  $std_api_update->param=$api_param_update;
                  $std_api_update->response_output="{hasil_update".$thecrud->table."}";

                  $std_process_update = std_process_table();
                  $std_process_update->table_name=$thecrud->table;
                  $std_process_update->execute="execute";
                  $std_process_update->process_name="update";
                  $std_process_update->param=$api_process_param_update;
                  $std_process_update->array_data=$api_process_array_data_update;
                  $std_process_update->outputVariable="hasil_update".$thecrud->table;
                  $std_process_update->where=$api_process_wherearray_data_update;

                  $std_api_update->process=$api_process_update_on_loop;
                  $std_api_update->process[]=$std_process_update;

                  $api_list[]=$std_api_update;



                  $std_url_catcher = std_url_catcher();
                  $std_url_catcher->catch="id";
                  $std_url_catcher->variable=get_uniktabelmodulpage($thecrud,$thepage_edit)."_id";

                  $thepage_edit->process[]=$std_url_catcher;




                  $std_process_retrieve = std_process_table();
                  $std_process_retrieve->table_name=$thecrud->table;
                  $std_process_retrieve->execute="one";
                  $std_process_retrieve->process_name="select";
                  $std_process_retrieve->output_generate="auto";
                  $std_process_retrieve->array_data=$api_process_select_one_edit_page;
                  $std_process_retrieve->outputVariable="data_diri_".$thecrud->table;

                  $std_process_retrieve_where = new \stdClass();
                  $std_process_retrieve_where->index="id";
                  $std_process_retrieve_where->operator="=";

                  $std_process_retrieve_where_value = new \stdClass();
                  $std_process_retrieve_where_value->var_name=get_uniktabelmodulpage($thecrud,$thepage_edit)."_id";

                  $std_process_retrieve_where->value=$std_process_retrieve_where_value;
                  $std_process_retrieve->param[]=$std_process_retrieve_where_value;
                  $std_process_retrieve->where[]=$std_process_retrieve_where;

                  for($dcf=0; $dcf<count($thecrud->field_edit->field); $dcf++){

                    $std_value= new \stdClass();
                    $std_value->var_name="data_diri_".$thecrud->table;
                    $std_value->index=array($thecrud->field_edit->field[$dcf]->field);

                    if($thecrud->field_edit->field[$dcf]->type=="textfield"){
                    $form_edit->field[$dcf]->value=$std_value;
                    }else if($thecrud->field_edit->field[$dcf]->type=="edit_image_upload"){
                    $form_edit->field[$dcf]->src=$std_value;
                    }else if($thecrud->field_edit->field[$dcf]->type=="image_upload"){
                    $form_edit->field[$dcf]->src=$std_value;
                  }

                  }

                  $form_element_edit->forms[]=$form_edit;
                  $thepage_edit->elemen[]=$form_element_edit;

                  $thepage_edit->process[]=$std_process_retrieve;


                  $thepage_delete = std_page();
                  $thepage_delete->id="delete_".$thecrud->page;
                  $thepage_delete->title="delete ".$thecrud->page;
                  $thepage_delete->properties_modul=$thecrud->modul;
                  $thepage_delete->properties_page=$thepage_delete->id;

                  $form_element_delete=std_element_form();
                  $form_element_delete->id="element_form_".$thecrud->table;
                  $form_element_delete->title="Form ".$thecrud->page;

                  $api_param_delete=array();
                  $api_process_param_delete=array();
                  $api_process_array_data_delete=array();
                  $api_process_wherearray_data_delete=array();

                  $form_delete=std_form();
                  $form_delete->table=$thecrud->table;
                  $form_delete->id="form_delete_".get_uniknamemodulpage($thecrud->page,$thepage_delete);
                  $form_delete->title="Form ".$thecrud->page;
                  $form_delete->properties_modul=$thepage_delete->properties_modul;
                  $form_delete->properties_page=$thepage_delete->properties_page;

                  $api_process_select_one_delete_page=array();

                  for($dcf=0; $dcf<count($thecrud->field_delete->field); $dcf++){
                    $thefield=$thecrud->field_delete->field[$dcf];
                    $thefield->properties_modul=$form_delete->properties_modul;
                    $thefield->properties_page=$form_delete->properties_page;

                    if(!isset($thefield->type)){
                      $thefield->type="textfield";
                    }

                    $text_field=std_form_general_field_with_validation($thefield);
                    $text_field->validation=array();

                    $text_field->attribute->disabled="disabled";
                    $form_delete->field[]=$text_field;

                    $api_process_select_one_delete_page[]=$thefield->field;
                  }

                  $submitbutton_delete=std_form_field_button();
                  $submitbutton_delete->id="submit_button_delete".get_uniknamemodulpage($thecrud->page,$thepage_delete);
                  $submitbutton_delete->label="Confirm Delete";
                  $submitbutton_delete->properties_modul=$form_delete->properties_modul;
                  $submitbutton_delete->properties_page=$form_delete->properties_page;


                  $apishooter_delete=std_form_js_api_shooter_auto_insert_update("delete_data",$thecrud->table,$thecrud->modul,$thecrud->page,$thecrud->field_delete->field,$form_delete,$thecrud);


                  $callfunctiononenter=std_form_js_callfunction();
                  $function_delete_data="upload_data_".get_uniktabelmodulpage($thecrud,$thepage_delete);
                  $callfunctiononenter->func_name=$function_delete_data;

                  $submitbutton_delete->listeners[]=std_form_general_submit($form_delete,$apishooter_delete,"onclick");

                  $form_delete->field[]=$submitbutton_delete;


                  $form_delete->listeners[]=std_form_general_submit($form_delete,$callfunctiononenter,"onEnter");


                  $std_url_catcher = std_url_catcher();
                  $std_url_catcher->catch="id";
                  $std_url_catcher->variable=get_uniktabelmodulpage($thecrud,$thepage_delete)."_id";

                  $std_process_retrieve = std_process_table();
                  $std_process_retrieve->table_name=$thecrud->table;
                  $std_process_retrieve->execute="one";
                  $std_process_retrieve->process_name="select";
                  $std_process_retrieve->output_generate="auto";
                  $std_process_retrieve->array_data=$api_process_select_one_delete_page;
                  $std_process_retrieve->outputVariable="data_diri_".$thecrud->table;

                  $std_process_retrieve_where = new \stdClass();
                  $std_process_retrieve_where->index="id";
                  $std_process_retrieve_where->operator="=";

                  $std_process_retrieve_where_value = new \stdClass();
                  $std_process_retrieve_where_value->var_name=get_uniktabelmodulpage($thecrud,$thepage_delete)."_id";

                  $std_process_retrieve_where->value=$std_process_retrieve_where_value;
                  $std_process_retrieve->param[]=$std_process_retrieve_where_value;
                  $std_process_retrieve->where[]=$std_process_retrieve_where;


                  for($dcf=0; $dcf<count($thecrud->field_delete->field); $dcf++){

                    $std_value= new \stdClass();
                    $std_value->var_name="data_diri_".$thecrud->table;
                    $std_value->index=array($thecrud->field_delete->field[$dcf]->field);

                    $form_delete->field[$dcf]->value=$std_value;
                  }

                  $form_element_delete->forms[]=$form_delete;
                  $thepage_delete->elemen[]=$form_element_delete;

                  $thepage_delete->process[]=$std_url_catcher;
                  $thepage_delete->process[]=$std_process_retrieve;

                  $std_api_process_param_delete = new \stdClass();
                  $std_api_process_param_delete->var_name="param_api_".$thecrud->page.$form_delete->properties_modul.$form_delete->properties_page."_id";
                  $api_process_param_delete[]=$std_api_process_param_delete;

                  $std_api_wherearray_data_delete = new \stdClass();
                  $std_api_wherearray_data_delete->index="id";
                  $std_api_wherearray_data_delete->operator="=";
                  $std_api_wherearray_data_delete->value=$std_api_process_param_delete;

                  $api_process_wherearray_data_delete[]=$std_api_wherearray_data_delete;



                  $std_api_param_delete = new \stdClass();
                  $std_api_param_delete->name=$thecrud->page.$form_delete->properties_modul.$form_delete->properties_page."_id";
                  $std_api_param_delete->mandatory=true;

                  $api_param_delete[]=$std_api_param_delete;

                  $std_api_delete = std_api();
                  $std_api_delete->modul="delete_data";
                  $std_api_delete->action="delete_data".get_uniknamemodulpage($thecrud->page,$thepage_delete);
                  $std_api_delete->param=$api_param_delete;
                  $std_api_delete->response_output="{hasil_delete".$thecrud->table."}";

                  $std_process_delete = std_process_table();
                  $std_process_delete->table_name=$thecrud->table;
                  $std_process_delete->execute="execute";
                  $std_process_delete->process_name="delete";
                  $std_process_delete->param=$api_process_param_delete;
                  $std_process_delete->array_data=$api_process_array_data_update;
                  $std_process_delete->outputVariable="hasil_delete".$thecrud->table;
                  $std_process_delete->where=$api_process_wherearray_data_delete;

                  $std_api_delete->process[]=$std_process_delete;

                  $api_list[]=$std_api_delete;


                  $page_list[]=$thepage_list;
                  $page_list[]=$thepage_add;
                  $page_list[]=$thepage_edit;
                  $page_list[]=$thepage_delete;
        }



}
//echo "jum dada".count($page_list)."<BR>";
$result["moduls_list"]=$moduls_list;
$result["page_list"]=$page_list;
$result["api_list"]=$api_list;

return $result;
// end of generate_auto_crud
}

function create_crud(){



  //end of create_crud
}

function get_fungsi_name_new($modul, $page, $enginetype, $enginebody, $tambahan)
{
    $additional_name = "";
    //$ar_fungsi = $_SESSION['ar_fungsi'];
    switch ($enginetype)
    {
        case "table":
            $additional_name = $enginebody->process_name . "_" . $enginebody->table_name;
        break;
    }

    $arcekcaller = array();
    $arcekcaller["modul"] = $modul;
    $arcekcaller["page"] = $page;
    $arcekcaller["table"] = $enginebody->table_name;
    $arcekcaller["process_name"] = $enginebody->process_name;
    $arcekcaller["process"] = $enginebody;
    //$arcekcaller["func_name"]="";
    $ar_body_caller_with_name = $_SESSION['ar_fungsi_caller'];

    $thename = "Go_" . $enginetype . "_for_modul_" . $modul . "_page_" . $page . "_" . $additional_name;
    $thename = "";
    for ($a = 0;$a < count($ar_body_caller_with_name);$a++)
    {
        //var_dump($arcekcaller);
        //echo "<BR><BR>";
        //var_dump($ar_body_caller_with_name[$a]);
        //echo "<BR><BR><BR>";
        if ($ar_body_caller_with_name[$a]["thecaller"] == $arcekcaller)
        {
            $thename = $ar_body_caller_with_name[$a]["func_name"];
            //echo "ada cek ".$ar_body_caller_with_name[$a]["func_name"]."<BR>";
            //var_dump($arcekcaller);

        }
        else
        {
            //echo "tak ada cek <br>";
            //var_dump($arcekcaller);
            //  echo "<br><br><br>";

        }
    }

    $hasilreturn = $thename;
    $dapatengine = 0;

    /**
     for($a=0; $a<count($ar_fungsi); $a++){
     if($ar_fungsi[$a]["enginetype"]==$enginetype){
     $dapatengine=1;
     $dapatmodul=0;
     //  var_dump($ar_fungsi[$a]["modul"][0]["modul"]);
     for($m=0; $m<count($ar_fungsi[$a]["modul"]); $m++){
     if($ar_fungsi[$a]["modul"][$m]["modul"]==$modul){
     $dapatmodul=1;
     $dapatpage=0;
     for($p=0; $p<count($ar_fungsi[$a]["modul"][$m]["page"]); $p++){
     if($ar_fungsi[$a]["modul"][$m]["page"][$p]["page"]==$page){
     $dapatpage=1;
     $thepage=$ar_fungsi[$a]["modul"][$m]["page"][$p];
     $dapat=0;
     //  echo count($thepage["name_list"])."<BR>";
     while($dapat==0){
     for($n=0; $n<count($thepage["name_list"]); $n++){
     //  echo $thepage["name_list"][$n]["body"]->id."<BR>";
     //echo json_encode($enginebody)."<BR>";
     if($thepage["name_list"][$n]["body"]==$enginebody){
     $dapat=1;
     $hasilreturn=$thepage["name_list"][$n]["function_name"];
     break;
     }
     }
     if($dapat==0){
     $bisapasang=1;
     for($n=0; $n<count($thepage["name_list"]); $n++){
     if($thepage["name_list"][$n]["function_name"]==$thename){
     $thename.=rand(1,1000);
     $bisapasang=0;
     break;
     }
     }
     if($bisapasang==1){
     $objbaru=array();
     $objbaru["function_name"]=$thename;
     $objbaru["body"]=$enginebody;
     $ar_fungsi[$a]["modul"][$m]["page"][$p]["name_list"][]=$objbaru;
     $hasilreturn=$thename;
     $dapat=1;
     }
     }
     }
     }
     }
     if($dapatpage==0){
     $objbaru=array("page"=>$page,"name_list"=>array(array("function_name"=>$thename,"body"=>$enginebody)));
     $ar_fungsi[$a]["modul"][$m]["page"][]=$objbaru;
     //  echo "GADA ".$modul." page ".$page;
     $hasilreturn=$thename;
     }
     }
     }
     if($dapatmodul==0){
     //  echo "GADA ".$modul." ".$thename;
     $objbaru=array("modul"=>$modul,"page"=>array(array("page"=>$page,"name_list"=>array(array("function_name"=>$thename,"body"=>$enginebody)))));
     $ar_fungsi[$a]["modul"][]=$objbaru;
     $hasilreturn=$thename;
     }
     }
     }
     if($dapatengine==0){
     //  echo "GADA enginetype ".$enginetype;
     $objbaru=array("enginetype"=>$enginetype,"modul"=>array(array("modul"=>$modul,"page"=>array(array("page"=>$page,"name_list"=>array(array("function_name"=>$thename,"body"=>$enginebody)))))));
     $ar_fungsi[]=$objbaru;
     $hasilreturn=$thename;
     }
     *
     */
    //echo count($ar_fungsi)."<BR>";
    $objreturn = new \stdClass();

    $objreturn->function_name = $hasilreturn;
    //$objreturn->ar_fungsi=$ar_fungsi;
    //$_SESSION['ar_fungsi']=$ar_fungsi;
    return $objreturn;

    //akhir get_fungsi_name_new

}

function rekursifcekurlcatcher($process)
{
    $daf_url_catcher = array();
    //echo "DIPANGGIL";
    //echo "api ".$page_name."<BR>";
    $tulisankode = json_encode($process);
    if (strpos("tes" . $tulisankode . "tes", "url_catcher"))
    {
        foreach ($process as $pro)
        {
            if (is_array($pro))
            {
                $hasilrekursif = rekursifcekurlcatcher($pro);
                $daf_url_catcher = array_merge($daf_url_catcher, $hasilrekursif);
            }
            elseif (is_object($pro))
            {
                if (isset($pro->type))
                {
                    if ($pro->type == "url_catcher")
                    {
                        $bahancatch = array(
                            "catch" => $pro->catch,
                            "variable" => $pro->variable
                        );
                        $daf_url_catcher[] = $bahancatch;
                    }
                }
                $hasilrekursif = rekursifcekurlcatcher($pro);
                $daf_url_catcher = array_merge($daf_url_catcher, $hasilrekursif);
            }
            else
            {
                //$category->properties_modul="NAMA MODUL";

            }
        }
    }
    return $daf_url_catcher;
    //akhir rekursifcekurlcatcher

}
function rekursifdafVariable($isiprocess)
{
    $dafVariable = array();
    foreach ($isiprocess as $pro)
    {
        //echo "TERPANGGIL";
        if (is_array($pro))
        {
            //echo $key."<BR>";
            //$dafVariable=array_merge($dafVariable,renderwhattodo($key,$category,$isitoproses));
            $dafVariable = array_merge($dafVariable, rekursifdafVariable($pro));
        }
        elseif (is_object($pro))
        {
            //echo $key."<BR>";
            if (isset($pro->outputVariable))
            {
                $dafVariable[] = $pro->outputVariable;
            }
            $dafVariable = array_merge($dafVariable, rekursifdafVariable($pro));
        }
        else
        {
        }
    }
    return $dafVariable;
}
function rekursifcekinclude($kodenya, $filedirection)
{
    $daf_stringinclude = array();
    //echo "DIPANGGIL";
    //echo "api ".$page_name."<BR>";
    $tulisankode = json_encode($kodenya);
    if (strpos("tes" . $tulisankode . "tes", "include_file"))
    {
        foreach ($kodenya as $category)
        {
            $tulisancat = json_encode($category);
            if (is_array($category))
            {
                $hasilrekursif = rekursifcekinclude($category, $filedirection);
                $daf_stringinclude = array_merge($daf_stringinclude, $hasilrekursif);
            }
            elseif (is_object($category))
            {
                if (isset($category->type))
                {
                    if ($category->type == "include_file")
                    {
                        //  echo "ADA INCLUDE ".$category->include."\n";
                        $isijsonfile = bacafile($filedirection . $category->include);
                        if (strlen($isijsonfile) > 0)
                        {
                            $tulisancat = json_encode($category);
                            //    echo "ISI INCLUDE ".$isijsonfile."\n";
                            //      echo "ISI tulisancat ".$tulisancat."\n";
                            $bahanreplace = array(
                                "from" => $tulisancat,
                                "to" => $isijsonfile
                            );
                            $daf_stringinclude[] = $bahanreplace;
                            $calonobj = json_decode($isijsonfile);
                            $category = $calonobj;
                        }
                    }
                }
                $hasilrekursif = rekursifcekinclude($category, $filedirection);
                $daf_stringinclude = array_merge($daf_stringinclude, $hasilrekursif);
            }
            else
            {
                //$category->properties_modul="NAMA MODUL";

            }
        }
    }
    return $daf_stringinclude;
}

function rekursifmodulpage($arnya, $con_name, $page_name, $compileto)
{
    //echo "DIPANGGIL";
    //echo "api ".$page_name."<BR>";
    foreach ($arnya as $category)
    {
        if (is_array($category))
        {
            rekursifmodulpage($category, $con_name, $page_name, $compileto);
        }
        elseif (is_object($category))
        {
            $category->properties_modul = $con_name;
            $category->properties_page = $page_name;
            $category->properties_compileto = $compileto;
            rekursifmodulpage($category, $con_name, $page_name, $compileto);
        }
        else
        {
            //$category->properties_modul="NAMA MODUL";

        }
    }
}

function rekursifcekfunction($arnya, $modul_id, $page_id)
{
    //echo "DIPANGGIL";
    //echo "api ".$page_name."<BR>";
    $ar_func = array();
    $tulisankode = json_encode($arnya);
    if (strpos("tes" . $tulisankode . "tes", "func_type"))
    {
        foreach ($arnya as $category)
        {
            if (is_array($category))
            {
                $hasilrekursif = rekursifcekfunction($category, $modul_id, $page_id);
                $ar_func = array_merge($ar_func, $hasilrekursif);
            }
            elseif (is_object($category))
            {
                if (isset($category->func_type))
                {
                    if ($category->func_type != "callfunction")
                    {
                        $category->modul_id = $modul_id;
                        $category->page_id = $page_id;
                        $func = create_web_function($category);
                        $ar_func[] = $func;
                    }
                }
                $hasilrekursif = rekursifcekfunction($category, $modul_id, $page_id);
                $ar_func = array_merge($ar_func, $hasilrekursif);
            }
            else
            {
                //$category->properties_modul="NAMA MODUL";

            }
        }
        //echo "ADA NIH \n";

    }
    //akhir rekursifcekfunction
    return $ar_func;
}

function concept_tree_mapping($manifest)
{
    foreach ($manifest as $key => $category)
    {
        if (is_array($category))
        {
            foreach ($category as $objcat)
            {
                if (is_object($objcat))
                {
                    if (!isset($objcat->scannedkey))
                    {
                        $objcat->scannedkey = array();
                    }
                    $objcat->scannedkey[] = $key;
                    if (isset($manifest->scannedkey))
                    {
                        $objcat->scannedkey = array_merge($objcat->scannedkey, $manifest->scannedkey);
                    }
                }
            }

            concept_tree_mapping($category);
        }
        elseif (is_object($category))
        {
            //echo $key."<BR>";
            if (!isset($category->scannedkey))
            {
                $category->scannedkey = array();
            }
            if (!is_int($key))
            {
                //$category->scannedkey[]=$key;

            }

            concept_tree_mapping($category);
        }
        else
        {
            //echo "tambah key ".$key." ".$category."<BR>";

        }
    }
}

function rekursifprosesmodulpage($isitoproses, $controller_name, $model_name)
{
    $ar_worktodo = array();
    foreach ($isitoproses as $key => $category)
    {
        if (is_array($category))
        {
            //echo $key."<BR>";
            $ar_worktodo = array_merge($ar_worktodo, renderwhattodo($key, $category, $isitoproses));
            $ar_worktodo = array_merge($ar_worktodo, rekursifprosesmodulpage($category, $controller_name, $model_name));
        }
        elseif (is_object($category))
        {
            //echo $key."<BR>";
            $ar_worktodo = array_merge($ar_worktodo, renderwhattodo($key, $category, $isitoproses));
            $ar_worktodo = array_merge($ar_worktodo, rekursifprosesmodulpage($category, $controller_name, $model_name));
        }
        else
        {
        }
    }
    return $ar_worktodo;
}

function renderwhattodo($key, $obj, $bodyawal)
{
    $ar_worktodo = array();
    $key = (string)$key;
    if ($key == "process")
    {
        if (isset($bodyawal->func_name))
        {
            //echo "key ".$bodyawal->func_name."<BR>";

        }
        //var_dump($bodyawal)."<BR>";
        $grupengine = render_grup_engine((object)$bodyawal);
        for ($iw = 0;$iw < count($grupengine->ar_worktodo);$iw++)
        {
            if (isset($grupengine->ar_worktodo[$iw]["fortop"]))
            {
                switch ($grupengine->ar_worktodo[$iw]["fortop"])
                {
                    case "untukatas":
                        if (isset($bodyawal->func_name))
                        {
                            $grupengine->ar_worktodo[$iw]["ignore"] = false;
                            //echo "ADAATAS".$bodyawal->func_name;
                            $grupengine->ar_worktodo[$iw]["function_id"] = "function_" . $bodyawal->func_name;
                            //$ar_worktodo[$iw]["content"]="ASDASD";

                        }
                    break;
                    case "fileatas":
                        if (isset($bodyawal->table_name))
                        {
                            $grupengine->ar_worktodo[$iw]["ignore"] = false;
                            //echo "fileatas".$bodyawal->table_name;
                            $grupengine->ar_worktodo[$iw]["file_id"] = "tabel_" . $bodyawal->table_name;
                            $grupengine->ar_worktodo[$iw]["work_id"] = "includes_" . $bodyawal->table_name . "_to_" . $grupengine->ar_worktodo[$iw]["namatabel"];
                            //$grupengine->ar_worktodo[$iw]["content"]=create_text_include_model("model_tabel_".$bodyawal->table_name);
                            //$ar_worktodo[$iw]["content"]="ASDASD";

                        }
                    break;
                }
            }
        }
        $ar_worktodo = array_merge($ar_worktodo, $grupengine->ar_worktodo);
        //print($grupengine->deklarasi)."<BR>";
        //echo $obj->title;
        //echo "<BR>";

    }

    return $ar_worktodo;
}

function replacemasal($ar_replace, $konten)
{
    $content = $konten;
    foreach ($ar_replace as $key => $value)
    {
        $content = str_replace($key, $value, $content);
        //echo "replace ".$key." dengan ".$value."<BR>";

    }
    return $content;
}

function get_web_field($field)
{
    $content = new \stdClass();
    $namafiletheme = "";
    if (!isset($field->theme))
    {
        $field->theme = "normal";
    }
    $namafiletheme = $field->type . "_theme_" . $field->theme;
    $requested_html = $_SESSION['caisconfig_' . $_SESSION['config_type']]->requested_html;
    //    var_dump($requested_html);
    //echo $namafiletheme;
    $isicontent = "";
    for ($r = 0;$r < count($requested_html);$r++)
    {
        if ($requested_html[$r]["key"] == "form_field")
        {
            if ($requested_html[$r]["name"] == $namafiletheme)
            {
                $isicontent = bacafile($requested_html[$r]["file"]);

                if (strlen($isicontent) == 0)
                {
                    echo "kosong field " . $namafiletheme . " " . $requested_html[$r]["file"] . " " . $isicontent;
                }
                break;
            }
        }
    }

    $isijs = "";
    $varjsawal = "";
    $attribute = "";
    $namavariablefield = "";
    if (!isset($field->variable))
    {
        $namavariablefield = "isian_" . $field->id;
        $field->variable = $namavariablefield;
    }
    else
    {
        $namavariablefield = $field->variable;
    }
    if ($field->type != "select" && $field->type != "select2")
    {
        // echo $namavariablefield;
        $varjsawal .= "var " . $namavariablefield . " = null;\n";
    }
    if (isset($field->attribute))
    {
        foreach ($field->attribute as $key => $value)
        {
            $attribute .= $key . "=\"" . $value . "\"";
        }
    }
    $requested_html = $_SESSION['caisconfig_' . $_SESSION['config_type']]->requested_html;
    //    var_dump($requested_html);
    //echo $namafiletheme;
    $dapetreq = false;
    for ($r = 0;$r < count($requested_html);$r++)
    {
        if ($requested_html[$r]["key"] == "form_field_js")
        {
            if ($requested_html[$r]["type"] == $field->type)
            {
                if (file_exists($requested_html[$r]["file"]))
                {
                    $dapetreq = true;
                    include ($requested_html[$r]["file"]);
                }
                break;
            }
        }
    }

    if (isset($field->listeners))
    {
        for ($lis = 0;$lis < count($field->listeners);$lis++)
        {
            $tolisten = $field->listeners[$lis];

            for ($r = 0;$r < count($requested_html);$r++)
            {
                if ($requested_html[$r]["key"] == "form_field_listener")
                {
                    if ($requested_html[$r]["listen"] == $tolisten->listen)
                    {
                        $isijs .= call_user_func($requested_html[$r]["func_name"], $field, $tolisten);
                        break;
                    }
                }
            }
        }
    }

    $isivalue = "";
    if (isset($field->value))
    {
        $tulisanvariable = create_variable_web($field->value);
        $isivalue = '<?php if(isset($' . $field
            ->value->var_name . ')){ print(' . $tulisanvariable . '); } ?>';
    }

    $isicontent = str_replace("{label}", $field->label, $isicontent);
    $isicontent = str_replace("{id}", $field->id, $isicontent);
    $isicontent = str_replace("{class}", $field->class, $isicontent);
    $isicontent = str_replace("{value}", $isivalue, $isicontent);
    $isicontent = str_replace("{attribute}", $attribute, $isicontent);
    if (isset($field->src))
    {
        $tulisanvariable = create_variable_web($field->src);
        $isicontent = str_replace("{src}", get_public_assets_directory("uploads") . "/<?php print(" . $tulisanvariable . ");?>", $isicontent);
    }

    $content->isicontent = $isicontent;
    $content->varjsawal = $varjsawal;
    $content->isijs = $isijs;
    return $content;
}
function get_web_print_option($key, $value, $selected)
{
    $result = 'print("<option value=\'".' . $key . '."\' {select}>".' . $value . '."</option>");';
    $result = str_replace("{select}", $selected, $result);
    $result = $result . "\n";
    return $result;
}

function create_web_element_dropdown($dropdown)
{
    $myObj = new \stdClass();
    $namafiletheme = "";
    if (!isset($dropdown->theme))
    {
        $dropdown->theme = "normal";
    }
    $namafiletheme = $dropdown->type . "_theme_" . $dropdown->theme;
    $select_content = "";
    $requested_html = $_SESSION['caisconfig_' . $_SESSION['config_type']]->requested_html;

    $alamatselect = "";
    for ($r = 0;$r < count($requested_html);$r++)
    {
        if ($requested_html[$r]["key"] == "form_field")
        {
            if ($requested_html[$r]["name"] == $namafiletheme)
            {
                $alamatselect = $requested_html[$r]["file"];

                break;
            }
        }
    }

    $select_content = bacafile($alamatselect);

    $option_list = "";
    if (isset($dropdown->first_option_value) && isset($dropdown->first_option_label))
    {
        $option_list .= "<?php ";
        $option_list .= get_web_print_option('"' . $dropdown->first_option_value . '"', '"' . $dropdown->first_option_label . '"', '');
        $option_list .= "?>" . "\n";
    }
    $firstloop = "";
    $contentloop = "";
    $closingloop = "";
    if (isset($dropdown->value))
    {
        $tulisanvariabledropdown = create_variable_web($dropdown->value);
        $bahankeyvalue = $dropdown
            ->value->var_name;
        if (isset($dropdown
            ->value
            ->index))
        {
            if (count($dropdown
                ->value
                ->index) > 0)
            {
                for ($cv = 0;$cv < count($dropdown
                    ->value
                    ->index);$cv++)
                {
                    $bahankeyvalue .= "_" . $dropdown
                        ->value
                        ->index[$cv];
                }
            }
        }

        if (!isset($dropdown
            ->value
            ->option_value))
        {
            $myObjcarikey = new \stdClass();
            $myObjcarikey->var_type = "variable";
            $myObjcarikey->var_name = 'key' . $bahankeyvalue;
            $dropdown
                ->value->option_value = $myObjcarikey;
        }
        if (!isset($dropdown
            ->value
            ->option_label))
        {
            $myObjcarikey = new \stdClass();
            $myObjcarikey->var_type = "variable";
            $myObjcarikey->var_name = 'value' . $bahankeyvalue;
            $dropdown
                ->value->option_label = $myObjcarikey;
        }

        $variabeloptionvalue = create_variable_web($dropdown
            ->value
            ->option_value);
        $variabeloptionlabel = create_variable_web($dropdown
            ->value
            ->option_label);

        $firstloop = 'if(isset(' . $tulisanvariabledropdown . ')){foreach(' . $tulisanvariabledropdown . ' as $key' . $bahankeyvalue . '=>$value' . $bahankeyvalue . ') {';
        $contentloop = get_web_print_option($variabeloptionvalue, $variabeloptionlabel, '');

        $closingloop = "}";
    }
    $option_list .= "<?php ";
    $option_list .= $firstloop . "\n";
    if (isset($dropdown->search))
    {
        if (!isset($dropdown->value))
        {
            //  echo "TIDAK ADA VALUE!!!!!\n";
            //  var_dump($dropdown);

        }
        else
        {
            //  echo "ADA VALUE!!!!\n";
            //  var_dump($dropdown->value);
            //    echo "\n";

        }
        $tulisanvariable = create_variable_web($dropdown->value);
        if (!isset($dropdown
            ->value
            ->equal_to))
        {
            $dropdown
                ->value->equal_to = 'key';
        }
        if (!isset($dropdown
            ->value
            ->equal_to_index))
        {
            $dropdown
                ->value->equal_to_index = array();
        }

        $tulisanvariableforeachsearch = "";
        $bahankeyvaluesearch = "";
        if (isset($dropdown
            ->search
            ->foreach))
        {
            if (!isset($dropdown
                ->search
                ->foreach
                ->var_type))
            {
                $dropdown
                    ->search
                    ->foreach->var_type = "variable";
            }
            $bahankeyvaluesearch = $dropdown
                ->search
                ->foreach->var_name;
            $tulisanvariableforeachsearch = create_variable_web($dropdown
                ->search
                ->foreach);

            if (isset($dropdown
                ->search
                ->foreach
                ->index))
            {
                if (count($dropdown
                    ->search
                    ->foreach
                    ->index) > 0)
                {
                    for ($cv = 0;$cv < count($dropdown
                        ->search
                        ->foreach
                        ->index);$cv++)
                    {
                        $bahankeyvaluesearch .= "_" . $dropdown
                            ->search
                            ->foreach
                            ->index[$cv];
                    }
                }
            }
        }
        $tulisanvariableifsearch = "null";
        if (isset($dropdown
            ->search
            ->if))
        {
            if (!isset($dropdown
                ->search
                ->if
                ->var_type))
            {
                $dropdown
                    ->search
                    ->if->var_type = "variable";
            }
            $tulisanvariableifsearch = create_variable_web($dropdown
                ->search
                ->if);
        }
        $tulisanvariablevaluesearch = "null";
        if (isset($dropdown
            ->search
            ->value))
        {
            if (!isset($dropdown
                ->search
                ->value
                ->var_type))
            {
                $dropdown
                    ->search
                    ->value->var_type = "variable";
            }
            $tulisanvariablevaluesearch = create_variable_web($dropdown
                ->search
                ->value);
        }

        if (!isset($dropdown
            ->search
            ->operator))
        {
            $dropdown
                ->search->operator = "==";
        }

        $myObjcarikey = new \stdClass();
        $myObjcarikey->var_type = "variable";
        $myObjcarikey->var_name = $dropdown
            ->value->equal_to;
        $myObjcarikey->index = $dropdown
            ->value->equal_to_index;
        $equalto = create_variable_web($myObjcarikey);

        $contentloop = '$dapatcari=0;' . "\n";
        if (isset($dropdown
            ->search
            ->foreach))
        {
            $contentloop .= 'foreach(' . $tulisanvariableforeachsearch . ' as $key' . $bahankeyvaluesearch . '=>$value' . $bahankeyvaluesearch . ') {' . "\n";
            $contentloop .= 'if (' . $tulisanvariableifsearch . ' ' . $dropdown
                ->search->operator . ' ' . $tulisanvariablevaluesearch . '){' . "\n";
            $contentloop .= '$dapatcari=1;' . "\n";
            $contentloop .= 'break;' . "\n";
            $contentloop .= '}' . "\n";
            $contentloop .= '}' . "\n";
            $closingloop = "}";
        }
        else
        {
            $contentloop .= 'if (' . $tulisanvariableifsearch . ' ' . $dropdown
                ->search->operator . ' ' . $tulisanvariablevaluesearch . '){' . "\n";
            $contentloop .= '$dapatcari=1;' . "\n";
            $contentloop .= '}' . "\n";
            $closingloop = "}";
        }

        $contentloop .= 'if ($dapatcari == 1){' . "\n";
        $contentloop .= get_web_print_option($variabeloptionvalue, $variabeloptionlabel, 'selected');
        $contentloop .= '}else{' . "\n";
        $contentloop .= get_web_print_option($variabeloptionvalue, $variabeloptionlabel, '');
        $contentloop .= '}' . "\n";
    }
    $option_list .= $contentloop . "\n";
    $option_list .= $closingloop . "\n";
    $option_list .= $closingloop . "\n";
    $option_list .= "?>";

    $select_content = str_replace("{label}", $dropdown->label, $select_content);
    $select_content = str_replace("{id}", $dropdown->id, $select_content);
    $select_content = str_replace("{option_list}", $option_list, $select_content);
    if (isset($dropdown->class))
    {
        $select_content = str_replace("{class}", $dropdown->class, $select_content);
    }
    $select_content = str_replace("<br />", "", $select_content);
    $myObj->content = $select_content;

    $select_js_content = "";
    $select_js_content_variabelawal = "";
    if (!isset($dropdown->default))
    {
        $dropdown->default = 0;
    }
    $select_js_content_variabelawal .= "var $dropdown->variable = $dropdown->default;\n";
    $select_js_content_variabelawal .= "var " . $dropdown->variable . "_textvalue = null;\n";

    $myObjFungsiSet = new \stdClass();
    $myObjFungsiSet->func_name = "set_idx_select_" . $dropdown->id;
    //$myObjFungsiSet->func_content="document.getElementById(\"".$page_elemen->dropdown[$c]->id."\").selectedIndex = nomidx;";
    $myObjFungsiSet->func_content = "$(\"select#" . $dropdown->id . "\").prop('selectedIndex', nomidx).change();";
    $myObjFungsiSet->type = "changer";
    $myObjFungsiSet->content_generate = "auto";
    $listenerset = create_web_function($myObjFungsiSet)->content;
    $listenerset = str_replace("{func_param}", "nomidx", $listenerset);
    $select_js_content .= $listenerset;

    $myObj->js_content = $select_js_content;
    $myObj->varjsawal = $select_js_content_variabelawal;
    return $myObj;

    //akhir create_web_element_dropdown

}

function create_booleancheck_web(stdClass $checkgroup)
{
    $comparing_content = "";
    $daf_var = array();
    $isset_content = "";
    if (!isset($checkgroup->operator))
    {
        $checkgroup->operator = "and";
    }

    for ($c = 0;$c < count($checkgroup->content);$c++)
    {
        if (!isset($checkgroup->content[$c]->type))
        {
            $checkgroup->content[$c]->type = "checking";
        }
        if ($checkgroup->content[$c]->type == "group")
        {
            $thegroup = create_booleancheck_web($checkgroup->content[$c]);
            $daf_var = array_merge($daf_var, $thegroup->daf_var);
            $comparing_content .= "(" . $thegroup->comparing_content . ")";
        }
        elseif ($checkgroup->content[$c]->type == "checking")
        {
            if (!isset($checkgroup->content[$c]->operator))
            {
                $checkgroup->content[$c]->operator = "==";
            }
            if (!isset($checkgroup->content[$c]
                ->value
                ->var_type))
            {
                $checkgroup->content[$c]
                    ->value->var_type = "variable";
            }
            if (!isset($checkgroup->content[$c]
                ->check
                ->var_type))
            {
                $checkgroup->content[$c]
                    ->check->var_type = "variable";
            }
            $varcheck = create_variable_web($checkgroup->content[$c]->check);
            $varvalue = create_variable_web($checkgroup->content[$c]->value);
            $comparing_content .= $varcheck . ' ' . $checkgroup->content[$c]->operator . ' ' . $varvalue . "\n";
            $daf_var[] = $varcheck;
            if ($c + 1 < count($checkgroup->content))
            {
                if ($checkgroup->operator == "and")
                {
                    $comparing_content .= " && ";
                }
                elseif ($checkgroup->operator == "or")
                {
                    $comparing_content .= " || ";
                }
            }
        }
    }
    for ($d = 0;$d < count($daf_var);$d++)
    {
        $isset_content .= "isset(" . $daf_var[$d] . ")";
        if ($d + 1 < count($daf_var))
        {
            $isset_content .= " && ";
        }
    }
    //echo $isset_content;
    $objreturn = new \stdClass();
    $objreturn->comparing_content = $comparing_content;
    $objreturn->isset_content = $isset_content;
    $objreturn->daf_var = $daf_var;
    return $objreturn;
    //akhir create_booleancheck_web

}
function get_variable_name($value)
{
    $bahankeyvalue = $value->var_name;
    if (isset($value->index))
    {
        if (count($value->index) > 0)
        {
            for ($cv = 0;$cv < count($value->index);$cv++)
            {
                $bahankeyvalue .= "_" . $value->index[$cv];
            }
        }
    }
    return $bahankeyvalue;
}
function create_variable_web($value)
{
    $tulisan_variable = "";
    $isivalue = "";
    //echo "valuenya ".var_dump($value)."\n";
    if (!isset($value->var_type))
    {
        $value->var_type = "variable";
    }
    switch ($value->var_type)
    {
        case "variable":
            $tulisan_variable = '$' . $value->var_name;
            if (isset($value->index))
            {
                if (count($value->index) > 0)
                {
                    foreach ($value->index as $in)
                    {
                        if (is_object($in))
                        {
                            $tulisan_variable .= '[' . create_variable_web($in) . ']';
                        }
                        else
                        {
                            $tulisan_variable .= '[\'' . $in . '\']';
                        }
                    }
                }
            }
            $isivalue = '<?php if(isset($' . $value->var_name . ')){ print(' . $tulisan_variable . '); } ?>';
        break;
        case "hardcode":
            $tulisan_variable = $value->var_name;
            $isivalue = $tulisan_variable;
        break;
    }
    return $tulisan_variable;
}
function get_system_directory($direktori)
{
    return "{cais_web_url}/" . $direktori;
}
function create_web_function_caller($caller)
{
    $bahanreturn = "";
    $variable_name = "";
    if (!isset($caller->func_type))
    {
        if (strlen($caller->func_name) > 0)
        {
            if (isset($caller->variable))
            {
                $variable_name = $caller->variable;
                $bahanreturn .= "var " . $variable_name . " = ";
            }
            else
            {
                $variable_name = "return_of_" . $caller->func_name;
                if (isset($caller->checkReturn))
                {
                    $bahanreturn .= "var " . $variable_name . " = ";
                }
            }

            $bahanreturn .= $caller->func_name . "(";

            if (isset($caller->param))
            {
                for ($p = 0;$p < count($caller->param);$p++)
                {
                    $bahanreturn .= $caller->param[$p];
                    if ($p < count($caller->param) - 1)
                    {
                        $bahanreturn .= ",";
                    }
                }
            }

            $bahanreturn .= ");\n";
        }
    }
    elseif (isset($caller->func_type))
    {
        $func_name = "thefunc" . rand(1, 100000);
        if (isset($caller->func_name))
        {
            if (strlen($caller->func_name) > 0)
            {
                $func_name = $caller->func_name;
            }
        }
        if (isset($caller->variable))
        {
            $variable_name = $caller->variable;
            $bahanreturn .= "var " . $variable_name . " = ";
        }
        else
        {
            $variable_name = "return_of_" . $func_name;
            if (isset($caller->checkReturn))
            {
                $bahanreturn .= "var " . $variable_name . " = ";
            }
        }

        $bahanreturn .= $func_name . "(";

        if (isset($caller->func_param))
        {
            for ($p = 0;$p < count($caller->func_param);$p++)
            {
                $bahanreturn .= $caller->func_param[$p];
                if ($p < count($caller->func_param) - 1)
                {
                    $bahanreturn .= ",";
                }
            }
        }

        $bahanreturn .= ");\n";
    }

    if (isset($caller->checkReturn))
    {
        for ($cr = 0;$cr < count($caller->checkReturn);$cr++)
        {
            $bahanreturn .= "if (" . $variable_name . " " . $caller->checkReturn[$cr]->condition . " " . $caller->checkReturn[$cr]->if . "){" . "\n";

            for ($th = 0;$th < count($caller->checkReturn[$cr]->then);$th++)
            {
                $bahanreturn .= create_web_function_caller($caller->checkReturn[$cr]->then[$th]);
                $bahanreturn .= "\n";
            }
            $bahanreturn .= "}" . "\n";
        }
    }
    return $bahanreturn;
    //akhir create_web_function_caller

}
function create_web_function($func)
{
    $objreturn = new \stdClass();
    $content = "";
    if (isset($func->variable))
    {
        $content .= "var $func->variable;\n";
    }
    $content .= "function {func_name}({func_param}){\n";
    $content .= "{content}\n";
    $content .= "}\n";
    $func_param = array();
    $func_body = "";
    $func_footer = "";
    $func_content = "";
    if (isset($func->func_content))
    {
        if (!empty($func->func_content))
        {
            $func_content = $func->func_content;
        }
    }

    if (!isset($func->content_generate))
    {
        $func->content_generate = "auto";
    }
    if ($func->content_generate == "manual")
    {
        $content = str_replace("{content}", "", $content);
    }
    else
    {
        $tipe = "";
        if (!isset($func->type))
        {
            $tipe = "normal";
        }
        else
        {
            $tipe = $func->type;
        }
        $copy_base_jsvoid = "";
        $requested_html = $_SESSION['caisconfig_' . $_SESSION['config_type']]->requested_html;

        for ($r = 0;$r < count($requested_html);$r++)
        {
            if ($requested_html[$r]["key"] == "void_script")
            {
                if ($requested_html[$r]["name"] == $tipe)
                {
                    if (file_exists($requested_html[$r]["file"]))
                    {
                        $copy_base_jsvoid = bacafile($requested_html[$r]["file"]);
                        $copy_base_jsvoid = str_replace("{func_name}", $func->func_name, $copy_base_jsvoid);
                    }
                    break;
                }
            }
        }

        $dapetreq = false;
        for ($r = 0;$r < count($requested_html);$r++)
        {
            if ($requested_html[$r]["key"] == "void_calculator")
            {
                if ($requested_html[$r]["name"] == $tipe)
                {
                    if (file_exists($requested_html[$r]["file"]))
                    {
                        $dapetreq = true;
                        include ($requested_html[$r]["file"]);
                    }
                    break;
                }
            }
        }
        if (!$dapetreq)
        {
            $func_body .= $copy_base_jsvoid;
        }

        $func_content .= $func_body . "\n" . $func_footer;
        $content = str_replace("{content}", $func_content, $content);
    }
    $func_name = "thefunc" . rand(1, 100000);
    if (isset($func->func_name))
    {
        $func_name = $func->func_name;
        $content = str_replace("{func_name}", $func->func_name, $content);
    }
    $isiarrayparam = "";
    if (count($func_param) > 0)
    {
        for ($fp = 0;$fp < count($func_param);$fp++)
        {
            $isiarrayparam .= $func_param[$fp]["name"];
            if ($fp < count($func_param) - 1)
            {
                $isiarrayparam .= ",";
            }
        }
        $content = str_replace("{func_param}", $isiarrayparam, $content);
    }
    $content = str_replace("<br />", "", $content);
    $objreturn->content = $content;
    $objreturn->func_param = $func_param;
    $objreturn->func_body = $func_body;
    $objreturn->func_name = $func_name;
    $objreturn->func_footer = $func_footer;

    return $objreturn;

    //akhir create_web_function

}

function create_web_onapireturn_listener($onapireturn)
{
    $content = "";

    for ($o = 0;$o < count($onapireturn);$o++)
    {
        $bahanlistener = create_web_function_caller($onapireturn[$o]);
        $content .= $bahanlistener . "\n";
    }

    return $content;
}

function create_unique_content($file_address, $content_to_add)
{
    $konten = "";
    $ada = false;
    if (file_exists($file_address))
    {
        $konten = bacafile($file_address);
    }
    if (!strpos("tes" . $konten . "tes", $content_to_add))
    {
        $konten .= $content_to_add . "\n";
    }

    file_put_contents($file_address, $konten);
    return $ada;
}

function get_project_url_js($modul, $page, $parameter)
{
    $linknya = get_system_directory("admin") . "/'+" . $modul . "+'/'+" . $page;
    if ($parameter == null)
    {
        $parameter = array();
    }
    $bahanparam = "";
    for ($fp = 0;$fp < count($parameter);$fp++)
    {
        $param = $parameter[$fp];
        if (!isset($param->value_type))
        {
            $param->value_type = "hardcode";
        }
        if (!isset($param->slash))
        {
            $param->slash = "/";
        }
        switch ($param->value_type)
        {
            case "hardcode":
                $param->value = "'" . $param->value . "'";
            break;
            case "variable":
                $param->value = $param->value;
            break;
        }
        switch ($param->slash)
        {
            case "/":
                $bahanparam .= "/" . $param->index . "/'+" . $param->value . "+'";
            break;
            case "?":
                $bahanparam .= "?" . $param->index . "='+" . $param->value . "+'";
            break;
            case "&":
                $bahanparam .= "&" . $param->index . "='+" . $param->value . "+'";
            break;
        }
    }
    if (count($parameter) > 0)
    {
        $linknya .= "+'" . $bahanparam . "'";
    }
    //echo $linknya;
    return $linknya;
}

function get_project_url_php($modul, $page, $parameter)
{
    $linknya = get_system_directory("admin") . "/" . $modul . "/" . $page;

    for ($fp = 0;$fp < count($parameter);$fp++)
    {
        $param = $parameter[$fp];
        if (!isset($param->value_type))
        {
            $param->value_type = "hardcode";
        }
        if (!isset($param->slash))
        {
            $param->slash = "/";
        }
        switch ($param->value_type)
        {
            case "hardcode":
                $param->value = $param->value;
            break;
            case "variable":
                $param->value = "<?php if(isset($" . $param->value . ")){ echo $" . $param->value . ";} ?>";
            break;
        }
        switch ($param->slash)
        {
            case "/":
                $linknya .= "/" . $param->index . "/" . $param->value . "";
            break;
            case "?":
                $linknya .= "?" . $param->index . "=" . $param->value . "";
            break;
            case "&":
                $linknya .= "&" . $param->index . "=" . $param->value . "";
            break;
        }
    }
    //echo $linknya;
    return $linknya;
}

function render_grup_engine(stdClass $thepage)
{
    $objreturn = new \stdClass();
    $content = "";
    $varphpawal = array();
    $varjsawal = "";
    $deklarasi = array();
    $include = array();
    $ar_worktodo = array();
    $properties_modul = $thepage->properties_modul;
    $isideklarasi = "";
    $isivarawal = "";

    $incudah = array();
    $isiinclude = "";
    //echo "nama modul ".$thepage->properties_modul."<BR><BR><BR><BR><BR>";
    $properties_page = $thepage->properties_page;
    //echo "nama page ".$properties_page."<BR><BR><BR><BR><BR>";
    $controller_nickname = "controller_" . $properties_modul;
    $page_nickname = "page_" . $properties_page;
    $page_name_controller = $page_nickname . $controller_nickname;
    if (isset($thepage->process) && count($thepage->process) > 0)
    {
        foreach ($thepage->process as $pro)
        {
            $properties_modul = $pro->properties_modul;
            $properties_page = $pro->properties_page;
            //  echo $pro->type."<BR>";
            if (isset($pro->properties_modul))
            {
                //echo "nama modul ".$pro->properties_modul."<BR><BR><BR><BR><BR>";

            }
            else
            {
                //  echo "AAA".$pro->type."<BR><BR><BR>";

            }
            $dapetmesin = 0;
            $adaawal = "";
            $adaakhir = "";
            $newcontent = "";
            if (isset($pro->runifnotnull))
            {
                if (count($pro->runifnotnull) > 0)
                {
                    $adaawal .= 'if (';
                    for ($pa = 0;$pa < count($pro->runifnotnull);$pa++)
                    {
                        if (!isset($pro->runifnotnull[$pa]->var_type))
                        {
                            $pro->runifnotnull[$pa]->var_type = "variable";
                        }
                        $adaawal .= ' ' . create_variable_web($pro->runifnotnull[$pa]) . '!=null';
                        if ($pa + 1 < count($pro->runifnotnull))
                        {
                            $adaawal .= ' &&';
                        }
                    }
                    $adaawal .= '){' . "\n";
                }
            }

            $dapetmesin = 1;
            $getengine = render_engine($pro->type, $pro, $pro, null);
            $newcontent .= $getengine->content . "\n";
            if (isset($getengine->varjsawal))
            {
                $varjsawal .= $getengine->varjsawal;
            }
            $ar_worktodo = array_merge($ar_worktodo, $getengine->ar_worktodo);

            if (isset($pro->runifnotnull))
            {
                if (count($pro->runifnotnull) > 0)
                {
                    $adaakhir .= '}' . "\n";
                }
            }

            if ($dapetmesin == 1)
            {
                $content .= $adaawal . $newcontent . $adaakhir;
                //  echo $content."<BR>";

            }
        }
        //echo "tipe ".$pro->type.$content."<BR>";
        $kasihatf = true;
        if (isset($pro->dalamgenggaman))
        {
            if ($pro->dalamgenggaman)
            {
                $kasihatf = false;
            }
        }
        if ($kasihatf)
        {
            $ar_worktodo[] = array(
                "type" => "add_to_function",
                "work_id" => "run_process_" . $pro->type . "_in_function_" . $properties_page . "_in_" . $properties_modul,
                "function_id" => "function_" . $page_name_controller,
                "content" => $content . "\n"
            );
        }
        //echo "function_id "."function_".$page_name_controller."<BR>";
        //  echo "run process "."run_process_".$pro->type."_in_function_".$properties_page."_in_".$properties_modul." content ".$content."<BR>";


        for ($d = 0;$d < count($include);$d++)
        {
            if (!in_array($include[$d], $incudah))
            {
                $incudah[] = $include[$d];
                $isiinclude .= $include[$d];
            }
        }

        $dekudah = array();
        for ($d = 0;$d < count($deklarasi);$d++)
        {
            if (!in_array($deklarasi[$d], $dekudah))
            {
                $dekudah[] = $deklarasi[$d];
                $isideklarasi .= $deklarasi[$d];
            }
        }

        $varudah = array();
        for ($d = 0;$d < count($varphpawal);$d++)
        {
            if (!in_array($varphpawal[$d], $varudah))
            {
                $varudah[] = $varphpawal[$d];
                $isivarawal .= $varphpawal[$d];
            }
        }
    }
    /**
     if(isset($pro->process)){
     $grupengine=render_grup_engine($pro);
     $ar_worktodo=array_merge($ar_worktodo,$grupengine->ar_worktodo);
     $content.=$grupengine->content;
     $isideklarasi.=$grupengine->deklarasi;
     echo "IYA ADA ".$grupengine->varphpawal;
     }
     *
     */

    $objreturn->content = $content;
    $objreturn->varjsawal = $varjsawal;
    $objreturn->deklarasi = $isideklarasi;
    $objreturn->varphpawal = $isivarawal;
    $objreturn->include = $incudah;
    $objreturn->ar_worktodo = $ar_worktodo;

    return $objreturn;
    //akhir render_grup_engine

}

function render_engine($type, $engine, $pro, $action)
{
    $objreturn = new \stdClass();
    $content = "";
    $varjsawal = "";
    $include = array();
    $deklarasi = array();
    $varphpawal = array();
    $ar_worktodo = array();
    $properties_modul = $pro->properties_modul;
    $properties_page = $pro->properties_page;
    $controller_nickname = "controller_" . $properties_modul;
    $page_nickname = "page_" . $properties_page;
    $page_name_controller = $page_nickname . $controller_nickname;
    $work_id = "";

    //echo "prop ".$pro->properties_modul." page ".$pro->properties_page."<BR>";
    $objrender = call_user_func("func_process_" . $type, $engine, $pro, $action);
    $content = $objrender->content;
    $varjsawal = $objrender->varjsawal;
    $deklarasi = $objrender->deklarasi;
    $varphpawal = $objrender->varphpawal;
    $include = $objrender->include;
    $ar_worktodo = $objrender->ar_worktodo;

    $objreturn->content = $content;
    $objreturn->varjsawal = $varjsawal;
    $objreturn->deklarasi = $deklarasi;
    $objreturn->varphpawal = $varphpawal;
    $objreturn->include = $include;
    $objreturn->ar_worktodo = $ar_worktodo;
    //echo "kerja nyata ".count($objreturn->ar_worktodo)."<BR>";
    //akhir render_engine
    return $objreturn;
}
