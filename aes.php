<?php

$SECRET_KEY = 'xxx'; //40 character secret key
$CREDENTIALS = 'user:pass';

$encrypted_credentials = @base64_encode(mcrypt_cbc(MCRYPT_RIJNDAEL_128,substr($SECRET_KEY,0,40),$CREDENTIALS,MCRYPT_ENCRYPT, 0));

$params['access_key'] = 'xxx'; //20 character key
$params['credentials'] = $encrypted_credentials;
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