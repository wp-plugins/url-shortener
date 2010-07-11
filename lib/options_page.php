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
	
	//Services
	$options['urlservice'] = $_POST['urlservice'];
	foreach ($this->authuser as $user){
		$options['apiuser_'.$user] = $_POST['apiuser_'.$user];
	}
	foreach ($this->authkey as $key){
		$options['apikey_'.$key] = $_POST['apikey_'.$key];
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
?>
<div class="wrap">
    <h2><?php _e('URL Shortener', 'FTShorten'); echo ' '.FTS_URL_SHORTENER_VERSION ?></h2>
	<form method="post" action="<?php echo $action_url ?>" id="shorturl_options">
		<?php wp_nonce_field('fts-urlshortener'); ?>
		<input type="hidden" name="submitted" value="1" /> 
        <fieldset title="General Options for Plugin" class="fs0">
            <h3><?php _e('Main Settings', 'FTShorten'); ?></h3> 
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="urlserviceenable"><?php _e('URL Shortener Integration', 'FTShorten'); ?></label></th>
                    <td>
                        <input name="urlserviceenable" id="urlserviceenable" type="checkbox" value="yes" <?php checked('yes', $urlserviceenable) ?> />
                        <span class="description"><?php _e('Enable Short URL generation using your <a href="#shorturl_selector">configured service<a/>.', 'FTShorten'); ?></span>
                    </td>
                </tr>
				<tr>
                    <th scope="row"><label for="useslug"><?php _e('Use Permalinks for Short URLs', 'FTShorten'); ?></label></th>
                    <td>
                        <input name="useslug" id="useslug" type="checkbox" value="yes" <?php checked('yes', $useslug) ?> />
                        <span class="description"><?php _e('Use your <a href="'.get_option('siteurl').'/wp-admin/options-permalink.php">permalinks</a> to generate the Short URL.
						<br />(Default: "http://yoursite/?p=123" or "http://yoursite/?page_id=123").', 'FTShorten'); ?></span>
                    </td>
                </tr>
            </table>
        </fieldset>   
        
        <fieldset title="Additional Features" class="fs0">
            <h3><?php _e('Additional Features', 'FTShorten'); ?></h3> 
            <table class="form-table">
                <tr>
                    <th scope="row">
						<label for="niceid"><?php _e('Nice ID URLs', 'FTShorten'); ?></label><br />
						<span class="description"><?php _e('(Formally named template_redirection)', 'FTShorten');?></span>
					</th>
                    <td>
                        <input name="niceid" id="niceid" type="checkbox" value="yes" <?php checked('yes', $niceid) ?> />
                        <span class="description"><?php _e('Allows usage of "http://yoursite/123" instead of "http://yoursite/?p=123"', 'FTShorten'); ?></span></td>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="niceid"><?php _e('Nice ID URL Prefix', 'FTShorten'); ?></label></th>
                    <td>
                        <input name="niceid_prefix" type="text" id="niceidprefix" value="<?php echo $niceid_prefix; ?>" class="regular-text code" />
                        <span class="description"><?php _e('default: "/"  (http://yoursite/123)</span>
                        <p>Examples:
                            <br />"<span class="red">prefix/</span>" = http://yoursite/<span class="red">prefix/</span>123
                            <br />"<span class="red">prefix-</span>" = http://yoursite/<span class="red">prefix-</span>123
                        </p>', 'FTShorten'); ?>
                        </td>
                    </td>
                </tr>                
            </table>
        </fieldset>   
        
        <fieldset title="URL Shortening Services" id="shorturl_selector">
            <h3><?php _e('URL Service Configuration', 'FTShorten'); ?></h3> 
            <p><?php _e('Select and configure your desired Short URL service.', 'FTShorten'); ?></p> 
            <p><?php _e('<span class="red">*</span> are required configurations for that service.', 'FTShorten'); ?></p>
            <div class="reqfielderror"></div>
            <table id="shorturl_table" class="widefat post fixed" cellspacing="0">
            	<thead>
                    <tr>
                        <th scope="col" id="sr" class="manage-column"><?php _e('Select', 'FTShorten'); ?></th>
                        <th scope="col" id="ss" class="manage-column"><?php _e('Services', 'FTShorten'); ?></th>
                        <th scope="col" id="sc" class="manage-column"><span class="csc"><?php _e('Configuration', 'FTShorten'); ?></span></th>
                    </tr>
                </thead>
            	<tfoot>
                    <tr>
                        <th scope="col" class="manage-column"><?php _e('Select', 'FTShorten'); ?></th>
                        <th scope="col" class="manage-column"><?php _e('Services', 'FTShorten'); ?></th>
                        <th scope="col" class="manage-column"><span class="csc"><?php _e('Configuration', 'FTShorten'); ?></span></th>
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
                        if (in_array($key, $this->authkey)){
                            $apireq .= '<label for="apikey_'.$key.'">'; 
                            in_array($key, $this->reqkey) ? $apireq .= ' <span>*</span>' : $apireq .= '';               
							$apireq .= __('API/Key', 'FTShorten') . ': </label><input type="text" name="apikey_'.$key.'" id="apikey_'.$key.'" value="'.$options['apikey_'.$key].'" />';
                        }
                        if (in_array($key, $this->authuser)){
                            $apireq .= '<label for="apiuser_'.$key.'">';
                            in_array($key, $this->requser) ? $apireq .='<span>*</span>' : $apireq .='';
                            $apireq .= __('User/ID', 'FTShorten') . ': </label><input type="text" name="apiuser_'.$key.'" id="apiuser_'.$key.'" value="'.$options['apiuser_'.$key].'" />';
                        }                          
                        if ($apireq == ''){
                            $apireq = '<span class="nc">'. __('No Configuration Needed', 'FTShorten') .'</span>';
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
                            $('.reqfielderror').append('<?php _e('Please fill the required User/ID', 'FTShorten'); ?><br />');
                            errorcount = true;
                        }    
                    }
                    if($.inArray(checkopt, reqkey) == -1){}else{
                        var spass = jQuery.trim( $('#apikey_'+checkopt).val() );
                        if (spass == ''){
                            $('.reqfielderror').append('<?php _e('Please fill in the required API/Key', 'FTShorten'); ?><br />');
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