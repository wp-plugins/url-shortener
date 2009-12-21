<?php
/*
Plugin Name: URL Shortener Addon Module
Plugin URI: http://fusedthought.com/downloads/addon-module-for-url-shortener-wordpress-plugin/
Description: This plugin addons an addon module to the <a href="http://fusedthought.com/downloads/url-shortener-wordpress-plugin/">URL Shortener Plugin</a>. It provides additional services that are currently in testing and not fully supported by the main URL Shortener Plugin yet.
Author: Gerald Yeo
Author URI: http://fusedthought.com
Version: 1.7-Addon
*/
require_once(dirname(__FILE__).'/beta/googl.php');

function fts_url_beta_logo(){
	$plugin_loc_mod = WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__) );
	$plugin_logo_mod = '<img src="'.$plugin_loc_mod.'/plugin-logo-addon.jpg" alt="" />';
	echo $plugin_logo_mod;
}

function fts_url_beta_list(){?>
	<?php $fts_urlfx = get_option('fts_urlfx'); ?>
	<option class="betaservopt" value="googl" <?php selected( 'googl', $fts_urlfx['urlservice'] ); ?>>goo.gl (Google URL Shortener)&nbsp;</option>
<?php }

function fts_url_beta_listinfo(){ ?>
	<?php $fts_urlfx = get_option('fts_urlfx'); ?>
	<div class="APIConfig">
		<div id="userkey_googl" class="<?php if ($fts_urlfx['urlservice'] != 'googl'){ echo "hideit";} else {echo "showit";} ?>">
			<p>No authentication / further configurations needed for this service</p>
			<p class="betaservdes"><strong>Note: </strong>Support for this service is still in BETA.</p>
		</div>
	</div>

<?php } 

function fts_url_beta_services($url){
	$fts_urlfx = get_option('fts_urlfx');
	$betaservices = $fts_urlfx['urlservice'];
	switch ($betaservices){
		case 'googl':
			$authtok = generateToken($url);
			//ini_set('user_agent', "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.2) Gecko/20090729 Firefox/3.5.2 GTB5");
			$apiurl = 'http://goo.gl/api/url';
			$body = array (
				'user' => 'toolbar@google.com',
				'url' => $url,
				'auth_token' => $authtok		
			);	
			$googlurl = urlxmlresult($apiurl, 'POST', $body);
			$json = processjson($googlurl);
			$data = $json->short_url;
			return $data;
			break;
		
		default:
			break;		
	}
}
?>