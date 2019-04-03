<?php
require_once ("core/domain/factory/file_factory.php");
use core\domain\repository\projectConceptToFileIndexesInterface;
use core\domain\factory\file_factory;
use core\domain\factory\file_include_factory;
use core\domain\factory\function_content_factory;
use core\domain\factory\function_factory;
use core\domain\factory\function_declaration_factory;
use core\domain\factory\function_auth_factory;
use core\domain\factory\function_footer_factory;
use core\domain\factory\directory_factory;
use core\domain\factory\entity_function_auth;
use core\domain\factory\file_indexes_factory;
class conceptConverter implements projectConceptToFileIndexesInterface
{
    protected $theconcept;
    protected $concept_config;
    public function __construct($concept_config, $theconcept)
    {
        $this->concept_config = $concept_config;
        $this->theconcept = $theconcept;
    }
    function convertToFileIndexes()
    {

        $tellers = $this->file_teller($this->concept_config, $this->theconcept);
        $indexes = $this->file_composer($tellers["works"], $this->concept_config);
        return $indexes;
    }

    function file_teller($theconfig, $thejson)
    {
        $paket = array();
        $bahan_respon = "";
        $web_config = null;
        $generated_code = "";

        if (isset($thejson->compiler_info["teller_include"]))
        {
            for ($j = 0;$j < count($thejson->compiler_info["teller_include"]);$j++)
            {

                include $thejson->compiler_info["teller_include"][$j]["file_path_to_include"];
                $prop = $thejson->compiler_info["teller_include"][$j]["properties"];
                $propvar = $thejson->compiler_info["teller_include"][$j]["properties_equal_var"];
                if ($thejson->compiler_info["teller_include"][$j]["for"] == "config")
                {
                    echo "added config properties from teller : " . $prop . "<br>";
                    $theconfig->$prop = ($$propvar);
                }
            }
        }

        $filedirection = $theconfig->web_localpath;
        $pecahslash = explode('/', $theconfig->web_url);
        $folderakhir = "";
        for ($p = count($pecahslash) - 1;$p > 0;$p--)
        {
            //  echo "pecahslash ".$pecahslash[$p]."\n";
            if (strlen($pecahslash[$p]) > 0)
            {
                $folderakhir = $pecahslash[$p];
                break;
            }
        }
        $theconfig->web_folder = $folderakhir;
        //echo $thejson->project_config[$j]->config_type."\n";
        $ar_worktodo = array();
        $manifest = $thejson;
        echo "MAKERPATH : " . $theconfig->maker_path . "<BR>";
        //include $theconfig->maker_path;
        $isi_ar = $this->makeLaravel($manifest);
        $ar_worktodo = array_merge($ar_worktodo, $isi_ar);

        return array(
            "works" => $ar_worktodo,
            "theconfig" => $theconfig
        );
        //akhir file_teller

    }

