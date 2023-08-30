;(function ($) {


  var forms = $('.wpcf7-form');

  forms.each(function(){

          var formId = $(this).find('input[name="_wpcf7"]').val();
          
          var ds_country = $('.uacf7-form-'+formId).find('#uacf7_country_api').attr('ds_country');
          var country_auto_complete = $('.uacf7-form-'+formId).find('#uacf7_country_api').attr('country_auto_complete');
          var country_auto_complete_v2 = $('.uacf7-form-'+formId).find('.wpcf7-uacf7_country_dropdown').attr('country_auto_complete');
          // var country_auto_complete = $('.uacf7-form-'+formId).find('#uacf7_country_api').attr('country_auto_complete');  
          // var city_auto_complete = $('.uacf7-form-'+formId).find('#uacf7_country_api').attr('city_auto_complete'); 
          // var state_auto_complete = $('.uacf7-form-'+formId).find('#uacf7_country_api').attr('state_auto_complete'); 
          // var road_auto_complete = $('.uacf7-form-'+formId).find('#uacf7_country_api').attr('road_auto_complete'); 
  
 
	if( !ds_country){
    if(!country_auto_complete_v2){
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
	 }
}); 


})(jQuery);

