<?php

namespace Drupal\creation_site_virtuel\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\lesroidelareno\Services\FormDonneeSiteVar;
use Drupal\lesroidelareno\Entity\DonneeSiteInternetEntity;
use Drupal\Core\Entity\Entity\EntityFormDisplay;
use Drupal\lesroidelareno\LesroidelarenoFormDonneeSite;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Url;

/**
 * Class ModelChoisieForm.
 */
class ModelChoisieForm extends FormBase {
  
  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;
  protected $entity;
  
  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->entityTypeManager = $container->get('entity_type.manager');
    return $instance;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'model_choisie_form';
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $formParents = [];
    /**
     * On verifie si l'entité existe deja.
     */
    if ($form_state->has(FormDonneeSiteVar::$entity)) {
      $this->entity = $form_state->get(FormDonneeSiteVar::$entity);
      /**
       *
       * @var EntityFormDisplay $form_display
       */
      $form_display = $form_state->get(FormDonneeSiteVar::$entity_display);
      $form_display->buildForm($this->entity, $formParents, $form_state);
    }
    else {
      $this->entity = DonneeSiteInternetEntity::create();
      $form_display = EntityFormDisplay::collectRenderDisplay($this->entity, 'default');
      $form_state->set(FormDonneeSiteVar::$entity, $this->entity);
      $form_display->buildForm($this->entity, $formParents, $form_state);
      $form_state->set(FormDonneeSiteVar::$entity_display, $form_display);
    }
    
    $dsi_form = [];
    // on retire les elements qui ne correspondent pas à un champs.
    foreach ($formParents as $key => $field) {
      if (!empty($field['#type']) && !empty($field['widget'])) {
        $dsi_form[$key] = $field;
      }
    }
    // On reordonne les champs par ordre de poids.
    // uasort($dsi_form, [
    // SortArray::class,
    // 'sortByWeightProperty'
    // ]);
    $form_state->set(FormDonneeSiteVar::$key_dsi_form, $dsi_form);
    
    $form['donnee-internet-entity'] = [
      '#type' => 'html_tag',
      '#tag' => 'section',
      "#attributes" => [
        'id' => 'donnee-internet-entity-next-field',
        'class' => [
          'step-donneesite',
          'mx-auto',
          'text-center'
        ]
      ],
      '#weight' => -10
    ];
    
    //
    if ($form_state->has(FormDonneeSiteVar::$key_steps)) {
      LesroidelarenoFormDonneeSite::getFieldForStep($form['donnee-internet-entity'], $form_state, 2);
      if (array_key_last($form_state->get(FormDonneeSiteVar::$key_steps)) == 'login') {
        $form['donnee-internet-entity'][] = [
          '#type' => 'html_tag',
          '#tag' => 'div',
          '#attributes' => [
            'class' => [
              'step-donneesite--header',
              'with-tablet',
              'mx-auto',
              'text-center'
            ]
          ],
          [
            '#type' => 'html_tag',
            '#tag' => 'h2',
            '#value' => 'Veillez vous connectez afin de sauvegarder vos données',
            '#attributes' => [
              'class' => [
                'step-donneesite--title'
              ]
            ]
          ],
          [
            '#type' => 'html_tag',
            '#tag' => 'div',
            '#attributes' => [
              'id' => 'appLoginRegister'
            ],
            '#value' => 'ff',
            '#weight' => 10
          ]
        ];
        // $form['donnee-internet-entity']['#attached']['library'][] = 'login_rx_vuejs/login_register';
        // $form['donnee-internet-entity']['#attached']['library'][] = 'login_rx_vuejs/login_register_small_components';
        $form['donnee-internet-entity']['#attached']['library'][] = "lesroidelareno/lesroidelareno_login";
      }
    }
    else
      LesroidelarenoFormDonneeSite::getHeader('ctm_description', $form['donnee-internet-entity']);
    
    if ($form_state->get(FormDonneeSiteVar::$laststep)) {
      LesroidelarenoFormDonneeSite::getFooter('ctm_footer', $form['donnee-internet-entity']);
    }
    
