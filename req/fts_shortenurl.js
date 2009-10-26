jQuery(document).ready(function($){

	
	$('#urlservicesel').each(function(){
		$(this).change(function(){	
			var target = $(this).val();
			$('.hideit').hide();
			$('.showit').hide();
			$('#reqfielderror').hide();
			$('#userkey_'+target).fadeIn(300);
		});
	});
	
	$('#shorturloptions').submit(function() {
		var seltarget = $('#urlservicesel').val();
		var selid = $('#userkey_'+seltarget);
		if ( selid.hasClass('req') ){
			
			var apiuserval = jQuery.trim( $("#apiuser_"+seltarget).val() );
			var apiuserkey = jQuery.trim( $("#apikey_"+seltarget).val() );
	
			if (apiuserval == "" || apiuserkey == ""){
				$('#reqfielderror').html('<p>Please fill in both the API User and API Key as they are required.</p>')
				$('#reqfielderror').fadeIn(400);
				return false;	
			} else {
				//alert('got values')
				return true;	
			}
	
		} else {
			//alert('no req')
			return true;
		}
	});
	



	
});

