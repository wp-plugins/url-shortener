jQuery(document).ready(function($){
	//$('#doaction').after('<input type="submit" class="button" name="btnsurl" value="Bulk Generate Short URL" />');
	//$('#doaction2').after('<input type="submit" class="button" name="btnsurl2" value="Bulk Generate Short URL" />');
	var bulkshort = '<div class="bulkshort"><select name="bulkurl"><option selected="selected" value="0">Short URL Bulk Edit &nbsp;&nbsp;</option><option value="generate">Generate</option><option value="delete">Delete</option></select><input type="submit" class="button" name="btnurl" value="Go" /></div>';
	var bulkshort2 = '<select name="bulkurl2"><option selected="selected" value="0">Short URL Bulk Edit &nbsp;&nbsp;</option><option value="generate">Generate</option><option value="delete">Delete</option></select><input type="submit" class="button" name="btnurl2" value="Go" />';
	$('table.post').before(bulkshort);
	$('table.page').before(bulkshort);	
	$('#doaction2').after(bulkshort2);

	$('.ftsgb').css('display','inline-block');
	$('.bulkshort').css({'margin-bottom':'10px'});
	$('.ftsgt').click(function(){
		prompt('Short URL:', this.href);
		return false;
	})
});