<?php
//saving of values
if ( isset($_POST['submitted']) ) {
	check_admin_referer('fts-urlshortener');
	$options = array();
	
	//Shortener
	$options['urlserviceenable'] = $_POST['urlserviceenable']; 
	$options['useslug'] = $_POST['useslug'];
	
	//Nice ID
	$options['niceid'] = $_POST['niceid'];
	$options['niceid_prefix'] = $_POST['niceid_prefix'];
	
	//Shortcode
	$options['url_shortcode'] = $_POST['url_shortcode'];

	//Services
	$options['urlservice'] = $_POST['urlservice'];
	foreach ($this->authuser as $user){
		$options['apiuser_'.$user] = $_POST['apiuser_'.$user];
	}
	foreach ($this->authkey as $key){
		$options['apikey_'.$key] = $_POST['apikey_'.$key];
	}

	foreach ($this->generic as $generic){
		$options['generic_'.$generic] = $_POST['generic_'.$generic];
	}

	$this->save_options($options);
	echo '<div class="updated fade"><p>Plugin settings saved.</p></div>';
}

//setting up of options page
$options = $this->my_options();
$urlserviceenable = $options['urlserviceenable'];
$urlservice = $options['urlservice'];
$useslug = $options['useslug'];
$niceid = $options['niceid'];
$niceid_prefix = $options['niceid_prefix'];
$url_shortcode = $options['url_shortcode'];
$sfx = new FTShared();
?>
<div class="wrap">
    <h2><?php _e('URL Shortener', 'url-shortener'); echo ' '.FTS_URL_SHORTENER_VERSION ?></h2>
	<form method="post" action="<?php echo $action_url ?>" id="shorturl_options">
		<?php wp_nonce_field('fts-urlshortener'); ?>
		<input type="hidden" name="submitted" value="1" /> 
        <fieldset title="General Options for Plugin" class="fs0">
            <h3><?php _e('Main Settings', 'url-shortener'); ?></h3> 
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="urlserviceenable"><?php _e('URL Shortener Integration', 'url-shortener'); ?></label></th>
                    <td>
                        <input name="urlserviceenable" id="urlserviceenable" type="checkbox" value="yes" <?php checked('yes', $urlserviceenable) ?> />
                        <span class="description"><?php _e('Enable Short URL generation using your <a href="#shorturl_selector">configured service<a/>.', 'url-shortener'); ?></span>
                    </td>
                </tr>
				<tr>
                    <th scope="row"><label for="useslug"><?php _e('Use Permalinks for Short URLs', 'url-shortener'); ?></label></th>
                    <td>
                        <input name="useslug" id="useslug" type="checkbox" value="yes" <?php checked('yes', $useslug) ?> />
                        <span class="description"><?php sprintf(_e('Use your <a href="%s/wp-admin/options-permalink.php">permalinks</a> to generate the Short URL.'), get_option('siteurl'));?>
						<br /><?php _e('(Default: "http://yoursite/?p=123" or "http://yoursite/?page_id=123")', 'url-shortener'); ?></span>
                    </td>
                </tr>
            </table>
        </fieldset>   
        
        <fieldset title="Additional Features" class="fs0">
            <h3><?php _e('Additional Features', 'url-shortener'); ?></h3> 
            <table class="form-table">
                <tr>
                    <th scope="row">
						<label for="niceid"><?php _e('Nice ID URLs', 'url-shortener'); ?></label><br />
						<span class="description"><?php _e('(Formally named template_redirection)', 'url-shortener');?></span>
					</th>
                    <td>
                        <input name="niceid" id="niceid" type="checkbox" value="yes" <?php checked('yes', $niceid) ?> />
                        <span class="description"><?php _e('Allows usage of "http://yoursite/123" instead of "http://yoursite/?p=123"', 'url-shortener'); ?></span></td>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="niceid"><?php _e('Nice ID URL Prefix', 'url-shortener'); ?></label></th>
                    <td>
                        <input name="niceid_prefix" type="text" id="niceidprefix" value="<?php echo $niceid_prefix; ?>" class="regular-text code" />
                        <span class="description"><?php _e('default: "/"  (http://yoursite/123)</span>
                        <p>Examples:
                            <br />"<span class="red">prefix/</span>" = http://yoursite/<span class="red">prefix/</span>123
                            <br />"<span class="red">prefix-</span>" = http://yoursite/<span class="red">prefix-</span>123
                        </p>', 'url-shortener'); ?>
                        </td>
                    </td>
                </tr>
				<tr>	
					 <th scope="row"><label for="url_shortcode"><?php _e('Disable Shortcode [shortlink]', 'url-shortener'); ?></label></th>
					<td>
                        <input name="url_shortcode" id="url_shortcode" type="checkbox" value="no" <?php checked('no', $url_shortcode) ?> />
                        <span class="description"><?php _e('Disables the usage of URL Shortener shortcode [shortlink]', 'url-shortener'); ?></span></td>
                    </td>
				</tr>                
            </table>
        </fieldset>   
        
        <fieldset title="URL Shortening Services" id="shorturl_selector">
            <h3><?php _e('URL Service Configuration', 'url-shortener'); ?></h3> 
            <p><?php _e('Select and configure your desired Short URL service.', 'url-shortener'); ?></p> 
            <p><?php _e('<span class="red">*</span> are required configurations for that service.', 'url-shortener'); ?></p>
            <div class="reqfielderror"></div>
            <table id="shorturl_table" class="widefat post fixed" cellspacing="0">
            	<thead>
                    <tr>
                        <th scope="col" id="sr" class="manage-column"><?php _e('Select', 'url-shortener'); ?></th>
                        <th scope="col" id="ss" class="manage-column"><?php _e('Services', 'url-shortener'); ?></th>
                        <th scope="col" id="sc" class="manage-column"><span class="csc"><?php _e('Configuration', 'url-shortener'); ?></span></th>
                    </tr>
                </thead>
            	<tfoot>
                    <tr>
                        <th scope="col" class="manage-column"><?php _e('Select', 'url-shortener'); ?></th>
                        <th scope="col" class="manage-column"><?php _e('Services', 'url-shortener'); ?></th>
                        <th scope="col" class="manage-column"><span class="csc"><?php _e('Configuration', 'url-shortener'); ?></span></th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php
                    foreach ($this->supported as $key => $value){ 
                        if($urlservice == $key){ 
                            $sh = 'show'; 
                            $rh = 'class="rh"';
                        }else{    
                            $sh = 'hide';
                        }
                        $apirow = '<tr id="row_'.$key.'"'.$rh.'>';
                        $apirow .= '<th class="ssr" scope="row"><input name="urlservice" id="'.$key.'" type="radio" value="'.$key.'"'. checked($key, $urlservice, false) .'/></th>';
                        $apirow .= '<td class="ssl"><label for="'.$key.'">'.$value.'</label></td><td>';
                        
                        $apirow .= '<div id="userkey_'.$key.'" class="APIConfig '.$sh.'">';
                        $apireq = '';    

						//Key Authentication      
                        if (in_array($key, $this->authkey)){
                            $apireq .= '<label for="apikey_'.$key.'">'; 
                            in_array($key, $this->reqkey) ? $apireq .= ' <span>*</span>' : $apireq .= '';               
							$apireq .= __('API/Key', 'url-shortener') . ': </label><input type="text" name="apikey_'.$key.'" id="apikey_'.$key.'" value="'.$options['apikey_'.$key].'" />';
                        }
						
						//User Authentication
                        if (in_array($key, $this->authuser)){
                            $apireq .= '<label for="apiuser_'.$key.'">';
                            in_array($key, $this->requser) ? $apireq .='<span>*</span>' : $apireq .='';
                            $apireq .= __('User/ID', 'url-shortener') . ': </label><input type="text" name="apiuser_'.$key.'" id="apiuser_'.$key.'" value="'.$options['apiuser_'.$key].'" />';
                        }
			
						//Generic Services
                        if (in_array($key, $this->generic)){
                            $apireq .= '<br /><label for="generic_'.$key.'">';

							//Cases
							switch ($key){
								case 'interdose':
									$apireq .= __('Service', 'url-shortener') . ': </label><input type="text" name="generic_'.$key.'" id="generic_'.$key.'" value="'.$options['generic_'.$key].'" />';
									$data = $sfx->openurl('http://api.interdose.com/api/shorturl/v1/services.json');
									$data = $sfx->processjson($data);
									$count = count($data);
									if ($count){
										$apireq .= '<br /><span class="slabel">Public Services: </span>';
										for ($i = 0; $i < $count; $i++){
											$apireq .= '<a class="val_'.$key.'" href="#generic_'.$key.'">'.$data[$i]->service.'</a>';	
										}			 
									}
									break;
								default: 
									break;
							}
                        }                      
                        if ($apireq == ''){
                            $apireq = '<span class="nc">'. __('No Configuration Needed', 'url-shortener') .'</span>';
                        }    
                        $apirow.= $apireq;
                        $apirow.= '</div></td></tr>';
                        $rh = '';
                        echo $apirow;
                    }  
                    ?>
                </tbody>
            </table>
            
            <div class="clear"></div>
        </fieldset>
 
        <div class="reqfielderror"></div>
        <script type="text/javascript">
            jQuery(document).ready(function($){
                $('.hide, .csc, .reqfielderror').hide();
                
                $('.ssr input[type="radio"]').change(function(){
                    $('.rhs .APIConfig, .rh .APIConfig').hide();
                    $('.rhs').removeClass('rhs');
                    var pc = '';
                    pc = $(this).parent().parent();
                    if(($(this).is(':checked'))){// && !(pc.hasClass('rh'))){
                        pc.addClass('rhs');
                        $('.rhs .APIConfig').show();   
                    } 
                });
                
				$('.val_interdose').click(function(){
						linkval = $(this).html()
						$('#generic_interdose').val(linkval);
				})

                //start submit
                var requser = ['snipurl', 'snurl', 'snipr', 'snim', 'cllk'];
                var reqkey = ['snipurl', 'snurl', 'snipr', 'snim', 'cllk', 'awesm', 'pingfm'];
                $('#shorturl_options').submit(function() { 
                    $('.reqfielderror').html('');
                    var errorcount = false;                
                    var checkopt = $('input:radio[name=urlservice]:checked').val();
                    if($.inArray(checkopt, requser) == -1){}else{
                        var suser = jQuery.trim( $('#apiuser_'+checkopt).val() );
                        if (suser == ''){
                            $('.reqfielderror').append('<?php _e('Please fill the required User/ID', 'url-shortener'); ?><br />');
                            errorcount = true;
                        }    
                    }
                    if($.inArray(checkopt, reqkey) == -1){}else{
                        var spass = jQuery.trim( $('#apikey_'+checkopt).val() );
                        if (spass == ''){
                            $('.reqfielderror').append('<?php _e('Please fill in the required API/Key', 'url-shortener'); ?><br />');
                            errorcount = true;
                        }
                    }
                    if (errorcount){
                        $('.reqfielderror').fadeIn(400);
                        //return false;
                    } else {
                        $('.reqfielderror').hide();
                        //return false;
                    }               
                });//end submit
            });//end js    
        </script>       
        
        <p class="submit"><input type="submit" id="submit-button" class="button-primary" value="<?php _e('Save Changes') ?>" /></p>	
    </form>
</div>
