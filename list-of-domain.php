<?php 


$API_KEY 	= "e4XhbNuXfzox_YafTM2DMriDyiWnh7wezym";
$API_SECRET = "XRFV5APBfgZZW2V7BWEEkN";


$url = "https://api.godaddy.com/v1/domains/?statuses=ACTIVE";

$header = array(
	'Authorization: sso-key '.$API_KEY.':'.$API_SECRET.''
);
$ch = curl_init();
$timeout=60;
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);  
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
$result = curl_exec($ch);
curl_close($ch);
$dn = json_decode($result, true);

print_r($dn);

?>