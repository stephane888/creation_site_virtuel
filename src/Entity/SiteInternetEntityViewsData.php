<?php

namespace Drupal\creation_site_virtuel\Entity;

use Drupal\views\EntityViewsData;

/**
 * Provides Views data for Site internet entity entities.
 */
class SiteInternetEntityViewsData extends EntityViewsData {

  /**
   * {@inheritdoc}
   */
  public function getViewsData() {
    $data = parent::getViewsData();

    // Additional information for Views integration, such as table joins, can be
    // put here.
    return $data;
  }

}
