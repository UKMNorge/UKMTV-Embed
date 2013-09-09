jQuery(document).ready(function(){
	jQuery('iframe.ukmtv').each(function(){
		width = jQuery(this).css('width');
		height = (parseInt(width)/16)*9;
		jQuery(this).css('height', height+'px');
	})
});