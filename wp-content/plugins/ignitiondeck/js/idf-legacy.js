jQuery(document).ready(function() {
	if (jQuery('.level-binding').length > 0) {
		jQuery.each(jQuery('.level-binding'), function() {
			jQuery(this).removeAttr('href');
		});
	}
	if (jQuery('.ign-supportnow a').length > 0) {
		jQuery.each(jQuery('.ign-supportnow a'), function() {
			jQuery(this).removeAttr('href');
		});
	}
	jQuery(document).bind('idc_lightbox_general', function(e) {
		// this is fired when we click on a generic support now button
		var selLevel = jQuery('.idc_lightbox:visible select[name="level_select"]').val();
		
		
		setLBValues(selLevel);
	});
	jQuery(document).bind('idc_lightbox_level_select', function(e, clickLevel) {
		selLevel = jQuery('.idc_lightbox:visible select[name="level_select"] option[data-order="'+ clickLevel +'"]').val();
		//levelDesc = jQuery('.idc_lightbox:visible select[name="level_select"] option[value="'+ selLevel +'"]').data('desc');
		//levelPrice = jQuery('.idc_lightbox:visible select[name="level_select"] option[value="'+ selLevel +'"]').data('price');
		setLBValues(selLevel);
	});
	jQuery('.idc_lightbox select[name="level_select"]').change(function(e) {
		// this is fired when we change the lightbox level selection
		if (jQuery(this).has(':visible')) {
			selLevel = jQuery(this).val();
			setLBValues(selLevel, false);
		}
	});
	function setLBValues(selLevel, withProp = true) {
		if (withProp) {
			var trueLevel = jQuery('.level_select option[value="' + selLevel + '"]');
			jQuery(trueLevel).prop('selected', true);
		}
		var levelDesc = jQuery('.idc_lightbox:visible select[name="level_select"] :selected').data('desc');
		var levelPrice = jQuery('.idc_lightbox:visible select[name="level_select"] :selected').data('price');
		jQuery('.idc_lightbox:visible .text p').text(levelDesc);
		jQuery('.idc_lightbox:visible span.total').data('value', levelPrice).text(levelPrice);
	}
});