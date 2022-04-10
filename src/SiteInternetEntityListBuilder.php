<?php

namespace Drupal\creation_site_virtuel;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Site internet entity entities.
 *
 * @ingroup creation_site_virtuel
 */
class SiteInternetEntityListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Site internet entity ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\creation_site_virtuel\Entity\SiteInternetEntity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.site_internet_entity.edit_form',
      ['site_internet_entity' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
