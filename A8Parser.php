<?php

require_once 'libs/simple_html_dom.php';
require_once 'A8SelfSearchModel.php';
/**
 * A8 各画面の DOM をうけとって
 * parsing する class
 */
Class A8Parser {

    private $searchModel = '';

    public function __construct() {
        $this->searchModel = new A8SelfSearchModel();
    }

    public function parseMember($htmlStr) {
        // TODO: parse処理
        $html = str_get_html($htmlStr);
    }

    public function parseSearch($htmlStr) {
        // TODO: parse処理
        $html = str_get_html($htmlStr);
        $tables = $html->find('div[id=areaLeft02] tbody a[onclick]');
        $searchModelArr = array();
        foreach($tables as $a) {
            // echo $a->onclick . "\n";
            preg_match("/\('(.*)'\)/is", $a->onclick, $retArr);
            foreach(array($retArr) as $ret) {
                // echo $ret[1] . "\n";
                $this->searchModel->clickInsId = $ret[1];
                $searchModelArr[] = $this->searchModel;
            }
        }

        $forms = $html->find('form[id=cForm] input');
        foreach($forms as $form) {
            switch($form->name) {
                case 'act':
                    $searchModelArr['act'] = $form->value;
                    break;
                case 'sealed':
                    $searchModelArr['sealed'] = $form->value;
                    break;
                default:
                    break;
            }
        }
        return $searchModelArr;
    }

    public function parseTopReport() {
        // TODO: parse処理
    }

    public function parseQuickReport() {
        // TODO: parse処理
    }

    public function parseShortcut() {
        // TODO: parse処理
    }

    public function parseCharityTop() {
        // TODO: parse処理
    }

}