    function file_composer($ar_worktodo, $theconfig)
    {

        $ar_files = array();
        $ar_directories = array();
        $ar_functions = array();
        $ar_file_functions = array();
        $ar_contents = array();
        $ar_declarations = array();
        $ar_function_declaration = array();
        $ar_footer = array();
        $ar_function_footer = array();
        $ar_func_content = array();
        $ar_function_content = array();
        $ar_includes = array();
        $ar_function_includes = array();
        $ar_auth = array();
        $ar_function_auth = array();
        $filedirection = $theconfig->web_localpath;

        echo "<BR><BR><BR>panjang work : " . count($ar_worktodo) . "<BR><BR><BR>";
        $finished_work_id = array();
        $exists_files_id = array();
        $exists_folder_id = array();
        $exists_files_include = array();

        $ar_canceled_work_id = array();
        for ($w = 0;$w < count($ar_worktodo);$w++)
        {
            if ($ar_worktodo[$w]["type"] == "cancelwork")
            {
                $ar_canceled_work_id[] = $ar_worktodo[$w]["cancel_work_id"];
                //echo "ADA CANCEL"."<BR>";

            }
            else
            {
                //echo "GAK ADA ".$ar_worktodo[$w]["type"]."<BR>";

            }

            if ($ar_worktodo[$w]["type"] == "add_declaration_to_function")
            {

                //echo "ADA ADF ".$ar_worktodo[$w]["work_id"]."<BR>";

            }
        }

        for ($w = 0;$w < count($ar_worktodo);$w++)
        {
            if (isset($ar_worktodo[$w]["function_id"]))
            {
                $_SESSION['index_of_' . 'footer' . '_function_' . $ar_worktodo[$w]["function_id"]] = 0;
                $_SESSION['index_of_' . 'content' . '_function_' . $ar_worktodo[$w]["function_id"]] = 0;
                $_SESSION['index_of_' . 'declaration' . '_function_' . $ar_worktodo[$w]["function_id"]] = 0;
            }
        }

        for ($w = 0;$w < count($ar_worktodo);$w++)
        {
            // echo "work_id : ".$ar_worktodo[$w]["work_id"]." type : ".$ar_worktodo[$w]["type"]."<br>";
            if ((!in_array($ar_worktodo[$w]["work_id"], $finished_work_id)) && (!in_array($ar_worktodo[$w]["work_id"], $ar_canceled_work_id)))
            {

                switch ($ar_worktodo[$w]["type"])
                {
                    case "addfile":
                        if (!in_array($ar_worktodo[$w]["file_id"], $exists_files_id))
                        {

                            $class_content = "";
                            if (!isset($ar_worktodo[$w]["content_from"]))
                            {
                                $ar_worktodo[$w]["content_from"] = "string";
                            }
                            if (!isset($ar_worktodo[$w]["autopath_content"]))
                            {
                              if (!isset($ar_worktodo[$w]["autopath_targetitem"]))
                              {
                                  $ar_worktodo[$w]["autopath_content"] =true;
                              }
                            }

                            switch ($ar_worktodo[$w]["content_from"])
                            {
                                case "file":
                                    //echo "baca file ".$ar_files[$w]["content"];
                                    if($ar_worktodo[$w]["autopath_content"]==true){

                                    if (file_exists($filedirection . $ar_worktodo[$w]["content"]))
                                    {


                                        $class_content = bacafile($filedirection . $ar_worktodo[$w]["content"]);
                                    }
                                    else
                                    {
                                        echo "tak ada file ".$filedirection . $ar_worktodo[$w]["content"] ."<br>";
                                    }

                                  }else if($ar_worktodo[$w]["autopath_targetitem"]==true){

                                    //   echo "HAHA ".$theconfig->target_items."<BR>";


                                  if (file_exists($theconfig->target_items . $ar_worktodo[$w]["content"]))
                                  {


                                      $class_content = bacafile($theconfig->target_items . $ar_worktodo[$w]["content"]);
                                  }
                                  else
                                  {
                                      echo "tak ada filer ".$theconfig->target_items . $ar_worktodo[$w]["content"] ."<br>";
                                  }

                                } else{
                                  if (file_exists($ar_worktodo[$w]["content"]))
                                  {
                                      $class_content = bacafile($ar_worktodo[$w]["content"]);
                                  }
                                  else
                                  {
                                      echo "tak ada file ".$ar_worktodo[$w]["content"] ."<br>";
                                  }
                                  }
                                break;
                                case "string":
                                    $class_content = $ar_worktodo[$w]["content"];
                                break;
                            }

                            if (isset($ar_worktodo[$w]["replaces"]))
                            {
                                for ($wr = 0;$wr < count($ar_worktodo[$w]["replaces"]);$wr++)
                                {
                                    //echo "hasil replace ".$ar_worktodo[$w]["replaces"][$wr]["search"];
                                    $class_content = str_replace($ar_worktodo[$w]["replaces"][$wr]["search"], $ar_worktodo[$w]["replaces"][$wr]["replace"], $class_content);
                                }
                            }

                            $ff = new file_factory();
                            //echo "file idnya : ".$ar_worktodo[$w]["file_id"]."<BR>";
                            $ff->create($ar_worktodo[$w]["file_id"], $ar_worktodo[$w]["location"], $class_content);
                            $ar_files[] = $ff->getFile();
                            $exists_files_id[] = $ar_worktodo[$w]["file_id"];
                        }
                    break;
                    case "addinclude":
                        if (!in_array($ar_worktodo[$w]["work_id"], $exists_files_include))
                        {
                            //echo "terjadi addinclunde ".$ar_worktodo[$w]["file_id"]."<BR>";
                            $fif = new file_include_factory();
                            $fif->create($ar_worktodo[$w]["work_id"], $ar_worktodo[$w]["file_id"], $ar_worktodo[$w]["content"]);
                            $ar_includes[] = $fif->getFileInclude();
                            $exists_files_include[] = $ar_worktodo[$w]["work_id"];
                        }
                    break;
                    case "addfunction":
                        if (!in_array($ar_worktodo[$w], $ar_functions))
                        {
                            $ar_functions[] = $ar_worktodo[$w];
                            $fif = new function_factory();
                            $fif->create($ar_worktodo[$w]["file_id"], $ar_worktodo[$w]["function_id"], $ar_worktodo[$w]["function_name"], $ar_worktodo[$w]["param"], "");
                            $ar_file_functions[] = $fif->getFunction();

                        }
                    break;
                    case "add_auth":
                        if (!in_array($ar_worktodo[$w], $ar_auth))
                        {
                            $ar_auth[] = $ar_worktodo[$w];
                            $faf = new function_auth_factory();
                            $faf->create($ar_worktodo[$w]["function_id"], $ar_worktodo[$w]["content"], $ar_worktodo[$w]["content_footer"]);
                            $ar_function_auth[] = $faf->getFunctionAuth();

                        }
                    break;
                    case "add_declaration_to_function":
                        if (!in_array($ar_worktodo[$w], $ar_declarations))
                        {
                            $ar_declarations[] = $ar_worktodo[$w];
                            $nomindexes = 0;
                            $whatoffunction = "declaration";
                            if (!isset($_SESSION['index_of_' . $whatoffunction . '_function_' . $ar_worktodo[$w]["function_id"]]))
                            {
                                $nomindexes = 0;
                            }
                            else
                            {
                                $nomindexes = $_SESSION['index_of_' . $whatoffunction . '_function_' . $ar_worktodo[$w]["function_id"]];
                            }
                            $nomindexes += 1;
                            $_SESSION['index_of_' . $whatoffunction . '_function_' . $ar_worktodo[$w]["function_id"]] = $nomindexes;

                            $faf = new function_declaration_factory();
                            $faf->create($ar_worktodo[$w]["function_id"], $ar_worktodo[$w]["content"], $nomindexes);
                            $ar_function_declaration[] = $faf->getFunctionDeclaration();

                        }
                    break;
                    case "add_footer_to_function":
                        if (!in_array($ar_worktodo[$w], $ar_footer))
                        {
                            $ar_footer[] = $ar_worktodo[$w];
                            $nomindexes = 0;
                            $whatoffunction = "footer";
                            if (!isset($_SESSION['index_of_' . $whatoffunction . '_function_' . $ar_worktodo[$w]["function_id"]]))
                            {
                                $nomindexes = 0;
                                // echo "belum ada";

                            }
                            else
                            {
                                $nomindexes = $_SESSION['index_of_' . $whatoffunction . '_function_' . $ar_worktodo[$w]["function_id"]];
                            }
                            $nomindexes += 1;
                            $_SESSION['index_of_' . $whatoffunction . '_function_' . $ar_worktodo[$w]["function_id"]] = $nomindexes;

                            $faf = new function_footer_factory();
                            $faf->create($ar_worktodo[$w]["function_id"], $ar_worktodo[$w]["content"], $nomindexes);
                            $ar_function_footer[] = $faf->getFunctionFooter();

                        }
                    break;
                    case "add_to_function":
                        if (!in_array($ar_worktodo[$w], $ar_func_content))
                        {
                            $ar_func_content[] = $ar_worktodo[$w];
                            $nomindexes = 0;
                            $whatoffunction = "content";
                            if (!isset($_SESSION['index_of_' . $whatoffunction . '_function_' . $ar_worktodo[$w]["function_id"]]))
                            {
                                $nomindexes = 0;
                            }
                            else
                            {
                                $nomindexes = $_SESSION['index_of_' . $whatoffunction . '_function_' . $ar_worktodo[$w]["function_id"]];
                            }
                            $nomindexes += 1;
                            $_SESSION['index_of_' . $whatoffunction . '_function_' . $ar_worktodo[$w]["function_id"]] = $nomindexes;

                            $faf = new function_content_factory();
                            $faf->create($ar_worktodo[$w]["function_id"], $ar_worktodo[$w]["content"], $nomindexes);
                            $ar_function_content[] = $faf->getFunctionContent();

                            //   var_dump($ar_worktodo[$w]);

                        }

                        for ($wf = 0;$wf < count($ar_functions);$wf++)
                        {
                            if ($ar_functions[$wf]["function_id"] == $ar_worktodo[$w]["function_id"])
                            {
                                //echo "ada cocok ".$ar_functions[$wf]["function_id"]."<BR>";

                            }
                            else
                            {
                                //echo "tidak cocok ".$ar_functions[$wf]["function_id"]." dengan ".$ar_worktodo[$w]["function_id"]."<BR>";

                            }
                        }
                        //echo "nambah isi fungsi";

                    break;
                    case "makedirectory":
                        if (!in_array($ar_worktodo[$w]["directory_id"], $exists_folder_id))
                        {
                            $faf = new directory_factory();
                            $faf->create($ar_worktodo[$w]["directory_id"], $ar_worktodo[$w]["location"]);

                            $ar_directories[] = $faf->getDirectory();
                            $exists_folder_id[] = $ar_worktodo[$w]["directory_id"];
                        }
                    break;
                }

                $finished_work_id[] = $ar_worktodo[$w]["work_id"];
            }
        }

        echo "<BR><BR><BR>panjang include : " . count($exists_files_include) . "<BR><BR><BR>";

        $paket = array(
            "language" => "php",
            "ar_files" => $ar_files,
            "ar_directories" => $ar_directories,
            "ar_includes" => $ar_includes,
            "ar_functions" => $ar_file_functions,
            "ar_contents" => $ar_contents,
            "ar_declarations" => $ar_declarations,
            "ar_footer" => $ar_footer,
            "ar_function_content" => $ar_function_content,
            "ar_auth" => $ar_auth,
            "theconfig" => $theconfig
        );
        //$ar_function_footer=array_reverse($ar_function_footer);
        $fif = new file_indexes_factory();
        $fif->create($ar_directories, $ar_files, $ar_includes, $ar_file_functions, $ar_function_auth, $ar_function_declaration, $ar_function_content, $ar_function_footer);

        return $fif->getFileIndexes();
        //akhir file_composer

    }

