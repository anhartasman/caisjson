<?php
namespace core\domain\repository;
use core\domain\entity\entity_project_json;
interface fileWorkerInterface {
public function __construct(fileTellerInterface $fti, fileComposerInterface $fci);
  public function createDirectory();
  public function prepareFile();
  public function prepareFileContent();
  public function addIncludeToFileContent();
  public function addFunctionToFileContent();
  public function addDeclarationToFunction();
  public function addContentToFunction();
  public function addFooterToFunction();
  public function addAuthToFunction();
  public function saveFileContentToFile();
}
 ?>
