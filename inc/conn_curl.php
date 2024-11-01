<?php

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"api_uid\":\"$api_uid\",\"api_key\":\"$api_key\",\"anno\":\"$annofatture\"}");

$headers = array();
$headers[] = 'Content-Type: application/json';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$pre_result = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

$result = json_decode($pre_result, true);



/*
$request = array(
    "api_uid" => $api_uid,
    "api_key" => $api_key,
    "anno" => $annofatture

);
$options = array(
    "http" => array(
    "header"  => "Content-type: text/json\r\n",
    "method"  => "POST",
    "content" => json_encode($request)
    ),
);
$context  = stream_context_create($options);
$result = json_decode(file_get_contents($url, false, $context), true);

*/
// print_r($result_dett);


