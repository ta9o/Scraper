<?php

require('A8ParserFactory.php');

Class A8Scraper {

    const A8_TOP = 'http://www.a8.net/a8v2';
    const A8_LOGIN = 'http://www.a8.net/a8v2/asLoginAction.do';
    const A8_SEARCH = 'https://www.a8.net/a8v2/asSearchAction.do';
    const A8_MEMBER = 'http://www.a8.net/a8v2/asMemberAction.do';
    const A8_TOP_REPORT = 'http://www.a8.net/a8v2/asTopReportAction.do';
    const A8_QUICK_REPORT = 'http://www.a8.net/a8v2/asQuickReportAction.do';
    const A8_SHORTCUT = 'http://www.a8.net/a8v2/asShortCutMenu.do';
    const A8_CHARITY_TOP = 'http://www.a8.net/a8v2/asCharityTopAction.do';

    const A8_SELFBACK_SEARCH = 'https://www.a8.net/a8v2/selfback/asSearchAction.do';

    const DEBUG = true;
    
    private $ua = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0";
    private $cookie = ""; // TODO: cookie のファイル名を場合によっては外から見れるように public にする必要はある
    private $login = "";
    private $passwd = "";
    private $app = "";

    public function __construct($_login = '', $_passwd = '') {
        $this->login = $_login;
        $this->passwd = $_passwd;
        date_default_timezone_set('Asia/Tokyo');
        $this->initialize();
    }

    /**
     * Member 画面の scrape
     * TODO: 今はhtml取得してるだけ。必要な情報を scrape する処理を書く
     * @arg $page: 各ページ名
     */
    public function scrape($page='') {
        switch ($page) {
            case 'member':
                $ch = $this->makeConnection(self::A8_MEMBER, true, '', $this->cookie, true);
                $result = curl_exec($ch);
                curl_close($ch);
                
                // TODO: scrape 処理
                $parser = new A8Parser();
                $parser->parseMember($result);
                // TODO: scrape 処理

                return $result;
                break;
            case 'search':
                // TODO: paging 処理を入れる

                $ch = $this->makeConnection(self::A8_SELFBACK_SEARCH, true, '', $this->cookie, true);
                $result = curl_exec($ch);
                curl_close($ch);
                $htmlStr = mb_convert_encoding($result, "UTF-8", "EUC-JP");

                $factory = new A8ParserFactory();
                $parser = $factory->create('selfSearch');
                // $searchModelArr = $parser->parseSearch($htmlStr);
                $searchModelArr = $parser->parse($htmlStr);

                $fixedPostData = "act=" . $searchModelArr['act'] . "&sealed=" . $searchModelArr['sealed']; 

                $searchDetailArr = array();
                foreach((array)$searchModelArr as $key=>$searchModel) {
                    if ($key == 'act' || $key == 'sealed' || strlen($searchModel->clickInsId) == 0) { continue; }
                    $postData = $fixedPostData . "&clickInsId=" . $searchModel->clickInsId;
                    echo $postData . "\n";

                    $ch = $this->makeConnection(self::A8_SEARCH, true, $postData, $this->cookie, true);
                    $result = curl_exec($ch);
                    // echo mb_convert_encoding($result, "UTF-8", "EUC-JP");
                    $htmlStr = mb_convert_encoding($result, "UTF-8", "EUC-JP");

                    $searchDetailArr[] =  $parser->parseSearchDetail($htmlStr);
                }

                return $searchDetailArr;

                break;
            case 'top_report':
                break;
            case 'quick_report':
                break;
            case 'shortcut':
                break;
            case 'charity_top':
                break;
            default:
                exit("invalid page name");
                break;
        }
    }

    /**
     * Top画面, LoginAction へのアクセス
     * 必要な Cookie 情報を取得するため
     */
    private function initialize() {
        $ch = $this->makeConnection(self::A8_TOP, false, "", "", true);
        curl_exec($ch);
        curl_close($ch);

        $query = "login=" . $this->login . "&passwd=" . $this->passwd . "&moa=/a8";
        $ch = $this->makeConnection(self::A8_LOGIN, true, $query, $this->cookie, true);
        curl_exec($ch);
        curl_close($ch);
    }

    private function makeConnection($_url='', $_isPost=false, $_query='', $_cookie='', $_isSetCookie=true) {
        $ch = curl_init($_url);
        curl_setopt($ch, CURLOPT_ENCODING, "gzip" );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_REFERER, "http://www.a8.net/a8v2/");
        curl_setopt($ch, CURLOPT_USERAGENT, $this->ua);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $_cookie);
        curl_setopt($ch, CURLOPT_POST, $_isPost);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $_query);
        if ($_isSetCookie) { 
            if (!$this->cookie || strlen($this->cookie) == 0) {
                // cookie の名前が決まっていない場合
                $this->cookie = "/tmp/a8/" . md5(date("Y-m-d H:i:s") . "cookie");
            }
            if (self::DEBUG) { 
                $command = "cat " . $this->cookie;
                // echo `${command}` . "\n\n";
            }
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookie); 
        }
        return $ch;
    } 
}
