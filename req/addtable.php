<?php
function fts_mass_generate(){
	$plugin_url = WP_PLUGIN_URL.'/'.plugin_basename( dirname(dirname(__FILE__)) );
	wp_enqueue_script('fts_surl_edit', $plugin_url.'/req/display/editcolumn.js',array('jquery'),1.0);
	
	
	if(isset($_GET['btnurl']) || isset($_GET['btnurl2'])){
		$ftsuri = basename($_SERVER["SCRIPT_FILENAME"]);
		$bulkshort = $_GET['bulkurl'];
		if ($bulkshort == '0'){
			$bulkshort = $_GET['bulkurl2'];
		}
		$pid_array = $_GET['post'];
		switch ($bulkshort){
			case 'generate':
				foreach( (array) $pid_array as $pid ) {
					if($ftsuri == 'edit.php'){
						fts_shortenurl($pid, 'post');
					} elseif($ftsuri == 'edit-pages.php'){
						fts_shortenurl($pid, 'page');
					}
				}
				break;
			case 'delete':
				foreach( (array)  $pid_array as $pid ) {
					delete_post_meta($pid , 'shorturl');
					delete_post_meta($pid , 'short_url');
				}
				break;
			default:
				break;
		}
	}
}

function fts_edit_generate(){
	$ftsuri = basename($_SERVER["SCRIPT_FILENAME"]);
	$ftsgensurl = $_GET['urlid'];
	if($ftsgensurl !='' && is_numeric($ftsgensurl)){
		if($ftsuri == 'edit.php' ){
			fts_shortenurl($ftsgensurl, 'post');
		} elseif($ftsuri == 'edit-pages.php' ) {
			fts_shortenurl($ftsgensurl, 'page');
		}
	}	
}

function add_urlshortner_column($columns){
	$columns['Short_URL'] = __('Short URL');
   	return $columns;
}

function manage_urlshortner_column($column_name, $id){
	if ($column_name == "Short_URL"){
		$short = get_post_meta($id, 'shorturl', true); 
		if (!$short){
			$short = get_post_meta($id, 'short_url', true);
		}
		if ($short){
			print '<a class="ftsgt" href="'.$short.'"/>Generated</a>';	
		} else {
			$ftsuri = basename($_SERVER["SCRIPT_FILENAME"]);
			if($ftsuri == 'edit.php' ){
				print '<a class="button ftsgb" href="'.admin_url('edit.php').'?urlid='.$id.'">Generate Now</a>';
			} elseif($ftsuri == 'edit-pages.php' ) {
				print '<a class="button ftsgb" href="'.admin_url('edit-pages.php').'?urlid='.$id.'">Generate Now</a>';
			}	
		}
	}
}


add_filter('manage_posts_columns', 'add_urlshortner_column');
add_action('manage_posts_custom_column', 'manage_urlshortner_column', 10, 2);
add_filter('manage_pages_columns', 'add_urlshortner_column');
add_action('manage_pages_custom_column', 'manage_urlshortner_column', 10, 2);
add_action('load-edit.php', 'fts_edit_generate');
add_action('load-edit-pages.php', 'fts_edit_generate');
add_action('load-edit.php', 'fts_mass_generate');
add_action('load-edit-pages.php', 'fts_mass_generate');
?>