<?php
/*
Plugin Name: URL Shortener
Plugin URI: http://fusedthought.com/downloads/url-shortener-wordpress-plugin/
Description: This plugin integrates multiple URL Shortening service with your WordPress.org installation. Brings a similar functionality of WordPress.com's WP.me shortlinks feature but using 3rd partly URL Shorteners. Supports own domain URL Shortener awe.sm as well. An <a href="http://fusedthought.com/downloads/addon-module-for-url-shortener-wordpress-plugin/">Addon module for additional services</a> also available.
Author: Gerald Yeo
Author URI: http://fusedthought.com
Version: 2.1
*/
/* 
 * Use "fts_show_shorturl($post)" to display link in a post
 * On Demand shortening eg: "fts_shorturl('http://www.google.com', 'supr');"
 */
 
 //classe and global
global $fts_urlfx;
global $addonurl;
$addonurl[0] = "http://fusedthought.com/downloads/addon-module-for-url-shortener-wordpress-plugin/";
$addonurl[1] = "http://fusedthought.com/downloads/simply-tweeted-wordpress-plugin/";
require_once( dirname(__FILE__) . '/req/class.FTShorten.2.0.php');
require_once( dirname(__FILE__) . '/req/wprewriteredirect.php');
require_once( dirname(__FILE__) . '/req/templateredirect.php');
require_once( dirname(__FILE__) . '/req/options.php');
require_once( dirname(__FILE__) . '/req/addtable.php');
if (!function_exists('fts_active')){function fts_active($plugin) {return in_array( $plugin, apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) );}}
function fts_shortenurl_init(){
	global $fts_urlfx;
	//name - db
	register_setting('fts_shortenurl','fts_urlfx');
	$fts_urlfx = get_option('fts_urlfx');	
}
if ( is_admin() ){add_action('admin_init', 'fts_shortenurl_init', 9);}
function fts_show_shorturl($post){
	$postid = $post->ID;
	$the_shorturl = get_post_meta($postid, 'shorturl', true);
	if (!$the_shorturl){
		$the_shorturl = get_post_meta($postid, 'short_url', true);
	}
	echo $the_shorturl;
}
function fts_shorturl($posturl, $api){
	$api = strip_tags($api);
	$api = preg_replace("/[^a-zA-Z0-9]/", "", $api);
	$selectedservice = $api;
	require( dirname(__FILE__) . '/fts-shortenurl-logic.php' );
	echo $short;
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
function fts_shortenurl($post_ID, $typeofpost = 'none', $tweet = true, $res = false){
	global $fts_urlfx;
	$got_shorturl = get_post_meta($post_ID, 'shorturl', true);
	$got_other_shorturl = get_post_meta($post_ID, 'short_url', true);
	// Generate short URL
	if (!$got_shorturl){
		if (!$got_other_shorturl){
			if ($typeofpost == 'post'){
				$posturl = get_option('home')."/index.php?p=".$post_ID;
			}elseif($typeofpost == 'page'){
				$posturl = get_option('home')."/index.php?page_id=".$post_ID;
			}else{
				$posturl = get_permalink($post_ID);
			}
			$selectedservice = $fts_urlfx['urlservice'];
			require( dirname(__FILE__) . '/fts-shortenurl-logic.php' );	
			//$short = $posturl.'-test'; //for testing	
			if($short){
				update_post_meta($post_ID, 'shorturl', $short);
				if (fts_active('simply-tweeted/tweeted.php') && $fts_urlfx['tweet'] == 'auto') {
					if($tweet){fts_tweet($post_ID, $short);}
				}
				if ($res){return $short;}
			}
		}elseif ($res){return $got_other_shorturl;}
	}elseif ($res){return $got_shorturl;}
}
function fts_shortenurl_gateway($post){
	global $fts_urlfx;
	$postid = $post->ID;
	$customyes = $_POST['get-shortlink'];
	$typeofpost = $_POST['post_type'];
	$shorturl = get_post_meta($postid, 'shorturl', true);
	if ($fts_urlfx['urlserviceenable'] == 'yes'){
		if($fts_urlfx['urlservice'] != 'none' && !$shorturl){	
			if($fts_urlfx['urlautogen'] == 'yes'){	
				fts_shortenurl($postid, $typeofpost, true);
			} elseif($fts_urlfx['urlautogen'] == 'no' && $customyes == 'Enabled'){
				fts_shortenurl($postid, $typeofpost, false);
			}else{};
		}
	}
}
// Hooks
add_action('save_post', 'fts_shortenurl_remove'); 
add_action('publish_to_publish', 'fts_shortenurl_gateway', 15);
add_action('draft_to_publish', 'fts_shortenurl_gateway', 15); 
add_action('private_to_publish', 'fts_shortenurl_gateway', 15); 
add_action('future_to_publish', 'fts_shortenurl_gateway', 15); 
add_action('pending_to_publish', 'fts_shortenurl_gateway', 15);  
add_action('new_to_publish', 'fts_shortenurl_gateway', 15); 
add_filter( 'plugin_action_links_'.plugin_basename(__FILE__), 'fts_shortenurl_actions', -10);
?>