<?php

namespace Drupal\creation_site_virtuel\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\lesroidelareno\Entity\DonneeSiteInternetEntity;
use Jawira\CaseConverter\Convert;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Component\Serialization\Json;
use Drupal\image\Entity\ImageStyle;
use Drupal\file\Entity\File;

/**
 * Returns responses for Creation site virtuel routes.
 */
class CreationSiteVirtuelController extends ControllerBase {
  
  /**
   */
  public function duplicatePage($site_internet_entity) {
    $entity = \Drupal\creation_site_virtuel\Entity\SiteInternetEntity::load($site_internet_entity);
    $datas['entitty_to_duplicate'] = $entity;
    $form = \Drupal::formBuilder()->getForm(\Drupal\creation_site_virtuel\Form\ManageDuplicateForm::class, $datas);
    return $form;
  }
  
  public function duplicateBlocks_contents($blocks_contents) {
    $entity = \Drupal\blockscontent\Entity\BlocksContents::load($blocks_contents);
    $datas['entitty_to_duplicate'] = $entity;
    $form = \Drupal::formBuilder()->getForm(\Drupal\creation_site_virtuel\Form\ManageDuplicateForm::class, $datas);
    return $form;
  }
  
  public function duplicateNode($node){
    $entity = \Drupal\node\Entity\Node::load($node);
    $datas['entitty_to_duplicate'] = $entity;
    $form = \Drupal::formBuilder()->getForm(\Drupal\creation_site_virtuel\Form\ManageDuplicateForm::class, $datas);
    return $form;
  }

  /**
   *
   * @param array|string $configs
   * @param number $code
   * @param string $message
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  protected function reponse($configs, $code = null, $message = null) {
    if (!is_string($configs))
      $configs = Json::encode($configs);
    $reponse = new JsonResponse();
    if ($code)
      $reponse->setStatusCode($code, $message);
    $reponse->setContent($configs);
    return $reponse;
  }
  
}
