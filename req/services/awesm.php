<?php
/*
*Awe.sm functions
*/
               	                                  
$createurl = 'http://create.awe.sm/url.txt';
$url = urlencode($url);

$postfield =  'version=1&' . 'target=' . $url . '&share_type=other&create_type=api&api_key=' . $key; //. '&' . 'domain=' . $domain ;
       
$ch = curl_init($createurl);
curl_setopt($ch, CURLOPT_URL, $createurl);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);
?>