    //
    $form['donnee-internet-entity']['container_buttons'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#attributes' => [
        'class' => [
          'd-flex',
          'justify-content-around',
          'align-items-center',
          'step-donneesite--submit'
        ]
      ],
      '#weight' => 45
    ];
    //
    if ($form_state->has(FormDonneeSiteVar::$key_steps) && count($form_state->get(FormDonneeSiteVar::$key_steps)) > 1) {
      $form['donnee-internet-entity']['container_buttons']['previews'] = [
        '#type' => 'submit',
        '#value' => 'Precedent',
        '#button_type' => 'secondary',
        '#submit' => [
          [
            $this,
            'selectPreviewsFieldSubmit'
          ]
        ],
        '#ajax' => [
          'callback' => '::selectPreviewsFieldSCallback',
          'wrapper' => 'donnee-internet-entity-next-field',
          'effect' => 'fade'
        ],
        '#attributes' => [
          'class' => [
            'd-inline-block',
            'w-auto',
            'btn btn-secondary'
          ]
        ]
      ];
    }
    //
    if (!$form_state->get(FormDonneeSiteVar::$laststep)) {
      $form['donnee-internet-entity']['container_buttons']['next'] = [
        '#type' => 'submit',
        '#value' => 'Suivant',
        '#button_type' => 'secondary',
        '#submit' => [
          [
            $this,
            'selectNextFieldSubmit'
          ]
        ],
        '#ajax' => [
          'callback' => '::selectNextFieldSCallback',
          'wrapper' => 'donnee-internet-entity-next-field',
          'effect' => 'fade'
        ],
        '#attributes' => [
          'class' => [
            'd-inline-block',
            'w-auto'
          ]
        ]
      ];
    }
    // save datas
    else {
      $form['donnee-internet-entity']['container_buttons']['submit'] = [
        '#type' => 'submit',
        '#value' => 'Enregistre les données',
        '#button_type' => 'secondary',
        '#submit' => [
          [
            $this,
            'saveSubmit'
          ]
        ],
        '#ajax' => [
          'callback' => '::selectNextFieldSCallback',
          'wrapper' => 'donnee-internet-entity-next-field',
          'effect' => 'fade'
        ],
        '#attributes' => [
          'class' => [
            'd-inline-block',
            'w-auto'
          ]
        ]
      ];
    }
    return $form;
  }
  
  public function selectNextFieldSCallback(array $form, FormStateInterface $form_state) {
    return $form['donnee-internet-entity'];
  }
  
  public function selectPreviewsFieldSCallback(array $form, FormStateInterface $form_state) {
    return $form['donnee-internet-entity'];
  }
  
  /**
   *
   * @param array $form
   * @param FormStateInterface $form_state
   */
  public function selectNextFieldSubmit($form, FormStateInterface $form_state) {
    //
    if ($form_state->has(FormDonneeSiteVar::$key_steps)) {
      if ($form_state->has(FormDonneeSiteVar::$entity)) {
        $entity = $form_state->get(FormDonneeSiteVar::$entity);
        /**
         *
         * @var EntityFormDisplay $form_display;
         */
        $form_display = $form_state->get(FormDonneeSiteVar::$entity_display);
        /**
         * On retire les arrays vide, cela semble etre un bug.
         *
         * @var array $files
         */
        $files = $entity->get('contenus_transferer')->getValue();
        $new_files = [];
        foreach ($files as $file) {
          if (!empty($file))
            $new_files[] = $file;
        }
        $entity->set('contenus_transferer', $new_files);
        $form_display->extractFormValues($entity, $form, $form_state);
        $form_state->set(FormDonneeSiteVar::$entity, $entity);
      }
    }
    else {
      $form_state->set(FormDonneeSiteVar::$key_steps, []);
    }
    $form_state->set('step_direction', '+');
    $form_state->setRebuild(true);
  }
  
  public function selectPreviewsFieldSubmit($form, FormStateInterface $form_state) {
    $form_state->set('step_direction', '-');
    // $this->messenger()->addStatus('selectPreviewsFieldSubmit :: ' . json_encode($form_state->getValues()), true);
    $form_state->setRebuild(true);
  }
  
  public function saveSubmit($form, FormStateInterface $form_state) {
    $entity = $form_state->get(FormDonneeSiteVar::$entity);
    $entity->save();
    
    $form_state->set(FormDonneeSiteVar::$entity, $entity);
    $this->messenger()->addStatus('Vos données ont été sauvegardées');
    // $form_state->setRebuild(true);
    $response = new AjaxResponse();
    if ($form_state->hasAnyErrors()) {
      // Do validation stuff here
      // ex: $response->addCommand(new ReplaceCommand... on error fields
    }
    else {
      // Do submit stuff here
      $this->messenger()->addStatus('rediction encours ... current');
      // $url = Url::fromRoute('multi_sitemap.render6');
      // $command = new RedirectCommand($url->toString());
      // $response->addCommand($command);
      
      $response = new AjaxResponse();
      $currentURL = Url::fromRoute('<current>');
      $response->addCommand(new RedirectCommand($currentURL->toString()));
      return $response;
    }
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
    // Validation is optional.
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\Core\Form\FormInterface::submitForm()
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    //
  }
  
}