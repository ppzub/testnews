<?php

namespace Drupal\weather\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'WeatherBlock' block.
 *
 * @Block(
 *  id = "weather_block",
 *  admin_label = @Translation("Weather block"),
 * )
 */
class WeatherBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $url = 'https://weather-ydn-yql.media.yahoo.com/forecastrss';
    $app_id = 'mbcExX6e';
    $consumer_key = 'dj0yJmk9YzM5NGZvWTBLY044JnM9Y29uc3VtZXJzZWNyZXQmc3Y9MCZ4PWRk';
    $consumer_secret = 'd5ecc57b1aca8185b6b83fd3e14f6173215a2faf';
    $query = [
      'woeid' => '925750',
      'format' => 'json',
    ];
    $oauth = [
      'oauth_consumer_key' => $consumer_key,
      'oauth_nonce' => uniqid(mt_rand(1, 1000)),
      'oauth_signature_method' => 'HMAC-SHA1',
      'oauth_timestamp' => time(),
      'oauth_version' => '1.0',
    ];
    $base_info = $this->buildBaseString($url, 'GET', array_merge($query, $oauth));
    $composite_key = rawurlencode($consumer_secret) . '&';
    $oauth_signature = base64_encode(hash_hmac('sha1', $base_info, $composite_key, TRUE));
    $oauth['oauth_signature'] = $oauth_signature;
    $header = [
      $this->buildAuthorizationHeader($oauth),
      'Yahoo-App-Id: ' . $app_id,
    ];
    $options = [
      CURLOPT_HTTPHEADER => $header,
      CURLOPT_HEADER => FALSE,
      CURLOPT_URL => $url . '?' . http_build_query($query),
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_SSL_VERIFYPEER => FALSE,
    ];

    $ch = curl_init();
    curl_setopt_array($ch, $options);
    $response = curl_exec($ch);
    curl_close($ch);

    $phpObj = json_decode($response);
    if (isset($phpObj) && !empty($phpObj) && isset($phpObj->forecasts) && !empty($phpObj->forecasts)) {
      $D1_CODE = 10000;
      $D1_HIGH = 10000;
      $D1_LOW = 10000;
      $D2_CODE = 10000;
      $D2_HIGH = 10000;
      $D2_LOW = 10000;
      $D3_CODE = 10000;
      $D3_HIGH = 10000;
      $D3_LOW = 10000;
      $timestamp = 0;

      if (isset($phpObj->current_observation->pubDate) && !empty($phpObj->current_observation->pubDate)) {
        $timestamp = $phpObj->current_observation->pubDate;
      }

      foreach ($phpObj->forecasts as $day => $data_weather) {
        if ($day == 0 && isset($data_weather->code) && isset($data_weather->high) && isset($data_weather->low)) {
          $D1_CODE = $data_weather->code;
          $D1_HIGH = $data_weather->high;
          $D1_LOW = $data_weather->low;
        }

        if ($day == 1 && isset($data_weather->code) && isset($data_weather->high) && isset($data_weather->low)) {
          $D2_CODE = $data_weather->code;
          $D2_HIGH = $data_weather->high;
          $D2_LOW = $data_weather->low;
        }

        if ($day == 2 && isset($data_weather->code) && isset($data_weather->high) && isset($data_weather->low)) {
          $D3_CODE = $data_weather->code;
          $D3_HIGH = $data_weather->high;
          $D3_LOW = $data_weather->low;
        }
      }
      if ($timestamp != 0 && $D1_CODE != 10000 && $D2_CODE != 10000 && $D3_CODE != 10000) {
        $timestamp_int = strtotime($timestamp);
        $timestamp_view = date("H:i", $timestamp_int);

        $WEATHER_CODES = [
          0 => "w-icon17",
          1 => "w-icon6",
          2 => "w-icon17",
          3 => "w-icon17",
          4 => "w-icon17",
          5 => "w-icon9",
          6 => "w-icon9",
          7 => "w-icon13",
          8 => "w-icon12",
          9 => "w-icon12",
          10 => "w-icon8",
          11 => "w-icon12",
          12 => "w-icon12",
          13 => "w-icon12",
          14 => "w-icon5",
          15 => "w-icon13",
          16 => "w-icon12",
          17 => "w-icon8",
          18 => "w-icon8",
          19 => "w-icon3",
          20 => "w-icon4",
          21 => "w-icon3",
          22 => "w-icon3",
          23 => "w-icon4",
          24 => "w-icon3",
          25 => "w-icon12",
          26 => "w-icon3",
          27 => "w-icon11",
          28 => "w-icon2",
          29 => "w-icon11",
          30 => "w-icon12",
          31 => "w-icon10",
          32 => "w-icon1",
          33 => "w-icon10",
          34 => "w-icon1",
          35 => "w-icon8",
          36 => "w-icon1",
          37 => "w-icon17",
          38 => "w-icon17",
          39 => "w-icon17",
          40 => "w-icon3",
          41 => "w-icon13",
          42 => "w-icon13",
          43 => "w-icon13",
          44 => "w-icon4",
          45 => "w-icon17",
          46 => "w-icon12",
          47 => "w-icon17",
        ];
        $D1_HIGH = number_format(($D1_HIGH - 32) * (5 / 9), 2, ".", "");
        $D1_HIGH = floor($D1_HIGH);
        $D2_HIGH = number_format(($D2_HIGH - 32) * (5 / 9), 2, ".", "");
        $D2_HIGH = floor($D2_HIGH);
        $D3_HIGH = number_format(($D3_HIGH - 32) * (5 / 9), 2, ".", "");
        $D3_HIGH = floor($D3_HIGH);
        if ($D1_HIGH > 0) {
          $D1_HIGH = "+" . $D1_HIGH;
        }
        if ($D2_HIGH > 0) {
          $D2_HIGH = "+" . $D2_HIGH;
        }
        if ($D3_HIGH > 0) {
          $D3_HIGH = "+" . $D3_HIGH;
        }

        $day_codes = array(
          'd1' => $D1_CODE,
          'd2' => $D2_CODE,
          'd3' => $D3_CODE,
        );
        $temp_high = array(
          'd1' => $D1_HIGH,
          'd2' => $D2_HIGH,
          'd3' => $D3_HIGH,
        );
        return [
          '#theme' => 'weather',
          '#day_codes' => $day_codes,
          '#timestamp_view' => $timestamp_view,
          '#weather_codes' => $WEATHER_CODES,
          '#temp_high' => $temp_high,
        ];
      }
    }
  }

  public function buildBaseString($baseURI, $method, $params) {
    $r = [];
    ksort($params);
    foreach ($params as $key => $value) {
      $r[] = "$key=" . rawurlencode($value);
    }
    return $method . "&" . rawurlencode($baseURI) . '&' . rawurlencode(implode('&', $r));
  }

  public function buildAuthorizationHeader($oauth) {
    $r = 'Authorization: OAuth ';
    $values = [];
    foreach ($oauth as $key => $value) {
      $values[] = "$key=\"" . rawurlencode($value) . "\"";
    }
    $r .= implode(', ', $values);
    return $r;
  }
}
