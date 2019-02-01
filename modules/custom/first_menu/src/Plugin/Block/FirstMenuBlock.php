<?php

namespace Drupal\first_menu\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'FirstMenuBlock' block.
 *
 * @Block(
 *  id = "first_menu_block",
 *  admin_label = @Translation("First menu block"),
 * )
 */
class FirstMenuBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    /**
     * menus taxonomy
     */
    $query = \Drupal::entityQuery('taxonomy_term');
    $query->condition('vid', "menus");
    $tids = $query->execute();
    $terms = \Drupal\taxonomy\Entity\Term::loadMultiple($tids);
    foreach ($terms as &$item) {
      $item = $item->toArray();
    }
    unset($item);
    ksort($terms);
    $subterms = [];
    foreach ($terms as $item) {
      if ($item['parent'][0]['target_id'] != 0) {
        array_push($subterms, $item);
      }
    }

    /**
     * menus2 taxonomy
     */
    $query2 = \Drupal::entityQuery('taxonomy_term');
    $query2->condition('vid', "menus2");
    $tids2 = $query2->execute();
    $terms2 = \Drupal\taxonomy\Entity\Term::loadMultiple($tids2);
    foreach ($terms2 as &$item2) {
      $item2 = $item2->toArray();
    }
    unset($item2);
    ksort($terms2);
    return [
      '#theme' => 'first_menu',
      '#terms' => $terms,
      '#subterms' => $subterms,
      '#terms2' => $terms2,
      '#attached' => [
        'library' => [
          'first_menu/my_first_menu',
        ],
      ],
    ];
  }


}