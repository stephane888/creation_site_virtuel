<?php

namespace Drupal\creation_site_virtuel\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\DependencyInjection\ContainerInjectionInterface;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Drupal\creation_site_virtuel\Entity\HbkCollectionInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class HbkCollectionController.
 *
 *  Returns responses for Collection by Habeuk routes.
 */
class HbkCollectionController extends ControllerBase implements ContainerInjectionInterface {

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
   * Displays a Collection by Habeuk revision.
   *
   * @param int $hbk_collection_revision
   *   The Collection by Habeuk revision ID.
   *
   * @return array
   *   An array suitable for drupal_render().
   */
  public function revisionShow($hbk_collection_revision) {
    $hbk_collection = $this->entityTypeManager()->getStorage('hbk_collection')
      ->loadRevision($hbk_collection_revision);
    $view_builder = $this->entityTypeManager()->getViewBuilder('hbk_collection');

    return $view_builder->view($hbk_collection);
  }

  /**
   * Page title callback for a Collection by Habeuk revision.
   *
   * @param int $hbk_collection_revision
   *   The Collection by Habeuk revision ID.
   *
   * @return string
   *   The page title.
   */
  public function revisionPageTitle($hbk_collection_revision) {
    $hbk_collection = $this->entityTypeManager()->getStorage('hbk_collection')
      ->loadRevision($hbk_collection_revision);
    return $this->t('Revision of %title from %date', [
      '%title' => $hbk_collection->label(),
      '%date' => $this->dateFormatter->format($hbk_collection->getRevisionCreationTime()),
    ]);
  }

  /**
   * Generates an overview table of older revisions of a Collection by Habeuk.
   *
   * @param \Drupal\creation_site_virtuel\Entity\HbkCollectionInterface $hbk_collection
   *   A Collection by Habeuk object.
   *
   * @return array
   *   An array as expected by drupal_render().
   */
  public function revisionOverview(HbkCollectionInterface $hbk_collection) {
    $account = $this->currentUser();
    $hbk_collection_storage = $this->entityTypeManager()->getStorage('hbk_collection');

    $langcode = $hbk_collection->language()->getId();
    $langname = $hbk_collection->language()->getName();
    $languages = $hbk_collection->getTranslationLanguages();
    $has_translations = (count($languages) > 1);
    $build['#title'] = $has_translations ? $this->t('@langname revisions for %title', ['@langname' => $langname, '%title' => $hbk_collection->label()]) : $this->t('Revisions for %title', ['%title' => $hbk_collection->label()]);

    $header = [$this->t('Revision'), $this->t('Operations')];
    $revert_permission = (($account->hasPermission("revert all collection by habeuk revisions") || $account->hasPermission('administer collection by habeuk entities')));
    $delete_permission = (($account->hasPermission("delete all collection by habeuk revisions") || $account->hasPermission('administer collection by habeuk entities')));

    $rows = [];

    $vids = $hbk_collection_storage->revisionIds($hbk_collection);

    $latest_revision = TRUE;

    foreach (array_reverse($vids) as $vid) {
      /** @var \Drupal\creation_site_virtuel\Entity\HbkCollectionInterface $revision */
      $revision = $hbk_collection_storage->loadRevision($vid);
      // Only show revisions that are affected by the language that is being
      // displayed.
      if ($revision->hasTranslation($langcode) && $revision->getTranslation($langcode)->isRevisionTranslationAffected()) {
        $username = [
          '#theme' => 'username',
          '#account' => $revision->getRevisionUser(),
        ];

        // Use revision link to link to revisions that are not active.
        $date = $this->dateFormatter->format($revision->getRevisionCreationTime(), 'short');
        if ($vid != $hbk_collection->getRevisionId()) {
          $link = Link::fromTextAndUrl($date, new Url('entity.hbk_collection.revision', [
            'hbk_collection' => $hbk_collection->id(),
            'hbk_collection_revision' => $vid,
          ]))->toString();
        }
        else {
          $link = $hbk_collection->toLink($date)->toString();
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
              Url::fromRoute('entity.hbk_collection.translation_revert', [
                'hbk_collection' => $hbk_collection->id(),
                'hbk_collection_revision' => $vid,
                'langcode' => $langcode,
              ]) :
              Url::fromRoute('entity.hbk_collection.revision_revert', [
                'hbk_collection' => $hbk_collection->id(),
                'hbk_collection_revision' => $vid,
              ]),
            ];
          }

          if ($delete_permission) {
            $links['delete'] = [
              'title' => $this->t('Delete'),
              'url' => Url::fromRoute('entity.hbk_collection.revision_delete', [
                'hbk_collection' => $hbk_collection->id(),
                'hbk_collection_revision' => $vid,
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

    $build['hbk_collection_revisions_table'] = [
      '#theme' => 'table',
      '#rows' => $rows,
      '#header' => $header,
    ];

    return $build;
  }

}
