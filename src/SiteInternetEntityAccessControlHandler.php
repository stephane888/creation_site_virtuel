<?php

namespace Drupal\creation_site_virtuel;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Site internet entity entity.
 *
 * @see \Drupal\creation_site_virtuel\Entity\SiteInternetEntity.
 */
class SiteInternetEntityAccessControlHandler extends EntityAccessControlHandler {
  
  /**
   *
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\creation_site_virtuel\Entity\SiteInternetEntityInterface $entity */
    switch ($operation) {
      
      case 'view':
        
        if (!$entity->isPublished()) {
          $permission = $this->checkOwn($entity, 'view unpublished', $account);
          if (!empty($permission)) {
            return AccessResult::allowed();
          }
          
          return AccessResult::allowedIfHasPermission($account, 'view unpublished site internet entity entities');
        }
        else {
          // if entity is published, show
          return AccessResult::allowed();
        }
        
        $permission = $this->checkOwn($entity, $operation, $account);
        if (!empty($permission)) {
          return AccessResult::allowed();
        }
        
        return AccessResult::allowedIfHasPermission($account, 'view published site internet entity entities');
      
      case 'update':
        
        $permission = $this->checkOwn($entity, $operation, $account);
        if (!empty($permission)) {
          return AccessResult::allowed();
        }
        return AccessResult::allowedIfHasPermission($account, 'edit site internet entity entities');
      
      case 'delete':
        
        $permission = $this->checkOwn($entity, $operation, $account);
        if (!empty($permission)) {
          return AccessResult::allowed();
        }
        return AccessResult::allowedIfHasPermission($account, 'delete site internet entity entities');
    }
    
    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }
  
  /**
   *
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add site internet entity entities');
  }
  
  /**
   * Test for given 'own' permission.
   *
   * @param \Drupal\Core\Entity\EntityInterface $entity
   * @param
   *        $operation
   * @param \Drupal\Core\Session\AccountInterface $account
   *
   * @return string|null The permission string indicating it's allowed.
   */
  protected function checkOwn(EntityInterface $entity, $operation, AccountInterface $account) {
    $status = $entity->isPublished();
    $uid = $entity->getOwnerId();
    
    $is_own = $account->isAuthenticated() && $account->id() == $uid;
    if (!$is_own) {
      return;
    }
    
    $bundle = $entity->bundle();
    
    $ops = [
      'create' => '%bundle add own %bundle entities',
      'view unpublished' => '%bundle view own unpublished %bundle entities',
      'view' => '%bundle view own entities',
      'update' => '%bundle edit own entities',
      'delete' => '%bundle delete own entities'
    ];
    $permission = strtr($ops[$operation], [
      '%bundle' => $bundle
    ]);
    
    if ($operation === 'view unpublished') {
      if (!$status && $account->hasPermission($permission)) {
        return $permission;
      }
      else {
        return NULL;
      }
    }
    if ($account->hasPermission($permission)) {
      return $permission;
    }
    
    return NULL;
  }
  
}
