<?php

namespace Drupal\creation_site_virtuel\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Returns responses for Creation site virtuel routes.
 */
class CreationSiteVirtuelController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
