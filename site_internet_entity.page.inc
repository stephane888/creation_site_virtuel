<?php

/**
 * @file
 * Contains site_internet_entity.page.inc.
 *
 * Page callback for Site internet entity entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Site internet entity templates.
 *
 * Default template: site_internet_entity.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_site_internet_entity(array &$variables) {
  // Fetch SiteInternetEntity Entity Object.
  $site_internet_entity = $variables['elements']['#site_internet_entity'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
