<?php

namespace Drupal\creation_site_virtuel;

class CreationSiteVirtuel {
  
  public static function getCurrentUser() {
    return \Drupal::currentUser()->id();
  }
  
  public static function getActiveDomain() {
    /**
     *
     * @var \Drupal\domain\DomainNegotiator $domainNegos
     */
    $domainNegos = \Drupal::service('domain.negotiator');
    return $domainNegos->getActiveId();
  }
  
}