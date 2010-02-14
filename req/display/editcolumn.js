jQuery(document).ready(function($){					  
	var bulkshort = '<option selected="selected" value="0">Short URL Bulk Edit &nbsp;&nbsp;</option><option value="generate">Generate</option><option value="delete">Delete</option></select>';
	$('table.post, table.page').before('<select id="bulk-url">'+bulkshort+'<a class="button" id="gs" href="#bulk-url">Go</a>');	
	$('#doaction2').after('<select id="bulk-url2">'+bulkshort+'<a class="button" id="gs2" href="#bulk-url2">Go</a>');
	$('table.post, table.page').css({'margin-top':'10px'});

	$('.shortget').fadeIn();
	$('.shortget').css('display', 'inline-block');
		
	function shorturl(pid, action){
		var post = {};
		post['action'] = 'urlshortener_act';
		post['pid'] = pid;
		post['pagetype'] = pt;
		post['_ajax_nonce'] = nonce;
		post['urlaction'] = action;
		$('a#'+pid).removeClass('button');
		$('a#'+pid).text('Please Wait....');
		$.ajaxq('ftsshortenurl', { 
			type : 'POST',
			url : aaurl,
			data : post,
			success : function(data){
					if (data == '-1' || action != 'generate'){
						$('a#'+pid).text('Generate Now');
						$('a#'+pid).addClass('button');						
						$('a#'+pid).attr('href', '#'+pid);
						$('a#'+pid).css('display', 'inline-block');
					} else {
						$('a#'+pid).hide();
						$('a#'+pid).text('Generated');
						var resurl = $(data).find('response_data').text();
						$('a#'+pid).attr('href',  resurl);
						$('a#'+pid).fadeIn();
					}
				},
			error : function(data){
				$('a#'+pid).text('Generate Now');
				$('a#'+pid).addClass('button');
				}
		});
	}
	$('.shortget').click(function(){
		var sid = $(this).attr('id');
		var thref = $(this).attr('href');
		if (thref == '#'+sid){
			shorturl(sid, 'generate');
		}else{
			prompt('Short URL:', thref);
			return false;	
		}	
	});
	function bulkshorturl(urlaction){
		switch (urlaction){
		case 'generate' :			    
			$('table input:checkbox').each( function() {
				if ($(this).is(':checked')){ 						
					var sid = $(this).val();	
					shorturl(sid, 'generate');
				}
			});break;
		case 'delete' :
			var confirmdel = confirm ("Delete Short URLs from selected posts?");
			if (confirmdel){ $('table input:checkbox').each( function() {
				if ($(this).is(':checked')){ 						
					var sid = $(this).val();	
					shorturl(sid, 'delete');
				}
			});} break;
		default : break;
		}
	}
	$('#gs').click(function(){var urlact = $('#bulk-url').val();bulkshorturl(urlact);});	
	$('#gs2').click(function(){var urlact = $('#bulk-url2').val();bulkshorturl(urlact);});
});