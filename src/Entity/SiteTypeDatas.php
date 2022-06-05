<?php

namespace Drupal\creation_site_virtuel\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;
use Drupal\link\LinkItemInterface;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

/**
 * Defines the Site type datas entity.
 *
 * @ingroup creation_site_virtuel
 *
 * @ContentEntityType(
 *   id = "site_type_datas",
 *   label = @Translation("Site type datas ( données de presentation de  modele ) "),
 *   handlers = {
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\creation_site_virtuel\SiteTypeDatasListBuilder",
 *     "views_data" = "Drupal\creation_site_virtuel\Entity\SiteTypeDatasViewsData",
 *     "translation" = "Drupal\creation_site_virtuel\SiteTypeDatasTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\creation_site_virtuel\Form\SiteTypeDatasForm",
 *       "add" = "Drupal\creation_site_virtuel\Form\SiteTypeDatasForm",
 *       "edit" = "Drupal\creation_site_virtuel\Form\SiteTypeDatasForm",
 *       "delete" = "Drupal\creation_site_virtuel\Form\SiteTypeDatasDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\creation_site_virtuel\SiteTypeDatasHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\creation_site_virtuel\SiteTypeDatasAccessControlHandler",
 *   },
 *   base_table = "site_type_datas",
 *   data_table = "site_type_datas_field_data",
 *   translatable = TRUE,
 *   admin_permission = "administer site type datas entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   links = {
 *     "canonical" = "/admin/structure/site_type_datas/{site_type_datas}",
 *     "add-form" = "/admin/structure/site_type_datas/add",
 *     "edit-form" = "/admin/structure/site_type_datas/{site_type_datas}/edit",
 *     "delete-form" = "/admin/structure/site_type_datas/{site_type_datas}/delete",
 *     "collection" = "/admin/structure/site_type_datas",
 *   },
 *   field_ui_base_route = "site_type_datas.settings"
 * )
 */
class SiteTypeDatas extends ContentEntityBase implements SiteTypeDatasInterface {
  
  use EntityChangedTrait;
  use EntityPublishedTrait;
  public static $key_type = 'site_internet_entity_type';
  
