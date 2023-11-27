(function ($) {
    $(document).ready(function () {
        var uacf_quick_preloader = `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="20x" height="20px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
        <path d="M10 50A40 40 0 0 0 90 50A40 42 0 0 1 10 50" fill="#ffffff" stroke="none">
          <animateTransform attributeName="transform" type="rotate" dur="1s" repeatCount="indefinite" keyTimes="0;1" values="0 50 51;360 50 51"></animateTransform>
        </path>`;

        // One Click CF7 Plugin install and activate
        $(document).on('click', '.required-plugin-button', function () {  
            var plugin_status = $(this).attr('data-plugin-status');
           if(plugin_status == 'not_installed'){
                var plugin_slug = 'contact-form-7'; 
                var button = $(this);
                button.html('Installing...' ); 
                $.ajax({
                    url: uacf7_admin_params.ajax_url,
                    type: 'post',
                    data: {
                        action: 'woocommerce_ajax_install_plugin', 
                        _ajax_nonce: uacf7_admin_params.uacf7_nonce,
                        slug: plugin_slug, 
                    },
                    success: function (response) {
                        $('.required-plugin-button').attr('data-plugin-status', 'not_active');
                        uacf7_onclick_ajax_activate_plugin()
                    }
                }); 
           }else if(plugin_status ==  'not_active'){
                
                uacf7_onclick_ajax_activate_plugin();
           }
 
        });

        function uacf7_onclick_ajax_activate_plugin(){
            var button = $('.required-plugin-button');
            var plugin_slug = 'contact-form-7';
            var file_name = 'wp-contact-form-7';
            button.html('Activating...'); 
            $.ajax({
                url: uacf7_admin_params.ajax_url,
                type: 'post',
                data: {
                    action: 'uacf7_onclick_ajax_activate_plugin', 
                    _ajax_nonce: uacf7_admin_params.uacf7_nonce,
                    slug: plugin_slug, 
                    file_name: file_name, 
                },
                success: function (response) { 
                    button.html('Activated');
                    $('.required-plugin-button').attr('data-plugin-status', 'activate');
                    $('.required-plugin-button').attr('disabled', true);
                    $('.uacf7-next').attr('disabled', false);
                    $('.uacf7-next').removeClass('disabled');
                    
                }
            });
        }


 
        // Uacf7 Next Button
        $(document).on('click', '.uacf7-next', function (e) {  
             
            var $this = $(this);
            var current_step = $this.attr('data-current-step');
            var next_step = $this.attr('data-next-step');
            $('.uacf7-single-step-content[data-step='+current_step+']').removeClass('active');
            $('.uacf7-single-step-content[data-step='+next_step+']').addClass('active');
            $('.uacf7-single-step-item[data-step='+next_step+']').addClass('active');

            $this.attr('data-current-step', next_step);
            $this.attr('data-next-step',  parseInt(next_step) + 1);

           if(current_step == '2'){
            alert(current_step);
            // $(".tf-option-form.tf-ajax-save").submit();
                
           }else{
                
           }
            

 
        });


        // Uacf7 Create Form
        $(document).on('change', '#uacf7-select-form', function (e) {
            if($(this).val() != ''){
                $('.uacf7-setup-widzard-btn').show();
            }else{
                $('.uacf7-setup-widzard-btn').hide();
            }
        });

        // Uacf7 Create Form
        $(document).on('click', '.uacf7-create-form', function (e) {
            e.preventDefault(); 
            var $this = $(this);
            var form_name = $('#uacf7-select-form').val();  
            var form_value = $('#uacf7_ai_code_content').val();  
            if(form_name.length <= 1){
              alert('Please select form type');
              return false;
            }
             
            $.ajax({
              url: uacf7_admin_params.ajax_url,
              type: 'post',
              data: {
                action: 'uacf7_form_quick_create_form',
                form_name: form_name, 
                form_value: form_value, 
                ajax_nonce: uacf7_admin_params.uacf7_nonce,
              },
              success: function (data) { 
                // redirect to edit page
                window.location.href = data.edit_url; 
              }
            });
        });

        // Uacf7 Generate Form
        $(document).on('click', '.uacf7-generate-form', function (e) {
            e.preventDefault(); 
            var $this = $(this);
            var searchValue = $('#uacf7-select-form').val();  
            if(searchValue.length <= 1){
              alert('Please select form type');
              return false;
            }
             
            $.ajax({
              url: uacf7_admin_params.ajax_url,
              type: 'post',
              data: {
                action: 'uacf7_form_generator_ai_quick_start',
                searchValue: searchValue, 
                ajax_nonce: uacf7_admin_params.uacf7_nonce,
              },
              success: function (data) { 
                $('.uacf7-single-step-content-inner img').hide();
                $('.uacf7-generated-template').show();
                typeName(data.value, 0); 
                
                // $this.find('.uacf7_ai_loader').remove();
                // $this.attr('disabled', false);
              }
            });
        });
  
        function typeName(data, iteration ) {
            // Prevent our code executing if there are no letters left
            if (iteration === data.length)
              return;
        
            setTimeout(function () {
              // Set the name to the current text + the next character
              // whilst incrementing the iteration variable
        
              $('#uacf7_ai_code_content').val($('#uacf7_ai_code_content').val() + data[iteration++]);
              // Re-trigger our function
              typeName(data, iteration);
              var textarea = $("#uacf7_ai_code_content");
              textarea.scrollTop(textarea[0].scrollHeight);
            }, 5);
         
          }

    });

})(jQuery);