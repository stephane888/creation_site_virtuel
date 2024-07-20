<?php

namespace Drupal\creation_site_virtuel;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class SiteInternetEntityStorage extends SqlContentEntityStorage implements SiteInternetEntityStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(SiteInternetEntityInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {site_internet_entity_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {site_internet_entity_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(SiteInternetEntityInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {site_internet_entity_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('site_internet_entity_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
