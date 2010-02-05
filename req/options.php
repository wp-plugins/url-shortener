<?php
function fts_shortenurl_cssjs(){
	$plugin_url = WP_PLUGIN_URL.'/'.plugin_basename( dirname(dirname(__FILE__)) );
	wp_enqueue_script('fts_shortenurl_js', $plugin_url.'/req/display/fts_shortenurl.js',array('jquery'),1.0);
	wp_enqueue_style('fts_shortenurl_css', $plugin_url.'/req/display/fts_shortenurl.css');
}
function draw_fts_shortenurl_page(){
	global $addonurl;
	global $fts_urlfx;
	global $fts_tweeted;
	$plugin_loc = WP_PLUGIN_URL.'/'.plugin_basename( dirname(dirname(__FILE__)) );
	$plugin_logo = '<img src="'.$plugin_loc.'/plugin-logo.jpg" alt="" />';
	?>
	<div class="wrap">
		<h2>URL Shortener<span class="pluginbyline">by <a href="http://fusedthought.com">Gerald Yeo</a> (Fusedthought.com)</span></h2>
		<div class="logo">
			<a href="http://fusedthought.com/downloads/url-shortener-wordpress-plugin/">
				<?php if($fts_urlfx['urlbetaservices'] == 'yes' && function_exists('fts_url_beta_logo')){
					fts_url_beta_logo();
				}else{echo $plugin_logo; }?>
			</a>
		</div>
		<p>This plugin allows you to :
			<ul class="ptshow">
				<li>Create shorter URLs using WordPress Post IDs, redirecting <em>http://yoursite/POST-ID</em> to the actual post.</li>
				<li>Generate Short URLs using 3rd Party Services</li>
			</ul>
		</p>
		<p>It bring's the one-click/automated URL Shortening functionality to your WordPress.org installation.</p>
		
		<form id="shorturloptions" method="post" action="options.php">
			<?php wp_nonce_field('update-options'); ?>
			<?php settings_fields('fts_shortenurl'); ?>
			<h4 class="sectheaders">Integration Options</h4>
			
			<!--START OPTIONS-->
			<div class="nl optsect">
				<label class="mainopt">Enable Shortening Service Integration:</label>
				<select name="fts_urlfx[urlserviceenable]" id="urlserviceenable">
					<option value="yes" <?php selected( 'yes', $fts_urlfx['urlserviceenable'] ); ?>>Yes &nbsp;</option>
					<option value="no" <?php selected( 'no', $fts_urlfx['urlserviceenable'] ); ?>>No &nbsp;</option>
				</select>
				<div id="enableurlservice" class="sub <?php if ($fts_urlfx['urlserviceenable'] != 'yes'){ echo "ehideit";} else {echo "eshowit";} ?>">
					<fieldset title="URL Shortening Service">
						<label for="urlservicesel">You're using:</label>
						
						<select name="fts_urlfx[urlservice]" id="urlservicesel" >
							<option value="none" <?php selected( 'none', $fts_urlfx['urlservice'] ); ?>>Select Service... &nbsp;</option>
							<option value="tinyurl" <?php selected( 'tinyurl', $fts_urlfx['urlservice'] ); ?>> TinyURL &nbsp;</option>				
							<option value="supr" <?php selected( 'supr', $fts_urlfx['urlservice'] ); ?>>Su.pr (by StumbleUpon) &nbsp;</option>
							<option value="isgd" <?php selected( 'isgd', $fts_urlfx['urlservice'] ); ?>>is.gd &nbsp;</option>
							<option value="bitly" <?php selected( 'bitly', $fts_urlfx['urlservice'] ); ?>>bit.ly &nbsp;</option>
							<option value="trim" <?php selected( 'trim', $fts_urlfx['urlservice'] ); ?>>tr.im &nbsp;</option>
							<option value="snipurl" <?php selected( 'snipurl', $fts_urlfx['urlservice'] ); ?>>Snipr / Snipurl / Snurl &nbsp;</option>
							<option value="cligs" <?php selected( 'cligs', $fts_urlfx['urlservice'] ); ?>>Cligs (Cl.gs &nbsp;)</option>
							<option value="shortie" <?php selected( 'shortie', $fts_urlfx['urlservice'] ); ?>>Short.ie &nbsp;</option>
							<option value="shortto" <?php selected( 'shortto', $fts_urlfx['urlservice'] ); ?>>Short.to &nbsp;</option>
							<option value="chilpit" <?php selected( 'chilpit', $fts_urlfx['urlservice'] ); ?>>Chilp.it &nbsp;</option>
							<option value="pingfm" <?php selected( 'pingfm', $fts_urlfx['urlservice'] ); ?>>Ping.fm &nbsp;</option>
							<option value="smsh" <?php selected( 'smsh', $fts_urlfx['urlservice'] ); ?>>sm00sh / smsh &nbsp;</option>
							<option value="unu" <?php selected( 'unu', $fts_urlfx['urlservice'] ); ?>>u.nu &nbsp;</option>
							<option value="unfakeit" <?php selected( 'unfakeit', $fts_urlfx['urlservice'] ); ?>>unfake.it &nbsp;</option>
							<option value="awesm" <?php selected( 'awesm', $fts_urlfx['urlservice'] ); ?>>awe.sm &nbsp;</option>
							<?php if ($fts_urlfx['urlbetaservices'] == 'yes' && fts_active('url-shortener-addon-2/fts-shortenurl-addon-module.php')){
							echo fts_url_beta_list();
							}?>
						</select>
						<div class="APIConfig">
							<div id="userkey_none" class="<?php if ($fts_urlfx['urlservice'] != 'none'){ echo "hideit";} else {echo "showit";} ?>">
								<p>Please select a service from the list provided.</p>
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
							<div id="userkey_snipurl" class="<?php if ($fts_urlfx['urlservice'] != 'snipurl'){ echo "hideit";} else {echo "showit";} ?> req">
								<label class="apifields">API User (Required)</label> 
								<input class="apiuserval" type="text" id="apiuser_snipurl" name="fts_urlfx[apiuser_snip]" value="<?php echo $fts_urlfx['apiuser_snip']; ?>" />
								<label class="apifields">API Key (Required)</label>
								<input class="apipassval" type="text" id="apikey_snipurl" name="fts_urlfx[apikey_snip]" value="<?php echo $fts_urlfx['apikey_snip']; ?>" />
								<label class="apifields">Select Prefix (Default: Snipr.com)</label>
								<select name="fts_urlfx[snipprefix]" id="snipprefixsel" >
									<option value="snipr" <?php selected( 'snipr', $fts_urlfx['snipprefix'] ); ?>>Snipr.com &nbsp;</option>									
									<option value="snim" <?php selected( 'snim', $fts_urlfx['snipprefix'] ); ?>>Sn.im &nbsp;</option>			
									<option value="snurl" <?php selected( 'snurl', $fts_urlfx['snipprefix'] ); ?>>Snurl.com &nbsp;</option>
									<option value="snipurl" <?php selected( 'snipurl', $fts_urlfx['snipprefix'] ); ?>>Snipurl.com &nbsp;</option>
								</select>
								
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
						<div class="APIConfig">
							<div id="userkey_pingfm" class="<?php if ($fts_urlfx['urlservice'] != 'pingfm'){ echo "hideit";} else {echo "showit";} ?> req">
								<label class="apifields">User Key (Required)</label>
								<input class="apipassval" type="text" id="apikey_pingfm" name="fts_urlfx[apikey_pingfm]" value="<?php echo $fts_urlfx['apikey_pingfm']; ?>" />
								<input class="apipassval" type="hidden" id="apiuser_pingfm" name="fts_urlfx[apiuser_pingfm]" value="nil" />
							</div>
						</div>
						<div class="APIConfig">
							<div id="userkey_awesm" class="<?php if ($fts_urlfx['urlservice'] != 'awesm'){ echo "hideit";} else {echo "showit";} ?> req">
								<label class="apifields">User Key (Required)</label>
								<input class="apipassval" type="text" id="apikey_awesm" name="fts_urlfx[apikey_awesm]" value="<?php echo $fts_urlfx['apikey_awesm']; ?>" />
								<input class="apipassval" type="hidden" id="apiuser_awesm" name="fts_urlfx[apiuser_awesm]" value="nil" />
							</div>
						</div>
						
						<?php if ($fts_urlfx['urlbetaservices'] == 'yes' && fts_active('url-shortener-addon-2/fts-shortenurl-addon-module.php')){
						echo fts_url_beta_listinfo();
						}?>
					</fieldset>
					<fieldset>
						<div class="nl">
							<label>Enable Automatic Short URL Generation upon Publishing: </label>
							<select name="fts_urlfx[urlautogen]" id="urlautogenpost" >
								<option value="yes" <?php selected( 'yes', $fts_urlfx['urlautogen'] ); ?>>Yes &nbsp;</option>				
								<option value="no" <?php selected( 'no', $fts_urlfx['urlautogen'] ); ?>>No &nbsp;</option>
							</select>
						</div>
					</fieldset>
					<?php if (fts_active('tweeted/tweeted.php')){?>
					<fieldset class="mod">
						<div class="nl">
							<label>Post to Twitter:</label>
							<select name="fts_tweeted[tweet]" id="urltweet" >
								<option value="disable" <?php selected( 'disable', $fts_tweeted['tweet'] ); ?>>Disable &nbsp;</option>							
								<option value="manual" <?php selected( 'manual', $fts_tweeted['tweet'] ); ?>>Manual &nbsp;</option>
								<option value="auto" <?php selected( 'auto', $fts_tweeted['tweet'] ); ?>>Auto &nbsp;</option>				
							</select> <a class="aserv" href="#">[?]</a>
							<div class="aserv-des none">
								<p><strong>Disable</strong>: Entire Twitter module will be disabled</p>
								<p><strong>Manual</strong>: Option to post updates to twitter will be made available</p>
								<p><strong>Auto</strong>: Automatically post your Title and the Short URL to Twitter upon post publishing.</p>
								<p>(Format of update: "Title, Short URL")</p>
							</div>
							<div id="tweetdetails" class="<?php if ($fts_tweeted['tweet'] == 'manual' || $fts_tweeted['tweet'] == 'auto' ){ echo "eshowit";} else {echo "ehideit";} ?>">
								<label>Twitter Username (Required)</label> 
								<input type="text" id="tweet_user" name="fts_tweeted[tweet_user]" value="<?php echo $fts_tweeted['tweet_user']; ?>" />
								<label>Twitter Password (Required)</label> 
								<input  type="password" id="tweet_pass" name="fts_tweeted[tweet_pass]" value="<?php echo $fts_tweeted['tweet_pass']; ?>" />
							</div>
						</div>
					</fieldset>
					<?php } ?>
					<?php if (fts_active('url-shortener-addon-2/fts-shortenurl-addon-module.php')){?>
					<fieldset class="mod">
						<div class="nl">
							<label class="betaserv">Enable Addon Module (for bonus/beta services): </label>
							<select name="fts_urlfx[urlbetaservices]" id="urlbetaservices" >
								<option value="no" <?php selected( 'no', $fts_urlfx['urlbetaservices'] ); ?>>No &nbsp;</option>							
								<option class="betaservopt" value="yes" <?php selected( 'yes', $fts_urlfx['urlbetaservices'] ); ?>>Yes &nbsp;</option>				
							</select> <a class="aserv" href="#">[?]</a>
							<p class="aserv-des none">The addon module provides bonus services (highlighted in green) and beta services (highlighted in red) which are not available in the main URL Shortener Plugin.</p>
						</div>
					</fieldset>
					<?php } ?>
					<?php 
					$modulehighlight = '<div class="field"><p><strong>Additional plugins/modules which can be integrated:</strong></p><ol>';
					if (!fts_active('tweeted/tweeted.php')){
						$modulehighlight .= '<li><a href="'.$addonurl[1].'">Tweeted WordPress Plugin</a> - Update Twitter upon post/page publishing.</li>';
					}
					if (!fts_active('url-shortener-addon-2/fts-shortenurl-addon-module.php')){
						$modulehighlight .= '<li><a href="'.$addonurl[0].'">URL Shortener Addon Module</a> - Provides bonus or beta URL Shortener Services</li>';
					}
					$modulehighlight .='<ol></div>';
					if (!fts_active('tweeted/tweeted.php') || !fts_active('url-shortener-addon-2/fts-shortenurl-addon-module.php')){
						print $modulehighlight;
					}
					?>
				</div>
				
			</div>
			<!--END OPTIONS-->
			<!--START OPTIONS-->
			<div class="nl optsect" id="ownserviceprefix">
				<label class="mainopt">Enable Short URLs using Post ID: </label>
				<select name="fts_urlfx[ownservice]" id="ownserviceoption" >
					<option value="yes"<?php selected( 'yes', $fts_urlfx['ownservice'] ); ?>>Yes &nbsp;</option>				
					<option value="no"<?php selected( 'no', $fts_urlfx['ownservice'] ); ?>>No &nbsp;</option>
				</select>	
				<div id="enableownservice" class="sub <?php if ($fts_urlfx['ownservice'] != 'yes'){ echo "ehideit";} else {echo "eshowit";} ?>">
					<fieldset title="Own Service Options">	
						<div id="ownredirecttype"  class="nl" >
							<label>Select type of redirect: </label>		
							<select name="fts_urlfx[ownservicetype]"  id="ownredirecttypeoption">
								<option value="templateredirect"<?php selected( 'templateredirect', $fts_urlfx['ownservicetype'] ); ?>>Template Redirect &nbsp;</option>				
								<option value="wprewriteredirect"<?php selected( 'wprewriteredirect', $fts_urlfx['ownservicetype'] ); ?>>WP_Rewrite Redirect &nbsp;</option>
							</select>
							
							<div id="tre" class="nl <?php if ($fts_urlfx['ownservicetype'] != 'templateredirect'){ echo "ehideit";} else {echo "eshowit";} ?>">
								<p>If template redirect is chosen, you can add a prefix when displaying the URLs without prior configuration. The redirection function will take that into account.</p>
								<p>Appending of Prefixes are supported.</p>
								<small>Eg: http://yoursite/<em>prefix/</em>post-id or http://yoursite/<em>prefix</em>post-id</small>
							</div>
							
							<div id="htre" class="nl <?php if ($fts_urlfx['ownservicetype'] != 'wprewriteredirect'){ echo "ehideit";} else {echo "eshowit";} ?>">
								<p>NOTE: <strong>WP_Rewrite Redirect</strong> has <em>NO</em> Page redirect support. It will <em>ONLY</em> redirect posts.</p>
								<p>I would recommend using the "template redirect" method as it does a 301 (Permanent) Redirection, and hence more search engine friendly.</p>
								<label>If WP_Rewrite Redirect is selected, please input your preferred prefix (optional):</label>
								<input type="text" name="fts_urlfx[ownserviceprefix]" value="<?php echo $fts_urlfx['ownserviceprefix']; ?>" />
								<small>For example:</small>
								<small>If "prefix/" was set: URL would be http://yoursite/<em>prefix/</em>post-id </small>
								<small>If "prefix" (without "/") was set: URL would be http://yoursite/<em>prefix</em>post-id</small>
							</div>
						</div>
						
					</fieldset>
				</div>
			
			</div>
			<!--END OPTIONS-->
			
			<h4 class="sectheaders">Save Your Settings</h4>
			<div class="reqfielderror"></div>
			<p class="submit">
				<input type="submit" id="submit-button" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>		
		</form>	
	</div>
<?php }
function fts_shorturl_posts_addons($post){add_meta_box('ftsshortenurl', 'Short URL', 'fts_shorturl_posts_metabox', 'post', 'side', 'default');}
function fts_shorturl_page_addons($post){add_meta_box('ftsshortenurl', 'Short URL', 'fts_shorturl_posts_metabox', 'page', 'side', 'default');}

