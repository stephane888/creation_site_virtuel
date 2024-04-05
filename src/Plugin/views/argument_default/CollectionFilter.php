<?php

namespace Drupal\creation_site_virtuel\Plugin\views\argument_default;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\creation_site_virtuel\SiteInternetEntityStorage;
use Drupal\views\Plugin\views\argument_default\ArgumentDefaultPluginBase;
use function PHPSTORM_META\map;

/**
 * Collection filter argument default plugin.
 *
 * @ViewsArgumentDefault(
 *   id = "creation_site_virtuel_collection_filter",
 *   title = @Translation("Collection filter")
 * )
 */
class CollectionFilter extends ArgumentDefaultPluginBase implements CacheableDependencyInterface {
  
  /**
   * The current route match.
   *
   * @var \Drupal\Core\Routing\RouteMatchInterface
   */
  protected $routeMatch;
  
  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $siteInternetEntity;
  
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
   * @param \Drupal\Core\Entity\SiteInternetEntityTypeForm $site_internet_entity
   *        The entity type manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $route_match, SiteInternetEntityStorage $site_internet_entity) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $route_match;
    $this->siteInternetEntity = $site_internet_entity;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('current_route_match'), $container->get('entity_type.manager')->getStorage("site_internet_entity"));
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function getArgument() {
    
    // @DCG
    // Here is the place where you should create a default argument for the
    // contextual filter. The source of this argument depends on your needs.
    // For example, you can extract the value from the URL or fetch it from
    // some fields of the current viewed entity.
    $result = "";
    $entity = $this->routeMatch->getParameter("site_internet_entity");
    if (!isset($entity)) {
      $entity = $this->routeMatch->getParameter("site_type_datas");
    }
    
    if (isset($entity)) {
      $field_values = $entity->get("hbk_collection")->getValue();
      if (!empty($field_values)) {
        
        if ($this->argument->options['break_phrase']) {
          $entities_ids = array_map(function ($value) {
            return $value["target_id"];
          }, $field_values);
          $result = implode("+", $entities_ids);
        }
        else {
          $result = $field_values[0]["target_id"];
        }
      }
    }
    else {
      // print an error message
    }
    return $result;
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
    // @DCG Use 'url' context if the argument comes from URL.
    return [];
  }
  
}
