<?php

namespace Drupal\os2web_edoc_file_import\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;


interface EsdhDocumentInterface extends ContentEntityInterface, EntityChangedInterface, EntityOwnerInterface {

  
}
