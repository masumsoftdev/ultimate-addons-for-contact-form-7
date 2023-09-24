;(function ($) {

    $(document).ready(function() {
        $('.toggle input').on('click', function() {
            const onOff = $(this).closest('.toggle').find('.onoff');
            onOff.text($(this).prop('checked') ? 'ON' : 'OFF');
        });
    });





    
    /** Updating "Is willing to send messages to Telegram Switcher Checkbox" */
    var isChecked = false;

    $('#uacf7_telegram_message_sending_enable').on('click', function() {

        var form_id = $(this).data('form-id');


        isChecked = !isChecked;
        $(this).checked = isChecked;
        value = isChecked ? 'on' : 'off';
        
        $.ajax({
            type: 'POST',
            url: uacf7_telegram_ajax.ajax_url,
            data: {
                action: 'uacf7_telegram_post_meta',
                form_id: form_id,
                new_value: value,
            },
            success: function() {

                $('#showing_success_message').text('Updated Successfully.....');
                setTimeout(function() {
                    $('#showing_success_message').text(''); 
                }, 3000);
               
            }
        });

    });
   
  })(jQuery);
  
  