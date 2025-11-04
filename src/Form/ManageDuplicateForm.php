<?php

namespace Drupal\creation_site_virtuel\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\apivuejs\Services\DuplicateEntityReference;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a Creation site virtuel form.
 */
class ManageDuplicateForm extends FormBase
{
  /**
   *
   * @var string
   */
  protected $field_domain_access = \Drupal\domain_access\DomainAccessManagerInterface::DOMAIN_ACCESS_FIELD;
  /**
   *
   * @var string
   */
  protected $field_domain_source = \Drupal\domain_source\DomainSourceElementManagerInterface::DOMAIN_SOURCE_FIELD;

  /**
   *
   * @var DuplicateEntityReference
   */
  protected $DuplicateEntityReference;

  function __construct(DuplicateEntityReference $DuplicateEntityReference)
  {
    $this->DuplicateEntityReference = $DuplicateEntityReference;
  }

  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container)
  {
    return new static($container->get('apivuejs.duplicate_reference'));
  }

  /**
   *
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'creation_site_virtuel_manage_duplicate';
  }

  /**
   *
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $buidlInfo = $form_state->getBuildInfo()['args'][0];
    /**
     *
     * @var \Drupal\Core\Entity\ContentEntityBase $entitty_to_duplicate
     */
    $entitty_to_duplicate = $buidlInfo['entitty_to_duplicate'];
    $form_state->set('entitty_to_duplicate', $entitty_to_duplicate);
    $form['name'] = [
      '#type' => 'textfield',
      '#title' => 'Titre de la nouvelle page',
      '#default_value' => 'Clone : ' . $entitty_to_duplicate->label()
    ];
    if (\Drupal::moduleHandler()->moduleExists('lesroidelareno')) {
      $curentDomain = \Drupal\lesroidelareno\lesroidelareno::getCurrentDomainId();
    } else {
      /**
       *
       * @var \Drupal\domain\DomainNegotiator $domainManagement
       */
      $domainManagement = \Drupal::service('domain.negotiator');
      $curentDomain = $domainManagement->getActiveId();
    }

    $form['select_domain'] = [
      '#type' => 'select2',
      '#options' => [
        $curentDomain => $curentDomain
      ],
      '#title' => $this->t('Selectionner un domaine'),
      '#default_value' => $curentDomain,
      '#required' => TRUE,
      '#autocomplete' => TRUE,
      '#target_type' => 'domain',
      '#selection_handler' => 'default',
      // '#multiple' => 1,
      '#description' => "Vous pouvez selectionner un autre domaine si vous souhaitez transferer une copie de cla page"
    ];

    $form['actions'] = [
      '#type' => 'actions'
    ];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Dupliquer la page')
    ];
    return $form;
  }

  /**
   *
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state)
  {
    //
  }

  /**
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    /**
     *
     * @var \Drupal\Core\Entity\ContentEntityBase $entitty_to_duplicate
     */
    $entitty_to_duplicate = $form_state->get('entitty_to_duplicate');
    $title = $form_state->getValue('name');
    $select_domain = $form_state->getValue('select_domain');
    if (is_array($select_domain)) {
      $select_domain = $select_domain[0]['target_id'];
    }
    $setValues = [];
    $message = "Copie de : " . $entitty_to_duplicate->label();
    $message .= ". <br>";
    if (!empty($title)) {
      if ($entitty_to_duplicate->getEntityTypeId() == "node") {
        $entitty_to_duplicate->set('title', $title);
      } else {
        $entitty_to_duplicate->set('name', $title);
      }
    }

    if (!empty($select_domain) && $entitty_to_duplicate->get($this->field_domain_access)->target_id != $select_domain) {
      $setValues = [
        \Drupal\domain_access\DomainAccessManagerInterface::DOMAIN_ACCESS_FIELD => $select_domain,
        \Drupal\domain_source\DomainSourceElementManagerInterface::DOMAIN_SOURCE_FIELD => $select_domain
      ];
      $message .= " Changement de domaine " . $entitty_to_duplicate->get($this->field_domain_access)->target_id . " par " . $select_domain;
      $message .= ". <br>";
    }
    $CopieDePage = $this->createCopie($entitty_to_duplicate, $setValues);
    if ($CopieDePage) {
      $message .= " Copie Ok ";
      $message .= ". <br>";
      $message .= " Nouvelle page : " . $CopieDePage->id();
      $this->messenger()->addStatus($message);
    } else {
      $message .= " Erreur de copie ";
      $this->messenger()->addWarning($message);
    }
  }

  /**
   * Permet de dupliquer une page avec la possibilité de changer de domaine.
   */
  protected function createCopie(\Drupal\Core\Entity\ContentEntityBase $entity, $setValues)
  {
    if (!$entity->isNew()) {
      return $this->DuplicateEntityReference->duplicateEntity($entity, false, [], $setValues, true);
    } else
      $this->messenger()->addError("Vous ne pouvez pas faire une copie d'une donnée qui n'est pas sauvegarder.");
  }
}
