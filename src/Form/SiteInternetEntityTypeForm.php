<?php

namespace Drupal\creation_site_virtuel\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

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
    $siteInternetType = $this->entity;
    $site_internet_entity_type = $this->entity;
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
    
    //
    $image = $siteInternetType->get('image');
    // dump($image);
    $form['image'] = [
      '#type' => 'managed_file',
      '#title' => 'Image',
      '#default_value' => !empty($image) ? $image : [],
      '#upload_location' => 'public://site-internet-type',
      '#upload_validators' => [
        'file_validate_extensions' => [
          'gif png jpg jpeg webp'
        ]
      ]
    ];
    if (!empty($image)) {
      /**
       *
       * @var \Drupal\file\Entity\File $file
       */
      $file = \Drupal\file\Entity\File::load($image[0]);
      if ($file)
        $form['image']['preview'] = [
          '#weight' => -10,
          '#theme' => 'image_style',
          // '#width' => $file->get,
          // '#height' => $variables['height'],
          '#style_name' => 'medium',
          '#uri' => $file->getFileUri()
        ];
    }
    
    //
    $terms = $siteInternetType->get('terms');
    // dump($terms);
    // $form['terms'] = [
    // '#type' => 'entity_autocomplete',
    // "#target_type" => 'taxonomy_term',
    // '#selection_handler' => "default:taxonomy_term",
    // '#multiple' => TRUE,
    // '#selection_settings' => [
    // 'target_bundles' => [
    // 'typesite' => 'typesite'
    // ],
    // 'sort' => [
    // 'field' => 'name',
    // 'direction' => 'asc'
    // ],
    // 'auto_create' => false,
    // 'auto_create_bundle' => false,
    // 'match_operator' => "CONTAINS",
    // 'match_limit' => 10
    // ],
    // '#title' => 'Tags'
    // // '#default_value' => !empty($terms) ? $terms : []
    // ];
    /* You will need additional form elements for your custom properties. */
    
    $form['terms'] = [
      '#type' => 'select2',
      '#target_type' => 'taxonomy_term',
      '#selection_handler' => "default:taxonomy_term",
      '#select2' => [
        'allowClear' => TRUE
      ],
      '#multiple' => TRUE,
      '#selection_settings' => [
        'target_bundles' => [
          'typesite' => 'typesite'
        ],
        'sort' => [
          'field' => 'name',
          'direction' => 'asc'
        ],
        'auto_create' => false,
        'auto_create_bundle' => false,
        'match_operator' => "CONTAINS",
        'match_limit' => 10
      ],
      '#cardinality' => -1,
      '#default_value' => !empty($terms) ? $terms : [],
      '#autocomplete' => true
    ];
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
