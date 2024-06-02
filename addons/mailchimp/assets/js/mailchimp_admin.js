(function ($) {

    $(document).ready(function () {
        // Show the preloader
        function showPreloader() {
            $('#preloader').show();
        }

        // Hide the preloader
        function hidePreloader() {
            $('#preloader').hide();
        }

        // MailChimp automatic connection 
        const glop_mailchimp = $('#mailchimp').find('.tf-fieldset').find('input[id="uacf7_settings\\[uacf7_mailchimp_api_key\\]"]');
        glop_mailchimp.on('change', function (event) {
            const main_id = $('#mailchimp');
            const inputKey = $(this).val();  // Correctly get the value of the input field
            const status_div = main_id.find('.tf-field.tf-field-callback').find('.tf-field-notice-inner');

            // Check if the preloader exists; if not, append it
            if ($('#preloader').length === 0) {
                main_id.append('<div id="preloader" style="display:none; position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); border: 8px solid #f3f3f3; border-radius: 50%; border-top: 8px solid #3498db; width: 60px; height: 60px; animation: spin 2s linear infinite;"></div>');
            }

            // Function to show the preloader
            function showPreloader() {
                $('#preloader').show();
            }

            // Function to hide the preloader
            function hidePreloader() {
                $('#preloader').hide();
            }

            // Show preloader before making the API call
            showPreloader();

            $.ajax({
                url: mailchimp_peram.ajaxurl,
                type: 'post',
                data: {
                    action: 'uacf7_ajax_mailchimp',
                    ajax_nonce: mailchimp_peram.nonce,
                    inputKey: inputKey  // Fix the key name to match PHP handler
                },
                success: function (data) {
                    // Assuming 'data' contains the status you want to display
                    status_div.html(data.data.status);
                    hidePreloader(); // Hide preloader after the API call completes
                },
                error: function (xhr, status, error) {
                    status_div.html('AJAX error: ' + error);  // Correctly display the error message
                    hidePreloader(); // Hide preloader after the API call completes
                }
            });
        });

    });
})(jQuery);








