<?php
function fts_shortenurl_init(){
	global $globe_fts_urlfx;
	//name - db
	register_setting('fts_shortenurl','fts_urlfx');
	$globe_fts_urlfx = get_option('fts_urlfx');

}

function fts_shortenurl_cssjs(){
	//css JS
	$plugin_url = WP_PLUGIN_URL.'/'.plugin_basename( dirname(dirname(__FILE__)) );
	wp_enqueue_script('fts_shortenurl_js', $plugin_url.'/req/fts_shortenurl.js',array('jquery'),1.0);
	wp_enqueue_style('fts_shortenurl_css', $plugin_url.'/req/fts_shortenurl.css');
}

function draw_fts_shortenurl_page(){
?>
	<div class="wrap">
		<h2>URL Shortening Service Integration for WordPress<span class="pluginbyline">by <a href="http://fusedthought.com">Gerald Yeo</a> (Fusedthought.com)</span></h2>
		
		<p>This plugin bring's the one-click URL Shortening functionality of WordPress.com blogs to your WordPress.org installation.</p>
		<p>Since WP.me is exclusive to WordPress.com users, this plugin supports a variety of other URL Shortening services, with more being added in future versions. </p>	
		<form id="shorturloptions" method="post" action="options.php">
			<?php settings_fields('fts_shortenurl'); ?>
			<?php $fts_urlfx = get_option('fts_urlfx'); ?>
			
			<h4 class="sectheaders">URL Shortening Service Settings</h4>
			
			<fieldset title="URL Shortening Service">
				<label for="urlservicesel">You're using:</label>
				
				<select name="fts_urlfx[urlservice]" id="urlservicesel" >
					<option value="none" <?php selected( 'none', $fts_urlfx['urlservice'] ); ?>>Select Service...</option>
					<option value="tinyurl" <?php selected( 'tinyurl', $fts_urlfx['urlservice'] ); ?>> TinyURL</option>				
					<option value="supr" <?php selected( 'supr', $fts_urlfx['urlservice'] ); ?>>Su.pr (by StumbleUpon)</option>
					<option value="isgd" <?php selected( 'isgd', $fts_urlfx['urlservice'] ); ?>>is.gd</option>
					<option value="bitly" <?php selected( 'bitly', $fts_urlfx['urlservice'] ); ?>>bit.ly</option>
					<option value="trim" <?php selected( 'trim', $fts_urlfx['urlservice'] ); ?>>tr.im</option>
					<option value="snip" <?php selected( 'snip', $fts_urlfx['urlservice'] ); ?>>Snipr / Snipurl</option>
					<option value="cligs" <?php selected( 'cligs', $fts_urlfx['urlservice'] ); ?>>Cligs (Cl.gs)</option>
					<option value="shortie" <?php selected( 'shortie', $fts_urlfx['urlservice'] ); ?>>Short.ie</option>
				</select>
				
				<div id="reqfielderror"></div>
				
				<div class="APIConfig">
					<div id="userkey_none" class="<?php if ($fts_urlfx['urlservice'] != 'none'){ echo "hideit";} else {echo "showit";} ?>">
						<p>Please select a service from the list provided.</p>
					</div>
				</div>
				
				<div class="APIConfig">
					<div id="userkey_tinyurl" class="<?php if ($fts_urlfx['urlservice'] != 'tinyurl'){ echo "hideit";} else {echo "showit";} ?>">
						<p>No authentication / further configurations needed for this service</p>
					</div>
				</div>
				
				<div class="APIConfig">
					<div id="userkey_supr" class="<?php if ($fts_urlfx['urlservice'] != 'supr'){ echo "hideit";} else {echo "showit";} ?>">
						<label class="apifields">API User (Optional)</label> 
						<input class="apiuserval" type="text" name="fts_urlfx[apiuser_supr]" value="<?php echo $fts_urlfx['apiuser_supr']; ?>" />
						<label class="apifields">API Key (Optional)</label> 
						<input class="apipassval" type="text" name="fts_urlfx[apikey_supr]" value="<?php echo $fts_urlfx['apikey_supr']; ?>" />
					</div>
				</div>
				
				<div class="APIConfig">
					<div id="userkey_isgd" class="<?php if ($fts_urlfx['urlservice'] != 'isgd'){ echo "hideit";} else {echo "showit";} ?>">
						<p>No authentication / further configurations needed for this service</p>
					</div>
				</div>
				
				<div class="APIConfig">
					<div id="userkey_bitly" class="<?php if ($fts_urlfx['urlservice'] != 'bitly'){ echo "hideit";} else {echo "showit";} ?> req">
						<label class="apifields">API User (Required)</label> 
						<input  class="apiuserval" type="text" id="apiuser_bitly" name="fts_urlfx[apiuser_bitly]" value="<?php echo $fts_urlfx['apiuser_bitly']; ?>" />
						<label class="apifields">API Key (Required)</label> 
						<input class="apipassval" type="text" id="apikey_bitly" name="fts_urlfx[apikey_bitly]" value="<?php echo $fts_urlfx['apikey_bitly']; ?>" />
					</div>
				</div>
				
				<div class="APIConfig">
					<div id="userkey_trim" class="<?php if ($fts_urlfx['urlservice'] != 'trim'){ echo "hideit";} else {echo "showit";} ?>">
						<label class="apifields">Username</label> 
						<input class="apiuserval" type="text" name="fts_urlfx[apiuser_trim]" value="<?php echo $fts_urlfx['apiuser_trim']; ?>" />
						<label class="apifields">Password</label> 
						<input class="apipassval" type="password" name="fts_urlfx[apikey_trim]" value="<?php echo $fts_urlfx['apikey_trim']; ?>" />
					</div>
				</div>

				<div class="APIConfig">
					<div id="userkey_snip" class="<?php if ($fts_urlfx['urlservice'] != 'snip'){ echo "hideit";} else {echo "showit";} ?> req">
						<label class="apifields">API User (Required)</label> 
						<input class="apiuserval" type="text" id="apiuser_snip" name="fts_urlfx[apiuser_snip]" value="<?php echo $fts_urlfx['apiuser_snip']; ?>" />
						<label class="apifields">API Key (Required)</label>
						<input class="apipassval" type="text" id="apikey_snip" name="fts_urlfx[apikey_snip]" value="<?php echo $fts_urlfx['apikey_snip']; ?>" />
					</div>
				</div>

				<div class="APIConfig">
					<div id="userkey_cligs" class="<?php if ($fts_urlfx['urlservice'] != 'cligs'){ echo "hideit";} else {echo "showit";} ?>">
						<label class="apifields">API Key (Optional)</label>
						<input class="apipassval" type="text" name="fts_urlfx[apikey_cligs]" value="<?php echo $fts_urlfx['apikey_cligs']; ?>" />
					</div>
				</div>

				<div class="APIConfig">
					<div id="userkey_shortie" class="<?php if ($fts_urlfx['urlservice'] != 'shortie'){ echo "hideit";} else {echo "showit";} ?>">
						<label class="apifields">API Email (Optional)</label>
						<input class="apipassval" type="text" name="fts_urlfx[apiuser_shortie]" value="<?php echo $fts_urlfx['apiuser_shortie']; ?>" />
						<label class="apifields">API Key (Optional)</label>
						<input class="apipassval" type="text" name="fts_urlfx[apikey_shortie]" value="<?php echo $fts_urlfx['apikey_shortie']; ?>" />
					</div>
				</div>
				
			</fieldset>

			<h4 class="sectheaders">Publishing Options</h4>
			<fieldset title="Publishing Options">
				<label for="postpubendis">Enable Automatic Short URL Generation upon Publishing:</label>
				<select name="fts_urlfx[urlautogen]" id="urlautogen" >
					<option value="yes" <?php selected( 'yes', $fts_urlfx['urlautogen'] ); ?>>Yes</option>				
					<option value="no" <?php selected( 'no', $fts_urlfx['urlautogen'] ); ?>>No</option>
				</select>
			</fieldset>
			

			<p class="submit">
				<input type="submit" id="submit-button" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
		</form>
		
	</div>

<?php
}

