jQuery(document).ready(function($){

	$('#menuBars').click(function(){
		$('#mobileMenu').slideToggle();
	});

	$(function(){
		$(window).resize(function(){
			if($(window).width() > 768){
				$('#mobileMenu').hide();
			}
		}).resize();
	});

});

jQuery(document).ready(function($){

	$('.ajax-catalogue-search').on('submit', function(event) {
		if (jQuery(this).hasClass('woocommerce')) {var Type = 'WooCommerce';}
		else {var Type = 'UPCP';}

		var Format = 'Full_Results';
		Run_AJAX_Product_Search(Type, Format);

		event.preventDefault();
	});

	$('.autocomplete-catalogue-search input').on('keyup', function() {
		if (jQuery(this).hasClass('woocommerce')) {var Type = 'WooCommerce';}
		else {var Type = 'UPCP';}

		var Input_Value = jQuery(this).val();
		var Format = 'Autocomplete';
		if (Input_Value.length >= 3) {Run_AJAX_Product_Search(Type, Format);}
	});
});

function Close_Ajax_Results_Lightbox(){
	jQuery('#ewd-kcae-ajax-results-background.ewd-kcae-Full_Results').click(function(e){
		if(e.target != this) return;
		jQuery('#ewd-kcae-ajax-results-background.ewd-kcae-Full_Results').hide();
		jQuery('#ewd-kcae-ajax-results-div').hide();
	});
	jQuery('#ewd-kcae-ajax-close-div.ewd-kcae-Full_Results #ewd-kcae-ajax-close-button').click(function(e){
		if(e.target != this) return;
		jQuery('#ewd-kcae-ajax-results-background.ewd-kcae-Full_Results').hide();
		jQuery('#ewd-kcae-ajax-results-div').hide();
	});
}

var RequestCount = 0;
function Run_AJAX_Product_Search(Type, Format) {
	var searchValue = jQuery('#headerSearchCatalog').val();
	var catalogueURL = jQuery('#headerSearch').attr('action');

	RequestCount = RequestCount + 1;
	var data = 'Search=' + searchValue + '&Request_Count=' + RequestCount + '&Catalogue_URL=' + catalogueURL;
	if (Type == 'WooCommerce') {data += '&action=ewd_kcae_wc_ajax_search';}
	else {data += '&action=upcp_ajax_search';} console.log(data);
	jQuery.post(ajaxurl, data, function(response) {
	   	var parsed_response = jQuery.parseJSON(response);
		if (parsed_response.request_count == RequestCount) {
	    	if (Type != 'WooCommerce') {
	    		var output0 = parsed_response.message.replace("<div class='upcp-minimal-img-div'>","<div class='upcp-minimal-img-div'><div class='upcp-minimal-img-div-inside'>");
	    		var output = output0.replace("<div class='upcp-minimal-title'>","</div><div class='upcp-minimal-title'>");
	    	}
	    	else {
	    		var output = parsed_response.message;
	    	}
	    	jQuery('#ewd-kcae-ajax-results').html(output);
	   	}
	   	Close_Ajax_Results_Lightbox();
	});

	jQuery('#ewd-kcae-ajax-results-background, #ewd-kcae-ajax-results-div').remove();

	var HTML = '<div id="ewd-kcae-ajax-results-background" class="ewd-kcae-' + Format + '"></div>';
	HTML += '<div id="ewd-kcae-ajax-results-div" class="ewd-kcae-' + Format + '">';
	HTML += '<div id="ewd-kcae-ajax-close-div" class="ewd-kcae-' + Format + '"><span id="ewd-kcae-ajax-close-button">x</span></div>';
	HTML += '<div id="ewd-kcae-ajax-results"><span class="ewd-kcae-ajax-retrieving">' + base_js_local.retrieving + '</span></div>';
	HTML += '<div class="clear"></div>'
	HTML += '<a href="' + catalogueURL + '?prod_name=' + searchValue + '" class="ewd-kcae-ajax-view-all">' + base_js_local.viewall + '</a>';
	HTML += '</div>'

	jQuery('#headerSearch').after(HTML);
}
