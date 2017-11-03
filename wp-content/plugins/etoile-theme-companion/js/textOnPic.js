onResizeTextOnPic = function(){
	jQuery('.textOnPic').each(function(){
		var textOnPicThis = jQuery(this);
		var textOnPicWidth = textOnPicThis.width();
		var textOnPicHeight = textOnPicWidth * .291;
		var textOnPicImageHeight = textOnPicHeight * .7;
		var textOnPicImageMargin = textOnPicHeight * .15;
		var textOnPicTextHeight = textOnPicThis.find('.innerText').height();
		var textOnPicTextMargin = (textOnPicHeight - textOnPicTextHeight) / 2;
		if(textOnPicTextMargin < 10){
			textOnPicTextMargin = 10;
		}
		textOnPicThis.css('height', textOnPicHeight+'px');
		if( jQuery(window).width() < 768 ){
			textOnPicThis.find('.textOnPicImage img').css('height', textOnPicImageHeight+'px');
			textOnPicThis.find('.textOnPicImage img').css('width', 'auto');
			textOnPicThis.find('.textOnPicImage img').css('margin-top', textOnPicImageMargin+'px');
			textOnPicThis.find('.innerText').css('margin-top', textOnPicTextMargin+'px');
		}
		else{
			textOnPicThis.find('.textOnPicImage img').css('height', textOnPicImageHeight+'px');
			textOnPicThis.find('.textOnPicImage img').css('width', 'auto');
			textOnPicThis.find('.textOnPicImage img').css('margin-top', textOnPicImageMargin+'px');
			textOnPicThis.find('.innerText').css('margin-top', textOnPicTextMargin+'px');
		}
	});
}

jQuery(document).ready(onResizeTextOnPic);
jQuery(window).bind('resize', onResizeTextOnPic);