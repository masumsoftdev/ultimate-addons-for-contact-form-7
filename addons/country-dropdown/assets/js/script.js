(function ($) {
	jQuery('.wpcf7-uacf7_country_dropdown').each(function(){
		var fieldId = jQuery(this).attr('id');
		
		$("#"+fieldId).countrySelect({
			defaultCountry: "",
			// onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
			responsiveDropdown: true,
			preferredCountries: []
		});
	});
})(jQuery);
