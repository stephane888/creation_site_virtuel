<?php

namespace Drupal\creation_site_virtuel;

use Drupal\Core\Entity\Sql\SqlContentEntityStorage;
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
class HbkCollectionStorage extends SqlContentEntityStorage implements HbkCollectionStorageInterface {

  /**
   * {@inheritdoc}
   */
  public function revisionIds(HbkCollectionInterface $entity) {
    return $this->database->query(
      'SELECT vid FROM {hbk_collection_revision} WHERE id=:id ORDER BY vid',
      [':id' => $entity->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function userRevisionIds(AccountInterface $account) {
    return $this->database->query(
      'SELECT vid FROM {hbk_collection_field_revision} WHERE uid = :uid ORDER BY vid',
      [':uid' => $account->id()]
    )->fetchCol();
  }

  /**
   * {@inheritdoc}
   */
  public function countDefaultLanguageRevisions(HbkCollectionInterface $entity) {
    return $this->database->query('SELECT COUNT(*) FROM {hbk_collection_field_revision} WHERE id = :id AND default_langcode = 1', [':id' => $entity->id()])
      ->fetchField();
  }

  /**
   * {@inheritdoc}
   */
  public function clearRevisionsLanguage(LanguageInterface $language) {
    return $this->database->update('hbk_collection_revision')
      ->fields(['langcode' => LanguageInterface::LANGCODE_NOT_SPECIFIED])
      ->condition('langcode', $language->getId())
      ->execute();
  }

}
