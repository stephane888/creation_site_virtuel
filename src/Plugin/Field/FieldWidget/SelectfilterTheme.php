<?php

namespace Drupal\creation_site_virtuel\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Field\Plugin\Field\FieldWidget\OptionsWidgetBase;

/**
 * Plugin implementation of the 'options_buttons' widget.
 *
 * @FieldWidget(
 *   id = "selectfilter_theme",
 *   label = @Translation(" selection de theme "),
 *   field_types = {
 *     "entity_reference",
 *   },
 *   multiple_values = TRUE
 * )
 */
class SelectfilterTheme extends OptionsWidgetBase {
  
  /**
   *
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = parent::formElement($items, $delta, $element, $form, $form_state);
    //
    $options = $this->getOptions($items->getEntity());
    $selected = $this->getSelectedOptions($items);
    
    // If required and there is one single option, preselect it.
    if ($this->required && count($options) == 1) {
      reset($options);
      $selected = [
        key($options)
      ];
    }
    
    if ($this->multiple) {
      $element += [
        '#type' => 'checkboxes',
        '#default_value' => $selected,
        '#options' => $options
      ];
    }
    else {
      $element += [
        '#type' => 'radios',
        // Radio buttons need a scalar value. Take the first default value, or
        // default to NULL so that the form element is properly recognized as
        // not having a default value.
        '#default_value' => $selected ? reset($selected) : NULL,
        '#options' => $options,
        '#theme' => 'form-element--image',
        'preview' => [
          '#type' => 'html_tag',
          '#tag' => 'h3',
          '#value' => 'PReviews kksa888'
        ]
      ];
    }
    // dump($element);
    return $element;
  }
  
}