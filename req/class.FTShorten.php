<?php
/*
Sub-Package: URL Shortner Services Class
Parent-Package: URL Shortener WordPress Plugin
Class Version: 1.0
Requires: inc.FTShared

Copyright Information and Usage
- This class is packaged in the URL Shortener plugin and can also be downloaded via http://fusedthought.com.
- Permission is granted for re-use of the class in other plugins provided the plugin is released under a similar license as my URL Shortener Plugin.
- This class is not to be packaged as part of a commercial plugin or other any part of a paid download without prior notification to the author.
- If in doubt, email your question to contact@fusedthought.com

Services supported:
- tinyurl - is.gd - su.pr - bit.ly - tr.im - short.ie - snipurl - cl.gs - short.to - ping.fm - chilp.it - smoosh - smsh.me - u.nu - unfake.it - awe.sm -
*/
require_once(dirname(__FILE__).'/components/inc.FTShared.php');

if (!class_exists('FTShorten')){
	class FTShorten extends FTShared {
		public $service, $url, $name, $apikey, $apiprefix, $apiextend;	
		public $pingfmapi;
		public function shorturl(){
			$surl = urlencode($this->url);
			$nurl = $this->url;
			$sservice = $this->service;
			$sname = $this->name;
			$skey = $this->apikey;
			$sprefix = $this->apiprefix;
			$ftsextend = $this->apiextend;
			
			switch ($sservice){
				case 'tinyurl':
					$data = $this->openurl("http://tinyurl.com/api-create.php?url=".$surl); 
					break;				
				case 'supr':
					if ($sname == '' || $skey == ''){} else {
						$apiuser = "&login=".$sname;
						$apipass = "&apiKey=".$skey;
						$surl .= $apiuser;
						$surl .= $apipass;
					}
					$data = $this->openurl("http://su.pr/api/simpleshorten?url=".$surl);  
					break;				
				case 'isgd': 
					$data = $this->openurl("http://is.gd/api.php?longurl=".$surl);  
					break;			
				case 'bitly':
					if ($sname == '' || $skey == ''){} else {
						$result = $this->openurl('http://api.bit.ly/shorten?version=2.0.1&longUrl='.$surl.'&login='.$sname.'&apiKey='.$skey);
						$json = $this->processjson($result);
						$data = $json->results->$nurl->shortUrl;
					}
					break;				
				case 'trim':
					if ($sname == '' || $skey == ''){} else {
						$result = $this->openurl('http://api.tr.im/api/trim_url.json?url='.$surl.'&username='.$sname.'&password='.$skey);
						$json = $this->processjson($result);
						$data = $json->url;
					}
					break;				
				case 'snipurl':
					if ($sname == '' || $skey == ''){} else {
						$data = $this->getsnip($nurl, $sname, $skey, $sprefix);
					}
					break;				
				case 'cligs':
					if ($skey == ''){} else {
						$apipass = "&key=".$skey ;
						$surl .= $apipass;
						$surl .= '&appid=ftsplugin';
					}
					$data = $this->openurl("http://cli.gs/api/v1/cligs/create?url=".$surl);  
					break;			
				case 'shortie':
					if ($skey== '' || $sname==''){} else {
						$surl .= '&format=plain';
						$surl .= '&private=true';
						$surl .= '&email='.$sname;
						$surl .= '&secretKey='.$skey;			
					}
					$data = $this->openurl("http://short.ie/api?url=".$surl);  
					break;				
				case 'shortto':
					$data = $this-openurl("http://short.to/s.txt?url=".$surl);  		
					break;			
				case 'chilpit':
					$data = $this-openurl("http://chilp.it/api.php?url=".$surl);  
					break;	
				case 'pingfm':
					$apiurl = 'http://api.ping.fm/v1/url.create';
					$body = array(
						'api_key' => $this->pingfmapi,
						'user_app_key' => $skey,
						'long_url' => $nurl
					);
					$result = $this->processxml($apiurl, 'POST', $body);
					if ($result) {
						$xml = new SimpleXMLElement($result);
						$data = $xml->short_url;				
					}	
					break;				
				case 'smsh':
					$result = $this->openurl("http://smsh.me/?api=json&url=".$surl);
					$json = $this->processjson($result);
					$data = $json->body;
					break;			
				case 'unu':
					$data = $this->openurl("http://u.nu/unu-api-simple?url=".$surl);  
					break;			
				case 'unfakeit':
					$data = $this->openurl("http://unfake.it/?a=api&url=".$surl);  
					break;			
				case 'awesm':
					$apiurl = 'http://create.awe.sm/url.txt';
					$postfield =  'version=1&' . 'target=' . $surl . '&share_type=other&create_type=api&api_key=' . $skey; //. '&' . 'domain=' . $domain ;
					if ($skey == ''){} else {
						$data = $this->openurl($apiurl, 'false', 'POST', $postfield);
					}
					break;	
				default:
					if (class_exists('FTShortenExtended') && $ftsextend == 'yes'){
						$FTSE = new FTShortenExtended();
						$FTSE->name = $sname;
						$FTSE->service = $sservice;
						$FTSE->url = $nurl;
						$FTSE->apikey = $skey;
						$FTSE->apiprefix = $sprefix;
						$data = $FTSE->shorturl();
					}
					break;
			} //end switch			
			return $data;
		}//end fx shorten
			
		protected function getsnip($url, $user, $key, $urlprefix = 'none'){
			switch ($urlprefix){
				case 'snurl':
					$apiurl = "http://snurl.com/site/getsnip";
					break;
				case 'snipurl':
					$apiurl = "http://snipurl.com/site/getsnip";
					break;				
				default:
					$apiurl = "http://snipr.com/site/getsnip";
					break;
			}
			require_once(dirname(__FILE__).'/components/fx.snipurl.php');	
			if ($urlprefix == 'snim'){
				$data = str_replace('snipr.com', 'sn.im', $data);
			}
			return $data;
		} //end fx snipurl
		
	} //end class
} //end check cleass
?>