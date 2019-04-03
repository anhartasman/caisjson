<?php

function modul_supplier_page_daftar_supplier(){
  $thepage=std_page();
  $thepage->id="daftar_supplier";
  $thepage->title="Daftar Supplier";
  $thepage->placement[]=std_place_sidemenu();

  $eltabelsupplier=std_element_tabel();
  $eltabelsupplier->id="tabel_supplier";
  $eltabelsupplier->title="Daftar Supplier";
  $eltabelsupplier->columns=["Supplier","Nomor Telfon"];

  $headmenu=std_link_head();
  $headmenu->modul="daftar_supplier";
  $headmenu->page="add_supplier";
  $headmenu->label="Tambah";

  $eltabelsupplier->link[]=$headmenu;

  $thepage->elemen[]=$eltabelsupplier;

  return $thepage;
}


 ?>
