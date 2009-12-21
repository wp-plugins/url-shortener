<?php
/*
Plugin Name: URL Shortener
Plugin URI: http://fusedthought.com/downloads/url-shortener-wordpress-plugin/
Description: This plugin integrates multiple URL Shortening service with your WordPress.org installation. Brings a similar functionality of WordPress.com's WP.me shortlinks feature but using 3rd partly URL Shorteners. Supports own domain URL Shortener awe.sm as well. <a href="http://fusedthought.com/downloads/addon-module-for-url-shortener-wordpress-plugin/">Addon module for beta-supported services available</a>.
Author: Gerald Yeo
Author URI: http://fusedthought.com
Version: 1.7
*/

/* 
 * Use "fts_show_shorturl($post)" to display link in a post
 * On Demand shortening eg: "fts_shorturl('http://www.google.com', 'supr');"
 */

global $globe_fts_urlfx;
global $addonurl;
$addonurl = "http://fusedthought.com/downloads/addon-module-for-url-shortener-wordpress-plugin/";

require_once( dirname(__FILE__) . '/req/urlservices.php' );
require_once( dirname(__FILE__) . '/req/options.php' );
require_once( dirname(__FILE__) . '/req/services/wprewriteredirect.php' );
require_once( dirname(__FILE__) . '/req/services/templateredirect.php' );

function fts_show_shorturl($post){
	$postid = $post->ID;
	$the_shorturl = get_post_meta($postid, 'shorturl', $single = true);	
	echo $the_shorturl;
}

function fts_shorturl($url, $api){
	$api = strip_tags($api);
	$api = preg_replace("/[^a-zA-Z0-9]/", "", $api);
	$the_shorturl = createshorturl($api, $url);
	echo $the_shorturl;
}


function fts_shortenurl($post_ID){
	global $globe_fts_urlfx;
	
	// Generate short URL ?
	$got_shorturl = get_post_meta($post_ID, 'shorturl', true);
	if (!$got_shorturl){
		$posturl = get_permalink($post_ID);
		
		$selectedservice = $globe_fts_urlfx['urlservice'];
		$short = createshorturl($selectedservice, $posturl);
		//$short = $posturl; //for testing
		
		if($short){
			update_post_meta($post_ID, 'shorturl', $short);
		}else{};
		
	} else {};
}


function fts_shortenurl_get($post_ID){
	if($_POST['get-shortlink'] == 'Enabled'){
		fts_shortenurl($post_ID);
	}
}


function fts_shortenurl_remove($post_ID){
	if ($_POST['remove-shortlink']){
		delete_post_meta($post_ID, 'shorturl');
	}
}

function fts_shortenurl_actions($links) {
	$links[] = '<a href="options-general.php?page=shorturl">Settings</a>';
	return $links;
}

function fts_shortenurl_future($post){
	$fts_urlfx = get_option('fts_urlfx');
	$postid = $post->ID;
	$customyes = $_POST['get-shortlink'];
	$shorturl = get_post_meta($postid, 'shorturl', true);
	if ($fts_urlfx['urlserviceenable'] == 'yes'){
		if($fts_urlfx['urlservice'] != 'none' && !$shorturl){	
			if($fts_urlfx['urlautogen'] == 'yes'){	
				fts_shortenurl($postid);
			} elseif($fts_urlfx['urlautogen'] == 'no' && $customyes == 'Enabled'){
				fts_shortenurl($postid);
			}else{};
		}
	}
}

// Hooks
add_action('wp_ajax_getshortlink', 'fts_shortenurl_get' );
add_action('wp_ajax_removeshortlink', 'fts_shortenurl_remove' );
add_action('save_post', 'fts_shortenurl_remove'); 
add_action('publish_to_publish', 'fts_shortenurl_future');
add_action('draft_to_publish', 'fts_shortenurl_future'); 
add_action('private_to_publish', 'fts_shortenurl_future'); 
add_action('future_to_publish', 'fts_shortenurl_future'); 
add_action('pending_to_publish', 'fts_shortenurl_future');  
add_action('new_to_publish', 'fts_shortenurl_future'); 
//add_action('publish_post', 'fts_shortenurl_get');
//add_action('publish_page', 'fts_shortenurl_get');
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'fts_shortenurl_actions', -10);
?>