<?php

namespace Drupal\creation_site_virtuel\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\views\Views;

/**
 * Permet de faire le rendu des vues, tout en tenant compte des champs exposé.
 *
 * @FieldFormatter(
 *   id = "creationsit_ds_views",
 *   label = @Translation(" Rendu via une vue V2 "),
 *   description = @Translation(" Permet de charger une vue en lui passant les paramettres provenant de l'entité "),
 *   field_types = {
 *     "entity_reference",
 *   },
 *   multiple_values = true
 * )
 */
class DisplayView extends FormatterBase {
  
  /**
   *
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return [
      'view_name_display' => null,
      'view_id' => null,
      'view_display' => null,
      'view_arguments' => [],
      'view_filters' => []
    ];
  }
  
  /**
   *
   * {@inheritdoc}
   * @see \Drupal\Core\Field\WidgetBase::settingsForm()
   */
  public function settingsForm($form, FormStateInterface $form_state) {
    $elements = parent::settingsForm($form, $form_state);
    $elements['view_name_display'] = [
      '#title' => $this->t(' Views'),
      '#type' => 'select',
      '#options' => $this->getViews(),
      '#required' => TRUE,
      '#default_value' => $this->configuration['view_name_display'],
      '#ajax' => [
        'callback' => self::class . '::SelectViewAndConfigure',
        'wrapper' => 'creation_site_virtuel_view_name_display_id',
        'effect' => 'fade'
      ]
    ];
    $elements['fields'] = [
      '#type' => 'details',
      '#open' => true,
      '#title' => t('Select display and configure view'),
      '#attributes' => [
        'id' => 'creation_site_virtuel_view_name_display_id'
      ],
      '#tree' => true
    ];
    return $elements;
  }
  
  /**
   *
   * @param FieldItemListInterface $items
   * @param string $langcode
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    return [];
  }
  
  /**
   * On charge toutes les vues.
   */
  protected function getViews() {
    $options = [];
    $query = \Drupal::entityQuery('view')->condition('status', TRUE)->accessCheck(TRUE);
    $ids = $query->execute();
    if ($ids) {
      $views = \Drupal::entityTypeManager()->getStorage('view')->loadMultiple($ids);
      foreach ($views as $val) {
        /**
         *
         * @var \Drupal\views\ViewExecutable $view
         */
        $view = $val->getExecutable();
        $displays = $view->storage->get('display');
        foreach ($displays as $display_id => $v) {
          $view->setDisplay($display_id);
          $options[$view->id() . ' ' . $display_id] = $view->getTitle() . ' (' . $v['display_title'] . ')';
        }
      }
    }
    
    return $options;
  }
  
  /**
   *
   * @param array $form
   * @param FormStateInterface $form_state
   * @return array
   */
  public static function SelectViewAndConfigure($form, FormStateInterface $form_state) {
    return $form['settings']['fields'];
  }
  
}