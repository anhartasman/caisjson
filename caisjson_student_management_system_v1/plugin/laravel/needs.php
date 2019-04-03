<?php
echo "the needs for laravel<BR>";

function what_need_from_modul($manifest, $themodul, $theconfig, $scanresource)
{
    $objreturn=new \stdClass();
    $content="";
    $varjsawal="";
    $include=array();
    $deklarasi=array();
    $varphpawal=array();
    $ar_worktodo=array();
    $filedirection = $theconfig->web_localpath;
    $base_url = $theconfig->web_url;
    $copy_basesideli = $scanresource["sidemenuli"];

    $bahanmenuli = "";

    if (!isset($themodul->asclass)) {
        $themodul->asclass=false;
    }

    $controller_name=$themodul->id;
    //echo "controller ".$controller_name."<BR>";
    $controller_nickname="controller_".$controller_name;
    $modelfilename=$controller_nickname;
    if ($themodul->asclass) {
        $modelfilename=$controller_name;
    }

    $class_location="app/Http/Controllers/model_".$modelfilename.".php";
    $class_template_file="language_php_template_controller";
    $namespace="App\Http\Controllers";
    if ($themodul->asclass) {
        $class_template_file="language_php_template_class";
        $namespace="App\global_model";
        $class_location="app/global_model/model_".$controller_nickname.".php";
    }

    $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile".$controller_nickname,"file_id"=>$controller_nickname,"location"=>$class_location,"content_from"=>"file","autopath_content"=>false,"content"=>$theconfig->target_items."file_template/".$class_template_file.".php","replaces"=>array(array("search"=>"{namespace}","replace"=>$namespace)));

    $foldermvcview = 'resources/views/mvc_view/' . $controller_name;
    $folderlink = 'admin/' . $controller_name;

    if (!$themodul->asclass) {
        $ar_worktodo[] = array(
                      "type" => "makedirectory",
                      "work_id" => "makedirectorymvcview" . $controller_name,
                      "directory_id" => $foldermvcview,
                      "location" => $foldermvcview
                  );
    }
      if(!isset($_SESSION['objectOfModul'])){
        $_SESSION['objectOfModul']=array();
      }
      $_SESSION['objectOfModul'][$themodul->id]=$themodul;

    $adagotplace = 0;
    for ($j = 0;$j < count($themodul->page);$j++) {
        //  echo "CETAAK".$themodul->page[$j]->id."<BR>";
        //    var_dump($themodul->page[$j]->placement)."<BR>";
        $gotplace = 0;
        for ($pl = 0;$pl < count($themodul->page[$j]->placement);$pl++) {
            //echo "place ".$themodul->page[$j]->placement[$pl]->place."\n";
            if ($themodul->page[$j]->placement[$pl]->place == "sidemenu") {
                $gotplace = 1;
                $adagotplace = 1;
            }
        }
        if ($gotplace == 1) {
            //echo "ADA SIDEMENU<BR>";
            $foldermvcviewpage = $foldermvcview . '/' . $themodul->page[$j]->id;
            $folderlinkpage = $folderlink . '/' . $themodul->page[$j]->id;
            $menuli = $copy_basesideli;
            $menuli = str_replace("{modul_id_page_id}", $themodul->id . "_" . $themodul->page[$j]->id, $menuli);
            $menuli = str_replace("{page_url}", $base_url . "/" . $folderlinkpage, $menuli);
            $menuli = str_replace("{page_title}", $themodul->page[$j]->title, $menuli);

            $bahanmenuli .= "\n" . '<?php if(isset($' . $manifest
                          ->auth_checking->outputVariable . '["auth_modul_' . $controller_name . '_page_' . $themodul->page[$j]->id . '"]) && $' . $manifest
                          ->auth_checking->outputVariable . '["auth_modul_' . $controller_name . '_page_' . $themodul->page[$j]->id . '"] == 1){ ?>';
            $bahanmenuli .= "\n" . $menuli;
            $bahanmenuli .= "\n" . '<?php } ?>';
        }
    }
    //------------------
    //balikan
    $objreturn->content=$content;
    $objreturn->varjsawal=$varjsawal;
    $objreturn->deklarasi=$deklarasi;
    $objreturn->varphpawal=$varphpawal;
    $objreturn->include=$include;
    $objreturn->ar_worktodo=$ar_worktodo;
    $objreturn->bahanmenuli=$bahanmenuli;
    $objreturn->adagotplace=$adagotplace;
    //echo "kerja nyata ".count($objreturn->ar_worktodo)."<BR>";
    //akhir what_need_from_modul
    return $objreturn;
}

