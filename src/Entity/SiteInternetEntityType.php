<?php

namespace Drupal\creation_site_virtuel\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Site internet entity type entity.
 *
 * @ConfigEntityType(
 *   id = "site_internet_entity_type",
 *   label = @Translation("Site internet entity type"),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\creation_site_virtuel\SiteInternetEntityTypeListBuilder",
 *     "form" = {
 *       "add" = "Drupal\creation_site_virtuel\Form\SiteInternetEntityTypeForm",
 *       "edit" = "Drupal\creation_site_virtuel\Form\SiteInternetEntityTypeForm",
 *       "delete" = "Drupal\creation_site_virtuel\Form\SiteInternetEntityTypeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\creation_site_virtuel\SiteInternetEntityTypeHtmlRouteProvider",
 *     },
 *   },
 *   config_prefix = "site_internet_entity_type",
 *   admin_permission = "administer site configuration",
 *   bundle_of = "site_internet_entity",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "image",
 *     "terms",
 *     "derivees",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/site_internet_entity_type/{site_internet_entity_type}",
 *     "add-form" = "/admin/structure/site_internet_entity_type/add",
 *     "edit-form" = "/admin/structure/site_internet_entity_type/{site_internet_entity_type}/edit",
 *     "delete-form" = "/admin/structure/site_internet_entity_type/{site_internet_entity_type}/delete",
 *     "collection" = "/admin/structure/site_internet_entity_type"
 *   }
 * )
 */
class SiteInternetEntityType extends ConfigEntityBundleBase implements SiteInternetEntityTypeInterface {
  
  /**
   * The Site internet entity type ID.
   *
   * @var string
   */
  protected $id;
  
  /**
   * The Site internet entity type label.
   *
   * @var string
   */
  protected $label;
  
  /**
   * Contient l'image de base.
   *
   * @var array
   */
  protected $image = [];
  
  /**
   * Contient les terms taxo.
   *
   * @var array
   */
  protected $terms = [];
  
  /**
   * Faudra prendre le temps de reflechir sur les derivées.
   *
   * @var array
   */
  protected $derivees = [];
  
}
