<?php

require_once 'libs/goutte.phar';
use Goutte\Client;

$client = new Client();

$params = array(
    'login'  => 'ad0002',
    'passwd' => 'eg1151'
);

// $crawler = $client->request('POST', 'http://www.a8.net/a8v2/asLoginAction.do', $params);
$crawler = $client->request('GET', 'http://www.a8.net/a8v2/');
echo $crawler->filter('#todayNum')->text();