function what_need_from_page($manifest, $thepage, $theconfig, $scanresource)
{
    $objreturn=new \stdClass();
    $content="";
    $varjsawal="";
    $include=array();
    $deklarasi=array();
    $varphpawal=array();
    $ar_worktodo=array();
    $balikanresource=array();
    $isiroute="";

    $themodul=null;
    $filedirection = $theconfig->web_localpath;
    $requested_html = $scanresource["requested_html"];
    /**
    for ($ma=0; $ma<count($manifest->moduls); $ma++) {
        if ($manifest->moduls[$ma]->id==$thepage->properties_modul) {
            $themodul=$manifest->moduls[$ma];
            //  echo "dapet modul <BR>";
        }
    }
    **/
    $themodul=$_SESSION['objectOfModul'][$thepage->properties_modul];

    if (!isset($themodul->asclass)) {
        $themodul->asclass=false;
    }
    $controller_name=$themodul->id;
    //echo "controller ".$controller_name."<BR>";
    $controller_nickname="controller_".$controller_name;


    $page_name=$thepage->id;
    if (!isset($thepage->page_func_param)) {
        $thepage->page_func_param=array();
    }
    if (!isset($thepage->route_type)) {
        $thepage->route_type="get";
    }
    $page_nickname="page_".$page_name;
    $page_name_controller=$page_nickname.$controller_nickname;

    $auth_content="";
    $ada_auth=0;
    $pakaiauth=null;

    $urlroute = "/admin/" . $controller_name . "/" . $page_name;
    $daf_url_catcher = rekursifcekurlcatcher($thepage->process);
    for ($d = 0;$d < count($daf_url_catcher);$d++)
    {
        $urlroute .= "/" . $daf_url_catcher[$d]["catch"] . "/{" . $daf_url_catcher[$d]["catch"] . "}";
    }
    $isiroute = "Route::".$thepage->route_type."('" . $urlroute . "', ['uses'=>'model_controller_" . $controller_name . "@page_" . $page_name . "']);\n";


    $ar_worktodo[]=array("type"=>"addinclude","work_id"=>"include_".$page_nickname."_to_".$controller_nickname,"file_id"=>$controller_nickname,"include_id"=>$page_nickname,"content"=>"use App\MVC_MODEL\\model_".$page_nickname.";"."\n");
    $nameforfunc=$page_nickname;
    if ($themodul->asclass) {
        $nameforfunc=$page_name;
    }
    //echo "DAPAT DELETE ".$nameforfunc."<BR>";
    $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"function_name"=>$nameforfunc,"param"=>$thepage->page_func_param,"file_id"=>$controller_nickname);

    $bahandeklarasi="";
    if (!$themodul->asclass) {
        $bahandeklarasi.="session_start();\n";
        $namespace="App\MVC_MODEL";
        $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile".$page_nickname,"file_id"=>$page_nickname,"location"=>"app/MVC_MODEL/model_".$page_nickname.".php","content_from"=>"file","autopath_content"=>false,"content"=>$theconfig->target_items."file_template/language_php_template_class.php","replaces"=>array(array("search"=>"{namespace}","replace"=>$namespace)));
        $bahandeklarasi.='$obj_'.$page_name." = new model_page_".$page_name."();\n";
    }
    $bahandeklarasi.='$variables=getVariables();'."\n";
    $bahandeklarasi.='extract($variables);'."\n";

    $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_themodelof_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasi."\n");
    $firstfooter_content='return view("mvc_view/'.$controller_name.'/'.$page_name.'/index",compact("variables"));'."\n";

    if (isset($thepage->outputVariable)) {
        $firstfooter_content='return $'.$thepage->outputVariable.";"."\n";
    }
    if (isset($thepage->nonreturn)) {
        if ($thepage->nonreturn) {
            $firstfooter_content='';
        }
    }

    if (!$themodul->asclass) {
        $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"deklarasipreparefooter_themodelof_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>'$obj_'.$page_name.'->variables=$variables;');
    }
    $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"deklarasifooter_themodelof_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>$firstfooter_content."\n");

    foreach ($thepage as $key=>$category) {
        if (is_array($category)) {
            //echo $key."<BR>";
            $ar_worktodo=array_merge($ar_worktodo, renderwhattodo($key, $category, $thepage));
            $ar_worktodo=array_merge($ar_worktodo, rekursifprosesmodulpage($category, $controller_name, $page_name));
        } elseif (is_object($category)) {
            //echo $key."<BR>";
            $ar_worktodo=array_merge($ar_worktodo, renderwhattodo($key, $category, $thepage));
            $ar_worktodo=array_merge($ar_worktodo, rekursifprosesmodulpage($category, $controller_name, $page_name));
        } else {
        }
    }

    $foldermvcview = 'resources/views/mvc_view/' . $controller_name;

    if (1==1) {
        if (!isset($thepage->ignore)) {
            $thepage->ignore = false;
        }
        if ($thepage->ignore == false) {
            if (!isset($thepage->frame)) {
                $thepage->frame = "adminpage";
            }

            $bahanawaljs = "";
            $variabeljsawal = "";
            $copy_basejs = "";
            $arlibcss = array();
            $arlibs = array();
            //$isicopy_basecss='$copy_basecss=array();'."\n";
            $isicopy_baselanguage = array();
            for ($lib = 0;$lib < count($manifest->libraries);$lib++) {
                $thelib = $manifest->libraries[$lib];
                //var_dump($thelib);
                $isicopy_baselanguage[$thelib
                        ->language] = '$copy_base_language_' . $thelib->language . '=array();' . "\n";
            }
            for ($r = 0;$r < count($requested_html);$r++) {
                if ($requested_html[$r]["key"] == "form_field_css_insert") {
                    $isicopy_baselanguage[$requested_html[$r]["language"]] = '$copy_base_language_' . $requested_html[$r]["language"] . '=array();' . "\n";
                }
                if ($requested_html[$r]["key"] == "page_element_css_insert") {
                    $isicopy_baselanguage[$requested_html[$r]["language"]] = '$copy_base_language_' . $requested_html[$r]["language"] . '=array();' . "\n";
                }
            }

            if (isset($manifest->js_vars)) {
                for ($lib = 0;$lib < count($manifest->js_vars);$lib++) {
                    $varphp = create_variable_web($manifest->js_vars[$lib]->var);
                    $variabeljsawal .= "<?php if(isset(" . $varphp . ")){ ?>\n";
                    $variabeljsawal .= 'var ' . $manifest->js_vars[$lib]->js_var . ' = "<?php print(' . create_variable_web($manifest->js_vars[$lib]->var) . ');?>";' . "\n";
                    $variabeljsawal .= "<?php } ?>\n";
                }
            }

            $thepage = $thepage;
            $func_name = $thepage->id;
            $page_name = $thepage->id;
            $page_nickname = "page_" . $page_name;
            $page_name_controller = $page_nickname . $controller_nickname;

            $variabeljsawal .= "var page_id=\"" . $thepage->id . "\";\n";
            $variabeljsawal .= "var modul_id=\"" . $themodul->id . "\";\n";

            $foldermvcviewpage = $foldermvcview . '/' . $thepage->id;

            /**
             if (!file_exists($foldermvcviewpage)) {
             mkdir($foldermvcviewpage, 0777, true);
             }
             *
             */
            if (!$themodul->asclass) {
                $ar_worktodo[] = array(
                        "type" => "makedirectory",
                        "work_id" => "makedirectorymvcview" . $page_name_controller,
                        "directory_id" => $page_name_controller,
                        "location" => $foldermvcviewpage
                    );
            }

            if (isset($thepage->process)) {
                $grupengine = render_grup_engine($thepage);
                $variabeljsawal .= $grupengine->varjsawal;
                //akhir isset proses
            }

            $bahanpagecontent = "";
            for ($e = 0;$e < count($thepage->elemen);$e++) {
                $alamatelemenjsinsert = "";
                for ($r = 0;$r < count($requested_html);$r++) {
                    if ($requested_html[$r]["key"] == "page_element_js_insert") {
                        if ($requested_html[$r]["type"] == $thepage->elemen[$e]->type) {
                            $alamatelemenjsinsert = $requested_html[$r]["file"];
                        }
                    }
                }
                for ($r = 0;$r < count($requested_html);$r++) {
                    if ($requested_html[$r]["key"] == "page_element_css_insert") {
                        if ($requested_html[$r]["type"] == $thepage->elemen[$e]->type) {
                            if (!in_array($requested_html[$r]["language"] . $requested_html[$r]["key"] . $requested_html[$r]["type"] . $requested_html[$r]["path"], $arlibs)) {
                                $isicopy_baselanguage[$requested_html[$r]["language"]] .= '$copy_base_language_' . $requested_html[$r]["language"] . '[]=array("name"=>"' . $requested_html[$r]["type"] . '","path"=>"' . $requested_html[$r]["path"] . '");' . "\n";
                                $arlibs[] = $requested_html[$r]["language"] . $requested_html[$r]["key"] . $requested_html[$r]["type"] . $requested_html[$r]["path"];
                            }
                        }
                    }
                }
                if (file_exists($alamatelemenjsinsert)) {
                    $isicopyjs = bacafile($alamatelemenjsinsert);
                    //echo $isicopyjs;
                    $copy_basejs .= "\n" . $isicopyjs;
                }
                if (isset($thepage->elemen[$e]->forms)) {
                    for ($fm = 0;$fm < count($thepage->elemen[$e]->forms);$fm++) {
                        for ($fmf = 0;$fmf < count($thepage->elemen[$e]->forms[$fm]->field);$fmf++) {
                            $thefield = $thepage->elemen[$e]->forms[$fm]->field[$fmf];

                            for ($lib = 0;$lib < count($manifest->libraries);$lib++) {
                                $thelib = $manifest->libraries[$lib];
                                for ($l = 0;$l < count($thelib->libraries);$l++) {
                                    $thelibrary = $thelib->libraries[$l];
                                    if (!in_array($thelib->language . $thelibrary->type, $arlibs)) {
                                        if ($thelibrary->type == "field_" . $thefield->type) {
                                            $isicopy_baselanguage[$thelib
                                                    ->language] .= '$copy_base_language_' . $thelib->language . '[]=array("name"=>"' . $thelibrary->name . '","path"=>"public/"."' . $thelibrary->path . '");' . "\n";
                                            $arlibs[] = $thelib->language . $thelibrary->type;
                                        }
                                    }
                                }
                            }
                            for ($r = 0;$r < count($requested_html);$r++) {
                                if ($requested_html[$r]["key"] == "form_field_css_insert") {
                                    if ($requested_html[$r]["type"] == $thefield->type) {
                                        if (!in_array($requested_html[$r]["language"] . $requested_html[$r]["key"] . $requested_html[$r]["type"] . $requested_html[$r]["path"], $arlibs)) {
                                            $isicopy_baselanguage[$requested_html[$r]["language"]] .= '$copy_base_language_' . $requested_html[$r]["language"] . '[]=array("name"=>"' . $requested_html[$r]["type"] . '","path"=>"' . $requested_html[$r]["path"] . '");' . "\n";
                                            $arlibs[] = $requested_html[$r]["language"] . $requested_html[$r]["key"] . $requested_html[$r]["type"] . $requested_html[$r]["path"];
                                        }
                                    }
                                }
                            }

                            /**
                             if (!in_array($thefield->type, $arlibcss)){
                             for($lib=0; $lib<count($manifest->library_web_css); $lib++){
                             if($manifest->library_web_css[$lib]->type=="field_".$thefield->type){
                             $isicopy_basecss.='$copy_basecss[]=array("name"=>"'.$manifest->library_web_css[$lib]->name.'","path"=>"'.$manifest->library_web_css[$lib]->path.'");'."\n";
                             $arlibcss[]=$thefield->type;
                             }
                             }
                             }
                             *
                             */
                            $alamatfieldjsinsert = "";
                            for ($r = 0;$r < count($requested_html);$r++) {
                                if ($requested_html[$r]["key"] == "form_field_js_insert") {
                                    if ($requested_html[$r]["type"] == $thefield->type) {
                                        $alamatfieldjsinsert = $requested_html[$r]["file"];

                                        break;
                                    }
                                }
                            }

                            if (file_exists($alamatfieldjsinsert)) {
                                $isiloopjs = bacafile($alamatfieldjsinsert);
                                $copy_basejs .= "\n" . $isiloopjs;
                            } else {
                            }
                        }
                    }
                }
                $alamatfieldjsloop = "";
                for ($r = 0;$r < count($requested_html);$r++) {
                    if ($requested_html[$r]["key"] == "page_element_js_declaration") {
                        if ($requested_html[$r]["type"] == $thepage->elemen[$e]->type) {
                            $alamatfieldjsloop = $requested_html[$r]["file"];

                            break;
                        }
                    }
                }

                if (file_exists($alamatfieldjsloop)) {
                    $isiloopjs = bacafile($alamatfieldjsloop);
                    $isiloopjs = str_replace("{elemen_id}", $thepage->elemen[$e]->id, $isiloopjs);

                    $page_elemen = $thepage->elemen[$e];
                    for ($r = 0;$r < count($requested_html);$r++) {
                        if ($requested_html[$r]["key"] == "page_element_script") {
                            if ($requested_html[$r]["type"] == $thepage->elemen[$e]->type) {
                                include($requested_html[$r]["file"]);
                                break;
                            }
                        }
                    }

                    $bahanawaljs .= "\n" . $isiloopjs;
                } else {
                }
                $alamatpagelement = "";
                for ($r = 0;$r < count($requested_html);$r++) {
                    if ($requested_html[$r]["key"] == "page_element") {
                        if ($requested_html[$r]["type"] == $thepage->elemen[$e]->type) {
                            $alamatpagelement = $requested_html[$r]["file"];

                            break;
                        }
                    }
                }

                if (file_exists($alamatpagelement)) {
                    $isicontent = bacafile($alamatpagelement);
                    $page_elemen = $thepage->elemen[$e];

                    for ($r = 0;$r < count($requested_html);$r++) {
                        if ($requested_html[$r]["key"] == "page_element_script") {
                            if ($requested_html[$r]["type"] == $page_elemen->type) {
                                include($requested_html[$r]["file"]);
                                break;
                            }
                        }
                    }

                    $bahanform = "";
                    if (isset($page_elemen->forms)) {
                        $daftarform = $page_elemen->forms;
                        for ($df = 0;$df < count($daftarform);$df++) {
                            $hasilrender = render_html_form_field($daftarform[$df]);
                            $kontenvariabelform = $hasilrender->kontenvariabelform;
                            $kontenfungsivalidasi = $hasilrender->kontenfungsivalidasi;
                            $variabeljsawal .= $hasilrender->variabeljsawal;
                            $bahanawaljs .= $hasilrender->bahanawaljs;
                            $bahanform .= $hasilrender->bahanform;
                        }
                    }
                    $isicontent = str_replace("{bahanform}", $bahanform, $isicontent);

                    if (isset($page_elemen->listeners)) {
                        //echo  "ADA INI ".var_dump($page_elemen)."\n";
                        for ($lis = 0;$lis < count($page_elemen->listeners);$lis++) {
                            $tolisten = $page_elemen->listeners[$lis];

                            //echo $tolisten->listen. "ADA INI \n";
                            switch ($tolisten->listen) {
                                    case "onload":
                                        //echo "ADA INI \n";
                                        for ($c = 0;$c < count($tolisten->functions);$c++) {
                                            $bahanawaljs .= $tolisten->functions[$c]->func_name . "(";

                                            if (isset($tolisten->functions[$c]->func_param)) {
                                                for ($p = 0;$p < count($tolisten->functions[$c]->func_param);$p++) {
                                                    $bahanawaljs .= $tolisten->functions[$c]->func_param[$p];
                                                    if ($p < count($tolisten->functions[$c]->func_param) - 1) {
                                                        $bahanawaljs .= ",";
                                                    }
                                                }
                                            }
                                            $bahanawaljs .= ");\n";
                                        }
                                    break;
                                }
                        }
                    } else {
                        //  echo "GAK ADA \n";
                    }

                    if (isset($page_elemen->attribute)) {
                        $bahanattribute = "";

                        foreach ($page_elemen->attribute as $key => $value) {
                            $bahanattribute .= $key . "=\"" . $value . "\"";
                        }
                        $isicontent = str_replace("{elemen_attribute}", $bahanattribute, $isicontent);
                    }
                    $isicontent = str_replace("{elemen_id}", $page_elemen->id, $isicontent);
                    $isicontent = str_replace("{elemen_title}", $page_elemen->title, $isicontent);
                    if (isset($page_elemen->link)) {
                        $headlink = "";
                        if (isset($page_elemen
                                ->link
                                ->head)) {
                            for ($l = 0;$l < count($page_elemen
                                    ->link
                                    ->head);$l++) {
                                $thelink = $page_elemen
                                        ->link
                                        ->head[$l];
                                $thehref = "";
                                $thelabel = "";
                                if (!isset($thelink->type)) {
                                    $thelink->type = "normal";
                                }
                                if (!isset($thelink->param)) {
                                    $thelink->param = [];
                                }
                                if (!isset($thelink->href)) {
                                    $thelink->href = "";
                                }
                                if (!isset($thelink->label)) {
                                    $thelink->label = "";
                                }
                                switch ($thelink->type) {
                                        case "normal":
                                            $thehref = $thelink->href;
                                            $thelabel = $thelink->label;
                                        break;
                                        case "modul_page":
                                            $thehref = get_project_url_php($thelink->modul, $thelink->page, $thelink->param);
                                            $thelabel = $thelink->label;
                                        break;
                                    }
                                $headlink .= "<th><a href=\"" . $thehref . "\">" . $thelabel . "</a></th>\n";
                            }
                        }
                        $isicontent = str_replace("{head_link}", $headlink, $isicontent);
                    }
                    $bahanpagecontent .= "\n" . $isicontent;
                }

                //akhir for elemen
            }

            $current_page = $thepage;
            $current_modul = $themodul;

            $ar_funcs = rekursifcekfunction($current_page, $current_modul->id, $current_page->id);
            $ar_func_done = array();
            for ($f = 0;$f < count($ar_funcs);$f++) {
                $thefunc = $ar_funcs[$f];
                //var_dump($thefunc);
                if (!in_array($thefunc->func_name, $ar_func_done)) {
                    $func = $thefunc->content;
                    $func = str_replace("{func_param}", "", $func);
                    $bahanawaljs .= $func;

                    $ar_func_done[] = $thefunc->func_name;
                }
                //rekursif
            }
            /**
             for($f=0; $f<count($current_page->functions); $f++){
             $thefunc=$current_page->functions[$f];
             $thefunc->modul_id=$current_modul->id;
             $thefunc->page_id=$current_page->id;
             $func=create_web_function($thefunc)->content;
             $func=str_replace("{func_param}","",$func);
             $bahanawaljs.=$func;
             //rekursif
             }
             *
             */

            $bahanawaljs = $variabeljsawal . $bahanawaljs;
            $copy_baseindexmodul="";
            if($current_page->frame!="blank"){
            $copy_baseindexmodul = bacafile($theconfig->target_items . "copy_base/frame_" . $current_page->frame . ".php");
            }
            $bahancopy_baseindexmodul = $copy_baseindexmodul;
            $bahanreplacemasal = array(

                    "{modul_id_page_id}" => $current_modul->id . "_" . $current_page->id,
                    "{modul_id}" => $current_modul->id,
                    "{page_name}" => $current_page->title . " | " . $manifest->project_name
                    //,"{copy_basecss}"=>$isicopy_basecss
                    ,
                    "{page_title}" => $current_page->title,
                    "{page_subtitle}" => $current_page->subtitle,
                    "{page_content}" => $bahanpagecontent,
                    "{footer_js}" => $bahanawaljs,
                    "{copy_js}" => $copy_basejs,
                    "{modul_title}" => $current_modul->title,
                    "<br />" => ""

                );
            for ($lib = 0;$lib < count($manifest->libraries);$lib++) {
                $thelib = $manifest->libraries[$lib];
                $bahanreplacemasal["{copy_base_language_" . $thelib->language . "}"] = $isicopy_baselanguage[$thelib->language];
            }
            for ($r = 0;$r < count($requested_html);$r++) {
                if ($requested_html[$r]["key"] == "form_field_css_insert") {
                    $bahanreplacemasal["{copy_base_language_" . $requested_html[$r]["language"] . "}"] = $isicopy_baselanguage[$requested_html[$r]["language"]];
                }
                if ($requested_html[$r]["key"] == "page_element_css_insert") {
                    $bahanreplacemasal["{copy_base_language_" . $requested_html[$r]["language"] . "}"] = $isicopy_baselanguage[$requested_html[$r]["language"]];
                }
            }
            $bahancopy_baseindexmodul = replacemasal($bahanreplacemasal, $bahancopy_baseindexmodul);
            $bahanreplacemasal = array();
            for ($lib = 0;$lib < count($libraries_warehouse);$lib++) {
                $bahanreplacemasal["{copy_base_language_" . $libraries_warehouse[$lib] . "}"] = "";
            }
            $bahancopy_baseindexmodul = replacemasal($bahanreplacemasal, $bahancopy_baseindexmodul);

            //file_put_contents($foldermvcviewpage."/index.php",$bahancopy_baseindexmodul);
            if (!$themodul->asclass) {
                $ar_worktodo[] = array(
                        "type" => "addfile",
                        "work_id" => "writefileto" . $foldermvcviewpage . "/index.blade.php",
                        "file_id" => $foldermvcviewpage . "/index.blade.php",
                        "location" => $foldermvcviewpage . "/index.blade.php",
                        "content_from" => "string",
                        "content" => $bahancopy_baseindexmodul
                    );
            }
        }
    }


          $balikanresource["isiroute"]=$isiroute;

    //------------------
    //balikan
    $objreturn->content=$content;
    $objreturn->varjsawal=$varjsawal;
    $objreturn->deklarasi=$deklarasi;
    $objreturn->varphpawal=$varphpawal;
    $objreturn->include=$include;
    $objreturn->ar_worktodo=$ar_worktodo;
    $objreturn->balikanresource=$balikanresource;
    //echo "kerja nyata ".count($objreturn->ar_worktodo)."<BR>";
    //akhir what_need_from_page
    return $objreturn;
}


