<?php

namespace Drupal\creation_site_virtuel\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Form controller for Site type datas edit forms.
 *
 * @ingroup creation_site_virtuel
 */
class SiteTypeDatasForm extends ContentEntityForm {
  
  /**
   * The current user account.
   *
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
  protected $account;
  
  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    // Instantiates this form class.
    $instance = parent::create($container);
    $instance->account = $container->get('current_user');
    return $instance;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    /* @var \Drupal\creation_site_virtuel\Entity\SiteTypeDatas $entity */
    $form = parent::buildForm($form, $form_state);
    // set defaut value.
    if (empty($form['page_supplementaires']['widget']['#default_value']))
      $form['page_supplementaires']['widget']['#default_value'] = \Drupal\creation_site_virtuel\CreationSiteVirtuel::getDefautPage();
    
    //
    $form['entete_paragraph']['widget']['#states'] = [
      'visible' => [
        ':input[name="is_home_page[value]"]' => [
          'checked' => TRUE
        ]
      ]
    ];
    $form['footer_paragraph']['widget']['#states'] = [
      'visible' => [
        ':input[name="is_home_page[value]"]' => [
          'checked' => TRUE
        ]
      ]
    ];
    $form['page_supplementaires']['widget']['#states'] = [
      'visible' => [
        ':input[name="is_home_page[value]"]' => [
          'checked' => TRUE
        ]
      ]
    ];
    
    // dump($form['is_home_page']['widget']);
    if (!$this->entity->isNew()) {
      $form['actions']['duplicate'] = [
        '#type' => 'submit',
        '#value' => 'Dupliquer le model',
        '#button_type' => 'secondary',
        '#submit' => [
          '::entityDuplicate'
        ],
        '#weight' => 20
      ];
    }
    // dump($this->entity->toArray());
    return $form;
  }
  
  public function entityDuplicate(array $form, FormStateInterface $form_state) {
    /**
     *
     * @var \Drupal\creation_site_virtuel\Entity\SiteTypeDatas $entity
     */
    $entity = $this->entity;
    
    /**
     *
     * @var \Drupal\creation_site_virtuel\Entity\SiteTypeDatas $duplique
     */
    $dupliqueEntity = $entity->createDuplicate();
    $dupliqueEntity->setName(' Clone : ' . $dupliqueEntity->getName());
    // on duplique les contenus.
    /**
     *
     * @var \Drupal\vuejs_entity\Services\DuplicateEntityReference $DuplicateEntityReference
     */
    $DuplicateEntityReference = \Drupal::service('vuejs_entity.duplicate.entity');
    $DuplicateEntityReference->duplicateExistantReference($dupliqueEntity);
    $dupliqueEntity->save();
    
    // $form_state->setRebuild();
    \Drupal::request()->query->remove('destination');
    $form_state->setRedirect("entity.site_type_datas.edit_form", [
      'site_type_datas' => $dupliqueEntity->id()
    ]);
    //
    $this->messenger()->addStatus('Contenu dupliqué avec success');
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $entity = $this->entity;
    
    $status = parent::save($form, $form_state);
    
    switch ($status) {
      case SAVED_NEW:
        $this->messenger()->addMessage($this->t('Created the %label Site type datas.', [
          '%label' => $entity->label()
        ]));
        break;
      
      default:
        $this->messenger()->addMessage($this->t('Saved the %label Site type datas.', [
          '%label' => $entity->label()
        ]));
    }
    $form_state->setRedirect('entity.site_type_datas.canonical', [
      'site_type_datas' => $entity->id()
    ]);
  }
  
}
