<?php
/*
Plugin Name: URL Shortening Services Integration
Plugin URI: http://fusedthought.com
Description: This plugin integrates multiple URL Shortening service with your WordPress.org installation. Brings a similar functionality of WordPress.com's WP.me shortlinks feature but using 3rd partly URL Shorteners. 
Author: Gerald Yeo (Fusedthought)
Author URI: http://fusedthought.com
Version: 1.4
/*

/* Release History :
  	1.0	:	Initial Private release.
				supports TinyURL, is.gd		
 	1.1	:	Added support for bit.ly, tr.im
				Added "Remove buttons" in post/page edit.
				Added option for automatic shorturl generation.
				Changed Custom Field name from fts_shorturl to shorturl
 	1.2	:	Added support for su.pr
	1.3	:	Added support for snipurl, cl.gs, Short.ie
	1.4	:	First Public Release
				Added simple validation to options page	
*/

/* 
 * Use "echo fts_show_shorturl($post)" to display link in a post
 */

global $globe_fts_urlfx;

require_once( dirname(__FILE__) . '/req/urlservices.php' );
require_once( dirname(__FILE__) . '/req/options.php' );


function fts_show_shorturl($post){
	$postid = $post->ID;
	$the_shorturl = get_post_meta($postid, 'shorturl', $single = true);	
	return $the_shorturl;
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
	$links[] = '<a href="options-general.php?page=shorturl" style="font-weight:bold">Settings</a>';
	return $links;
}

// Hooks
add_action('wp_ajax_getshortlink', 'fts_shortenurl_get' );
add_action('wp_ajax_removeshortlink', 'fts_shortenurl_remove' );
add_action('save_post', 'fts_shortenurl_remove'); 
add_action('publish_post', 'fts_shortenurl_get'); 
add_action('publish_page', 'fts_shortenurl_get'); 
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'fts_shortenurl_actions', -10);
?>