<?php

namespace Drupal\creation_site_virtuel\Form;

use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a form for deleting Site type datas entities.
 *
 * @ingroup creation_site_virtuel
 */
class SiteTypeDatasDeleteForm extends ContentEntityDeleteForm {

  public function buildForm(array $form, FormStateInterface $form_state) {
    $form = parent::buildForm($form, $form_state);
    $form['infos_html'] = [
      '#type' => 'html_tag',
      '#tag' => 'div',
      '#value' => "Les entites en reference seront egalement supprimer"
    ];
    return $form;
  }

}
