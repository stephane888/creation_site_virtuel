<?php

namespace Drupal\creation_site_virtuel;

use Drupal\Core\Entity\ContentEntityStorageInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Language\LanguageInterface;
use Drupal\creation_site_virtuel\Entity\SiteInternetEntityInterface;

/**
 * Defines the storage handler class for Site internet entity entities.
 *
 * This extends the base storage class, adding required special handling for
 * Site internet entity entities.
 *
 * @ingroup creation_site_virtuel
 */
interface SiteInternetEntityStorageInterface extends ContentEntityStorageInterface {

  /**
   * Gets a list of Site internet entity revision IDs for a specific Site internet entity.
   *
   * @param \Drupal\creation_site_virtuel\Entity\SiteInternetEntityInterface $entity
   *   The Site internet entity entity.
   *
   * @return int[]
   *   Site internet entity revision IDs (in ascending order).
   */
  public function revisionIds(SiteInternetEntityInterface $entity);

  /**
   * Gets a list of revision IDs having a given user as Site internet entity author.
   *
   * @param \Drupal\Core\Session\AccountInterface $account
   *   The user entity.
   *
   * @return int[]
   *   Site internet entity revision IDs (in ascending order).
   */
  public function userRevisionIds(AccountInterface $account);

  /**
   * Counts the number of revisions in the default language.
   *
   * @param \Drupal\creation_site_virtuel\Entity\SiteInternetEntityInterface $entity
   *   The Site internet entity entity.
   *
   * @return int
   *   The number of revisions in the default language.
   */
  public function countDefaultLanguageRevisions(SiteInternetEntityInterface $entity);

  /**
   * Unsets the language for all Site internet entity with the given language.
   *
   * @param \Drupal\Core\Language\LanguageInterface $language
   *   The language object.
   */
  public function clearRevisionsLanguage(LanguageInterface $language);

}
