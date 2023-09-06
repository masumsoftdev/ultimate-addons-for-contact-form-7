(function ($) {
    document.addEventListener('DOMContentLoaded', function () {
          new Choices('#uacf7-form-generator-ai', {
            maxItemCount: 2,
            disabled: false,
            allowHTML: false,
            duplicateItemsAllowed: false,
            removeItemButton: true, 
            placeholderValue: 'This is a placeholder set in the config',
            searchPlaceholderValue: 'This is a search placeholder',
          });
    });
    $(document).ready(function () { 
     
        var fullURL = window.location.href;
        // Create a URL object
        var parsedUrl = new URL(fullURL);

        // Use URLSearchParams to get values
        var pageValue = parsedUrl.searchParams.get('page');
        var actionValue = parsedUrl.searchParams.get('action');
        // display form generator ai in wpcf7-new page and edit page
        if( pageValue == 'wpcf7-new' || pageValue =='wpcf7' && actionValue == 'edit' ){ 
            $($(".wrap h1")[0]).append("<a  id='uacf7-ai-form-button-popup' class='uacf7-ai-form-button'>Form Generator AI</a>");

            $(document).on('click', '#uacf7-ai-form-button-popup', function(e){
                $('.uacf7-form-ai-popup').addClass('active');
                     
            });
            $(document).on('click', '.uacf7-form-ai-popup .close', function(e){
                $('.uacf7-form-ai-popup').removeClass('active');
                     
            });

            var substringMatcher = function(strs) {
                return function findMatches(q, cb) {
                  var matches, substringRegex;
              
                  // an array that will be populated with substring matches
                  matches = [];
              
                  // regex used to determine if a string contains the substring `q`
                  substrRegex = new RegExp(q, 'i');
              
                  // iterate through the pool of strings and for any string that
                  // contains the substring `q`, add it to the `matches` array
                  $.each(strs, function(i, str) {
                    if (substrRegex.test(str)) {
                      matches.push(str);
                    }
                  });
              
                  cb(matches);
                };
              };

            var states = [' Create a Multistep Form'];
            $('#uacf7_ai_serach').typeahead({
                hint: true,
                highlight: true,
                minLength: 1
              },
              {
                name: 'states',
                source: substringMatcher(states)
              });
        } 
        

        // Generate form Using Ajax Query
        
    });
})(jQuery);


