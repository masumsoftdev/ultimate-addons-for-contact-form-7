;(function ($) {

  var forms = $('.wpcf7-form');

  forms.each(function(){

          var formId = $(this).find('input[name="_wpcf7"]').val();
          
          var ds_country = $('.uacf7-form-'+formId).find('#uacf7_country_api').attr('ds_country'); 

 
	if(!ds_country){
      $('.uacf7-form-'+formId).find('.wpcf7-uacf7_country_dropdown').each(function(){
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
	 }
}); 

})(jQuery);

