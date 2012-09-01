<?php

$SECRET_KEY = 'xxx'; //40 character secret key
$CREDENTIALS = 'a:b';

$key256 = pack("H*" , hash('sha256', $SECRET_KEY));
$encrypted_string = base64_encode( openssl_encrypt( $CREDENTIALS, "aes-256-cbc", $key256, true) );

$params['access_key'] = 'xxx'; //20 character key
$params['credentials'] = $encrypted_string;
$params['timestamp'] = date('c');

$pre_signature = 'http://api.ravelry.com/authenticate.json?' . http_build_query($params);
$signature = base64_encode(hash_hmac('sha256', $pre_signature, $SECRET_KEY, true));

$params['signature'] = $signature;

$authUrl = http_build_query($params);
$authUrl = 'http://api.ravelry.com/authenticate.json?' . $authUrl;

echo($authUrl);

$c = curl_init();

curl_setopt($c, CURLOPT_URL, $authUrl);
curl_setopt($c, CURLOPT_HEADER, 0);

curl_exec($c);

curl_close($c);

?>