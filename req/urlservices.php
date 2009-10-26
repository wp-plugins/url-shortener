<?php
function createshorturl($apiservice, $url) {  
	global $globe_fts_urlfx;
	
	switch ($apiservice){
		case 'tinyurl':
			$gettinyurl = file_get_contents("http://tinyurl.com/api-create.php?url=".$url);  
			return $gettinyurl;  
		break;
			
		case 'supr':
			$apilogin = htmlentities($globe_fts_urlfx['apiuser_supr'], ENT_QUOTES);
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_supr'], ENT_QUOTES);
			if ($apilogin == '' || $apiloginpass == ''){} else {
				$apiuser = "&login=".$apilogin;
				$apipass = "&apiKey=".$apiloginpass ;
				$url .= $apiuser;
				$url .= $apipass;
			}
			$getsupr = file_get_contents("http://su.pr/api/simpleshorten?url=".$url);  
			return $getsupr; 
		break;
			
		case 'isgd':
			$getisgd = file_get_contents("http://is.gd/api.php?longurl=".$url);  
			return $getisgd;  
			break;
		
		case 'bitly':
			$apilogin = htmlentities($globe_fts_urlfx['apiuser_bitly'], ENT_QUOTES);
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_bitly'], ENT_QUOTES);
			if ($apilogin == '' || $apiloginpass == ''){} else {
				$getbitlystr = file_get_contents('http://api.bit.ly/shorten?version=2.0.1&longUrl='.urlencode($url).'&login='.$apilogin.'&apiKey='.$apiloginpass);
				$json = processjson($getbitlystr);
				$getbitly = $json->results->$url->shortUrl;
			}
			return $getbitly;
			break;
		
		case 'trim':
			$apilogin = htmlentities($globe_fts_urlfx['apiuser_trim'], ENT_QUOTES);
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_trim'], ENT_QUOTES);
			if ($apilogin == '' || $apiloginpass == ''){} else {
				$gettrimstr = file_get_contents('http://api.tr.im/api/trim_url.json?url='.urlencode($url).'&username='.$apilogin.'&password='.$apiloginpass);
				$json = processjson($gettrimstr);
				$gettrim = $json->url;
			}
			return $gettrim;
			break;
		
		case 'snip':
			$apilogin = htmlentities($globe_fts_urlfx['apiuser_snip'], ENT_QUOTES);
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_snip'], ENT_QUOTES);
			if ($apilogin == '' || $apiloginpass == ''){} else {
				$getsnip = snipurlapi($url, $apilogin, $apiloginpass);
			}
			return $getsnip;
			break;
		
		case 'cligs':
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_cligs'], ENT_QUOTES);
			if ($apiloginpass == ''){} else {
				$apipass = "&key=".$apiloginpass ;
				$url .= $apipass;
				$url .= '&appid=ftsplugin';
			}
			$getcligs = file_get_contents("http://cli.gs/api/v1/cligs/create?url=".$url);  
			return $getcligs;		
			break;	
		
		case 'shortie':
			$apiemail = htmlentities($globe_fts_urlfx['apiuser_shortie'], ENT_QUOTES);
			$apiloginpass = htmlentities($globe_fts_urlfx['apikey_shortie'], ENT_QUOTES);
			if ($apiloginpass == '' || $apiemail==''){} else {
				$url .= '&format=plain';
				$url .= '&private=true';
				$url .= '&email='.$apiemail;
				$url .= '&secretKey='.$apiloginpass;			
			}
			$getshortie = file_get_contents("http://short.ie/api?url=".$url);  
			return $getshortie;		
			break;	
		
		default:
			break;
	}

}  

function processjson($jsonurl){
	require_once(dirname(__FILE__).'/JSON.php');
	$json = new Services_JSON();
	$parseit = $json->decode($jsonurl);
	return $parseit;
}

function snipurlapi($url, $user, $key){
	require_once(dirname(__FILE__).'/snipurl.php');
	return $data;
}
?>