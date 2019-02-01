<?php

namespace Drupal\curs_valut\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'CursBlock' block.
 *
 * @Block(
 *  id = "curs_block",
 *  admin_label = @Translation("Curs block"),
 * )
 */
class CursBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $data = file_get_contents("http://resources.finance.ua/ua/public/currency-cash.json");
    if (isset($data) && !empty($data)) {
      $data = json_decode($data);
    }

    $rates = $data->organizations;
    $rates_array = [];
    foreach ($rates as $item) {
      if (isset($item->currencies->USD) && isset($item->currencies->EUR) && isset($item->currencies->PLN)) {
        array_push($rates_array, $item->currencies);
      }
    }

    $usd_arr = [];
    foreach ($rates_array as $item) {
      array_push($usd_arr, $item->USD);
    }

    $eur_arr = [];
    foreach ($rates_array as $item) {
      array_push($eur_arr, $item->EUR);
    }
    $pln_arr = [];
    foreach ($rates_array as $item) {
      array_push($pln_arr, $item->PLN);
    }

    $USD_BID = 10000;
    $USD_ASK = 10000;
    $EUR_BID = 10000;
    $EUR_ASK = 10000;
    $PLN_BID = 10000;
    $PLN_ASK = 10000;

    foreach ($usd_arr as $value) {
      if (isset($value->bid) && $value->bid > 0 && $USD_BID > $value->bid) {
        $USD_BID = $value->bid;
      }
      if (isset($value->ask) && $value->ask > 0 && $USD_ASK > $value->ask) {
        $USD_ASK = $value->ask;
      }
    }
    foreach ($eur_arr as $value) {
      if (isset($value->bid) && $value->bid > 0 && $EUR_BID > $value->bid) {
        $EUR_BID = $value->bid;
      }
      if (isset($value->ask) && $value->ask > 0 && $EUR_ASK > $value->ask) {
        $EUR_ASK = $value->ask;
      }
    }
    foreach ($pln_arr as $value) {
      if (isset($value->bid) && $value->bid > 0 && $PLN_BID > $value->bid) {
        $PLN_BID = $value->bid;
      }
      if (isset($value->ask) && $value->ask > 0 && $PLN_ASK > $value->ask) {
        $PLN_ASK = $value->ask;
      }
    }
    $result = [];
    $result['bid'] = [
      'usd' => floatval(number_format($USD_BID, 2)),
      'eur' => floatval(number_format($EUR_BID, 2)),
      'pln' => floatval(number_format($PLN_BID, 2)),
    ];
    $result['ask'] = [
      'usd' => floatval(number_format($USD_ASK, 2)),
      'eur' => floatval(number_format($EUR_ASK, 2)),
      'pln' => floatval(number_format($PLN_ASK, 2)),
    ];

    $time = strtotime($data->date);
    $date = date('H:i j.m.Y', $time);

    return [
      '#theme' => 'curs_valut',
      '#curs' => $result,
      '#datetime' => $date,
    ];
  }

}
