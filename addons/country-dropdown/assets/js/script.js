;(function ($) {


      
  // 	const countrySelect = document.getElementById('uacf7_country');
  //   const stateSelect = document.getElementById('uacf7_state');
  //   const citySelect = document.getElementById('uacf7_city');

  // 	const apiUrlCountries = "https://masumofficegithub.github.io/csc/data.json";


  // fetch(apiUrlCountries)
  // .then(response => response.json())
  // .then(data => {
  // 		const countries = data;
  // 		countries.forEach(country => {
  // 				const option = document.createElement('option');
  // 				option.value = country.name;
  // 				option.textContent = country.name;
  // 				countrySelect.appendChild(option);
  // 		});

  // 		// Fetch states when a country is selected
  // 		countrySelect.addEventListener('change', function () {
  // 				const selectedCountry = countrySelect.value;
  // 				fetch(apiUrlCountries)
  // 						.then(response => response.json())
  // 						.then(data => {
  // 								const statesData = data;

  // 								// Find states for the selected country
  // 								const selectedCountryData = statesData.find(country => country.name === selectedCountry);

  // 								if (selectedCountryData) {
  // 										stateSelect.innerHTML = ""; // Clear previous state options
  // 										citySelect.innerHTML = ""; // Clear city options
  // 										for( var state of selectedCountryData.states){
  // 												const option = document.createElement('option');
  // 												option.value = state.name;
  // 												option.textContent = state.name;
  // 												stateSelect.appendChild(option);
  // 										}
  // 								}
  // 						})
              
  // 		});

  // 		// Fetch cities when a state is selected
  // 		stateSelect.addEventListener('change', function (){
  // 				const selectedState = stateSelect.value;
  // 				fetch(apiUrlCountries)
  // 						.then(response => response.json())
  // 						.then(data => {
  // 								const citiesData = data; 
  // 										for ( var country of citiesData ){
  // 											for ( var state of country.states){

  // 													const target_state = selectedState;
  // 													if(state.name === target_state){
  // 															for ( var city of state.cities){
  // 																	const option = document.createElement('option');
  // 																	option.value = city.name;
  // 																	option.textContent = city.name;
  // 																	citySelect.appendChild(option);
  // 															}	
  // 															break;
  // 													}
  // 											}
  // 									}				
  // 				});
  // 		});
      
  // });






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


})(jQuery);

