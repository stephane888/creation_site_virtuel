<?php

namespace Drupal\creation_site_virtuel;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\taxonomy\Entity\Term;
use Drupal\file\Entity\File;

/**
 * Defines a class to build a listing of Site type datas entities.
 *
 * @ingroup creation_site_virtuel
 */
class SiteTypeDatasListBuilder extends EntityListBuilder {

  /**
   *
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['id'] = $this->t(' ID ');
    $header['image'] = $this->t(" Image du model");
    $header['name'] = $this->t(' Name ');
    // $header['site_internet_entity_type'] = $this->t(' Type de site web');
    $header['terms'] = $this->t(' Categories ');
    $header['is_home_page'] = $this->t(" page d'accueil ? ");
    return $header + parent::buildHeader();
  }

  /**
   *
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    /* @var \Drupal\creation_site_virtuel\Entity\SiteTypeDatas $entity */
    $row['id'] = $entity->id();

    $fileUrl = '';
    $fid = $entity->getImageModel();
    if (!empty($fid)) {
      $file = File::load($fid);
      $fileUrl = [
        '#theme' => 'image_style',
        '#uri' => $file->getFileUri(),
        '#style_name' => 'medium'
      ];
      $fileUrl = \Drupal::service('renderer')->renderRoot($fileUrl);
    }

    $row['image'] = $fileUrl;
    $row['name'] = Link::createFromRoute($entity->label(), 'entity.site_type_datas.edit_form', [
      'site_type_datas' => $entity->id()
    ]);
    // $row['site_internet_entity_type'] = $entity->getType();
    $row['terms'] = $this->getLabelTerms($entity->get('terms')->getValue());
    $row['is_home_page'] = $entity->get('is_home_page')->value ? 'Oui' : 'Non';
    return $row + parent::buildRow($entity);
  }

  /**
   *
   * @param array $values
   */
  private function getLabelTerms(array $values) {
    $li = [];
    foreach ($values as $k => $val) {
      if (!empty($val['target_id'])) {
        $term = Term::load($val['target_id']);
        if ($term) {
          $label = $term->label();
          $label = is_array($label) ? reset($label) : $label;
          $li = [
            '#type' => 'html_tag',
            '#tag' => 'li',
            '#value' => $label
          ];
        }
      }
    }
    $ul = [
      '#type' => 'html_tag',
      '#tag' => 'ul',
      $li
    ];
    return (render($ul));
  }

}
