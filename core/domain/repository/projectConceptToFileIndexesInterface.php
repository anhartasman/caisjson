<?php
namespace core\domain\repository;
interface projectConceptToFileIndexesInterface {
public function __construct($file_config,$theconcept);
  public function convertToFileIndexes();
}
 ?>
