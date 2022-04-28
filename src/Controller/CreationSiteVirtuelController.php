<?php

namespace Drupal\creation_site_virtuel\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\lesroidelareno\Entity\DonneeSiteInternetEntity;
use Jawira\CaseConverter\Convert;

/**
 * Returns responses for Creation site virtuel routes.
 */
class CreationSiteVirtuelController extends ControllerBase {
  
  /**
   * Builds the response.
   */
  public function build() {
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!')
    ];
    
    return $build;
  }
  
  public function formSave($id_entity) {
    $uid = $this->currentUser()->id();
    //
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!')
    ];
    //
    if (!$uid) {
      $build['content'] = [
        '#type' => 'html_tag',
        '#tag' => 'section',
        "#attributes" => [
          'id' => 'donnee-internet-entity-next-field',
          'class' => [
            'step-donneesite',
            'mx-auto',
            'text-center'
          ]
        ],
        '#weight' => -10
      ];
      $build['donnee-internet-entity'][] = [
        '#type' => 'html_tag',
        '#tag' => 'div',
        '#attributes' => [
          'class' => [
            'step-donneesite--header',
            'with-tablet',
            'mx-auto',
            'text-center'
          ]
        ],
        [
          '#type' => 'html_tag',
          '#tag' => 'h2',
          '#value' => 'Veillez vous connectez afin de sauvegarder vos données',
          '#attributes' => [
            'class' => [
              'step-donneesite--title'
            ]
          ]
        ],
        [
          '#type' => 'html_tag',
          '#tag' => 'div',
          '#attributes' => [
            'id' => 'appLoginRegister',
            'action_after_login' => 'emit_even'
          ],
          '#value' => 'ff',
          '#weight' => 10
        ]
      ];
      $build['donnee-internet-entity']['#attached']['library'][] = "lesroidelareno/lesroidelareno_login";
    }
    else {
      // $DonneeSiteInternet = DonneeSiteInternetEntity::loadMultiple();
      // if (!empty($DonneeSiteInternet))
      // foreach ($DonneeSiteInternet as $node) {
      // // $node->delete();
      // }
      // return $this->redirect('user.page');
    }
    
    // $entity = $this->entityTypeManager()->getStorage('donnee_internet_entity')->load(26);
    // $entity->setDomainOvhEntity(1565);
    // $entity->save();
    // dump($entity->get('domain_ovh_entity')->target_id);
    $sub_domain = "gabi-attitude.lesroisdelareno.fr";
    $textConvert = new Convert($sub_domain);
    $domain_id = $textConvert->toSnake();
    $domain_id = str_replace('.', '_', $domain_id);
    dump($domain_id);
    
    return $build;
  }
  
}
