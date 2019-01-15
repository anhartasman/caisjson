<?php

class system_database {

public function __construct() {

  include '../sparrow.php';
  //$database_host="localhost";
  //$database_username="root";
  //$database_password="";
  //$database_name="belajarcrud";
  $database_host="localhost";
  $database_username="root";
  $database_password="";
  $database_name="belajarcrud2";
  $db = new Sparrow();
  $sql = mysqli_connect($database_host, $database_username, $database_password,$database_name);
  $db->setDb($sql);
  $this->db=$db;
}

public function getDB(){


  return $this->db;
}

}
?>
