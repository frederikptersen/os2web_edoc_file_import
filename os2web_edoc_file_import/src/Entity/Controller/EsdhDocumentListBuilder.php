<?php

namespace Drupal\os2web_edoc_file_import\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a list controller for eDoc Document entity.
 *
 * @ingroup os2web_edoc_file_import
 */
class EsdhDocumentListBuilder extends EntityListBuilder {

  /**
   * The URL generator.
   *
   * @var \Drupal\Core\Routing\UrlGeneratorInterface
   */
  protected $urlGenerator;

  /**
   * {@inheritdoc}
   */
  public static function createInstance(ContainerInterface $container, EntityTypeInterface $entity_type) {
    return new static(
      $entity_type,
      $container->get('entity_type.manager')->getStorage($entity_type->id()),
      $container->get('url_generator')
    );
  }

  /**
   * Constructs a new EsdhDocumentListBuilder object.
   *
   * @param \Drupal\Core\Entity\EntityTypeInterface $entity_type
   *   The entity type definition.
   * @param \Drupal\Core\Entity\EntityStorageInterface $storage
   *   The entity storage class.
   * @param \Drupal\Core\Routing\UrlGeneratorInterface $url_generator
   *   The URL generator.
   */
  public function __construct(EntityTypeInterface $entity_type, EntityStorageInterface $storage, UrlGeneratorInterface $url_generator) {
    parent::__construct($entity_type, $storage);
    $this->urlGenerator = $url_generator;
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build['description'] = [
      '#markup' => $this->t('The ESDH Document entities are fieldable entities. You can manage the fields on the <a href="@adminlink">ESDH Document admin page</a>.', [
        '@adminlink' => $this->urlGenerator->generateFromRoute('entity.esdh_document.admin_form'),
      ]),
    ];
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Document ID');
    $header['title'] = $this->t('Title');
    $header['case_reference'] = $this->t('Case Reference');
    $header['case_id'] = $this->t('Case ID');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\os2web_edoc_file_import\Entity\EsdhDocument */
    $row['id'] = $entity->id();
    $row['title'] = $entity->get('field_document_title')->value;
    $row['case_reference'] = $entity->get('field_case_reference')->entity->label();
    $row['case_id'] = $entity->get('field_case_id')->value;
    return $row + parent::buildRow($entity);
  }

}
