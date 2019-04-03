<?php
function formatrupiah($data)
{
    $cekanya = number_format($data, 0, ',', '.');
    return $cekanya;
}
function create_web_loop($param)
{
    $content = "for (" . $param . "){" . "\n";
    $content .= "{content}" . "\n";
    $content .= "}" . "\n";

    return $content;
}
function get_db_pointer($a)
{
    $bahanreturn = "";
    if (is_object($a))
    {
        if (isset($a->raw))
        {
            $bahanreturn .= 'DB::raw("' . $a->raw . '")';
        }
    }
    else
    {
        $bahanreturn .= '"' . $a . '"';
    }
    return $bahanreturn;
}

function create_web_variable($var_data)
{
    $var_name = '$' . $var_data->name;
    $content = $var_name . '=';
    switch ($var_data->type)
    {
        case "array":
            $content .= 'array();' . "\n";
            for ($c = 0;$c < count($var_data->content);$c++)
            {
                $content .= $var_name . '[\'' . $var_data->content[$c]->index . '\']="' . $var_data->content[$c]->value . '";' . "\n";

            }

        break;
    }
    return $content;
}

function create_database_proses($table, $table_name)
{

    $objreturn = new \stdClass();
    $content = "";
    $content .= '$data' . $table->outputVariable . '=array();' . "\n";
    $varphpawal = array();
    $varphpawal[] = '$' . $table->outputVariable . ';' . "\n";
    $ar_worktodo = array();
    switch ($table->process_name)
    {
        case "insert":
            foreach ($table->array_data as $a)
            {
                if (!isset($a
                    ->value
                    ->var_type))
                {
                    $a
                        ->value->var_type = "variable";
                }
                $content .= '$data' . $table->outputVariable . '[' . get_db_pointer($a->index) . ']=' . create_variable_web($a->value) . ';' . "\n";
            }
            $content .= '$result_for_' . $table->outputVariable . ' = DB::table(\'' . $table_name . '\')' . "\n";

        break;
        case "update":
            foreach ($table->array_data as $a)
            {
                if (!isset($a
                    ->value
                    ->var_type))
                {
                    $a
                        ->value->var_type = "variable";
                }
                $content .= '$data' . $table->outputVariable . '[' . get_db_pointer($a->index) . ']=' . create_variable_web($a->value) . ';' . "\n";
            }
            $content .= '$result_for_' . $table->outputVariable . ' = DB::table(\'' . $table_name . '\')' . "\n";

        break;
        case "select":
            foreach ($table->array_data as $a)
            {
                $content .= '$data' . $table->outputVariable . '[]=' . get_db_pointer($a) . ';' . "\n";

            }
            //$content .= '$result_for_' . $table->outputVariable . ' = DB::table(\'' . $table_name . '\')' . "\n";
            $content .= '$result_for_' . $table->outputVariable . ' = $obj_entity_factory_tabel_' . $table_name . '\')' . "\n";
            if (isset($table->distinct))
            {
                if ($table->distinct == true)
                {
                    $content .= '->distinct()';
                }
            }
        break;
        case "delete":
            $content .= '$result_for_' . $table->outputVariable . ' = DB::table(\'' . $table_name . '->getArrayArray($datahasil_get_hotel_images,$wherearraytb_images_hotel);' . "\n";

        break;
        case "bridge":
            //$content.='$databridgeright'.$table->outputVariable.'=array();'."\n";
            //$content.='$databridgeright'.$table->outputVariable.'[]="'.$table->right_table_id.'";'."\n";
            if (!isset($table->left_id))
            {
                if (!isset($table
                    ->left_id
                    ->var_type))
                {
                    $table
                        ->left_id->var_type = "variable";
                }
            }
            if (!isset($table->right_array))
            {
                if (!isset($table
                    ->right_array
                    ->var_type))
                {
                    $table
                        ->right_array->var_type = "variable";
                }
            }
            $content .= '$result_for_' . $table->outputVariable . ' = DB::table(\'' . $table_name . '\')' . "\n";
            $content .= '-> where (\'' . $table->left_bridge_column . '\', \'=\',' . create_variable_web($table->left_id) . ')' . "\n";
            $content .= '->select(array("id","' . $table->left_bridge_column . '","' . $table->right_bridge_column . '"))' . "\n";

            $content .= '->get()->toArray();' . "\n";
            $content .= '$result_for_' . $table->outputVariable . ' = array_map(function($object){return (array) $object;}, $result_for_' . $table->outputVariable . ");\n";

        break;
    }

    switch ($table->process_name)
    {
        case "insert":
            $content .= '->insert($data' . $table->outputVariable . ');' . "\n";
        break;
        case "update":
            if (isset($table->where))
            {

                for ($s = 0;$s < count($table->where);$s++)
                {
                    $content .= '-> where (\'' . $table->where[$s]->index . '\', \'' . $table->where[$s]->operator . '\',' . create_variable_web($table->where[$s]->value) . ')' . "\n";

                }
            }
            $content .= '->update($data' . $table->outputVariable . ');' . "\n";
        break;
        case "delete":
            if (isset($table->where))
            {

                for ($s = 0;$s < count($table->where);$s++)
                {
                    $content .= '-> where (\'' . $table->where[$s]->index . '\', \'' . $table->where[$s]->operator . '\',' . create_variable_web($table->where[$s]->value) . ')' . "\n";

                }
            }
            $content .= '->delete();' . "\n";
        break;
        case "select":
            if (isset($table->join))
            {
                $bahanjoin = '-> join (\'' . $table
                    ->join->table . '\',array({isiarray}))' . "\n";
                $isiarray = "";
                for ($s = 0;$s < count($table
                    ->join
                    ->where);$s++)
                {
                    $isiarray .= '\'' . $table
                        ->join
                        ->where[$s]->index . '\' => ' . create_variable_web($table
                        ->join
                        ->where[$s]->value);
                    if ($s + 1 > count($table
                        ->join
                        ->where))
                    {
                        $isiarray .= ",";
                    }
                }
                $bahanjoin = str_replace("{isiarray}", $isiarray, $bahanjoin);
                $content .= $bahanjoin;
            }
            if (isset($table->where))
            {

                for ($s = 0;$s < count($table->where);$s++)
                {
                    $content .= '-> where (' . get_db_pointer($table->where[$s]->index) . ', \'' . $table->where[$s]->operator . '\',' . create_variable_web($table->where[$s]->value) . ')' . "\n";

                }
            }
            $content .= '->select($data' . $table->outputVariable . ')' . "\n";
            if ($table->execute == "many")
            {
                $content .= '->get()->toArray();' . "\n";
                $content .= '$result_for_' . $table->outputVariable . ' = array_map(function($object){return (array) $object;}, $result_for_' . $table->outputVariable . ");\n";
            }
            else if ($table->execute == "one")
            {
                $content .= '->first();' . "\n";
                $content .= '$result_for_' . $table->outputVariable . ' = (array) $result_for_' . $table->outputVariable . ";\n";
            }

            break;
        }

        if (isset($table->output))
        {
            switch ($table->execute)
            {
                case "many":
                    $bahan_output = "";
                    switch ($table->output_generate)
                    {
                        case "manual":
                            $table->output = str_replace("\"", "\\\"", $table->output);
                            $bahan_output = $table->output;
                        break;
                        case "table_column":
                            $isioutput = "[";

                            if (is_array($table->output))
                            {
                                for ($io = 0;$io < count($table->output);$io++)
                                {
                                    $theoutput = $table->output[$io];
                                    switch ($theoutput->type)
                                    {
                                        case "label":
                                            $isioutput .= '\"' . $theoutput->label . '\"';
                                              break;
                                            case "varvar":
                                                $isioutput .= $theoutput->label ;
                                                  break;
                                            case "variable":
                                            $isioutput .= '\"".' . create_variable_web($theoutput->value) . '."\""."';

                                        break;
                                        case "link":

                                            $bahanattribute = "";
                                            if (isset($theoutput->attribute))
                                            {
                                                foreach ($theoutput->attribute as $key => $value)
                                                {
                                                    $bahanattribute .= $key . "='" . $value . "'";
                                                }
                                            }

                                            $ledakan = (explode("properties_", $bahanattribute));

                                            for ($l = 1;$l < count($ledakan);$l++)
                                            {
                                                $subledakan = (explode("'", $ledakan[$l]));
                                                $bahanattribute = str_replace("properties_" . $subledakan[0] . "'" . $subledakan[1] . "'", "", $bahanattribute);
                                            }
                                            $isihref=$theoutput->label;
                                            if(isset($theoutput->image)){
                                              if(!isset($theoutput->width)){
                                                $theoutput->width=30;
                                              }
                                                if(!isset($theoutput->height)){
                                                  $theoutput->height=30;
                                                }
                                                $bahangambar="<img src='" . $theoutput->image . "' width='" . $theoutput->width . "px' height='" . $theoutput->height . "px' />";
                                                $isihref=$bahangambar;
                                            }
                                            $isioutput .= '\"' . "<a href='" . $theoutput->href . "' " . $bahanattribute . ">" . $isihref . "</a>" . '\"';
                                        break;
                                        case "image":

                                            $bahanattribute = "";
                                            if (isset($theoutput->attribute))
                                            {
                                                foreach ($theoutput->attribute as $key => $value)
                                                {
                                                    $bahanattribute .= $key . "='" . $value . "'";
                                                }
                                            }

                                            $ledakan = (explode("properties_", $bahanattribute));

                                            for ($l = 1;$l < count($ledakan);$l++)
                                            {
                                                $subledakan = (explode("'", $ledakan[$l]));
                                                $bahanattribute = str_replace("properties_" . $subledakan[0] . "'" . $subledakan[1] . "'", "", $bahanattribute);
                                            }

                                              if(!isset($theoutput->width)){
                                                $theoutput->width=30;
                                              }
                                                if(!isset($theoutput->height)){
                                                  $theoutput->height=30;
                                                }
                                                $bahangambar="<img src='" . $theoutput->image . "' " . $bahanattribute . " width='" . $theoutput->width . "px' height='" . $theoutput->height . "px' />";


                                            $isioutput .= '\"' . $bahangambar . '\"';
                                        break;
                                    }
                                    if ($io < count($table->output) - 1)
                                    {
                                        $isioutput .= ",";
                                    }
                                }
                            }else{
                              echo "bukan array<BR>";

                            }

                            $isioutput .= "]";
                            $table->output_generate = "manual";
                            $table->output = $isioutput;
                            $bahan_output = $table->output;
                        break;
                    }
                    $content .= '$output_content' . $table->outputVariable . '="";' . "\n";
                    $content .= '$num' . $table->outputVariable . '=0;' . "\n";
                    $content .= '$result_for_' . $table->outputVariable . ' = array_map(function($object){return (array) $object;}, $result_for_' . $table->outputVariable . ");\n";
                    $content .= 'foreach($result_for_' . $table->outputVariable . ' as $q' . $table->outputVariable . '){' . "\n";
                    $content .= '$num' . $table->outputVariable . '+=1;' . "\n";

                    if (isset($table->bridge))
                    {
                        $objproses = create_database_proses($table->bridge, $table
                            ->bridge
                            ->table);

                        $ar_worktodo = array_merge($ar_worktodo, $objproses->ar_worktodo);
                        $content .= $objproses->content;
                        $content .= 'foreach($result_for_' . $table->outputVariable . ' as $q' . $table->outputVariable . '){' . "\n";
                        $content .= '}' . "\n";
                    }

                    if (isset($table->process))
                    {
                        foreach ($table->process as $pro)
                        {

                            switch ($pro->type)
                            {

                                case "table":
                                    if (isset($table->engine))
                                    {
                                        for ($eng = 0;$eng < count($table->engine);$eng++)
                                        {
                                            if ($table->engine[$eng]->type == "table")
                                            {
                                                for ($ca = 0;$ca < count($table->engine[$eng]->content);$ca++)
                                                {
                                                    if ($table->engine[$eng]->content[$ca]->id == $pro->id)
                                                    {
                                                        $table->engine[$eng]->content[$ca]->need = "content";

                                                    }
                                                }
                                            }
                                        }
                                    }
                                break;
                            }
                        }
                        $grupengine = render_grup_engine($table);
                        $varphpawal[] = $grupengine->varphpawal;
                        $ar_worktodo = array_merge($ar_worktodo, $grupengine->ar_worktodo);
                        $content .= $grupengine->content;
                        //if($table->table_name=="tb_hotel_price_package"){
                        //  if(isset($table->inidia)){
                        //echo "ANANA".$grupengine->content;
                        //}
                        //}

                    }
                    //if($table->table_name=="tb_jem_roomtype_paketharga"){
                    //  if(isset($table->inidia)){
                    //echo "ANANA".$grupengine->content;
                    //}
                    //}
                    $ledakan = (explode("v{", $table->output));

                    $ledakan = (explode("v{", $table->output));
                    for ($l = 1;$l < count($ledakan);$l++)
                    {
                        $ledakandalam = explode("}v", $ledakan[$l]);
                        $dapatkurunganlama = "v{" . $ledakandalam[0] . "}v";
                        $ledakandalam[0] = str_replace("'", "\"", $ledakandalam[0]);
                        $dapatkurungan = "{" . $ledakandalam[0] . "}";
                        $bahanjsonledakan = json_decode($dapatkurungan);
                        $tes = $bahanjsonledakan;
                        if ($tes != null)
                        {
                            if (!isset($tes->var_type))
                            {
                                //  echo "HAHAHA".var_dump($tes);
                                $tes->var_type = "variable";
                            }
                            $bikinvar = create_variable_web($tes);
                            $dapatkurunganbaru = str_replace('"', '\"', $dapatkurungan);
                            //echo $dapatkurunganlama;
                            $bahan_output = str_replace($dapatkurunganlama, '".' . $bikinvar . '."', $bahan_output);

                        }
                        else
                        {
                            echo "alasan kosong " . $dapatkurungan;
                        }
                    }
                    //$bahan_output=str_replace("v{","",$dapatkurungan);
                    $content .= '$bahan_output' . $table->outputVariable . '="' . $bahan_output . '";' . "\n";
                    if (isset($table->output_divider))
                    {
                        if (strlen($table->output_divider) > 0)
                        {
                            $content .= 'if(count($result_for_' . $table->outputVariable . ')>$num' . $table->outputVariable . '){' . "\n";
                            $content .= '$bahan_output' . $table->outputVariable . '=$bahan_output' . $table->outputVariable . '."' . $table->output_divider . '";' . "\n";
                            $content .= '}' . "\n";
                        }
                    }

                    $content .= '$output_content' . $table->outputVariable . '.=$bahan_output' . $table->outputVariable . ';' . "\n";
                    $content .= '}' . "\n";
                    $content .= '$' . $table->outputVariable . ' = $output_content' . $table->outputVariable . ';' . "\n";

                break;
            }
        }
        else if (isset($table->to_array))
        {
            $content .= '$' . $table->outputVariable . '_array=array();' . "\n";
            //  $content.='$result_for_'.$table->outputVariable.' = array_map(function($object){return (array) $object;}, $result_for_'.$table->outputVariable.");\n";
            $content .= 'foreach($result_for_' . $table->outputVariable . ' as $key) {' . "\n";
            $content .= '$' . $table->outputVariable . '_array[$key[\'' . $table
                ->to_array->index . '\']]=$key[\'' . $table
                ->to_array->value . '\'];' . "\n";
            $content .= '}' . "\n";
            $content .= '$' . $table->outputVariable . ' = $' . $table->outputVariable . "_array;" . "\n";
        }
        else
        {
            $content .= '$' . $table->outputVariable . ' = $result_for_' . $table->outputVariable . ";" . "\n";
            if (isset($table->process_name))
            {
                if ($table->process_name == "insert")
                {
                    $content .= '$' . $table->outputVariable . '_last_id = DB::getPdo()->lastInsertId();' . "\n";
                    $content .= '$this->last_id = $' . $table->outputVariable . '_last_id;' . "\n";
                }
            }

        }
        if ($table->process_name == "bridge")
        {
            $content .= '$jum_bridge_' . $table->outputVariable . ' = count($' . $table->outputVariable . ");" . "\n";
            $content .= '$jum_right_array_' . $table
                ->right_array->var_name . ' = count(' . create_variable_web($table->right_array) . ");" . "\n";
            $content .= 'if($jum_bridge_' . $table->outputVariable . ' > $jum_right_array_' . $table
                ->right_array->var_name . '){' . "\n";
            $content .= '$bedajum_bridge_' . $table->outputVariable . ' = $jum_bridge_' . $table->outputVariable . ' - $jum_right_array_' . $table
                ->right_array->var_name . ";" . "\n";
            $content .= 'for($ib=0;$ib<count($' . $table->outputVariable . ');$ib++){' . "\n";
            $content .= 'if(!in_array($' . $table->outputVariable . '[$ib]["' . $table->right_bridge_column . '"],' . create_variable_web($table->right_array) . ')){' . "\n";
            $content .= 'DB::table(\'' . $table_name . '\')->where("id",$' . $table->outputVariable . '[$ib]["id"])->delete();' . "\n";
            $content .= '}' . "\n";
            $content .= '}' . "\n";

            $content .= '}else if($jum_bridge_' . $table->outputVariable . ' < $jum_right_array_' . $table
                ->right_array->var_name . '){' . "\n";
            $content .= '$bedajum_bridge_' . $table->outputVariable . ' = $jum_right_array_' . $table
                ->right_array->var_name . ' - $jum_bridge_' . $table->outputVariable . ";" . "\n";

            $content .= 'for($ir=0; $ir<$bedajum_bridge_' . $table->outputVariable . '; $ir++) {' . "\n";
            $content .= 'DB::table(\'' . $table_name . '\')' . "\n";
            $content .= '->insert(array("' . $table->right_bridge_column . '"=>' . create_variable_web($table->right_array) . '[$ir],"' . $table->left_bridge_column . '"=>' . create_variable_web($table->left_id) . '));' . "\n";

            $content .= '}' . "\n";

            $content .= 'for($ir=0; $ir<count($result_for_' . $table->outputVariable . '); $ir++) {' . "\n";
            $content .= 'DB::table(\'' . $table_name . '\')->where("id",$result_for_' . $table->outputVariable . '[$ir]["id"])' . "\n";
            $content .= '->update(array("' . $table->right_bridge_column . '"=>' . create_variable_web($table->right_array) . '[$bedajum_bridge_' . $table->outputVariable . '+$ir]));' . "\n";
            $content .= '}' . "\n";

            $content .= '}else{' . "\n";

            $content .= 'for($ir=0; $ir<count($result_for_' . $table->outputVariable . '); $ir++) {' . "\n";

            $content .= 'DB::table(\'' . $table_name . '\')->where("id",$result_for_' . $table->outputVariable . '[$ir]["id"])' . "\n";
            $content .= '->update(array("' . $table->right_bridge_column . '"=>' . create_variable_web($table->right_array) . '[$ir]));' . "\n";
            $content .= '}' . "\n";

            $content .= '}' . "\n";

            $content .= '$result_for_' . $table->outputVariable . ' = DB::table(\'' . $table_name . '\')' . "\n";
            $content .= '-> where (\'' . $table->left_bridge_column . '\', \'=\',' . create_variable_web($table->left_id) . ')' . "\n";
            $content .= '->select(array("id","' . $table->left_bridge_column . '","' . $table->right_bridge_column . '"))' . "\n";
            $content .= '->get()->toArray();' . "\n";
            $content .= '$result_for_' . $table->outputVariable . ' = array_map(function($object){return (array) $object;}, $result_for_' . $table->outputVariable . ");\n";

            $content .= '$' . $table->outputVariable . ' = $result_for_' . $table->outputVariable . ";" . "\n";

        }
        $objreturn->content = $content;
        $objreturn->varphpawal = $varphpawal;
        $objreturn->ar_worktodo = $ar_worktodo;
        return $objreturn;
        //end of create_database_proses

    }

    function get_public_assets_directory($direktori)
    {
        return "{cais_web_url}/public/" . $direktori;
    }

    function get_web_check_apiparam($param, $mandatory)
    {
        $content = 'if(isset($obj->' . $param . ')){' . "\n";
        $content .= '$param_api_' . $param . '=$obj->' . $param . ';' . "\n";
        $content .= '$variables[\'param_api_' . $param . '\']=$obj->' . $param . ';' . "\n";
        if ($mandatory)
        {
            $content .= '}else{' . "\n";
            $content .= '$prosesapi=0;' . "\n";
            $content .= '$error_code="001";' . "\n";
            $content .= '$error_msg="' . $param . ' tidak ada";' . "\n";
        }
        $content .= '}' . "\n";
        $varphpawal = '$param_api_' . $param . ' = null;';
        $objreturn = new \stdClass();
        $objreturn->content = $content;
        $objreturn->varphpawal = $varphpawal;
        return $objreturn;
    }
    function get_web_database_query($table)
    {
        $content = 'DB::table(\'' . $table->table_name . '\')' . "\n";
        $selected = "";
        for ($s = 0;$s < count($table->select);$s++)
        {
            $selected .= '\'' . $table->select[$s] . '\'';
            if ($s < count($table->select) - 1)
            {
                $selected .= ",";
            }
        }
        for ($s = 0;$s < count($table->where);$s++)
        {
            $content .= '-> where (\'' . $table->where[$s]->index . '\', \'' . $table->where[$s]->operator . '\',' . $table->where[$s]->value . ')' . "\n";

        }
        $content .= '->select(array(' . $selected . '))' . "\n";
        if ($table->fetch == "many")
        {
            $content .= '->get()->toArray();' . "\n";
        }
        else if ($table->fetch == "one")
        {
            $content .= '->first();' . "\n";
        }
        $content .= "\n\n";
        $content .= '$bahanreturn=array();' . "\n";
        $content .= 'foreach($query as $q){' . "\n";
        $content .= '$ret=array();' . "\n";
        for ($o = 0;$o < count($table->output);$o++)
        {
            $content .= '$bahanretret="' . $table->output[$o]->value . '";' . "\n";
            for ($s = 0;$s < count($table->select);$s++)
            {
                if (strpos("tes" . $table->output[$o]->value . "tes", $table->select[$s]))
                {
                    $content .= '$bahanretret=str_replace("{' . $table->select[$s] . '}",$q["' . $table->select[$s] . '"],$bahanretret);' . "\n";
                }
            }
            switch ($table->output[$o]->type)
            {
                case "link":
                    $content .= '$bahanretret=str_replace($bahanretret,"<a href=\"$bahanretret\">' . $table->output[$o]->label . '</a>",$bahanretret);' . "\n";

                break;
            }
            $content .= '$ret[]=$bahanretret;' . "\n";
        }
        $content .= 'foreach($q as $aa){' . "\n";
        //$content.='$ret[]=$aa;'."\n";
        $content .= '}' . "\n";
        $content .= '$bahanreturn[]=$ret;' . "\n";
        $content .= '}' . "\n";
        $content .= '$response_data=$query;' . "\n";
        //$content.='$response_data=$bahanreturn;'."\n";
        return $content;
    }

    function create_text_model_location($modelname)
    {
        return 'App\MVC_MODEL\\' . $modelname;
    }

    function create_text_model_file_location($modelname)
    {
        return "app/MVC_MODEL/" . $modelname . ".php";
    }

    function create_text_include_model($modelname)
    {
        return 'use ' . create_text_model_location($modelname) . ';' . "\n";
    }

    function create_text_upload_directory()
    {
        return 'public_path().$base_upload_directory';
    }

    function runscanning($manifest, $theconfig, $scanresource)
    {
        $objreturn = new \stdClass();
        $content = "";
        $varjsawal = "";
        $include = array();
        $deklarasi = array();
        $varphpawal = array();
        $ar_worktodo = array();
        $balikanresource = array();
        $bahansidemenu = "";
        $isiroute = "";

        $hasilrekur = rekursifscanning2($manifest, $manifest, $theconfig, $scanresource);
        $ar_worktodo = array_merge($ar_worktodo, $hasilrekur->ar_worktodo);

        if (isset($hasilrekur->balikanresource["bahansidemenu"]))
        {
            $bahansidemenu .= $hasilrekur->balikanresource["bahansidemenu"];
        }
        if (isset($hasilrekur->balikanresource["isiroute"]))
        {
            $isiroute .= $hasilrekur->balikanresource["isiroute"];
        }
        //echo "hasil route ".$isiroute."<BR>";


        $balikanresource["bahansidemenu"] = $bahansidemenu;
        $balikanresource["isiroute"] = $isiroute;
        //------------------
        //balikan
        $objreturn->content = $content;
        $objreturn->varjsawal = $varjsawal;
        $objreturn->deklarasi = $deklarasi;
        $objreturn->varphpawal = $varphpawal;
        $objreturn->include = $include;
        $objreturn->ar_worktodo = $ar_worktodo;
        $objreturn->balikanresource = $balikanresource;
        //echo "kerja nyata ".count($objreturn->ar_worktodo)."<BR>";
        //akhir runscanning
        return $objreturn;
    }

    function rekursifscanning2($manifestawal, $manifest, $theconfig, $scanresource)
    {
        $objreturn = new \stdClass();
        $content = "";
        $varjsawal = "";
        $include = array();
        $deklarasi = array();
        $varphpawal = array();
        $ar_worktodo = array();
        $balikanresource = array();
        $filedirection = $theconfig->web_localpath;
        $copy_basesidetreeview = bacafile($filedirection . "copy_base/sidemenutreeview.txt");
        $bahansidemenu = "";
        $isiroute = "";

        foreach ($manifest as $key => $category)
        {
            if (is_array($category))
            {
                $hasilrekscan = rekursifscanning2($manifestawal, $category, $theconfig, $scanresource);
                $ar_worktodo = array_merge($ar_worktodo, $hasilrekscan->ar_worktodo);
                $balikanresource = array_merge($balikanresource, $hasilrekscan->balikanresource);

                if (isset($hasilrekscan->balikanresource["bahansidemenu"]))
                {
                    $bahansidemenu .= $hasilrekscan->balikanresource["bahansidemenu"];
                }
                if (isset($hasilrekscan->balikanresource["isiroute"]))
                {
                    $isiroute .= $hasilrekscan->balikanresource["isiroute"];
                }
            }
            elseif (is_object($category))
            {
                //echo $key."<BR>";
                $hasilcekneed = array();
                $dapatarwork = array();
                switch ($category->scannedkey[0])
                {
                    case "moduls":
                        $themodul = $category;
                        if (!isset($themodul->asclass))
                        {
                            $themodul->asclass = false;
                        }
                        $controller_name = $themodul->id;
                        $bahanmenuli = "";
                        $bahantreeview = $copy_basesidetreeview;
                        $hasilcekneed = what_need_from_modul($manifestawal, $category, $theconfig, $scanresource);
                        $dapatarwork = $hasilcekneed->ar_worktodo;
                        //  echo "hasil li ".$hasilcekneed->bahanmenuli."<BR>";
                        $adagotplace = 0;
                        if (isset($hasilcekneed->bahanmenuli))
                        {
                            $bahanmenuli = $hasilcekneed->bahanmenuli;
                        }
                        $adagotplace = $hasilcekneed->adagotplace;

                        $bahantreeview = str_replace("{modul_id}", $themodul->id, $bahantreeview);
                        $bahantreeview = str_replace("{modul_title}", $themodul->title, $bahantreeview);
                        $bahantreeview = str_replace("{li}", $bahanmenuli, $bahantreeview);
                        if ($adagotplace == 1)
                        {
                            $bahansidemenu .= "\n" . '<?php if($' . $manifestawal
                                ->auth_checking->outputVariable . '["poin_auth_modul_' . $controller_name . '"] > 0){ ?>';
                            $bahansidemenu .= "\n" . $bahantreeview;
                            $bahansidemenu .= "\n" . '<?php } ?>';

                            //$bahansidemenu.="\n".$bahantreeview;

                        }

                    break;
                    case "page":
                        if ($category->scannedkey[1] == "moduls")
                        {
                            //echo "page ".$category->id."<BR>";
                            $hasilcekneed = what_need_from_page($manifestawal, $category, $theconfig, $scanresource);
                            $dapatarwork = $hasilcekneed->ar_worktodo;
                            $isiroute .= $hasilcekneed->balikanresource["isiroute"];
                            //  echo "hasil cek need ".$isiroute."<BR>";
                            //echo "hasil cek need ".$isiroute."<BR>";

                        }

                    break;
                    case "daf_api":
                        echo "dapat API " . $category->modul . "<BR>";
                        $hasilcekneed = what_need_from_daf_api($category);
                        $dapatarwork = $hasilcekneed->ar_worktodo;

                    break;
                }
                $ar_worktodo = array_merge($ar_worktodo, $dapatarwork);

                $hasilrekscan = rekursifscanning2($manifestawal, $category, $theconfig, $scanresource);
                $ar_worktodo = array_merge($ar_worktodo, $hasilrekscan->ar_worktodo);
                $balikanresource = array_merge($balikanresource, $hasilrekscan->balikanresource);
                if (isset($hasilrekscan->balikanresource["bahansidemenu"]))
                {
                    $bahansidemenu .= $hasilrekscan->balikanresource["bahansidemenu"];
                }

                if (isset($hasilrekscan->balikanresource["isiroute"]))
                {
                    $isiroute .= $hasilrekscan->balikanresource["isiroute"];
                }
            }
            else
            {
                //echo "tambah key ".$key." ".$category."<BR>";

            }
        }

        $balikanresource["bahansidemenu"] = $bahansidemenu;
        $balikanresource["isiroute"] = $isiroute;
        //------------------
        //balikan
        $objreturn->content = $content;
        $objreturn->varjsawal = $varjsawal;
        $objreturn->deklarasi = $deklarasi;
        $objreturn->varphpawal = $varphpawal;
        $objreturn->include = $include;
        $objreturn->ar_worktodo = $ar_worktodo;
        $objreturn->balikanresource = $balikanresource;
        //echo "kerja nyata ".count($objreturn->ar_worktodo)."<BR>";
        //akhir rekursifscanning2
        return $objreturn;
    }



    function rekursifsetting($manifest)
    {
        foreach ($manifest as $key => $category)
        {
            if (is_array($category))
            {

                rekursifsetting($category);
            }
            elseif (is_object($category))
            {

              switch ($category->scannedkey[0])
              {
                  case "process":

                      switch ($category->type)
                      {
                        case "catch_incoming_data":

                        if($category->properties_modul=="tabel_hotel" && $category->properties_page=="dropzone_hotel_images"){
                          if(!isset($category->catch_by)){
                            $category->catch_by="get";
                          }
                        }

                        break;
                      }

                  break;
              }

                rekursifsetting($category);
            }
            else
            {
                //echo "tambah key ".$key." ".$category."<BR>";

            }
        }
    }

?>
