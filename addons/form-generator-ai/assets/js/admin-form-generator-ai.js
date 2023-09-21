(function ($) {
 
     
    $(document).ready(function () {   
      $('#uacf7-form-generator-ai').each(function() {
        var $this = $(this);
        var first_option = [
          { value: 'form', label: 'Form' },
          { value: 'tag', label: 'Tag' }, 
        ];
        var secend_option_form = [
          { value: 'uacf7-form-contact', label: 'Contact' },
          { value: 'uacf7-form-multistep', label: 'Multistep' }, 
          { value: 'uacf7-form-conversational', label: 'Conversational' }, 
          { value: 'uacf7-form-booking', label: 'Booking  ' }, 
          { value: 'uacf7-form-conditional', label: 'Conditional' }, 
          { value: 'uacf7-form-subscription', label: 'Subscription' }, 
        ];
        var secend_option_tag = [
          { value: 'text', label: 'Text' },
          { value: 'email', label: 'Email' },
          { value: 'URL', label: 'URL' },
          { value: 'tel', label: 'Tel' },
          { value: 'number', label: 'Number' },
          { value: 'date', label: 'Date' },
          { value: 'textarea', label: 'TExarea' },
        ];
   
        $.ajax({
          url: uacf7_form_ai.ajaxurl,
          type: 'post',
          data: {
              action: 'uacf7_form_generator_ai_get_tag',  
              ajax_nonce: uacf7_form_ai.nonce,
          },
          success: function (data) {  
            secend_option_tag = data.value;  
            
          }
        });  
        var third_option = [
          { value: 'label', label: 'With Label' },  
          { value: 'div', label: 'With Div' },  
          { value: 'span', label: 'With Spen' },  
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
            if(current_values[0].value == 'form'){
              uacf_form_ai.setChoices(secend_option_form, 'value', 'label', true);
            }else if(current_values[0].value == 'tag'){ 
              uacf_form_ai.setChoices(secend_option_tag, 'value', 'label', true);
            } 
          }
          else if(current_values.length == 2){ 
            if(current_values[1].value == 'uacf7-form-multistep' || current_values[1].value == 'uacf7-form-conditional'){ 
              $('.uacf7-form-steps-label').show();
            }else{
              $('.uacf7-form-steps-label').hide();
            }
          }
          else if(current_values.length == 0){
            uacf_form_ai.setChoices(first_option, 'value', 'label', true);
          }
 
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
      // $('#uacf7_ai_code_content pre code').html(html); 
      var searchValue = $('#uacf7-form-generator-ai').val();
      var form_step = $('#uacf7-form-steps').val();
      var form_field = $('#uacf7-form-fields').val();
      if ($('#uacf7-enable-form-label').is(':checked')) {
        var form_label = 1;
      }else{
        var form_label = 0;
      } 
      $.ajax({
        url: uacf7_form_ai.ajaxurl,
        type: 'post',
        data: {
            action: 'uacf7_form_generator_ai', 
            searchValue: searchValue,
            form_step: form_step,
            form_field: form_field,
            form_label: form_label,
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


