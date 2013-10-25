<?php

require_once "A8Login.php";

$a8 = new A8Login('ad0002', 'eg1151');
$memberDom = $a8->fetchMember();
echo $memberDom;

