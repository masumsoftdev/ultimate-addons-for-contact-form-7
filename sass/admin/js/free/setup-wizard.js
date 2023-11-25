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
        $(document).on('click', '.uacf7-next', function () {  
             
            var $this = $(this);
            var current_step = $this.attr('data-current-step');
            var next_step = $this.attr('data-next-step');
           alert(next_step);
            $('.uacf7-single-step-content[data-step='+current_step+']').removeClass('active');
            $('.uacf7-single-step-content[data-step='+next_step+']').addClass('active');
            $('.uacf7-single-step-item[data-step='+next_step+']').addClass('active');

            $this.attr('data-current-step', next_step);
            $this.attr('data-next-step',  parseInt(next_step) + 1);

 
        });


  

    });

})(jQuery);