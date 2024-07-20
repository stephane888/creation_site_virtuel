<?php

namespace Drupal\creation_site_virtuel\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Site type datas entities.
 *
 * @ingroup creation_site_virtuel
 */
interface SiteTypeDatasInterface extends ContentEntityInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Site type datas name.
   *
   * @return string
   *   Name of the Site type datas.
   */
  public function getName();

  /**
   * Sets the Site type datas name.
   *
   * @param string $name
   *   The Site type datas name.
   *
   * @return \Drupal\creation_site_virtuel\Entity\SiteTypeDatasInterface
   *   The called Site type datas entity.
   */
  public function setName($name);

  /**
   * Gets the Site type datas creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Site type datas.
   */
  public function getCreatedTime();

  /**
   * Sets the Site type datas creation timestamp.
   *
   * @param int $timestamp
   *   The Site type datas creation timestamp.
   *
   * @return \Drupal\creation_site_virtuel\Entity\SiteTypeDatasInterface
   *   The called Site type datas entity.
   */
  public function setCreatedTime($timestamp);

}
