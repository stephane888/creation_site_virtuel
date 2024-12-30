<?php

namespace Drupal\creation_site_virtuel;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Collection by Habeuk entity.
 *
 * @see \Drupal\creation_site_virtuel\Entity\HbkCollection.
 */
class HbkCollectionAccessControlHandler extends EntityAccessControlHandler {
  
  /**
   *
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\creation_site_virtuel\Entity\HbkCollectionInterface $entity */
    switch ($operation) {
      
      case 'view':
        
        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished collection by habeuk entities');
        }
        /**
         * Pour l'instant on autorise tout le monde à voir les contenus publiés.
         * On verra apres pour les ameliorations.
         */
        return AccessResult::allowed();
      
      case 'update':
        
        return AccessResult::allowedIfHasPermission($account, 'edit collection by habeuk entities');
      
      case 'delete':
        
        return AccessResult::allowedIfHasPermission($account, 'delete collection by habeuk entities');
    }
    
    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }
  
  /**
   *
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add collection by habeuk entities');
  }
}
