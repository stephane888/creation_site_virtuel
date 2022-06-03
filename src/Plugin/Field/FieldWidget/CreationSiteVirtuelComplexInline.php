<?php

namespace Drupal\creation_site_virtuel\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\inline_entity_form\Plugin\Field\FieldWidget\InlineEntityFormComplex;

/**
 * A widget bar.
 *
 * @FieldWidget(
 *   id = "creationsitevirtuelcomplexinline",
 *   label = @Translation(" Create site virtual Complexe inline "),
 *   field_types = {
 *     "entity_reference",
 *   },
 *   multiple_values = true
 * )
 */
class CreationSiteVirtuelComplexInline extends InlineEntityFormComplex {
  
  /**
   *
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element += parent::formElement($items, $delta, $element, $form, $form_state);
    return $element;
  }
  
  /**
   * Le rendu inline_entity_form_complex a explicitement desactivé la valeur par
   * defaut.
   *
   * L'objectif est de definir des valeurs par defaut.
   *
   * {@inheritdoc}
   * @see \Drupal\inline_entity_form\Plugin\Field\FieldWidget\InlineEntityFormBase::form()
   */
  // public function form(FieldItemListInterface $items, array &$form,
  // FormStateInterface $form_state, $get_delta = NULL) {
  // if (!$this->isDefaultValueWidget($form_state))
  // return parent::form($items, $form, $form_state, $get_delta);
  // else {
  // return parent::form($items, $form, $form_state, $get_delta);
  // }
  // }
  
  // protected function canBuildForm(FormStateInterface $form_state) {
  // return true;
  // }
  
  /**
   *
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $settingForm = parent::settingsForm($form, $form_state);
    // dump($settingForm);
    return $settingForm;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $settingsSummary = parent::settingsSummary();
    // dump($settingsSummary);
    return $settingsSummary;
  }
  
  public function _getIefId() {
    return $this->getIefId();
  }
  
}