<?php
//create array of data to be posted
$post_data['login'] = 'ad0002';
$post_data['passwd'] = 'eg1151';
$post_data['moa'] = '/a8';

//traverse array and prepare data for posting (key1=value1)
foreach ( $post_data as $key => $value) {
    $post_items[] = $key . '=' . $value;
}

//create the final string to be posted using implode()
// $post_string = implode ('&', $post_items);

$post_array = array(
    'login' => 'ad0002',
    'passwd' => 'eg1151',
    'lgin_as_btn.x' => '21',
    'lgin_as_btn.y' => '16',
    'moa' => '/a8'
);

//create cURL connection
$curl_connection = 
  curl_init('http://www.a8.net/a8v2/asLoginAction.do');

//set options
curl_setopt($curl_connection, CURLOPT_ENCODING, "gzip" );
curl_setopt($curl_connection, CURLOPT_CONNECTTIMEOUT, 30);
curl_setopt($curl_connection, CURLOPT_USERAGENT, "Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:24.0) Gecko/20100101 Firefox/24.0");
curl_setopt($curl_connection, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl_connection, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl_connection, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($curl_connection, CURLOPT_REFERER, "http://www.a8.net/a8v2/");

//set data to be posted
curl_setopt($curl_connection, CURLOPT_POSTFIELDS, $post_array);
//perform our request
$result = curl_exec($curl_connection);

print $result;
//show information regarding the request
echo curl_errno($curl_connection) . '-' . 
                curl_error($curl_connection);

//close the connection
curl_close($curl_connection);
