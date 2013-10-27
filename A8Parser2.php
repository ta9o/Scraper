<?php

require_once 'A8SelfSearchParser.php';

Class A8Parser2 {

    public function __construct($pageName) {
        $class = '';
        switch($pageName) {
            case 'selfSearch':
                $class = new A8SelfSearchParser();
                break;
            default:
                break;
        }
        return $class;
    }

    protected function scrape() {}
}