function fts_shorturl_posts_addons($post){
	add_meta_box('ftsshortenurl', 'Short URL', 'fts_shorturl_posts_metabox', 'post', 'side', 'default');
}
function fts_shorturl_page_addons($post){
	add_meta_box('ftsshortenurl', 'Short URL', 'fts_shorturl_posts_metabox', 'page', 'side', 'default');
}

function fts_shorturl_posts_metabox($post){
	global $globe_fts_urlfx;
	$postid = $post->ID;
	$shorturl = get_post_meta($postid, 'shorturl', true);
	
	if($globe_fts_urlfx['urlservice'] != 'none' && !$shorturl){
		wp_nonce_field( 'fts_shortenurl', '_ajax_ftsshorturl', false );	
		
		if($globe_fts_urlfx['urlautogen'] == 'yes'){?>
			<h4>How To:</h4>
			<p>Short URL will be generated upon publishing the post/page.</p>
			<p>Set "Enable Automatic Short URL Generation upon publish" in the <a href="options-general.php?page=shorturl">URL Shortener options page</a> to "No" to disable this</p>
			<input id="shortlink" type="hidden" name="get-shortlink" value="Enabled" />
			<script type="text/javascript">
			/* <![CDATA[ */
			jQuery(document).ready(function($){
				$('#misc-publishing-actions').append('<div class="misc-pub-section">Short URL Generation: <strong>Auto</strong></div>');
	
			});//global	
			/* ]]> */
			</script>
		
		<?php } else {?>
			<h4>How To:</h4>
			<p>Check the generate short URL option to enable short URL generation upon publishing the post/page.</p>
			<div id="fts_shorturl_nojs"><div style="font-weight: bold; padding: 1em; margin-top: 2em;background: #D2FFCF;">Generate Short URL on publish: <input id="shortlink" type="checkbox" name="get-shortlink" value="Enabled" /></div></div>
			<script type="text/javascript">
			/* <![CDATA[ */
			jQuery(document).ready(function($){
				$('#fts_shorturl_nojs').html('');
				$('#misc-publishing-actions').append('<div class="misc-pub-section">Short URL Status: <strong>No Short URL</strong></div><div style="font-weight: bold; padding: 1em; margin-top: 2em;background: #D2FFCF;">Generate Short URL on publish: <input id="shortlink" type="checkbox" name="get-shortlink" value="Enabled" /></div>');		
			});//global	
			/* ]]> */
			</script>

		<?php }//sutogen
		} elseif($globe_fts_urlfx['urlservice'] != 'none') { ?>
			
			<div style="text-align: left;">
				<p id="shortlinkstatus"><strong>Your current short URL is: </strong><br /><a href="<?php echo $shorturl;?>"><?php echo $shorturl;?></a></p>
				<p style="text-align: right"><input type="submit" class="button" id="remove-shortlink-button" name="remove-shortlink" value="Remove Short URL" /></p>
			</div>
			<script type="text/javascript">
			/* <![CDATA[ */
			jQuery(document).ready(function($){					  		
				$('#edit-slug-box').append('<span id="show-shortlink-button"><a class="button" href="#">Show Short URL</a></span>');	
				$('#show-shortlink-button a').click(function(){ 
					prompt('Short URL:', '<?php echo $shorturl; ?>'); 
					return false;
				});	
				
				$('#misc-publishing-actions').append('<div class="misc-pub-section"><div id="shortlinkstatustop" style="display: inline;">Short URL Status: <strong>Generated </strong></div><input type="submit" class="button" name="remove-shortlink" id="remove-shortlink-button1" value="Remove" /></div>');
				
				$('#remove-shortlink-button').click(function(){ 
					$('#shortlinkstatus').html('Removing short URL...');
					return true;
				});
				$('#remove-shortlink-button1').click(function(){ 
					$('#shortlinkstatustop').html('Shortlink Status: <strong>Removing....</strong>');
					return true;
				});
				
			});
			/* ]]> */
			</script>
		<?php
		} else {/*end urlservice else*/?>
		<h4>Plugin Not Configured</h4>
		<p>Please proceed to the <a href="options-general.php?page=shorturl">URL Shortener options page</a> to select your desired URL Shortening Service</p>
		<script type="text/javascript">
		/* <![CDATA[ */
		jQuery(document).ready(function($){
			$('#misc-publishing-actions').append('<div class="misc-pub-section">Short URL Status: <strong>Not Configured</strong></div><div style="padding: 1em; margin-top: 2em;background: #D2FFCF;">Please select your <a href="options-general.php?page=shorturl">URL Shortening Service</a></div>');

		});//global	
		/* ]]> */
		</script>
		
	<?php }
}


function fts_shorturl_add_page() {
	$plugin_page = add_options_page('URL Shortener', 'URL Shortener', 'administrator', 'shorturl', 'draw_fts_shortenurl_page');
	add_action( 'load-'.$plugin_page, 'fts_shortenurl_cssjs' );
}

if ( is_admin() ){ 
	add_action('admin_init', 'fts_shortenurl_init');
	add_action('load-post.php', 'fts_shorturl_posts_addons');
	add_action('load-post-new.php', 'fts_shorturl_posts_addons');
	add_action('load-page.php', 'fts_shorturl_page_addons');
	add_action('load-page-new.php', 'fts_shorturl_page_addons');
	add_action('admin_menu', 'fts_shorturl_add_page');
} else {}


?>