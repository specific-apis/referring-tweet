<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
$url = 'https://mobile.twitter.com/search?q=' . str_replace("?amp=1","",$_GET["url"]);

$ch = curl_init();
$timeout = 5;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
$html = curl_exec($ch);
curl_close($ch);

$dom = new DOMDocument();
@$dom->loadHTML($html);

$xpath = new DOMXpath($dom);

$items = array();
$expression = './/div[contains(concat(" ", normalize-space(@class), " "), " tweet-text ")]';

foreach ($xpath->evaluate($expression) as $div) {
  $items[] = $div;
}

if (!$items) {
  echo 'null';
} else {
  echo $items[0]->getAttribute('data-id');
}
