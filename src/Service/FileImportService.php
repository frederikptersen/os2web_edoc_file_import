<?php

namespace Drupal\os2web_edoc_file_import\Service;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\Entity\Node;

class FileImportService {
  protected $entityTypeManager;

  public function __construct(EntityTypeManagerInterface $entityTypeManager) {
    $this->entityTypeManager = $entityTypeManager;
  }

  public function deleteCaseOrDocument($caseNumber, $fileID) {
    $storage = $this->entityTypeManager->getStorage('node');

    $cases = $storage->loadByProperties(['type' => 'esdh_case', 'field_case_id' => $caseNumber]);
    $documents = $storage->loadByProperties(['type' => 'esdh_document', 'field_document_id' => $fileID]);

    if ($case = reset($cases)) {
      $case->delete();
    }

    if ($document = reset($documents)) {
      $document->delete();
    }
  }

  public function createCaseOrDocument($caseNumber, $caseName, $fileName, $fileID) {
    $case = Node::create([
      'type' => 'esdh_case', // Opdateret indholdstype
      'title' => $caseName,
      'field_case_id' => $caseNumber,
    ]);
    $case->save();

    $document = Node::create([
      'type' => 'esdh_document', // Opdateret indholdstype
      'title' => $fileName,
      'field_document_id' => $fileID,
      'field_case_reference' => $case->id(),
    ]);
    $document->save();
  }

  public function updateCaseOrDocument($caseNumber, $caseName, $fileName, $fileID) {
    $storage = $this->entityTypeManager->getStorage('node');

    $cases = $storage->loadByProperties(['type' => 'esdh_case', 'field_case_id' => $caseNumber]);
    $documents = $storage->loadByProperties(['type' => 'esdh_document', 'field_document_id' => $fileID]);

    if ($case = reset($cases)) {
      $case->set('title', $caseName);
      $case->save();
    }

    if ($document = reset($documents)) {
      $document->set('title', $fileName);
      $document->save();
    }
  }

  public function processFile($file_path) {
    $xml = simplexml_load_file($file_path);

    $created = (string) $xml->Created;
    $updated = (string) $xml->Updated;
    $deleted = (string) $xml->Deleted;
    $caseNumber = (string) $xml->CaseNumber;
    $caseName = (string) $xml->CaseName;
    $fileName = (string) $xml->FileName;
    $fileID = (string) $xml->FileID;

    if (!empty($deleted)) {
      $this->deleteCaseOrDocument($caseNumber, $fileID);
    }
    else if (!empty($created)) {
      $this->createCaseOrDocument($caseNumber, $caseName, $fileName, $fileID);
    }
    else if (!empty($updated)) {
      $this->updateCaseOrDocument($caseNumber, $caseName, $fileName, $fileID);
    }
  }
}