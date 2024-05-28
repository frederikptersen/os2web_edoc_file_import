<?php

namespace Drupal\os2web_edoc_file_import\Entity\Controller;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Routing\UrlGeneratorInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a list controller for eDoc Case entity.
 *
 * @ingroup os2web_edoc_file_import
 */
class EsdhCaseListBuilder extends EntityListBuilder {

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
   * Constructs a new EsdhCaseListBuilder object.
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
      '#markup' => $this->t('The ESDH Case entities are fieldable entities. You can manage the fields on the <a href="@adminlink">ESDH Case admin page</a>.', [
        '@adminlink' => $this->urlGenerator->generateFromRoute('entity.esdh_case.admin_form'),
      ]),
    ];
    $build['table'] = parent::render();
    return $build;
  }

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Case ID');
    $header['name'] = $this->t('Name');
    $header['case_name'] = $this->t('Case Name');
    $header['sagsnummer'] = $this->t('Sagsnummer');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var $entity \Drupal\os2web_edoc_file_import\Entity\EsdhCase */
    $row['id'] = $entity->id();
    $row['name'] = $entity->toLink()->toString();
    $row['case_name'] = $entity->get('field_case_name')->value;
    $row['sagsnummer'] = $entity->get('field_sagsnummer')->value;
    return $row + parent::buildRow($entity);
  }

}
