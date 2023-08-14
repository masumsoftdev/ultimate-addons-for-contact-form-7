(function ($) {

    $(document).ready(function () { 
        var fullURL = window.location.href;
        // Create a URL object
        var parsedUrl = new URL(fullURL);

        // Use URLSearchParams to get values
        var pageValue = parsedUrl.searchParams.get('page');
        var actionValue = parsedUrl.searchParams.get('action');
        if( pageValue == 'wpcf7-new' || pageValue =='wpcf7' && actionValue == 'edit' ){ 
            $($(".wrap h1")[0]).append("<a  id='uacf7-ai-form-button-popup' class='uacf7-ai-form-button'>Form Generator AI</a>");

            $(document).on('click', '#uacf7-ai-form-button-popup', function(e){
                 
                     
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
        
        
    });
})(jQuery);
