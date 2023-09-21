;(function ($) {

    $(document).ready(function() {
        $('.toggle input').on('click', function() {
            const onOff = $(this).closest('.toggle').find('.onoff');
            onOff.text($(this).prop('checked') ? 'ON' : 'OFF');
        });
    });





    /** Updating "Is willing to send messages to Telegram Switcher Checkbox" */

    $('#uacf7_telegram_message_sending_enable').on('click', function() {
  
        var updated_value = $('#uacf7_telegram_message_sending_enable').val();

    
        $.ajax({
            type: 'POST',
            url: uacf7_telegram_ajax.ajax_url,
            data: {
                action: 'update_post_meta',
                post_id: uacf7_telegram_ajax.form_id,
                new_value: updated_value,
            },
            success: function(response) {
               
            }
        });

    });
   
  })(jQuery);
  
  