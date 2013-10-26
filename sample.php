<?php

require_once "A8Scraper.php";

$a8 = new A8Scraper('ad0002', 'eg1151');
$memberDom = $a8->scrape('search');
// echo $memberDom;

