<?php

/**
 * @file
 * Contains site_type_datas.page.inc.
 *
 * Page callback for Site type datas entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Site type datas templates.
 *
 * Default template: site_type_datas.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_site_type_datas(array &$variables) {
  // Fetch SiteTypeDatas Entity Object.
  $site_type_datas = $variables['elements']['#site_type_datas'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
