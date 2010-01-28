<?php
/*
Sub-Package: URL Shortner Shared Fx
Parent-Package: URL Shortener WordPress Plugin
Requires: class.json
*/
require_once(dirname(__FILE__).'/class.json.php');

if (!class_exists('FTShortenShared')){
	class FTShortenShared {
		function openurl($url, $useragent = 'false', $posttype = 'GET', $postfield = '') {
			if (function_exists('curl_init')) {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_HEADER, false);	
				if ($useragent != 'false'){
					curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
				}
				if ($posttype == 'POST'){
					curl_setopt($ch, CURLOPT_POST, 1);
					curl_setopt($ch, CURLOPT_POSTFIELDS, $postfield);
					curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);		
				}
				$result = curl_exec($ch);
				curl_close($ch);
				return $result;				
			} else {
				return file_get_contents($url);
			}
		}//end fx open url	
		
		function processjson($url){
			$json = new Services_JSON();
			$result = $json->decode($url);
			return $result;
		}//end json process
		
		function processxml($url, $method='POST', $body=array()){
			$request = new WP_Http;
			$result = $request->request( $url, array( 'method' => $method, 'body' => $body) ); 
			if($result['body']){return $result['body'];}		
		} //end xml process
	}//end class
}//end check
?>