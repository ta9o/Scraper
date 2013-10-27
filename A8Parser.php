<?php

require_once 'libs/simple_html_dom.php';
require_once 'A8SelfSearchModel.php';
/**
 * A8 各画面の DOM をうけとって
 * parsing する class
 */
Class A8Parser {


    public function __construct() {

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
            if ($a->href = "javascript:void(0);") {
                preg_match("/do_confirm\('(.*)'\)/is", $a->onclick, $retArr);
                if (isset($retArr[1])) {
                    foreach(array($retArr) as $ret) {
                        // echo $ret[1] . "\n";
                        $searchModel = new A8SelfSearchModel();
                        $searchModel->clickInsId = $ret[1];
                        $searchModelArr[] = $searchModel;
                        unset($searchModel);
                    }
                }
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

    public function parseSearchDetail($htmlStr) {
        $html = str_get_html($htmlStr);

        $trs = $html->find('table[class=programSearch_details] tr td');
        $searchModel = new A8SelfSearchModel();
        foreach($trs as $key => $tr) {
            switch($key) {
                case 0:
                    $searchModel->sponsorName = $tr->plaintext;
                    break;
                case 1:
                    $searchModel->programName = $tr->plaintext;
                    break;
                case 2:
                    $searchModel->category= $tr->plaintext;
                    break;
                case 3:
                    $searchModel->device = $tr->plaintext;
                    break;
                case 4:
                    $searchModel->reward = $tr->plaintext;
                    break;
                case 5:
                    $searchModel->campaign = $tr->plaintext;
                    break;
                case 6:
                    $searchModel->detailComment = $tr->plaintext;
                    break;
                case 7:
                    $searchModel->review = $tr->plaintext;
                    break;
                case 8:
                    $searchModel->revisitTimeSpan = $tr->plaintext;
                    break;
                case 9:
                    $searchModel->estimation = $tr->plaintext;
                    break;
                case 10:
                    $searchModel->status = $tr->plaintext;
                    break;
                case 11:
                    $searchModel->status = $tr->plaintext;
                    break;
                case 12:
                    $searchModel->keyword = $tr->plaintext;
                    break;
                case 13:
                    $searchModel->appealSite = $tr->plaintext;
                    break;
            }
        }
        // var_dump($searchModel);
        return $searchModel;

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
