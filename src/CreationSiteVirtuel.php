<?php

namespace Drupal\creation_site_virtuel;

class CreationSiteVirtuel {
  
  public static function getCurrentUser() {
    return \Drupal::currentUser()->id();
  }
  
}