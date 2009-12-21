<?php
function ownurlservice_rewrite($rewrite){
	$prefixval = get_option('fts_urlfx');
	$customprefix = $prefixval['ownserviceprefix'];
	$customprefix = ltrim($customprefix, " /");
	$customprefix = rtrim($customprefix, " ");
	$customprefix = strip_tags($customprefix);
	
	global $wp_rewrite;
	if ($prefixval['ownservice'] == 'yes' && $prefixval['ownservicetype'] == 'wprewriteredirect'){		
		$ownservicerules = array();
		$regrules = $customprefix . '([0-9]+)$';
		$ownservicerules[$regrules] = 'index.php?p=' . $wp_rewrite->preg_index( 1 );
		
		$wp_rewrite->rules = $ownservicerules + $wp_rewrite->rules;
	}
}

function flushRules(){
	global $wp_rewrite;
   	$wp_rewrite->flush_rules();
}

add_filter('generate_rewrite_rules', 'ownurlservice_rewrite');
add_filter('init','flushRules');

?>