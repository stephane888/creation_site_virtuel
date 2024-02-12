<?php

namespace Drupal\creation_site_virtuel;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Link;
use Drupal\creation_site_virtuel\Entity\SiteInternetEntity;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Site internet entity entities.
 *
 * @ingroup creation_site_virtuel
 */
class SiteInternetEntityListBuilder extends EntityListBuilder {
  
  /**
   * Contient les domaines de la page.
   *
   * @var array
   */
  protected $domains = [];
  
  /**
   *
   * {@inheritdoc}
   */
  public function buildHeader() {
    $field_access = \Drupal\domain_access\DomainAccessManagerInterface::DOMAIN_ACCESS_FIELD;
    $header['id'] = $this->t('Site internet entity ID');
    $header['name'] = $this->t('Name');
    $header['is_home_page'] = $this->t('Type de page');
    $header[$field_access] = $this->t('Domaine');
    return $header + parent::buildHeader();
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $field_access = \Drupal\domain_access\DomainAccessManagerInterface::DOMAIN_ACCESS_FIELD;
    /* @var \Drupal\creation_site_virtuel\Entity\SiteInternetEntity $entity */
    $row['id'] = $entity->id();
    $row['name'] = Link::createFromRoute($entity->label(), 'entity.site_internet_entity.canonical', [
      'site_internet_entity' => $entity->id()
    ]);
    $row['is_home_page'] = $entity->isHomePage() ? "Page d'accueil" : "Page simple";
    $domain = $this->getDomain($entity->get($field_access)->target_id);
    $hostname = '#';
    $DomainLabel = '';
    if ($domain) {
      $DomainLabel = $domain->label();
      $hostname = $domain->getPath();
    }
    $row[$field_access] = [
      'data' => [
        '#type' => 'html_tag',
        '#tag' => 'a',
        '#value' => $DomainLabel,
        '#attributes' => [
          'href' => $hostname,
          'target' => '_blank',
          'class' => []
        ]
      ]
    ];
    return $row + parent::buildRow($entity);
  }
  
  /**
   *
   * @param string $domain_id
   * @return \Drupal\domain\Entity\Domain
   */
  public function getDomain(string $domain_id) {
    if (empty($this->domains[$domain_id])) {
      $this->domains[$domain_id] = \Drupal\domain\Entity\Domain::load($domain_id);
    }
    return $this->domains[$domain_id];
  }
  
}
