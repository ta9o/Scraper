<?php

require_once "A8Scraper.php";

$time_start = microtime(true);
$a8 = new A8Scraper('ad0002', 'eg1151');
$searchDetailArr = $a8->scrape('search', 5);
echo count($searchDetailArr) . "\n";
$time_end = microtime(true);
$time = $time_end - $time_start;

echo "実行時間:{$time}秒";
// var_dump($searchDetailArr);
