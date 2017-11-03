jQuery(document).ready(function($) {
	( function( api , $ ) {
		api.controlConstructor['section_order'] = api.Control.extend( {
			ready: function() {
				var control = this;
				var sections = jQuery('tbody').sortable({
					items: '.list-item',
					opacity: 0.6,
					cursor: 'move',
					axis: 'y',
					update: function() {
						//var order = jQuery(this).sortable('serialize') + '&action=kcae-update-homepage-section';
						//jQuery.post(ajaxurl, order, function(response) {});
						EWD_KCAE_Enable_Save();
					}
				});
				jQuery('input[type="checkbox"]').on('click', 'EWD_KCAE_Enable_Save');

				jQuery('#save').on('click', function(event) {
					event.preventDefault();
					var Raw_Data = sections.sortable('toArray');
					var Array_Data = [];
					jQuery(Raw_Data).each(function(index, el) {
						var Section = el.substr(10);
						if (jQuery('input[name="Visible[]"][data-section="'+Section+'"]').is(':checked')) {var Display = "Yes";}
						else {var Display = "No";}
						var Section_Data = [Section, Display];
						Array_Data.push(Section_Data);
					});
					var data = 'data=' + JSON.stringify(Array_Data) + '&action=kcae_update_homepage_section';
					jQuery.post(ajaxurl, data, function(response) {
						jQuery('#save').off('click');
						jQuery('#save').trigger('click');
					});
				});
			}
		});
	} )( wp.customize);
});

function EWD_KCAE_Enable_Save() {
	jQuery('#save').prop('disabled', false).val(customizer_js_local.savepublish);
}