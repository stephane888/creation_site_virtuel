<?php

namespace Drupal\creation_site_virtuel\Plugin\views\argument_default;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\creation_site_virtuel\Entity\HbkCollectionInterface;
use Drupal\views\Plugin\views\argument_default\ArgumentDefaultPluginBase;
use function PHPSTORM_META\map;

/**
 * Collection filter argument default plugin.
 *
 * @ViewsArgumentDefault(
 *   id = "creation_sittuel_collection_current_id",
 *   title = @Translation("Collection filter ID")
 * )
 */
class CollectionCurrentId extends ArgumentDefaultPluginBase implements CacheableDependencyInterface {
  
  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;
  
  /**
   * Constructs a new TestEn instance.
   *
   * @param array $configuration
   *        The plugin configuration, i.e. an array with configuration values
   *        keyed
   *        by configuration option name. The special key 'context' may be used
   *        to
   *        initialize the defined contexts by setting it to an array of context
   *        values keyed by context names.
   * @param string $plugin_id
   *        The plugin_id for the plugin instance.
   * @param mixed $plugin_definition
   *        The plugin implementation definition.
   * @param \Drupal\Core\Routing\RouteMatchInterface $route_match
   *        The current route match.
   *        The entity type manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $route_match) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $route_match;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('current_route_match'));
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function getArgument() {
    if (($hbk_collection = $this->routeMatch->getParameter('hbk_collection')) && $hbk_collection instanceof HbkCollectionInterface) {
      return $hbk_collection->id();
    }
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function getCacheMaxAge() {
    return Cache::PERMANENT;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return [
      'url'
    ];
  }
}
