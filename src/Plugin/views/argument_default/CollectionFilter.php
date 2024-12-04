<?php

namespace Drupal\creation_site_virtuel\Plugin\views\argument_default;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Cache\Cache;
use Drupal\Core\Cache\CacheableDependencyInterface;
use Drupal\Core\Entity\EntityFieldManagerInterface;
use Drupal\Core\Routing\RouteMatchInterface;
use Drupal\field\Entity\FieldStorageConfig;
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
   * @var EntityFieldManagerInterface
   */
  protected $entityFieldManager;
  
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
  public function __construct(array $configuration, $plugin_id, $plugin_definition, RouteMatchInterface $route_match, EntityFieldManagerInterface $entity_field_manager) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->routeMatch = $route_match;
    $this->entityFieldManager = $entity_field_manager;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('current_route_match'), $container->get('entity_field.manager'));
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
    
    // dd($this->routeMatch->getParameters());
    $route_name = $this->routeMatch->getRouteName();
    [
      $prefix,
      $middle,
      $suffix
    ] = explode(".", $route_name);
    
    // If it's not an entity page then nothing happens
    if (!isset($prefix) || !isset($middle) || $prefix !== "entity") {
      return $result;
    }
    
    /**
     *
     * @var \Drupal\Core\Entity\ContentEntityBase $entity
     */
    $entity = $this->routeMatch->getParameter($middle);
    
    if (isset($entity)) {
      
      // Il faut trouver le moyen de determiner quel champ sélectionner de
      // manière automatique
      // Ceci n'est qu'une solution temporaire
      $field_values = match (true) {
          $entity->hasField("hbk_collection") => $entity->get("hbk_collection")->getValue(),
          $entity->hasField("field_collections") => $entity->get("field_collections")->getValue(),
          default => []
      };
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
      else {
        $this->messenger()->addWarning("Le champs 'hbk_collection' ou 'field_collections' n'est pas definit dans l'entites qui est visité => (" . $entity->id() . " // " . $entity->label() . ")");
      }
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
    return [
      'url'
    ];
  }
  
  /**
   *
   * Pas encore au point
   * the field name or false if there's no reference
   *
   * @return bool|string
   */
  function checkEntityReference($target_type) {
    // Récupérer la carte de tous les champs de référence d'entité
    $map = $this->entityFieldManager->getFieldMapByFieldType('entity_reference');
    $results = [];
    
    // Parcourir tous les types d'entités et leurs champs
    foreach ($map as $entity_type => $fields) {
      foreach ($fields as $field_name => $field) {
        // Charger la configuration du champ pour vérifier le type de cible
        $config = FieldStorageConfig::loadByName($entity_type, $field_name);
        if ($config && $config->getSetting('target_type') == $target_type) {
          // Exécuter une requête d'entité pour trouver toutes les entités qui
          // référencent l'ID cible
          return $field_name;
        }
      }
    }
    
    return $results;
  }
}
