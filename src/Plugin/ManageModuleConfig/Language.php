<?php

namespace Drupal\creation_site_virtuel\Plugin\ManageModuleConfig;

use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\manage_module_config\ManageModuleConfigPluginBase;
use Drupal\Core\Url;

/**
 * Gestion du menu.
 *
 * @ManageModuleConfig(
 *   id = "manage_module_config_language",
 *   label = @Translation("Language"),
 *   description = @Translation("Foo description.")
 * )
 */
class Language extends ManageModuleConfigPluginBase {
  use StringTranslationTrait;
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\manage_module_config\ManageModuleConfigInterface::GetName()
   */
  public function GetName() {
    return $this->configuration['name'];
  }

  /**
   *
   * {@inheritdoc}
   * @see \Drupal\manage_module_config\ManageModuleConfigInterface::getRoute()
   */
  public function getRoute() {
    /**
     *
     * @var \Drupal\Core\Http\RequestStack $RequestStack
     */
    $RequestStack = \Drupal::service('request_stack');
    $Request = $RequestStack->getCurrentRequest();

    $url = Url::fromRoute('creation_site_virtuel.language', [
      "domain" => \Drupal\lesroidelareno\lesroidelareno::getCurrentDomainId()
    ], [
      'query' => [
        'destination' => $Request->getPathInfo()
      ]
    ]);
    return $url;
  }

  /**
   *
   * {@inheritdoc}
   * @see \Drupal\manage_module_config\ManageModuleConfigInterface::getDescription()
   */
  public function getDescription() {
    return $this->configuration['description'];
  }

  /**
   *
   * {@inheritdoc}
   * @see \Drupal\manage_module_config\ManageModuleConfigPluginBase::defaultConfiguration()
   */
  public function defaultConfiguration() {
    return [
      'name' => $this->t('Language'),
      'description' => $this->t("Language configurations of your website"),
      'icon_svg_class' => 'btn-wbu-background text-light btn-lg',
      'enable' => true,
      'icon_svg' => '<svg viewBox="0 0 24 24" width="1em" height="1em"  xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" clip-rule="evenodd" d="M14 7h7a3 3 0 0 1 3 3v11a3 3 0 0 1-3 3h-8a3 3 0 0 1-3-3v-4H3a3 3 0 0 1-3-3V3a3 3 0 0 1 3-3h8a3 3 0 0 1 3 3zm0 2v2h2a1 1 0 1 1 2 0h2a1 1 0 1 1 0 2h-.201a14.1 14.1 0 0 1-1.711 4.047q1.05 1.176 2.467 2.12a1 1 0 0 1-1.11 1.665 15 15 0 0 1-2.568-2.147A14.4 14.4 0 0 1 14.6 20.8a1 1 0 0 1-1.2-1.6 12.3 12.3 0 0 0 2.19-2.093 13 13 0 0 1-.984-1.66 1 1 0 1 1 1.789-.894q.188.375.401.735.57-1.071.93-2.288H14v1a3 3 0 0 1-2 2.83V21a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V10a1 1 0 0 0-1-1zm-7.78.5L7 7.162 7.78 9.5zm-.666 2h2.892l.605 1.816a1 1 0 1 0 1.898-.632l-3-9c-.304-.912-1.594-.912-1.898 0l-3 9a1 1 0 0 0 1.898.632z" fill="currentColor"/></svg>'

    ] + parent::defaultConfiguration();
  }
}
