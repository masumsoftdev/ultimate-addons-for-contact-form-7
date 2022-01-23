;(function ($) {
    'use strict';

    jQuery(document).ready(function () {
        uacf7_redirect_mailsent_handler();

        function uacf7_redirect_mailsent_handler() {
            document.addEventListener('wpcf7mailsent', function (event) {
                
                var form = uacf7_redirect_object[event.detail.contactFormId];
                
                var cr_enable = uacf7_redirect_enable[event.detail.contactFormId];
                
                if(typeof uacf7_redirect_type !== 'undefined') {
                
                    var uacf7RedirectType = uacf7_redirect_type[event.detail.contactFormId];
                
                }else {
                    
                    var uacf7RedirectType = '';
                }
                
                if( cr_enable == 'yes' && uacf7RedirectType != 'yes' ) {
                    // Set redirect URL
                    if (form.uacf7_redirect_to_type == 'to_url' && form.external_url) {
                        var redirect_url = form.external_url;
    					
                    } else if(form.uacf7_redirect_to_type == 'to_page') {
                        var redirect_url = form.thankyou_page_url;
                    }
    
                    // Redirect
                    if (redirect_url) {
                        if (!form.target) {
                            location.href = redirect_url;
                        } else {
                            window.open(redirect_url);
                        }
                    }
                
                }

            }, false);
        }
	
    });

})(jQuery);
