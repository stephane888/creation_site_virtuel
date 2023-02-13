<?php

namespace Drupal\creation_site_virtuel\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;
use Drupal\language\Entity\ContentLanguageSettings;

/**
 * Class SiteInternetEntityTypeForm.
 */
class SiteInternetEntityTypeForm extends EntityForm {
  
  /**
   *
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);
    $site_internet_entity_type = $this->entity;
    // dump($site_internet_entity_type->toArray());
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $site_internet_entity_type->label(),
      '#description' => $this->t("Label for the Site internet entity type."),
      '#required' => TRUE
    ];
    
    //
    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $site_internet_entity_type->id(),
      '#machine_name' => [
        'exists' => '\Drupal\creation_site_virtuel\Entity\SiteInternetEntityType::load'
      ],
      '#disabled' => !$site_internet_entity_type->isNew()
    ];
    
    /* You will need additional form elements for your custom properties. */
    
    if ($this->moduleHandler->moduleExists('language')) {
      $form['language'] = [
        '#type' => 'details',
        '#title' => $this->t('Language settings'),
        '#group' => 'additional_settings'
      ];
      
      $language_configuration = ContentLanguageSettings::loadByEntityTypeBundle('site_internet_entity', $site_internet_entity_type->id());
      $form['language']['language_configuration'] = [
        '#type' => 'language_configuration',
        '#entity_information' => [
          'entity_type' => 'site_internet_entity',
          'bundle' => $site_internet_entity_type->id()
        ],
        '#default_value' => $language_configuration
      ];
    }
    
    return $form;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $site_internet_entity_type = $this->entity;
    $status = $site_internet_entity_type->save();
    //
    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t(' Created the %label Site internet entity type. ', [
          '%label' => $site_internet_entity_type->label()
        ]));
        break;
      default:
        $this->messenger()->addMessage($this->t(' Saved the %label Site internet entity type. ', [
          '%label' => $site_internet_entity_type->label()
        ]));
    }
    $form_state->setRedirectUrl($site_internet_entity_type->toUrl('collection'));
  }
  
  /**
   * --
   */
  protected function getIds(array $terms) {
    $ids = [];
    foreach ($terms as $term) {
      if (!empty($term['target_id'])) {
        $ids[] = $term['target_id'];
      }
    }
    return $ids;
  }
  
}
