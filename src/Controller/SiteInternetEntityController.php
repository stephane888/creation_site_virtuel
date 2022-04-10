<?php

namespace Drupal\creation_site_virtuel\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Url;
use Drupal\creation_site_virtuel\Entity\SiteInternetEntityInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SiteInternetEntityController.
 *
 *  Returns responses for Site internet entity routes.
 */
class SiteInternetEntityController extends ControllerBase implements ContainerInjectionInterface {

  /**
   * The date formatter.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * The renderer.
   *
   * @var \Drupal\Core\Render\Renderer
   */
  protected $renderer;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $instance = parent::create($container);
    $instance->dateFormatter = $container->get('date.formatter');
    $instance->renderer = $container->get('renderer');
    return $instance;
  }

  /**
   * Displays a Site internet entity revision.
   *
   * @param int $site_internet_entity_revision
   *   The Site internet entity revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($site_internet_entity_revision) {
    $site_internet_entity = $this->entityTypeManager()->getStorage('site_internet_entity')
      ->loadRevision($site_internet_entity_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('site_internet_entity');

    return $view_builder->view($site_internet_entity);
  }

  /**
   * Page title callback for a Site internet entity revision.
   *
   * @param int $site_internet_entity_revision
   *   The Site internet entity revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($site_internet_entity_revision) {
    $site_internet_entity = $this->entityTypeManager()->getStorage('site_internet_entity')
      ->loadRevision($site_internet_entity_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $site_internet_entity->label(),
      '%date' => $this->dateFormatter->format($site_internet_entity->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Site internet entity.
   *
   * @param \Drupal\creation_site_virtuel\Entity\SiteInternetEntityInterface $site_internet_entity
   *   A Site internet entity object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(SiteInternetEntityInterface $site_internet_entity) {
    $account = $this->currentUser();
    $site_internet_entity_storage = $this->entityTypeManager()->getStorage('site_internet_entity');

    $langcode = $site_internet_entity->language()->getId();
    $langname = $site_internet_entity->language()->getName();
    $languages = $site_internet_entity->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $site_internet_entity->label()]) : $this->t('Revisions for %title', ['%title' => $site_internet_entity->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all site internet entity revisions") || $account->hasPermission('administer site internet entity entities')));
    $delete_permission = (($account->hasPermission("delete all site internet entity revisions") || $account->hasPermission('administer site internet entity entities')));

    $rows = [];

    $vids = $site_internet_entity_storage->revisionIds($site_internet_entity);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\creation_site_virtuel\SiteInternetEntityInterface $revision */
      $revision = $site_internet_entity_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $site_internet_entity->getRevisionId()) {
          $link = $this->l($date, new Url('entity.site_internet_entity.revision', [
            'site_internet_entity' => $site_internet_entity->id(),
            'site_internet_entity_revision' => $vid,
          ]));
        }
        else {
          $link = $site_internet_entity->link($date);
        }

        $row = [];
        $column = [
          'data' => [
            '#type' => 'inline_template',
            '#template' => '{% trans %}{{ date }} by {{ username }}{% endtrans %}{% if message %}<p class="revision-log">{{ message }}</p>{% endif %}',
            '#context' => [
              'date' => $link,
              'username' => $this->renderer->renderPlain($username),
              'message' => [
                '#markup' => $revision->getRevisionLogMessage(),
                '#allowed_tags' => Xss::getHtmlTagList(),
              ],
            ],
          ],
        ];
        $row[] = $column;

        if ($latest_revision) {
          $row[] = [
            'data' => [
              '#prefix' => '<em>',
              '#markup' => $this->t('Current revision'),
              '#suffix' => '</em>',
            ],
          ];
          foreach ($row as &$current) {
            $current['class'] = ['revision-current'];
          }
          $latest_revision = FALSE;
        }
        else {
          $links = [];
          if ($revert_permission) {
            $links['revert'] = [
              'title' => $this->t('Revert'),
              'url' => $has_translations ?
              Url::fromRoute('entity.site_internet_entity.translation_revert', [
                'site_internet_entity' => $site_internet_entity->id(),
                'site_internet_entity_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.site_internet_entity.revision_revert', [
                'site_internet_entity' => $site_internet_entity->id(),
                'site_internet_entity_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.site_internet_entity.revision_delete', [
                'site_internet_entity' => $site_internet_entity->id(),
                'site_internet_entity_revision' => $vid,
              ]),
            ];
          }

          $row[] = [
            'data' => [
              '#type' => 'operations',
              '#links' => $links,
            ],
          ];
        }

        $rows[] = $row;
      }
    }

    $build['site_internet_entity_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