    function makeLaravel($manifest)
    {
$manifest->auto_crud=array();
$teks_manifest=json_encode($manifest,JSON_PRETTY_PRINT);
      $myfile = fopen("thejson/main_file_auto.json", "w") or die("Unable to open file!");
$txt = $teks_manifest;
fwrite($myfile, $txt);
fclose($myfile);


        include 'helper_makelaravel.php';
        include 'process/registered_process.php';
        for ($p = 0;$p < count($all_process);$p++)
        {
            echo $all_process[$p]["file"] . "<BR>";
            include "process/" . $all_process[$p]["file"];
        }
        $requested_html = $_SESSION['caisconfig_' . $_SESSION['config_type']]->requested_html;

        for ($r = 0;$r < count($requested_html);$r++)
        {
            if ($requested_html[$r]["key"] == "form_field_listener")
            {
                include ($requested_html[$r]["file"]);
            }
        }

        $theconfig = null;
        for ($j = 0;$j < count($manifest->project_config);$j++)
        {
            if ($manifest->project_config[$j]->config_type == "weblaravel")
            {
                $theconfig = $manifest->project_config[$j];
                break;
            }

        }
        $libraries_warehouse = array(
            "library_web_css",
            "library_web_js"
        );
        $filedirection = $theconfig->web_localpath;

        $base_url = $theconfig->web_url;

        $ar_worktodo = array();
        $copy_baselayout = bacafile($theconfig->target_items . "copy_base/layout_admin.blade.php");
        $copy_baseheader = bacafile($theconfig->target_items . "copy_base/inc_body_header.php");
        $copy_basefooter = bacafile($theconfig->target_items . "copy_base/inc_body_footer.php");
        $copy_basesidetreeview = bacafile($theconfig->target_items . "copy_base/sidemenutreeview.txt");
        $copy_basesideli = bacafile($theconfig->target_items . "copy_base/sidemenuli.txt");
        $copy_baseclass = bacafile($theconfig->target_items . "copy_base/class.php");

        $daf_variables = "";
        for ($i = 0;$i < count($manifest->global_variables);$i++)
        {
            $daf_variables .= create_web_variable($manifest->global_variables[$i]);
            $daf_variables .= '$variables["' . $manifest->global_variables[$i]->name . '"]=$' . $manifest->global_variables[$i]->name . ';' . "\n";
        }

        $config_system_content = bacafile($theconfig->target_items . "copy_base/config_variables.php");
        $config_system_content = str_replace("<br />", "", $config_system_content);
        $config_system_content = str_replace("{write}", $daf_variables, $config_system_content);
        //$ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfileutilvariables","file_id"=>"fileutilvariables","location"=>"utils/variables.php","content_from"=>"string","content"=>$config_system_content);
        $system_content = "";
        $config_system_content = bacafile($theconfig->target_items . "copy_base/config_system.php");
        $config_system_content = str_replace("<br />", "", $config_system_content);
        $config_system_content = str_replace("{write}", $system_content, $config_system_content);
        $ar_worktodo[] = array(
            "type" => "addfile",
            "work_id" => "addfileconfig_system",
            "file_id" => "config_system",
            "location" => "config/system.php",
            "content_from" => "string",
            "content" => $config_system_content
        );

        $config_system_content = bacafile($theconfig->target_items . "copy_base/config_database.php");
        $config_system_content = str_replace("<br />", "", $config_system_content);
        if (!isset($theconfig->database_port))
        {
            $theconfig->database_port = "3306";
        }
        $config_system_content = str_replace("{database_host}", $theconfig->database_host, $config_system_content);
        $config_system_content = str_replace("{database_port}", $theconfig->database_port, $config_system_content);
        $config_system_content = str_replace("{database_name}", $theconfig->database_name, $config_system_content);
        $config_system_content = str_replace("{database_username}", $theconfig->database_username, $config_system_content);
        $config_system_content = str_replace("{database_password}", $theconfig->database_password, $config_system_content);
        $ar_worktodo[] = array(
            "type" => "addfile",
            "work_id" => "addfileconfig_database",
            "file_id" => "config_database",
            "location" => "config/database.php",
            "content_from" => "string",
            "content" => $config_system_content
        );

        $config_system_content = bacafile($theconfig->target_items . "copy_base/env.php");
        $config_system_content = str_replace("<br />", "", $config_system_content);
        $config_system_content = str_replace("{database_host}", $theconfig->database_host, $config_system_content);
        $config_system_content = str_replace("{database_port}", $theconfig->database_port, $config_system_content);
        $config_system_content = str_replace("{database_name}", $theconfig->database_name, $config_system_content);
        $config_system_content = str_replace("{database_username}", $theconfig->database_username, $config_system_content);
        $config_system_content = str_replace("{database_password}", $theconfig->database_password, $config_system_content);
        $ar_worktodo[] = array(
            "type" => "addfile",
            "work_id" => "addfileconfig_env",
            "file_id" => "config_env",
            "location" => ".env",
            "content_from" => "string",
            "content" => $config_system_content
        );

        $bahansidemenu = "";
        /**
         echo "jum modul ".count($manifest->moduls)."<BR>";
         $daf_stringinclude=rekursifcekinclude($manifest,"");
         echo "DAF STRING INCLUDE ".count($daf_stringinclude);
         $tulisanmanifest=json_encode($manifest);
         for($i=0; $i<count($daf_stringinclude); $i++){
         $tulisanmanifest=str_replace($daf_stringinclude[$i]["from"],$daf_stringinclude[$i]["to"],$tulisanmanifest);
         }
         $manifest=json_decode($tulisanmanifest);
         *
         */
        //JSON sudah lengkap #clear #siap #ready

        for ($i = 0;$i < count($manifest->moduls);$i++)
        {

            $controller_name = $manifest->moduls[$i]->id;
            for ($j = 0;$j < count($manifest->moduls[$i]->page);$j++)
            {
                $thepage = $manifest->moduls[$i]->page[$j];
                $thepage->properties_modul = $controller_name;
                $thepage->properties_page = $thepage->id;
                $func_name = $thepage->id;

                foreach ($thepage as $category)
                {
                    if (is_array($category))
                    {
                        rekursifmodulpage($category, $controller_name, $func_name, "weblaravel");
                    }
                    else if (is_object($category))
                    {
                        $category->properties_modul = $controller_name;
                        $category->properties_page = $thepage->properties_page;
                        rekursifmodulpage($category, $controller_name, $func_name, "weblaravel");
                    }
                    else
                    {
                        //echo $category;
                        //$category->properties_modul="NAMA MODUL";

                    }
                }

            }

        }

        for ($d = 0;$d < count($manifest->daf_api);$d++)
        {
            $manifest->daf_api[$d]->modul = $manifest->daf_api[$d]->modul;
            $controller_name = $manifest->daf_api[$d]->modul;
            for ($act = 0;$act < count($manifest->daf_api[$d]->action);$act++)
            {
                $action = $manifest->daf_api[$d]->action[$act];
                $action->properties_modul = $controller_name;
                $action->properties_page = $action->action;
                //echo "properties_page : ".$action->properties_page."<BR>";
                $func_name = $action->action;

                foreach ($action as $category)
                {
                    if (is_array($category))
                    {
                        rekursifmodulpage($category, $controller_name, $func_name, "weblaravel");
                    }
                    else if (is_object($category))
                    {
                        $category->properties_modul = $controller_name;
                        $category->properties_page = $action->properties_page;
                        rekursifmodulpage($category, $controller_name, $func_name, "weblaravel");
                    }
                    else
                    {
                        //echo $category;
                        //$category->properties_modul="NAMA MODUL";

                    }
                }

            }
        }

        concept_tree_mapping($manifest);
        require_once ("needs.php");

        include ("setup_function_names.php");

        setup_database_function_name($manifest);

                $scanresource=array();
                $scanresource["sidemenuli"]=$copy_basesideli;
                $scanresource["requested_html"]=$requested_html;

        rekursifsetting($manifest);
        $hasilscan = runscanning($manifest,$theconfig,$scanresource);

        $ar_worktodo = array_merge($ar_worktodo, $hasilscan->ar_worktodo);

        $isiroute = $hasilscan->balikanresource["isiroute"];
        //echo "isi route : ".$isiroute."<BR>";

        $ar_worktodo[] = array(
            "type" => "addfile",
            "work_id" => "addfileportdatabase",
            "file_id" => "portdatabase",
            "location" => "app/MVC_MODEL/model_port_database.php",
            "content_from" => "file",
            "autopath_content" => false,
            "content" => $theconfig->target_items."copy_base/model_port_database.php"
        );

        $docsfilelocation = "resources/views/mvc_view/system_information/documentation";

        $ar_worktodo[] = array(
            "type" => "makedirectory",
            "work_id" => "makedirectorydocumentation",
            "directory_id" => "folderdocumentation",
            "location" => $docsfilelocation
        );

        $copy_baseindexmodul = bacafile($theconfig->target_items . "copy_base/frame_adminpage.php");
        $copy_basedocumentation = bacafile($theconfig->target_items . "copy_base/documentation.php");

        $isidataspage = "";
        $nomidx = 1;
        for ($i = 0;$i < count($manifest->moduls);$i++)
        {

            $controller_name = $manifest->moduls[$i]->id;
            for ($j = 0;$j < count($manifest->moduls[$i]->page);$j++)
            {
                $thepage = $manifest->moduls[$i]->page[$j];
                $func_name = $thepage->id;
                $urlroute = "/admin/" . $controller_name . "/" . $func_name;
                $isiplace = "";
                for ($pl = 0;$pl < count($manifest->moduls[$i]->page[$j]->placement);$pl++)
                {
                    $isiplace .= $manifest->moduls[$i]->page[$j]->placement[$pl]->place . ",";
                }
                $isidataspage .= "<tr>";
                $isidataspage .= "<td>" . $nomidx . "</td>";
                $isidataspage .= "<td>" . $controller_name . "</td>";
                $isidataspage .= "<td>" . $func_name . "</td>";
                $isidataspage .= "<td>" . $isiplace . "</td>";
                $isidataspage .= "</tr>";
                $nomidx += 1;
            }
        }
        $copy_basedocumentation = str_replace("{datas_page}", $isidataspage, $copy_basedocumentation);

        $isidatasapi = "";
        $nomidx = 1;
        for ($d = 0;$d < count($manifest->daf_api);$d++)
        {
            $manifest->daf_api[$d]->modul = $manifest->daf_api[$d]->modul;
            $controller_name = $manifest->daf_api[$d]->modul;
            for ($act = 0;$act < count($manifest->daf_api[$d]->action);$act++)
            {
                $action = $manifest->daf_api[$d]->action[$act];
                $action->properties_modul = $controller_name;
                $action->properties_page = $action->action;
                //echo "properties_page : ".$action->properties_page."<BR>";
                $func_name = $action->action;
                $isiparam = "";
                for ($f = 0;$f < count($action->param);$f++)
                {
                    if (!isset($action->param[$f]->mandatory))
                    {
                        $action->param[$f]->mandatory = false;
                    }

                    $isiparam .= $action->param[$f]->name . "(" . (int)$action->param[$f]->mandatory . ")" . ",";
                }
                $isidatasapi .= "<tr>";
                $isidatasapi .= "<td>" . $nomidx . "</td>";
                $isidatasapi .= "<td>" . $controller_name . "</td>";
                $isidatasapi .= "<td>" . $func_name . "</td>";
                $isidatasapi .= "<td>" . $isiparam . "</td>";
                $isidatasapi .= "<td>" . "{cais_web_url}/API" . "</td>";
                $isidatasapi .= "</tr>";
                $nomidx += 1;
            }
        }

        $copy_basedocumentation = str_replace("{datas_api}", $isidatasapi, $copy_basedocumentation);

        $bahancopy_baseindexmodul = $copy_baseindexmodul;
        $bahanpagecontent = "";
        $bahanreplacemasal = array(

            "{modul_id_page_id}" => "",
            "{modul_id}" => "",
            "{page_name}" => "Documentation | System Information"
            //,"{copy_basecss}"=>$isicopy_basecss
            ,
            "{page_title}" => "Documentation",
            "{page_subtitle}" => "Documentation",
            "{page_content}" => $copy_basedocumentation,
            "{footer_js}" => "",
            "{copy_js}" => "",
            "{modul_title}" => "",
            "<br />" => ""

        );

        $bahancopy_baseindexmodul = replacemasal($bahanreplacemasal, $bahancopy_baseindexmodul);
        $bahanreplacemasal = array();
        for ($lib = 0;$lib < count($libraries_warehouse);$lib++)
        {
            $bahanreplacemasal["{copy_base_language_" . $libraries_warehouse[$lib] . "}"] = "";
        }
        $bahancopy_baseindexmodul = replacemasal($bahanreplacemasal, $bahancopy_baseindexmodul);

        //file_put_contents($foldermvcviewpage."/index.php",$bahancopy_baseindexmodul);
        $ar_worktodo[] = array(
            "type" => "addfile",
            "work_id" => "newwritefileto" . $docsfilelocation . "/index.blade.php",
            "file_id" => "new".$docsfilelocation . "/index.blade.php",
            "location" => $docsfilelocation . "/index.blade.php",
            "content_from" => "string",
            "content" => $bahancopy_baseindexmodul
        );

        //$ar_worktodo[]=array("type"=>"addfile","work_id"=>"makefiledocumentation","directory_id"=>"filedocumentation","location"=>$docsfilelocation."/index.blade.php","content_from"=>"string","content"=>"tes tertulis");
        $config_system_content = bacafile($theconfig->target_items . "copy_base/routes_web.php");
        $config_system_content = str_replace("<br />", "", $config_system_content);
        $config_system_content = str_replace("{write}", $isiroute, $config_system_content);
        $ar_worktodo[] = array(
            "type" => "addfile",
            "work_id" => "addfileconfig_routes_web",
            "file_id" => "config_routes_web",
            "location" => "routes/web.php",
            "content_from" => "string",
            "content" => $config_system_content
        );

        $config_system_content = bacafile($theconfig->target_items . "copy_base/routes_web.php");
        $config_system_content = str_replace("<br />", "", $config_system_content);
        $config_system_content = str_replace("{write}", $isiroute, $config_system_content);
        $ar_worktodo[] = array(
            "type" => "addfile",
            "work_id" => "addfileconfig_routes_web",
            "file_id" => "config_routes_web",
            "location" => "routes/web.php",
            "content_from" => "string",
            "content" => $config_system_content
        );

        $config_system_content = bacafile($theconfig->target_items . "copy_base/config_helpers.php");
        $config_system_content = str_replace("<br />", "", $config_system_content);
        $config_system_content = str_replace("{write_variables}", $daf_variables, $config_system_content);
        $ar_worktodo[] = array(
            "type" => "addfile",
            "work_id" => "addfile_helpers",
            "file_id" => "file_helpers",
            "location" => "app/helpers.php",
            "content_from" => "string",
            "content" => $config_system_content
        );


        //var_dump($manifest);
        $bahansidemenu .= '<?php' . "\n";
        $bahansidemenu .= "\n" . '?>' . "\n";

        $bahansidemenu = $hasilscan->balikanresource["bahansidemenu"];

        $copy_baselayout = replacemasal(array(
            "{sidemenu}" => $bahansidemenu,
            "{js_functions}" => "",
            "{copy_js}" => "",
            "<br />" => ""
        ) , $copy_baselayout);
        $copy_baselayout = str_replace("<br />", "", $copy_baselayout);

        $ar_worktodo[] = array(
            "type" => "addfile",
            "work_id" => "writelayout_frame_admin",
            "file_id" => "layout_frame_admin",
            "location" => "resources/views/layouts/layout_admin.blade.php",
            "content_from" => "string",
            "content" => $copy_baselayout
        );

        return $ar_worktodo;

    }

}


?>
