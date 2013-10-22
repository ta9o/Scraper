<?php

Class A8Login {
    
    // private $ua = "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0";
    private $ua = "Mozilla/5.0 (iPhone; CPU iPhone OS 6_0 like Mac OS X) AppleWebKit/536.26 (KHTML, like Gecko) Version/6.0 Mobile/10A403 Safari/8536.25";
    private $cookie = "";
    private $login = "";
    private $passwd = "";
    private $app = "";

    public function __construct() {
    }

    public function makeRequest($_url, $_method) {
        if ( !$_url || !$_method ) { return "invalid argments"; }

        $curl_connection = curl_init($_url);

        //set options
        $this->setUpCurl($curl_connection);

        //set data to be posted
        // curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_array);
        //perform our request
        $result = curl_exec($curl_connection);

        preg_match('/^Set-Cookie:\s*([^;]*)/mi', $result, $m);
        echo $m[1];
        // $this->setCookies($m[1]);

        $curl_connection = curl_init("http://www.a8.net/a8v2/asLoginAction.do");
        $this->setUpCurl($curl_connection);
        curl_setopt($curl_connection, CURLOPT_COOKIE);

        /*
        $info = curl_getinfo($curl_connection);
        $header = substr($result, 0, $info["header_size"]);
        $body = substr($result, $info["header_size"]);

        echo $header . "\n";
        // echo $body . "\n";

        print $result;
        //show information regarding the request
        echo curl_errno($curl_connection) . '-' . 
            curl_error($curl_connection);

        //close the connection
        curl_close($curl_connection);
         */
    }

    private function setUpCurl($ch) {
        curl_setopt($ch, CURLOPT_ENCODING, "gzip" );
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, $this->ua);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_REFERER, "http://www.a8.net/a8v2/");
    }

    private function setCookies($header) {
        $parsed = parse_str($header, $arr);
        echo trim($arr['app']);
    }

    private function separateKeyAndValue($str) {
        

    }
}
