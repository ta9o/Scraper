<?php

require_once 'A8SelfSearchParser.php';

Class A8ParserFactory {

    public function __construct() {}

    public function create($pageName) {
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

    public function parse() { echo "parser2\n"; }
}
