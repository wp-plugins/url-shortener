<?php
function createshorturl($apiservice, $url, $beta = NULL) {  
	global $globe_fts_urlfx;
	
	switch ($apiservice){
		case 'tinyurl':
			$geturl = file_get_contents("http://tinyurl.com/api-create.php?url=".urlencode($url));  
			return $geturl;  
			break;
			
		case 'supr':
			$apilogin = htmlentities($globe_fts_urlfx['apiuser_supr'], ENT_QUOTES);
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_supr'], ENT_QUOTES);
			$url = urlencode($url);
			if ($apilogin == '' || $apiloginpass == ''){} else {
				$apiuser = "&login=".$apilogin;
				$apipass = "&apiKey=".$apiloginpass ;
				$url .= $apiuser;
				$url .= $apipass;
			}
			$geturl = file_get_contents("http://su.pr/api/simpleshorten?url=".$url);  
			return $geturl; 
			break;
			
		case 'isgd':
			$geturl = file_get_contents("http://is.gd/api.php?longurl=".urlencode($url));  
			return $geturl;  
			break;
		
		case 'bitly':
			$apilogin = htmlentities($globe_fts_urlfx['apiuser_bitly'], ENT_QUOTES);
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_bitly'], ENT_QUOTES);
			if ($apilogin == '' || $apiloginpass == ''){} else {
				$bitlystr = file_get_contents('http://api.bit.ly/shorten?version=2.0.1&longUrl='.urlencode($url).'&login='.$apilogin.'&apiKey='.$apiloginpass);
				$json = processjson($bitlystr);
				$geturl = $json->results->$url->shortUrl;
			}
			return $geturl;
			break;
		
		case 'trim':
			$apilogin = htmlentities($globe_fts_urlfx['apiuser_trim'], ENT_QUOTES);
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_trim'], ENT_QUOTES);
			if ($apilogin == '' || $apiloginpass == ''){} else {
				$trimstr = file_get_contents('http://api.tr.im/api/trim_url.json?url='.urlencode($url).'&username='.$apilogin.'&password='.$apiloginpass);
				$json = processjson($trimstr);
				$geturl = $json->url;
			}
			return $geturl;
			break;
		
		case 'snipurl':
			$apilogin = htmlentities($globe_fts_urlfx['apiuser_snip'], ENT_QUOTES);
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_snip'], ENT_QUOTES);
			$urlprefix = $globe_fts_urlfx['snipprefix'];
			if ($apilogin == '' || $apiloginpass == ''){} else {
				$geturl = snipurlapi($url, $apilogin, $apiloginpass, $urlprefix);
			}
			return $geturl;
			break;
		
		case 'cligs':
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_cligs'], ENT_QUOTES);
			$url = urlencode($url);
			if ($apiloginpass == ''){} else {
				$apipass = "&key=".$apiloginpass ;
				$url .= $apipass;
				$url .= '&appid=ftsplugin';
			}
			$geturl = file_get_contents("http://cli.gs/api/v1/cligs/create?url=".$url);  
			return $geturl;		
			break;	
		
		case 'shortie':
			$apiemail = htmlentities($globe_fts_urlfx['apiuser_shortie'], ENT_QUOTES);
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_shortie'], ENT_QUOTES);
			$url = urlencode($url);
			if ($apiloginpass == '' || $apiemail==''){} else {
				$url .= '&format=plain';
				$url .= '&private=true';
				$url .= '&email='.$apiemail;
				$url .= '&secretKey='.$apiloginpass;			
			}
			$geturl = file_get_contents("http://short.ie/api?url=".$url);  
			return $geturl;		
			break;	
		
		case 'shortto':
			$geturl = file_get_contents("http://short.to/s.txt?url=".urlencode($url));  
			return $geturl;  
			break;
		
		case 'chilpit':
			$geturl = file_get_contents("http://chilp.it/api.php?url=".urlencode($url));  
			return $geturl;  
			break;

		case 'pingfm':
			$apiurl = 'http://api.ping.fm/v1/url.create';
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_pingfm'], ENT_QUOTES);
			$url = urlencode($url);
			$body = array(
				'api_key' => 'f51e33510d3cbe2ff1e16a4a4897f099',
				'user_app_key' => $apiloginpass,
				'long_url' => $url
			);
			$xml = urlxmlresult($apiurl, 'POST', $body );
			if ($xml) {
				$thexml = new SimpleXMLElement($xml);
				$geturl = $thexml->short_url;				
			}	
			return $geturl;
			break;
		
		case 'smsh':
			$smshstr = file_get_contents("http://smsh.me/?api=json&url=".urlencode($url));
			$json = processjson($smshstr);
			$geturl = $json->body;
			return $geturl;
			break;
		
		case 'unu':
			$geturl = file_get_contents("http://u.nu/unu-api-simple?url=".urlencode($url));  
			return $geturl; 
			break;
		
		case 'unfakeit':
			$geturl = file_get_contents("http://unfake.it/?a=api&url=".urlencode($url));  
			return $geturl; 
			break;
		
		case 'awesm':
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_awesm'], ENT_QUOTES);
			if ($apiloginpass == ''){} else {
				$geturl = awesmapi($url, $apiloginpass);
			}
			return $geturl;
			break;

		default:
			if ($globe_fts_urlfx['urlbetaservices'] == 'yes' && function_exists('fts_url_beta_services')){
				$geturl = fts_url_beta_services($url);
				return $geturl;
			}	
			break;
	}

}  

function processjson($jsonurl){
	require_once(dirname(__FILE__).'/JSON.php');
	$json = new Services_JSON();
	$parseit = $json->decode($jsonurl);
	return $parseit;
}

function snipurlapi($url, $user, $key, $urlprefix){
	switch ($urlprefix){
		case 'snurl':
			$urltoget = "http://snurl.com/site/getsnip";
			break;
		case 'snipurl':
			$urltoget = "http://snipurl.com/site/getsnip";
			break;
		case 'snim':
			$urltoget = "http://sn.im/site/getsnip";
			break;				
		default:
			$urltoget = "http://snipr.com/site/getsnip";
			break;
	
	}
	require_once(dirname(__FILE__).'/services/snipurl.php');
	
	if ($urlprefix == 'snim'){
		$data = str_replace('snurl.com', 'sn.im', $data);
	}
	
	return $data;
}

function awesmapi($url, $key){
	require_once(dirname(__FILE__).'/services/awesm.php');
	return $data;
}

function urlxmlresult($url, $method='POST', $body=array()){
	$request = new WP_Http;
	$result = $request->request( $url, array( 'method' => $method, 'body' => $body) ); 
	
	if($result['body']){
		return $result['body'];
	} else {};

};
?>