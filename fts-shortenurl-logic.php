<?php
$newshort = new FTShorten();
$newshort->service = $selectedservice;
$newshort->url = $posturl;
$newshort->apiextend = $fts_urlfx['urlbetaservices'];
switch($selectedservice){				
	case 'supr':
		$newshort->name = htmlentities($fts_urlfx['apiuser_supr'], ENT_QUOTES);
		$newshort->apikey = htmlentities($fts_urlfx['apikey_supr'], ENT_QUOTES);
		break;
	case 'bitly':
		$newshort->name = htmlentities($fts_urlfx['apiuser_bitly'], ENT_QUOTES);
		$newshort->apikey = htmlentities($fts_urlfx['apikey_bitly'], ENT_QUOTES);
		break;
	case 'trim':
		$newshort->name = htmlentities($fts_urlfx['apiuser_trim'], ENT_QUOTES);
		$newshort->apikey = htmlentities($fts_urlfx['apikey_trim'], ENT_QUOTES);
		break;
	case 'snipurl':
		$newshort->name = htmlentities($fts_urlfx['apiuser_snip'], ENT_QUOTES);
		$newshort->apikey = htmlentities($fts_urlfx['apikey_snip'], ENT_QUOTES);
		$newshort->apiprefix = $fts_urlfx['snipprefix'];
		break;		
	case 'cligs':
		$newshort->apikey = htmlentities($fts_urlfx['apikey_cligs'], ENT_QUOTES);
		break;		
	case 'shortie':
		$newshort->name = htmlentities($fts_urlfx['apiuser_shortie'], ENT_QUOTES);
		$newshort->apikey = htmlentities($fts_urlfx['apikey_shortie'], ENT_QUOTES);
		break;		
	case 'pingfm':
		$newshort->apikey = htmlentities($fts_urlfx['apikey_pingfm'], ENT_QUOTES);
		$newshort->pingfmapi = 'f51e33510d3cbe2ff1e16a4a4897f099';
		break;
	case 'awesm':
		$newshort->apikey =  htmlentities($fts_urlfx['apikey_awesm'], ENT_QUOTES);
		break;	
	default:
		break;
}
$short = $newshort->shorturl();
?>