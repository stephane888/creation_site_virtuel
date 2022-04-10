<?php

namespace Drupal\creation_site_virtuel\Form;

use Drupal\Core\Form\ConfirmFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a form for deleting a Site internet entity revision.
 *
 * @ingroup creation_site_virtuel
 */
class SiteInternetEntityRevisionDeleteForm extends ConfirmFormBase {

  /**
   * The Site internet entity revision.
   *
   * @var \Drupal\creation_site_virtuel\Entity\SiteInternetEntityInterface
   */
  protected $revision;

  /**
   * The Site internet entity storage.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  protected $siteInternetEntityStorage;

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $connection;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->siteInternetEntityStorage = $container->get('entity_type.manager')->getStorage('site_internet_entity');
    $instance->connection = $container->get('database');
    return $instance;
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'site_internet_entity_revision_delete_confirm';
  }

  /**
   * {@inheritdoc}
   */
  public function getQuestion() {
    return $this->t('Are you sure you want to delete the revision from %revision-date?', [
      '%revision-date' => \Drupal::service('date.formatter')->format($this->revision->getRevisionCreationTime()),
    ]);
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl() {
    return new Url('entity.site_internet_entity.version_history', ['site_internet_entity' => $this->revision->id()]);
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText() {
    return $this->t('Delete');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $site_internet_entity_revision = NULL) {
    $this->revision = $this->SiteInternetEntityStorage->loadRevision($site_internet_entity_revision);
    $form = parent::buildForm($form, $form_state);

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->SiteInternetEntityStorage->deleteRevision($this->revision->getRevisionId());

    $this->logger('content')->notice('Site internet entity: deleted %title revision %revision.', ['%title' => $this->revision->label(), '%revision' => $this->revision->getRevisionId()]);
    $this->messenger()->addMessage(t('Revision from %revision-date of Site internet entity %title has been deleted.', ['%revision-date' => \Drupal::service('date.formatter')->format($this->revision->getRevisionCreationTime()), '%title' => $this->revision->label()]));
    $form_state->setRedirect(
      'entity.site_internet_entity.canonical',
       ['site_internet_entity' => $this->revision->id()]
    );
    if ($this->connection->query('SELECT COUNT(DISTINCT vid) FROM {site_internet_entity_field_revision} WHERE id = :id', [':id' => $this->revision->id()])->fetchField() > 1) {
      $form_state->setRedirect(
        'entity.site_internet_entity.version_history',
         ['site_internet_entity' => $this->revision->id()]
      );
    }
  }

}
