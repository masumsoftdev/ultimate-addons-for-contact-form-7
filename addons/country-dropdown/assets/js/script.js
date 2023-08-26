;(function ($) {


  var dynamic_selection = $('.wpcf7-uacf7_country_dropdown').attr('dynamic-selection');
	if(dynamic_selection !== 'true'){
		jQuery('.wpcf7-uacf7_country_dropdown').each(function(){
      var fieldId = jQuery(this).attr('id');
      var defaultCountry = jQuery(this).attr('country-code');
      var onlyCountries = jQuery(this).attr('only-countries');  
      if(typeof onlyCountries !== "undefined" && onlyCountries != ''){
        onlyCountries = JSON.parse(onlyCountries);
      }else{
        onlyCountries = '';
      }
      
      $("#"+fieldId).countrySelect({
        defaultCountry: defaultCountry,
        onlyCountries: onlyCountries,
        responsiveDropdown: true,
        preferredCountries: []
      });
      });
      
      
      $(document).on('change', '.wpcf7-uacf7_country_dropdown', function () {
      
      });
      
	}


  

})(jQuery);

