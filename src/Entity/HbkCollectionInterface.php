<?php

namespace Drupal\creation_site_virtuel\Entity;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\RevisionLogInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\Core\Entity\EntityPublishedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface for defining Collection by Habeuk entities.
 *
 * @ingroup creation_site_virtuel
 */
interface HbkCollectionInterface extends ContentEntityInterface, RevisionLogInterface, EntityChangedInterface, EntityPublishedInterface, EntityOwnerInterface {

  /**
   * Add get/set methods for your configuration properties here.
   */

  /**
   * Gets the Collection by Habeuk name.
   *
   * @return string
   *   Name of the Collection by Habeuk.
   */
  public function getName();

  /**
   * Sets the Collection by Habeuk name.
   *
   * @param string $name
   *   The Collection by Habeuk name.
   *
   * @return \Drupal\creation_site_virtuel\Entity\HbkCollectionInterface
   *   The called Collection by Habeuk entity.
   */
  public function setName($name);

  /**
   * Gets the Collection by Habeuk creation timestamp.
   *
   * @return int
   *   Creation timestamp of the Collection by Habeuk.
   */
  public function getCreatedTime();

  /**
   * Sets the Collection by Habeuk creation timestamp.
   *
   * @param int $timestamp
   *   The Collection by Habeuk creation timestamp.
   *
   * @return \Drupal\creation_site_virtuel\Entity\HbkCollectionInterface
   *   The called Collection by Habeuk entity.
   */
  public function setCreatedTime($timestamp);

  /**
   * Gets the Collection by Habeuk revision creation timestamp.
   *
   * @return int
   *   The UNIX timestamp of when this revision was created.
   */
  public function getRevisionCreationTime();

  /**
   * Sets the Collection by Habeuk revision creation timestamp.
   *
   * @param int $timestamp
   *   The UNIX timestamp of when this revision was created.
   *
   * @return \Drupal\creation_site_virtuel\Entity\HbkCollectionInterface
   *   The called Collection by Habeuk entity.
   */
  public function setRevisionCreationTime($timestamp);

  /**
   * Gets the Collection by Habeuk revision author.
   *
   * @return \Drupal\user\UserInterface
   *   The user entity for the revision author.
   */
  public function getRevisionUser();

  /**
   * Sets the Collection by Habeuk revision author.
   *
   * @param int $uid
   *   The user ID of the revision author.
   *
   * @return \Drupal\creation_site_virtuel\Entity\HbkCollectionInterface
   *   The called Collection by Habeuk entity.
   */
  public function setRevisionUserId($uid);

}
