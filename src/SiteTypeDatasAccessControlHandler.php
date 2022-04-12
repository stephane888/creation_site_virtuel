<?php

namespace Drupal\creation_site_virtuel;

use Drupal\Core\Entity\EntityAccessControlHandler;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Access\AccessResult;

/**
 * Access controller for the Site type datas entity.
 *
 * @see \Drupal\creation_site_virtuel\Entity\SiteTypeDatas.
 */
class SiteTypeDatasAccessControlHandler extends EntityAccessControlHandler {

  /**
   * {@inheritdoc}
   */
  protected function checkAccess(EntityInterface $entity, $operation, AccountInterface $account) {
    /** @var \Drupal\creation_site_virtuel\Entity\SiteTypeDatasInterface $entity */

    switch ($operation) {

      case 'view':

        if (!$entity->isPublished()) {
          return AccessResult::allowedIfHasPermission($account, 'view unpublished site type datas entities');
        }


        return AccessResult::allowedIfHasPermission($account, 'view published site type datas entities');

      case 'update':

        return AccessResult::allowedIfHasPermission($account, 'edit site type datas entities');

      case 'delete':

        return AccessResult::allowedIfHasPermission($account, 'delete site type datas entities');
    }

    // Unknown operation, no opinion.
    return AccessResult::neutral();
  }

  /**
   * {@inheritdoc}
   */
  protected function checkCreateAccess(AccountInterface $account, array $context, $entity_bundle = NULL) {
    return AccessResult::allowedIfHasPermission($account, 'add site type datas entities');
  }


}
