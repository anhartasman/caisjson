<?php

namespace App\MVC_MODEL;

use Illuminate\Database\Eloquent\Model;


use DB;

class model_port_database extends Model
{
  /**
  public function __construct() {

  }
  **/


  function selectMany($tb_name,$selectarray,$wherearray){

/**
  $result = DB::table($tb_name)
  -> where ("idh", '=',$hotel_id)
  ->select($datahasil_get_hotel_images)
  ->get()->toArray();
**/
  $result = DB::table($tb_name);

  foreach($wherearray as $where){
    $result=$result-> where ($where["column"], $where["operation"],$where["value"]);
  }
  $result=$result->select($selectarray);

  $result=$result->get()->toArray();


  $result = array_map(function($object){return (array) $object;}, $result);

  return $result;
  //end of function selectMany
  }


  function selectSingle($tb_name,$selectarray,$wherearray){

      $result = DB::table($tb_name);

      foreach($wherearray as $where){
        $result=$result-> where ($where["column"], $where["operation"],$where["value"]);
      }

      $result=$result->select($selectarray);

      $result=$result->first();
      $result = (array) $result;

      return $result;
    //end of function selectSingle
  }


  function insert_data($tb_name,$dataarray){
      $result = array();
      $input = DB::table($tb_name)->insert($dataarray);

      $result["last_id"]= DB::getPdo()->lastInsertId();
      $result["body"]= $input;


      return $result;
    //end of function selectSingle
  }

    function delete_data($tb_name,$wherearray){
      $result = array();
      $vardelete = DB::table($tb_name);

      foreach($wherearray as $where){
        $vardelete=$vardelete-> where ($where["column"], $where["operation"],$where["value"]);
      }

      $vardelete=$vardelete->delete();

      $result["body"]= $vardelete;

      return $result;
      //end of function selectSingle
    }


      function update_data($tb_name,$updatearray,$wherearray){
        $result = array();

          $varupdate = DB::table($tb_name);

          foreach($wherearray as $where){
            $varupdate=$varupdate-> where ($where["column"], $where["operation"],$where["value"]);
          }

          $varupdate=$varupdate->update($updatearray);
          
          $result["body"]=$varupdate;

          return $result;
        //end of function selectSingle
      }

}
