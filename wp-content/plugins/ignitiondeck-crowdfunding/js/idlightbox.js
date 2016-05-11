jQuery(document).ready(function() {
	jQuery(document).bind('idc_lightbox_general', function(e) {
		var selLevel = jQuery('.idc_lightbox:visible select[name="level_select"]').val();
		var levelDesc = jQuery('.idc_lightbox:visible select[name="level_select"] :selected').data('desc');
		var levelPrice = jQuery('.idc_lightbox:visible select[name="level_select"] :selected').data('price');
		jQuery('.idc_lightbox:visible .text p').text(levelDesc);
		jQuery('.idc_lightbox input[name="total"]').val(levelPrice);
		jQuery('.idc_lightbox:visible span.total').data('value', levelPrice).text(levelPrice);
	});
	jQuery('.idc_lightbox select[name="level_select"]').change(function(e) {
		if (jQuery(this).has(':visible')) {
			//console.log(e);
			selLevel = jQuery(this).val();
			levelDesc = jQuery('.idc_lightbox:visible select[name="level_select"] :selected').data('desc');
			levelPrice = jQuery('.idc_lightbox:visible select[name="level_select"] :selected').data('price');
			jQuery('.idc_lightbox:visible .text p').text(levelDesc);
			jQuery('.idc_lightbox input[name="total"]').val(levelPrice);
			jQuery('.idc_lightbox:visible span.total').data('value', levelPrice).text(levelPrice);
		}
	});
	jQuery(document).bind('idc_lightbox_level_select', function(e, clickLevel) {
		// Mapping the index to the level orders
		var orderArray = {};
		i = 0;
		jQuery('.level-binding').each(function(index, element) {
			if (jQuery(this).attr('href') !== undefined && jQuery(this).attr('href') == ".idc_lightbox") {
				var optionElement = jQuery('.level_select option').get(i);
				// console.log('optionElement: ', optionElement);
				orderArray[index] = jQuery(optionElement).data('order');
				i++;
			}
		});
		// console.log('orderArray: ', orderArray);
		// selLevel = jQuery('.idc_lightbox:visible select[name="level_select"] option').eq(clickLevel).val();
		valExists = jQuery('.idc_lightbox:visible select[name="level_select"] option[data-order="'+ (orderArray[clickLevel]) +'"]').val();
		selLevel = valExists;
		// console.log('clickLevel: ', clickLevel, 'selLevel: ', selLevel);
		if (valExists) {
			levelDesc = jQuery('.idc_lightbox:visible select[name="level_select"] option[value="'+ selLevel +'"]').data('desc');
			levelPrice = jQuery('.idc_lightbox:visible select[name="level_select"] option[value="'+ selLevel +'"]').data('price');
			jQuery('.idc_lightbox:visible .text p').text(levelDesc);
			jQuery('.idc_lightbox input[name="total"]').val(levelPrice);
			jQuery('.idc_lightbox:visible span.total').data('value', levelPrice).text(levelPrice);
			// console.log('selecting selLevel: ', selLevel);
			jQuery('.idc_lightbox:visible .level_select').val(selLevel);
			// console.log('selected selLevel: ', selLevel);
			jQuery('.lb_level_submit').removeAttr('disabled');
		}
		else {
			jQuery('.idc_lightbox:visible .text p').text('');
			jQuery('.idc_lightbox input[name="total"]').val(0);
			jQuery('.idc_lightbox:visible span.total').data('value', 0).text('0');
			jQuery('.lb_level_submit').attr('disabled','disabled');
		}
	});
});