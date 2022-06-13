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
    //
    //
    // $values = [
    // 'type' => 'page_realisation'
    // ];
    // $entity =
    // $this->entityTypeManager()->getStorage('node')->create($values);
    // dump($entity->toArray());
    // /**
    // *
    // * @var \Drupal\commerce_product\Entity\Product $Product;
    // */
    // $Product =
    // $this->entityTypeManager()->getStorage('commerce_product')->load(38);
    // dump($Product->toArray());
    // /**
    // *
    // * @var \Drupal\commerce_product\Entity\Product $Product;
    // */
    // $Product =
    // $this->entityTypeManager()->getStorage('commerce_product')->load(39);
    // dump($Product->toArray());
    // /**
    // *
    // * @var \Drupal\commerce_product\Entity\Product $Product;
    // */
    // $Product =
    // $this->entityTypeManager()->getStorage('commerce_product')->load(15);
    // dump($Product->toArray());
    // /**
    // *
    // * @var \Drupal\commerce_product\Entity\Product $Product;
    // */
    // $Product =
    // $this->entityTypeManager()->getStorage('commerce_product')->load(2);
    // dump($Product->toArray());
    // /**
    // *
    // * @var \Drupal\commerce_product\Entity\Product $Product;
    // */
    // $Product =
    // $this->entityTypeManager()->getStorage('commerce_product')->load(4);
    // dump($Product->toArray());
    //
    // $menuLink =
    // $this->entityTypeManager()->getStorage('menu_link_content')->loadByProperties([
    // 'bundle' => 'main'
    // ]);
    // dump($menuLink);
    //
    // $value = "@lesKIO_DE-Froisdel#areno.fr pa pin";
    // dump(preg_replace('/[0-9\@\.\;\" "]+/', "", $value));
    // dump(preg_replace("/[A-Z]/", "", $value));
    // '/[^A-Za-z0-9\-]/'
    // valid un domaine
    // dump(preg_replace('/[^a-z0-9\-\.-]/', "", $value));
    // valid le debut d'un sous domaine
    // dump(preg_replace('/[^a-z0-9\-]/', "", $value));
    // $domain_name = 'dump';
    // if (preg_match("/^([a-zd](-*[a-zd])*)(.([a-zd](-*[a-zd])*))*$/i",
    // $domain_name) && // valid characters check
    // preg_match("/^.{1,253}$/", $domain_name) && // overall length check
    // preg_match("/^[^.]{1,63}(.[^.]{1,63})*$/", $domain_name)) {
    // var_dump("domaine valid");
    // }
    // else {
    // var_dump("domaine non valid");
    // }
    // validation d'une entité avec bundle.
    //
    //
    // $bundle_entity_type_id = 'mappings_entity';
    // $bundle = 'content_generate_entity';
    // $bundle_entity =
    // \Drupal::entityTypeManager()->getStorage($bundle_entity_type_id)->load($bundle);
    // dump($bundle_entity);
    // if ($bundle_entity) {
    // dump($bundle_entity->getConfigDependencyName());
    // }
    // else {
    // dump(\Drupal::entityTypeManager()->getStorage($bundle_entity_type_id)->loadMultiple());
    // }
    //
    // $blockContent =
    // $this->entityTypeManager()->getStorage('block_content')->load(46);
    // // $user = \Drupal\user\Entity\User::load(\Drupal::currentUser()->id());
    // // $serializer = \Drupal::service('serializer');
    // // $data = $serializer->serialize($user, 'json', [
    // // 'plugin_id' => 'entity'
    // // ]);
    // $users = [
    // 'users' => [
    // $user->toArray()
    // ]
    // ];
    // return $this->reponse($users);
    // return $build;
    //
    //
    // $blockContent =
    // $this->entityTypeManager()->getStorage('block_content')->load(188);
    // dump($blockContent->toArray());
    //
    //
    /**
     *
     * @var \Drupal\block\Entity\Block $entity
     */
    // $entities =
    // $this->entityTypeManager()->getStorage('block')->loadByProperties([
    // 'theme' => 'admin25_wb_horizon_kksa'
    // ]);
    // $blocks = [];
    // foreach ($entities as $entity) {
    // $blocks[] = $entity->toArray();
    // }
    // dump($blocks);
    //
    // $entity =
    // $this->entityTypeManager()->getStorage('block_content')->load(58);
    // dump($entity->toArray());
    /**
     * Charge un menu.
     */
    // $entities =
    // $this->entityTypeManager()->getStorage('menu')->loadByProperties([
    // 'theme' => 'admin23_wb_horizon_kksa'
    // ]);
    // $blocks = [];
    // foreach ($entities as $entity) {
    // $blocks[] = $entity->toArray();
    // }
    // dump($blocks);
    /**
     * Charge un item de menu.
     */
    // $entity =
    // $this->entityTypeManager()->getStorage('menu_link_content')->load(3);
    // dump($entity->toArray());
    
    // dump(system_region_list('admin26_wb_horizon_kksa'));
    
    /**
     * test de recuration via le multidomaine.
     *
     * @var $configs
     */
    /**
     *
     * @var \Drupal\domain_config\DomainConfigOverrider $DomainConfigOverrider
     */
    // $conf =
    // \Stephane888\Debug\Repositories\ConfigDrupal::config('ovh_api_rest.settings');
    // dump($conf);
    //
    $file = File::load(327);
    if ($file) {
      $logo_path = ImageStyle::load('medium')->buildUri($file->getFileUri());
      $img2 = ImageStyle::load('medium')->buildUrl($file->getFileUri());
      file_get_contents($img2);
      $file_url_generator = \Drupal::service('file_url_generator');
      $img_url = $file_url_generator->generateString($logo_path);
      dump($logo_path, $img_url, $file->getFileUri());
    }
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