function what_need_from_daf_api($thedafapi, $theconfig)
{
    $objreturn=new \stdClass();
    $content="";
    $varjsawal="";
    $include=array();
    $deklarasi=array();
    $varphpawal=array();
    $ar_worktodo=array();




    $controller_name=$thedafapi->modul;
    if (!isset($thedafapi->ignore)) {
        $thedafapi->ignore=false;
    }
    //echo "controller ".$controller_name."<BR>";
    //var_dump($thedafapi)."<BR>";
    if (!$thedafapi->ignore) {
        $controller_nickname="controller_".$controller_name;
        $namespace="App\Http\Controllers";
        $ar_worktodo[]=array("type"=>"addfile","work_id"=>"addfile".$controller_nickname,"file_id"=>$controller_nickname,"location"=>"app/Http/Controllers/model_".$controller_nickname.".php","content_from"=>"file","autopath_content"=>false,"content"=>$theconfig->target_items."file_template/language_php_template_controller.php","replaces"=>array(array("search"=>"{namespace}","replace"=>$namespace)));
        for ($act=0; $act<count($thedafapi->action); $act++) {
            $action=$thedafapi->action[$act];
            $func_name=$action->action;
            //echo "page api ".$controller_name."<BR>";


            $dafVariable=array();
            foreach ($action->process as $pro) {
                if (is_array($pro)) {
                    //echo $key."<BR>";
                    //$dafVariable=array_merge($dafVariable,renderwhattodo($key,$category,$isitoproses));
                    $dafVariable=array_merge($dafVariable, rekursifdafVariable($pro));
                } elseif (is_object($pro)) {
                    //echo $key."<BR>";
                    if (isset($pro->outputVariable)) {
                        $dafVariable[]=$pro->outputVariable;
                    }
                    $dafVariable=array_merge($dafVariable, rekursifdafVariable($pro));
                } else {
                }
            }

            if (isset($action->process)) {
                foreach ($action->process as $pro) {
                    if (isset($pro->outputVariable)) {
                        $dafVariable[]=$pro->outputVariable;
                    }
                    switch ($pro->type) {
                            case "table":


                                       if (isset($action->engine)) {
                                           for ($eng=0;$eng<count($action->engine);$eng++) {
                                               if ($action->engine[$eng]->type=="table") {
                                                   for ($ca=0; $ca<count($action->engine[$eng]->content); $ca++) {
                                                       if ($action->engine[$eng]->content[$ca]->id==$pro->id) {
                                                           $table_action=$action->engine[$eng]->content[$ca];
                                                           if ($table_action!=null) {
                                                               $dafVariable[]=$table_action->outputVariable;
                                                           }
                                                           break;
                                                       }
                                                   }
                                               }
                                           }
                                       }

                            break;
                          }
                }

                //akhir isset proses
            }


            $page_nickname="page_".$func_name;
            $page_name_controller=$page_nickname.$controller_nickname;
            //echo "page name controller ".$page_name_controller."<BR>";
            $ar_worktodo[]=array("type"=>"addfunction","starter"=>"function","work_id"=>"add_function_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"function_name"=>$page_nickname,"param"=>array('$obj'),"file_id"=>$controller_nickname);
            $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_variabel_error_code_in_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>'$error_code = "000";'."\n");
            $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_variabel_error_msg_in_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>'$error_msg = "";'."\n");
            $bahandeklarasiapi="";
            $varphpawal="";
            $bahandeklarasiapi.='$variables=getVariables();'."\n";
            $bahandeklarasiapi.='extract($variables);'."\n";
            $bahandeklarasiapi.='$prosesapi=1;'."\n";
            $bahandeklarasiapi.='$response_data="";'."\n";
            $bahandeklarasiapi.='$returnAPI=array();'."\n\n";
            $bahandeklarasiapi.="{varphpawal}"."\n";
            $cekmodul=get_web_check_apiparam("modul", true);
            $cekaction=get_web_check_apiparam("action", true);
            $varphpawal.=$cekmodul->varphpawal."\n";
            $varphpawal.=$cekaction->varphpawal."\n";
            $bahandeklarasiapi.=$cekmodul->content."\n";
            $bahandeklarasiapi.=$cekaction->content."\n";
            for ($f=0; $f<count($action->param); $f++) {
                if (!isset($action->param[$f]->mandatory)) {
                    $action->param[$f]->mandatory=false;
                }
                $cekparam=get_web_check_apiparam($action->param[$f]->name, $action->param[$f]->mandatory);
                $varphpawal.=$cekparam->varphpawal."\n";
                $bahandeklarasiapi.=$cekparam->content."\n";
            }
            $bahandeklarasiapi=str_replace("{varphpawal}", $varphpawal, $bahandeklarasiapi);

            $bahandeklarasiapi.='if ($prosesapi==1){'."\n";
            $ar_worktodo[]=array("type"=>"add_declaration_to_function","work_id"=>"deklarasi_themodelof_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>$bahandeklarasiapi."\n");


            $ledakanresponse= (explode("v{", $action->response_output));
            for ($l=1;$l<count($ledakanresponse);$l++) {
                $ledakanresponsedalam= explode("}v", $ledakanresponse[$l]);
                $dapatkurunganlama="v{".$ledakanresponsedalam[0]."}v";
                $ledakanresponsedalam[0]=str_replace("'", "\"", $ledakanresponsedalam[0]);
                $dapatkurungan="{".$ledakanresponsedalam[0]."}";
                $bahanjsonledakan=json_decode($dapatkurungan);
                $tes=  $bahanjsonledakan;
                if (!isset($tes->var_type)) {
                    $tes->var_type="variable";
                }
                //echo "gak ada ".$tes->var_name;
                $bikinvar=create_variable_web($tes);
                $dapatkurunganbaru=str_replace('"', '\"', $dapatkurungan);
                //echo $dapatkurunganlama;
                $action->response_output=str_replace($dapatkurunganlama, '".'.$bikinvar.'."', $action->response_output);
                //$bahanfooter.='$bahan_respon=str_replace("'.$dapatkurunganlama.'",'.$bikinvar.',$bahan_respon);'."\n";
            }
            $bahanfooter='$bahan_respon = "'.$action->response_output."\";"."\n";
            foreach ($dafVariable as $a) {
                if (strpos("tes".$action->response_output."tes", "{".$a."}")) {
                    $bahanfooter.='$bahan_respon=str_replace("{'.$a.'}",$'.$a.',$bahan_respon);'."\n";
                }
            }
            if (isset($action->response_type)) {
                switch ($action->response_type) {
            case "json":

            if (isset($action->json_encode) && $action->json_encode) {
                $bahanfooter.='$response_data = json_decode(json_encode($bahan_respon))'.";"."\n";
            } else {
                $bahanfooter.='$response_data = json_decode($bahan_respon)'.";"."\n";
            }
            break;
            case "text":
            $bahanfooter.='$response_data = $bahan_respon'.";"."\n";
            break;
          }
            } else {
                $bahanfooter.='$response_data = $bahan_respon'.";"."\n";
            }

            $bahanfooter.='}'."\n\n";
            $bahanfooter.='$returnAPI[\'error_code\']=$error_code;'."\n";
            $bahanfooter.='$returnAPI[\'error_msg\']=$error_msg;'."\n";
            $bahanfooter.='$returnAPI["response_data"]=$response_data;'."\n";
            $bahanfooter.='$hasil=json_encode($returnAPI);'."\n";
            $bahanfooter.='echo $hasil;'."\n";
            $ar_worktodo[]=array("type"=>"add_footer_to_function","work_id"=>"deklarasi_footer_of_modelof_".$page_name_controller,"function_id"=>"function_".$page_name_controller,"content"=>$bahanfooter."\n");


            foreach ($action as $key=>$category) {
                if (is_array($category)) {
                    //echo $key."<BR>";
                    $ar_worktodo=array_merge($ar_worktodo, renderwhattodo($key, $category, $action));
                    $ar_worktodo=array_merge($ar_worktodo, rekursifprosesmodulpage($category, $controller_name, $func_name));
                } elseif (is_object($category)) {
                    //echo $key."<BR>";
                    $ar_worktodo=array_merge($ar_worktodo, renderwhattodo($key, $category, $action));
                    $ar_worktodo=array_merge($ar_worktodo, rekursifprosesmodulpage($category, $controller_name, $func_name));
                } else {
                }
            }
        }
    }
    //akhir daf_api

    //------------------
    //balikan
    $objreturn->content=$content;
    $objreturn->varjsawal=$varjsawal;
    $objreturn->deklarasi=$deklarasi;
    $objreturn->varphpawal=$varphpawal;
    $objreturn->include=$include;
    $objreturn->ar_worktodo=$ar_worktodo;
    //echo "kerja nyata ".count($objreturn->ar_worktodo)."<BR>";
    //akhir render_engine
    return $objreturn;
}
