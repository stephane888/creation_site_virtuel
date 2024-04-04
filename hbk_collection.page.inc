<?php

/**
 * @file
 * Contains hbk_collection.page.inc.
 *
 * Page callback for Collection by Habeuk entities.
 */

use Drupal\Core\Render\Element;

/**
 * Prepares variables for Collection by Habeuk templates.
 *
 * Default template: hbk_collection.html.twig.
 *
 * @param array $variables
 *   An associative array containing:
 *   - elements: An associative array containing the user information and any
 *   - attributes: HTML attributes for the containing element.
 */
function template_preprocess_hbk_collection(array &$variables) {
  // Fetch HbkCollection Entity Object.
  $hbk_collection = $variables['elements']['#hbk_collection'];

  // Helpful $content variable for templates.
  foreach (Element::children($variables['elements']) as $key) {
    $variables['content'][$key] = $variables['elements'][$key];
  }
}
