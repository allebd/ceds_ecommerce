function ShowOptionTab(TabName) {
	jQuery(".upcp-theme-option-set").each(function() {
		jQuery(this).addClass("upcp-theme-hidden");
	});
	jQuery("#"+TabName).removeClass("upcp-theme-hidden");
	
	// var activeContentHeight = jQuery("#"+TabName).innerHeight();
	// jQuery(".upcp-theme-options-page-tabbed-content").animate({
	// 	'height':activeContentHeight
	// 	}, 500);
	// jQuery(".upcp-theme-options-page-tabbed-content").height(activeContentHeight);

	jQuery(".options-subnav-tab").each(function() {
		jQuery(this).removeClass("options-subnav-tab-active");
	});
	jQuery("#"+TabName+"_Menu").addClass("options-subnav-tab-active");
}

jQuery(document).ready(function() {
	SetProductDeleteHandlers();

	jQuery('.ewd-upcp-theme-add-product-list-item').on('click', function(event) {
		var ID = jQuery(this).data('nextid');

		var HTML = "<tr id='ewd-upcp-theme-product-list-item-" + ID + "'>";
		HTML += "<td><a class='ewd-upcp-theme-delete-product-list-item' data-productid='" + ID + "'>" + admin_js_local.delete + "</a></td>";
		HTML += "<td><select name='Featured_Product_" + ID + "_ID' id='ewd-upcp-theme-select-populate-" + ID + "'></select></td>";
		HTML += "</tr>";

		//jQuery('table > tr#ewd-uasp-add-reminder').before(HTML);
		jQuery('#ewd-upcp-theme-product-list-table tr:last').before(HTML);

		AJAXUPCPDropdown("#ewd-upcp-theme-select-populate-" + ID);

		ID++;
		jQuery(this).data('nextid', ID); //updates but doesn't show in DOM

		SetProductDeleteHandlers();

		event.preventDefault();
	});
});

function SetProductDeleteHandlers() {
	jQuery('.ewd-upcp-theme-delete-product-list-item').on('click', function(event) {
		var ID = jQuery(this).data('productid');
		var tr = jQuery('#ewd-upcp-theme-product-list-item-'+ID);

		tr.fadeOut(400, function(){
            tr.remove();
        });

		event.preventDefault();
	});
}

function AJAXUPCPDropdown(selectID) {
	var data = '&action=upcp_theme_get_products';
    jQuery.post(ajaxurl, data, function(response) {
		response = response.substring(0, response.length - 1);
		var products_array = jQuery.parseJSON(response);
		jQuery(products_array).each(function(index, product) {
			//console.log('product', product);
			jQuery(selectID).append("<option value='"+product.ID+"'>"+product.Name+"</option>");
		});
    });
}

jQuery(document).ready(function() {
	jQuery('.ewd-upcp-theme-spectrum').spectrum({
		showInput: true,
		showInitial: true,
		preferredFormat: "hex",
		allowEmpty: true
	});

	jQuery('.ewd-upcp-theme-spectrum').css('display', 'inline');

	jQuery('.ewd-upcp-theme-spectrum').on('change', function() {
		if (jQuery(this).val() != "") {
			jQuery(this).css('background', jQuery(this).val());
			var rgb = EWD_UPCP_hexToRgb(jQuery(this).val());
			var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
			if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
			else {jQuery(this).css('color', '#000000');}
		}
		else {
			jQuery(this).css('background', 'none');
		}
	});

	jQuery('.ewd-upcp-theme-spectrum').each(function() {
		if (jQuery(this).val() != "") {
			jQuery(this).css('background', jQuery(this).val());
			var rgb = EWD_UPCP_hexToRgb(jQuery(this).val());
			var Brightness = (rgb.r * 299 + rgb.g * 587 + rgb.b * 114) / 1000;
			if (Brightness < 100) {jQuery(this).css('color', '#ffffff');}
			else {jQuery(this).css('color', '#000000');}
		}
	});
});

function EWD_UPCP_hexToRgb(hex) {
    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    return result ? {
        r: parseInt(result[1], 16),
        g: parseInt(result[2], 16),
        b: parseInt(result[3], 16)
    } : null;
}

jQuery(document).ready(function($){
 
    var custom_uploader;
 
    jQuery('#TextOnPic_Background_Image_button').click(function(e) {
 
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
          var sel = custom_uploader.state().get('selection')
          , attachment = [], i;

          console.log(sel.models);
          for(i=0; i< sel.models.length; i++) {
            console.log(sel.models[i].toJSON());
            attachment.push(sel.models[i].toJSON().url);
          }
          jQuery('#TextOnPic_Background_Image').val(attachment);
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
});

jQuery(document).ready(function($){

	jQuery('#TextOnPic_Overlay_Image_button').click(function(e) {
 
 		var custom_uploader;
 		
        e.preventDefault();
 
        //If the uploader object has already been created, reopen the dialog
        if (custom_uploader) {
            custom_uploader.open();
            return;
        }
 
        //Extend the wp.media object
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: true
        });
 
        //When a file is selected, grab the URL and set it as the text field's value
        custom_uploader.on('select', function() {
          var sel = custom_uploader.state().get('selection')
          , attachment = [], i;

          console.log(sel.models);
          for(i=0; i< sel.models.length; i++) {
            console.log(sel.models[i].toJSON());
            attachment.push(sel.models[i].toJSON().url);
          }
          jQuery('#TextOnPic_Overlay_Image').val(attachment);
        });
 
        //Open the uploader dialog
        custom_uploader.open();
 
    });
});