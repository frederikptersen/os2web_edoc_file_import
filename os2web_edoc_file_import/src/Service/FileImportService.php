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
    // Logik skal laves til at slette en fil eller dokument.
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
    // Logik skal laves til at opdatere en eksisterende fil eller dokument.
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
