<?php

namespace Drupal\os2web_edoc_file_import\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the EsdhCase entity edit forms.
 *
 * @ingroup os2web_edoc_file_import
 */
class EsdhCaseForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var $entity \Drupal\os2web_edoc_file_import\Entity\EsdhCase */
    $form = parent::buildForm($form, $form_state);
    $entity = $this->entity;

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->getEntity();
    $result = $entity->save();

    $message_arguments = ['%label' => $this->entity->label()];
    $messenger = \Drupal::messenger();

    if ($result == SAVED_NEW) {
      $messenger->addStatus($this->t('New case %label has been created.', $message_arguments));
    }
    else {
      $messenger->addStatus($this->t('The case %label has been updated.', $message_arguments));
    }

    $form_state->setRedirect('entity.esdh_case.collection');
  }

}