  /**
   *
   * {@inheritdoc}
   *
   */
  public static function preCreate(EntityStorageInterface $storage_controller, array &$values) {
    parent::preCreate($storage_controller, $values);
    $values += [
      'user_id' => \Drupal::currentUser()->id()
    ];
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function getName() {
    return $this->get('name')->value;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function setName($name) {
    $this->set('name', $name);
    return $this;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function getCreatedTime() {
    return $this->get('created')->value;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function setCreatedTime($timestamp) {
    $this->set('created', $timestamp);
    return $this;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function getOwner() {
    return $this->get('user_id')->entity;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function getOwnerId() {
    return $this->get('user_id')->target_id;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function setOwnerId($uid) {
    $this->set('user_id', $uid);
    return $this;
  }
  
  public function getType() {
    return $this->get(self::$key_type)->target_id;
  }
  
  public function getCategorie() {
    return $this->get('terms')->target_id;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }
  
  public function preSave($storage) {
    if (empty($this->getType())) {
      throw new \LogicException('Le type de site web doit etre definie (site_internet_entity_type). ');
    }
    parent::preSave($storage);
  }
  
  public function getFirstImage() {
    if ($this->get('image')->first()) {
      $fisrt = $this->get('image')->first();
      if (!empty($fisrt)) {
        $val = $fisrt->getValue();
        if (!empty($val['target_id'])) {
          return $val['target_id'];
        }
      }
    }
    
    return $this->get('image')->target_id;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);
    
    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);
    
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')->setLabel(t('Authored by'))->setDescription(t('The user ID of author of the Site type datas entity.'))->setRevisionable(TRUE)->setSetting('target_type', 'user')->setSetting('handler', 'default')->setTranslatable(TRUE)->setDisplayOptions('view', [
      'label' => 'hidden',
      'type' => 'author',
      'weight' => 0
    ])->setDisplayOptions('form', [
      'type' => 'entity_reference_autocomplete',
      'weight' => 5,
      'settings' => [
        'match_operator' => 'CONTAINS',
        'size' => '60',
        'autocomplete_type' => 'tags',
        'placeholder' => ''
      ]
    ])->setDisplayConfigurable('form', TRUE)->setDisplayConfigurable('view', TRUE);
    
    $fields['name'] = BaseFieldDefinition::create('string')->setLabel(t('Name'))->setDescription(t('The name of the Site type datas entity.'))->setSettings([
      'max_length' => 50,
      'text_processing' => 0
    ])->setDefaultValue('')->setDisplayOptions('view', [
      'label' => 'above',
      'type' => 'string',
      'weight' => -4
    ])->setDisplayOptions('form', [
      'type' => 'string_textfield',
      'weight' => -4
    ])->setDisplayConfigurable('form', TRUE)->setDisplayConfigurable('view', TRUE)->setRequired(TRUE);
    
    $fields['status']->setDescription(t('A boolean indicating whether the Site type datas is published.'))->setDisplayOptions('form', [
      'type' => 'boolean_checkbox',
      'weight' => -3
    ]);
    
    $fields['created'] = BaseFieldDefinition::create('created')->setLabel(t('Created'))->setDescription(t('The time that the entity was created.'));
    
    $fields['changed'] = BaseFieldDefinition::create('changed')->setLabel(t('Changed'))->setDescription(t('The time that the entity was last edited.'));
    
    $fields[self::$key_type] = BaseFieldDefinition::create('entity_reference')->setLabel(t('Type de site'))->setRequired(true)->setDisplayOptions('form', [
      'type' => 'options_select',
      'weight' => 5,
      'settings' => array(
        'match_operator' => 'CONTAINS',
        'size' => '10',
        'autocomplete_type' => 'tags',
        'placeholder' => ''
      )
    ])->setSetting('target_type', self::$key_type)->setSetting('handler', 'default')->setDisplayConfigurable('view', TRUE)->setDisplayConfigurable('form', true);
    //
    $fields['terms'] = BaseFieldDefinition::create('entity_reference')->setLabel(" Sélectionner les categories ")->setDisplayOptions('form', [
      'type' => 'select2_entity_reference',
      'weight' => 5,
      'settings' => array(
        'match_operator' => 'CONTAINS',
        'size' => '10',
        'autocomplete_type' => 'tags',
        'placeholder' => ''
      )
    ])->setDisplayConfigurable('view', TRUE)->setDisplayConfigurable('form', true)->setDescription(t(" Selectionnez ou ajouté une categorie pour ce theme "))->setSetting('handler_settings', [
      'target_bundles' => [
        'typesite' => 'typesite'
      ],
      'sort' => [
        'field' => 'name',
        'direction' => 'asc'
      ],
      'auto_create' => true,
      'auto_create_bundle' => ''
    ])->setSetting('target_type', 'taxonomy_term')->setSetting('handler', 'default:taxonomy_term')->setRevisionable(TRUE)->setCardinality(-1);
    //
    $fields['image'] = BaseFieldDefinition::create('image')->setLabel(' Image du model ')->setRequired(false)->setDisplayConfigurable('form', true)->setDisplayConfigurable('view', TRUE)->setSetting("min_resolution", "1000x1000");
    $fields['description'] = BaseFieldDefinition::create('text_long')->setLabel(" Description ")->setSettings([
      'text_processing' => 0,
      'html_format' => "text_code"
    ])->setDisplayOptions('form', [
      'type' => 'text_textarea',
      'weight' => 0
    ])->setDisplayOptions('view', [
      'label' => 'hidden',
      'type' => 'text_default',
      'weight' => 0
    ])->setRequired(TRUE)->setDisplayConfigurable('view', TRUE)->setDisplayConfigurable('form', true);
    //
    $fields['layout_paragraphs'] = BaseFieldDefinition::create('entity_reference')->setLabel(t(' Sections '))->setCardinality(FieldStorageDefinitionInterface::CARDINALITY_UNLIMITED)->setDisplayOptions('form', [
      'type' => 'inline_entity_form_complex',
      'weight' => 0
    ])->setDisplayConfigurable('form', TRUE)->setDisplayConfigurable('view', TRUE)->setSetting('target_type', 'paragraph')->setSetting('handler', 'default')->setTranslatable(false)->setSetting('allow_duplicate', true);
    
    //
    $fields['je_choisie_text'] = BaseFieldDefinition::create('string')->setLabel(t('Je choisie (texte)'))->setDisplayConfigurable('form', true)->setDisplayConfigurable('view', TRUE);
    //
    $fields['je_choisie'] = BaseFieldDefinition::create('link')->setLabel(t('Je choisie (direct link )'))->setSetting('link_type', LinkItemInterface::LINK_GENERIC)->setSetting('title', DRUPAL_OPTIONAL)->setDefaultValue([
      'link_type' => '#',
      'title' => 'Je choisie'
    ])->setDisplayConfigurable('form', true)->setDisplayConfigurable('view', TRUE);
    // Permet de definir faire apparaitre le dit modele sur la liste de
    // selection.
    $fields['is_home_page'] = BaseFieldDefinition::create('boolean')->setLabel(" Page d'accueil ? ")->setDisplayOptions('form', [
      'type' => 'boolean_checkbox',
      'weight' => 3
    ])->setDisplayOptions('view', [])->setDisplayConfigurable('view', TRUE)->setDisplayConfigurable('form', true)->setDefaultValue(false);
    // pour determiner les modeles en fonction de la categorie. il doivent avoir
    // la meme categorie. Le titre servir de nom de la page.
    
    //
    $fields['voir_demo'] = BaseFieldDefinition::create('link')->setLabel(t('Voir la demo'))->setSetting('link_type', LinkItemInterface::LINK_GENERIC)->setSetting('title', DRUPAL_OPTIONAL)->setDisplayConfigurable('form', true)->setDisplayConfigurable('view', TRUE);
    //
    return $fields;
  }
  
}
