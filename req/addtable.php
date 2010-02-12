<?php
function add_urlshortner_column($columns){
	$columns['Short_URL'] = __('Short URL');
   	return $columns;
}
function manage_urlshortner_column($column_name, $id){
	if ($column_name == "Short_URL"){
		$short = get_post_meta($id, 'shorturl', true); 
		if (!$short){$short = get_post_meta($id, 'short_url', true);}
		if ($short){
			print '<a class="shortget" href="'.$short.'" id="'.$id.'">Generated</a>';	
		} else {
			print '<a class="button shortget hidden" href="#'.$id.'" id="'.$id.'">Generate Now</a>';
		}
	}
}
function fts_urlshortener_edit_head(){
	$plugin_url = WP_PLUGIN_URL.'/'.plugin_basename( dirname(dirname(__FILE__)) );
	wp_enqueue_script('fts_surl_ajax', $plugin_url.'/req/display/jquery.ajaxq.js',array('jquery'),1.0);
	wp_enqueue_script('fts_surl_edit', $plugin_url.'/req/display/editcolumn.js',array('jquery'),1.0);
}
function fts_urlshortener_adminhead(){
	$ftsuri = basename($_SERVER["SCRIPT_FILENAME"]);
	?>
	<script type="text/javascript" >
		var pt = '<?php echo $ftsuri ?>';
		var aaurl = '<?php echo admin_url('admin-ajax.php'); ?>';
		var nonce = '<?php echo wp_create_nonce('urlshortener_ajax');?>';
	</script>
	<?php
}
function fts_urlshortener_ajaxcallback(){
	check_ajax_referer('urlshortener_ajax');
	$postid = $_POST['pid'];
	$pt = $_POST['pagetype'];
	$urlaction =  $_POST['urlaction'];
	switch ($urlaction){
		case 'generate' :
			if($pt  == 'edit.php' ){ $pagetype = 'post'; } elseif($pt == 'edit-pages.php' ) {$pagetype = 'page';}	
			$result = fts_shortenurl($postid, $pagetype, false, true);
			$x = new WP_AJAX_Response(array('data' => $result));
			$x->send();
			break;
		case 'delete' :
			delete_post_meta($postid, 'shorturl');
			delete_post_meta($postid, 'short_url');
			break;
		default: break;
	}
}
//create columns
add_filter('manage_posts_columns', 'add_urlshortner_column');
add_action('manage_posts_custom_column', 'manage_urlshortner_column', 10, 2);
add_filter('manage_pages_columns', 'add_urlshortner_column');
add_action('manage_pages_custom_column', 'manage_urlshortner_column', 10, 2);
//ajax and inc.
add_action('admin_head', 'fts_urlshortener_adminhead');
add_action('wp_ajax_urlshortener_act', 'fts_urlshortener_ajaxcallback');
add_action('load-edit.php', 'fts_urlshortener_edit_head');
add_action('load-edit-pages.php', 'fts_urlshortener_edit_head');
?>