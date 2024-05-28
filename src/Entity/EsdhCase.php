<?php

namespace Drupal\os2web_edoc_file_import\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defines the eDoc Case entity.
 *
 * @ContentEntityType(
 *   id = "esdh_case",
 *   label = @Translation("eDoc Case"),
 *   base_table = "esdh_case",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *   },
 *   handlers = {
 *     "storage" = "Drupal\Core\Entity\Sql\SqlContentEntityStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\os2web_edoc_file_import\Entity\Controller\EsdhCaseListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 *     "form" = {
 *       "default" = "Drupal\os2web_edoc_file_import\Form\EsdhCaseForm",
 *       "add" = "Drupal\os2web_edoc_file_import\Form\EsdhCaseForm",
 *       "edit" = "Drupal\os2web_edoc_file_import\Form\EsdhCaseForm",
 *       "delete" = "Drupal\os2web_edoc_file_import\Form\EsdhCaseDeleteForm",
 *     },
 *     "access" = "Drupal\os2web_edoc_file_import\EsdhCaseAccessControlHandler",
 *   },
 *   admin_permission = "administer site configuration",
 *   field_ui_base_route = "entity.esdh_case.admin_form",
 *   links = {
 *     "canonical" = "/esdh_case/{esdh_case}",
 *   },
 * )
 */
class EsdhCase extends ContentEntityBase {

  /**
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);

    // Body field
    $fields['body'] = BaseFieldDefinition::create('text_long')
      ->setLabel(t('Body'))
      ->setDescription(t('The main body of the case.'))
      ->setTranslatable(TRUE)
      ->setDisplayOptions('form', [
        'type' => 'text_textarea',
        'weight' => -4,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Case Name field
    $fields['field_case_name'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Case Name'))
      ->setDescription(t('The name of the case.'))
      ->setSettings([
        'max_length' => 255,
        'text_processing' => 0,
      ])
      ->setDisplayOptions('form', [
        'type' => 'string_textfield',
        'weight' => -3,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Entity Reference
    $fields['field_case_documents'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('Case Documents'))
      ->setDescription(t('Documents related to the case.'))
      ->setSetting('target_type', 'esdh_document')
      ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
      ->setDisplayOptions('form', [
        'type' => 'entity_reference_autocomplete',
        'weight' => -2,
      ])
      ->setDisplayConfigurable('form', TRUE)
      ->setDisplayConfigurable('view', TRUE);

    // Sagsnummer field
    $fields['field_sagsnummer'] = BaseFieldDefinition::create('string')
      ->setLabel(t('Sagsnummer'))
      ->setDescription(t('The case number.'))
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

    return $fields;
  }

}