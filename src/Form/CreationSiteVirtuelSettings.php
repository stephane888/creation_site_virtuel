<?php

namespace Drupal\creation_site_virtuel\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;

/**
 * Class SiteTypeDatasSettingsForm.
 *
 * @ingroup creation_site_virtuel
 */
class CreationSiteVirtuelSettings extends ConfigFormBase {

  /**
   * Drupal\domain_config_ui\Config\ConfigFactory definition.
   *
   * @var \Drupal\domain_config_ui\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Drupal\Core\Entity\EntityTypeManagerInterface definition.
   *
   * @var EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->configFactory = $container->get('config.factory');
    $instance->entityTypeManager = $container->get('entity_type.manager');
    return $instance;
  }

  /**
   *
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'creation_site_virtuel_settings';
  }

  /**
   *
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      'creation_site_virtuel.settings'
    ];
  }

  /**
   *
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $paragraph_types = $this->entityTypeManager->getStorage('paragraphs_type')->loadMultiple();
    $paragraphs = [];
    foreach ($paragraph_types as $paragraph_type) {
      $paragraphs[$paragraph_type->id()] = $paragraph_type->id();
    }
    $config = $this->config('creation_site_virtuel.settings');
    $form['entete_paragraph_type'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t(" Selectionner les types de paragraphes pour l'entete "),
      '#default_value' => !empty($config->get('entete_paragraph_type')) ? $config->get('entete_paragraph_type') : [],
      '#options' => $paragraphs
    ];
    $form['footer_paragraph_type'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t("Selectionner les types de paragraphes pour le pied de page"),
      '#default_value' => !empty($config->get('footer_paragraph_type')) ? $config->get('footer_paragraph_type') : [],
      '#options' => $paragraphs
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   *
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('creation_site_virtuel.settings');
    $config->set('entete_paragraph_type', $form_state->getValue('entete_paragraph_type'));
    $config->set('footer_paragraph_type', $form_state->getValue('footer_paragraph_type'));
    $config->save();
    parent::submitForm($form, $form_state);
  }

}