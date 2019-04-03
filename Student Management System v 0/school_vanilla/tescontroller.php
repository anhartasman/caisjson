<?php
    include "config/database.php"; 
include "mvc_controller/controller_laporan_transaksi.php";
$main= new controller_laporan_transaksi();
$main->db=$db;
$main->page_tabel_laporan();
 ?>
