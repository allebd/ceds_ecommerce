onResizePortfolio = function(){
	jQuery('.featuredProds ul li').each(function(){
		var liThis = jQuery(this);
		var liWidth = liThis.width();
		var liHeight = liWidth * .8;
		var liBottomMargin = liThis.parent('ul').width() / 50;
		liThis.css('height', liHeight+'px');
		liThis.css('margin-bottom', liBottomMargin+'px');
	});
}

jQuery(document).ready(onResizePortfolio);
jQuery(window).bind('resize', onResizePortfolio);