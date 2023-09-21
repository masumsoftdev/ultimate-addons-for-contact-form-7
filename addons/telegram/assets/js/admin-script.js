;(function ($) {

    $(document).ready(function() {
        $('.toggle input').on('click', function() {
            const onOff = $(this).closest('.toggle').find('.onoff');
            onOff.text($(this).prop('checked') ? 'ON' : 'OFF');
        });
    });
   
  })(jQuery);
  
  