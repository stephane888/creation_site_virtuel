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
  
  /**
   *
   * @param integer $id_entity
   * @return array
   */
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
    
    // $conf = ConfigDrupal::config('ovh_api_rest.settings');
    // $entities =
    /**
     *
     * @var \Drupal\creation_site_virtuel\Entity\SiteTypeDatas $entities
     */
    // $entities =
    // $this->entityTypeManager()->getStorage('paragraph')->load('10626');
    // $ar = $entities->toArray();
    // $entities->set('layout_builder__layout', $ar['layout_builder__layout']);
    // $entities->save();
    // /**
    // *
    // * @var \Drupal\layout_builder\Field\LayoutSectionItemList $layout_builder
    // */
    // $layout_builder = $entities->get('layout_builder__layout');
    // dump($ar);
    // $this->testDuplicateModelePageTranslate();
    // $this->testDuplicateNodeTranslate();
    $this->comprendreLeProblemeGetTranslation(15109);
    $this->comprendreLeProblemeGetTranslation(10623);
    //
    return [];
    //
    // $str = implode("\n", $out);
    // $cmd = " echo '" . $str . "' | sudo tee /etc/hosts ";
    // $exc = $this->excuteCmd($cmd);
    // if ($exc['return_var']) {
    // $this->logger->critical(' Error to update /etc/hosts <br> ' .
    // implode("<br>", $exc['output']));
    // $this->hasError = true;
    // }
    
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
    
    $connection = \Drupal::database();
    $query = $connection->select('node_field_data', 'nd');
    $query->addField('nd', 'nid');
    $query->condition('nd.status', 1);
    $query->condition('nd.type', 'realisations_entreprise_generale');
    $query->addJoin('INNER', 'node__field_domain_access', 'fda', 'fda.entity_id=nd.nid');
    $query->condition('fda.field_domain_access_target_id', 'test61_wb_horizon_kksa');
    dump($query->execute()->fetchAll(\PDO::ATTR_ERRMODE));
    //
    $file = File::load(799);
    if ($file) {
      $url = ImageStyle::load('medium')->buildUrl($file->getFileUri());
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_VERBOSE, 0);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      // curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/50.0 (compatible;)");
      curl_setopt($ch, CURLOPT_URL, urlencode($url));
      curl_exec($ch);
      curl_close($ch);
      dump($url);
    }
    if ($file == '000') {
      $logo_path = ImageStyle::load('medium')->buildUri($file->getFileUri());
      $img2 = ImageStyle::load('medium')->buildUrl($file->getFileUri());
      file_get_contents($img2);
      dump($img2);
      $file_url_generator = \Drupal::service('file_url_generator');
      $img_url = $file_url_generator->generateString($logo_path);
      dump($logo_path, $img_url, $file->getFileUri());
    }
  }
  
  protected function comprendreLeProblemeGetTranslation($id) {
    /**
     *
     * @var \Drupal\paragraphs\Entity\Paragraph $paragraph
     */
    $paragraph = $this->entityTypeManager()->getStorage('paragraph')->load($id);
    dump($paragraph);
    // dump($paragraph->getTranslation('en')->toArray());
  }
  
  /**
   * Permet de genere une page de site dans la langue courante à partir du model
   * de page.
   */
  protected function testDuplicateModelePageTranslate() {
    $lang_code = \Drupal::languageManager()->getCurrentLanguage()->getId();
    /**
     *
     * @var \Drupal\creation_site_virtuel\Entity\SiteTypeDatas $modelPage
     */
    $modelPage = $this->entityTypeManager()->getStorage('site_type_datas')->load(142);
    // on recupere le model de page en function de la langue encours.
    if ($modelPage->hasTranslation($lang_code)) {
      $modelPage = $modelPage->getTranslation($lang_code);
    }
    $values = [
      'type' => $modelPage->getType()
    ];
    /**
     *
     * @var \Drupal\creation_site_virtuel\Entity\SiteInternetEntity $pageSiteWeb
     */
    $pageSiteWeb = $this->entityTypeManager()->getStorage('site_internet_entity')->create($values);
    dump($pageSiteWeb->toArray());
    // on recupere la page du site web en function de la langue encours.
    // ( pour les contenus generer par l'interface, la langue par defaut c'est
    // la langue par defaut au niveau du site web ).
    if (!$pageSiteWeb->hasTranslation($lang_code)) {
      $pageSiteWeb = $pageSiteWeb->addTranslation($lang_code);
      // dans ce cas on doit definir cette langue comme langue par defaut,(
      // celle par defaut ne serra pas recuperer ).
      $pageSiteWeb->set('default_langcode', true);
    }
    // On transfert les données.
    $pageSiteWeb->set('name', $modelPage->getNameToMenu());
    $pageSiteWeb->save();
    dump($pageSiteWeb->toArray());
  }
  
  /**
   * Duplique un node dans la langue courante.
   */
  protected function testDuplicateNodeTranslate() {
    $lang_code = \Drupal::languageManager()->getCurrentLanguage()->getId();
    /**
     *
     * @var \Drupal\node\Entity\Node $node
     */
    $node = $this->entityTypeManager()->getStorage('node')->load(1860);
    // $clone = $node->createDuplicate();
    // $clone->save();
    // dump($node->getTranslation('en')->toArray());
    /**
     *
     * @var \Drupal\node\Entity\Node $newNode
     */
    $newNode = $this->entityTypeManager()->getStorage('node')->create([
      'type' => $node->bundle()
    ]);
    // On souhaite que le nouveau node($newNode) soit dans la langues courantes.
    if (!$newNode->hasTranslation($lang_code)) {
      $newNode = $newNode->addTranslation($lang_code);
    }
    // On recupere le contenu de la langue courante, si elle existe.
    if ($node->hasTranslation($lang_code)) {
      $node = $node->getTranslation($lang_code);
    }
    // on transfert les données.
    $newNode->set('title', $node->get('title')->getValue());
    // ... // set more fields.
    $newNode->save();
    // // On recupere les langues supplementaires.
    // $langues = $node->getTranslationLanguages();
    // $lang_codes = array_keys($langues);
    // if (!empty($lang_codes))
    // foreach ($lang_codes as $langcode) {
    // if ($langcode == $lang_code)
    // continue;
    // $nodeTanslate = $node->getTranslation($langcode);
    // if (!$newNode->hasTranslation($langcode)) {
    // $newNodeTranslate = $newNode->addTranslation($langcode);
    // $newNodeTranslate->set('title', $nodeTanslate->get('title')->getValue());
    // $newNodeTranslate->save();
    // }
    // }
    //
    // $newNode->save();
    // $newNode->addTranslation($langcode);
    dump($newNode);
    dump($newNode->toArray());
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