//Start Admin Page
function fts_shorturl_posts_metabox($post){
	global $fts_urlfx;
	global $fts_tweeted;
	$postid = $post->ID;
	$shorturl = get_post_meta($postid, 'shorturl', true);
	$anothershorturl = get_post_meta($postid, 'short_url', true);
	$got_tweet = get_post_meta($postid, 'tweet', true);
	if ($fts_urlfx['urlserviceenable'] == 'yes'){
	
		if($fts_urlfx['urlservice'] != 'none' && !$shorturl && !$anothershorturl){
			wp_nonce_field( 'fts_shortenurl', '_ajax_ftsshorturl', false );	
			
			if($fts_urlfx['urlautogen'] == 'yes'){?>
				<h4>How To:</h4>
				<p>Short URL will be generated upon publishing the post/page.</p>
				<p>To disable automatic generation, set "Enable Automatic Short URL Generation upon publish" in the <a href="options-general.php?page=shorturl">URL Shortener options page</a> to "No".</p>
				<input id="urlshortlink" type="hidden" name="get-shortlink" value="Enabled" />
				<script type="text/javascript">
				/* <![CDATA[ */
				jQuery(document).ready(function($){
					$('#misc-publishing-actions').append('<div class="misc-pub-section">Short URL Generation: <strong>Auto</strong></div>');
					<?php if (fts_active('tweeted/tweeted.php')){
						if($fts_tweeted['tweet'] == 'auto'){?>
							$('#misc-publishing-actions').append('<div class="misc-pub-section">Post to Twitter: <strong>Auto</strong></div>');
						<?php } elseif ($fts_tweeted['tweet'] == 'manual') {?>
							$('#misc-publishing-actions').append('<div class="misc-pub-section">Post to Twitter: <strong>Manual</strong></div>');
					<?php }}?>	
				});	
				/* ]]> */
				</script>
			
			<?php } else {?>
				<h4>How To:</h4>
				<p>Check the generate short URL option to enable short URL generation upon publishing the post/page.</p>
				<div id="fts_shorturl_nojs"><div style="font-weight: bold; padding: 1em; margin-top: 2em;background: #D2FFCF;">Generate Short URL on publish: <input id="urlshortlink" type="checkbox" name="get-shortlink" value="Enabled" /></div></div>
				<script type="text/javascript">
				/* <![CDATA[ */
				jQuery(document).ready(function($){
					$('#fts_shorturl_nojs').html('');
					$('#misc-publishing-actions').append('<div class="misc-pub-section">Short URL Status: <strong>No Short URL</strong></div>');				
					<?php if (fts_active('tweeted/tweeted.php')){
					if ($fts_tweeted['tweet'] == 'auto'){?>
					$('#misc-publishing-actions').append('<div class="misc-pub-section">Post to Twitter: <strong>Auto</strong></div>');
					<?php }elseif ($fts_tweeted['tweet'] == 'manual') {?>
					$('#misc-publishing-actions').append('<div class="misc-pub-section">Post to Twitter: <strong>Manual</strong></div>');
					<?php }}?>					
					$('#misc-publishing-actions').append('<div style="font-weight: bold; padding: 1em; margin-top: 2em;background: #D2FFCF;">Generate Short URL on publish: <input id="urlshortlink" type="checkbox" name="get-shortlink" value="Enabled" /></div>');		
				});//global	
				/* ]]> */
				</script>
	
			<?php }//sutogen

		} elseif($fts_urlfx['urlservice'] != 'none' ) { 	
			if($shorturl){
				$displayshorturl = $shorturl;
			} else {
				$displayshorturl = $anothershorturl;
			}?>
				
			<div style="text-align: left;">
				<p id="shortlinkstatus"><strong>Your current short URL is: </strong><br /><a href="<?php echo $displayshorturl;?>"><?php echo $displayshorturl;?></a></p><p style="text-align: right"><input type="submit" class="button" id="remove-shortlink-button" name="remove-shortlink" value="Remove Short URL" /></p>
			</div>
			<script type="text/javascript">
			/* <![CDATA[ */
			jQuery(document).ready(function($){	
				<?php if (!function_exists('get_shortlink') ){?>  		
					$('#edit-slug-box').append('<span class="show-shortlink-button"><a class="button" href="#">Show Short URL</a></span>');	
				<?php }?>
				$('#misc-publishing-actions').append('<div class="misc-pub-section"><div id="shortlinkstatustop" style="display: inline;">Short URL Status: <strong class="show-shortlink-button"><a href="#">Generated</a></strong></div>&nbsp;<input type="submit" class="button" name="remove-shortlink" id="remove-shortlink-button1" value="Remove" /></div>');
				<?php if (fts_active('tweeted/tweeted.php')){
					if($got_tweet){ ?>
						$('#misc-publishing-actions').append('<div class="misc-pub-section">Post to Twitter: <a href="<?php echo $got_tweet;?>"><strong>Published</strong></a></div>');
				<?php } elseif ($fts_tweeted['tweet'] == 'manual' || $fts_tweeted['tweet'] == 'auto'){?>
					$('#misc-publishing-actions').append('<div class="misc-pub-section">Post to Twitter: <input type="submit" class="button" name="post-tweet" value="Click to Post" /></div>');
				<?php }}?>
				$('.show-shortlink-button a').click(function(){ 
					prompt('Short URL:', '<?php echo $displayshorturl; ?>'); 
					return false;
				});	
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
	} else { /*url service enable else*/?>
	<p>Short URL generation using 3rd party services is currently <strong>disabled</strong></p>
	<p>To enable it, please proceed to the <a href="options-general.php?page=shorturl">URL Shortener options page</a> to select your desired URL Shortening Service</p>
	<?php }
}
function fts_shorturl_add_page() {
	$plugin_page = add_options_page('URL Shortener', 'URL Shortener', 'administrator', 'shorturl', 'draw_fts_shortenurl_page');
	add_action( 'load-'.$plugin_page, 'fts_shortenurl_cssjs' );
}
if ( is_admin() ){ 
	add_action('load-post.php', 'fts_shorturl_posts_addons');
	add_action('load-post-new.php', 'fts_shorturl_posts_addons');
	add_action('load-page.php', 'fts_shorturl_page_addons');
	add_action('load-page-new.php', 'fts_shorturl_page_addons');
	add_action('admin_menu', 'fts_shorturl_add_page');
} else {}
?>