<?php

namespace Drupal\creation_site_virtuel;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;

/**
 * Defines a class to build a listing of Site type datas entities.
 *
 * @ingroup creation_site_virtuel
 */
class SiteTypeDatasListBuilder extends EntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t('Site type datas ID');
    $header['name'] = $this->t('Name');
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\creation_site_virtuel\Entity\SiteTypeDatas $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute(
      $entity->label(),
      'entity.site_type_datas.edit_form',
      ['site_type_datas' => $entity->id()]
    );
    return $row + parent::buildRow($entity);
  }

}
