jQuery(document).ready(function($){
	$('#urlservicesel').each(function(){
		function lc(){	
			var target = $(this).val();
			$('.hideit, .showit').hide();
			$('#userkey_'+target).fadeIn(300);
		}					    
		$(this).change(lc);
		$(this).keypress(lc);
	});
	$('#shorturloptions').submit(function() {
		var serviceenable = $('#urlserviceenable').val();
		if (serviceenable == 'yes'){
			$('.reqfielderror').html("");						   
			var errorcount = false;
			var tweetdetails = $('#urltweet').val();
			if ( tweetdetails == 'auto' || tweetdetails == 'manual'){
				var tweetuser = jQuery.trim( $('#tweet_user').val() );
				var tweetpass = jQuery.trim( $('#tweet_pass').val() );
				if(tweetuser == "" || tweetpass == ""){
					$('.reqfielderror').append('Please fill in your Twitter Username and Password<br />');
					errorcount = true;
				}				
			}						   
			var seltarget = $('#urlservicesel').val();
			var selid = $('#userkey_'+seltarget);
			if ( selid.hasClass('req') ){
				
				var apiuserval = jQuery.trim( $("#apiuser_"+seltarget).val() );
				var apiuserkey = jQuery.trim( $("#apikey_"+seltarget).val() );
	
				if (apiuserval == "" || apiuserkey == ""){
					$('.reqfielderror').append('Please fill in both the API User and API Key as they are required.<br />');
					errorcount = true;
				}
			}
			if (errorcount){
				$('.reqfielderror').fadeIn(400);
				return false;
			} else {
				$('.reqfielderror').hide();
				return true;
			}
		}
	});
	$('#urlserviceenable').each(function(){
		function lc(){	
			var target = $(this).val();
			if (target == "yes"){
				$('#enableurlservice').fadeIn(300);
			} else {
				$('#enableurlservice').fadeOut(300);	
			}
		}						  
		$(this).change(lc);
		$(this).keypress(lc);
	});	
	$('#ownserviceoption').each(function(){
		function lc(){	
			var target = $(this).val();
			if (target == "yes"){
			$('#enableownservice').fadeIn(300);
			} else {
				$('#enableownservice').fadeOut(300);	
			}	
		}	
		$(this).change(lc);
		$(this).keypress(lc);
	});
	$('#ownredirecttypeoption').each(function(){
		function lc(){	
			var target = $(this).val();
			if (target == "templateredirect"){
				$('#htre').fadeOut(300);
				$('#tre').fadeIn(300);
			} else {
				$('#tre').fadeOut(300);
				$('#htre').fadeIn(300);	
			}

		}
		$(this).change(lc);
		$(this).keypress(lc);
	});
	$('.aserv-des').hide();
	$('.aserv').click(function(){
		$(this).next('.aserv-des').toggle(300);
		return false;
	});
	$('#urltweet').each(function(){
		function lc(){	
			var target = $(this).val();
			if (target == 'manual' || target == 'auto'){
				$('#tweetdetails').fadeIn(300);
			} else {
				$('#tweetdetails').fadeOut(300);	
			}
		}
		$(this).change(lc);
		$(this).keypress(lc);
	});
});