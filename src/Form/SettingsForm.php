<?php

namespace Drupal\os2web_edoc_file_import\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class SettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['os2web_edoc_file_import.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'os2web_edoc_file_import_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('os2web_edoc_file_import.settings');

    $form['import_path'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Import Path'),
      '#default_value' => $config->get('import_path'),
      '#description' => $this->t('Hvor filer vil blive importeret fra. Brug Drupal\'s "private://"'),
      '#required' => TRUE,
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('os2web_edoc_file_import.settings')
      ->set('import_path', $form_state->getValue('import_path'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
