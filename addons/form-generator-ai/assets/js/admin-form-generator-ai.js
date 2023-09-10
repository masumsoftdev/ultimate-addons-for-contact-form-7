(function ($) {
 
     
    $(document).ready(function () {  
      document.querySelectorAll('#uacf7_ai_code_content').forEach(el => {
        // then highlight each
        hljs.highlightElement(el);
      });
      $('#uacf7-form-generator-ai').each(function() {
        var $this = $(this);
        var first_option = [
          { value: 'uacf7-form-default', label: 'Default form Form' },
          { value: 'uacf7-form-multistep', label: 'Multistep Form' }, 
        ];
        var secend_option = [
          { value: 'field', label: 'first 1' },
          { value: 'field2', label: 'first 2' },
        ];
        const uacf_form_ai = new Choices('#uacf7-form-generator-ai', {
          maxItemCount: 5,
          disabled: false,
          allowHTML: false,
          duplicateItemsAllowed: false, 
          placeholderValue: 'This is a placeholder set in the config',
          searchPlaceholderValue: 'This is a search placeholder',
        }).setChoices(first_option, 'value', 'label', true);

        $('#uacf7-form-generator-ai').on('change', function(event) {
          var current_values = uacf_form_ai.getValue();
          uacf_form_ai.clearChoices(); 
          if(current_values.length == 1){ 
            uacf_form_ai.setChoices(secend_option, 'value', 'label', true);
          }else if(current_values.length == 0){
            uacf_form_ai.setChoices(first_option, 'value', 'label', true);
          }

          // $('#uacf7-form-generator-ai option').each(function() { 
          //   console.log($(this));
          //   if(!$(this).selected){
          //     // $(this).remove();
          //   } 
          // });
          
          // uacf_form_ai.clearStore(); 
        });

     });
      

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
        } 
        

        // Generate form Using Ajax Query
        
    });

    $(document).on('click', '.uacf7_ai_search_button', function(e){
        e.preventDefault();
        html = hljs.highlightAuto('<h1>Hello World! how are you bro</h1>').value;
        // $('#uacf7_ai_code_content pre code').html(html);
        typeName(html, 0); 
        return false;
        var searchValue = $('#uacf7-form-generator-ai').val();
        console.log(searchValue);
        jQuery.ajax({
          url: uacf7_form_ai.ajaxurl,
          type: 'post',
          data: {
              action: 'uacf7_form_generator_ai', 
              searchValue: searchValue,
              ajax_nonce: uacf7_form_ai.nonce,
          },
          success: function (data) {
            typeName(data.value, 0);
           
          }
      });    

    });

    function typeName(data, iteration) {
      // Prevent our code executing if there are no letters left
      if (iteration === data.length)
          return;
      
      setTimeout(function() {
          // Set the name to the current text + the next character
          // whilst incrementing the iteration variable
          // $('.name').text( $('.name').text() + data[iteration++] );
          $('#uacf7_ai_code_content').html($('#uacf7_ai_code_content').html()+data[iteration++]);
          // Re-trigger our function
          typeName(data, iteration);
      }, 5);
  }
})(jQuery);


