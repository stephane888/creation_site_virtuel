<?php

namespace Drupal\creation_site_virtuel\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Site internet entity entities.
 *
 * @ingroup creation_site_virtuel
 */
interface SiteInternetEntityInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Site internet entity name.
   *
   * @return string
   *   Name of the Site internet entity.
   */
  public function getName();

  /**
   * Sets the Site internet entity name.
   *
   * @param string $name
   *   The Site internet entity name.
   *
   * @return \Drupal\creation_site_virtuel\Entity\SiteInternetEntityInterface
   *   The called Site internet entity entity.
   */
  public function setName($name);

  /**
   * Gets the Site internet entity creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Site internet entity.
   */
  public function getCreatedTime();

  /**
   * Sets the Site internet entity creation timestamp.
   *
   * @param int $timestamp
   *   The Site internet entity creation timestamp.
   *
   * @return \Drupal\creation_site_virtuel\Entity\SiteInternetEntityInterface
   *   The called Site internet entity entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Site internet entity revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Site internet entity revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\creation_site_virtuel\Entity\SiteInternetEntityInterface
   *   The called Site internet entity entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Site internet entity revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Site internet entity revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\creation_site_virtuel\Entity\SiteInternetEntityInterface
   *   The called Site internet entity entity.
   */
  public function setRevisionUserId($uid);

}
