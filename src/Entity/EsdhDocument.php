<?php

namespace Drupal\os2web_edoc_file_import\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\user\EntityOwnerTrait;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the eDoc Document entity class.
 *
 * @ContentEntityType(
 *   id = "esdh_document",
 *   label = @Translation("eDoc Document"),
 *   base_table = "esdh_document",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *     "langcode" = "langcode",
 *     "uid" = "user_id",
 *   },
 *   handlers = {
 *     "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\os2web_edoc_file_import\Entity\Controller\EsdhDocumentListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\os2web_edoc_file_import\Form\EsdhDocumentForm",
 *       "add" = "Drupal\os2web_edoc_file_import\Form\EsdhDocumentForm",
 *       "edit" = "Drupal\os2web_edoc_file_import\Form\EsdhDocumentForm",
 *       "delete" = "Drupal\os2web_edoc_file_import\Form\EsdhDocumentDeleteForm",
 *     },
 *     "access" = "Drupal\os2web_edoc_file_import\EsdhDocumentAccessControlHandler",
 *   },
 *   admin_permission = "administer site configuration",
 *   field_ui_base_route = "entity.esdh_document.admin_form",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *   },
 *   links = {
 *     "canonical" = "/esdh_document/{esdh_document}",
 *   },
 * )
 */
class EsdhDocument extends ContentEntityBase {

  use EntityChangedTrait;
  use EntityOwnerTrait;

  /**
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
    if (!$this->getOwnerId()) {
      $this->setOwnerId(0);
    }
  }

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    #$fields += static::ownerBaseFieldDefinitions($entity_type);

    // Body field
    $fields['body'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Body'))
      ->setDescription(t('The main body of the document.'))
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Case Reference field
    $fields['field_case_reference'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Case Reference'))
      ->setDescription(t('Reference to the related case.'))
      ->setSetting('target_type', 'esdh_case')
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Document ID field
    $fields['field_document_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Document ID'))
      ->setDescription(t('The ID of the document.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Document Title field
    $fields['field_document_title'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Document Title'))
      ->setDescription(t('The title of the document.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // File field
    $fields['field_case_file'] = BaseFieldDefinition::create('file')
      ->setLabel(t('File'))
      ->setDescription(t('The file attached to the document.'))
      ->setSetting('file_directory', 'edoc-files')
      ->setDisplayOptions('form', [
        'type' => 'file',
        'weight' => 0,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Case ID field
    $fields['field_case_id'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Case ID'))
      ->setDescription(t('The ID of the related case.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => 1,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    return $fields;
  }

}
