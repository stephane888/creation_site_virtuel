<?php

namespace Drupal\creation_site_virtuel;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\creation_site_virtuel\Entity\HbkCollectionInterface;

/**
 * Defines the storage handler class for Collection by Habeuk entities.
 *
 * This extends the base storage class, adding required special handling for
 * Collection by Habeuk entities.
 *
 * @ingroup creation_site_virtuel
 */
interface HbkCollectionStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Collection by Habeuk revision IDs for a specific Collection by Habeuk.
   *
   * @param \Drupal\creation_site_virtuel\Entity\HbkCollectionInterface $entity
   *   The Collection by Habeuk entity.
   *
   * @return int[]
   *   Collection by Habeuk revision IDs (in ascending order).
   */
  public function revisionIds(HbkCollectionInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Collection by Habeuk author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Collection by Habeuk revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\creation_site_virtuel\Entity\HbkCollectionInterface $entity
   *   The Collection by Habeuk entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(HbkCollectionInterface $entity);

  /**
   * Unsets the language for all Collection by Habeuk with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
