<?php

namespace Drupal\creation_site_virtuel\Entity;

use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EditorialContentEntityBase;
use Drupal\Core\Entity\RevisionableInterface;
use Drupal\Core\Entity\EntityChangedTrait;
use Drupal\Core\Entity\EntityPublishedTrait;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\user\UserInterface;

/**
 * Defines the Collection by Habeuk entity.
 *
 * @ingroup creation_site_virtuel
 *
 * @ContentEntityType(
 *   id = "hbk_collection",
 *   label = @Translation("Collection by Habeuk"),
 *   handlers = {
 *     "storage" = "Drupal\creation_site_virtuel\HbkCollectionStorage",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\creation_site_virtuel\HbkCollectionListBuilder",
 *     "views_data" = "Drupal\creation_site_virtuel\Entity\HbkCollectionViewsData",
 *     "translation" = "Drupal\creation_site_virtuel\HbkCollectionTranslationHandler",
 *
 *     "form" = {
 *       "default" = "Drupal\creation_site_virtuel\Form\HbkCollectionForm",
 *       "add" = "Drupal\creation_site_virtuel\Form\HbkCollectionForm",
 *       "edit" = "Drupal\creation_site_virtuel\Form\HbkCollectionForm",
 *       "delete" = "Drupal\creation_site_virtuel\Form\HbkCollectionDeleteForm",
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\creation_site_virtuel\HbkCollectionHtmlRouteProvider",
 *     },
 *     "access" = "Drupal\creation_site_virtuel\HbkCollectionAccessControlHandler",
 *   },
 *   base_table = "hbk_collection",
 *   data_table = "hbk_collection_field_data",
 *   revision_table = "hbk_collection_revision",
 *   revision_data_table = "hbk_collection_field_revision",
 *   show_revision_ui = TRUE,
 *   translatable = TRUE,
 *   admin_permission = "administer collection by habeuk entities",
 *   entity_keys = {
 *     "id" = "id",
 *     "revision" = "vid",
 *     "label" = "name",
 *     "uuid" = "uuid",
 *     "uid" = "user_id",
 *     "langcode" = "langcode",
 *     "published" = "status",
 *   },
 *   revision_metadata_keys = {
 *     "revision_user" = "revision_uid",
 *     "revision_created" = "revision_timestamp",
 *     "revision_log_message" = "revision_log"
 *   },
 *   links = {
 *     "canonical" = "/collection/{hbk_collection}",
 *     "add-form" = "/admin/structure/hbk_collection/add",
 *     "edit-form" = "/admin/structure/hbk_collection/{hbk_collection}/edit",
 *     "delete-form" = "/admin/structure/hbk_collection/{hbk_collection}/delete",
 *     "version-history" = "/admin/structure/hbk_collection/{hbk_collection}/revisions",
 *     "revision" = "/admin/structure/hbk_collection/{hbk_collection}/revisions/{hbk_collection_revision}/view",
 *     "revision_revert" = "/admin/structure/hbk_collection/{hbk_collection}/revisions/{hbk_collection_revision}/revert",
 *     "revision_delete" = "/admin/structure/hbk_collection/{hbk_collection}/revisions/{hbk_collection_revision}/delete",
 *     "translation_revert" = "/admin/structure/hbk_collection/{hbk_collection}/revisions/{hbk_collection_revision}/revert/{langcode}",
 *     "collection" = "/admin/structure/hbk_collection",
 *   },
 *   field_ui_base_route = "hbk_collection.settings"
 * )
 */
class HbkCollection extends EditorialContentEntityBase implements HbkCollectionInterface {
  
  use EntityChangedTrait;
  use EntityPublishedTrait;
  
  /**
   *
   * {@inheritdoc}
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
  protected function urlRouteParameters($rel) {
    $uri_route_parameters = parent::urlRouteParameters($rel);
    
    if ($rel === 'revision_revert' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }
    elseif ($rel === 'revision_delete' && $this instanceof RevisionableInterface) {
      $uri_route_parameters[$this->getEntityTypeId() . '_revision'] = $this->getRevisionId();
    }
    
    return $uri_route_parameters;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public function preSave(EntityStorageInterface $storage) {
    parent::preSave($storage);
    
    foreach (array_keys($this->getTranslationLanguages()) as $langcode) {
      $translation = $this->getTranslation($langcode);
      
      // If no owner has been set explicitly, make the anonymous user the owner.
      if (!$translation->getOwner()) {
        $translation->setOwnerId(0);
      }
    }
    
    // If no revision author has been set explicitly,
    // make the hbk_collection owner the revision author.
    if (!$this->getRevisionUser()) {
      $this->setRevisionUserId($this->getOwnerId());
    }
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
  
  /**
   *
   * {@inheritdoc}
   */
  public function setOwner(UserInterface $account) {
    $this->set('user_id', $account->id());
    return $this;
  }
  
  /**
   *
   * {@inheritdoc}
   */
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type) {
    $fields = parent::baseFieldDefinitions($entity_type);
    
    // Add the published field.
    $fields += static::publishedBaseFieldDefinitions($entity_type);
    
    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')->setLabel(t('Authored by'))->setDescription(t('The user ID of author of the Collection by Habeuk entity.'))->setRevisionable(
      TRUE)->setSetting('target_type', 'user')->setSetting('handler', 'default')->setTranslatable(TRUE)->setDisplayOptions('view', [
      'label' => 'hidden',
      'type' => 'author',
      'weight' => 0
    ])->setDisplayOptions('form',
      [
        'type' => 'entity_reference_autocomplete',
        'weight' => 5,
        'settings' => [
          'match_operator' => 'CONTAINS',
          'size' => '60',
          'autocomplete_type' => 'tags',
          'placeholder' => ''
        ]
      ])->setDisplayConfigurable('form', TRUE)->setDisplayConfigurable('view', TRUE);
    
    $fields['name'] = BaseFieldDefinition::create('string')->setLabel(t('Name'))->setDescription(t('The name of the Collection by Habeuk entity.'))->setRevisionable(TRUE)->setSettings(
      [
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
    
    $fields['status']->setDescription(t('A boolean indicating whether the Collection by Habeuk is published.'))->setDisplayOptions('form', [
      'type' => 'boolean_checkbox',
      'weight' => -3
    ]);
    
    $fields['created'] = BaseFieldDefinition::create('created')->setLabel(t('Created'))->setDescription(t('The time that the entity was created.'));
    
    $fields['changed'] = BaseFieldDefinition::create('changed')->setLabel(t('Changed'))->setDescription(t('The time that the entity was last edited.'));
    
    $fields['revision_translation_affected'] = BaseFieldDefinition::create('boolean')->setLabel(t('Revision translation affected'))->setDescription(
      t('Indicates if the last edit of a translation belongs to current revision.'))->setReadOnly(TRUE)->setRevisionable(TRUE)->setTranslatable(TRUE);
    
    return $fields;
  }
}
