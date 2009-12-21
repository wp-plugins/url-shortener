<?php

function ownservice(){
	$prefixval = get_option('fts_urlfx');
	
	if( is_404() && $prefixval['ownservice'] == 'yes' && $prefixval['ownservicetype'] == 'templateredirect'){
		
		$customprefix = $prefixval['ownserviceprefix'];
		
		$currentloc = strtolower($_SERVER['REQUEST_URI']);
		
		$savedloc = get_option( 'siteurl' );
		$siteurl = parse_url($savedloc );
		$path = $siteurl['path'];
		
		// "/[^a-zA-Z0-9\s]/"
		$url = str_replace( $path, '', $currentloc );
		
		$theid = preg_replace("/[^0-9]/", "", $url);

		if( !empty($theid)){
			$redirto = get_permalink($theid);
			header("Location: " . $redirto, true, 301);
		}	

	
	}

}

add_action('template_redirect', 'ownservice');
?>