<?php

namespace Drupal\os2web_edoc_file_import\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;

class FileUploadForm extends FormBase {

  public function getFormId() {
    return 'os2web_edoc_file_import_upload_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['file_upload'] = [
      '#type' => 'managed_file',
      '#title' => $this->t('Upload Fil'),
      '#upload_location' => 'private://edoc_files',
      '#required' => TRUE,
      '#description' => $this->t('Tilladte filtyper: <br> .jpg .jpeg .gif .png .txt .doc .docx .xls .pdf .ppt .pps .odt .ods .odp .xml'),
      '#upload_validators' => [
        'file_validate_extensions' => ['jpg jpeg gif png txt doc docx xls pdf ppt pps odt ods odp xml'],
      ],
    ];
  
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Upload'),
    ];
  
    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $file_id = $form_state->getValue('file_upload')[0];
    $file = File::load($file_id);
    $file->setPermanent();
    $file->save();

    $this->messenger()->addMessage($this->t('Fil uploadet!'));
  }
}
